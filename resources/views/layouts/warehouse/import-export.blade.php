@extends('home._layout')
@section('title', 'Partner | List')
@section('content')
<section class="content-header bg-gradient-white shadow py-1">
    <div class="container-fluid">
        <div class="row ">
            <div class="col-sm-6">

                <h1 class="m-0 text-dark">{{__('msg.importExportList')}}<i class="text-muted text-md">( 3...)</i></h1>
            </div><!-- /.col -->

        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</section>
<section class="content my-2">
    <div class="">
        <!-- danh sách partner  -->
        <div class="card">
            <div class="card-header bg-white pb-0">
                </h3>
            </div>
            <div class="card-body p-2 mt-2">
                @if(session()->has('success'))
                <div class="alert alert-success" id="success-alert">
                    {{ session('success') }}
                </div>
                @elseif($errors->has('error'))
                <div class="alert alert-danger" id="danger-alert">
                    {{ $errors->first('error') }}
                </div>
                @endif
                <div class="col-12 row p-0 m-0 justify-content-end" style="position: sticky; top:0px; background-color: #fff; z-index: 1;">
                    <div class="col-sm-6 pl-0">
                        <div class="form-group">
                            <select class="form-control select2 select2-primary" data-dropdown-css-class="select2-primary" name="typePartner" id="typePartner" style="width: 30%;" required>
                                <option selected value="1"> 1. {{__('msg.import')}} </option>
                                <option selected value="2"> 2. {{__('msg.export')}} </option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-6 pr-0 ">
                        <div class="input-group mb-2">
                            <input class="form-control" type="text" id="searchInput" placeholder="Search">
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fas fa-search"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <table id="importExportTable" class="table table-bordered table-striped">
                        <thead style="position: sticky; top:60px; background-color: #fff; z-index: 1;">
                            <tr class="text-center">
                                <th style="width: 1%">
                                    {{__('msg.num')}}
                                </th>
                                <th style="width: 10%">
                                    {{__('msg.productCode')}}
                                </th>
                                <th style="width: 10%">
                                    {{__('msg.originalProductName')}}
                                </th>
                                <th style="width: 10%">
                                    {{__('msg.quantity')}}
                                </th>
                                <th style="width: 10%">
                                    {{__('msg.ratio')}}
                                </th>
                                <th style="width: 10%">
                                    {{__('msg.unit')}}
                                </th>
                                <th style="width: 38%">
                                    {{__('msg.partnerName')}}
                                </th>
                                <th style="width: 10%">
                                    {{__('msg.createdOnUTC')}}
                                </th>
                                <th style="position: sticky; right:0px; width: 1%" class="text-center">
                                    <a href="/partner-add-form" class="btn btn-success btn-sm col " data-toggle="modal" data-target="#AddForm">
                                        <i class="fas fa-plus"></i> </a>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $num = 0;  ?>
                            @foreach($getStocks as $stock)
                            <tr>
                                <td class="text-center "> {{ ++$num }} </td>
                                <td class="text-center gmail"> {{ $stock->product_code }} </td>
                                <td class="text-center address"> {{ $stock->product_name }} </td>
                                <td class="text-center gmail"> {{ $stock->quantity }} </td>
                                <td class="text-center gmail"> {{ $stock->PONo }} </td>
                                <td class="text-center address"> {{ $stock->partner_name }} </td>
                                <td class="text-center gmail"> {{ $stock->PONo }} </td>
                                <td class="text-center gmail"> {{ $stock->createdBy }} </td>
                                <td class="text-center address"> format {{ $stock->createdOnUTC }} </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <button id="backToTopBtn" onclick="scrollToTop()">
        <i class="fa-solid fa-circle-chevron-up text-success rounded-circle bg-white text-xl"></i>
        <p class="text-success ">Back to top</p>
    </button>
</section>
<!-- thêm hoặc sửa partner phát triển -->




@section('scripts-partner')
@include('scripts.script-partner')
@endsection
@push('scripts_fixPushMenu')
<script src="../../dist/js/adminlte.min.js?v=3.2.0"></script>
@endpush
@endsection
