<button type="button" class="btn btn-info waves-effect waves-light" onclick="showImage('{{ $image }}','Image')"><i class="bx bx-image font-size-16 align-middle"></i></button>
@if($deleted_at)
    @can('User Management User (Delete)')
        <button type="button" class="btn btn-success waves-effect btn-label waves-light delete-item" data-tableid="table" data-action="Restore" data-url="{{ route('admin.user-management.user.destroy', $id) }}"><i class="bx bx-undo label-icon"></i> Restore</button>
    @endif
@else
    @can('User Management User (Edit)')
        <button type="button" class="btn btn-warning waves-effect btn-label waves-light" onclick="edit('{{ $id }}')"><i class="bx bx-pencil label-icon"></i> Edit</button>
    @endif
    @can('User Management User (Delete)')
        <button type="button" class="btn btn-danger waves-effect btn-label waves-light delete-item" data-tableid="table" data-action="Delete" data-url="{{ route('admin.user-management.user.destroy', $id) }}"><i class="bx bx-trash label-icon"></i> Delete</button>
    @endif
@endif
