<x-app-layout title="{{ $title }}" subTitle="View detailed information about this promotional campaign">
    <x-card-component col="12" title="Promo Details">
        <div class="row">
            <!-- Basic Information -->
            <div class="col-md-6">
                <div class="card mb-3">
                    <div class="card-header bg-primary text-white">
                        <h6 class="mb-0"><i class="bx bx-info-circle"></i> Basic Information</h6>
                    </div>
                    <div class="card-body">
                        <table class="table table-borderless table-sm">
                            <tr>
                                <td class="fw-bold" style="width: 40%;">Promo Name:</td>
                                <td>{{ $promo->name }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Promo Code:</td>
                                <td><span class="badge bg-info">{{ $promo->promo_code }}</span></td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Description:</td>
                                <td>{{ $promo->description ?: 'No description' }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Status:</td>
                                <td>
                                    @if($promo->isValid())
                                        <span class="badge bg-success">Active</span>
                                    @elseif($promo->start_date && now()->lt($promo->start_date))
                                        <span class="badge bg-warning">Scheduled</span>
                                    @else
                                        <span class="badge bg-danger">Inactive</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Created By:</td>
                                <td>{{ $promo->creator ? $promo->creator->name : 'N/A' }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Updated By:</td>
                                <td>{{ $promo->updater ? $promo->updater->name : 'N/A' }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Discount Information -->
            <div class="col-md-6">
                <div class="card mb-3">
                    <div class="card-header bg-success text-white">
                        <h6 class="mb-0"><i class="bx bx-discount"></i> Discount Information</h6>
                    </div>
                    <div class="card-body">
                        <table class="table table-borderless table-sm">
                            <tr>
                                <td class="fw-bold" style="width: 40%;">Discount Type:</td>
                                <td>
                                    @if($promo->discount_type === 'percentage')
                                        <span class="badge bg-primary">Percentage</span>
                                    @else
                                        <span class="badge bg-secondary">Fixed Amount</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Discount Value:</td>
                                <td>
                                    @if($promo->discount_type === 'percentage')
                                        {{ $promo->discount_value }}%
                                    @else
                                        Rp. {{ number_format($promo->discount_value, 0, ',', '.') }}
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Applicable To:</td>
                                <td>
                                    @switch($promo->applicable_to)
                                        @case('all')
                                            <span class="badge bg-info">All Products</span>
                                            @break
                                        @case('category')
                                            <span class="badge bg-primary">{{ $promo->categories->count() }} Categories</span>
                                            @break
                                        @case('product')
                                            <span class="badge bg-secondary">{{ $promo->products->count() }} Products</span>
                                            @break
                                    @endswitch
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Validity Period -->
            <div class="col-md-6">
                <div class="card mb-3">
                    <div class="card-header bg-warning text-dark">
                        <h6 class="mb-0"><i class="bx bx-calendar"></i> Validity Period</h6>
                    </div>
                    <div class="card-body">
                        <table class="table table-borderless table-sm">
                            <tr>
                                <td class="fw-bold" style="width: 40%;">Start Date:</td>
                                <td>{{ $promo->start_date ? $promo->start_date->format('d M Y H:i') : 'No start date' }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">End Date:</td>
                                <td>{{ $promo->end_date ? $promo->end_date->format('d M Y H:i') : 'No end date' }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Duration:</td>
                                <td>
                                    @if($promo->start_date && $promo->end_date)
                                        {{ $promo->start_date->diffInDays($promo->end_date) }} days
                                    @else
                                        Ongoing
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Usage Statistics -->
            <div class="col-md-6">
                <div class="card mb-3">
                    <div class="card-header bg-info text-white">
                        <h6 class="mb-0"><i class="bx bx-chart"></i> Usage Statistics</h6>
                    </div>
                    <div class="card-body">
                        <table class="table table-borderless table-sm">
                            <tr>
                                <td class="fw-bold" style="width: 40%;">Current Usage:</td>
                                <td>{{ $promo->usage_count }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Usage Limit:</td>
                                <td>{{ $promo->usage_limit ?: 'Unlimited' }}</td>
                            </tr>
                            @if($promo->usage_limit)
                                <tr>
                                    <td class="fw-bold">Usage Progress:</td>
                                    <td>
                                        <div class="progress" style="height: 20px;">
                                            @php
                                                $percentage = min(($promo->usage_count / $promo->usage_limit) * 100, 100);
                                            @endphp
                                            <div class="progress-bar {{ $percentage >= 80 ? 'bg-danger' : ($percentage >= 60 ? 'bg-warning' : 'bg-success') }}"
                                                 role="progressbar"
                                                 style="width: {{ $percentage }}%">
                                                {{ round($percentage, 1) }}%
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endif
                        </table>
                    </div>
                </div>
            </div>

            <!-- Applicable Categories (if applicable) -->
            @if($promo->applicable_to === 'category' && $promo->categories->isNotEmpty())
                <div class="col-12">
                    <div class="card mb-3">
                        <div class="card-header bg-primary text-white">
                            <h6 class="mb-0"><i class="bx bx-category"></i> Applicable Categories</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                @foreach($promo->categories as $categoryRel)
                                    <div class="col-md-4 mb-2">
                                        <div class="d-flex justify-content-between align-items-center p-2 bg-light rounded">
                                            <div>
                                                <strong>{{ $categoryRel->category->name }}</strong>
                                                @if($categoryRel->discount_type && $categoryRel->discount_value)
                                                    <br>
                                                    <small class="text-muted">
                                                        Override:
                                                        @if($categoryRel->discount_type === 'percentage')
                                                            {{ $categoryRel->discount_value }}%
                                                        @else
                                                            Rp. {{ number_format($categoryRel->discount_value, 0, ',', '.') }}
                                                        @endif
                                                    </small>
                                                @endif
                                            </div>
                                            <span class="badge {{ $categoryRel->enabled ? 'bg-success' : 'bg-danger' }}">
                                                {{ $categoryRel->enabled ? 'Enabled' : 'Disabled' }}
                                            </span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Applicable Products (if applicable) -->
            @if($promo->applicable_to === 'product' && $promo->products->isNotEmpty())
                <div class="col-12">
                    <div class="card mb-3">
                        <div class="card-header bg-secondary text-white">
                            <h6 class="mb-0"><i class="bx bx-box"></i> Applicable Products</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                @foreach($promo->products as $productRel)
                                    <div class="col-md-6 mb-2">
                                        <div class="d-flex justify-content-between align-items-center p-2 bg-light rounded">
                                            <div>
                                                <strong>{{ $productRel->produk->name }}</strong>
                                                <br>
                                                <small class="text-muted">{{ $productRel->produk->category->name }}</small>
                                                @if($productRel->discount_type && $productRel->discount_value)
                                                    <br>
                                                    <small class="text-muted">
                                                        Override:
                                                        @if($productRel->discount_type === 'percentage')
                                                            {{ $productRel->discount_value }}%
                                                        @else
                                                            Rp. {{ number_format($productRel->discount_value, 0, ',', '.') }}
                                                        @endif
                                                    </small>
                                                @endif
                                            </div>
                                            <span class="badge {{ $productRel->enabled ? 'bg-success' : 'bg-danger' }}">
                                                {{ $productRel->enabled ? 'Enabled' : 'Disabled' }}
                                            </span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Summary Statistics -->
            <div class="col-12">
                <div class="card mb-3">
                    <div class="card-header bg-dark text-white">
                        <h6 class="mb-0"><i class="bx bx-stats"></i> Summary Statistics</h6>
                    </div>
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-md-3">
                                <div class="p-3">
                                    <h4 class="text-primary">{{ $totalProducts }}</h4>
                                    <p class="mb-0 text-muted">Total Products Affected</p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="p-3">
                                    <h4 class="text-success">{{ $activeProducts }}</h4>
                                    <p class="mb-0 text-muted">Currently Active</p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="p-3">
                                    <h4 class="text-info">{{ $promo->usage_count }}</h4>
                                    <p class="mb-0 text-muted">Times Used</p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="p-3">
                                    <h4 class="text-warning">
                                        @if($promo->end_date)
                                            {{ max(0, $promo->end_date->diffInDays(now())) }}
                                        @else
                                            ∞
                                        @endif
                                    </h4>
                                    <p class="mb-0 text-muted">Days Remaining</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.promo.promo.index') }}" class="btn btn-secondary">
                        <i class="bx bx-arrow-back"></i> Back to List
                    </a>
                    @can('promo edit')
                        <form action="{{ route('admin.promo.promo.toggle-status', $promo) }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" class="btn btn-warning" onclick="return confirm('Are you sure you want to change the status of this promo?')">
                                <i class="bx bx-power-off"></i> {{ $promo->is_active ? 'Deactivate' : 'Activate' }}
                            </button>
                        </form>
                        <a href="{{ route('admin.promo.promo.edit', $promo) }}" class="btn btn-primary">
                            <i class="bx bx-edit"></i> Edit Promo
                        </a>
                    @endcan
                    <form action="{{ route('admin.promo.promo.duplicate', $promo) }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn btn-info text-white">
                            <i class="bx bx-copy"></i> Duplicate
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </x-card-component>
</x-app-layout>