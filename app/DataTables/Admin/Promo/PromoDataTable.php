<?php

namespace App\DataTables\Admin\Promo;

use App\Models\Promo\Promo;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use Carbon\Carbon;

class PromoDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', 'admin.promo.promo.action')
            ->editColumn('discount_value', function ($query) {
                $value = $query->discount_value;
                if ($query->discount_type === 'percentage') {
                    return $value . '%';
                }
                return 'Rp. ' . number_format($value, 0, ',', '.');
            })
            ->editColumn('status', function ($query) {
                $now = Carbon::now();
                $isValid = $query->is_active &&
                    (!$query->start_date || $now->gte($query->start_date)) &&
                    (!$query->end_date || $now->lte($query->end_date)) &&
                    (!$query->usage_limit || $query->usage_count < $query->usage_limit);

                if (!$isValid) {
                    return '<span class="badge bg-danger">Inactive</span>';
                }

                if ($query->start_date && $now->lt($query->start_date)) {
                    return '<span class="badge bg-warning">Scheduled</span>';
                }

                return '<span class="badge bg-success">Active</span>';
            })
            ->editColumn('usage', function ($query) {
                $current = $query->usage_count;
                $limit = $query->usage_limit;

                if ($limit) {
                    $percentage = round(($current / $limit) * 100, 1);
                    return $current . ' / ' . $limit . ' (' . $percentage . '%)';
                }

                return $current . ' / Unlimited';
            })
            ->editColumn('date_range', function ($query) {
                $start = $query->start_date ? Carbon::parse($query->start_date)->format('d M Y') : 'No start';
                $end = $query->end_date ? Carbon::parse($query->end_date)->format('d M Y') : 'No end';

                return $start . ' - ' . $end;
            })
            ->editColumn('applicable_to', function ($query) {
                switch ($query->applicable_to) {
                    case 'all':
                        return '<span class="badge bg-info">All Products</span>';
                    case 'category':
                        $count = $query->categories()->where('enabled', true)->count();
                        return '<span class="badge bg-primary">' . $count . ' Categories</span>';
                    case 'product':
                        $count = $query->products()->where('enabled', true)->count();
                        return '<span class="badge bg-secondary">' . $count . ' Products</span>';
                    default:
                        return $query->applicable_to;
                }
            })
            ->addColumn('created_by_name', function ($query) {
                return $query->creator ? $query->creator->name : 'N/A';
            })
            ->rawColumns(['status', 'action', 'applicable_to'])
            ->addIndexColumn();
    }

    public function query(Promo $model): QueryBuilder
    {
        return $model->newQuery()
            ->with(['creator', 'categories', 'products'])
            ->select('promos.*');
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('promo-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('<"row mb-3 mt-2"<"col-md-2"l><"col-md-3"f><"col-md-7 text-md-end"B>>rtip')
                    ->orderBy(1, 'desc')
                    ->scrollX(true)
                    ->selectStyleSingle()
                    ->buttons([
                        Button::make('excel')->title('Promo Data')->exportOptions(['columns' => ':visible']),
                        Button::make('csv')->title('Promo Data')->exportOptions(['columns' => ':visible']),
                        Button::make('pdf')->title('Promo Data')->exportOptions(['columns' => ':visible']),
                        Button::make('print')->title('Promo Data')->exportOptions(['columns' => ':visible']),
                        Button::make('colvis')->text('Columns'),
                    ]);
    }

    public function getColumns(): array
    {
        return [
            Column::computed('DT_RowIndex')->title('#')->width('25')->addClass('text-center'),
            Column::make('name')->title('Promo Name')->width('200px')->addClass('text-start'),
            Column::make('promo_code')->title('Code')->width('120px')->addClass('text-center'),
            Column::computed('discount_value')->title('Discount')->width('120px')->addClass('text-center'),
            Column::computed('applicable_to')->title('Applied To')->width('150px')->addClass('text-center'),
            Column::computed('date_range')->title('Valid Period')->width('200px')->addClass('text-center'),
            Column::computed('usage')->title('Usage')->width('120px')->addClass('text-center'),
            Column::computed('status')->title('Status')->width('100px')->addClass('text-center'),
            Column::make('created_by_name')->title('Created By')->width('120px')->addClass('text-center'),
            Column::computed('action')->exportable(false)->printable(false)->width('180px')->addClass('text-center')->title('Actions'),
        ];
    }

    protected function filename(): string
    {
        return 'Promo_' . date('YmdHis');
    }
}