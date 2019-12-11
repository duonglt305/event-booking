<?php
/**
 * Table.php
 *
 * Table
 *
 * @package    Kurneo\Table
 * @author     Giang Nguyen
 * @author     <mrcatbro97@gmail.com>
 * @date       14/09/2019
 */

namespace DG\Dissertation\Table\Abstracts;

use Assets;
use Html;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\Services\DataTable;

abstract class TableAbstract extends Datatable
{
    /**
     * @var DataTables
     */
    protected $table;

    /**
     * @var Model
     */
    protected $model;

    /**
     * @var string
     */
    protected $view = 'table::table';

    /**
     * @var boolean
     */
    protected $hasCheckbox = true;

    /**
     * @var array
     */
    protected $defaultActions;

    /**
     * Table constructor.
     * @param DataTables $dataTables
     * @param Model $model
     */
    public function __construct(DataTables $dataTables, Model $model)
    {
        $this->table = $dataTables;
        $this->model = $model;
        $this->defaultActions = [
            'excel' => [
                'extend' => 'excel',
                'text' => '<i class="fa fa-file-excel mr-1"></i> ' . trans('table::tables.buttons.excel')
            ],
            'pdf' => [
                'extend' => 'pdf',
                'text' => '<i class="fa fa-file-pdf mr-1"></i> ' . trans('table::tables.buttons.pdf')
            ],
            'print' => [
                'extend' => 'print',
                'text' => '<i class="fa fa-print"></i> ' . trans('table::tables.buttons.print')
            ],
            'colvis' => [
                'extend' => 'colvis',
                'text' => '<i class="fa fa-eye"></i> ' . trans('table::tables.buttons.colvis'),
                'columns' => ':gt(0)'
            ],
            'reload' => [
                'text' => '<i class="fa fa-sync"></i> ' . trans('table::tables.buttons.reload'),
                'action' => 'function (a,o,r,d){$("#dataTableBuilder").block({overlayCSS:{backgroundColor:"#ffffff9c",opacity:.8,zIndex:9999999,cursor:"wait"},css:{border:0,color:"#fff",padding:0,zIndex:9999999,backgroundColor:"transparent"},message:null}),o.ajax.reload()}'
            ],
        ];
    }

    /**
     * @param bool $value
     */
    public function setHasCheckbox(bool $value)
    {
        $this->hasCheckbox = $value;
    }

    /**
     * @return bool
     */
    public function getHasCheckbox()
    {
        return $this->hasCheckbox;
    }

    /**
     * @param DataTables $tables
     */
    public function setTable(DataTables $tables)
    {
        $this->table = $tables;
    }

    /**
     * @return DataTables
     */
    public function getTable(): DataTables
    {
        return $this->table;
    }

    /**
     * @param string $view
     */
    public function setView(string $view)
    {
        $this->view = $view;
    }

    /**
     * @return string
     */
    public function getView(): string
    {
        return $this->view;
    }

    /**
     * @param $model
     */
    public function setModel($model)
    {
        $this->model = $model;
    }

    /**
     * @return Model
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * @return Builder
     * @throws \Throwable
     */
    public function html()
    {
        return $this->builder()
            ->columns($this->getColumns())
            ->parameters([
                'dom' => $this->getTableDOM(),
                'drawCallback' => $this->htmlDrawCallback(),
                'initComplete' => $this->htmlInitComplete(),
                'preDrawCallback' => $this->htmlPreDrawCallback(),
                'buttons' => $this->getActions(),
                "pageLength" => 10,
                'language' => [
                    'info' => view('table::table-info')->render(),
                    'search' => trans('table::tables.search'),
                    'lengthMenu' => Html::tag('span', '_MENU_', ['class' => 'dt-length-style'])->toHtml(),
                ]
            ]);
    }

    /**
     * @return array
     */
    public function getColumns(): array
    {
        $columns = $this->columns();

        foreach ($columns as $key => &$column) {
            $column['class'] = (isset($column['class']) ? Arr::get($column, 'class') : '') . ' column-key-' . $key;
        }

        if ($this->hasCheckbox) {
            $columns = array_merge($this->getCheckboxColumnHeader(), $columns);
        }

        return $columns;
    }

    /**
     * @return array
     */
    abstract public function columns(): array;

    /**
     * @return array
     */
    abstract public function additionActions(): array;

    /**
     * @return string
     */
    abstract public function multiActionsTemplate(): string;

    /**
     * @return string
     */
    abstract public function checkBoxName(): string;

    /**
     * @return string
     */
    abstract function actionMultiQuerySelect(): string;

    /**
     * @return Model
     */
    abstract function query();

    /**
     * @return string
     */
    abstract function modelTemplate(): string;

    /**
     * @return array
     */
    public function getActions(): array
    {
        $buttons = [];
        $actions = $this->additionActions();
        $defaultActions = collect($this->defaultActions);
        if (count($actions) > 0) {
            foreach ($actions as $action) {
                if (isset($action['action']) && $action['action'] === 'create') {
                    $this->generateCreateButton($buttons, $action);
                } else if (is_string($action)) {
                    $buttons[] = $defaultActions->has($action) ? $defaultActions->get($action) : $action;
                } else {
                    $this->generateCustomButton($buttons, $action);
                }
            }
        }
        return $buttons;
    }

