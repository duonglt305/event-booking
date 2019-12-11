<?php


namespace DG\Dissertation\Admin\Tables;


use DG\Dissertation\Admin\Models\Speaker;
use DG\Dissertation\Table\Abstracts\TableAbstract;
use Yajra\DataTables\DataTables;

class SpeakerTable extends TableAbstract
{
    /**
     * @var Event
     */
    private $event;

    public function __construct(DataTables $dataTables, Speaker $model)
    {
        parent::__construct($dataTables, $model);
    }

    /**
     * @param Event $event
     */
    public function setEvent($event)
    {
        $this->event = $event;
    }

    /**
     * @return array
     */
    public function columns(): array
    {
        return [
            'name' => [],
            'photo' => [
                'name' => 'speakers.photo',
                'class' => 'text-center'
            ],
            'company' => [
                'name' => 'speakers.company',
                'class' => 'text-center'
            ],
            'position' => [
                'name' => 'speaker.position',
                'class' => 'text-center'
            ],
            'description' => [
                'name' => 'speaker.description'
            ],
            'created_at' => [
                'class' => 'text-center',
                'title' => 'Created At'
            ],
            'action' => [
                'class' => 'text-center',
            ]
        ];
    }

    public function ajax()
    {
        return $this->getTable()
            ->eloquent($this->query())
            ->addIndexColumn()
            ->editColumn('name', function (Speaker $model) {
                return $model->firstname . ' ' . $model->lastname;
            })
            ->editColumn('photo', function (Speaker $model) {
                return '<img src="' . asset($model->photo) . '" style="width:100px;height:100px">';
            })
            ->editColumn('company', function (Speaker $model) {
                return $model->company;
            })
            ->editColumn('position', function (Speaker $model) {
                return $model->position;
            })
            ->editColumn('description', function (Speaker $model) {
                return empty($model->description) ? 'N/A' : $model->description;
            })
            ->editColumn('created_at', function (Speaker $model) {
                return $model->created_at->format('d/m/Y');
            })
            ->editColumn('action', function (Speaker $model) {
                return view('admin::events.speakers.tables.action-single')
                    ->with(['event' => $this->event, 'model' => $model])->render();
            })
            ->editColumn('checkbox', function ($user) {
                return '<div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="' . $this->checkBoxName() . '-' . $user->id . '" name="' . $this->checkBoxName() . '" value="' . $user->id . '">
                            <label class="custom-control-label" for="' . $this->checkBoxName() . '-' . $user->id . '"></label>
                        </div>';
            })
            ->rawColumns(['checkbox', 'action', 'photo'])
            ->make(true);
    }

    /**
     * @return array
     */
    public function additionActions(): array
    {
        return [
            'reload',
            [
                'tag' => 'button',
                'attribute' => [
                    'class' => 'btn btn-primary btn-sm',
                    'data-toggle' => 'modal',
                    'data-target' => '#model_create_speaker'
                ],
                'content' => '<i class="fa fa-plus"></i> Create'
            ]
        ];
    }

    /**
     * @return string
     * @throws \Throwable
     */
    public function multiActionsTemplate(): string
    {
        return view('admin::events.speakers.tables.action-multi')->with(['event' => $this->event->id])->render();
    }

    /**
     * @return string
     */
    public function checkBoxName(): string
    {
        return 'checkbox-multi-action';
    }

    /**
     * @return string
     */
    function actionMultiQuerySelect(): string
    {
        return '$("#speakers-table-multi-action").find("a")';
    }


    function query()
    {
        return $this->getModel()
            ->newQuery()
            ->where('event_id', '=', $this->event->id)
            ->select([
                'id',
                'firstname',
                'lastname',
                'photo',
                'company',
                'position',
                'description',
                'event_id',
                'created_at',
                'updated_at'
            ]);
    }


    /**
     * @return string
     * @throws \Throwable
     */
    function modelTemplate(): string
    {
        return view('admin::events.speakers.tables.modal')->with(['event' => $this->event->id])->render();
    }

    protected function event()
    {
        return '<div class="pb-4">
                    <h3 class="title mb-lg-0 mb-2">' . $this->event->name . '</h3>
                    <p class="text-muted">' . $this->event->date_formatted . '</p>
                </div>';
    }

    public function cardTitle()
    {
        return 'Speaker manage';
    }

    public function renderTable($data = [], $mergeData = [])
    {
        \Assets::addScriptsDirectly(['/js/speakers.js']);
        $data['event'] = $this->event();
        $data['cardTitle'] = $this->cardTitle();
        return parent::renderTable($data, $mergeData);
    }
}
