@extends('home._layout')
@section('title', 'PurchaseOrder | List')
@section('content')
<section class="content-header bg-gradient-navy shadow py-1">
    <div class="container-fluid">
        <div class="row ">
            <div class="col-sm-6">

                <h1 class="m-0  text-uppercase text-white">{{__('msg.purchaseOrderList')}}<i class=" text-gray-700 text-md text-lowercase">( {{ $countPurchaseOrders }} purchase orders )</i></h1>
            </div><!-- /.col -->

        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</section>


<section class="content my-2">
    <div class="col-sm-12">
        <!-- danh sách purchaseOrder  -->
        <div class="card ">
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
                <div class="col-12 row p-0 m-0  text-uppercase justify-content-end" style="position: sticky; top:0px; background-color: #fff; z-index: 1;">
                    <div class="col-sm-6 pl-0">
                        <div class="form-group">
                            <select class="form-control text-xs select2 select2-primary select2-purchase-order-phaseIDSelectionToPurchaseOrder" data-dropdown-css-class="select2-primary" name="phaseIDSelectionToPurchaseOrder" id="phaseIDSelectionToPurchaseOrder" style="width: 30%;" required>
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
                <table id="purchaseOrderTable" class="table table-bordered table-striped">
                    <thead style="position: sticky; top:60px; background-color: #fff; z-index: 1;">
                        <tr class="text-center">
                            <th style="width: 1%">
                                {{__('msg.num')}}
                            </th>
                            <th class="address" style="width: 8%">
                                {{__('msg.purchaseOrderNo')}}
                            </th>
                            <th class="address" style="width: 8%">
                                {{__('msg.POOnUTC')}}
                            </th>
                            <th class="email" style="width: 4%">
                                {{__('msg.currency')}}
                            </th>
                            <th class="email" style="width: 21%">
                                {{__('msg.partnerName')}}
                            </th>
                            <th class="email" style="width: 8%">
                                {{__('msg.status')}}
                            </th>
                            <th class="email" style="width: 8%">
                                {{__('msg.acceptedBy')}}
                            </th>
                            <th class="email" style="width: 10%">
                                {{__('msg.acceptedOnUTC')}}
                            </th>
                            <th class="email" style="width: 8%">
                                {{__('msg.createdBy')}}
                            </th>
                            <th class="email" style="width: 23%">
                                {{__('msg.note')}}
                            </th>
                            <th style="position: sticky; right:0px; width: 1%" class="text-center">
                                <a class="btn btn-sm bg-navy col purchase-order-btn-add">
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
<!-- thêm hoặc sửa purchaseOrder phát triển -->

