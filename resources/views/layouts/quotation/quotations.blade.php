@extends('home._layout')
@section('title', 'Quotation | List')
@section('content')
<section class="content-header bg-gradient-orange shadow py-1">
    <div class="container-fluid">
        <div class="row ">
            <div class="col-sm-6">

                <h1 class="m-0 text-dark">{{__('msg.quotationList')}}<i class="text-muted text-md">( {{ $countQuotations }} quotations )</i></h1>
            </div><!-- /.col -->

        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</section>


<section class="content my-2">
    <div class="">
        <!-- danh sách quotation  -->
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
                            <select class="form-control text-xs select2 select2-primary select2-quotation-phaseIDSelectionToQuotation" data-dropdown-css-class="select2-primary" name="phaseIDSelectionToQuotation" id="phaseIDSelectionToQuotation" style="width: 30%;" required>
                                <?php $numAdd = 0; ?>
                                @foreach($getDropListPhases as $key => $phase)
                                <option value="{{ $phase->id }}" {{ $loop->last ? 'selected' : '' }}>
                                    {{ ++$numAdd }}/ {{ $phase->name }}
                                </option>
                                @endforeach
                            </select>

                        </div>
                    </div>
                    <div class="col-sm-6 pr-0 ">
                        <div class="input-group mb-2">
                            <input class="form-control text-xs" type="text" id="searchInput" placeholder="Search">
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fas fa-search"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
                <table id="quotationTable" class="table table-bordered table-striped">
                    <thead style="position: sticky; top:60px; background-color: #fff; z-index: 1;">
                        <tr class="text-center">
                            <th style="width: 1%">
                                {{__('msg.num')}}
                            </th>
                            <th class="address" style="width: 5%">
                                {{__('msg.phase')}}
                            </th>
                            <th class="address" style="width: 23%">
                                {{__('msg.partnerName')}}
                            </th>
                            <th class="email" style="width: 10%">
                                {{__('msg.quotationNo')}}
                            </th>
                            <th class="email" style="width: 10%">
                                {{__('msg.quotationDate')}}
                            </th>
                            <th class="address" style="width: 15%">
                                {{__('msg.validityQuotation')}}
                            </th>
                            <th class="email" style="width: 15%">
                                {{__('msg.savedOnUTC')}}
                            </th>
                            <th class="email" style="width: 10%">
                                {{__('msg.approve')}}
                            </th>
                            <th class="email" style="width: 10%">
                                {{__('msg.note')}}
                            </th>
                            <th style="position: sticky; right:0px; width: 1%" class="text-center">
                                <a class="btn bg-orange btn-sm col quotation-btn-add">
                                    <i class="fas fa-plus"></i> </a>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="text-xs">
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
</section>
<!-- thêm hoặc sửa quotation phát triển -->

