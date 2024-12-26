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
                        <h4 class="card-title">Employee Detail</h4>
                        <hr>
                        <table class="table table-bordered">
                            <tr>
                                <th>First Name</th>
                                <td>{{ $emp->fname }}</td>
                            </tr>
                            <tr>
                                <th>Last Name</th>
                                <td>{{ $emp->lname }}</td>
                            </tr>
                            <tr>
                                <th>Mobile</th>
                                <td>{{ $emp->mobile }}</td>
                            </tr>
                            <tr>
                                <th>Date of Birth</th>
                                <td>{{ $emp->dob }}</td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>{{ $emp->email }}</td>
                            </tr>
                            <tr>
                                <th>Address</th>
                                <td>{{ $emp->address }}</td>
                            </tr>
                            <tr>
                                <th>City</th>
                                <td>{{ $emp->city }}</td>
                            </tr>
                            <tr>
                                <th>State</th>
                                <td>{{ $emp->state }}</td>
                            </tr>
                            <tr>
                                <th>Pincode</th>
                                <td>{{ $emp->pincode }}</td>
                            </tr>
                        </table>

                        <a href="{{ url('emp_list') }}" class="btn btn-secondary mt-3">Back to List</a>
                        <a href="{{ url('emp_edit', $emp->id) }}" class="btn btn-primary mt-3">Edit</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@include('layouts.footer')
