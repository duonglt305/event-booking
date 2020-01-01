<?php


namespace DG\Dissertation\Admin\Http\Controllers;


use App\Http\Controllers\Controller;
use DG\Dissertation\Admin\Models\Contact;
use DG\Dissertation\Admin\Repositories\ContactRepository;

class ContactController extends Controller
{
    /**
     * @var ContactRepository
     */
    private $contactRepository;

    /**
     * ContactController constructor.
     * @param ContactRepository $contactRepository
     */
    public function __construct(ContactRepository $contactRepository)
    {
        $this->contactRepository = $contactRepository;
    }

    public function index()
    {
        return view('admin::contact');
    }

    public function datatable()
    {
        try {
            $contacts = Contact::with(['event' => function ($query) {
                return $query->where('events.organizer_id', auth()->guard()->user()->id)
                    ->orderBy('created_at', 'desc');
            }])->get();
            return \DataTables::make($contacts)
                ->rawColumns(['message', 'status', 'sender', 'action'])
                ->addColumn('sender', function ($contact) {
                    return '<div class="row ml-2">
                                <div class="col-12 text-left" style="padding-left: 20px"> <i class="fa fa-user-circle"></i>: ' . $contact->name . '</div>
                                <div class="col-12 text-left" style="padding-left: 20px"> <i class="icon-mail"></i>: ' . $contact->email . '</div>
                            </div>';
                })
                ->addColumn('message', function ($contact) {
                    return '<div class="text-left" style="padding-left: 20px">' . $contact->message . '</div>';
                })
                ->addColumn('status', function ($contact) {
                    return '<div class="' . (empty($contact->status) ? 'text-danger' : 'text-success') . '">' . (empty($contact->status) ? 'unread' : 'read') . '</div>';
                })
                ->addColumn('time', function ($contact) {
                    return date('d/m/Y H:i', strtotime($contact->created_at));
                })
                ->addColumn('action', function ($contact) {
                    return empty($contact->status) ? '<div>
                                <a href="' . route('organizer.mask_as_read_contact') . '" data-id="' . $contact->id . '" class="text-small mask-as-read">Mask as read</a>
                            </div>' : '';
                })
                ->addIndexColumn()
                ->toJson();
        } catch (\Exception $e) {
            return response()->json(['message' => 'Not found', 'errors' => []], 404);
        }
    }

    public function maskAsRead()
    {
        try {
            $id = request()->post('id');
            if (empty($id)) {
                return response()->json([
                    'message' => 'id is require'
                ], 422);
            }

            $contact = $this->contactRepository->findById($id);

            if (!empty($contact)) {
                $contact->status = 1;
                $contact->save();
                return response()->json([
                    'message' => 'Update contact successful'
                ]);
            } else {
                return response()->json([
                    'message' => 'Update contact failed'
                ], 500);
            }
        } catch (\Exception $exception) {
            return response()->json([
                'message' => 'Update contact failed'
            ], 500);
        }
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function maskAsReadAll()
    {
        try {
            $contacts = $this->contactRepository->allBy([
                'WHERE' => [
                    ['status', '=', 0]
                ]
            ]);

            foreach ($contacts as $contact) {
                $contact->status = 1;
                $contact->save();
            }
            return response()->json([
                'message' => 'Update contact successful'
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'message' => 'Update contact failed'
            ], 500);
        }
    }
}
