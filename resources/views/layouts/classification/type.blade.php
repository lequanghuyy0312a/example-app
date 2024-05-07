@extends('home._layout')
@section('title', 'Classification | Group')

@section('content')
<section class="content-header bg-gradient-white py-1 shadow">
    <div class="container-fluid">
        <div class="row ">
            <div class="col-sm-6">
                <h1 class="m-0 text-navy">{{__('msg.type')}}</h1>
            </div><!-- /.col -->

        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</section>
<section class="content my-2">
    <div class="">

        <!-- danh sách team  -->
        <div class="card">
            <div class="card-header btn bg-white pb-0" data-card-widget="collapse">
                <h3 class="card-title text-navy ">{{__('msg.typeList')}}</h3>
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
                <table id="typeTable" class="table table-bordered table-striped">
                    <thead>
                        <tr class="text-center">
                            <th style="width: 1%">
                            {{__('msg.num')}}
                            </th>
                            <th>
                                {{__('msg.typeName')}}
                            </th>
                            <th style="width: 1%" class="text-center">
                                <a href="/type-add-form" class="btn btn-success btn-sm col " data-toggle="modal" data-target="#AddForm">
                                    <i class="fas fa-plus"></i> </a>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $numList = 0;
                        ?>
                        @foreach($getTypes as $type)
                        <tr>
                            <td class="text-center "> {{ ++$numList }}</a> </td>
                            <td>
                                {{$type->name }}
                            </td>
                            <td class="project-actions text-center  py-0">
                                <div class="btn btn-group">
                                    <a class="btn btn-link btn-sm mx-1" data-toggle="modal" data-target="#EditForm{{ $type->id }}">
                                        <i class="fas fa-pencil-alt">
                                        </i>
                                    </a>
                                    <a class="btn btn-link btn-sm" type="submit" href="/type/{{$type->id}}/delete" onclick="return confirm('Are you sure you want to delete: {{ $numList }} -- {{ $type->name}}?')">
                                        <i class="fas fa-trash">
                                        </i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <!-- modal form sửa thông tin team -->
                        <div class="modal fade" id="EditForm{{ $type->id }}" tabindex="0"  role="dialog" aria-hidden="true" style="z-index:1050; display:none" aria-labelledby="editUserModalLabel">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header bg-primary">
                                        <h3 class="card-title" id="editUserModalLabel">{{__('msg.editType')}}</h3>
                                        <button type="button" class="close" data-dismiss="modal" area-label="Close">
                                            <span aria-hidden="true"><i class="fa fa-close"></i> </span>
                                        </button>
                                    </div>
                                    <form action="{{route('type-edit-submit', $type->id)}}" method="post">
                                        @method("PATCH")
                                        @csrf
                                        <div class="modal-body">

                                            <div class="form-group">
                                                <label class="mb-0">1. {{__('msg.typeName')}}</label>
                                                <input class="form-control" name="nameEdit" value="{{ $type->name }}" required>
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
                <h3 class="card-title">{{__('msg.addNewType')}}</h3>
                <button type="button" class="close" data-dismiss="modal" area-label="Close">
                    <span aria-hidden="true"><i class="fa fa-close"></i> </span>
                </button>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="{{route('type-add-submit')}}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label class="mb-0">1. {{__('msg.newTypeName')}}</label>
                        <input class="form-control" name="nameAdd"  required>
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
@push('scripts_fixPushMenu')
<script src="../../dist/js/adminlte.min.js?v=3.2.0"></script>
@endpush
@endsection