<!-- ADD -->
<div id="modal-container">
    <div class="modal fade" id="addModalQuotation" tabindex="0" role="dialog" aria-hidden="true" style="z-index:1050; display:none" aria-labelledby="addUserModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content" style="width: 1080px;  margin: 30px 0px 30px -300px;">
                <div class="modal-header bg-orange py-1 m-0 pt-2">
                    <h3 class="card-title" id="addUserModalLabel">{{__('msg.addNewQuotation')}}</h3>
                    <button type="button" class="close" data-dismiss="modal" area-label="Close">
                        <span aria-hidden="true"><i class="fa fa-close"></i> </span>
                    </button>
                </div>

                <form action="{{route('quotation-add-submit')}}" method="post">
                    @csrf
                    <div class="modal-body  text-xs  " style="max-height: 620px;overflow-y: auto;">
                        <div class="form-group">
                            <label class="mb-0 text-primary">1. {{__('msg.choosenPartner')}}</label>
                            <select class="form-control text-xs select2 select2-primary " data-dropdown-css-class="select2-primary" name="partnerIDQuotationAdd" id="partnerIDQuotationAdd" style="width: 100%;" required>
                            </select>
                        </div>
                        <input class="form-control text-xs" name="hiddenPhaseID" id="hiddenPhaseID" hidden>
                        <div class="form-group" style=" background-color: #f7f7f7;">
                            <table class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th style="width: 10%" class="text-center">{{__('msg.productCode')}}</th>
                                        <th style="width: 30%" class="text-center">{{__('msg.orderProductName')}}</th>
                                        <th style="width: 10%" class="text-center">{{__('msg.orderCode')}}</th>
                                        <th style="width: 20%" class="text-center">{{__('msg.description')}}</th>
                                        <th style="width: 6%" class="text-center">{{__('msg.unit')}}</th>
                                        <th style="width: 9%" class="text-center">{{__('msg.quantity')}}</th>
                                        <th style="width: 9%" class="text-center">{{__('msg.unitPrice')}}</th>
                                        <th style="width: 6%" class="text-center">{{__('msg.VAT')}}</th>
                                        <th style="width: 1%" class="text-center px-1">
                                            <a class="btn btn-add-row text-success p-0 m-0" id="addRowBtnQuotation">
                                                <i class="fa-solid fa-plus"></i>
                                            </a>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody id="dynamicRowsContainerQuotation">
                                    <tr class="dynamic-row-quotation text-xs">
                                        <td class="px-1 text-xs">
                                            <select hidden class="form-control text-xs select2-danger" data-dropdown-css-class="select2-danger" id="productIDAdd" name="productIDAdd[]" style="width: 100%;">
                                                <option value="0" disabled selected> ... </option>
                                            </select>
                                        </td>
                                        <td class="px-1 text-xs">
                                            <input hidden class="form-control text-xs p-0 px-1" name="orderProductNameAdd[]" />
                                        </td>
                                        <td class="px-1 text-xs">
                                            <input hidden class="form-control text-xs p-0 px-1" name="orderCodeAdd[]" />
                                        </td>
                                        <td class="px-1 text-xs">
                                            <input hidden class="form-control text-xs p-0 px-1" name="descriptionAdd[]" />
                                        </td>
                                        <td class="px-1 text-xs">
                                            <input hidden class="form-control text-xs p-0 px-1" name="unitAdd[]" />
                                        </td>
                                        <td class="px-1 text-xs">
                                            <input hidden class="form-control text-xs p-0 px-1" oninput="formatInput(this)" name="quantityAdd[]" />
                                        </td>
                                        <td class="px-1 text-xs">
                                            <input hidden class="form-control text-xs p-0 px-1 " oninput="formatInput(this)" name="unitPriceAdd[]" />
                                        </td>
                                        <td class="px-1 text-xs">
                                            <input hidden class="form-control text-xs p-0 px-1 " type="number" min="0" step="any" name="VATAdd[]" />
                                        </td>
                                        <td class="text0center  px-1">
                                            <a hidden class="btn btn-remove-row text-danger p-0 m-0 pt-2">
                                                <i class="fa-solid fa-xmark"></i>
                                            </a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="row">
                            <div class="form-group col-sm-4">
                                <label class="mb-0">2. {{__('msg.quotationNo')}}</label>
                                <input class="form-control text-xs" name="quotationNoAdd" id="quotationNoAdd" required>
                            </div>

                            <div class="form-group col-sm-4">
                                <label class="mb-0">3. {{__('msg.receivedFrom')}}</label>
                                <input class="form-control text-xs" name="receivedFromAdd" id="receivedFromAdd" required>
                            </div>
                            <div class="form-group col-sm-4">
                                <label class="mb-0">4. {{__('msg.contact')}}</label>
                                <input class="form-control text-xs" name="contactAdd" id="contactAdd" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-sm-4 py-0">
                                <label class="mb-0">5. {{__('msg.quotationDate')}}</label>
                                <div class="input-group date my-0" id="reservationdate" data-target-input="nearest">
                                    <input type="text" name="quotationDateAdd" id="quotationDateAdd" required class="form-control text-xs datetimepicker-input" data-target="#reservationdate" />
                                    <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-sm-4">
                                <label class="mb-0">6. {{__('msg.validityQuotation')}}</label>
                                <input class="form-control text-xs" name="validityDateAdd" id="validityDateAdd" required>
                            </div>
                            <div class="form-group col-sm-4">
                                <label class="mb-0">7. {{__('msg.savedBy')}}</label>
                                <input class="form-control text-xs" name="savedByAdd" id="savedByAdd" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-sm-6">
                                <label class="mb-0">8. {{__('msg.exchangeRate')}}</label>
                                <textarea class="form-control text-xs" name="exchangeRateAdd" id="exchangeRateAdd" required></textarea>
                            </div>
                            <div class="form-group col-sm-6">
                                <label class="mb-0">9. {{__('msg.termPayment')}}</label>
                                <textarea class="form-control text-xs" name="termPaymentAdd" id="termPaymentAdd" required></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-sm-6 py-0">
                                <label class="mb-0">10. {{__('msg.placeDelivery')}}</label>
                                <textarea class="form-control text-xs" name="placeDeliveryAdd" id="placeDeliveryAdd" required></textarea>
                            </div>
                            <div class="form-group col-sm-6">
                                <label class="mb-0">11. {{__('msg.leadTime')}}</label>
                                <textarea class="form-control text-xs" name="leadTimeAdd" id="leadTimeAdd" required></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="mb-0">12. {{__('msg.note')}}</label>
                            <textarea class="form-control text-xs" name="noteAdd" id="noteAdd" required></textarea>
                        </div>

                    </div>
                    <div class="text-right card-footer p-1  pr-3">
                        <button type="submit" class="btn btn-primary">{{__('msg.save')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- EDIT -->
<div id="modal-container">
    <div class="modal fade" id="editModalQuotation" tabindex="0" role="dialog" aria-hidden="true" style="z-index:1050; display:none" aria-labelledby="editUserModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content" style="width: 800px; margin: 30px 0px 30px -70px;">
                <div class="modal-header bg-orange py-1 m-0 pt-2">
                    <h3 class="card-title" id="editUserModalLabel">{{__('msg.editQuotation')}}</h3>
                    <button type="button" class="close" data-dismiss="modal" area-label="Close">
                        <span aria-hidden="true"><i class="fa fa-close"></i> </span>
                    </button>
                </div>
                <form id="editQuotationForm" method="post">
                    @method("PATCH")
                    @csrf
                    <div class="modal-body    ">
                        <div class="form-group">
                            <label class="mb-0 text-primary">1. {{__('msg.belongQuotationType')}}</label>
                            <select class="form-control text-xs select2 select2-primary" data-dropdown-css-class="select2-primary" name="partnerIDEdit" id="partnerIDEdit" style="width: 100%;" required>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="mb-0">2. {{__('msg.quotationName')}}</label>
                            <input class="form-control text-xs" name="nameEdit" id="nameEdit" required>
                        </div>
                        <div class="form-group">
                            <label class="mb-0">3. {{__('msg.tax')}}</label>
                            <input class="form-control text-xs" name="taxEdit" id="taxEdit" required>
                        </div>
                        <div class="form-group">
                            <label class="mb-0">4. {{__('msg.address')}}</label>
                            <input class="form-control text-xs" name="addressEdit" id="addressEdit" required>
                        </div>
                        <div class="form-group">
                            <label class="mb-0">5. {{__('msg.email')}}</label>
                            <input class="form-control text-xs" name="emailEdit" id="emailEdit" required>
                        </div>
                        <div class="form-group">
                            <label class="mb-0">6. {{__('msg.phone')}}</label>
                            <input class="form-control text-xs" name="phoneEdit" id="phoneEdit" required>
                        </div>
                        <div class="form-group">
                            <label class="mb-0">7. {{__('msg.note')}}</label>
                            <input class="form-control text-xs" name="noteEdit" id="noteEdit" required>
                        </div>

                    </div>
                    <div class="text-right card-footer p-1  pr-3">
                        <button type="submit" class="btn btn-primary">{{__('msg.save')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div id="modal-container r">
    <div class="modal fade " id="infoModalQuotation" tabindex="0" role="dialog" aria-hidden="true" style="z-index:1050; display:none" aria-labelledby="infoUserModalLabel">
        <div class="modal-dialog text-left" role="document">
            <div class="modal-content" style="width: 800px; margin: 30px 0px 30px -70px;">
                <div class="modal-header bg-orange py-1 m-0 pt-2">
                    <h3 class="card-title" id="infoUserModalLabel"><b>{{__('msg.infoQuotation')}}</b></h3>
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
                <div class="text-right card-footer p-1  pr-3">
                    <input type="hidden" id="hiddenSelectedQuotationID">
                    <a onclick="return confirm('Bạn chọn thay đổi trạng thái phê duyệt?')" id="btnApprove" class="btn btn-success text-white">{{ __('msg.approve') }}</a>

                    <button data-dismiss="modal" area-label="Close" class="btn btn-secondary">{{__('msg.close')}}</button>
                </div>
            </div>
        </div>
    </div>
</div>
@section('scripts-quotation-supplier')
@include('scripts.script-quotation-supplier')
@endsection
@push('scripts_fixPushMenu')
<script src="../../dist/js/adminlte.min.js?v=3.2.0"></script>
@endpush
@endsection
