<?php

namespace App\DataTables\Admin\Produk;

use App\Models\Produk\ProdukCategory;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class ProdukCategoryDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', 'admin.produk.category.action')
            ->addIndexColumn();
    }

    public function query(ProdukCategory $model): QueryBuilder
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
                    ->orderBy(1, 'asc')
                    ->scrollX(true)
                    ->selectStyleSingle()
                    ->buttons([
                        // Button::make('excel'),
                        // Button::make('csv'),
                        // Button::make('pdf'),
                    ]);
    }

    public function getColumns(): array
    {
        return [
            Column::computed('DT_RowIndex')->title('#')->width('25')->addClass('text-center'),
            Column::make('urutan')->width('10px')->addClass('text-center'),
            Column::make('name')->width('150px')->addClass('text-center'),
            Column::computed('action')->exportable(false)->printable(false)->width('250px')->addClass('text-center')->title('Action'),
        ];
    }
    protected function filename(): string
    {
        return 'Produk_Category_' . date('YmdHis');
    }
}
