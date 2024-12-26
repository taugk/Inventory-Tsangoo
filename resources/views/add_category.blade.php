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
                <li class="breadcrumb-item active"><a href="{{ url('category_list') }}">Kategori</a></li>
                <li class="breadcrumb-item active"><a href="{{ url('category_add') }}">Tambah Kategori</a></li>
            </ol>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Tambah Kategori</h4>
                <hr>
                <form class="form-group" name="category_add" id="category_add" action="{{url('category')}}" method="POST">
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
                        <div class="form-group col-md-12">
                            <label>Nama Kategori</label>
                            <input type="text" class="form-control input-default" name="name" id="name"
                                placeholder="Masukkan Nama Kategori" required>
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
