<?php

namespace App\DataTables\Admin\JeepTrip;

use App\Models\JeepTrip\JeepTrip;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class JeepTripDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', 'admin.jeep-trip.jeep-trip.action')
            ->addColumn('total_bookings', function ($record) {
                return $record->booking_items_count ?? 0;
            })
            ->editColumn('harga_weekday', fn($record) => 'Rp. ' . number_format($record->harga_weekday, 0, ',', '.'))
            ->editColumn('harga_weekend', fn($record) => 'Rp. ' . number_format($record->harga_weekend, 0, ',', '.'))
            ->editColumn('durasi_jam', fn($record) => $record->durasi_jam ? $record->durasi_jam . ' jam' : '-')
            ->editColumn('rating', fn($record) => $record->rating ? number_format($record->rating, 1) . ' ⭐' : '-')
            ->editColumn('is_active', function ($record) {
                return $record->is_active
                    ? '<span class="badge bg-success">Aktif</span>'
                    : '<span class="badge bg-danger">Tidak Aktif</span>';
            })
            ->editColumn('created_at', fn($record) => $record->created_at->format('d/m/Y H:i'))
            ->addIndexColumn()
            ->rawColumns(['is_active', 'action']);
    }

    public function query(JeepTrip $model): QueryBuilder
    {
        return $model->newQuery()
            ->with(['images', 'slots'])
            ->withCount('bookingItems')
            ->select('jeep_trips.*');
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('jeep-trip-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('<"row mb-3 mt-2"<"col-md-2"l><"col-md-2"f><"col-md-8 text-md-end"B>>rtip')
            ->orderBy(1, 'desc')
            ->scrollX(true)
            ->selectStyleSingle()
            ->buttons([
                Button::make('excel'),
                Button::make('csv'),
                Button::make('pdf'),
            ]);
    }

    public function getColumns(): array
    {
        return [
            Column::computed('DT_RowIndex')->title('#')->width('25')->addClass('text-center'),
            Column::make('nama_paket')->width('200px')->title('Nama Paket'),
            Column::make('zona')->width('100px')->addClass('text-center')->title('Zona'),
            Column::make('durasi_jam')->width('80px')->addClass('text-center')->title('Durasi'),
            Column::make('kapasitas_ideal_per_jeep')->width('80px')->addClass('text-center')->title('Kapasitas'),
            Column::make('harga_weekday')->width('120px')->addClass('text-center')->title('Harga Weekday'),
            Column::make('harga_weekend')->width('120px')->addClass('text-center')->title('Harga Weekend'),
            Column::make('rating')->width('80px')->addClass('text-center')->title('Rating'),
            Column::make('is_active')->width('80px')->addClass('text-center')->title('Status'),
            Column::make('total_bookings')->width('80px')->addClass('text-center')->title('Total Booking'),
            Column::make('created_at')->width('120px')->addClass('text-center')->title('Dibuat'),
            Column::computed('action')->exportable(false)->printable(false)->width('250px')->addClass('text-center')->title('Aksi'),
        ];
    }

    protected function filename(): string
    {
        return 'Jeep_Trip_' . date('YmdHis');
    }
}