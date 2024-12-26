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
                <li class="breadcrumb-item active"><a href="{{ url('emp_edit') }}">Edit</a></li>
            </ol>
        </div>
    </div>

    <div class="col-lg-8 ">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Edit Karyawan</h4>
                <hr>
                <form class="form-group" id="edit_emp" action="{{ url('edit_emp', $emp->id) }}" method="POST">
                    @csrf
                    @method('PUT')

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

                    @if ($emp->status != 1)
                        <div class="form-group">
                            <label for="type">Posisi</label>
                            <select class="form-control" id="type" name="type" required>
                                <option value="">Pilih Posisi</option>
                                <option value="2" {{ $emp->status == 2 ? 'selected' : '' }}>Admin</option>
                                <option value="3" {{ $emp->status == 3 ? 'selected' : '' }}>User</option>
                            </select>
                        </div>
                    @endif

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="fname">Nama Pendek</label>
                            <input type="text" class="form-control" name="fname" id="fname" placeholder="Nama Pendek"
                                   value="{{ $emp->fname }}" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="lname">Nama Lengkap</label>
                            <input type="text" class="form-control" name="lname" id="lname" placeholder="Nama Lengkap"
                                   value="{{ $emp->lname }}" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="mobile">Nomor Handphone</label>
                            <input type="tel" class="form-control" name="mobile" id="mobile"
                                   placeholder="+628-1234-1234" value="{{ $emp->mobile }}" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="dob">Tanggal Lahir</label>
                            <input type="date" class="form-control" name="dob" id="dob" value="{{ $emp->dob }}" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" name="email" id="email" placeholder="Email"
                                   value="{{ $emp->email }}" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="address">Alamat</label>
                        <input type="text" class="form-control" name="address" id="address" placeholder="Alamat"
                               value="{{ $emp->address }}" required>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="city">Kota</label>
                            <input type="text" class="form-control" name="city" id="city" placeholder="Kota"
                                   value="{{ $emp->city }}" required>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="state">Provinsi</label>
                            <input type="text" class="form-control" name="state" id="state" placeholder="Provinsi"
                                   value="{{ $emp->state }}" required>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="pincode">Kode Pos</label>
                            <input type="number" class="form-control" name="pincode" id="pincode" placeholder="Kode Pos"
                                   value="{{ $emp->pincode }}" required>
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
