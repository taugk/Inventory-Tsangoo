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
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Kategori</a></li>
            </ol>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Kategori List</h4>
                        <a href="{{ url('category_add') }}" class="btn btn-primary mb-2">Tambah</a>
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

                            <table class="table table-striped table-bordered" id="dataTable">
                                <thead>
                                    <tr>
                                        <th>
                                            Jenis Kategori
                                        </th>
                                        <th>
                                            Tanggal Dibuat
                                        </th>

                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @if($cat_list->count() > 0)
                                    @foreach($cat_list as $value)
                                    <tr>
                                        {{-- <td>{{$value->user_type}}</td> --}}
                                        <td>{{$value->name}}</td>

                                        <td>{{$value->created_at}}</td>
                                        <td>
                                            <form action="{{ url('category_delete', $value->id) }}" method="POST" id="delete-form-{{ $value->id }}" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-danger delete-btn" id="delete" data-id="{{ $value->id }}"><i class="far fa-trash-alt"></i></button>
                                            </form>
                                            <button type="button" class="btn btn-warning edit-btn" data-id="{{ $value->id }}" data-name="{{ $value->name }}"><i class="far fa-edit"></i></button>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr>
                                        <td colspan="8">No Records Found</td>
                                    </tr>
                                    @endif
                                </tbody>

                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

  <!-- Modal Edit Kategori -->
  <div class="modal fade" id="editCategoryModal" tabindex="-1" role="dialog" aria-labelledby="editCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="editCategoryForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="editCategoryModalLabel">Edit Kategori</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="editCategoryName">Nama Kategori</label>
                        <input type="text" class="form-control" id="editCategoryName" name="name" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--**********************************
        Content body end
***********************************-->

@include('layouts.footer')
