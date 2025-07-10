<div class="vertical-menu" style="background: {{ ($settings['theme'] ?? null) }}">
    <div data-simplebar class="h-100">
        <div id="sidebar-menu">
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title" key="t-menu">Menu</li>
                <li class="{{ request()->is('admin/dashboard') ? 'mm-active' : '' }}"><a href="{{ route('admin.dashboard') }}" class="waves-effect"><i class="bx bxs-dashboard"></i><span key="t-dashboard">Dashboard</span></a></li>
                @canany(['Produk Category (Index)','Produk (Index)'])
                    <li><a href="#" class="has-arrow waves-effect"><i class="bx bx-home-alt"></i><span key="t-produk">Produk</span></a>
                        <ul class="sub-menu" aria-expanded="true">
                            @can('Produk Category (Index)')
                                <li class="{{ request()->is('admin/produk/category') ? 'mm-active' : '' }}"><a href="{{ route('admin.produk.category.index') }}" key="t-produk-category">Category</a></li>
                            @endcan
                            @can('Produk (Index)')
                                <li class="{{ request()->is('admin/produk/produk') ? 'mm-active' : '' }}"><a href="{{ route('admin.produk.produk.index') }}" key="t-produk-produk">Produk</a></li>
                            @endcan
                        </ul>
                    </li>
                @endcanany

                @can('Transaksi (Index)')
                    <li><a href="{{ route('admin.transaksi.transaksi.index') }}" class="waves-effect"><i class="bx bxs-report"></i><span key="t-transaksi">Transaksi</span></a></li>
                @endcan

                @can('Rekening (Index)')
                    <li><a href="{{ route('admin.rekening.index') }}" class="waves-effect"><i class="bx bx-credit-card"></i><span key="t-rekening">Rekening</span></a></li>
                @endcan

                @canany(['User Management User (Index)','User Management Role (Index)','User Management Permission (Index)'])
                    <li><a href="#" class="has-arrow waves-effect"><i class="bx bx-user-check"></i><span key="t-user-management">User Management</span></a>
                        <ul class="sub-menu" aria-expanded="true">
                            @can('User Management User (Index)')
                                <li class="{{ request()->is('admin/user-management/user') ? 'mm-active' : '' }}"><a href="{{ route('admin.user-management.user.index') }}" key="t-user">User</a></li>
                            @endcan
                            @can('User Management Role (Index)')
                                <li class="{{ request()->is('admin/user-management/role') ? 'mm-active' : '' }}"><a href="{{ route('admin.user-management.role.index') }}" key="t-role">Role</a></li>
                            @endcan
                            @can('User Management Permission (Index)')
                                <li class="{{ request()->is('admin/user-management/permission') ? 'mm-active' : '' }}"><a href="{{ route('admin.user-management.permission.index') }}" key="t-permission">Permission</a></li>
                            @endcan
                        </ul>
                    </li>
                @endcanany

                @canany(['Activity Log (Index)','Setting Apps (Index)'])
                    <li class="menu-title" key="t-setting">Setting</li>
                    @can('Activity Log (Index)')
                        <li class="{{ request()->is('admin/activity-log') ? 'mm-active' : '' }}"><a href="{{ route('admin.activity-log.index') }}" class="waves-effect"><i class="bx bxs-report"></i><span key="t-activity-log">Activity Log</span></a></li>
                    @endcan
                    @can('Setting Apps (Index)')    
                        <li class="{{ request()->is('admin/setting') ? 'mm-active' : '' }}"><a href="{{ route('admin.setting.index') }}" class="waves-effect"><i class="bx bx-cog"></i><span key="t-setting-apps">Setting Apps</span></a></li>
                    @endcan
                @endcanany
            </ul>
        </div>
    </div>
</div>
