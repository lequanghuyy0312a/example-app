<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PO Process | Print</title>

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
        <h2 class="text-center text-uppercase text-bold"> {{__('msg.RefurnStockForm')}}</h2>
    </div>
    <div class="form-group m-2">
        <table class="table table-bordered" id="purchaseOrderDetailTable">
            <thead>
                <tr class=" text-center">
                    <th class="p-1" style="width: 1%">
                        {{__('msg.num')}}
                    </th>
                    <th class=" p-1" style="width: 15%">
                        <p class="m-0 text-uppercase text-xs  text-truncate d-inline"> {{__('msg.purchaseOrderMaterialCode')}} </p>
                        <p class="m-0 " style="font-size:10px">{{__('msg.purchaseOrderMaterialCodeEN')}}</p>
                    </th>
                    <th class=" p-1" style="width: 34%">
                        <p class="m-0 text-uppercase text-xs  text-truncate d-inline"> {{__('msg.purchaseOrderMaterialName')}} </p>
                        <p class="m-0 " style="font-size:10px">{{__('msg.purchaseOrderMaterialNameEN')}}</p>
                    </th>
                    <th class=" p-1" style="width: 10%">
                        <p class="m-0 text-uppercase text-xs  text-truncate d-inline"> {{__('msg.purchaseOrderUnit')}} </p>
                        <p class="m-0 " style="font-size:10px">{{__('msg.purchaseOrderUnitEN')}}</p>
                    </th>
                    <th class=" p-1" style="width: 10%">
                        <p class="m-0 text-uppercase text-xs  text-truncate d-inline"> {{__('msg.purchaseOrderQuantity')}} </p>
                        <p class="m-0 " style="font-size:10px">{{__('msg.purchaseOrderQuantityEN')}}</p>
                    </th>
                    <th class=" p-1" style="width: 10%">
                        <p class="m-0 text-uppercase text-xs  text-truncate d-inline"> {{__('msg.purchaseOrderDeliveryDate')}} </p>
                        <p class="m-0 " style="font-size:10px">{{__('msg.purchaseOrderDeliveryDateEN')}}</p>
                    </th>
                    <th class=" p-1" style="width: 20%">
                        <p class="m-0 text-uppercase text-xs  text-truncate d-inline"> {{__('msg.purchaseOrderNote')}} </p>
                        <p class="m-0 " style="font-size:10px">{{__('msg.purchaseOrderNoteEN')}}</p>
                    </th>
                </tr>
            </thead>
            <tbody style="font-size:13px">
                <?php $numList = 0;  ?>
                @foreach($getProcessPurchase as $process)
                <tr>
                    <td class="text-center p-1">{{ ++$numList }}</td>
                    <td class="p-1 email">{{ $process->product_code }}</td>
                    <td class="p-1 email">{{ $process->product_name }}</td>
                    <td class="text-center p-1 email">{{ $process->product_unit }}</td>
                    <td class="text-right p-1 email">{{ $process->quantity }}</td>
                    <td class="text-center p-1 email">{{ $process->date }}</td>
                    <td class="text-center p-1 email">{{ $process->note }}</td>
                </tr>
                @endforeach
            </tbody>

        </table>

        <div class="row ml-1 mt-4">
            <div class="col-3 text-center">
                <p class="mb-0"><b>{{__('msg.returnBy')}}</b></p>
            </div>
            <div class="col-3 text-center">
                <p class="mb-0"><b>{{__('msg.receiveBy')}}</b></p>
            </div>
            <div class="col-3 text-center">
                <p class="mb-0"><b>{{__('msg.storeKeeper')}}</b></p>
            </div>
            <div class="col-3 text-center">
                <p class="mb-0"><b>KATSURA VIETNAM JSC</b></p>

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
