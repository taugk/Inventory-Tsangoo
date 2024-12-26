<div class="nk-sidebar">
    <div class="nk-nav-scroll">
        <ul class="metismenu" id="menu">
            <li class="nav-label">{{Session::get('session_user_type')}} - {{Session::get('session_name')}}</li>
            <li>
                <a href="{{url('index')}}" aria-expanded="false">
                    <i class="icon-speedometer menu-icon"></i><span class="nav-text">Dashboard</span>
                </a>
            </li>
            <li class="mega-menu mega-menu-sm">
                <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                    <i class="icon-globe-alt menu-icon"></i><span class="nav-text">Inventory</span>
                </a>
                <ul aria-expanded="false">
                    <!-- Submenu Stok -->
                    <li class="submenu">
                        <a href="javascript:void()" class="has-arrow" aria-expanded="false"><i class="icon-bag menu-icon"> </i> Stok</a>
                        <ul aria-expanded="false">
                            <li><a href="{{url('list_item')}}">Daftar Stok</a></li>
                            <li><a href="{{url('add_item')}}">Stok Masuk</a></li>
                            <li><a href="{{url('barang_keluar')}}">Stok Keluar</a></li>
                            <li><a href="{{url('stok_opname')}}">Stok Opname</a></li>
                            <li><a href="{{url('stok_terbuang')}}">Stok Terbuang</a></li>
                        </ul>
                    </li>

                    <!-- Submenu Pembelian Stok -->
                    <li><a href="{{url('pembelian_stok')}}">Pembelian Stok</a></li>


                    <!-- Submenu Produksi Stok -->
                    <li><a href="{{url('produksi_stok')}}">Produksi Stok</a></li>



                    <!-- Menu lainnya di Inventory -->
                    <li><a href="{{url('add_item')}}">Tambah Item</a></li>
                    <li><a href="{{url('category')}}">Kategori Item</a></li>
                </ul>
            </li>
            <li class="nav-label">Apps</li>
            <li class="mega-menu mega-menu-sm">
                <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                    <i class="icon-globe-alt menu-icon"></i><span class="nav-text">Sale</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{url('add_sale')}}">Sales Order</a></li>
                    <li><a href="{{url('list_sale')}}">Sales List</a></li>
                    <li><a href="{{url('list_customer')}}">Customer List</a></li>
                </ul>
            </li>
            <li class="mega-menu mega-menu-sm">
                <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                    <i class="icon-globe-alt menu-icon"></i><span class="nav-text">Purchase</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{url('add_purchase')}}">Purchase Order</a></li>
                    <li><a href="{{url('list_purchase')}}">Purchase List</a></li>
                    <li><a href="{{url('list_vendor')}}">Vendor List</a></li>
                </ul>
            </li>
            <li class="mega-menu mega-menu-sm">
                <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                    <i class="icon-user menu-icon"></i><span class="nav-text">Employee</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{url('emp_registration')}}">Employee Create</a></li>
                    <li><a href="{{url('emp_list')}}">Employee List</a></li>
                </ul>
            </li>
            <li class="nav-label">Reports</li>
            <li class="mega-menu mega-menu-sm">
                <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                    <i class="icon-globe-alt menu-icon"></i><span class="nav-text">Import / Export</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{url('export')}}">Export</a></li>
                    <li><a href="{{url('import')}}">Import</a></li>
                    <li><a href="{{url('download_pdf')}}">Stock PDF</a></li>
                </ul>
            </li>
            <li>
                <a href="{{url('logout')}}" aria-expanded="false">
                    <i class="icon-key"></i><span class="nav-text">Logout</span>
                </a>
            </li>
        </ul>
    </div>
</div>
