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
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Barang Keluar</a></li>
            </ol>
        </div>
    </div>

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

    <div class="col-lg-12">
        <div class="card">
            <form name="add_inventory_out" id="add_inventory_out" class="form-horizontal" method="POST" action="{{ url('inventory_out') }}" enctype="multipart/form-data" autocomplete="on">
                {{ csrf_field() }}
                <div class="card-body" style="text-transform:uppercase">
                    <h4 class="card-title">Barang Keluar</h4>
                    <hr>

                    <div class="basic-form">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th class="col-sm-2 pb-2">Item</th>
                                    <th class="col-sm-2 pb-2">Quantity</th>
                                    <th class="col-sm-2 pb-2">Unit</th>
                                    <th class="col-sm-2 pb-2">Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <select class="form-control" name="item_id[]" required>
                                            <option value="">Select Item</option>
                                            @if($items->count() > 0)
                                            @foreach($items as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </td>
                                    <td>
                                        <input type="number" class="form-control" name="quantity[]" min="1" placeholder="Quantity" required>
                                    </td>
                                    <td>
                                        <select class="form-control" name="unit[]" required>
                                            <option value="">Select Unit</option>
                                            <option value="pcs">pcs</option>
                                            <option value="kg">kg</option>
                                            <option value="unit">unit</option>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="date" class="form-control" name="date[]" required>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary float-right">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>
<!--**********************************
        Content body end
***********************************-->

@include('layouts.footer')