<!-- ADD -->
<div id="modal-container">
    <div class="modal fade" id="addModalPurchaseOrder" tabindex="0" role="dialog" aria-hidden="true" style="z-index:1050; display:none" aria-labelledby="addUserModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content" style="width: 1080px;  margin: 30px 0px 30px -300px;">
                <div class="modal-header bg-navy py-1 m-0  text-uppercase pt-2">
                    <h3 class="card-title mb-0" id="addUserModalLabel">{{__('msg.addNewPurchaseOrder')}}</h3>
                    <button type="button" class="close p-0 m-0" data-dismiss="modal" area-label="Close">
                        <span aria-hidden="true"><i class="fa fa-close"></i> </span>
                    </button>
                </div>

                <form action="{{route('purchase-order-add-submit')}}" method="post">
                    @csrf
                    <div class="modal-body  text-xs">
                        <div class="form-group">
                            <label class="mb-0 text-primary">1. {{__('msg.choosenPartner')}}</label>
                            <select class="form-control text-xs select2 select2-primary " data-dropdown-css-class="select2-primary" name="partnerIDPurchaseOrderAdd" id="partnerIDPurchaseOrderAdd" style="width: 100%;" required>
                            </select>
                        </div>
                        <input class="form-control text-xs" name="hiddenPhaseID" id="hiddenPhaseID" hidden>
                        <div class="row">
                            <div class="form-group col-sm-12">
                                <label class="mb-0">2. {{__('msg.suplierATTNEN')}}</label>
                                <textarea class="form-control text-xs" name="ATTNAdd" id="ATTNAdd" required></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-sm-4">
                                <label class="mb-0">3. {{__('msg.purchaseOrderNo')}}</label>
                                <input class="form-control text-xs" name="purchaseOrderNoAdd" id="purchaseOrderNoAdd" required>
                            </div>
                            <div class="form-group col-sm-4 py-0">
                                <label class="mb-0">4. {{__('msg.POOnUTC')}}</label>
                                <input type="date" name="POOnUTCAdd" id="POOnUTCAdd" class="form-control text-xs " />
                            </div>

                            <div class="form-group col-sm-2">
                                <label class="mb-0">5. {{__('msg.currency')}}</label>
                                <input class="form-control text-xs" name="currencyAdd" id="currencyAdd" required>
                            </div>
                            <div class="form-group col-sm-2">
                                <label class="mb-0">6. {{__('msg.rateMoney')}}</label>
                                <input class="form-control text-xs" name="rateAdd" id="rateAdd" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-sm-12">
                                <label class="mb-0">7. {{__('msg.note')}}</label>
                                <textarea class="form-control text-xs" name="noteAdd" id="noteAdd" required></textarea>
                            </div>
                        </div>

                        <div class="form-group" style=" background-color: #f7f7f7; max-height: 320px;overflow-y: auto;">
                            <table class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th style="width: 10%" class="text-center">{{__('msg.productCode')}}</th>
                                        <th style="width: 24%" class="text-center">{{__('msg.orderProductName')}}</th>
                                        <th style="width: 18%" class="text-center">{{__('msg.description')}}</th>
                                        <th style="width: 7%" class="text-center">{{__('msg.unit')}}</th>
                                        <th style="width: 7%" class="text-center">{{__('msg.quantity')}}</th>
                                        <th style="width: 7%" class="text-center">{{__('msg.unitPrice')}}</th>
                                        <th style="width: 7%" class="text-center">{{__('msg.VAT')}}</th>
                                        <th style="width: 9%" class="text-center">{{__('msg.purchaseOrderDeliveryDate')}}</th>
                                        <th style="width: 10%" class="text-center">{{__('msg.note')}}</th>
                                        <th style="width: 1%" class="text-center">
                                            <a class="btn btn-add-row text-success p-0 m-0" id="addRowBtnPurchaseOrder">
                                                <i class="fa-solid fa-plus"></i>
                                            </a>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody id="dynamicRowsContainerPurchaseOrder">
                                    <tr class="dynamic-row-purchase-order text-xs">
                                        <td class="px-1 text-xs">
                                            <select hidden class="form-control text-xs select2-danger" data-dropdown-css-class="select2-danger" id="productIDPOAdd" name="productIDPOAdd[]" style="width: 100%;">
                                                <option value="0" disabled selected> ... </option>
                                            </select>
                                        </td>
                                        <td class="px-1 text-xs">
                                            <input hidden class="form-control text-xs p-0 px-1" id="orderProductNameAdd" name="orderProductNameAdd[]" />
                                        </td>
                                        <td class="px-1 text-xs">
                                            <input hidden class="form-control text-xs p-0 px-1" id="descriptionAdd" name="descriptionAdd[]" />
                                        </td>
                                        <td class="px-1 text-xs">
                                            <input hidden class="form-control text-xs p-0 px-1" id="unitAdd" name="unitAdd[]" />
                                        </td>
                                        <td class="px-1 text-xs">
                                            <input hidden class="form-control text-xs p-0 px-1" id="quantityAdd" name="quantityAdd[]" oninput="formatInput(this)" />
                                        </td>
                                        <td class="px-1 text-xs">
                                            <input hidden class="form-control text-xs p-0 px-1" id="unitPriceAdd" name="unitPriceAdd[]" oninput="formatInput(this)" />
                                        </td>
                                        <td class="px-1 text-xs">
                                            <input hidden class="form-control text-xs p-0 px-1" id="VATAdd" name="VATAdd[]" oninput="formatInput(this)" />
                                        </td>
                                        <td class="px-1 text-xs">
                                            <!-- <input type="text" id="deliveryDateAdd" name="deliveryDateAdd[]" class="form-control text-xs p-0 px-1" data-inputmask-alias="datetime" data-inputmask-inputformat="yyyy/mm/dd" data-mask> -->
                                            <input hidden type="date" name="deliveryDateAdd[]" id="deliveryDateAdd" class="form-control text-xs" />

                                        </td>
                                        <td class="px-1 text-xs">
                                            <input hidden class="form-control text-xs p-0 px-1" id="PONoteAdd" name="PONoteAdd[]" />
                                        </td>
                                        <td class="text0center">
                                            <a hidden class="btn btn-remove-row text-danger p-0 m-0  text-uppercase pt-2">
                                                <i class="fa-solid fa-xmark"></i>
                                            </a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
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
    <div class="modal fade" id="editModalPurchaseOrder" tabindex="0" role="dialog" aria-hidden="true" style="z-index:1050; display:none" aria-labelledby="editUserModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content" style="width: 800px; margin: 30px 0px 30px -70px;">
                <div class="modal-header bg-navy py-1 m-0  text-uppercase pt-2">
                    <h3 class="card-title" id="editUserModalLabel">{{__('msg.editPurchaseOrder')}}</h3>
                    <button type="button" class="close" data-dismiss="modal" area-label="Close">
                        <span aria-hidden="true"><i class="fa fa-close"></i> </span>
                    </button>
                </div>
                <form id="editPurchaseOrderForm" method="post">
                    @method("PATCH")
                    @csrf
                    <div class="modal-body    ">
                        <div class="form-group">
                            <label class="mb-0 text-primary">1. {{__('msg.belongPurchaseOrderType')}}</label>
                            <select class="form-control text-xs select2 select2-primary" data-dropdown-css-class="select2-primary" name="partnerIDEdit" id="partnerIDEdit" style="width: 100%;" required>
                                <option value="0" disabled selected> ... </option>

                            </select>
                        </div>
                        <div class="form-group">
                            <label class="mb-0">2. {{__('msg.purchaseOrderName')}}</label>
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
                    <div class="text-right card-footer">
                        <button type="submit" class="btn btn-primary">{{__('msg.save')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div id="modal-container">
    <div class="modal fade" id="infoModalPurchaseOrder" tabindex="0" role="dialog" aria-hidden="true" style="z-index:1050; display:none" aria-labelledby="infoUserModalLabel">
        <div class="modal-dialog text-left" role="document">
            <div class="modal-content" style="width: 800px; margin: 30px 0px 30px -70px;">
                <div class="modal-header bg-navy py-1 m-0  text-uppercase pt-2">
                    <h3 class="card-title" id="infoUserModalLabel">{{__('msg.purchaseOrder')}}</h3>
                    <button type="button text-white" class="close" data-dismiss="modal" area-label="Close">
                        <span aria-hidden="true"><i class="fa fa-close"></i> </span>
                    </button>
                </div>
                <div class="modal-body toPrint">
                    <div class="form-group">
                        <h3 class="text-center text-uppercase"> {{__('msg.purchaseOrder')}}</h3>
                        <div class="row">
                            <!-- left  -->
                            <div class="col-6 text-xs">
                                <div class=" row ml-1 p-0" style="border-top: 0.5px solid #000; border-bottom: 0.5px solid #000">
                                    <div class="col-sm-3 px-0 text-center">
                                        <p class="m-0"><u><b>{{__('msg.suplierCode')}}:</b></u></p>
                                        <p class="m-0"><u> {{__('msg.suplierCodeEN')}}: </u></p>
                                    </div>
                                    <b class="col-sm-9 align-self-center" id="showPartnerCode"></b>
                                </div>
                                <div class="row ml-1 px-0" style="border-bottom: 0.5px solid #000">
                                    <div class="col-sm-3 px-0  text-center">
                                        <p class="m-0"><u><b>{{__('msg.suplierName')}}:</b></u></p>
                                        <p class="m-0"><u> {{__('msg.suplierNameEN')}}: </u></p>
                                    </div>
                                    <a class="col-sm-9  align-self-center" id="showPartnerName"></a>
                                </div>
                                <div class="row ml-1 p-0" style="border-bottom: 0.5px solid #000">
                                    <div class="col-sm-3 px-0  align-self-center text-center">
                                        <p class="m-0"><u><b>{{__('msg.suplierAddress')}}:</b></u></p>
                                        <p class="m-0"><u> {{__('msg.suplierAddressEN')}}: </u></p>
                                    </div>
                                    <a class="col-sm-9 align-self-center" id="showPartnerAddress"></a>
                                </div>
                                <div class="row ml-1" style="border-bottom: 0.5px solid #000">
                                    <div class="col-sm-3 px-0 text-center">

                                        <p class="m-0"><u><b>{{__('msg.suplierATTN')}}:</b></u></p>
                                        <p class="m-0"><u> {{__('msg.suplierATTNEN')}}: </u></p>
                                    </div>
                                    <a class="col-sm-9  align-self-center" id="showATTN"></a>
                                </div>
                                <div class="row ml-1 p-0" style="border-bottom: 0.5px solid #000">
                                    <div class="col-sm-3 px-0 text-center">
                                        <b class="col-sm-3 px-0  text-center">{{__('msg.suplierTel')}}:</b>
                                    </div>
                                    <p class="col-sm-9 m-0 align-self-center" id="showPartnerContact"></p>
                                </div>
                            </div>
                            <!-- center -->
                            <div class="col-3">
                            </div>
                            <!-- right -->
                            <div class="col-3 text-xs pl-0">
                                <div class=" row mr-1 p-0" style="border-top: 0.5px solid #000; border-bottom: 0.5px solid #000">
                                    <div class="col-sm-5 px-0 text-center">
                                        <p class="m-0"><u><b>{{__('msg.purchaseOrderNo')}}:</b></u></p>
                                        <p class="m-0"><u> {{__('msg.purchaseOrderNoEN')}}: </u></p>
                                    </div>
                                    <b class="col-sm-7 pl-0 text-center  align-self-center" id="showPurchaseOrderNo"></b>
                                </div>
                                <div class=" row mr-1 p-0" style=" border-bottom: 0.5px solid #000">
                                    <div class="col-sm-5 px-0 text-center">
                                        <p class="m-0"><u><b>{{__('msg.purchaseOrderDate')}}:</b></u></p>
                                        <p class="m-0"><u> {{__('msg.purchaseOrderDateEN')}}: </u></p>
                                    </div>
                                    <b class="col-sm-7 pl-0 text-center  align-self-center" id="showPOOnUTC"></b>
                                </div>
                                <div class=" row mr-1 p-0" style=" border-bottom: 0.5px solid #000">
                                    <div class="col-sm-5 px-0  text-center">
                                        <p class="m-0"><u><b>{{__('msg.purchaseOrderCurrency')}}:</b></u></p>
                                        <p class="m-0"><u> {{__('msg.purchaseOrderCurrencyEN')}}: </u></p>
                                    </div>
                                    <b class="col-sm-7 pl-0  align-self-center text-center" id="showCurrency"></b>
                                </div>
                                <div class=" row mr-1 p-0" style=" border-bottom: 0.5px solid #000">
                                    <div class="col-sm-5 px-0 text-center">
                                        <p class="m-0"><u><b>{{__('msg.purchaseOrderRate')}}:</b></u></p>
                                        <p class="m-0"><u> {{__('msg.purchaseOrderRateEN')}}: </u></p>
                                    </div>
                                    <b class="col-sm-7 pl-0  align-self-center text-center" id="showRate"></b>
                                </div>
                            </div>
                        </div>

                    </div>
                    <u><b>{{__('msg.savedBy')}} </u></b>: <a id="showSavedBy"></a>
                    <div class="form-group mt-2">
                        <table class="table table-bordered" id="purchaseOrderDetailTable">
                            <thead>
                                <tr class=" text-center">
                                    <th class="p-1" style="width: 1%">
                                        {{__('msg.num')}}
                                    </th>
                                    <th class=" p-1" style="width: 10%">
                                        <p class="m-0 text-uppercase text-xs  text-truncate d-inline"> {{__('msg.purchaseOrderMaterialCode')}} </p>
                                        <p class="m-0 " style="font-size:10px">{{__('msg.purchaseOrderMaterialCodeEN')}}</p>
                                    </th>
                                    <th class=" p-1" style="width: 5%">
                                        <p class="m-0 text-uppercase text-xs  text-truncate d-inline"> {{__('msg.purchaseOrderCode')}} </p>
                                        <p class="m-0 " style="font-size:10px">{{__('msg.purchaseOrderCodeEN')}}</p>
                                    </th>
                                    <th class=" p-1" style="width: 25%">
                                        <p class="m-0 text-uppercase text-xs  text-truncate d-inline"> {{__('msg.purchaseOrderMaterialName')}} </p>
                                        <p class="m-0 " style="font-size:10px">{{__('msg.purchaseOrderMaterialNameEN')}}</p>
                                    </th>
                                    <th class=" p-1" style="width: 5%">
                                        <p class="m-0 text-uppercase text-xs  text-truncate d-inline"> {{__('msg.purchaseOrderUnit')}} </p>
                                        <p class="m-0 " style="font-size:10px">{{__('msg.purchaseOrderUnitEN')}}</p>
                                    </th>
                                    <th class="email p-1" style="width: 10%">
                                        <p class="m-0 text-uppercase text-xs  text-truncate d-inline"> {{__('msg.purchaseOrderUnitPrice')}} </p>
                                        <p class="m-0 " style="font-size:10px">{{__('msg.purchaseOrderUnitPriceEN')}}</p>
                                    </th>
                                    <th class=" p-1" style="width: 10%">
                                        <p class="m-0 text-uppercase text-xs  text-truncate d-inline"> {{__('msg.purchaseOrderQuantity')}} </p>
                                        <p class="m-0 " style="font-size:10px">{{__('msg.purchaseOrderQuantityEN')}}</p>
                                    </th>
                                    <th class=" p-1" style="width: 5%">
                                        <p class="m-0 text-uppercase text-xs  text-truncate d-inline"> {{__('msg.purchaseOrderVAT')}} </p>
                                        <p class="m-0 " style="font-size:10px">{{__('msg.purchaseOrderVATEN')}}</p>
                                    </th>
                                    <th class=" p-1" style="width: 10%">
                                        <p class="m-0 text-uppercase text-xs  text-truncate d-inline"> {{__('msg.purchaseOrderSubTotal')}} </p>
                                        <p class="m-0 " style="font-size:10px">{{__('msg.purchaseOrderSubTotalEN')}}</p>
                                    </th>
                                    <th class=" p-1 " style="width: 10%">
                                        <p class="m-0 text-uppercase text-xs  text-truncate d-inline"> {{__('msg.purchaseOrderDeliveryDate')}} </p>
                                        <p class="m-0 text-truncate d-inline" style="font-size:10px">{{__('msg.purchaseOrderDeliveryDateEN')}}</p>
                                    </th>
                                    <th class=" p-1" style="width: 10%">
                                        <p class="m-0 text-uppercase text-xs  text-truncate d-inline"> {{__('msg.purchaseOrderNote')}} </p>
                                        <p class="m-0 " style="font-size:10px">{{__('msg.purchaseOrderNoteEN')}}</p>
                                    </th>
                                </tr>
                            </thead>
                            <tbody style="font-size:11px">
                            </tbody>
                        </table>
                        <div class="row ml-1">
                            <u><b>{{__('msg.note')}} </b></u>: <a id="showNote"></a>

                        </div>

                    </div>
                </div>
                <div class="text-right card-footer">
                    <a href="#" id="printPO" rel="noopener" target="_blank" class="btn bg-success "><i class="fa-solid fa-print mr-1"></i>{{__('msg.print')}} </a>
                    <button data-dismiss="modal" area-label="Close" class="btn bg-navy">{{__('msg.close')}}</button>
                </div>
            </div>
        </div>
    </div>
</div>
@section('scripts-purchase-order')
@include('scripts.script-purchase-order')
@endsection
@push('scripts_fixPushMenu')
<script src="../../dist/js/adminlte.min.js?v=3.2.0"></script>
@endpush
@endsection
