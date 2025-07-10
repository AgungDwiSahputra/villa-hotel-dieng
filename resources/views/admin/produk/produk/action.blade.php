<a href="{{ route('admin.produk.image.index',['produk' => $id]) }}" class="btn btn-info waves-effect waves-light mb-1" title="Image"><i class="bx bx-image font-size-16 align-middle"></i></a>
<a href="{{ route('admin.produk.fasilitas.index',['produk' => $id]) }}" class="btn btn-info waves-effect waves-light mb-1" title="Fasilitas"><i class="bx bx-cog font-size-16 align-middle"></i></a>
<a href="{{ route('admin.produk.wisata.index',['produk' => $id]) }}" class="btn btn-info waves-effect waves-light mb-1" title="Wisata"><i class="bx bx-map font-size-16 align-middle"></i></a>
<a href="{{ route('admin.produk.syarat.index',['produk' => $id]) }}" class="btn btn-info waves-effect waves-light mb-1" title="Syarat & Ketentuan"><i class="bx bx-file font-size-16 align-middle"></i></a>

@can('Produk (Edit)')
    <button type="button" class="btn btn-warning waves-effect btn-label waves-light" onclick="edit('{{ $id }}')"><i class="bx bx-pencil label-icon"></i> Edit</button>
@endif
@can('Produk (Delete)')
    <button type="button" class="btn btn-danger waves-effect btn-label waves-light delete-item" data-tableid="table" data-action="Delete" data-url="{{ route('admin.produk.produk.destroy', $id) }}"><i class="bx bx-trash label-icon"></i> Delete</button>
@endif