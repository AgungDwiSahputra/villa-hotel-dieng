<?php

namespace App\DataTables\Admin\UserManagement;

use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class PermissionDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', 'admin.user-management.permission.action')
            ->addIndexColumn();
    }

    public function query(Permission $model): QueryBuilder
    {
        // Start the query
        $query = $model->newQuery()
            ->select([
                'permissions.*',
                DB::raw('SUBSTR(name, 1, INSTR(name, "(") - 1) as module'),
                DB::raw('SUBSTR(name, INSTR(name, "(") + 1, INSTR(name, ")") - INSTR(name, "(") - 1) as module_action')
            ]);

        if ($search = request()->get('search')['value']) {
            $query->where(function ($q) use ($search) {
                $q->whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($search) . '%']);
                $q->orWhereRaw('LOWER(SUBSTR(name, 1, INSTR(name, "(") - 1)) LIKE ?', ['%' . strtolower($search) . '%']);
                $q->orWhereRaw('LOWER(SUBSTR(name, INSTR(name, "(") + 1, INSTR(name, ")") - INSTR(name, "(") - 1)) LIKE ?', ['%' . strtolower($search) . '%']);
            });
        }

        return $query;
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('<"row mb-3 mt-2"<"col-md-2"l><"col-md-2"f><"col-md-8 text-md-end"B>>rtip')
                    ->orderBy(1, 'asc')->orderBy(2, 'asc')
                    ->selectStyleSingle()
                    ->scrollX(true)
                    ->buttons([
                        Button::make('excel'),
                        // Button::make('csv'),
                        // Button::make('pdf'),
                    ]);
    }

    public function getColumns(): array
    {
        $columns = [
            Column::computed('DT_RowIndex')->title('#')->width('5%')->addClass('text-center'),
            Column::make('module')->width('30%')->addClass('text-center')->searchable(false)->orderable(true),
            Column::make('module_action')->width('35%')->addClass('text-center')->searchable(false)->orderable(true),
        ];

        $canEdit = auth()->user()->can('User Management Permission (Edit)');
        $canDelete = auth()->user()->can('User Management Permission (Delete)');

        if ($canEdit || $canDelete) {
            $columns[] = Column::computed('action')->exportable(false)->printable(false)->width('30%')->addClass('text-center')->title('Action');

        }
        return $columns;
    }

    protected function filename(): string
    {
        return 'Permission_' . date('YmdHis');
    }
}
