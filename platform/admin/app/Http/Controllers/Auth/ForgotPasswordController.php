<?php


namespace DG\Dissertation\Admin\Http\Controllers\Auth;


use App\Http\Controllers\Controller;
use Carbon\Carbon;
use DG\Dissertation\Admin\Models\PasswordReset;
use DG\Dissertation\Admin\Notifications\ResetPasswordNotification;
use DG\Dissertation\Admin\Repositories\PasswordResetRepository;
use DG\Dissertation\Admin\Repositories\OrganizerRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    /**
     * @var PasswordResetRepository
     */
    protected $passwordResetRepository;

    /**
     * @var OrganizerRepository
     */
    protected $organizerRepository;

    /**
     * ForgotPasswordController constructor.
     * @param PasswordResetRepository $passwordResetRepository
     * @param OrganizerRepository $organizerRepository
     */
    public function __construct(PasswordResetRepository $passwordResetRepository, OrganizerRepository $organizerRepository)
    {
        $this->passwordResetRepository = $passwordResetRepository;
        $this->organizerRepository = $organizerRepository;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showForgotForm()
    {
        return view('admin::auth.forgot-password');
    }

    /**
     * @param Request $request
     */
    protected function validateForgot(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
        ], [
            'required' => trans('admin::validation.required'),
            'string' => trans('admin::validation.string'),
            'email' => trans('admin::validation.email'),
        ], [
            'email' => 'email',
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendMail(Request $request)
    {
        $this->validateForgot($request);

        $organizer = $this->organizerRepository->firstBy(['WHERE' => [['email', '=', $request->email]]]);

        if (empty($organizer)){
            session()->flash('message', 'We have e-mailed your password reset link!');

            return redirect()->back();
        }

        $passwordReset = $this->passwordResetRepository->firstBy([
            'WHERE' => [
                ['email', '=', $organizer->email]
            ]
        ]);

        if (empty($passwordReset)){
            $passwordReset = $this->passwordResetRepository->insert([
                'email' => $organizer->email,
                'token' => Str::random(60)
            ]);
        }
        else {
            $passwordReset->token = Str::random(60);
            $passwordReset->created_at = date('Y-m-d H:i:s');
            $passwordReset->save();
        }

        $organizer->notify(new ResetPasswordNotification($passwordReset->token));

        session()->flash('message', 'We have e-mailed your password reset link!');

        return redirect()->back();

    }

    /**
     * @param Request $request
     * @param $token
     * @return \Illuminate\Http\JsonResponse
     */
    public function resetPassShow(Request $request, $token)
    {
        $success = session()->get('success',false);

        $passwordReset = $this->passwordResetRepository->firstBy([
            'WHERE' => [
                ['token', '=', $token]
            ]
        ]);

        $isPass = $passwordReset ? Carbon::parse($passwordReset->created_at)->addMinutes(720)->isPast() : true;

        return view('admin::auth.reset-password', compact('isPass', 'token', 'passwordReset','success'));
    }

    /**
     * @param Request $request
     */
    public function resetPass(Request $request)
    {
        $this->validateReset($request);

        $data = $request->all();

        $passwordReset = $this->passwordResetRepository->firstBy([
            'WHERE' => [
                ['token', '=', $data['token']]
            ]
        ]);

        if ($passwordReset) {
            $organizer = $this->organizerRepository->firstBy([
                'WHERE' => [
                    ['email', '=', $passwordReset->email]
                ]
            ]);
            $organizer->password = bcrypt($data['password']);
            $organizer->save();
            PasswordReset::where('token', $data['token'])->delete();
        }
        session()->flash('success', true);
        return redirect()->back();
    }

    protected function validateReset(Request $request)
    {
        $request->validate([
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'password_confirmation' => ['required', 'string', 'min:8'],
            'token' => ['required', 'string']
        ], [
            'required' => trans('admin::validation.required'),
            'string' => trans('admin::validation.string'),
            'min' => trans('admin::validation.min'),
            'confirmed' => trans('admin::validation.confirmed'),
        ], [
            'password' => 'password',
            'password_confirmation' => 'password confirmation',
            'token' => 'token'
        ]);
    }
}
