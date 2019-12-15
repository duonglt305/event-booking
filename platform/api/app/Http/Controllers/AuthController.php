<?php


namespace DG\Dissertation\Api\Http\Controllers;


use App\Http\Controllers\Controller;
use Carbon\Carbon;
use DG\Dissertation\Api\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('api.jwt.auth')->except(['login', 'refresh']);
        $this->middleware('jwt.refresh')->only(['refresh']);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        try {
            $this->validate($request, [
                $this->username() => 'required|string',
                'password' => 'required|string'
            ]);
        } catch (ValidationException $e) {
            return response()->json(['message' => $e->getMessage(), 'errors' => $e->validator->errors()], 422);
        }
        $credentials = $this->credentials($request);
        if (!$token = $this->guard()->attempt($credentials))
            return response()->json([
                'status' => 'unauthorized',
                'message' => 'These credentials do not match our records.'
            ], 401);

        /* Check attendee verify email */
        if (!$this->attendee()->hasVerifiedEmail()) {
            event(new Registered($this->attendee()));
            return response()->json([
                'status' => 'not_verify',
                'message' => "Your account not yet verify, we're send your verify code to your email {$this->attendee()->email}, please check your email."
            ], 401);
        }
        return $this->respondWithToken($token);
    }

    /**
     * @return string
     */
    public function username()
    {
        return 'username';
    }

    /**
     * @param Request $request
     * @return array
     */
    protected function credentials(Request $request)
    {
        return $request->only([$this->username(), 'password']);
    }

    /**
     * @return \Illuminate\Contracts\Auth\Guard|\Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return \Auth::guard('api');
    }

    /**
     * @return \DG\Dissertation\Api\Models\Attendee | mixed
     */
    public function attendee()
    {
        return $this->guard()->user();
    }

    /**
     * @param $token
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expire_in' => $this->guard()->factory()->getTTL() * 60,
            'user' => $this->attendee(),
        ]);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        $this->guard()->logout();
        return response()->json(['message' => 'Logout successfully.']);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken($this->guard()->refresh());
    }

    public function changePassword(Request $request)
    {
        try {
            $this->validate($request, [
                'current_password' => ['required', 'string'],
                'new_password' => ['required', 'string', 'confirmed'],
                'new_password_confirmation' => ['required', 'string']
            ]);
        } catch (ValidationException $e) {
            return response()->json(['message' => $e->getMessage(), 'errors' => $e->errors()], 422);
        }
        if (!$this->validateCurrentPassword($request))
            return response()->json(['message' => 'Your current password does not match.'], 422);
        if (!$this->validateNewPassword($request))
            return response()->json(['message' => 'New password shouldn\'t be same as current password.'], 422);
        try {
            $this->attendee()->update([
                'password' => bcrypt($request->get('new_password')),
            ]);
            $this->guard()->logout();;
            return response()->json(['message' => 'Your password has been changed, please login again.']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Data cannot be processed'], 422);
        }


    }

    protected function validateCurrentPassword(Request $request)
    {
        return \Hash::check($request->get('current_password'), $this->attendee()->password);
    }

    protected function validateNewPassword(Request $request)
    {
        return !\Hash::check($request->get('new_password'), $this->attendee()->password);
    }


    public function changePhoto(Request $request)
    {
        try {
            $this->validate($request, [
                'photo' => ['required', 'base64image']
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'errors' => $e->errors(),
            ]);
        }
        if ($request->has('photo')) {

            $this->attendee()->update([
                'photo' => $request->get('photo')
            ]);
            return response()->json([
                'message' => 'Change photo successfully.',
                'photo' => $this->attendee()->photo
            ]);
        }
        return response()->json(['message' => 'Please select your photo.'], 404);
    }

}
