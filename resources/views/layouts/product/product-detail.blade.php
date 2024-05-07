@extends('home._layout')
@section('title', 'Product | List')

@section('content')
<section class="content-header bg-gradient-white shadow py-1">
    <div class="container-fluid">
        <div class="row ">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">{{__('msg.productDetail')}}</h1>
            </div><!-- /.col -->

        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</section>
<section class="content my-2">
    <div class="">
        <!-- danh sách productDetail  -->
        <div class="card">
            <div class="card-header bg-white pb-0">
                <h3 class="card-title"> <i>{{ $countProductDetails }} (items)</i>
                    <a class="btn btn-primary text-white" data-toggle="modal" data-target="#InsertForm">
                        <i class="fa-solid fa-file-import"></i></a>
                    <a class="btn btn-danger text-white" data-toggle="modal" data-target="#RemoveForm">
                        <i class="fa-solid fa-trash-can"></i></a>
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
                            <select class="form-control select2 select2-primary" data-dropdown-css-class="select2-primary" name="phaseIDSelectionToProductList" id="phaseIDSelectionToProductList" style="width: 30%;" required>
                                <?php $numAdd = 0; ?>
                                @foreach($getDropListPhases as $key => $phase)
                                <option value="{{ $phase->id }}" {{ $loop->last ? 'selected' : '' }}>
                                    {{ ++$numAdd }}. {{ $phase->name }}
                                </option>
                                @endforeach
                            </select>

                        </div>
                    </div>
                    <div class="col-sm-6 pr-0 ">
                        <div class="input-group mb-2">
                            <input class="form-control" type="text" id="searchProduct" placeholder="Search">
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fas fa-search"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <table id="productDetailTable" class="table table-bordered table-striped">
                        <thead style="position: sticky; top:60px; background-color: #fff; z-index: 1;">
                            <tr class="text-center">
                                <th style="width: 1%">
                                    {{__('msg.num')}}
                                </th>
                                <th style="width: 5%">
                                    {{__('msg.belongPhase')}}
                                </th>
                                <th style="width: 10%">
                                    {{__('msg.originalProductCode')}}
                                </th>
                                <th style="width: 7%">
                                    {{__('msg.importedPhase')}}
                                </th>
                                <th style="width: 7%">
                                    {{__('msg.exportedPhase')}}
                                </th>
                                <th style="width: 7%">
                                    {{__('msg.beginningInventory')}}
                                </th>
                                <th style="width: 7%">
                                    {{__('msg.endingInventory')}}
                                </th>
                                <th style="width: 6%">
                                    {{__('msg.orderCode')}}
                                </th>
                                <th style="width: 20%">
                                    {{__('msg.partnerName')}}
                                </th>
                                <th style="width: 10%">
                                    {{__('msg.createdOnUTC')}}
                                </th>
                                <th style="position: sticky; right:0px; width: 1%" class="text-center">
                                    <a class="btn btn-success btn-sm col " id="product-details-btn-add">
                                        <i class="fas fa-plus"></i> </a>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
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
<!-- thêm hoặc sửa productDetail phát triển -->



<!-- ADD -->
<div id="modal-container">
    <div class="modal fade" id="addModalProductDetail" tabindex="0" role="dialog" aria-hidden="true" style="z-index:1050; display:none" aria-labelledby="addUserModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content" style="width: 800px;">
                <div class="modal-header bg-primary">
                    <h3 class="card-title" id="addUserModalLabel">{{__('msg.addNewProductDetail')}}</h3>
                    <button type="button" class="close" data-dismiss="modal" area-label="Close">
                        <span aria-hidden="true"><i class="fa fa-close"></i> </span>
                    </button>
                </div>

                <form action="{{route('product-details-add-submit')}}" method="post">
                    @csrf
                    <div class="modal-body  ">
                        <div class="form-group">
                            <label class="mb-0 text-primary">1. {{__('msg.originalProductName')}}</label>
                            <select class="form-control select2 select2-primary  " data-dropdown-css-class="select2-primary" name="productIDByPhaseAdd" id="productIDByPhaseAdd" style="width: 100%;" required>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="mb-0">2. {{__('msg.importedPhase')}}</label>
                            <input class="form-control" name="importedPhaseAdd" id="importedPhaseAdd" required>
                        </div>
                        <div class="form-group">
                            <label class="mb-0">3. {{__('msg.exportedPhase')}}</label>
                            <input class="form-control" name="exportedPhaseAdd" id="exportedPhaseAdd" required>
                        </div>
                        <div class="form-group">
                            <label class="mb-0">4. {{__('msg.beginningInventory')}}</label>
                            <input class="form-control" name="beginningInventoryAdd" id="beginningInventoryAdd" required>
                        </div>
                        <div class="form-group">
                            <label class="mb-0">5. {{__('msg.endingInventory')}}</label>
                            <input class="form-control" name="endingInventoryAdd" id="endingInventoryAdd" required>
                        </div>
                        <div class="form-group">
                            <label class="mb-0">6. {{__('msg.beginningInventory')}}</label>
                            <input class="form-control" name="beginningInventoryAdd" id="beginningInventoryAdd" required>
                        </div>
                        <div class="form-group">
                            <label class="mb-0">7. {{__('msg.orderCode')}}</label>
                            <input class="form-control" name="orderCodeAdd" id="orderCodeAdd" required>
                        </div>
                        <div class="form-group">
                            <label class="mb-0 text-primary">8. {{__('msg.partnerName')}}</label>
                            <select class="form-control select2 select2-primary " data-dropdown-css-class="select2-primary" name="partnerIDProductAdd" id="partnerIDProductAdd" style="width: 100%;" required>

                            </select>
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

