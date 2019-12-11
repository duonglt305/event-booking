<?php


namespace DG\Dissertation\Api\Http\Controllers;


use App\Http\Controllers\Controller;
use Carbon\Carbon;
use DG\Dissertation\Api\Events\Registered;
use DG\Dissertation\Api\Events\Verified;
use DG\Dissertation\Api\Models\Attendee;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        try {
            $this->validate($request, [
                'firstname' => ['required', 'string'],
                'lastname' => ['required', 'string'],
                'username' => ['required', 'string', 'unique:attendees,username', 'regex:/^([a-z0-9])+(?:[a-z0-9+]*)$/', 'min:8'],
                'email' => ['required', 'string', 'email', 'unique:attendees,email'],
                'password' => ['required', 'string', 'confirmed', 'min:8'],
            ]);
        } catch (ValidationException $e) {
            return response()->json(['message' => $e->getMessage(), 'errors' => $e->errors()], 422);
        }
        $all = $request->only(['firstname', 'lastname', 'username', 'email', 'password']);
        $all['password'] = bcrypt($all['password']);
        try {
            $attendee = Attendee::create($all);
            event(new Registered($attendee));
            return response()->json(['message' => "Register successfully, we're send your verify code to your email {$attendee->email}, please check your email."], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Data cannot be processed.', 'errors' => []], 422);
        }
    }


    public function verify(Request $request)
    {
        $attendee = Attendee::where('username', $request->get('username'))
            ->whereNotNull('verify_code')
            ->first();

        /* Check attendee exists with email */
        if (!$attendee instanceof Attendee)
            return response()->json(['status' => 'account_not_found', 'message' => 'Can not find your account.'], 404);

        if (!$attendee->assertVerificationCode($request->get('verify_code')))
            return response()->json(['status' => 'not_correct_verify_code', 'message' => "Verify code is not correct."], 422);

        /* Check verify code is expired */
        if (!$attendee->validateVerificationCode($request->get('verify_code'))) {
            event(new Registered($attendee));
            return response()->json(['status' => 'expired_verify_code', 'message' => "Your verify code is expired, we're send your verify code to your email {$attendee->email}, please check your email."], 422);
        }
        /* Verify attendee account */
        event(new Verified($attendee));
        /* Login attendee account */
        $token = $this->guard()->login($attendee);
        $payload = $this->guard()->payload();
        return response()->json([
            'message' => 'Verify your account successfully.',
            'access_token' => $token,
            'token_type' => 'bearer',
            'expire_in' => $this->guard()->factory()->getTTL() * 60,
            'user' => $this->guard()->user(),
            'expire_at' => Carbon::createFromTimestamp($payload['exp'])->toDateTimeString()
        ]);
    }

    protected function guard()
    {
        return \Auth::guard('api');
    }
}
