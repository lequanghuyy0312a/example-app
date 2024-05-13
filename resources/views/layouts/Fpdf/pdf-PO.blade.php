<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Purchase Order | Print</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
</head>

<body>
    <div class="col-12 row">
        <div class="row col-12 mx-3">
            <h5>
                <b>{{__('msg.kvnName')}} </b>
                <p class="text-sm mb-0"><i>Address: {{__('msg.kvnAddress')}}</i></p>
                <p class="text-sm mb-0"><i>Tel: 0272 390 0830 (office) - 027 2390 0831 (sale) </i></p>
                <p class="text-sm mb-0"><i>Fax: 027 - 2390 0829</i></p>
            </h5>
        </div>
        <div class="col-12 row mt-3">
            <div class="col-6 ">
                <img src="{{ asset('assets/img/logo_kvn.jpg') }}" style="width: 200px;" class="col-8">
            </div>
            <div class="col-6 mt-3">
                <h5 class="page-header text-right text-uppercase">
                    <b>{{__('msg.warehousePO')}}</b>
                </h5>
                <hr class="m-0 p-0">
                <div class="col-12 mr-0 pr-0">
                    <p class=" text-right"><b>{{__('msg.latestUpdate')}}</b>{{ __(' :day / :month  / :year', ['day' => now()->format('d'), 'month' => now()->format('m'), 'year' => now()->format('Y')]) }}</p>
                </div>
            </div>
        </div>
    </div>
    <div class="wrapper m-4">
        <h2 class="text-center text-uppercase text-bold"> {{__('msg.purchaseOrder')}}</h2>
        <div class="row mt-5">
            <!-- left  -->
            <div class="col-6">
                <hr class="m-0 p-0">

                <div class=" row ml-1 p-0">
                    <div class="col-3 px-0 text-center">
                        <p class="m-0"><u><b>{{__('msg.suplierCode')}}:</b></u></p>
                        <p class="m-0"><u> {{__('msg.suplierCodeEN')}}: </u></p>
                    </div>
                    <b class="col-9 align-self-center"> </b>
                </div>
                <hr class="m-0 p-0">


                <div class="row ml-1 px-0">
                    <div class="col-3 px-0  text-center">
                        <p class="m-0"><u><b>{{__('msg.suplierName')}}:</b></u></p>
                        <p class="m-0"><u> {{__('msg.suplierNameEN')}}: </u></p>
                    </div>
                    <p class="m-0 col-9  align-self-center">{{ collect($getPurchaseOrderToInfo)->pluck('partner_name')->first() }}</p>
                </div>
                <hr class="m-0 p-0">

                <div class="row ml-1 p-0">
                    <div class="col-3 px-0  align-self-center text-center">
                        <p class="m-0"><u><b>{{__('msg.suplierAddress')}}:</b></u></p>
                        <p class="m-0"><u> {{__('msg.suplierAddressEN')}}: </u></p>
                    </div>
                    <p class="m-0 col-9 align-self-center">{{ collect($getPurchaseOrderToInfo)->pluck('partner_address')->first() }}</p>
                </div>
                <hr class="m-0 p-0">
                <div class="row ml-1 p-0">
                    <div class="col-3 px-0 text-center">
                        <b class="col-3 px-0  text-center">{{__('msg.suplierTel')}}:</b>
                    </div>
                    <p class="col-9 m-0 align-self-center">{{ collect($getPurchaseOrderToInfo)->pluck('partner_phone')->first() }}</p>
                </div>
                <hr class="m-0 p-0">
                <div class="row ml-1">
                    <div class="col-3 px-0 text-center">

                        <p class="m-0"><u><b>{{__('msg.suplierATTN')}}:</b></u></p>
                        <p class="m-0"><u> {{__('msg.suplierATTNEN')}}: </u></p>
                    </div>
                    <p class="m-0 col-9  align-self-center">{{ collect($getPurchaseOrderToInfo)->pluck('ATTN')->first() }}</p>
                </div>
                <hr class="m-0 p-0">



            </div>
            <!-- center -->
            <div class="col-3">
            </div>
            <!-- right -->
            <div class="col-3 pl-0">
                <hr class="m-0 p-0">

                <div class=" row mr-1 p-0">
                    <div class="col-5 px-0 text-center">
                        <p class="m-0"><u><b>{{__('msg.purchaseOrderNo')}}:</b></u></p>
                        <p class="m-0"><u> {{__('msg.purchaseOrderNoEN')}}: </u></p>
                    </div>
                    <b class="col-7 pl-0 text-center  align-self-center">{{ collect($getPurchaseOrderToInfo)->pluck('purchaseOrderNo')->first() }}</b>
                </div>
                <hr class="m-0 p-0">

                <div class=" row mr-1 p-0">
                    <div class="col-5 px-0 text-center">
                        <p class="m-0"><u><b>{{__('msg.purchaseOrderDate')}}:</b></u></p>
                        <p class="m-0"><u> {{__('msg.purchaseOrderDateEN')}}: </u></p>
                    </div>
                    <b class="col-7 pl-0 text-center  align-self-center">{{ collect($getPurchaseOrderToInfo)->pluck('POOnUTC')->first() }}</b>
                </div>
                <hr class="m-0 p-0">

                <div class=" row mr-1 p-0">
                    <div class="col-5 px-0  text-center">
                        <p class="m-0"><u><b>{{__('msg.purchaseOrderCurrency')}}:</b></u></p>
                        <p class="m-0"><u> {{__('msg.purchaseOrderCurrencyEN')}}: </u></p>
                    </div>
                    <b class="col-7 pl-0  align-self-center text-center">{{ collect($getPurchaseOrderToInfo)->pluck('currency')->first() }}</b>
                </div>
                <hr class="m-0 p-0">

                <div class=" row mr-1 p-0">
                    <div class="col-5 px-0 text-center">
                        <p class="m-0"><u><b>{{__('msg.purchaseOrderRate')}}:</b></u></p>
                        <p class="m-0"><u> {{__('msg.purchaseOrderRateEN')}}: </u></p>
                    </div>
                    <b class="col-7 pl-0  align-self-center text-center">{{ collect($getPurchaseOrderToInfo)->pluck('rate')->first() }} </b>
                </div>
                <hr class="m-0 p-0">

            </div>
        </div>

    </div>
    <div class="form-group m-2">
        <table class="table table-bordered" id="purchaseOrderDetailTable">
            <thead>
                <tr class=" text-center">
                    <th class="p-1" style="width: 1%">
                        {{__('msg.num')}}
                    </th>
                    <th class=" p-1" style="width: 8%">
                        <p class="m-0 text-uppercase text-xs  text-truncate d-inline"> {{__('msg.purchaseOrderMaterialCode')}} </p>
                        <p class="m-0 " style="font-size:10px">{{__('msg.purchaseOrderMaterialCodeEN')}}</p>
                    </th>
                    <th class=" p-1" style="width: 10%">
                        <p class="m-0 text-uppercase text-xs  text-truncate d-inline"> {{__('msg.purchaseOrderCode')}} </p>
                        <p class="m-0 " style="font-size:10px">{{__('msg.purchaseOrderCodeEN')}}</p>
                    </th>
                    <th class=" p-1" style="width: 22%">
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
            <tbody style="font-size:13px">
                @foreach($getPurchaseOrderDetailToInfo as $detail)
                <?php
                $numList = 0;
                $subTotal = 0;
                $totalAmount = 0;
                ?>
                <tr>
                    <?php
                    $subTotal = ($detail->MOQ * $detail->unitPrice) + (($detail->MOQ * $detail->unitPrice * $detail->vat) / 100);
                    ?>
                    <td class="text-center p-1">{{ ++$numList }}</td>
                    <td class="p-1 email">{{ $detail->product_code }}</td>
                    <td class="p-1 email">{{ $detail->orderCode }}</td>
                    <td class="p-1 email"><b>{{ $detail->product_name }}</b></td>
                    <td class="text-center p-1 email">{{ $detail->unit }}</td>
                    <td class="text-right p-1 email">{{ number_format($detail->unitPrice, 2, '.', ',') }}</td>
                    <td class="text-right p-1 email">{{ number_format($detail->MOQ, 2, '.', ',') }}</td>
                    <td class="text-right p-1 email">{{ number_format($detail->vat, 2, '.', ',') }}</td>
                    <td class="text-right p-1 email">{{ number_format($subTotal, 2, '.', ',') }}</td>
                    <td class="text-center p-1 email">{{ $detail->deliveryDate }}</td>
                    <td class="text-center p-1 email">{{ $detail->note }}</td>
                </tr>
                <?php $totalAmount += $subTotal; ?>
                @endforeach
                <tr>
                    <td colspan="9" class="text-right"><u><b>Total:</u></b> </td>
                    <td colspan="3" class="text-right"> <b id="showTotal" class="text-md  ml-2 mb-0">{{ number_format($totalAmount, 2, '.', ',') }}</b></td>
                </tr>
            </tbody>

        </table>
        <div class="row ml-1">
            <p><u><b>{{__('msg.note')}} </b></u>: {{ collect($getPurchaseOrderToInfo)->pluck('note')->first() }}</p>

        </div>

        <div class="row ml-1 mt-4">
            <div class="col-7 text-center">
                <p class="mb-0">SUPLLIER </p>
            </div>
            <div class="col-5 text-center">
                <p class="mb-0">BUYER </p>
                <p class="mb-0"><b>KATSURA VIETNAM JSC</b></p>
                <p>GENERAL DIRECTOR</p>

                <p class="mt-5">TSUCHIHASHI IKUO</p>
            </div>
        </div>

    </div>

    <!-- ./wrapper -->
    <!-- Page specific script -->
    <script>
        window.addEventListener("load", window.print());
    </script>
    <style>
        @media print {
            body {
                font-family: 'Arial', sans-serif;
                /* Use a font that supports Vietnamese characters */
            }
        }
    </style>

</body>

</html>