<!-- EDIT -->
<div id="modal-container">
    <div class="modal fade" id="editModalProductDetail" tabindex="0" role="dialog" aria-hidden="true" style="z-index:1050; display:none" aria-labelledby="editUserModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content" style="width: 800px;">
                <div class="modal-header bg-primary">
                    <h3 class="card-title" id="editUserModalLabel">{{__('msg.editProduct')}}</h3>
                    <button type="button" class="close" data-dismiss="modal" area-label="Close">
                        <span aria-hidden="true"><i class="fa fa-close"></i> </span>
                    </button>
                </div>
                <form id="editProductDetailForm" method="post">
                    @method("PATCH")
                    @csrf
                    <div class="modal-body ">
                        <div class="form-group">
                            <label class="mb-0">1. {{__('msg.originalProductName')}}</label>
                            <select class="form-control select2 select2-primary select2-product-details-product" data-dropdown-css-class="select2-primary" name="productIDByPhaseEdit" id="productIDByPhaseEdit" style="width: 100%;" required>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="mb-0  text-success">2. {{__('msg.importedPhase')}}</label>
                            <input class="form-control" name="importedPhaseEdit" id="importedPhaseEdit" required>
                        </div>
                        <div class="form-group">
                            <label class="mb-0  text-danger">3. {{__('msg.exportedPhase')}}</label>
                            <input class="form-control" type="number" min="1" step="any" name="exportedPhaseEdit" id="exportedPhaseEdit" required>
                        </div>
                        <div class="form-group">
                            <label class="mb-0">4. {{__('msg.beginningInventory')}}</label>
                            <input class="form-control" type="number" min="1" step="any" name="beginningInventoryEdit" id="beginningInventoryEdit" required>
                        </div>
                        <div class="form-group">
                            <label class="mb-0">5. {{__('msg.endingInventory')}}</label>
                            <input class="form-control" type="number" min="1" step="any" name="endingInventoryEdit" id="endingInventoryEdit" required>
                        </div>
                        <div class="form-group">
                            <label class="mb-0">6. {{__('msg.orderCode')}}</label>
                            <input class="form-control" name="orderCodeEdit" id="orderCodeEdit" required>
                        </div>
                        <div class="form-group">
                            <label class="mb-0">7. {{__('msg.partnerName')}}</label>
                            <select class="form-control select2 select2-primary select2-product-details-partner" data-dropdown-css-class="select2-primary" name="partnerIDProductEdit" id="partnerIDProductEdit" style="width: 100%;" required>
                            </select>
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

<!-- insert all -->
<div class="modal fade" id="InsertForm" tabindex="-1" role="dialog" aria-hidden="true" style="z-index:1050; display:none">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="width: 800px;">
            <div class="modal-header bg-primary">
                <h3 class="card-title">{{__('msg.addAllProductByPhase')}}</h3>
                <button type="button" class="close" data-dismiss="modal" area-label="Close">
                    <span aria-hidden="true"><i class="fa fa-close"></i> </span>
                </button>
            </div>
            <form action="{{route('product-details-insert')}}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="col-12 row">
                        <div class="form-group col-6">
                            <label class="mb-0">1. {{__('msg.choosePhaseToCopy')}}</label>
                            <select class="form-control select2 select2-secondary select2-productDetail-insert-current" data-dropdown-css-class="select2-primary" name="phaseIDCurrent" id="phaseIDCurrent" style="width: 100%;" required>
                                <option selected disabled>{{__('msg.choosePhase')}}</option>
                                <?php $numCopy = 0; ?>
                                @foreach($getDropListPhases as $phase)
                                <option value="{{ $phase->id }}">{{ ++$numCopy }}. {{ $phase->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-6">
                            <label class="mb-0">2. {{__('msg.choosePhasePickup')}}</label>
                            <select class="form-control select2 select2-secondary select2-productDetail-insert-selection" data-dropdown-css-class="select2-primary" name="phaseIDSelection" id="phaseIDSelection" style="width: 100%;" required>
                                <option selected disabled>{{__('msg.choosePhase')}}</option>
                                <?php $numCopy = 0; ?>
                                @foreach($getDropListPhases as $phase)
                                <option value="{{ $phase->id }}">{{ ++$numCopy }}. {{ $phase->name }}</option>
                                @endforeach
                            </select>
                        </div>
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

<div class="modal fade" id="RemoveForm" tabindex="-1" role="dialog" aria-hidden="true" style="z-index:1050; display:none">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h3 class="card-title">{{__('msg.removeOriginalProductByPhase')}}</h3>
                <button type="button" class="close" data-dismiss="modal" area-label="Close">
                    <span aria-hidden="true"><i class="fa fa-close"></i> </span>
                </button>
            </div>
            <form action="{{route('product-details-remove')}}" method="g">
                @csrf
                <div class="modal-body">
                    <div class="form-group  ">
                        <label class="mb-0">1. {{__('msg.choosePhaseToRemove')}}</label>
                        <select class="form-control select2 select2-secondary select2-productDetail-remove-selected" data-dropdown-css-class="select2-primary" name="phaseIDSelected" id="phaseIDSelected" style="width: 100%;" required>
                            <option selected disabled>...</option>
                            <?php $numCopy = 0; ?>
                            @foreach($getDropListPhases as $phase)
                            <option value="{{ $phase->id }}">{{ ++$numCopy }}. {{ $phase->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="text-right card-footer">
                    <button type="submit" class="btn btn-danger">{{__('msg.remove')}}</button>
                </div>
            </form>
        </div>
    </div>
</div>

@section('scripts-product-detail')
@include('scripts.script-product-detail')
@endsection
@push('scripts_fixPushMenu')
<script src="../../dist/js/adminlte.min.js?v=3.2.0"></script>
@endpush
@endsection
