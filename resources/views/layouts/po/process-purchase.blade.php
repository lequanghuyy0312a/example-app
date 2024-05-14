@extends('home._layout')
@section('title', 'Partner | List')
@section('content')
<section class="content-header bg-gradient-white shadow py-1">
    <div class="container-fluid">
        <div class="row ">
            <div class="col-sm-6">

                <h1 class="m-0 text-dark">{{__('msg.processPO')}}</h1>
            </div><!-- /.col -->

        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</section>
<section class="content my-2">
    <div class="">
        <!-- danh sách partner  -->
        <div class="card">
            <div class="card-body p-2">
                <section class="content px-0">
                    <div class="container-fluid px-1">
                        <div class="form-group mt-2" style="max-height: 680px;overflow-y: auto;">

                            <table class="table table-bordered m-0 p-0">
                                <thead style="position: sticky; top:0px; background:white">
                                    <tr class=" text-center">
                                        <th class="p-1" style="width: 1%">
                                            {{__('msg.num')}}
                                        </th>
                                        <th class=" p-1" style="width: 5%">{{__('msg.purchaseOrderCode')}} </th>
                                        <th class=" p-1" style="width: 10%"> {{__('msg.purchaseOrderMaterialCode')}} </th>
                                        <th class=" p-1" style="width: 33%"> {{__('msg.purchaseOrderMaterialName')}} </th>
                                        <th class=" p-1" style="width: 5%">{{__('msg.purchaseOrderUnit')}} </th>
                                        <th class="email p-1" style="width: 7%">{{__('msg.purchaseOrderUnitPrice')}} </th>
                                        <th class=" p-1" style="width: 7%">{{__('msg.purchaseOrderQuantity')}}</th>
                                        <th class=" p-1" style="width: 5%">{{__('msg.purchaseOrderVAT')}} </th>
                                        <th class=" p-1" style="width: 7%">{{__('msg.purchaseOrderSubTotal')}} </th>
                                        <th class=" p-1 " style="width: 10%">{{__('msg.purchaseOrderDeliveryDate')}} </th>
                                        <th class=" p-1" style="width: 10%">{{__('msg.purchaseOrderNote')}}</th>
                                        <th class=" p-1" style="width: 1%">
                                            <a class="btn btn-link btn-sm p-0 m-0 px-1" href="/print-PO-process-return/{{$savePOID}}" rel="noopener" target="_blank">
                                                <i class="fa-solid fa-truck-ramp-box p-1 rounded-circle text-light bg-danger"></i>
                                            </a>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody style="font-size:14px">
                                    <?php $numMaterial = 0; ?>
                                    @foreach($getPurchaseOrderDetailToProcress as $detail)
                                    <?php
                                    $subTotal = ($detail->MOQ * $detail->unitPrice) + (($detail->MOQ * $detail->unitPrice * $detail->vat) / 100);
                                    $tempTotal = 0; // Khởi tạo biến tạm tính tổng
                                    ?>
                                    <tr style="background-color:darkgrey;">
                                        <td class="text-center p-1">{{++$numMaterial}}</td>
                                        <td class="p-1 email">{{ $detail->orderCode }}</td>
                                        <td class="p-1 email">{{ $detail->product_code }}</td>
                                        <td class="p-1"> <b>{{ $detail->product_name }}</b></td>
                                        <td class="text-center p-1 email">{{ $detail->unit }}</td>
                                        <td class="text-right p-1 email">{{ ($detail->unitPrice) }}</td>
                                        <td class="text-right p-1 email">{{ ($detail->MOQ) }}</td>
                                        <td class="text-right p-1 email">{{ ($detail->vat) }}</td>
                                        <td class="text-right p-1 email">{{ ($subTotal) }}</td>
                                        <td class="text-center p-1 email">{{ $detail->deliveryDate }}</td>
                                        <td class="text-center p-1 email">{{ $detail->note }}</td>
                                        <td class="text-center p-1 email">
                                            <a class="btn btn-link btn-sm p-0 m-0 px-1" data-toggle="modal" data-target="#AddForm{{ $detail->productID }}">
                                                <i class="fa-solid text-light bg-primary p-1 rounded-circle fa-plus"></i>
                                            </a>

                                        </td>
                                    </tr>
                                    <div class="modal fade" id="AddForm{{ $detail->productID }}" tabindex="-1" role="dialog" aria-hidden="true" style="z-index:1050; display:none">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header bg-primary">
                                                    <h3 class="card-title">{{__('msg.addNewPOProcess')}}</h3>
                                                    <button type="button" class="close" data-dismiss="modal" area-label="Close">
                                                        <span aria-hidden="true"><i class="fa fa-close"></i> </span>
                                                    </button>
                                                </div>
                                                <!-- /.card-header -->
                                                <!-- form start -->
                                                <form action="{{ route('po-process-add-submit', [$detail->productID]) }}" method="post">
                                                    @csrf
                                                    <input type="hidden" name="hiddenPOIDToAdd" value="{{$savePOID}}" />

                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label class="mb-0">1.{{__('msg.quantity')}}</label>
                                                            <input class="form-control" name="quantityAdd" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="mb-0">2.{{__('msg.receiptDate')}}</label>
                                                            <input type="date" class="form-control" name="dateAdd" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="mb-0">3.{{__('msg.note')}}</label>
                                                            <input class="form-control" name="noteAdd" required>
                                                        </div>
                                                    </div>
                                                    <!-- /.card-body -->
                                                    <div class="text-right card-footer">
                                                        <button type="submit" class="btn btn-primary">{{__('msg.save')}}</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <tr>
                                        <td colspan="12" class="p-0" style="border-bottom: solid 1px;">
                                            <table class="table table-bordered w-75 float-right  mb-2">
                                                <tbody style="font-size:11px">
                                                    <?php $num = 0;
                                                    $tempTotalSuccess = 0;
                                                    $tempTotalProcess = 0;
                                                    $hasData = false; ?>
                                                    @foreach($getProcessPurchase as $process)
                                                    @if($process->materialID == $detail->productID)
                                                    <?php $hasData = true; ?> <!-- Đặt biến cờ thành true nếu có dữ liệu -->
                                                    <tr>
                                                        <td class="text-center p-1 email">Delivery {{ ++$num }}</td>
                                                        <td class="text-right p-1 email">{{ ($process->date) }}</td>
                                                        <td class="text-left p-1 email">{{ $process->note }}</td>
                                                        <td class="text-center p-1 email">
                                                            {!! $process->approve == 0 ? '<b class="text-orange">' . __('msg.checking') . '</b>' :
                                                            ($process->approve == 3 ? '<s class="text-secondary">' . __('msg.NGReturn') . '</s>' :
                                                            ($process->approve == 1 ? '<b class="text-success">OK</b>' :
                                                            ($process->approve == 4 ? '<s class="text-secondary">' . __('msg.NGReturned') . '</s>' :
                                                            ($process->approve == 2 ? '<b class="text-danger">'.__('msg.NGInstruction').'</b>' : '<b class="text-dark">undefined</b>'))))!!}
                                                        </td>
                                                        <td class="text-right p-1 email">
                                                            {!! $process->approve == 3 ? '<s>' . $process->quantity . '</s>' : $process->quantity !!}
                                                        </td>


                                                        <td class="text-right  p-0 m-0">
                                                            <div class="btn btn-group  p-0 m-0">
                                                                @if($process->approve == 0)
                                                                <a class="btn btn-link btn-sm p-0 m-0 px-1" data-toggle="modal" data-target="#ApproveForm{{$process->id}}">
                                                                    <i class="fa-solid fa-clipboard-list text-orange"></i>
                                                                </a>
                                                                @elseif($process->approve == 1)
                                                                <a class="btn btn-link btn-sm p-0 m-0 px-1" href="/po-process/{{$process->id}}/import-warehouse" onclick="return confirm('Are you sure import to warehouse ?')">
                                                                    <i class="fa-solid fa-cubes-stacked  text-success"></i>
                                                                </a>
                                                                @elseif($process->approve == 2)
                                                                <a class="btn btn-link btn-sm p-0 m-0 px-1" data-toggle="modal" data-target="#NGForm{{$process->id}}">
                                                                    <i class="fa-solid fa-triangle-exclamation  text-danger"></i>
                                                                </a>
                                                                @elseif($process->approve == 3)
                                                                <a class="btn btn-link btn-sm p-0 m-0 px-1" href="/po-process/{{$process->id}}/returned" onclick="return confirm('Are you sure returned ?')">
                                                                    <i class=" text-secondary  fa-solid fa-stamp"></i>
                                                                </a>
                                                                @endif
                                                                <a class="btn btn-link btn-sm p-0 m-0 px-1" href="/po-process/{{$process->id}}/delete" onclick="return confirm('Are you sure you want to delete ?')">
                                                                    <i class="fas text-secondary fa-trash"></i>
                                                                </a>

                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <div class="modal fade" id="ApproveForm{{ $process->id }}" tabindex="0" role="dialog" aria-hidden="true" style="z-index:1050; display:none">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header bg-primary p-0 m-0 pt-2 pl-3">
                                                                    <h3 class="card-title text-capitalize">{{__('msg.approveProcess')}}</h3>
                                                                    <button type="button" class="close" data-dismiss="modal" area-label="Close">
                                                                        <span aria-hidden="true"><i class="fa fa-close"></i> </span>
                                                                    </button>
                                                                </div>
                                                                <form action="{{route('po-process-approve-edit-submit', $process->id)}}" method="post">
                                                                    @method("PATCH")
                                                                    @csrf
                                                                    <div class="modal-body pb-0">
                                                                        <div class="form-group d-flex justify-content-around">
                                                                            <div class="">
                                                                                <input type="radio" name="approveEdit" value="1" id="radioSuccess1">
                                                                                <label for="radioSuccess1" class="mb-0 text-success">OK</label>
                                                                            </div>
                                                                            <div class="">
                                                                                <input type="radio" name="approveEdit" value="2" id="radioSuccess2">
                                                                                <label for="radioSuccess2" class="mb-0 text-danger">{{__('msg.NGInstruction')}}</label>
                                                                            </div>

                                                                        </div>
                                                                    </div>
                                                                    <div class="text-right card-footer p-1">
                                                                        <button type="submit" class="btn btn-primary">{{__('msg.save')}}</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal fade" id="NGForm{{ $process->id }}" tabindex="0" role="dialog" aria-hidden="true" style="z-index:1050; display:none">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header bg-primary p-0 m-0 pt-2 pl-3">
                                                                    <h3 class="card-title text-capitalize">{{__('msg.approveProcess')}}</h3>
                                                                    <button type="button" class="close" data-dismiss="modal" area-label="Close">
                                                                        <span aria-hidden="true"><i class="fa fa-close"></i> </span>
                                                                    </button>
                                                                </div>
                                                                <form action="{{route('po-process-approve-edit-submit', $process->id)}}" method="post">
                                                                    @method("PATCH")
                                                                    @csrf
                                                                    <div class="modal-body pb-0">
                                                                        <div class="form-group d-flex justify-content-around">
                                                                            <div class="">
                                                                                <input type="radio" name="approveEdit" value="0" id="radioSuccess1">
                                                                                <label for="radioSuccess1" class="mb-0 text-orange">{{__('msg.review')}}</label>
                                                                            </div>
                                                                            <div class="">
                                                                                <input type="radio" name="approveEdit" value="3" id="radioSuccess2">
                                                                                <label for="radioSuccess2" class="mb-0 text-danger">{{__('msg.NGReturn')}}</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="text-right card-footer p-1">
                                                                        <button type="submit" class="btn btn-primary">{{__('msg.save')}}</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <?php
                                                    if ($process->approve == 1) {
                                                        $tempTotalSuccess += $process->quantity;
                                                    } elseif ($process->approve == 0)
                                                        $tempTotalProcess += $process->quantity;
                                                    }
                                                    ?>
                                                    @endif
                                                    @endforeach

                                                    @if($hasData) <!-- Kiểm tra biến cờ, nếu có dữ liệu thỏa mãn thì hiển thị thead -->
                                                    <thead>
                                                        <tr style="background-color:gainsboro;">
                                                            <th class="text-center p-1" style="width: 10%">{{__('msg.delivery')}} </th>
                                                            <th class="text-center p-1" style="width: 15%">{{__('msg.deliveryDate')}} </th>
                                                            <th class="text-center p-1" style="width: 44%">{{__('msg.note')}} </th>
                                                            <th class="text-center p-1" style="width: 15%">{{__('msg.QCcheck')}} </th>
                                                            <th class="text-center p-1" style="width: 16%">{{__('msg.quantity')}} </th>
                                                            <th></th>
                                                        </tr>
                                                    </thead>

                                                    <tr>
                                                        <?php
                                                        $total = $detail->MOQ;
                                                        $success = ($tempTotalSuccess > 0 && $total > 0) ? ($tempTotalSuccess / $total) * 100 : 0;
                                                        $processing = ($tempTotalProcess > 0 && $total > 0) ? ($tempTotalProcess / $total) * 100 : 0;
                                                        ?>
                                                        <td colspan="12" class="p-1" style="border-bottom: solid 1px;">
                                                            <div class="progress progress-sm m-1">
                                                                <div class="progress-bar bg-success" role="progressbar" aria-valuenow="{{ $success }}" aria-valuemin="0" aria-valuemax="100" style="width: {{ $success }}%">
                                                                    {{ $success }}%
                                                                </div>
                                                                <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="{{ $processing }}" aria-valuemin="0" aria-valuemax="100" style="width: {{ $processing}}%">
                                                                    {{ $processing}}%
                                                                </div>
                                                                <div class="progress-bar bg-secondary" role="progressbar" aria-valuenow="{{ 100 - $success - $processing}}" aria-valuemin="0" aria-valuemax="100" style="width: {{ 100 - $success - $processing}}%">
                                                                    {{ 100 - $success - $processing}}%
                                                                </div>
                                                            </div>
                                                            <span class="px-1 text-xs d-flex justify-content-between">
                                                                <b class="text-muted"> {{__('msg.deliverySuccess')}}: {{ $tempTotalSuccess}} ({{ $detail->unit }})</b>
                                                                <b class="text-muted"> {{__('msg.deliveryProcess')}}: {{ $tempTotalProcess}} ({{ $detail->unit }}) </b>
                                                                <b class="text-muted">
                                                                    {{__('msg.deliveryImcomplete')}}: {{ number_format($detail->MOQ - $tempTotalSuccess - $tempTotalProcess) }}
                                                                </b>
                                                            </span>
                                                        </td>
                                                    </tr>
                                                    @endif

                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- /.row -->
                    </div><!-- /.container-fluid -->
                </section>
            </div>
        </div>
    </div>

</section>

@section('scripts-process-purchase')
@include('scripts.script-process-purchase')
@endsection
@push('scripts_fixPushMenu')
<script src="../../dist/js/adminlte.min.js?v=3.2.0"></script>
@endpush
@endsection
