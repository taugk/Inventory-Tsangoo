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
                <li class="breadcrumb-item active"><a href="{{ url('emp_list') }}">Karyawan</a></li>
                <li class="breadcrumb-item active"><a href="{{ url('emp_registration') }}">Tambah</a></li>
            </ol>
        </div>
    </div>

    <div class="col-lg-8 ">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Tambah Karyawan</h4>
                <hr>
                <form class="form-group" name="emp_registration" id="emp_registration"
                    action="{{url('emp_registration')}}" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}
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
                            <label>Nama Lengkap</label>
                            <input type="text" class="form-control input-default" name="name" id="name"
                                placeholder="Nama Lengkap" required>
                                @error('name')
                                    <span class="text-danger" role="alert">{{ $message }}</span>
                                @enderror
                        </div>
                        <div class="form-group col-md-8">
                            <label>Posisi</label>
                            <select class="form-control" id="role" name="role" required>
                                <option value="">Pilih Poisi</option>
                                <option value="admin">Admin</option>
                                <option value="staff">Staff</option>
                            </select>
                            @error('role')
                                    <span class="text-danger" role="alert">{{ $message }}</span>
                                @enderror
                        </div>
                        <div class="form-group col-md-8">
                            <label>Nomor Handphone</label>
                            <input
                                type="tel"
                                class="form-control input-default @error('phone') is-invalid @enderror"
                                name="phone"
                                id="phone"
                                placeholder="Masukkan Nomor Handphone"
                                pattern="^(\+62|62|0)[8][1-9][0-9]{6,11}$"
                                title="Nomor handphone harus dimulai dengan +62, 62, atau 0, diikuti oleh 8 dan 7-12 digit angka lainnya."
                                required>
                            @error('phone')
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
                        <div class="form-group col-md-8">
                            <label>Password</label>
                            <input type="password" class="form-control input-default" name="password" id="password"
                                placeholder="Password" required>
                                @error('password')
                                    <span class="text-danger" role="alert">{{ $message }}</span>
                                @enderror
                        </div>

                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-8">
                            <label>Foto</label>
                            <input type="file" class="form-control input-default" name="image" id="image" placeholder="Foto" required>
                            @error('image')
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
                    <div class="form-row">
                        <div class="form-group col-md-8">
                            <label>Kota</label>
                            <input type="text" class="form-control input-default" name="city" id="city"
                                placeholder="Kota" required>
                                @error('city')
                                    <span class="text-danger" role="alert">{{ $message }}</span>
                                @enderror
                        </div>
                        <div class="form-group col-md-8">

                            <label>Provinsi</label>
                            <input type="text" class="form-control input-default" name="state" id="state"
                                placeholder="Provinsi" required>
                                @error('state')
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
