<?php

namespace App\DataTables\Admin\Produk;

use App\Models\Produk\Produk;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class ProdukDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->filterColumn('category_name', fn($query, $keyword) => $query->where('produk_categories.name', 'like', "%{$keyword}%"))
            ->addColumn('action', 'admin.produk.produk.action')
            ->editColumn('harga_weekend',fn($query) => 'Rp. '. number_format($query->harga_weekend,0,',','.'))
            ->editColumn('harga_weekday',fn($query) => 'Rp. '. number_format($query->harga_weekday,0,',','.'))
            ->addIndexColumn();
    }

    public function query(Produk $model): QueryBuilder
    {
        return $model->newQuery()
        ->join('produk_categories', 'produks.category_id', '=', 'produk_categories.id')
        ->select([
            'produks.*',
            'produk_categories.name as category_name',
        ]);
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('<"row mb-3 mt-2"<"col-md-2"l><"col-md-2"f><"col-md-8 text-md-end"B>>rtip')
                    ->orderBy(1, 'desc')
                    ->orderBy(2, 'asc')
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
            Column::make('category_name')->width('150px')->addClass('text-center')->title('Kategori'),
            Column::make('urutan')->width('10px')->addClass('text-center'),
            Column::make('name')->width('150px')->addClass('text-center'),
            Column::make('unit')->width('50px')->addClass('text-center'),
            Column::make('kamar')->width('50px')->addClass('text-center'),
            Column::make('orang')->width('50px')->addClass('text-center'),
            Column::make('maks_orang')->width('100px')->addClass('text-center'),
            Column::make('lokasi')->width('250px')->addClass('text-center'),
            Column::make('harga_weekday')->width('150px')->addClass('text-center'),
            Column::make('harga_weekend')->width('150px')->addClass('text-center'),
            Column::make('label')->width('10px')->addClass('text-center'),
            Column::computed('action')->exportable(false)->printable(false)->width('250px')->addClass('text-center')->title('Action'),
        ];
    }
    protected function filename(): string
    {
        return 'Produk_' . date('YmdHis');
    }
}