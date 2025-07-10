@can('User Management Role (Create)')
    <button type="button" class="btn btn-warning waves-effect btn-label waves-light" onclick="edit('{{ $id }}')"><i class="bx bx-pencil label-icon"></i> Edit</button>
@endcan
@can('User Management Role (Delete)')
    <button type="button" class="btn btn-danger waves-effect btn-label waves-light delete-item" data-tableid="table" data-url="{{ route('admin.user-management.role.destroy', $id) }}"><i class="bx bx-trash label-icon"></i> Delete</button>
@endcan
@can('User Management Role (Permission)')
    <a href="{{ route('admin.user-management.role.show',$id) }}"><button type="button" class="btn btn-info waves-effect btn-label waves-light"><i class="bx bxs-briefcase-alt-2 label-icon"></i> Permission</button></a>
@endcan
