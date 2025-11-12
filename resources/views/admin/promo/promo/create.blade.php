<x-app-layout title="Create New Promo" subTitle="Set up a new promotional campaign">
    <x-card-component col="12" title="Promo Information">
        <form method="POST" action="{{ route('admin.promo.promo.store') }}">
            @csrf

            <!-- Basic Information -->
            <div class="row mb-4">
                <div class="col-12">
                    <h6 class="mb-3"><i class="bx bx-info-circle"></i> Basic Information</h6>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="name" class="form-label">Promo Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                               id="name" name="name" value="{{ old('name') }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="promo_code" class="form-label">Promo Code</label>
                        <input type="text" class="form-control @error('promo_code') is-invalid @enderror"
                               id="promo_code" name="promo_code" value="{{ old('promo_code') }}"
                               placeholder="Leave blank to auto-generate">
                        @error('promo_code')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">Unique code for promo identification</small>
                    </div>
                </div>
                <div class="col-12">
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror"
                                  id="description" name="description" rows="3">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Discount Configuration -->
            <div class="row mb-4">
                <div class="col-12">
                    <h6 class="mb-3"><i class="bx bx-discount"></i> Discount Configuration</h6>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="discount_type" class="form-label">Discount Type <span class="text-danger">*</span></label>
                        <select class="form-select @error('discount_type') is-invalid @enderror"
                                id="discount_type" name="discount_type" required>
                            <option value="">Select Discount Type</option>
                            <option value="percentage" {{ old('discount_type') == 'percentage' ? 'selected' : '' }}>
                                Percentage (%)
                            </option>
                            <option value="fixed" {{ old('discount_type') == 'fixed' ? 'selected' : '' }}>
                                Fixed Amount (Rp)
                            </option>
                        </select>
                        @error('discount_type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="discount_value" class="form-label">Discount Value <span class="text-danger">*</span></label>
                        <input type="number" class="form-control @error('discount_value') is-invalid @enderror"
                               id="discount_value" name="discount_value" value="{{ old('discount_value') }}"
                               step="0.01" min="0" required>
                        @error('discount_value')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted" id="discountHelper">Enter discount percentage or amount</small>
                    </div>
                </div>
            </div>

            <!-- Validity Period -->
            <div class="row mb-4">
                <div class="col-12">
                    <h6 class="mb-3"><i class="bx bx-calendar"></i> Validity Period</h6>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="start_date" class="form-label">Start Date</label>
                        <input type="datetime-local" class="form-control @error('start_date') is-invalid @enderror"
                               id="start_date" name="start_date" value="{{ old('start_date') }}">
                        @error('start_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">Leave blank for immediate activation</small>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="end_date" class="form-label">End Date</label>
                        <input type="datetime-local" class="form-control @error('end_date') is-invalid @enderror"
                               id="end_date" name="end_date" value="{{ old('end_date') }}">
                        @error('end_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">Leave blank for no expiration</small>
                    </div>
                </div>
            </div>

            <!-- Usage Limits -->
            <div class="row mb-4">
                <div class="col-12">
                    <h6 class="mb-3"><i class="bx bx-limit"></i> Usage Limits</h6>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="usage_limit" class="form-label">Usage Limit</label>
                        <input type="number" class="form-control @error('usage_limit') is-invalid @enderror"
                               id="usage_limit" name="usage_limit" value="{{ old('usage_limit') }}"
                               min="1">
                        @error('usage_limit')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">Leave blank for unlimited usage</small>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active"
                                   value="1" {{ old('is_active', '1') ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">
                                Active
                            </label>
                        </div>
                        <small class="form-text text-muted">Uncheck to create inactive promo</small>
                    </div>
                </div>
            </div>

            <!-- Applicable To -->
            <div class="row mb-4">
                <div class="col-12">
                    <h6 class="mb-3"><i class="bx bx-target-lock"></i> Applicable To</h6>
                </div>
                <div class="col-12">
                    <div class="mb-3">
                        <label class="form-label">Apply promo to <span class="text-danger">*</span></label>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" id="applicable_all"
                                           name="applicable_to" value="all"
                                           {{ old('applicable_to', 'all') == 'all' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="applicable_all">
                                        <strong>All Products</strong>
                                        <div class="text-muted small">Apply to all available products</div>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" id="applicable_category"
                                           name="applicable_to" value="category"
                                           {{ old('applicable_to') == 'category' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="applicable_category">
                                        <strong>Specific Categories</strong>
                                        <div class="text-muted small">Select product categories</div>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" id="applicable_product"
                                           name="applicable_to" value="product"
                                           {{ old('applicable_to') == 'product' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="applicable_product">
                                        <strong>Specific Products</strong>
                                        <div class="text-muted small">Select individual products</div>
                                    </label>
                                </div>
                            </div>
                        </div>
                        @error('applicable_to')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Dynamic Selection based on Applicable To -->
            <div id="categorySelection" class="row mb-4" style="display: none;">
                <div class="col-12">
                    <h6 class="mb-3"><i class="bx bx-category"></i> Select Categories</h6>
                    <div class="row">
                        @foreach($categories as $category)
                            <div class="col-md-4 mb-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="categories[]"
                                           value="{{ $category->id }}" id="category_{{ $category->id }}"
                                           {{ in_array($category->id, old('categories', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="category_{{ $category->id }}">
                                        {{ $category->name }}
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @error('categories')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div id="productSelection" class="row mb-4" style="display: none;">
                <div class="col-12">
                    <h6 class="mb-3"><i class="bx bx-box"></i> Select Products</h6>
                    <div class="row">
                        @foreach($products as $product)
                            <div class="col-md-4 mb-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="products[]"
                                           value="{{ $product->id }}" id="product_{{ $product->id }}"
                                           {{ in_array($product->id, old('products', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="product_{{ $product->id }}">
                                        {{ $product->name }} ({{ $product->category->name }})
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @error('products')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Form Actions -->
            <div class="row">
                <div class="col-12">
                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.promo.promo.index') }}" class="btn btn-secondary">
                            <i class="bx bx-arrow-back"></i> Cancel
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bx bx-save"></i> Create Promo
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </x-card-component>
</x-app-layout>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const applicableRadios = document.querySelectorAll('input[name="applicable_to"]');
    const categorySelection = document.getElementById('categorySelection');
    const productSelection = document.getElementById('productSelection');
    const discountType = document.getElementById('discount_type');
    const discountHelper = document.getElementById('discountHelper');

    function toggleSelection() {
        const selectedValue = document.querySelector('input[name="applicable_to"]:checked').value;

        categorySelection.style.display = selectedValue === 'category' ? 'block' : 'none';
        productSelection.style.display = selectedValue === 'product' ? 'block' : 'none';
    }

    function updateDiscountHelper() {
        if (discountType.value === 'percentage') {
            discountHelper.textContent = 'Enter discount percentage (0-100)';
            document.getElementById('discount_value').max = '100';
        } else {
            discountHelper.textContent = 'Enter discount amount in Rupiah';
            document.getElementById('discount_value').removeAttribute('max');
        }
    }

    applicableRadios.forEach(radio => {
        radio.addEventListener('change', toggleSelection);
    });

    discountType.addEventListener('change', updateDiscountHelper);

    // Initialize on page load
    toggleSelection();
    updateDiscountHelper();

    // Set minimum start date to today
    const startDate = document.getElementById('start_date');
    const today = new Date().toISOString().slice(0, 16);
    startDate.min = today;
});
</script>