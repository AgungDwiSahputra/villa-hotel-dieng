@can('Produk Syarat (Edit)')
    <button type="button" class="btn btn-warning waves-effect btn-label waves-light" onclick="edit('{{ $id }}')"><i class="bx bx-pencil label-icon"></i> Edit</button>
@endif
@can('Produk Syarat (Delete)')
    <button type="button" class="btn btn-danger waves-effect btn-label waves-light delete-item" data-tableid="table" data-action="Delete" data-url="{{ route('admin.produk.syarat.destroy', $id) }}"><i class="bx bx-trash label-icon"></i> Delete</button>
@endif