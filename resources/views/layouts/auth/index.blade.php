@extends('home._layout')
@section('title', 'Account | Dashboard')
@section('content')
<!-- Content Wrapper. Contains page content -->

<!-- Content Header (Page header) -->
<div class="content-header bg-gradient-navy py-1">
    <div class="container-fluid">
        <div class="row ">
            <div class="col-sm-6">
                <h1 class="m-0">{{__('msg.accountManagement')}}</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right ">
                    <li class="breadcrumb-item "><a href="/">
                            <h4 class="text-white m-0 pt-1 ">Home</h4>
                        </a></li>
                    <li class="breadcrumb-item active text-white m-0 pt-1 ">{{__('msg.account')}}</li>
                </ol>
            </div><!-- /.col -->

        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<section class="content my-2 mt-3">
    <div class="">
        <!-- Info boxes -->
        <div class="row">
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box">
                    <a href="" class="info-box-icon bg-danger elevation-1"><i class="fa-solid fa-user-gear"></i></a>
                    <div class="info-box-content">
                        <span class="info-box-text">{{__('msg.totalAccount')}}</span>
                        <span class="info-box-number"> {{$countAccounts}} </span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box mb-3">
                    <a href="" class="info-box-icon bg-primary elevation-1"><i class="fas fa-people-arrows"></i></a>

                    <div class="info-box-content">
                        <span class="info-box-text">{{__('msg.modifier')}}</span>
                        <span class="info-box-number">{{$countModifierAccounts}}</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="clearfix hidden-md-up"></div>

            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box mb-3">
                    <a href="" class="info-box-icon bg-info elevation-1">
                        <i class="fa-solid fa-users-viewfinder"></i>
                    </a>
                    <div class="info-box-content">
                        <span class="info-box-text">{{__('msg.manager')}}</span>
                        <span class="info-box-number">{{$countManagerAccounts}}</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box mb-3">
                    <a href="" class="info-box-icon bg-warning elevation-1"><i class="fas fa-users-cog"></i></a>

                    <div class="info-box-content">
                        <span class="info-box-text">{{__('msg.leader')}}</span>
                        <span class="info-box-number">{{$countLeaderAccounts}}</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- Main row -->
        <div class="row">
            <!-- Left col -->
            <div class="col-md-8">
                <div class="card ">
                    <div class="card-header border-transparent bg-gradient-navy btn pb-0" data-card-widget="collapse">
                        <h3 class="card-title">{{__('msg.permissionList')}}</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class=" text-white fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table m-0 text-nowrap">
                                <thead>
                                    <tr>
                                        <th style="width: 1%;">{{__('msg.num')}}</th>
                                        <th style="width: 20%;">{{__('msg.code')}}</th>
                                        <th style="width: 20%;">{{__('msg.permission')}}</th>
                                        <th style="width: 20%;" class="text-center">{{__('msg.status')}}</th>
                                        <th style="width: 29%;">{{__('msg.note')}}</th>
                                        <th style="width: 10%" class="text-center">
                                            <a href="/role-account/add" class="btn btn-success btn-sm w-50 " data-toggle="modal" data-target="#Addnew">
                                                <i class="fas fa-plus"></i> </a>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($getRoleAccounts)
                                    <?php $num = 0; ?>
                                    @foreach($getRoleAccounts as $roleAccounts)
                                    <tr>
                                        <td class="text-center">#{{++$num}}</a></td>
                                        <td>{{$roleAccounts->keyword}}</td>
                                        <td>{{$roleAccounts->name}}</td>
                                        @if($roleAccounts->acctive == '1')
                                        <td class="project-state text-center">
                                            <span class="badge badge-success">{{__('msg.acctive')}}</span>
                                        </td>
                                        @else
                                        <td class="project-state text-center">
                                            <span class="badge badge-secondary">{{__('msg.suspended')}}</span>
                                        </td>
                                        @endif
                                        <td> {{$roleAccounts->note}} </td>
                                        <td class="project-actions text-center py-0">
                                            <div class="btn btn-group">
                                                <a class="btn btn-warning btn-sm mx-1" data-toggle="modal" data-target="#editRoleAccount{{ $roleAccounts->id }}">
                                                    <i class="fas fa-pencil-alt">
                                                    </i>
                                                </a>
                                                <a class="btn btn-danger btn-sm" type="submit" href="/role-account/{{$roleAccounts->id}}/delete" onclick="return confirm('Bạn chọn xoá quyền truy cập: {{ $num }} -- {{$roleAccounts->name}}?')">
                                                    <i class="fas fa-trash">
                                                    </i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    <!-- sửa quyền truy cập -->
                                    <div class="modal fade" id="editRoleAccount{{ $roleAccounts->id }}" role="dialog" aria-hidden="true" style="z-index:1050; display:none" aria-labelledby="editUserModalLabel">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header bg-danger">
                                                    <h3 class="card-title" id="editUserModalLabel">{{__('msg.editPermission')}}</h3>
                                                    <button type="button" class="close" data-dismiss="modal" area-label="Close">
                                                        <span aria-hidden="true"><i class="fa fa-close"></i> </span>
                                                    </button>
                                                </div>
                                                <form action="{{route('role-account-update', $roleAccounts->id)}}" method="post">
                                                    @method("PATCH")
                                                    @csrf
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label class="mb-0" for="keyword">I. {{__('msg.code')}}</label>
                                                            <input class="form-control" type="text" name="keyword1" value="{{ $roleAccounts->keyword }}" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="mb-0" for="name">II. {{__('msg.permission')}}</label>
                                                            <input class="form-control" type="text" name="name1" value="{{ $roleAccounts->name }}" required>
                                                        </div>
                                                        <div class="form-group ml-2">
                                                            <div class="custom-control custom-switch custom-switch-off-secondary custom-switch-on-danger">
                                                                <input type="checkbox" class="custom-control-input roleAccountCheckbox" id="customSwitch{{ $roleAccounts->id }}" name="acctive1" {{$roleAccounts->acctive == 1 ? 'checked' : ''}}>
                                                                <label class="custom-control-label" for="customSwitch{{ $roleAccounts->id }}">III. {{__('msg.status')}}</label>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="mb-0">IV. {{__('msg.note')}}</label>
                                                            <textarea class="form-control" name="note1" placeholder="ex: {{__('msg.note')}}">{{ $roleAccounts->note }}</textarea>
                                                        </div>
                                                    </div>
                                                    <div class="text-right card-footer  py-1 m-0 pr-3">
                                                        <button type="submit" class="btn btn-danger">{{__('msg.save')}}</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- modal form sửa thông quyền đăng nhập-->
                                    @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <!-- /.table-responsive -->
                    </div>
                </div>
                <div class="card ">
                    <div class="card-header border-transparent  bg-gradient-navy btn pb-0" data-card-widget="collapse">
                        <h3 class="card-title">{{__('msg.latestAccount')}}</h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="text-white fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table m-0 text-nowrap">
                                <thead>
                                    <tr>
                                        <th style="width: 1%;">{{__('msg.num')}}</th>
                                        <th style="width: 15%;">{{__('msg.permission')}}</th>
                                        <th style="width: 20%;">{{__('msg.useBy')}}</th>
                                        <th style="width: 19%;">{{__('msg.email')}}</th>
                                        <th style="width: 15%;">{{__('msg.phoneNumber')}}</th>
                                        <th style="width: 25%;">{{__('msg.createdBy')}}</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @if($listNewestAccounts)
                                    <?php $num = 0; ?>
                                    @foreach($listNewestAccounts as $newestAccounts)
                                    <tr>
                                        @php
                                        $colorClass = '';
                                        switch ($newestAccounts->A_keyword) {
                                        case 'admin':
                                        $colorClass = 'badge-danger';
                                        break;
                                        case 'modifier':
                                        $colorClass = 'badge-primary';
                                        break;
                                        case 'manager':
                                        $colorClass = 'badge-info';
                                        break;
                                        case 'leader':
                                        $colorClass = 'badge-warning';
                                        break;
                                        default:
                                        $colorClass = 'badge-dark';
                                        }
                                        @endphp
                                        <td class="text-center">#{{++$num}}</a></td>
                                        <td class="project-state">
                                            <span class="badge {{ $colorClass }}"> {{$newestAccounts->A_name}}</span>
                                        </td>
                                        <td>{{$newestAccounts->employee_FullName}}</td>
                                        <td>{{$newestAccounts->email}}</td>
                                        <td>{{$newestAccounts->phoneNumber}}</td>
                                        <td> {{$newestAccounts->createdBy_FullName}} </td>
                                    </tr>
                                    @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer clearfix">
                            <a href="/accounts" class="btn btn-sm bg-gradient-navy float-right">{{__('msg.addNew')}}</a>
                            <a href="/accounts" class="btn btn-sm btn-secondary float-left">{{__('msg.viewAll')}}</a>
                        </div>
                        <!-- /.table-responsive -->
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header bg-gradient-navy btn  pb-0" data-card-widget="collapse">
                        <h3 class="card-title">{{__('msg.changedInformation')}}</h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body p-0">
                        <ul class="products-list product-list-in-card pl-2 pr-2">
                            @if($listChanged)
                            @foreach($listChanged as $changed)
                            <li class="item">
                                <div class="product-img">
                                    <img src="{{ asset('assets/employees/' . $changed->H_Image) }}" alt="" class="img-size-50">
                                </div>
                                @php
                                $colorClass = '';
                                switch ($changed->CRUD) {
                                case 'insert':
                                $colorClass = 'badge-success';
                                break;
                                case 'update':
                                $colorClass = 'badge-warning';
                                break;
                                case 'delete':
                                $colorClass = 'badge-danger';
                                break;
                                case 'login':
                                $colorClass = 'badge-primary';
                                break;
                                case 'logout':
                                $colorClass = 'badge-secondary';
                                break;
                                default:
                                $colorClass = 'badge-dark';
                                }
                                @endphp
                                <div class="product-info">
                                    <a href="/history/{{$changed->id}}" class="product-title">{{$changed->H_FullName}}
                                        <span class="badge float-right {{ $colorClass }}" href="/history/{{$changed->id}}">{{$changed->CRUD}}</span></a>
                                    <span class="product-description">
                                        {{__('msg.operationTo')}}: {{$changed->keyword}}
                                        <span class="float-right">{{ date('H:i  |  d-n', strtotime($changed->changedOnUTC)) }}</span></a>
                                    </span>
                                </div>
                            </li>
                            @endforeach
                            @endif
                        </ul>
                    </div>
                    <!-- /.card-body -->
                    @if (session('loginRoleAccount')== 1)
                    <div class="card-footer text-center">
                        <a href="/histories" class="uppercase">{{__('msg.viewChanged')}}</a>
                    </div>
                    @endif
                    <!-- /.card-footer -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div><!--/. container-fluid -->
