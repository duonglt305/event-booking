<?php

namespace DG\Dissertation\Admin\Tables;

use Botble\Assets\Assets;
use DG\Dissertation\Admin\Models\Event;
use DG\Dissertation\Admin\Models\SessionType;
use DG\Dissertation\Table\Abstracts\TableAbstract;
use Yajra\DataTables\DataTables;

class SessionTypeTable extends TableAbstract
{
    /**
     * @var Event
     */
    protected $event;

    public function __construct(DataTables $dataTables, SessionType $model)
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
            'id' => [
                'name' => 'session_types.id',
                'title' => 'ID'
            ],
            'name' => [
                'name' => 'session_types.name',
                'title' => 'Name',
                'class' => 'text-center',
            ],
            'cost' => [
                'name' => 'session_types.cost',
                'title' => 'Cost',
                'class' => 'text-center'
            ],
            'action' => [
                'class' => 'text-center'
            ]
        ];
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
                    'data-target' => '#model_create_session_type'
                ],
                'content' => '<i class="fa fa-plus"></i> Create'
            ]
        ];
    }

    /**
     * @return string
     */
    public function multiActionsTemplate(): string
    {
        return view('admin::events.session-types.tables.action-multi')
            ->with(['event' => $this->event->id])
            ->render();
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
        return '$("#menu_bulk_actions").find("a")';
    }


    function query()
    {
        return $this->getModel()->newQuery()
            ->where('event_id', '=', $this->event->id)
            ->select([
                'id',
                'name',
                'cost',
                'created_at',
                'updated_at'
            ]);
    }

    public function modelTemplate(): string
    {
        return view('admin::events.session-types.tables.modal')->with(['event' => $this->event->id])->render();
    }

    public function ajax()
    {
        return $this->getTable()
            ->eloquent($this->query())
            ->addIndexColumn()
            ->editColumn('name', function (SessionType $model) {
                return $model->name;
            })
            ->editColumn('cost', function (SessionType $model) {
                return empty($model->cost) ? 'Free' : $model->cost;
            })
            ->editColumn('action', function (SessionType $model) {
                return view('admin::events.session-types.tables.action-single')
                    ->with([
                        'model' => $model,
                        'event' => $this->event->id
                    ])
                    ->render();
            })
            ->editColumn('checkbox', function ($user) {
                return '<div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="' . $this->checkBoxName() . '-' . $user->id . '" name="' . $this->checkBoxName() . '" value="' . $user->id . '">
                            <label class="custom-control-label" for="' . $this->checkBoxName() . '-' . $user->id . '"></label>
                        </div>';
            })
            ->rawColumns(['checkbox', 'action','cost'])
            ->make(true);
    }

    /**
     * @return string
     */
    protected function event()
    {
        return '<div class="pb-4">
                    <h3 class="title mb-lg-0 mb-2">' . $this->event->name . '</h3>
                    <p class="text-muted">' . $this->event->date_formatted . '</p>
                </div>';
    }

    /**
     * @return string
     */
    protected function cardTitle()
    {
        return 'Session type manage';
    }

    public function renderTable($data = [], $mergeData = [])
    {
        \Assets::addScriptsDirectly([
            '/js/session-types.js',
        ]);
        $data['event'] = $this->event();
        $data['cardTitle'] = $this->cardTitle();
        return parent::renderTable($data, $mergeData);
    }
}
