<div class="nk-sidebar">
    <div class="nk-nav-scroll">
        <ul class="metismenu" id="menu">
            <li class="nav-label">{{Session::get('session_user_type')}} - {{Session::get('session_name')}}</li>
            <li>
                <a href="{{url('index')}}" aria-expanded="false">
                    <i class="icon-speedometer menu-icon"></i><span class="nav-text">Dashboard</span>
                </a>
            </li>

            <!-- Inventory Section -->
            @if(Session::get('session_user_type') == 'admin' || Session::get('session_user_type') == 'staff')
            <li class="mega-menu mega-menu-sm">
                <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                    <i class="icon-globe-alt menu-icon"></i><span class="nav-text">Manajemen Stok</span>
                </a>
                <ul aria-expanded="false">

                    <li><a href="{{url('list_item')}}">Daftar Barang</a></li>

                    <li><a href="{{url('list_stock_in')}}">Stok Masuk</a></li>
                    @endif
                    <li><a href="{{url('list_item_out')}}">Stok Keluar</a></li>
                    <li><a href="{{url('stock_opname')}}">Stok Opname</a></li>
                </ul>
                <ul>
                    @if(Session::get('session_user_type') == 'admin')
                    <li><a href="{{url('add_item')}}">Tambah Item</a></li>
                    <li><a href="{{url('category')}}">Kategori Item</a></li>
                    @endif
                </ul>
            </li>
            <!-- Supplier Section -->
            @if(Session::get('session_user_type') == 'admin')
            <li class="mega-menu mega-menu-sm">
                <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                    <i class="icon-user menu-icon"></i><span class="nav-text">Supplier</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{url('add_supplier')}}">Tambah Supplier</a></li>
                    <li><a href="{{url('supp_list')}}">Daftar Supplier</a></li>
                </ul>
            </li>
            @endif

            <!-- Employee Section -->
            @if(Session::get('session_user_type') == 'admin')
            <li class="mega-menu mega-menu-sm">
                <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                    <i class="icon-user menu-icon"></i><span class="nav-text">User</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{url('emp_registration')}}">Tambah User</a></li>
                    <li><a href="{{url('emp_list')}}">Daftar User</a></li>
                </ul>
            </li>
            @endif

            <!-- Reports Section -->
            @if(Session::get('session_user_type') == 'owner')
            <li class="nav-label">Laporan</li>
            <li class="mega-menu mega-menu-sm">
                <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                    <i class="icon-globe-alt menu-icon"></i><span class="nav-text"></span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{url('export')}}">Export</a></li>
                    <li><a href="{{url('import')}}">Import</a></li>
                    <li><a href="{{url('download_pdf')}}">Stock PDF</a></li>
                </ul>
            </li>
            <li class="mega-menu mega-menu-sm">
                <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                    <i class="icon-docs menu-icon"></i><span class="nav-text">Stock Reports</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{url('export_inventory_in')}}">Barang Masuk</a></li>
                    <li><a href="{{url('export_inventory_out')}}">Barang Keluar</a></li>
                </ul>
            </li>
            @endif

            <!-- Logout -->
            <li>
                <a href="{{url('logout')}}" aria-expanded="false">
                    <i class="icon-key"></i><span class="nav-text">Logout</span>
                </a>
            </li>
        </ul>
    </div>
</div>
