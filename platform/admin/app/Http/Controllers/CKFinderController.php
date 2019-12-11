<?php


namespace DG\Dissertation\Admin\Http\Controllers;


use App\Http\Controllers\Controller;
use DG\Dissertation\Core\Supports\Helper;

class CKFinderController extends Controller
{
    public function index()
    {
        @session_start();
        $_SESSION['finderPermit'] = auth()->check();
        $_SESSION['finderPath'] = DIRECTORY_SEPARATOR . 'storage' . DIRECTORY_SEPARATOR . auth()->user()->slug . DIRECTORY_SEPARATOR . 'articles' . DIRECTORY_SEPARATOR;
        return view('admin::ckfinder.index');
    }

    public function connector()
    {
        Helper::autoload(__DIR__ . '/../../../../../public/admin/vendors/ckfinder/core/connector/php/connector.php');
    }
}
