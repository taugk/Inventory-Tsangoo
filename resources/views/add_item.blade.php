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
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Barang Masuk</a></li>
            </ol>
        </div>
    </div>

    <div class="container-fluid">
        <div class="col-lg-8 ">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Form Barang Masuk</h4>
                    <hr>
                    <form class="form-group" name="item_entry" id="item_entry" action="{{ url('add_item_entry') }}" method="POST">
                        @csrf
                        @if (Session::has('success'))
                        <div class="alert alert-success">
                            {{ Session::get('success') }}
                        </div>
                        @endif
                        @if (Session::has('fail'))
                        <div class="alert alert-danger">
                            {{ Session::get('fail') }}
                        </div>
                        @endif

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Nama Barang</label>
                                <input type="text" class="form-control input-default" name="name" id="name" placeholder="Nama Barang" required>
                                </div>
                            <div class="form-group col-md-6">
                                <label>Kategori Barang</label>
                                <select class="form-control" id="item_id" name="item_id" required>
                                    <option value="">Pilih Kategori Barang</option>
                                    @foreach($items as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Tanggal Masuk</label>
                                <input type="date" class="form-control input-default" name="entry_date" id="entry_date" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Tanggal Expired</label>
                                <input type="date" class="form-control input-default" name="expired_date" id="expired_date" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Sumber Barang</label>
                                <input type="text" class="form-control" id="source" name="source" placeholder="Ketik nama supplier..." list="supplierList" required>
                                <datalist id="supplierList">
                                    @foreach($suppliers as $supplier)
                                    <option value="{{ $supplier->name }}">{{ $supplier->name }}</option>
                                    @endforeach
                                </datalist>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Jumlah Barang</label>
                                <div class="input-group">
                                    <input type="number" class="form-control input-default" name="quantity" id="quantity" placeholder="Jumlah Barang" required>
                                    <div class="input-group-append">
                                        <select class="form-control" name="unit" id="unit">
                                            <option value="pcs">pcs</option>
                                            <option value="kg">kg</option>
                                            <option value="unit">unit</option>
                                            <!-- Tambahkan opsi satuan lainnya sesuai kebutuhan -->
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label>Harga Beli</label>
                                <input type="text" class="form-control input-default" name="purchase_price" id="purchase_price" placeholder="Harga Beli" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Gambar Barang</label>
                                <input type="file" class="form-control input-default" name="image" id="image" placeholder="Gambar Barang" required>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label>Keterangan</label>
                                <textarea class="form-control" name="notes" id="notes" placeholder="Tambahkan keterangan jika diperlukan"></textarea>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-dark float-right">Simpan</button>
                    </form>

                </div>
            </div>
        </div>

    </div>

</div>
<!--**********************************
        Content body end
***********************************-->

@include('layouts.footer')
