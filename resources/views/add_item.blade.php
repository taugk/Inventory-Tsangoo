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
                    <form class="form-group" name="item_entry" id="item_entry" action="{{ url('add_item_entry') }}" method="POST" enctype="multipart/form-data">
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
                                <input type="text" class="form-control input-default" name="name" id="name" placeholder="Nama Barang" value="{{ old('name') }}" required>
                                @error('name')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label>Kategori Barang</label>
                                <select class="form-control" id="category_id" name="category_id" required>
                                    <option value="">Pilih Kategori Barang</option>
                                    @foreach($items as $item)
                                    <option value="{{ $item->id }}" {{ old('category_id') == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label>Tanggal Masuk</label>
                                <input type="date" class="form-control input-default" name="entry_date" id="entry_date" value="{{ old('entry_date') }}" required>
                                @error('entry_date')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label>Tanggal Expired</label>
                                <input type="date" class="form-control input-default" name="expiry_date" id="expiry_date" value="{{ old('expiry_date') }}" required>
                                @error('expiry_date')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label>Sumber Barang</label>
                                <input type="text" class="form-control" id="supplier_name" name="supplier_name" placeholder="Ketik nama supplier..." list="supplierList" value="{{ old('supplier_name') }}" required>
                                <!-- Hidden field untuk supplier_id yang akan di-submit -->
                                <input type="hidden" id="supplier_id" name="supplier_id" value="{{ old('supplier_id') }}">
                                <datalist id="supplierList">
                                    @foreach($suppliers as $supplier)
                                    <option value="{{ $supplier->name }}" data-id="{{ $supplier->id }}">
                                    @endforeach
                                </datalist>
                                @error('supplier_name')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="form-group col-md-6">
                                <label>Jumlah Barang</label>
                                <div class="input-group">
                                    <input type="number" class="form-control input-default" name="quantity" id="quantity" placeholder="Jumlah Barang" value="{{ old('quantity') }}" required>
                                    <div class="input-group-append">
                                        <select class="form-control" name="unit" id="unit">
                                            <option value="pcs" {{ old('unit') == 'pcs' ? 'selected' : '' }}>pcs</option>
                                            <option value="kg" {{ old('unit') == 'kg' ? 'selected' : '' }}>kg</option>
                                            <option value="unit" {{ old('unit') == 'unit' ? 'selected' : '' }}>unit</option>
                                        </select>
                                    </div>
                                </div>
                                @error('quantity')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label>Harga Beli</label>
                                <input type="number" class="form-control input-default" name="purchase_price" id="purchase_price" placeholder="Harga Beli" value="{{ old('purchase_price') }}" required>
                                @error('purchase_price')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label>Gambar Barang</label>
                                <input type="file" class="form-control input-default" name="image" id="image" accept="image/jpeg, image/jpg, image/png, image/gif" required>
                                @error('image')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label>Keterangan</label>
                                <textarea class="form-control" name="description" id="description" placeholder="Tambahkan keterangan jika diperlukan">{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
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
