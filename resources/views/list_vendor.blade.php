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
                <li class="breadcrumb-vendor"><a href="javascript:void(0)">Dashboard</a></li>
                <li class="breadcrumb-vendor active"><a href="javascript:void(0)">Home</a></li>
            </ol>
        </div>
    </div>
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

    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <!-- Sidebar -->
                    <div class="col-md-3">
                        <div class="d-flex justify-content-between align-vendors-center mb-4">
                            <h4><span class="text-body">Vendor List</span></h4>
                            <button type="button" class="btn btn-primary" data-toggle="modal"
                                data-target=".bd-example-modal-lg-vendor">Add Vendor</button>
                        </div>
                        <hr>
                        <div class="mb-3">
                            <input type="text" id="vendorSearch" class="form-control" placeholder="Search vendor...">
                        </div>
                        <hr>
                        <div class="vendor-list">
                            <table id="vendorTable" class="table table-bordered table-hover verticle-middle">
                                <tbody>
                                    @if($list_vendor->count() > 0)
                                    @foreach($list_vendor as $value)
                                    <tr class="vendor-rowid" data-id="{{ $value->id }}"
                                        data-name="{{ $value->vendor_name }}">
                                        <td>
                                            {{-- <a id="get_data">{{$value->vendor_name}}</a> --}}
                                            <a href="#" id="vendor-link" data-id="{{ $value->id }}"
                                                data-name="{{ $value->vendor_name }}">{{ $value->vendor_name
                                                }}</a>
                                        </td>
                                        {{-- <td>{{ $value->vendor_opening_stock}}</td> --}}
                                    </tr>
                                    @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- Main Content -->
                    <div class="col-md-9 vendor-details">
                        <div class="d-flex justify-content-between align-vendors-center mb-4">
                            <h4><span id="vendor_name_view"></span></h4>
                            <div id="data-vendor_id"></div>
                            {{-- <button type="button" id="data-vendor_id"
                                class="btn btn-primary bd-example-modal-lg-edit" data-toggle="modal"
                                data-target="#bd-example-modal-lg-edit">Edit</button> --}}
                        </div>
                        <hr>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <p>Mobile: <span class="text-info" id="vendor_mobile_view"></span></p>
                                <p>GSTIN: <span class="text-info" id="vendor_gstin_view"></span></p>
                            </div>
                            <div class="col-md-6">
                                <p>Email: <span class="text-info" id="vendor_email_view"></span></p>
                                <p>Address: <span class="text-info" id="vendor_address_view"></span></p>
                            </div>
                        </div>
                        <hr>

                        <!-- Transactions Table -->
                        <h5>Transactions</h5>

                        <div class="transaction-list ">
                            <table id="transactionsTable" class="table table-bordered verticle-middle">
                                <thead>
                                    <tr>
                                        <th>Type</th>
                                        <th>Invoice/Ref. No</th>
                                        <th>Name</th>
                                        <th>Date</th>

                                        <th>Amount</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Rows will be appended here by the script -->
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

@include('layouts.vendor_modal')
@include('layouts.vendor_ajax')

<script>
    $(document).ready(function() {
    $('#vendorSearch').on('keyup', function() {
        var value = $(this).val().toLowerCase();
        
        $('#vendorTable tbody tr').filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });
    });
});

</script>

@include('layouts.footer')