<?php

namespace App\DataTables\Admin\UserManagement;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class UserDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', 'admin.user-management.user.action')
            ->editColumn('deleted_at', fn($row) => $row->deleted_at ? '<span class="badge bg-danger">Not Active</span>' : '<span class="badge bg-success">Active</span>')
            ->addIndexColumn()
            ->rawColumns(['action', 'deleted_at']);
    }

    public function query(User $model): QueryBuilder
    {
        return $model->newQuery()->withTrashed();
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('<"row mb-3 mt-2"<"col-md-2"l><"col-md-2"f><"col-md-8 text-md-end"B>>rtip')
                    ->orderBy(5, 'asc')
                    ->orderBy(1, 'asc')
                    ->scrollX(true)
                    ->selectStyleSingle()
                    ->buttons([
                        Button::make('excel'),
                        // Button::make('csv'),
                        // Button::make('pdf'),
                    ]);
    }

    public function getColumns(): array
    {
        return [
            Column::computed('DT_RowIndex')->title('#')->width('25')->addClass('text-center'),
            Column::make('name')->width('150px')->addClass('text-center'),
            Column::make('email')->width('100px')->addClass('text-center'),
            Column::make('role')->width('100px')->addClass('text-center'),
            Column::make('deleted_at')->width('100px')->addClass('text-center')->title('Status'),
            Column::computed('action')->exportable(false)->printable(false)->width('250px')->addClass('text-center')->title('Action'),
        ];
    }
    protected function filename(): string
    {
        return 'User_' . date('YmdHis');
    }
}
