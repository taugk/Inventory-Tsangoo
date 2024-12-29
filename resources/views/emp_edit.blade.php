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
                <li class="breadcrumb-item"><a href="{{ url('index') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ url('emp_list') }}">Karyawan</a></li>
                <li class="breadcrumb-item active"><a href="{{ url('emp_edit', $emp->id) }}">Edit</a></li>
            </ol>
        </div>
    </div>

    <div class="col-lg-8 ">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Edit Karyawan</h4>
                <hr>
                <form class="form-group" name="emp_edit_post" id="emp_edit_post"
                    action="{{ url('emp_edit_post', $emp->id) }}" method="POST" enctype="multipart/form-data">
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

                    <div class="form-row">
                        <div class="form-group col-md-8">
                            <label>Nama Lengkap</label>
                            <input type="text" class="form-control input-default" name="name" id="name"
                                placeholder="Nama Lengkap" value="{{ old('name', $emp->name) }}" required>
                            @error('name')
                                <span class="text-danger" role="alert">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-md-8">
                            <label>Posisi</label>
                            <select class="form-control" id="role" name="role" required>
                                <option value="">Pilih Posisi</option>
                                <option value="admin" {{ old('role', $emp->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="staff" {{ old('role', $emp->role) == 'staff' ? 'selected' : '' }}>Staff</option>
                            </select>
                            @error('role')
                                <span class="text-danger" role="alert">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-md-8">
                            <label>Nomor Handphone</label>
                            <input type="tel" class="form-control input-default" name="phone" id="phone"
                                placeholder="Masukkan Nomor Handphone"
                                pattern="^(\+62|62|0)[8][1-9][0-9]{6,11}$"
                                title="Nomor handphone harus dimulai dengan +62, 62, atau 0, diikuti oleh 8 dan 7-12 digit angka lainnya."
                                value="{{ old('phone', $emp->phone) }}" required>
                            @error('phone')
                                <span class="text-danger" role="alert">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-8">
                            <label>Email</label>
                            <input type="email" class="form-control input-default" name="email" id="email"
                                placeholder="Email" value="{{ old('email', $emp->email) }}" required>
                            @error('email')
                                <span class="text-danger" role="alert">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-8">
                            <label>Foto</label>
                            <div class="mb-2">
                                <img src="{{ $emp->image }}" alt="Foto Karyawan" width="100">
                            </div>
                            <input type="file" class="form-control input-default" name="image" id="image">
                            <small>Biarkan kosong jika tidak ingin mengubah gambar.</small>
                            @error('image')
                                <span class="text-danger" role="alert">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-8">
                            <label>Alamat</label>
                            <input type="text" class="form-control input-default" name="address" id="address"
                                placeholder="Alamat Lengkap" value="{{ old('address', $emp->address) }}" required>
                            @error('address')
                                <span class="text-danger" role="alert">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-8">
                            <label>Kota</label>
                            <input type="text" class="form-control input-default" name="city" id="city"
                                placeholder="Kota" value="{{ old('city', $emp->city) }}" required>
                            @error('city')
                                <span class="text-danger" role="alert">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-md-8">
                            <label>Provinsi</label>
                            <input type="text" class="form-control input-default" name="state" id="state"
                                placeholder="Provinsi" value="{{ old('state', $emp->state) }}" required>
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
