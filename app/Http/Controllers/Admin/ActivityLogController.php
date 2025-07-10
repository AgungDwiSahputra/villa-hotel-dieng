<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\ActivityLogDataTable;
use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class ActivityLogController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:Activity Log (Index)', only: ['index']),
            new Middleware('permission:Activity Log (Delete)', only: ['destroy']),
        ];
    }

    public function index(ActivityLogDataTable $dataTable, Request $request)
    {                
        return $dataTable->render('admin.activity-log.index');
    }

    public function destroy(string $id)
    {
        ActivityLog::query()->delete();
        return response()->json();
    }
}
