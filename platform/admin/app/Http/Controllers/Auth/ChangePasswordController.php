<?php


namespace DG\Dissertation\Admin\Http\Controllers\Auth;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ChangePasswordController extends Controller
{
    /**
     * ChangePasswordController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showChangePassword()
    {
        set_page_title('Change password');
        return view('admin::change-password');
    }

    /**
     * @param Request $request
     * @return mixed
     * @throws ValidationException
     */
    public function changePassword(Request $request)
    {
        $this->validate($request, $this->rules(), $this->validationErrorMessage(), $this->customAttributes());
        $user = \Auth::user();
        if (!$this->checkPasswordOld($user, $request->get('password_old')))
            throw ValidationException::withMessages(['password_old' => ['Current password is wrong.']]);
        return $this->processChangePassword($user, $request->get('password_new'))
            ? $this->sendChangeResponse()
            : $this->sendChangeFailedResponse();
    }

    /**
     * @return mixed
     */
    protected function sendChangeResponse()
    {
        return redirect()->back()->withSuccess([
            'message' => 'Change password successful, Please logout and login again'
        ]);
    }

    /**
     * @return mixed
     */
    protected function sendChangeFailedResponse()
    {
        return redirect()->back()->withFailed([
            'message' => 'opp, have an error, please try again later'
        ]);
    }

    /**
     * @param $user
     * @param $password
     * @return mixed
     */
    protected function processChangePassword($user, $password)
    {
        $user->password = \Hash::make($password);
        return $user->save();
    }

    /**
     * @param $user
     * @param $password
     * @return bool
     */
    protected function checkPasswordOld($user, $password)
    {
        return \Hash::check($password, $user->getAuthPassword());
    }

    /**
     * @return array
     */
    protected function validationErrorMessage()
    {
        return [
            'required' => trans('admin::validation.required'),
            'string' => trans('admin::validation.string'),
            'confirmed' => trans('admin::validation.confirmed'),
            'different' => trans('admin::validation.different'),
            'min' => trans('admin::validation.min'),
        ];
    }

    /**
     * @return array
     */
    protected function rules()
    {
        return [
            'password_old' => 'required|string',
            'password_new' => 'required|string|confirmed|different:password_old|min:8',
            'password_new_confirmation' => 'required|string|min:8'
        ];
    }

    /**
     * @return array
     */
    protected function customAttributes()
    {
        return [
            'password_old' => 'current password',
            'password_new' => 'new password',
            'password_new_confirmation' => 'confirm password',
        ];
    }
}
