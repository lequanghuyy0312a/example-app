@extends('home._layout')
@section('title', 'ComparePrices | List')
@section('content')
<section class="content-header bg-gradient-white shadow py-1">
    <div class="container-fluid">
        <div class="row ">
            <div class="col-sm-6">

                <h1 class="m-0 text-dark">{{__('msg.comparePricesList')}}<i class="text-muted text-md"></i></h1>
            </div><!-- /.col -->

        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</section>
<section class="content my-2">
    <div class="">
        <!-- danh sách comparePrices  -->
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
                    <div class="col-sm-4 pl-0">
                        <div class="form-group">
                            <label>{{__('msg.choosePhase')}}</label>
                            <select class="form-control text-xs select2 select2-primary" data-dropdown-css-class="select2-primary" name="phaseIDSelectionToCompare" id="phaseIDSelectionToCompare" style="width: 30%;" required>
                                <?php $numAdd = 0; ?>
                                @foreach($getDropListPhases as $key => $phase)
                                <option value="{{ $phase->id }}" {{ $loop->last ? 'selected' : '' }}>
                                    {{ ++$numAdd }}/ {{ $phase->name }}
                                </option>
                                @endforeach
                            </select>

                        </div>
                    </div>
                    <div class="col-sm-8 pl-0">
                        <div class="form-group">
                            <label>{{__('msg.chooseProductName')}}</label>

                            <select class="form-control text-xs select2 select2-primary" data-dropdown-css-class="select2-primary" name="productIDSelectionToCompare" id="productIDSelectionToCompare" style="width: 100%;" required>

                            </select>

                        </div>
                    </div>

                </div>
                <table id="comparePricesTable" class="table table-bordered table-striped">
                    <thead style="position: sticky; top:60px; background-color: #fff; z-index: 1;">
                        <tr class="text-center">
                            <th style="width: 1%">
                                {{__('msg.num')}}
                            </th>
                            <th class="address" style="width: 15%">
                                {{__('msg.partnerName')}}
                            </th>

                            <th class="email" style="width: 10%">
                                {{__('msg.orderCode')}}
                            </th>
                            <th class="address" style="width: 10%">
                                {{__('msg.unitPrice')}}
                            </th>
                            <th class="email" style="width: 20%">
                                {{__('msg.description')}}
                            </th>

                            <th class="email" style="width: 30%">
                                {{__('msg.note')}}
                            </th>
                            <th class="address" style="width: 15%">
                                {{__('msg.orderProductName')}}
                            </th>
                        </tr>
                    </thead>

                    <tbody>

                    </tbody>

                </table>
                <div id="loadingIndicator" class="spinner"></div>

            </div>
        </div>
    </div>
    <button id="backToTopBtn" onclick="scrollToTop()">
        <i class="fa-solid fa-circle-chevron-up text-success rounded-circle bg-white text-xl"></i>
        <p class="text-success ">Back to top</p>
    </button>

    <div id="modal-container">
        <div class="modal fade" id="infoModalCompare" tabindex="0" role="dialog" aria-hidden="true" style="z-index:1050; display:none" aria-labelledby="infoUserModalLabel">
            <div class="modal-dialog text-left" role="document">
                <div class="modal-content" style="width: 800px; margin: 30px 0px 30px -70px;">
                    <div class="modal-header bg-navy py-1 m-0  text-uppercase pt-2">
                        <h3 class="card-title mb-1" id="infoUserModalLabel">{{__('msg.infoQuotation')}}</h3>
                        <button type="button" class="close" data-dismiss="modal" area-label="Close">
                            <span aria-hidden="true"><i class="fa fa-close"></i> </span>
                        </button>
                    </div>
                    <div class="modal-body">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-6">
                                <u class="mb-0" id="showPartnerName"></u>
                                <div class="text-xs">
                                    <b> {{__('msg.address')}}:</b> <a class="mb-0" id="showPartnerAddress"></a>
                                </div>
                                <div class="text-xs">
                                    <b> {{__('msg.phone')}}:</b> <a class="mb-0" id="showPartnerContact"></a>
                                </div>
                            </div>
                            <div class="col-2"> </div>
                            <div class="col-4 text-xs">
                                <div class="row">
                                    <a class="col-sm-6"> {{__('msg.quotationNo')}}: </a>
                                    <b class="col-sm-6 text-right" id="showQuotationNo">:</b>
                                </div>
                                <div class="row">
                                    <a class="col-sm-6"> {{__('msg.quotationDate')}}: </a>
                                    <b class="col-sm-6 text-right" id="showQuotationDate">:</b>
                                </div>
                                <div class="row">
                                    <a class="col-sm-6 ">{{__('msg.receivedFrom')}}:</a>
                                    <b class="col-sm-6 text-right" id="showReceivedFrom">:</b>
                                </div>
                            </div>
                        </div>

                        <h3 class="text-center uppercase"> {{__('msg.quotation')}}</h3>
                    </div>
                    <u><b>{{__('msg.savedBy')}} </u></b>: <a id="showSavedBy"></a>

                    <div class="form-group mt-2">
                        <table class="table table-bordered" id="quotationDetailTable">
                            <thead>
                                <tr class=" text-center">
                                    <th style="width: 1%">
                                        {{__('msg.num')}}
                                    </th>
                                    <th class="address" style="width: 10%">
                                        {{__('msg.productCode')}}
                                    </th>
                                    <th class="address" style="width: 30%">
                                        {{__('msg.orderProductName')}}
                                    </th>
                                    <th class="address" style="width: 10%">
                                        {{__('msg.orderCode')}}
                                    </th>
                                    <th class="email" style="width: 20%">
                                        {{__('msg.description')}}
                                    </th>
                                    <th class="address" style="width: 4%">
                                        {{__('msg.unit')}}
                                    </th>
                                    <th class="email" style="width: 10%">
                                        {{__('msg.quantityQuotation')}}
                                    </th>
                                    <th class="address" style="width: 10%">
                                        {{__('msg.unitPrice')}}
                                    </th>
                                    <th class="address" style="width: 5%">
                                        {{__('msg.VAT')}}
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="text-xs">
                            </tbody>
                        </table>
                        <div class="row">
                            <div class="col-sm-6">
                                <u><b>{{__('msg.contact')}} </b></u>: <a id="showQuotationContact"></a>
                            </div>
                            <div class="col-sm-6 ">
                                <div class=" d-flex col-12 m-0 p-0 py-1" style="border-bottom:solid 2px">
                                    <a class="col-4 text-right"> {{__('msg.total')}}</a>
                                    <a class="col-8 text-right" id="showTotal"> </a>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="row ml-0 mt-2">
                                <i class="col-sm-3 px-0">* {{__('msg.placeDelivery')}}</i> <i class="col-sm-9 px-0 px-0" id="showDelivery"></i>
                                <i class="col-sm-3 px-0">* {{__('msg.leadTime')}}</i> <i class="col-sm-9 px-0 px-0" id="showLeadTime"></i>
                                <i class="col-sm-3 px-0">* {{__('msg.termPayment')}}</i> <i class="col-sm-9 px-0 px-0" id="showPayment"></i>
                                <i class="col-sm-3 px-0">* {{__('msg.exchangeRate')}}</i> <i class="col-sm-9 px-0 px-0" id="showExchangeRate"></i>
                                <i class="col-sm-3 px-0">* {{__('msg.validityQuotation')}}</i> <i class="col-sm-9 px-0 px-0" id="showValidity"></i>

                            </div>

                        </div>
                    </div>
                </div>
                    <div class="text-right card-footer">
                        <button data-dismiss="modal" area-label="Close" class="btn btn-secondary">{{__('msg.close')}}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- thêm hoặc sửa comparePrices phát triển -->

@section('scripts-compare-prices')
@include('scripts.script-compare-prices')
@endsection
@push('scripts_fixPushMenu')
<script src="../../dist/js/adminlte.min.js?v=3.2.0"></script>
@endpush
@endsection
