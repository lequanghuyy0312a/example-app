@extends('home._layout')
@section('title', 'Product | List')

@section('content')
<section class="content-header bg-gradient-white shadow py-1">
    <div class="container-fluid">
        <div class="row ">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Quy trình</h1>
            </div><!-- /.col -->

        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</section>
<section class="content my-2">
    <div class="">
        <!-- danh sách product  -->
        <div class="card">
            <div class="card-header btn bg-white pb-0" data-card-widget="collapse">
                <h3 class="card-title text-dark ">Quản lý các quy trình</h3>
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

                <div>
                    <table id="processTable" class="table table-bordered table-striped">
                        <thead style="position: sticky; top:0px; background-color: #fff; z-index: 1;">
                            <tr>
                                <th style="width: 1%">
                                    STT
                                </th>
                                <th style="width: 50%">
                                    Tên quy trình
                                </th>
                                <th style="width: 24%">
                                    Kho xuất
                                </th>
                                <th style="width: 24%">
                                    Kho nhập
                                </th>
                                <th style="width: 1%" class="text-center">
                                    <a href="/product-add-form" class="btn btn-success btn-sm col " data-toggle="modal" data-target="#AddForm">
                                        <i class="fas fa-plus"></i>
                                        <span>Add</span> </a>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $numList = 0;
                            ?>
                            @foreach($getProcesses as $process)
                            <tr>
                                <td class="text-center "> {{ ++$numList }}</a> </td>
                                <td>
                                    {{$process->name }}
                                </td>
                                <td>
                                    {{$process->warehouseExportName}}
                                </td>
                                <td>
                                {{$process->warehouseImportName}}
                                </td>
                                <td class="project-actions text-center  py-0">
                                    <div class="btn btn-group">
                                        <a class="btn btn-link btn-sm mx-1" data-toggle="modal" data-target="#EditForm{{ $process->id }}">
                                            <i class="fas fa-pencil-alt">
                                            </i>
                                        </a>
                                        <a class="btn btn-link btn-sm" type="submit" href="/process/{{$process->id}}/delete" onclick="return confirm('Bạn chọn xoá Nhóm: {{ $numList }} -- {{ $process->name}}?')">
                                            <i class="fas fa-trash">
                                            </i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <!-- modal form sửa thông tin team -->
                            <div class="modal fade" id="EditForm{{ $process->id }}"  tabindex="0" role="dialog" aria-hidden="true" style="z-index:1050; display:none" aria-labelledby="editUserModalLabel">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header bg-primary">
                                            <h3 class="card-title" id="editUserModalLabel">Sửa thông tin Loại</h3>
                                            <button type="button" class="close" data-dismiss="modal" area-label="Close">
                                                <span aria-hidden="true"><i class="fa fa-close"></i> </span>
                                            </button>
                                        </div>
                                        <form action="{{route('process-edit-submit', $process->id)}}" method="post">
                                            @method("PATCH")
                                            @csrf
                                            <div class="modal-body">

                                                <div class="form-group">
                                                    <label class="mb-0">1. Tên quy trình</label>
                                                    <input class="form-control" name="nameEdit" value="{{ $process->name }}" required>
                                                </div>
                                                <div class="form-group">
                                                    <label class="mb-0 text-danger">2. Kho xuất</label>
                                                    <select class="form-control select2 select2-danger select2-process-import" data-dropdown-css-class="select2-danger" name="warehouseExportEdit" style="width: 100%;" required>
                                                        <option selected disabled>Chọn Kho xuất khác</option>
                                                        <?php $numEdit = 0; ?>
                                                        @foreach($getDropListWarehouses as $warehouse)
                                                        @if ($warehouse->id == $process->warehouseExport)
                                                        <option value="{{ $warehouse->id }}" selected>{{ ++$numEdit }}. {{ $warehouse->name }}</option>
                                                        @else
                                                        <option value="{{ $warehouse->id }}">{{ ++$numEdit }}. {{ $warehouse->name }}</option>
                                                        @endif
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label class="mb-0 text-danger">3. Kho nhập</label>
                                                    <select class="form-control select2 select2-danger select2-process-export" data-dropdown-css-class="select2-danger" name="warehouseImportEdit" style="width: 100%;" required>
                                                        <option selected disabled>Chọn Kho nhập khác</option>
                                                        <?php $numEdit = 0; ?>
                                                        @foreach($getDropListWarehouses as $warehouse)
                                                        @if ($warehouse->id == $process->warehouseImport)
                                                        <option value="{{ $warehouse->id }}" selected>{{ ++$numEdit }}. {{ $warehouse->name }}</option>
                                                        @else
                                                        <option value="{{ $warehouse->id }}">{{ ++$numEdit }}. {{ $warehouse->name }}</option>
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
    </div>
</section>
<!-- thêm hoặc sửa product phát triển -->
<div class="modal fade" id="AddForm" tabindex="-1" role="dialog" aria-hidden="true" style="z-index:1050; display:none">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h3 class="card-title">Thêm mới Sản phẩm gốc</h3>
                <button type="button" class="close" data-dismiss="modal" area-label="Close">
                    <span aria-hidden="true"><i class="fa fa-close"></i> </span>
                </button>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="{{route('process-add-submit')}}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label class="mb-0">1. Tên quy trình</label>
                        <input class="form-control" name="codeAdd" placeholder="ex: xuất kho" required>
                    </div>

                    <div class="form-group">
                        <label class="mb-0 text-primary">2. Kho xuất</label>
                        <select class="form-control select2 select2-primary" data-dropdown-css-class="select2-primary" name="warehouseExportAdd" style="width: 100%;" required>
                            <option selected disabled>Chọn Kho xuất</option>
                            <?php $numEdit = 0; ?>
                            @foreach($getDropListWarehouses as $warehouseExport)
                            <option value="{{ $warehouseExport->id }}">{{ ++$numEdit }}. {{ $warehouseExport->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="mb-0 text-primary">3. Kho nhập</label>
                        <select class="form-control select2 select2-primary" data-dropdown-css-class="select2-primary" name="warehouseImportAdd" style="width: 100%;" required>
                            <option selected disabled>Chọn Kho nhập</option>
                            <?php $numEdit = 0; ?>
                            @foreach($getDropListWarehouses as $warehouseImport)
                            <option value="{{ $warehouseImport->id }}">{{ ++$numEdit }}. {{ $warehouseImport->name }}</option>
                            @endforeach
                        </select>
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

@endsection
