@extends('home._layout')
@section('title', 'Product | By Phase')

@section('content')
<section class="content-header bg-gradient-white py-1">
    <div class="container-fluid">
        <div class="row ">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Sản phẩm theo kỳ</h1>
            </div><!-- /.col -->

        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</section>
<section class="content my-2">
    <div class="">
        <div class="card">
            <div class="card-header btn bg-white pb-0" data-card-widget="collapse">
                <h3 class="card-title text-dark ">Danh sách Sản phẩm theo Kỳ</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool text-white" data-card-widget="collapse">
                        <i class="fas fa-minus"></i> </button>
                </div>
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
                <table id="productByPhaseTable" class="table table-bordered table-striped">
                    <thead>
                        <tr class="text-center">
                            <th style="width: 1%">
                                STT
                            </th>
                            <th style="width: 1%">
                                Thuộc Kỳ
                            </th>
                            <th style="width: 5%">
                                Thuộc Chủng
                            </th>
                            <th style="width: 5%">
                                Thuộc Loại
                            </th>
                            <th style="width: 5%">
                                Thuộc Nhóm
                            </th>
                            <th style="width: 1%">
                                Hình ảnh
                            </th>
                            <th style="width: 10%">
                                Mã Sản phẩm
                            </th>
                            <th style="width: 48%">
                                Tên Sản phẩm
                            </th>
                            <th style="width: 1%">
                                ĐVT
                            </th>
                            <th style="width: 10%">
                                Order Code
                            </th>
                            <th style="width: 8%">
                                Giá vốn
                            </th>
                            <th style="width: 8%">
                                Giá bán
                            </th>
                            <th style="width: 8%">
                                Kho nhập về
                            </th>
                            <th style="width: 1%" class="text-center">
                                <a href="/product-by-phase-add-form" class="btn btn-success btn-sm col " data-toggle="modal" data-target="#AddForm">
                                    <i class="fas fa-plus"></i>
                                    <span>Add</span> </a>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $numList = 0;
                        ?>
                        @foreach($getProductsByPhase as $productByPhase)
                        <tr>
                            <td class="text-center "> {{ ++$numList }}</a> </td>
                            <td>
                                {{$productByPhase->thuocky }}
                            </td>
                            <td class="address">
                                {{$productByPhase->thuocchung == '' ? '...' : $productByPhase->thuocchung }}
                            </td>
                            <td class="address">
                                {{$productByPhase->thuocloai == '' ? '...' : $productByPhase->thuocloai}}
                            </td>
                            <td class="address">
                                {{$productByPhase->thuocnhom == '' ? '...' : $productByPhase->thuocnhom}}
                            </td>
                            <td class="address">
                                {{$productByPhase->thuocmasanpham }}
                            </td>
                            <td class="address">
                                {{$productByPhase->thuocsanpham }}
                            </td>
                            <td>
                                {{number_format($productByPhase->costPrice)}}
                            </td>
                            <td>
                                {{number_format($productByPhase->sellingPrice) }}
                            </td>
                            <td class="address">
                                {{($productByPhase->thuocquytrinh) }}
                            </td>
                            <td class="project-actions text-center  py-0">
                                <div class="btn btn-group">
                                    <a class="btn btn-link btn-sm mx-1" data-toggle="modal" data-target="#EditForm{{ $productByPhase->id }}">
                                        <i class="fas fa-pencil-alt">
                                        </i>
                                    </a>
                                    <a class="btn btn-link btn-sm" type="submit" href="/product-by-phase/{{$productByPhase->id}}/delete" onclick="return confirm('Bạn chọn xoá sản phẩm số: {{ $numList }}')">
                                        <i class="fas fa-trash">
                                        </i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <!-- modal form sửa thông tin team -->
                        <div class="modal fade" id="EditForm{{ $productByPhase->id }}" tabindex="0" role="dialog" aria-hidden="true" style="z-index:1050; display:none" aria-labelledby="editUserModalLabel">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header bg-primary">
                                        <h3 class="card-title" id="editUserModalLabel">Sửa thông tin Sản phẩm theo Kỳ</h3>
                                        <button type="button" class="close" data-dismiss="modal" area-label="Close">
                                            <span aria-hidden="true"><i class="fa fa-close"></i> </span>
                                        </button>
                                    </div>
                                    <form action="{{route('product-by-phase-edit-submit', $productByPhase->id)}}" method="post">
                                        @method("PATCH")
                                        @csrf
                                        <div class="modal-body">
                                        <input type="hidden" name="hiddenPhaseID" id="hiddenPhaseID">
                                            <div class="form-group">
                                                <label class="mb-0 ">1. Thuộc Kỳ</label>
                                                <select class="form-control select2 select2-warning select2-product-phase" data-dropdown-css-class="select2-warning" name="phaseIDEdit" style="width: 100%;" required>
                                                    <option selected disabled>Chọn Kỳ khác</option>
                                                    <?php $numEdit = 0; ?>
                                                    @foreach($getDropListPhases as $phase)
                                                    @if ($phase->id == old('hiddenPhaseID', $productToEdit->phaseID))
                                                    <option value="{{ $phase->id }}" selected>{{ ++$numEdit }}. {{ $phase->name }}</option>
                                                    @else
                                                    <option value="{{ $phase->id }}">{{ ++$numEdit }}. {{ $phase->name }}aa</option>
                                                    @endif
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label class="mb-0 ">2. Thuộc Chủng</label>
                                                <select class="form-control select2 select2-warning select2-product-category" data-dropdown-css-class="select2-warning" name="categoryIDEdit" style="width: 100%;" required>
                                                    <option selected value="0">Không thuộc Chủng</option>
                                                    <?php $numEdit = 0; ?>
                                                    @foreach($getDropListCategories as $category)
                                                    @if ($category->id == $productByPhase->categoryID)
                                                    <option value="{{ $category->id }}" selected>{{ ++$numEdit }}. {{ $category->name }}</option>
                                                    @else
                                                    <option value="{{ $category->id }}">{{ ++$numEdit }}. {{ $category->name }}</option>
                                                    @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label class="mb-0 ">3. Thuộc Loại</label>
                                                <select class="form-control select2 select2-warning select2-product-type1" data-dropdown-css-class="select2-warning" name="typeIDEdit" style="width: 100%;">
                                                    <option selected value="0">Không thuộc Loại</option>
                                                    <?php $numEdit = 0; ?>
                                                    @foreach($getDropListTypes as $type)
                                                    @if ($type->id == $productByPhase->typeID)
                                                    <option value="{{ $type->id }}" selected>{{ ++$numEdit }}. {{ $type->name }}</option>
                                                    @else
                                                    <option value="{{ $type->id }}">{{ ++$numEdit }}. {{ $type->name }}</option>
                                                    @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label class="mb-0 ">4. Thuộc Nhóm</label>
                                                <select class="form-control select2 select2-warning select2-product-group" data-dropdown-css-class="select2-warning" name="groupIDEdit" style="width: 100%;">
                                                    <option selected  value="0">Không thuộc Nhóm<menu type="toolbar"></menu></option>
                                                    <?php $numEdit = 0; ?>
                                                    @foreach($getDropListGroups as $group)
                                                    @if ($group->id == $productByPhase->groupID)
                                                    <option value="{{ $group->id }}" selected>{{ ++$numEdit }}. {{ $group->name }}</option>
                                                    @else
                                                    <option value="{{ $group->id }}">{{ ++$numEdit }}. {{ $group->name }}</option>
                                                    @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label class="mb-0 ">5. Sản phẩm</label>
                                                <select class="form-control select2 select2-warning select2-product-product" data-dropdown-css-class="select2-warning" name="productIDEdit" style="width: 100%;" required>
                                                    <option selected disabled>Chọn Sản phẩm khác</option>
                                                    <?php $numEdit = 0; ?>
                                                    @foreach($getDropListProducts as $product)
                                                    @if ($product->id == $productByPhase->productID)
                                                    <option value="{{ $product->id }}" selected>{{ ++$numEdit }}. {{ $product->code }} - {{ $product->name }}</option>
                                                    @else
                                                    <option value="{{ $product->id }}">{{ ++$numEdit }}. {{ $product->code }} - {{ $product->name }}</option>
                                                    @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label class="mb-0">6. Giá vốn</label>
                                                <input class="form-control money-load" name="costPriceEdit" type="text" oninput="formatCurrency(this)" value="{{ ($productByPhase->costPrice) }}" required>
                                            </div>
                                            <div class="form-group">
                                                <label class="mb-0">7. Giá bán</label>
                                                <input class="form-control money-load" name="sellingPriceEdit" type="text" oninput="formatCurrency(this)" value="{{ ($productByPhase->sellingPrice) }}" required>
                                            </div>
                                            <div class="form-group">
                                                <label class="mb-0 ">8. Thuộc quy trình</label>
                                                <select class="form-control select2 select2-warning select2-product-group" data-dropdown-css-class="select2-warning" name="processIDEdit" style="width: 100%;" required>
                                                    <option selected disabled>Chọn Quy trình khác</option>
                                                    <?php $numEdit = 0; ?>
                                                    @foreach($getDropListProcesses as $process)
                                                    @if ($process->id == $productByPhase->processID)
                                                    <option value="{{ $process->id }}" selected>{{ ++$numEdit }}. {{ $process->name }}</option>
                                                    @else
                                                    <option value="{{ $process->id }}">{{ ++$numEdit }}. {{ $process->name }}</option>
                                                    @endif
                                                    @endforeach
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
                        <!-- modal form sửa thông tin team -->
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        </div>