    /**
     * @param array $buttons
     * @param array $action
     */
    private function generateCreateButton(array &$buttons, array $action)
    {
        $text = Html::tag(
            'a',
            Html::tag('i', '', [
                'class' => isset($action['icon']) ? $action['icon'] . ' mr-1' : 'fa fa-plus mr-1'
            ])->toHtml() . trans('table::tables.buttons.create'),
            [
                'href' => $action['url'],
                'class' => isset($action['class']) ? $action['class'] . ' button-action  mr-1' : 'btn btn-primary btn-sm button-action  mr-1'
            ]
        )->toHtml();
        $buttons[] = [
            'text' => $text
        ];
    }

    /**
     * @param array $buttons
     * @param array $action
     */
    private function generateCustomButton(array &$buttons, array $action)
    {
        $attribute = isset($action['attribute']) ? $action['attribute'] : [];
        $attribute['class'] = isset($attribute['class']) ?
            $attribute['class'] . ' button-action btn-sm mr-1' :
            'button-action btn btn-primary btn-sm mr-1';
        $content = isset($action['content']) ? $action['content'] :
            Html::tag('i', '', [
                'class' => ' fas fa-heartbeat mr-1'
            ])->toHtml() . ' Action';
        $tag = isset($action['tag']) ? $action['tag'] : 'div';
        $text = Html::tag(
            $tag,
            $content,
            $attribute
        )->toHtml();
        $buttons[] = [
            'text' => $text
        ];
    }

    /**
     * @return string
     */
    protected function getTableDOM(): string
    {
        return "<'row'<'col-md-4 d-flex justify-content-start'f><'col-md-8 d-flex justify-content-end'B>><'table-responsive't><'datatables__info_wrap'<'row'<'col-md-6'<'row'<'col-md-2 mr-1'l><i>>><'col-md-6'p>>>";
    }

    /**
     * @return array
     */
    private function getCheckboxColumnHeader(): array
    {
        return [
            'checkbox' => [
                'title' => '<div class="custom-control custom-checkbox"><input type="checkbox" class="custom-control-input table-check-all" id="table-check-all" value="check"><label class="custom-control-label" for="table-check-all"></label></div>',
                'class' => 'text-center no-sort',
                'width' => '10px',
                'orderable' => false,
                'searchable' => false,
                'exportable' => false,
                'printable' => false,
            ]
        ];
    }

    /**
     * @return string
     */
    public function htmlInitComplete(): ?string
    {
        $checkBoxName = $this->checkBoxName();
        $actionMultiQuerySelect = empty($this->actionMultiQuerySelect()) ?
            '$(".' . Str::random(6) . '")' :
            $this->actionMultiQuerySelect();
        return 'function (e){$(e.nTHead).find("th").addClass("no-break");let t=$("#dataTableBuilder_wrapper").find(".button-action"),n=$("div[class=dt-buttons]");t.parents("button").remove(),n.append(t);let A=$("input[id=table-check-all]");' . $actionMultiQuerySelect . '.click(e=>{e.preventDefault();let t=$("input[name=' . $checkBoxName . ']:checked");if((!A.prop("checked")||A.prop("checked"))&&0===t.length)return $.toast({heading:"Notification",text:"Please select at least one record to perform this action!",showHideTransition:"slide",icon:"error",loaderBg:"#f2a654",position:"top-right"}),!1}),A.change(e=>{e.preventDefault(),$("input[name=' . $checkBoxName . ']").prop("checked",$(e.target).prop("checked"))})}';
    }

    /**
     * @return string|null
     */
    public function htmlDrawCallback(): ?string
    {
        return 'function (){$(".table-check-all").parents("th").removeClass("sorting_asc"),$(".table-check-all").prop("checked",!1),0<$("#table-check-all").length&&$("#table-check-all").parents("th").attr("title","Select all"),$("#dataTableBuilder").unblock()}';
    }

    /**
     * @return string
     */
    public function htmlPreDrawCallback(): string
    {
        return 'function (){$("#dataTableBuilder").block({overlayCSS:{backgroundColor:"#ffffff9c",opacity:.8,zIndex:49,cursor:"wait"},css:{border:0,color:"#fff",padding:0,zIndex:49,backgroundColor:"transparent"},message:null})}';
    }

    /**
     * @param array $data
     * @param array $mergeData
     * @return mixed
     */
    public function renderTable($data = [], $mergeData = [])
    {
        Assets::addStyles([
            'datatables-css',
            'buttons-dataTables-css',
            'tables-css'
        ]);
        Assets::addScripts([
            'datatables-js',
            'dataTables-buttons-js',
            'buttons-flash-js',
            'buttons-print-js',
            'buttons-html5-js',
            'buttons-colVis-js',
            'jszip-min-js',
            'pdfmake-min-js',
            'vfs_fonts-js',
        ]);
        $data['hasCheckbox'] = $this->hasCheckbox;
        $data['additionActions'] = $this->additionActions();
        $data['multiTemplate'] = $this->multiActionsTemplate();
        $data['model'] = $this->modelTemplate();
        return $this->render($this->view, $data, $mergeData);
    }
}
