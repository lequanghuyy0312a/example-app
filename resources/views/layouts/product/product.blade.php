@extends('home._layout')
@section('title', 'Product | List')

@section('content')
<section class="content-header bg-gradient-white shadow py-1">
    <div class="container-fluid">
        <div class="row ">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">{{__('msg.originalProduct')}}</h1>
            </div><!-- /.col -->

        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</section>
<section class="content my-2">
    <div class="">
        <!-- danh sách product  -->
        <div class="card">
            <div class="card-header bg-white pb-0">
                <h3 class="card-title"> <i>{{ $countProducts }} (items)</i>
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
                            <select class="form-control select2 select2-primary" data-dropdown-css-class="select2-primary" name="phaseIDSelectionToList" id="phaseIDSelectionToList" style="width: 30%;" required>
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
                            <input class="form-control" type="text" id="searchInput" placeholder="Search">
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fas fa-search"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <table id="productTable" class="table table-bordered table-striped">
                        <thead >
                            <tr class="text-center" >
                                <th style="width: 1%">
                                    {{__('msg.num')}}
                                </th>
                                <th style="width: 4%">
                                    {{__('msg.belongPhase')}}
                                </th>
                                <th style="width: 8%">
                                    {{__('msg.belongCategory')}}
                                </th>
                                <th style="width: 10%">
                                    {{__('msg.belongType')}}
                                </th>
                                <th style="width: 10%">
                                    {{__('msg.belongGroup')}}
                                </th>
                                <th style="width: 8%">
                                    {{__('msg.originalProductCode')}}
                                </th>
                                <th style="width: 48%">
                                    {{__('msg.originalProductName')}}
                                </th>
                                <th style="width: 1%">
                                    {{__('msg.unit')}}
                                </th>
                                <th style="width: 9%">
                                    {{__('msg.inWarehouse')}}
                                </th>

                                <th style="position: sticky; right:0px; width: 1%" class="text-center">
                                    <a href="/product-add-form" class="btn btn-success btn-sm col " data-toggle="modal" data-target="#AddForm">
                                        <i class="fas fa-plus"></i> </a>
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
    </div>
    <button id="backToTopBtn" onclick="scrollToTop()">
        <i class="fa-solid fa-circle-chevron-up text-success rounded-circle bg-white text-xl"></i>
        <p class="text-success ">Back to top</p>
    </button>
</section>
<!-- thêm hoặc sửa product phát triển -->