</section>
<!-- thêm hoặc sửa team phát triển -->
<div class="modal fade" id="AddForm" tabindex="-1" role="dialog" aria-hidden="true" style="z-index:1050; display:none">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success pb-0">
                <h3 class="card-title">Thêm mới Sản phẩm theo Kỳ</h3>
                <button type="button" class="close" data-dismiss="modal" area-label="Close">
                    <span aria-hidden="true"><i class="fa fa-close"></i> </span>
                </button>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="{{route('product-by-phase-add-submit')}}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label class="mb-0 text-primary">1. Thuộc Kỳ</label>
                        <select class="form-control select2 select2-primary" data-dropdown-css-class="select2-primary" name="phaseIDAdd" style="width: 100%;" required>
                            <option selected disabled>Chọn Kỳ khác</option>
                            <?php $numEdit = 0; ?>
                            @foreach($getDropListPhases as $phase)
                            <option value="{{ $phase->id }}">{{ ++$numEdit }}. {{ $phase->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="mb-0 text-primary">2. Thuộc sản phẩm</label>
                        <select class="form-control select2 select2-primary" data-dropdown-css-class="select2-primary" name="productIDAdd" style="width: 100%;" required>
                            <option selected disabled>Chọn Sản phẩm </option>
                            <?php $numEdit = 0; ?>
                            @foreach($getDropListProducts as $product)
                            <option value="{{ $product->id }}">{{ ++$numEdit }}. {{ $product->code }} - {{ $product->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="mb-0 text-primary">3. Thuộc Chủng</label>
                        <select class="form-control select2 select2-primary" data-dropdown-css-class="select2-primary" name="categoryIDAdd" style="width: 100%;" >
                            <option value="0" selected >Không thuộc Chủng </option>
                            <?php $numEdit = 0; ?>
                            @foreach($getDropListCategories as $category)
                            <option value="{{ $category->id }}">{{ ++$numEdit }}.  {{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="mb-0 text-primary">4. Thuộc Loại</label>
                        <select class="form-control select2 select2-primary " data-dropdown-css-class="select2-primary" name="typeIDAdd" style="width: 100%;" >
                            <option value="0" selected >Không thuộc Loại </option>
                            <?php $numEdit = 0; ?>
                            @foreach($getDropListTypes as $type)
                            <option value="{{ $type->id }}">{{ ++$numEdit }}.  {{ $type->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="mb-0 text-primary">5. Thuộc Nhóm</label>
                        <select class="form-control select2 select2-primary" data-dropdown-css-class="select2-primary" name="groupIDAdd" style="width: 100%;" >
                            <option value="0" selected >Không thuộc Nhóm</option>
                            <?php $numEdit = 0; ?>
                            @foreach($getDropListGroups as $group)
                            <option value="{{ $group->id }}">{{ ++$numEdit }}. {{ $group->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="mb-0">6. Giá vốn</label>
                        <input type="text" name="costPriceAdd" class="form-control" required oninput="formatCurrency(this)">
                    </div>
                    <div class="form-group">
                        <label class="mb-0">7. Giá bán</label>
                        <input class="form-control" name="sellingPriceAdd" type="text" required oninput="formatCurrency(this)">
                    </div>
                    <div class="form-group">
                        <label class="mb-0 text-primary">8. Thuộc Quy trình</label>
                        <select class="form-control select2 select2-primary" data-dropdown-css-class="select2-primary" name="processIDAdd" style="width: 100%;" required>
                            <option selected disabled>Chọn quy trình</option>
                            <?php $numEdit = 0; ?>
                            @foreach($getDropListProcesses as $process)
                            <option value="{{ $process->id }}">{{ ++$numEdit }}. {{ $process->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <!-- /.card-body -->
                </div>
                <div class="text-right card-footer">
                        <button type="submit" class="btn btn-primary">{{__('msg.save')}}</button>
                    </div>
            </form>
        </div>
    </div>
</div>
@endsection




<!-- xong -->
<div class="modal fade" id="AddForm" tabindex="-1" role="dialog" aria-hidden="true" style="z-index:1050; display:none; ">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="width: 800px;">
            <div class="modal-header bg-primary">
                <h3 class="card-title">Thêm mới Sản phẩm gốc</h3>
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
                            <label class="mb-0 text-primary">1. Thuộc Kỳ</label>
                            <select class="form-control select2 select2-primary" data-dropdown-css-class="select2-primary" name="phaseIDAdd" style="width: 100%;" required>
                                <option selected disabled>Chọn Kỳ khác</option>
                                <?php $numAdd = 0; ?>
                                @foreach($getDropListPhases as $phase)
                                <option value="{{ $phase->id }}">{{ ++$numAdd }}. {{ $phase->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="mb-0 text-primary">2. Thuộc Chủng</label>
                            <select class="form-control select2 select2-primary" data-dropdown-css-class="select2-primary" name="categoryIDAdd" style="width: 100%;">
                                <option value="0" selected>Không thuộc Chủng </option>
                                <?php $numAdd = 0; ?>
                                @foreach($getDropListCategories as $category)
                                <option value="{{ $category->id }}">{{ ++$numAdd }}. {{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="mb-0 text-primary">3. Thuộc Loại</label>
                            <select class="form-control select2 select2-primary" data-dropdown-css-class="select2-primary" name="typeIDAdd" style="width: 100%;">
                                <option value="0" selected>Không thuộc Loại </option>
                                <?php $numAdd = 0; ?>
                                @foreach($getDropListTypes as $type)
                                <option value="{{ $type->id }}">{{ ++$numAdd }}. {{ $type->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="mb-0 text-primary">4. Thuộc Nhóm</label>
                            <select class="form-control select2 select2-primary" data-dropdown-css-class="select2-primary" name="groupIDAdd" style="width: 100%;">
                                <option value="0" selected>Không thuộc Nhóm</option>
                                <?php $numAdd = 0; ?>
                                @foreach($getDropListGroups as $group)
                                <option value="{{ $group->id }}">{{ ++$numAdd }}. {{ $group->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="mb-0">5. Mã sản phẩm</label>
                            <input  class="form-control" name="codeAdd" required>
                        </div>
                        <div class="form-group">
                            <label class="mb-0">6. Tên hiển thị</label>
                            <input  class="form-control" name="nameAdd" required>
                        </div>
                    </div>
                    <div class="col-sm-6">

                        <div class="form-group">
                            <label class="mb-0">7. Order Code</label>
                            <input class="form-control" name="orderCodeAdd" required>
                        </div>
                        <div class="form-group">
                            <label class="mb-0">8. ĐVT</label>
                            <input class="form-control" name="unitAdd"  required>
                        </div>
                        <div class="form-group">
                            <label class="mb-0">9. Giá vốn</label>
                            <input type="text" name="costPriceAdd" class="form-control" required oninput="formatCurrency(this)">
                        </div>
                        <div class="form-group">
                            <label class="mb-0">10. Giá bán</label>
                            <input class="form-control" name="sellingPriceAdd" type="text" required oninput="formatCurrency(this)">
                        </div>
                        <div class="form-group">
                            <label class="mb-0 text-primary">11. Nhập về Kho</label>
                            <select class="form-control select2 select2-primary" data-dropdown-css-class="select2-primary" name="warehouseIDAdd" style="width: 100%;" required>
                                <option selected disabled>Chọn Kho chứa</option>
                                <?php $numAdd = 0; ?>
                                @foreach($getDropListWarehouses as $warehouse)
                                <option value="{{ $warehouse->id }}">{{ ++$numAdd }}. {{ $warehouse->name }}</option>
                                @endforeach
                            </select>
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
