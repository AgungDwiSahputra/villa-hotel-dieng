<x-app-layout title="Promo Management" subTitle="Manage your promotional campaigns">
    <x-card-component col="12" title="All Promos" :dataTable="$dataTable">
        @can('promo create')
            <div class="d-flex justify-content-between mb-3">
                <div class="btn-group">
                    <a href="{{ route('admin.promo.promo.create') }}" class="btn btn-primary waves-effect btn-label waves-light">
                        <i class="bx bx-plus label-icon"></i> Create New Promo
                    </a>
                </div>
            </div>
        @endcan
    </x-card-component>

    @slot('modal')
        <!-- Delete Confirmation Modal -->
        <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel">Delete Confirmation</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to delete the promo "<strong id="deletePromoName"></strong>"?</p>
                        <p class="text-danger">This action cannot be undone and will remove all related category and product associations.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <form id="deleteForm" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endslot
</x-app-layout>

<script>
function confirmDelete(promoId, promoName) {
    document.getElementById('deletePromoName').textContent = promoName;
    document.getElementById('deleteForm').action = '/admin/promo/promo/' + promoId;
    new bootstrap.Modal(document.getElementById('deleteModal')).show();
}
</script>