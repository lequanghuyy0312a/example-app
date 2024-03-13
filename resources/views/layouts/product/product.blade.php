@extends('home._layout')
@section('title', 'Product | List')

@section('content')
<section class="content-header bg-gradient-white shadow py-1">
    <div class="container-fluid">
        <div class="row ">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Sản phẩm gốc</h1>
            </div><!-- /.col -->

        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</section>
<section class="content my-2">
    <div class="">
        <!-- danh sách product  -->
        <div class="card">
            <div class="card-header btn bg-white pb-0" data-card-widget="collapse">
                <h3 class="card-title text-dark ">Danh sách Sản phẩm gốc</h3>
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
                <div class="col-12 row p-0 m-0 justify-content-end" style="position: sticky; top:0px; background-color: #fff; z-index: 1;">
                    <div class="input-group mb-2 w-50">
                        <input class="form-control" type="text" id="searchInput" placeholder="Search">
                        <div class="input-group-append">
                            <span class="input-group-text"><i class="fas fa-search"></i></span>
                        </div>
                    </div>
                </div>
                <div>
                    <table id="productTable" class="table table-bordered table-striped">
                        <thead style="position: sticky; top:60px; background-color: #fff; z-index: 1;">
                            <tr class="text-center">
                                <th style="width: 1%">
                                    STT
                                </th>
                                <th style="width: 4%">
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
                                <th style="width: 10%">
                                    Mã Sản phẩm
                                </th>
                                <th style="width: 48%">
                                    Tên Sản phẩm
                                </th>
                                <th style="width: 2%">
                                    ĐVT
                                </th>
                                <th style="width: 10%">
                                    Order Code
                                </th>
                                <th style="width: 2%">
                                    Giá vốn
                                </th>
                                <th style="width: 2%">
                                    Giá bán
                                </th>
                                <th style="width: 5%">
                                    Kho nhập về
                                </th>

                                <th style="width: 1%" class="text-center">
                                    <a href="/product-add-form" class="btn btn-success btn-sm col " data-toggle="modal" data-target="#AddForm">
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
<!-- thêm hoặc sửa product phát triển -->



<!-- ADD -->
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
                            <label class="mb-0 text-primary">5. Nhập về Kho</label>
                            <select class="form-control select2 select2-primary" data-dropdown-css-class="select2-primary" name="warehouseIDAdd" style="width: 100%;" required>
                                <option selected disabled>Chọn Kho chứa</option>
                                <?php $numAdd = 0; ?>
                                @foreach($getDropListWarehouses as $warehouse)
                                <option value="{{ $warehouse->id }}">{{ ++$numAdd }}. {{ $warehouse->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="mb-0">6. Mã sản phẩm</label>
                            <input class="form-control" name="codeAdd" required>
                        </div>
                        <div class="form-group">
                            <label class="mb-0">7. Tên hiển thị</label>
                            <input class="form-control" name="nameAdd" required>
                        </div>
                        <div class="form-group">
                            <label class="mb-0">8. Order Code</label>
                            <input class="form-control" name="orderCodeAdd" required>
                        </div>
                        <div class="form-group">
                            <label class="mb-0">9. ĐVT</label>
                            <input class="form-control" name="unitAdd" required>
                        </div>
                        <div class="form-group">
                            <label class="mb-0">10. Giá vốn</label>
                            <input type="text" name="costPriceAdd" class="form-control" required oninput="formatCurrency(this)">
                        </div>
                        <div class="form-group">
                            <label class="mb-0">11. Giá bán</label>
                            <input class="form-control" name="sellingPriceAdd" type="text" required oninput="formatCurrency(this)">
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
                    <h3 class="card-title" id="editUserModalLabel">Sửa thông tin Sản phẩm</h3>
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
                                <label class="mb-0 text-primary">1. Thuộc Kỳ</label>
                                <select class="form-control select2 select2-primary select2-product-phase" data-dropdown-css-class="select2-primary" name="phaseIDEdit" id="phaseIDEdit" style="width: 100%;" required>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="mb-0 text-primary">2. Thuộc Chủng</label>
                                <select class="form-control select2 select2-primary select2-product-category" data-dropdown-css-class="select2-primary" name="categoryIDEdit" id="categoryIDEdit" style="width: 100%;">
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="mb-0 text-primary">3. Thuộc Loại</label>
                                <select class="form-control select2 select2-primary select2-product-type" data-dropdown-css-class="select2-primary" name="typeIDEdit" id="typeIDEdit" style="width: 100%;">
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="mb-0 text-primary">4. Thuộc Nhóm</label>
                                <select class="form-control select2 select2-primary select2-product-group" data-dropdown-css-class="select2-primary" name="groupIDEdit" id="groupIDEdit" style="width: 100%;">
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="mb-0 text-primary">5. Nhập về Kho</label>
                                <select class="form-control select2 select2-primary select2-product-warehouse" data-dropdown-css-class="select2-primary" name="warehouseIDEdit" id="warehouseIDEdit" style="width: 100%;" required>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="mb-0">6. Mã sản phẩm</label>
                                <input class="form-control" name="codeEdit" id="codeEdit" required>
                            </div>
                            <div class="form-group">
                                <label class="mb-0">7. Tên hiển thị</label>
                                <input class="form-control" name="nameEdit" id="nameEdit" required>
                            </div>
                            <div class="form-group">
                                <label class="mb-0">8. Order Code</label>
                                <input class="form-control" name="orderCodeEdit" id="orderCodeEdit" required>
                            </div>
                            <div class="form-group">
                                <label class="mb-0">9. ĐVT</label>
                                <input class="form-control" name="unitEdit" id="unitEdit" required>
                            </div>
                            <div class="form-group">
                                <label class="mb-0">10. Giá vốn</label>
                                <input type="text" name="costPriceEdit" id="costPriceEdit" class="form-control" required oninput="formatCurrency(this)">
                            </div>
                            <div class="form-group">
                                <label class="mb-0">11. Giá bán</label>
                                <input class="form-control" name="sellingPriceEdit" id="sellingPriceEdit" type="text" required oninput="formatCurrency(this)">
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

@endsection
