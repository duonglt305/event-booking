### Table Module

Create your own table class extend from TableAbstract Class

```php

use Kurneo\Table\Abstracts\TableAbstract;

class UserTable extends TableAbstract
{
   //
}
```


Override following method for table

```php
use Yajra\DataTables\DataTables;
use Kurneo\User\Models\User;

/**
 * Provide Model for qiery data. And Datatables instance
 * @param DataTables $dataTables
 * @param User $model
 */
public function __construct(DataTables $dataTables, User $model)
{
    parent::__construct($dataTables, $model);
}
```


Define column for show
```php
public function columns(): array
    {
        return [
            'id' => [
                'name' => 'users.id', //feild in model
                'title' => 'ID', //Content for table heaer if no declade this will be name
                'class' => 'text-center' //addition class for table header,
                'width' => '100px', //define column with
                'orderable' => false, //order
                'searchable' => false, //search
                'exportable' => false, //export
                'printable' => false, //print
            ],
            'username' => [
                'name' => 'users.username',
                'class' => 'text-center'
            ],
            // and so on...
        ];
    }
```

Custom for specify column
```php
public function ajax()
    {
        return $this->table
            ->eloquent($this->query())
            ->editColumn('created_at', function ($user) {
                return $user->created_at->format('d/m/Y');
            })
            ->editColumn('dob', function ($model) {
                return date('d/m/Y', strtotime($model->dob));
            })
            ->editColumn('address', function (User $model) {
                return $model->address;
            })
            ->editColumn('phone', function (User $model) {
                return $model->phone;
            })
            ->editColumn('gender', function ($model) {
                return $model->gender === 1 ? 'Nam' : 'Nữ';
            })
            ->addColumn('about', function ($model) {
                return $model->about;
            })
            ->editColumn('updated_at', function ($user) {
                return $user->updated_at->format('d/m/Y');
            })
            ->editColumn('actions', function () {
                return view('action-single')->render();
            })
            ->editColumn('full_name', function (User $model) {
                return $model->first_name . ' ' . $model->last_name;
            })
            ->editColumn('checkbox', function ($user) {
                return '<div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="' . $this->checkBoxName() . '-' . $user->id . '" name="' . $this->checkBoxName() . '" value="' . $user->id . '">
                            <label class="custom-control-label" for="' . $this->checkBoxName() . '-' . $user->id . '"></label>
                        </div>';
            })
            ->rawColumns(['checkbox', 'actions'])
            ->make(true);
    }
```

Query for get data
```php
    public function query()
    {
        return $this->model->newQuery()
            ->select([
                'id',
                'email',
                'about',
                'dob',
                'address',
                'phone',
                'gender',
                'about',
                'first_name',
                'last_name',
                'username',
                'created_at',
                'updated_at'
            ]);
    }

```

Define addition action

```php

public function additionActions(): array
    {
        return [
            'excel',
            'pdf',
            'print',
            'colvis',
            'reload',
            [ //custom action
                'tag' => 'a',
                'attribute' => [
                    'class' => 'btn btn-info',
                    'href' => 'https://google.com'
                ]
            ],
            [ //link to create page
                'action' => 'create',
                'url' => route('users.create')
            ],
        ];
    }
```

Define name attribute for checkobx input, if no use multi action pls return empty string
```php
    public function checkBoxName(): string
    {
        return 'checkbox-multi-action';
    }
```

Defile multi action query, if no use multi action pls return empty string
```php
    public function actionMultiQuerySelect(): string
    {
        return '$("#user-table-multi-action").find("a")';
    }
```
Define multi action template has string HTML
```php
    public function multiActionsTemplate(): string
    {
        return view('core.user::table.action-multi')->render();
    }
```

If you has model for multi action, define its here as string Html
```php
    public function multiActionsModelTemplate(): string
    {
        return view('core.user::table.model')->render();
    }
```
