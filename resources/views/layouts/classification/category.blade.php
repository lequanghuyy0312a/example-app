@extends('home._layout')
@section('title', 'Classification | Category')

@section('content')

<section class="content-header bg-gradient-white py-1 shadow">
    <div class="container-fluid">
        <div class="row ">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Chủng</h1>
            </div><!-- /.col -->

        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</section>
<section class="content my-2">
    <div class="">

        <!-- danh sách team  -->
        <div class="card">
            <div class="card-header btn bg-white pb-0" data-card-widget="collapse">
                <h3 class="card-title text-dark ">Danh sách Chủng</h3>
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
                <table id="categoryTable" class="table table-bordered table-striped">
                    <thead>
                        <tr class="text-center">
                            <th style="width: 1%">
                                STT
                            </th>
                            <th style="width: 30%">
                                Tên Chủng
                            </th>
                            <th style="width: 1%" class="text-center">
                                <a href="/category-add-form" class="btn btn-success btn-sm col " data-toggle="modal" data-target="#AddForm">
                                    <i class="fas fa-plus"></i>
                                    <span>Add</span> </a>
                            </th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        $numList = 0;
                        ?>
                        @foreach($getCategories as $category)
                        <tr>
                            <td class="text-center "> {{ ++$numList }}</a> </td>
                            <td>
                                {{$category->name }}
                            </td>
                            <td class="project-actions text-center  py-0">
                                <div class="btn btn-group">
                                    <a class="btn btn-link btn-sm mx-1" data-toggle="modal" data-target="#EditForm{{ $category->id }}">
                                        <i class="fas fa-pencil-alt">
                                        </i>
                                    </a>
                                    <a class="btn btn-link btn-sm" type="submit" href="/category/{{$category->id}}/delete" onclick="return confirm('Bạn chọn xoá Chủng: {{ $numList }} -- {{ $category->name}}?')">
                                        <i class="fas fa-trash">
                                        </i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <!-- modal form sửa thông tin team -->
                        <div class="modal fade" id="EditForm{{ $category->id }}"  tabindex="0" role="dialog" aria-hidden="true" style="z-index:1050; display:none" aria-labelledby="editUserModalLabel">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header bg-primary">
                                        <h3 class="card-title" id="editUserModalLabel">Sửa thông tin Chủng</h3>
                                        <button type="button" class="close" data-dismiss="modal" area-label="Close">
                                            <span aria-hidden="true"><i class="fa fa-close"></i> </span>
                                        </button>
                                    </div>
                                    <form action="{{route('category-edit-submit', $category->id)}}" method="post">
                                        @method("PATCH")
                                        @csrf
                                        <div class="modal-body">

                                            <div class="form-group">
                                                <label class="mb-0">1. Tên Chủng</label>
                                                <input class="form-control" name="nameEdit" value="{{ $category->name }}" required>
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
            <div class="modal-header bg-primary">
                <h3 class="card-title">Thêm mới Chủng</h3>
                <button type="button" class="close" data-dismiss="modal" area-label="Close">
                    <span aria-hidden="true"><i class="fa fa-close"></i> </span>
                </button>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="{{route('category-add-submit')}}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label class="mb-0">1. Tên Chủng mới</label>
                        <input class="form-control" name="nameAdd" placeholder="ex: VNJ 1" required>
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