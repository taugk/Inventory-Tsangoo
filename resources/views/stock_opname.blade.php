@include('layouts.header')
@include('layouts.css')
<link href="{{ asset('assets/plugins/tables/css/datatable/dataTables.bootstrap4.min.css') }}" rel="stylesheet">

@include('layouts.top_navbar')
@include('layouts.left_sidebar')

<div class="content-body">

    <div class="row page-titles mx-0">
        <div class="col p-md-0">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Stock Opname</a></li>
            </ol>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Stock Opname</h4>
                        <div class="d-flex justify-content-between mb-3">
                            <a href="{{ url('stock_opname_add') }}" class="btn btn-primary">Tambah Stock Opname</a>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Nama Barang</th>
                                        <th>Stok Sistem</th>
                                        <th>Stok Aktual</th>
                                        <th>Selisih</th>
                                        <th>Catatan</th>
                                        <th>Tanggal</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($stockOpnames->count() > 0)
                                        @foreach($stockOpnames as $stockOpname)
                                        <tr>
                                            <td>{{ $stockOpname->inventory->name }}</td>
                                            <td>{{ $stockOpname->system_stock }}</td>
                                            <td>{{ $stockOpname->actual_stock }}</td>
                                            <td>{{ $stockOpname->difference }}</td>
                                            <td>{{ $stockOpname->notes }}</td>
                                            <td>{{ $stockOpname->created_at->format('Y-m-d') }}</td>
                                            <td>
                                                <form action="{{ url('stock_opname_delete', $stockOpname->id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger"><i class="far fa-trash-alt"></i></button>
                                                </form>
                                                <a href="{{ url('stock_opname_edit', $stockOpname->id) }}" class="btn btn-warning"><i class="far fa-edit"></i></a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    @else
                                    <tr>
                                        <td colspan="7" style="text-align:center;">Tidak ada data stock opname.</td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                            <div class="mt-3" style="float:right;">
                                {{ $stockOpnames->links('pagination::bootstrap-5') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@include('layouts.footer')
