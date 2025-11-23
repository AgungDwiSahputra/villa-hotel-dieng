@can('Jeep Trip Image (Index)')
    <a href="{{ route('admin.jeep-trip.image.index', ['jeep_trip' => $id]) }}" class="btn btn-info waves-effect btn-label waves-light" title="Kelola Gambar">
        <i class="bx bx-image label-icon"></i> Gambar
    </a>
@endcan
@can('Jeep Trip (Edit)')
    <button type="button" class="btn btn-warning waves-effect btn-label waves-light" onclick="editData('{{ $id }}')">
        <i class="bx bx-pencil label-icon"></i> Edit
    </button>
@endcan
@can('Jeep Trip (Delete)')
    <button type="button" class="btn btn-danger waves-effect btn-label waves-light" onclick="deleteData('{{ $id }}')">
        <i class="bx bx-trash label-icon"></i> Hapus
    </button>
@endcan