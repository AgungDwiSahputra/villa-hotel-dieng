<?php

namespace App\DataTables\Admin;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use App\Models\ActivityLog;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class ActivityLogDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->filterColumn('user_name', fn($query, $keyword) => $query->where('users.name', 'like', "%{$keyword}%"))
            ->addColumn('ip', fn($row) => $this->extractJson($row->data, 'ip'))
            ->addColumn('user_agent', fn($row) => $this->extractJson($row->data, 'user_agent'))
            ->addIndexColumn();
    }

    private function extractJson(?string $json, string $key): ?string
    {
        if (!$json) {
            return null;
        }

        $data = json_decode($json, true);
        return $data[$key] ?? null;
    }

    public function query(ActivityLog $model): QueryBuilder
    {
        $dateRange = $this->request->date;
        
        if ($dateRange) {
            [$startDate, $endDate] = explode(' - ', $dateRange);
            $startDate = Carbon::createFromFormat('d-m-Y', trim($startDate))->startOfDay();
            $endDate = Carbon::createFromFormat('d-m-Y', trim($endDate))->endOfDay();
        } else {
            $startDate = Carbon::now()->subDays(7)->startOfDay();
            $endDate = Carbon::now()->endOfDay();
        }
        
        return $model->newQuery()
            ->join('users', 'logs.user_id', '=', 'users.id')
            ->select([
                'logs.*',
                'users.name as user_name',
            ])
            ->whereBetween('logs.log_date', [$startDate, $endDate]);
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
                        Button::make('excel'),
                        Button::make('csv'),
                        Button::make('pdf'),
                    ]);
    }

    public function getColumns(): array
    {
        return [
            Column::computed('DT_RowIndex')->title('#')->width('25px')->addClass('text-center'),
            Column::make('ip')->width('100px')->addClass('text-center'),
            Column::make('user_agent')->width('100px')->addClass('text-center'),
            Column::make('user_name')->width('100px')->addClass('text-center')->title('User'),
            Column::make('log_date')->width('100px')->addClass('text-center'),
            Column::make('table_name')->width('100px')->addClass('text-center'),
            Column::make('log_type')->width('100px')->addClass('text-center'),
            Column::make('data')->width('100px')->addClass('text-center'),
        ];
    }
    protected function filename(): string
    {
        return 'Activity_Log' . date('YmdHis');
    }
}