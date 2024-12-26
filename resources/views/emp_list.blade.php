@include('layouts.header')
<!-- CSS Start-->
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
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Home</a></li>
            </ol>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Admin List</h4>
                        <a href="{{ url('emp_registration') }}" class="btn btn-primary">Tambah</a>
                        <script>
                            @if (session('success'))
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success',
                                    text: '{{ session('success') }}',
                                    showConfirmButton: true,
                                    confirmButtonText: 'OK',
                                    timer: 5000
                                });
                            @endif

                            @if (session('error'))
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: '{{ session('error') }}',
                                    showConfirmButton: true,
                                    confirmButtonText: 'OK',
                                    timer: 5000
                                });
                            @endif
                        </script>

                        <div class="table-responsive">
                            <div class="form-group col-md-4 float-right d-flex">
                                <input type="text" class="form-control" id="globalSearchInput" placeholder="Cari Kategori...">
                                <button type="button" class="btn btn-primary ml-2" id="globalSearchButton">
                                    <i class="fas fa-search"></i> Cari
                                </button>
                            </div>

                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Nama</th>
                                        <th>Posisi</th>
                                        <th>Tanggal Dibuat</th>

                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($emp_list->count() > 0)
                                    @foreach($emp_list as $value)
                                    <tr>
                                        {{-- <td>{{$value->user_type}}</td> --}}
                                        <td>{{$value->name}}</td>
                                        <td>
                                            {{ $value->role }}
                                        </td>

                                        <td>{{$value->created_at}}</td>

                                        <td>

                                            <form action="{{ url('emp_delete', $value->id) }}" method="POST" id="delete-form-{{ $value->id }}" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-danger delete-btn" id="delete" data-id="{{ $value->id }}"><i class="far fa-trash-alt"></i></button>
                                            </form>



                                            <a href="{{ url('emp_edit', $value->id) }}" class="btn btn-warning"><i class="far fa-edit"></i></a>

                                            <a href="{{ url('emp_detail', $value->id) }}" class="btn btn-info"><i class="far fa-eye"></i></a>
                                        </td>
                                    </tr>

                                    @endforeach
                                    @else
                                    <tr>
                                        <td colspan="8">No Records Found</td>
                                    </tr>
                                    @endif

                                    <tr id="noDataRow" style="display:none;">
                                        <td colspan="2" style="text-align:center; color: red;">Data tidak ditemukan.</td>
                                    </tr>
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>
<!--**********************************
        Content body end
***********************************-->

@include('layouts.footer')
