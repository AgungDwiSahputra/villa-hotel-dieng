<?php

namespace App\DataTables\Admin\Transaksi;

use App\Models\Transaksi\Transaksi;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class TransaksiDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', 'admin.transaksi.transaksi.action')
            ->editColumn('created_at', fn($query) => $query->created_at->format('d M Y'))
            ->editColumn('status', fn($query) => $query->status == "PENDING" ? '<span class="badge bg-warning">PENDING</span>' : ($query->status == "Terima" ? '<span class="badge bg-success">Terima</span>' : '<span class="badge bg-danger">Tolak</span>'))
            ->addIndexColumn()
            ->rawColumns(['action', 'status']);
    }

    public function query(Transaksi $model): QueryBuilder
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
            Column::computed('DT_RowIndex')->title('#')->width('25px')->addClass('text-center'),
            Column::make('created_at')->title('Tanggal Booking')->width('150px')->addClass('text-center'),
            Column::make('produk_id')->title('Produk ID')->width('150px')->addClass('text-center'),
            Column::make('start_date')->title('Check In')->width('120px')->addClass('text-center'),
            Column::make('end_date')->title('Check Out')->width('120px')->addClass('text-center'),
            Column::make('night')->title('Jumlah Malam')->width('150px')->addClass('text-center'),
            Column::make('unit')->title('Jumlah Unit')->width('100px')->addClass('text-center'),
            Column::make('total')->title('Total')->width('100px')->addClass('text-center'),
            Column::make('name')->title('Nama')->width('150px')->addClass('text-center'),
            Column::make('email')->title('Email')->width('200px')->addClass('text-center'),
            Column::make('no_wa')->title('No. WhatsApp')->width('150px')->addClass('text-center'),
            Column::make('status')->title('Status')->width('100px')->addClass('text-center'),
            Column::computed('action')->exportable(false)->printable(false)->width('250px')->addClass('text-center')->title('Action'),
        ];
    }
    protected function filename(): string
    {
        return 'Transaksi' . date('YmdHis');
    }
}