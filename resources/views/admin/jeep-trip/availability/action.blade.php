@can('Jeep Trip Availability (Edit)')
    <button type="button" class="btn btn-warning waves-effect btn-label waves-light" onclick="editData('{{ $id }}')">
        <i class="bx bx-pencil label-icon"></i> Edit
    </button>
@endcan
@can('Jeep Trip Availability (Delete)')
    <button type="button" class="btn btn-danger waves-effect btn-label waves-light" onclick="deleteData('{{ $id }}')">
        <i class="bx bx-trash label-icon"></i> Hapus
    </button>
@endcan