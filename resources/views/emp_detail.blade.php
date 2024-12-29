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
                <li class="breadcrumb-item active"><a href="{{ url('emp_list') }}">Karyawan</a></li>
                <li class="breadcrumb-item active"><a href="{{ url('emp_detail') }}">Detail</a></li>
            </ol>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Detail Karyawan</h4>
                        <hr>
                        <table class="table table-bordered">
                            <tr>
                                <th>Nama</th>
                                <td>{{ $emp->name }}</td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>{{ $emp->email }}</td>
                            </tr>
                            <tr>
                                <th>Nomor Handphone</th>
                                <td>{{ $emp->phone }}</td>
                            </tr>
                            <tr>
                                <th>Alamat</th>
                                <td>{{ $emp->address }}</td>
                            </tr>
                            <tr>
                                <th>Kota</th>
                                <td>{{ $emp->city }}</td>
                            </tr>
                            <tr>
                                <th>Provinsi</th>
                                <td>{{ $emp->state }}</td>
                            </tr>
                            <tr>
                                <th></th>
                                <td>
                                    <img src="{{ $emp->image }}" alt="" srcset="" class="rounded-circle" style="width: 100px; height: 100px; object-fit: cover;">
                                </td>
                            </tr>
                        </table>
                        <a href="{{ url('emp_list') }}" class="btn btn-secondary mt-3"><i class="fas fa-arrow-left"></i></a>
                        <a href="{{ url('emp_edit', $emp->id) }}" class="btn btn-primary mt-3" style="float: right"><i class="far fa-edit"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@include('layouts.footer')
