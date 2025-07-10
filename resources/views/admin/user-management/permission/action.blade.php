@can('User Management Permission (Edit)')
    <button type="button" class="btn btn-warning waves-effect btn-label waves-light" onclick="edit('{{ $id }}')"><i class="bx bx-pencil label-icon"></i> Edit</button>
@endcan
@can('User Management Permission (Delete)')
    <button type="button" class="btn btn-danger waves-effect btn-label waves-light delete-item" data-tableid="table" data-url="{{ route('admin.user-management.permission.destroy', $id) }}"><i class="bx bx-trash label-icon"></i> Delete</button>
@endcan