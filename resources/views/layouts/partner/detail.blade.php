@extends('home._layout')
@section('title', 'Partner | List')
@section('content')
<section class="content-header bg-gradient-white shadow py-1">
    <div class="container-fluid">
        <div class="row ">
            <div class="col-sm-6">

                <h1 class="m-0 text-dark">{{__('msg.partnerDetail')}}</h1>
            </div><!-- /.col -->

        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</section>
<section class="content my-2">
    <div class="">
        <!-- danh sách partner  -->
        <div class="card">
            <div class="card-body p-2">
                <div class="col-12 row p-0 m-0 " style="position: sticky; top:0px; background-color: #fff; z-index: 1;">
                    <div class="col-12 pl-0">
                        <div class="form-group">
                            <input id="selectedPartnerID" hidden value="{{$saveID}}">
                            <select class="form-control text-xs select2 select2-primary select2-purchase-order-phaseID" data-dropdown-css-class="select2-primary" name="phaseID" id="phaseID" style="width: 30%;" required>
                                <?php $numAdd = 0; ?>
                                @foreach($getDropListPhases as $key => $phase)
                                <option value="{{ $phase->id }}" {{ $loop->last ? 'selected' : '' }}>
                                    {{ ++$numAdd }}/ {{ $phase->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <section class="content px-0">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-3 px-0">
                                <!-- Profile Image -->
                                <div class="card card-primary card-outline">
                                    <div class="card-body box-profile py-2 px-3">
                                        <div class="text-center">
                                            <img class="profile-user-img img-fluid img-circle" src="../../dist/img/user4-128x128.jpg" alt="Partner profile picture">
                                        </div>

                                        <h6 class=" text-center" id="showPartnerName"></h6>

                                        <p class="text-muted text-center mb-0" id="showType"></p>
                                        <ul class="list-group list-group-unbordered mb-3">
                                            <li class="list-group-item py-1">
                                                <b>{{__('msg.countQuotation')}}</b> <a class="float-right" id="showNumQuotations"></a>
                                            </li>
                                            <li class="list-group-item  py-1">
                                                <b>{{__('msg.countPO')}}</b> <a class="float-right" id="showNumPOs"></a>
                                            </li>
                                            <li class="list-group-item py-1">
                                                <b>{{__('msg.productBuy')}}</b> <a class="float-right" id="showNumProductsBuy"></a>
                                            </li>
                                            <li class="list-group-item py-1">
                                                <b>{{__('msg.productSell')}}</b> <a class="float-right" id="showNumProductsSell">...</a>
                                            </li>
                                        </ul>
                                    </div>
                                    <!-- /.card-body -->
                                </div>
                                <!-- /.card -->

                                <!-- About Me Box -->
                                <div class="card card-primary">
                                    <div class="card-header p-1 m-0">
                                        <h3 class="card-title m-0">{{__('msg.infomation')}}</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body py-1 px-3">
                                        <strong><i class="fas fa-map-marker-alt mr-1"></i>{{__('msg.address')}}</strong>
                                        <p class="text-muted mb-0" id="showAddress"></p>
                                        <hr class="my-2">
                                        <strong><i class="fas fa-phone mr-1"></i> {{__('msg.phone')}}</strong>
                                        <p class="text-muted mb-0" id="showAddress"></p>
                                        <hr class="my-2">
                                        <strong><i class="fas fa-pencil-alt mr-1"></i> {{__('msg.tax')}}</strong>
                                        <p class="text-muted mb-0" id="showTax"></p>
                                        <hr class="my-2">
                                        <strong><i class="far fa-file-alt mr-1"></i> {{__('msg.note')}}</strong>
                                        <p class="text-muted  mb-0" id="showNote"></p>
                                    </div>
                                    <!-- /.card-body -->
                                </div>
                                <!-- /.card -->
                            </div>
                            <!-- /.col -->
                            <div class="col-md-9 pr-0">
                                <div class="card">
                                    <div class="card-header p-2">
                                        <ul class="nav nav-pills">
                                            <li class="nav-item"><a class="nav-link active" href="#activity" id="tabQuotation" data-toggle="tab">{{__('msg.quotation')}}</a></li>
                                            <li class="nav-item"><a class="nav-link" href="#timeline" data-toggle="tab">{{__('msg.purchaseOrders')}}</a></li>
                                            <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">{{__('msg.productBuy')}}</a></li>
                                        </ul>
                                    </div><!-- /.card-header -->
                                    <div class="card-body p-0 p-1">
                                        <div class="tab-content">
                                            <div class="active tab-pane " id="activity">
                                            <div  style="max-height: 580px; overflow-y: auto;">
                                                    <!-- timeline time label -->
                                                    <table id="detailPartnerQuotation" class="table table-bordered table-striped">
                                                        <thead  style="position: sticky; top:-1px; background-color: #fff; z-index: 1;">
                                                            <tr>
                                                                <th class="text-center p-0 px-1" style="width: 1%;">{{__('msg.num')}}</th>
                                                                <th class="text-center p-0" style="width: 10%;">{{__('msg.quotationNo')}}</th>
                                                                <th class="text-center p-0" style="width: 10%;">{{__('msg.productCode')}}</th>
                                                                <th class="text-center p-0" style="width: 10%;">{{__('msg.orderCode')}}</th>
                                                                <th class="text-center p-0" style="width: 24%;">{{__('msg.orderProductName')}}</th>
                                                                <th class="text-center p-0" style="width: 1%;">{{__('msg.unit')}}</th>
                                                                <th class="text-center p-0" style="width: 10%;">{{__('msg.MOQ')}}</th>
                                                                <th class="text-center p-0" style="width: 10%;">{{__('msg.unitPrice')}}</th>
                                                                <th class="text-center p-0" style="width: 1%;">{{__('msg.VAT')}}</th>
                                                                <th class="text-center p-0" style="width: 5%;">{{__('msg.approve')}}</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody class="text-xs">

                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <!-- /.tab-pane -->
                                            <div class="tab-pane" id="timeline">
                                                <!-- The timeline -->
                                                <div>
                                                <table id="detailPartnerPO" class="table table-bordered table-striped">
                                                        <thead  style="position: sticky; top:-1px; background-color: #fff; z-index: 1;">
                                                            <tr>
                                                                <th class="text-center p-0 px-1" style="width: 1%;">{{__('msg.num')}}</th>
                                                                <th class="text-center p-0" style="width: 10%;">{{__('msg.productCode')}}</th>
                                                                <th class="text-center p-0" style="width: 5%;">{{__('msg.unit')}}</th>
                                                                <th class="text-center p-0" style="width: 10%;">{{__('msg.MOQ')}}</th>
                                                                <th class="text-center p-0" style="width: 10%;">{{__('msg.unitPrice')}}</th>
                                                                <th class="text-center p-0" style="width: 15%;">{{__('msg.description')}}</th>
                                                                <th class="text-center p-0" style="width: 10%;">{{__('msg.VAT')}}</th>
                                                                <th class="text-center p-0" style="width: 10%;">{{__('msg.deliveryDate')}}</th>
                                                                <th class="text-center p-0" style="width: 10%;">{{__('msg.createdOnUTC')}}</th>
                                                                <th class="text-center p-0" style="width: 14%;">{{__('msg.note')}}</th>
                                                                <th class="text-center p-0" style="width: 15%;">{{__('msg.approve')}}</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody class="text-xs">
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <!-- /.tab-pane -->

                                            <div class="tab-pane" id="settings">
                                                <div>
                                                <table id="detailPartnerProduct" class="table table-bordered table-striped">
                                                        <thead  style="position: sticky; top:-1px; background-color: #fff; z-index: 1;">
                                                            <tr>
                                                                <th class="text-center p-0 px-1" style="width: 1%;">{{__('msg.num')}}</th>
                                                                <th class="text-center p-0" style="width: 15%;">{{__('msg.productCode')}}</th>
                                                                <th class="text-center p-0" style="width: 15%;">{{__('msg.importedPhase')}}</th>
                                                                <th class="text-center p-0" style="width: 15%;">{{__('msg.exportedPhase')}}</th>
                                                                <th class="text-center p-0" style="width: 15%;">{{__('msg.beginningInventory')}}</th>
                                                                <th class="text-center p-0" style="width: 15%;">{{__('msg.endingInventory')}}</th>
                                                                <th class="text-center p-0" style="width: 10%;">{{__('msg.orderCode')}}</th>
                                                                <th class="text-center p-0" style="width: 14%;">{{__('msg.createdOnUTC')}}</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody class="text-xs">

                                                        </tbody>
                                                    </table>

                                                </div>
                                            </div>
                                            <!-- /.tab-pane -->
                                        </div>
                                        <!-- /.tab-content -->
                                    </div><!-- /.card-body -->
                                </div>
                                <!-- /.card -->
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->
                    </div><!-- /.container-fluid -->
                </section>
            </div>
        </div>
    </div>
</section>

@section('scripts-partner-detail')
@include('scripts.script-partner-detail')
@endsection
@push('scripts_fixPushMenu')
<script src="../../dist/js/adminlte.min.js?v=3.2.0"></script>
@endpush
@endsection
