@include('layouts.header')
<!-- CSS Start-->
@include('layouts.css')
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
                <li class="breadcrumb-item active"><a href="{{ url('index') }}">Home</a></li>
                <li class="breadcrumb-item active"><a href="{{ url('supp_list') }}">Supplier</a></li>
                <li class="breadcrumb-item active"><a href="{{ url('add_supplier') }}">Tambah</a></li>
            </ol>
        </div>
    </div>

    <div class="col-lg-8 ">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Tambah Supplier</h4>
                <hr>
                <form class="form-group" name="supplier_registration" id="supplier_registration"
                    action="{{url('store_supplier')}}" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    @if (Session::has('success'))
                    <div class="alert alert-success">
                        {{Session::get('success')}}
                    </div>
                    @endif
                    @if (Session::has('fail'))
                    <div class="alert alert-danger">
                        {{Session::get('fail')}}
                    </div>
                    @endif
                    <div class="form-row">
                        <div class="form-group col-md-8">
                            <label>Nama Supplier</label>
                            <input type="text" class="form-control input-default" name="name" id="name"
                                placeholder="Nama Supplier" required>
                                @error('name')
                                    <span class="text-danger" role="alert">{{ $message }}</span>
                                @enderror
                        </div>
                        <div class="form-group col-md-8">
                            <label>Nomor Handphone</label>
                            <input
                                type="tel"
                                class="form-control input-default @error('contact') is-invalid @enderror"
                                name="contact"
                                id="contact"
                                placeholder="Masukkan Nomor Handphone"
                                pattern="^(\+62|62|0)[8][1-9][0-9]{6,11}$"
                                title="Nomor handphone harus dimulai dengan +62, 62, atau 0, diikuti oleh 8 dan 7-12 digit angka lainnya."
                                required>
                            @error('contact')
                                <span class="text-danger" role="alert">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-8">
                            <label>Email</label>
                            <input type="email" class="form-control input-default" name="email" id="email"
                                placeholder="Email" required>
                                @error('email')
                                    <span class="text-danger" role="alert">{{ $message }}</span>
                                @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-8">
                            <label>Alamat</label>
                            <input type="text" class="form-control input-default" name="address" id="address"
                                placeholder="Alamat Lengkap" required>
                                @error('address')
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
<!--**********************************
        Content body end
***********************************-->

@include('layouts.footer')
