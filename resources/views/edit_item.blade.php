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
                <li class="breadcrumb-item"><a href="javascript:void(0)">Manajemen Stok</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Daftar Stok</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0)">Edit Barang</a></li>
            </ol>
        </div>
    </div>

    <div class="container-fluid">
        <div class="col-lg-8 ">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Form Edit Barang</h4>
                    <hr>
                    <form class="form-group" name="edit_item" id="edit_item" action="{{ route('edit_item_post', $items->id) }}"
                        method="POST" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
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
                                <input type="text" class="form-control input-default" name="name" id="name" placeholder="Nama Barang" value="{{ old('name', $items->name) }}" required>
                                @error('name')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label>Kategori Barang</label>
                                <select class="form-control" id="category_id" name="category_id" required>
                                    <option value="">Pilih Kategori Barang</option>
                                    @foreach($category as $cat)
                                        <option value="{{ $cat->id }}"
                                            {{ old('category_id', $items->category_id) == $cat->id ? 'selected' : '' }}>
                                            {{ $cat->name }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('category_id')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label>Tanggal Masuk</label>

                                <input type="date" class="form-control input-default" name="entry_date" id="entry_date"
                                value="{{ old('entry_date', $items->entry_date ? date('Y-m-d', strtotime($items->entry_date)) : null) }}" required>
                                @error('entry_date')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label>Tanggal Expired</label>
                                <input type="date" class="form-control input-default" name="expiry_date" id="expiry_date"
                                value="{{ old('expiry_date', $items->expiry_date ? date('Y-m-d', strtotime($items->expiry_date)) : null) }}" required>
                                @error('expiry_date')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label>Sumber Barang</label>
                                <input type="text" class="form-control" id="supplier_name" name="supplier_name"
                                    placeholder="Ketik nama supplier..." list="supplierList"
                                    value="{{ old('supplier_name', $items->supplier->name ?? '') }}" required>

                                <input type="hidden" id="supplier_id" name="supplier_id"
                                    value="{{ old('supplier_id', $items->supplier_id) }}">

                                <datalist id="supplierList">
                                    @foreach($supplier as $sup)
                                        <option value="{{ $sup->name }}" data-id="{{ $sup->id }}">
                                    @endforeach
                                </datalist>

                                @error('supplier_name')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="form-group col-md-6">
                                <label>Jumlah Barang</label>
                                <div class="input-group">
                                    <input type="number" class="form-control input-default" name="quantity" id="quantity" placeholder="Jumlah Barang" value="{{ old('quantity', $items->quantity) }}" required>
                                    <div class="input-group-append">
                                        <select class="form-control" name="unit" id="unit">
                                            <option value="pcs" {{ old('unit', $items->unit) == 'pcs' ? 'selected' : '' }}>pcs</option>
                                            <option value="kg" {{ old('unit', $items->unit) == 'kg' ? 'selected' : '' }}>kg</option>
                                            <option value="unit" {{ old('unit', $items->unit) == 'unit' ? 'selected' : '' }}>unit</option>
                                        </select>
                                    </div>
                                </div>
                                @error('quantity')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label>Harga Beli</label>
                                <input type="number" class="form-control input-default" name="purchase_price" id="purchase_price"
                                       placeholder="Harga Beli" value="{{ old('price', $items->price) }}" required>
                                @error('purchase_price')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label>Keterangan</label>
                                <textarea class="form-control" name="description" id="description"
                                placeholder="Tambahkan keterangan jika diperlukan">{{ old('description', $items->description) }}</textarea>
                                @error('description')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Gambar Barang</label>
                                <div class="mb-2">
                                    <img src="{{ $items->image }}" alt="Foto Barang" width="100">
                                </div>
                                <input type="file" class="form-control input-default" name="image" id="image">
                                <small>Biarkan kosong jika tidak ingin mengubah gambar.</small>
                                @error('image')
                                    <span class="text-danger" role="alert">{{ $message }}</span>
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
