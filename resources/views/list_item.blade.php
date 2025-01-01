@include('layouts.header')
<!-- CSS Start -->
@include('layouts.css')
<link href="{{asset('assets/plugins/tables/css/datatable/dataTables.bootstrap4.min.css')}}" rel="stylesheet">

@include('layouts.top_navbar')
@include('layouts.left_sidebar')
<!--**********************************
         Content body start
***********************************-->
<div class="content-body">

    <div class="row page-titles mx-0">
        <div class="col p-md-0">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Daftar Barang</a></li>
            </ol>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Daftar Barang</h4>
                        <div class="d-flex justify-content-between mb-3">
                            <a href="{{ url('add_item') }}" class="btn btn-primary">Tambah</a>
                            <div class="d-flex md-3 float-left">
                                <!-- Tombol Import -->
                                <button class="btn btn-success mr-2" id="importButton">
                                    <i class="fa fa-upload"></i> Import
                                </button>

                                <!-- Input File (disembunyikan) -->
                                <form id="importForm" action="{{ url('export_inventory') }}" method="POST" enctype="multipart/form-data" style="display: none;">
                                    @csrf
                                    <input type="file" name="excel_file" id="excelInput" accept=".csv,.xls,.xlsx">
                                </form>

                                <!-- Tombol Export -->
                                <a href="{{ url('emp_export') }}" class="btn btn-info">
                                    <i class="fa fa-download"></i> Export
                                </a>
                            </div>
                        </div>

                        <script>
                            @if (session('success'))
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success',
                                    text: '{{ session('success') }}',
                                    showConfirmButton: true,
                                    confirmButtonText: 'OK',
                                    timer: 5000
                                });
                            @endif

                            @if (session('error'))
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: '{{ session('error') }}',
                                    showConfirmButton: true,
                                    confirmButtonText: 'OK',
                                    timer: 5000
                                });
                            @endif
                        </script>

                            <div class="table-responsive">
                                <div class="form-group col-md-4 float-right d-flex">
                                    <input type="text" class="form-control" id="globalSearchInput" placeholder="Cari Barang...">
                                    <button type="button" class="btn btn-primary ml-2" id="globalSearchButton">
                                        <i class="fas fa-search"></i> Cari
                                    </button>
                                </div>

                                <div class="d-flex align-items-center mb-3">
                                    <form action="{{ url('list_item') }}" method="GET" class="form-inline">
                                        <input type="text" name="date_range" id="date_range" class="form-control mr-3"
                                            placeholder="Pilih rentang tanggal" value="{{ request('date_range') }}">

                                        <button type="submit" class="btn btn-primary" style="float: left">
                                            <i class="fa fa-filter"></i> Filter
                                        </button>
                                    </form>
                                </div>

                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Nama Barang</th>
                                        <th>Gambar</th>
                                        <th>Kategori</th>
                                        <th>Jumlah</th>
                                        <th>Harga</th>
                                        <th>Kadaluarsa</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody loading="lazy">
                                    @if($items->count() > 0)
                                    @foreach($items as $item)
                                    <tr>
                                        <td>{{ $item->name }}</td>
                                        <td><img src="{{ $item->image }}" alt="Image" class="rounded-circle" style="width: 50px; height: 50px; object-fit: cover;" loading="lazy"></td>
                                        <td>{{ $item->category ? $item->category->name : 'Tidak Ada Kategori' }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>Rp{{ number_format($item->price, 2, ',', '.') }}</td>
                                        <td>{{ $item->expiry_date ? $item->expiry_date->format('d-m-Y') : 'Tidak Ada Kadaluarsa' }}</td>
                                        <td>
                                            @if($item->status == 'available')
                                            <span class="badge badge-success">Tersedia</span>
                                            @elseif($item->status == 'not available')
                                            <span class="badge badge-danger">Tidak Tersedia</span>
                                            @elseif ($item->status == 'low stock')
                                            <span class="badge badge-warning">Stok Sedikit</span>
                                            @endif
                                        </td>
                                        <td>
                                            <form action="{{ url('inventory_delete', $item->id) }}" method="POST" id="delete-form-{{ $item->id }}" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-danger delete-btn" id="delete" data-id="{{ $item->id }}"><i class="far fa-trash-alt"></i></button>
                                            </form>
                                            <a href="{{ url('edit_item', $item->id) }}" class="btn btn-warning"><i class="far fa-edit"></i></a>
                                            <a href="{{ url('item_detail', $item->id) }}" class="btn btn-info"><i class="far fa-eye"></i></a>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr>
                                        <td colspan="7" style="text-align:center;">Tidak ada data barang.</td>
                                    </tr>
                                    @endif

                                    <tr id="noDataRow" style="display:none;">
                                        <td colspan="7" style="text-align:center; color: red;">Data tidak ditemukan.</td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="mt-3" style="float:right;">
                                {{ $items->links('pagination::bootstrap-5') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<!--**********************************
        Content body end
***********************************-->

@include('layouts.footer')
