<?php

namespace App\DataTables\Admin\JeepTrip;

use App\Models\JeepTrip\JeepTripImage;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class JeepTripImageDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', 'admin.jeep-trip.image.action')
            ->addColumn('image_preview', function ($record) {
                return '<img src="' . asset('storage/' . $record->image_path) . '" class="img-thumbnail" style="width: 60px; height: 60px; object-fit: cover;" alt="Preview">';
            })
            ->addIndexColumn()
            ->rawColumns(['image_preview', 'action']);
    }

    public function query(JeepTripImage $model): QueryBuilder
    {
        return $model->newQuery()->where('jeep_trip_id', $this->request->jeep_trip)->orderBy('urutan');
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('jeep-trip-image-table')
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
            Column::computed('image_preview')->title('Preview')->width('80px')->addClass('text-center'),
            Column::make('judul')->width('200px')->title('Judul'),
            Column::make('urutan')->width('80px')->addClass('text-center')->title('Urutan'),
            Column::computed('action')->exportable(false)->printable(false)->width('150px')->addClass('text-center')->title('Aksi'),
        ];
    }

    protected function filename(): string
    {
        return 'Jeep_Trip_Image_' . date('YmdHis');
    }
}