</section>
<!-- thêm quyền đăng nhập -->
<div class="modal fade" id="Addnew" tabindex="-1" role="dialog" aria-hidden="true" style="z-index:1050; display:none">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h3 class="card-title">{{__('msg.addPermission')}}</h3>
                <button type="button" class="close" data-dismiss="modal" area-label="Close">
                    <span aria-hidden="true"><i class="fa fa-close"></i> </span>
                </button>
            </div> <!-- /.card-header --> <!-- form start -->
            <form action="{{route('role-account-addnew')}}" method="post"> @csrf <div class="modal-body">
                    <div class="modal-body p-0">
                        <div class="form-group">
                            <label class="mb-0" for="keyword">I. {{__('msg.code')}}</label>
                            <input class="form-control" type="text" name="keyword" placeholder="ex: staff" required>
                        </div>
                        <div class="form-group">
                            <label class="mb-0" for="name">II. {{__('msg.permission')}}</label>
                            <input class="form-control" type="text" name="name" placeholder="ex: nhân viên" required>
                        </div>
                        <div class="form-group pl-2">
                            <div class="custom-control custom-switch custom-switch-on-danger custom-switch-off-secondary ">
                                <input type="checkbox" name="acctive" checked value="1" class="custom-control-input" id="checkDirectorStatus">
                                <label class="custom-control-label" for="checkDirectorStatus">III. {{__('msg.status')}}</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="mb-0">IV. {{__('msg.note')}}</label>
                            <textarea class="form-control" name="note" placeholder="ex: {{__('msg.note')}}"></textarea>
                        </div>
                    </div>
                    <div class="text-right card-footer p-0 m-0 py-1">
                        <button type="submit" class="btn btn-danger">{{__('msg.save')}}</button>
                    </div>

            </form>

        </div>

    </div>
</div> <!-- thêm quyền đăng nhập-->
@push('scripts_fixPushMenu')
<script src="../../dist/js/adminlte.min.js?v=3.2.0"></script>
@endpush
@endsection