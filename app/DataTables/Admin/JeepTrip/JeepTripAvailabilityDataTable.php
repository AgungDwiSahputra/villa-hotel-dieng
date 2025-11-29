<?php

namespace App\DataTables\Admin\JeepTrip;

use App\Models\JeepTrip\JeepTripAvailability;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class JeepTripAvailabilityDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', 'admin.jeep-trip.availability.action')
            ->addColumn('jeep_trip_name', function ($record) {
                return $record->slot->jeepTrip->nama_paket ?? '-';
            })
            ->addColumn('slot_name', function ($record) {
                return $record->slot->nama_slot ?? '-';
            })
            ->addColumn('time_range', function ($record) {
                return $record->slot->getFormattedTimeRange();
            })
            ->addColumn('quota_tersedia', function ($record) {
                return $record->getQuotaTersedia();
            })
            ->editColumn('tanggal', fn($record) => $record->tanggal->format('d/m/Y'))
            ->editColumn('quota_jeep', fn($record) => $record->quota_jeep . ' jeep')
            ->editColumn('quota_terpakai', fn($record) => $record->quota_terpakai . ' jeep')
            ->editColumn('is_closed', function ($record) {
                return $record->is_closed
                    ? '<span class="badge bg-danger">Ditutup</span>'
                    : '<span class="badge bg-success">Terbuka</span>';
            })
            ->editColumn('created_at', fn($record) => $record->created_at->format('d/m/Y H:i'))
            ->addIndexColumn()
            ->rawColumns(['is_closed', 'action']);
    }

    public function query(JeepTripAvailability $model): QueryBuilder
    {
        return $model->newQuery()
            ->with(['slot.jeepTrip'])
            ->select('jeep_trip_availabilities.*')
            ->orderBy('tanggal', 'asc')
            ->orderBy('created_at', 'desc');
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('jeep-trip-availability-table')
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
            Column::make('jeep_trip_name')->width('200px')->title('Paket Jeep Trip'),
            Column::make('slot_name')->width('150px')->title('Slot'),
            Column::make('time_range')->width('120px')->addClass('text-center')->title('Waktu'),
            Column::make('tanggal')->width('100px')->addClass('text-center')->title('Tanggal'),
            Column::make('quota_jeep')->width('80px')->addClass('text-center')->title('Quota Total'),
            Column::make('quota_terpakai')->width('80px')->addClass('text-center')->title('Terpakai'),
            Column::make('quota_tersedia')->width('80px')->addClass('text-center')->title('Tersedia'),
            Column::make('is_closed')->width('80px')->addClass('text-center')->title('Status'),
            Column::make('created_at')->width('120px')->addClass('text-center')->title('Dibuat'),
            Column::computed('action')->exportable(false)->printable(false)->width('200px')->addClass('text-center')->title('Aksi'),
        ];
    }

    protected function filename(): string
    {
        return 'Jeep_Trip_Availability_' . date('YmdHis');
    }
}