@canany(['promo edit', 'promo delete'])
    <div class="btn-group" role="group">
        <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bx bx-dots-horizontal-rounded"></i>
        </button>
        <ul class="dropdown-menu">
            @can('promo view')
                <li>
                    <a href="{{ route('admin.promo.promo.show', $id) }}" class="dropdown-item">
                        <i class="bx bx-show-alt text-info"></i> View Details
                    </a>
                </li>
            @endcan
            @can('promo edit')
                <li>
                    <a href="{{ route('admin.promo.promo.edit', $id) }}" class="dropdown-item">
                        <i class="bx bx-edit text-primary"></i> Edit
                    </a>
                </li>
                <li>
                    <form action="{{ route('admin.promo.promo.toggle-status', $id) }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="dropdown-item" onclick="return confirm('Are you sure you want to change the status of this promo?')">
                            <i class="bx bx-power-off text-warning"></i> {{ $is_active ? 'Deactivate' : 'Activate' }}
                        </button>
                    </form>
                </li>
                <li>
                    <form action="{{ route('admin.promo.promo.duplicate', $id) }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="dropdown-item">
                            <i class="bx bx-copy text-info"></i> Duplicate
                        </button>
                    </form>
                </li>
            @endcan
            @can('promo delete')
                <li><hr class="dropdown-divider"></li>
                <li>
                    <button type="button" class="dropdown-item text-danger" onclick="confirmDelete('{{ $id }}', '{{ $name }}')">
                        <i class="bx bx-trash"></i> Delete
                    </button>
                </li>
            @endcan
        </ul>
    </div>
@endcanany