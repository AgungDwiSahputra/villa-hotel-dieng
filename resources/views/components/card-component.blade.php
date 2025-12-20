<div class="col-md-{{ $col }}">
    <div class="card card-body">
        <h3 class="card-title">{{ $title }}</h3>
        <p class="card-text">{{ $subTitle }}</p>
        {{ $slot }}
        @if($dataTable)
            {{ $dataTable->table() }}
        @endif
    </div>
</div>

@if($dataTable)
    @push('js')
        {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
    @endpush
@endif