<!-- ADD -->
<div class="modal fade" id="AddForm" tabindex="-1" role="dialog" aria-hidden="true" style="z-index:1050; display:none; ">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="width: 800px;">
            <div class="modal-header bg-primary">
                <h3 class="card-title"> {{__('msg.addNewProduct')}}</h3>
                <button type="button" class="close" data-dismiss="modal" area-label="Close">
                    <span aria-hidden="true"><i class="fa fa-close"></i> </span>
                </button>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="{{route('product-add-submit')}}" method="post">
                @csrf
                <div class="modal-body   row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="mb-0 text-primary">1. {{__('msg.belongPhase')}}</label>
                            <select class="form-control select2 select2-primary" data-dropdown-css-class="select2-primary" name="phaseIDAdd" style="width: 100%;" required>
                                <option selected disabled>{{__('msg.chooseOtherPhase')}}</option>
                                <?php $numAdd = 0; ?>
                                @foreach($getDropListPhases as $phase)
                                <option value="{{ $phase->id }}">{{ ++$numAdd }}. {{ $phase->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="mb-0 text-primary">2. {{__('msg.belongCategory')}}</label>
                            <select class="form-control select2 select2-primary" data-dropdown-css-class="select2-primary" name="categoryIDAdd" style="width: 100%;">
                                <option value="0" selected>Không thuộc Chủng </option>
                                <?php $numAdd = 0; ?>
                                @foreach($getDropListCategories as $category)
                                <option value="{{ $category->id }}">{{ ++$numAdd }}. {{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="mb-0 text-primary">3. {{__('msg.belongType')}}</label>
                            <select class="form-control select2 select2-primary" data-dropdown-css-class="select2-primary" name="typeIDAdd" style="width: 100%;">
                                <option value="0" selected>{{__('msg.chooseOtherType')}}</option>
                                <?php $numAdd = 0; ?>
                                @foreach($getDropListTypes as $type)
                                <option value="{{ $type->id }}">{{ ++$numAdd }}. {{ $type->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="mb-0 text-primary">4. {{__('msg.belongGroup')}}</label>
                            <select class="form-control select2 select2-primary" data-dropdown-css-class="select2-primary" name="groupIDAdd" style="width: 100%;">
                                <option value="0" selected>{{__('msg.chooseOtherGroup')}}</option>
                                <?php $numAdd = 0; ?>
                                @foreach($getDropListGroups as $group)
                                <option value="{{ $group->id }}">{{ ++$numAdd }}. {{ $group->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="mb-0 text-primary">5. {{__('msg.inWarehouse')}}</label>
                            <select class="form-control select2 select2-primary" data-dropdown-css-class="select2-primary" name="warehouseIDAdd" style="width: 100%;" required>
                                <option selected disabled>{{__('msg.chooseOtherWarehouse')}}</option>
                                <?php $numAdd = 0; ?>
                                @foreach($getDropListWarehouses as $warehouse)
                                <option value="{{ $warehouse->id }}">{{ ++$numAdd }}. {{ $warehouse->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="mb-0">6. {{__('msg.originalProductCode')}}</label>
                            <input class="form-control" name="codeAdd" required>
                        </div>
                        <div class="form-group">
                            <label class="mb-0">7. {{__('msg.originalProductName')}}</label>
                            <input class="form-control" name="nameAdd" required>
                        </div>
                        <div class="form-group">
                            <label class="mb-0">8. {{__('msg.unit')}}</label>
                            <input class="form-control" name="unitAdd" required>
                        </div>
                    </div>

                </div>
                <div class="text-right card-footer">
                    <button type="submit" class="btn btn-primary">{{__('msg.save')}}</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- EDIT -->
<div id="modal-container">
    <div class="modal fade" id="editModalProduct" tabindex="0" role="dialog" aria-hidden="true" style="z-index:1050; display:none" aria-labelledby="editUserModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content" style="width: 800px;">
                <div class="modal-header bg-primary">
                    <h3 class="card-title" id="editUserModalLabel">{{__('msg.editProduct')}}</h3>
                    <button type="button" class="close" data-dismiss="modal" area-label="Close">
                        <span aria-hidden="true"><i class="fa fa-close"></i> </span>
                    </button>
                </div>
                <form id="editProductForm" method="post">
                    @method("PATCH")
                    @csrf
                    <div class="modal-body row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="mb-0 text-primary">1. {{__('msg.belongPhase')}}</label>
                                <select class="form-control select2 select2-primary select2-product-phase" data-dropdown-css-class="select2-primary" name="phaseIDEdit" id="phaseIDEdit" style="width: 100%;" required>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="mb-0 text-primary">2. {{__('msg.belongCategory')}}</label>
                                <select class="form-control select2 select2-primary select2-product-category" data-dropdown-css-class="select2-primary" name="categoryIDEdit" id="categoryIDEdit" style="width: 100%;">
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="mb-0 text-primary">3. {{__('msg.belongType')}}</label>
                                <select class="form-control select2 select2-primary select2-product-type" data-dropdown-css-class="select2-primary" name="typeIDEdit" id="typeIDEdit" style="width: 100%;">
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="mb-0 text-primary">4. {{__('msg.belongGroup')}}</label>
                                <select class="form-control select2 select2-primary select2-product-group" data-dropdown-css-class="select2-primary" name="groupIDEdit" id="groupIDEdit" style="width: 100%;">
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="mb-0 text-primary">5. {{__('msg.inWarehouse')}}</label>
                                <select class="form-control select2 select2-primary select2-product-warehouse" data-dropdown-css-class="select2-primary" name="warehouseIDEdit" id="warehouseIDEdit" style="width: 100%;" required>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="mb-0">6. {{__('msg.originalProductCode')}}</label>
                                <input class="form-control" name="codeEdit" id="codeEdit" required>
                            </div>
                            <div class="form-group">
                                <label class="mb-0">7. {{__('msg.originalProductName')}}</label>
                                <input class="form-control" name="nameEdit" id="nameEdit" required>
                            </div>
                            <div class="form-group">
                                <label class="mb-0">8. {{__('msg.unit')}}</label>
                                <input class="form-control" name="unitEdit" id="unitEdit" required>
                            </div>
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
            <form action="{{route('product-insert-byPhase')}}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="col-12 row">
                        <div class="form-group col-6">
                            <label class="mb-0">1. {{__('msg.choosePhaseToCopy')}}</label>
                            <select class="form-control select2 select2-secondary select2-product-insert-current" data-dropdown-css-class="select2-primary" name="phaseIDCurrent" id="phaseIDCurrent" style="width: 100%;" required>
                                <option selected disabled>{{__('msg.choosePhase')}}</option>
                                <?php $numCopy = 0; ?>
                                @foreach($getDropListPhases as $phase)
                                <option value="{{ $phase->id }}">{{ ++$numCopy }}. {{ $phase->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-6">
                            <label class="mb-0">2. {{__('msg.choosePhasePickup')}}</label>
                            <select class="form-control select2 select2-secondary select2-product-insert-selection" data-dropdown-css-class="select2-primary" name="phaseIDSelection" id="phaseIDSelection" style="width: 100%;" required>
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
            <form action="{{route('product-remove-byPhase')}}" method="g">
                @csrf
                <div class="modal-body">
                    <div class="form-group  ">
                        <label class="mb-0">1. {{__('msg.choosePhaseToRemove')}}</label>
                        <select class="form-control select2 select2-secondary select2-product-remove-selected" data-dropdown-css-class="select2-primary" name="phaseIDSelected" id="phaseIDSelected" style="width: 100%;" required>
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

@section('scripts-product')
@include('scripts.script-product')
@endsection
@push('scripts_fixPushMenu')
<script src="../../dist/js/adminlte.min.js?v=3.2.0"></script>
@endpush
@endsection
