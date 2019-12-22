<?php


namespace DG\Dissertation\Admin\Http\Controllers;


use App\Http\Controllers\Controller;
use DG\Dissertation\Admin\Models\Notification;

class NotifyController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        set_page_title('Notification');
        return view('admin::notify');
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function datatable()
    {
        try {
            $notifications = Notification::where('notifiable_id', auth()->guard()->user()->id)
                ->orderBy('created_at', 'desc')
                ->get();
            return \DataTables::make($notifications)
                ->rawColumns(['content', 'status'])
                ->addColumn('content', function ($notify) {
                    $data = json_decode($notify->data);
                    return '<div class="text-left" style="padding-left: 20px"><strong>'. $data->attendee->firstname . ' ' . $data->attendee->lastname . '</strong> just register to event <strong>' . $data->event->name . '<strong></div>';
                })
                ->addColumn('status', function ($notify) {
                    return '<div class="' . (empty($notify->read_at) ? 'text-danger' : 'text-success') . '">' . (empty($notify->read_at) ? 'unread' : 'read') . '</div>';
                })
                ->addColumn('time', function ($notify) {
                    return date('d/m/Y H:i',strtotime($notify->created_at));
                })
                ->addColumn('read_at', function ($notify) {
                    return empty($notify->read_at) ? 'N/A' : date('d/m/Y H:i',strtotime($notify->read_at));
                })
                ->addIndexColumn()
                ->toJson();
        } catch (\Exception $e) {
            return response()->json(['message' => 'Not found', 'errors' => []], 404);
        }
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function maskAsRead()
    {
//        try {
            foreach (auth()->user()->unreadNotifications as $notification) {
                $notification->markAsRead();
            }

            return response()->json([
                'message' => 'Update notification successful'
            ]);
//        } catch (\Exception $exception) {
//            return response()->json([
//                'message' => 'Oops, have an error, can update notification'
//            ], 500);
//        }

    }
}
