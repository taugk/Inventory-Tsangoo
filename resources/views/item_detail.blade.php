@include('layouts.header')
@include('layouts.css')
@include('layouts.top_navbar')
@include('layouts.left_sidebar')

<div class="content-body">

    <div class="row page-titles mx-0">
        <div class="col p-md-0">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                <li class="breadcrumb-item active"><a href="{{ url('index') }}">Home</a></li>
                <li class="breadcrumb-item active"><a href="{{ url('item_list') }}">Barang</a></li>
                <li class="breadcrumb-item active"><a href="{{ url('item_detail') }}">Detail Barang</a></li>
            </ol>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Detail Barang</h4>
                        <hr>
                        <table class="table table-bordered">
                            <tr>
                                <th>Nama Barang</th>
                                <td>{{ $item->name }}</td>
                            </tr>
                            <tr>
                                <th>Kategori</th>
                                <td>{{ $item->category->name }}</td> <!-- Assuming you have category relationship -->
                            </tr>
                            <tr>
                                <th>Supplier</th>
                                <td>{{ $item->supplier->name }}</td> <!-- Assuming you have supplier relationship -->
                            </tr>
                            <tr>
                                <th>Harga Beli</th>
                                <td>Rp{{ number_format($item->price, 2, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <th>Jumlah</th>
                                <td>{{ $item->quantity }}</td>
                            </tr>
                            <tr>
                                <th>Tanggal Masuk</th>
                                <td>{{ \Carbon\Carbon::parse($item->entry_date)->format('d-m-Y') }}</td>
                            </tr>
                            <tr>
                                <th>Tanggal Expired</th>
                                <td>{{ \Carbon\Carbon::parse($item->expiry_date)->format('d-m-Y') }}</td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>
                                    @if ($item->status == 'available')
                                        <span class="badge badge-success">Tersedia</span>
                                        @elseif ($item->status == 'not available')
                                        <span class="badge badge-danger">Tidak Tersedia</span>
                                        @elseif ($item->status == 'low stock')
                                        <span class="badge badge-warning">Stok Sedikit</span>
                                        @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Deskripsi</th>
                                <td>{{ $item->description }}</td>
                            </tr>
                            <tr>
                                <th>Gambar</th>
                                <td>
                                    <img src="{{ $item->image }}" alt="Item Image" class="rounded" style="width: 100px; height: 100px; object-fit: cover;">
                                </td>
                            </tr>
                        </table>
                        <a href="{{ url('item_list') }}" class="btn btn-secondary mt-3"><i class="fas fa-arrow-left"></i> Kembali</a>
                        <a href="{{ url('item_edit', $item->id) }}" class="btn btn-primary mt-3" style="float: right"><i class="far fa-edit"></i> Edit</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@include('layouts.footer')
