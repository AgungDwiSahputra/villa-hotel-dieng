<x-app-layout title="Activity Log" subTitle="Activity Log">
    <x-card-component col="4" title="Filter Activity Log">
        <form action="{{ route('admin.activity-log.index') }}" method="GET">
            <div class="row">
                <x-input-form-component col="12" title="Date" max=23 id="date_range" name="date" value="{{ request()->date ?? Carbon\Carbon::now()->subDays(7)->format('d-m-Y') . ' - ' . Carbon\Carbon::now()->format('d-m-Y') }}" />
            </div>
            <div class="row">
                <div class="col text-end">
                    <button type="submit" class="btn btn-primary">Filter</button>
                </div>
            </div>
        </form>
    </x-card-component>
    
    <x-card-component col="12" title="Data Activity Log" :dataTable="$dataTable">
        @can('Activity Log (Delete)')
            <div class="d-flex justify-content-end">
                <button type="button" class="btn btn-danger waves-effect btn-label waves-light delete-item" data-tableid="table" data-url="{{ route('admin.activity-log.destroy', 1) }}"><i class="bx bx-trash label-icon"></i> Clear Data</button>
            </div>
        @endcan
    </x-card-component>
</x-app-layout>