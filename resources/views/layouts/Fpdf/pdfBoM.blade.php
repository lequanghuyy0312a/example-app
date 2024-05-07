<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BoM | Print</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
</head>

<body>
    <div class="wrapper mx-4 my-4 ">
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
                    <th class=" p-1" style="width: 10%">
                        <p class="m-0 text-uppercase text-xs  text-truncate d-inline"> {{__('msg.purchaseOrderDeliveryDate')}} </p>
                        <p class="m-0 " style="font-size:10px">{{__('msg.purchaseOrderDeliveryDateEN')}}</p>
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
    <!-- ./wrapper -->
    <!-- Page specific script -->
    <script>
        window.addEventListener("load", window.print());
    </script>
</body>

</html>
