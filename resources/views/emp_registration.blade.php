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
                    action="{{url('emp_registration')}}" method="POST">
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
                        <div class="form-group col-md-3">
                            <label>Posisi</label>
                            <select class="form-control" id="type" name="type" required>
                                <option value="">Pilih Poisi</option>
                                <option value="2">Admin</option>
                                <option value="3">User</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label>Nama Lengkap</label>
                            <input type="text" class="form-control input-default" name="lname" id="lname"
                                placeholder="Nama Lengkap" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label>Nomor Handphone</label>
                            <input type="tel" class="form-control input-default" name="mobile" id="mobile"
                                placeholder="+628-1234-1234" required>
                        </div>
                        <div class="form-group col-md-4">
                            <label>Tanggal Lahir</label>
                            <input type="date" class="form-control input-default" name="dob" id="dob" placeholder="Tanggal Lahir"
                                required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label>Email</label>
                            <input type="email" class="form-control input-default" name="email" id="email"
                                placeholder="Email" required>
                        </div>
                        <div class="form-group col-md-4">
                            <label>Password</label>
                            <input type="password" class="form-control input-default" name="pwd" id="pwd"
                                placeholder="Password" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-8">
                            <label>Alamat</label>
                            <input type="text" class="form-control input-default" name="address" id="address"
                                placeholder="Alamat Lengkap" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label>Kota</label>
                            <input type="text" class="form-control input-default" name="city" id="city"
                                placeholder="Kota" required>
                        </div>
                        <div class="form-group col-md-4">
                            <label>Provinsi</label>
                            <input type="text" class="form-control input-default" name="state" id="state"
                                placeholder="Provinsi" required>
                        </div>
                        <div class="form-group col-md-4">
                            <label>Kode Pos</label>
                            <input type="number" class="form-control input-default" name="pincode" id="pincode"
                                placeholder="Kode Pos" pattern="[0-9]{6}" maxlength="6" required>
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
