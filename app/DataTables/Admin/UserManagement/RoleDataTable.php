<?php

namespace App\DataTables\Admin\UserManagement;

use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class RoleDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', 'admin.user-management.role.action')
            ->addIndexColumn();
    }

    public function query(Role $model): QueryBuilder
    {
        return $model->newQuery();
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('<"row mb-3 mt-2"<"col-md-2"l><"col-md-2"f><"col-md-8 text-md-end"B>>rtip')
                    ->orderBy(1,'asc')
                    ->selectStyleSingle()
                    ->scrollX(true)
                    ->buttons([
                        Button::make('excel'),
                        // Button::make('csv'),
                        // Button::make('pdf'),
                    ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        $columns = [
            Column::computed('DT_RowIndex')->title('#')->width('5%')->addClass('text-center'),
            Column::make('name')->width('55%')->addClass('text-center'),
        ];

        $canEdit = auth()->user()->can('User Management Role (Edit)');
        $canDelete = auth()->user()->can('User Management Role (Delete)');
        $canPermission = auth()->user()->can('User Management Role (Permission)');

        if ($canEdit || $canDelete || $canPermission) {
            $columns[] = Column::computed('action')->exportable(false)->printable(false)->width('40%')->addClass('text-center')->title('Action');
        }
        return $columns;
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Role_' . date('YmdHis');
    }
}
