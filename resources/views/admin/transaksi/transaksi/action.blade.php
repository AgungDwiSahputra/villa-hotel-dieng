@if(strtolower($status) === 'pending')
<button type="button" class="btn btn-success waves-effect btn-label waves-light" onclick="konfirmasi('{{ $id }}','success')"><i class="bx bx-check-double label-icon"></i>Approve</button>
<button type="button" class="btn btn-danger waves-effect btn-label waves-light" onclick="konfirmasi('{{ $id }}','failed')"><i class="bx bx-x label-icon"></i>Reject</button>
@else
<span class="badge bg-secondary">{{ ucfirst($status) }}</span>
@endif

