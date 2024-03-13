@extends('home._layout')
@section('title', 'Account | List')
@section('content')

<section class="content-header bg-gradient-navy text-white">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h1>{{__('msg.accountManagement')}}</h1>
            </div>
            <div class="col-sm-6 d-none d-sm-inline-block">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item "><a href="/account-dashboard" class="text-white">
                            <h4 class=" m-0 pt-1 ">Dashboard</h4>
                        </a></li>
                    <li class="breadcrumb-item active m-0 pt-1  text-white">{{__('msg.account')}}</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
<section class="">
    @if(session()->has('success'))
    <div class="alert alert-success" id="success-alert">
        {{ session('success') }}
    </div>
    @elseif($errors->has('error'))
    <div class="alert alert-danger" id="danger-alert">
        {{ $errors->first('error') }}
    </div>
    @endif
    <div class="card">
        <div class="card-body m-0 p-0">
            <!-- danh sách tài khoản   -->
            <div class="card mt-2 mx-2">
                <div class="card-header bg-gradient-navy pb-0">
                    <h3 class="card-title text-white">{{__('msg.accountList')}}</h3>
                </div>
                <div class="card-body p-2  mt-2">
                    <table id="accountTable" class="table table-bordered table-striped">
                        <thead>
                            <tr class="text-center">
                                <th style="width: 1%" class="text-center"> {{__('msg.num')}}</th>
                                <th style="width: 8%">
                                    {{__('msg.permission')}}
                                </th>
                                <th style="width: 15%">
                                    {{__('msg.useBy')}}
                                </th>
                                <th style="width: 10%">
                                    {{__('msg.code')}}
                                </th>
                                <th style="width: 15%">
                                    {{__('msg.email')}}
                                </th>
                                <th style="width: 10%">
                                    {{__('msg.password')}}
                                </th>
                                <th style="width: 10%">
                                    {{__('msg.createdBy')}}
                                </th>
                                <th style="width: 10%">
                                    {{__('msg.createdDate')}}
                                </th>
                                <th style="width: 5%" class="text-center">
                                    {{__('msg.acctive')}}
                                </th>
                                <th style="width: 15%">
                                    {{__('msg.note')}}
                                </th>
                                @if (session('loginRoleAccount')== 1)

                                <th style="width: 5%" class="text-center">
                                    <a href="/employee-add" class="btn btn-success btn-sm col " data-toggle="modal" data-target="#Addnew">
                                        <i class="fas fa-plus"></i>
                                        <span>Add</span> </a>
                                </th>
                            </tr>
                            @endif
                        </thead>
                        <tbody>
                            @if (!empty($listAccounts))
                            <?php
                            $num1 = 0;
                            ?>
                            @foreach($listAccounts as $accounts)
                            <tr>
                                @php
                                $colorClass = '';
                                switch ($accounts->A_keyword) {
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
                                <td class="text-center">{{++$num1}}</a></td>
                                <td class="project-state text-center">
                                    <span class="badge {{ $colorClass }}"> {{$accounts->A_name}}</span>
                                </td>
                                <td class="address"> {{$accounts->E_firstName}} {{$accounts->E_lastName}} </td>
                                <td> {{$accounts->code}} </td>
                                <td> {{$accounts->email}} </td>
                                <td><input type="password" value="{{$accounts->password}}" disabled> </td>
                                <td class="address"> {{$accounts->E2_firstName}} {{$accounts->E2_lastName}} </td>
                                <td class="address"> {{$accounts->createdOnUTC}} </td>

                                @if($accounts->acctive == '1')
                                <td class="project-state text-center">
                                    <span class="badge badge-success">{{__('msg.acctive')}}</span>
                                </td>
                                @else
                                <td class="project-state text-center">
                                    <span class="badge badge-secondary">{{__('msg.suspended')}}</span>
                                </td>
                                @endif
                                <td> {{$accounts->note}} </td>
                                @if (session('loginRoleAccount')== 1)

                                <td class="project-actions text-center py-0">
                                    <div class="btn btn-group">
                                        <form action="{{route('account-update-password', $accounts->id)}}" method="post">
                                            @method("PATCH")
                                            @csrf
                                            <button class="btn btn-info btn-sm" type="submit" onclick="return confirm('Bạn chọn đặt lại mật khẩu: {{ $num1 }} -- {{$accounts->E_firstName}} {{$accounts->E_lastName}} ?')">
                                                <i class="fa-solid fa-repeat"></i>
                                            </button>
                                        </form>
                                        <a class="btn btn-warning btn-sm mx-1" data-toggle="modal" data-target="#editAccount{{ $accounts->id }}">
                                            <i class="fas fa-pencil-alt">
                                            </i>
                                        </a>
                                        <a class="btn btn-danger btn-sm" type="submit" href="/account/{{$accounts->id}}/delete" onclick="return confirm('Bạn chọn xoá  tài khoản: {{ $num1 }} -- {{$accounts->E_firstName}} {{$accounts->E_lastName}} ?')">
                                            <i class="fas fa-trash">
                                            </i>
                                        </a>
                                    </div>
                                </td>
                                @endif
                            </tr>
                            <!-- sửa tài khoản -->
                            <div class="modal fade" id="editAccount{{ $accounts->id }}" role="dialog" aria-hidden="true" style="z-index:1050; display:none" aria-labelledby="editUserModalLabel">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header bg-primary">
                                            <h3 class="card-title" id="editUserModalLabel">{{__('msg.editAccount')}}</h3>
                                            <button type="button" class="close" data-dismiss="modal" area-label="Close">
                                                <span aria-hidden="true"><i class="fa fa-close"></i> </span>
                                            </button>
                                        </div>
                                        <form action="{{route('account-update', $accounts->id)}}" method="post">
                                            @method("PATCH")
                                            @csrf
                                            <div class="modal-body">
                                                <div class="form-group text-center">
                                                    <label class="mb-0" class="mb-0 text-primary ">
                                                        <h2>{{ $accounts->E_firstName }} {{ $accounts->E_lastName }}</h2>
                                                    </label>
                                                </div>
                                                <div class="form-group">
                                                    <label class="mb-0" class="mb-0 text-danger">I. {{__('msg.permission')}}</label>
                                                    <select  class="form-control select2 select2-danger select2-account" data-dropdown-css-class="select2-danger" name="roleAccountID1" style="width: 100%;" required>
                                                        <option value="" selected disabled>{{__('msg.choosePermission')}}</option>
                                                        <?php $numEdit = 1; ?>
                                                        @if (!empty($listRoleAccount))
                                                        @foreach($listRoleAccount as $roleAccount)
                                                        @if ($roleAccount->id == $accounts->roleAccountID)
                                                        <option value="{{ $roleAccount->id }}" selected>{{ $numEdit }}. {{ $roleAccount->name }}</option>
                                                        @else
                                                        <option value="{{ $roleAccount->id }}">{{ $numEdit }}. {{ $roleAccount->name }}</option>
                                                        @endif
                                                        <?php $numEdit++; ?>
                                                        @endforeach
                                                        @else <option value="" disabled>...</option>
                                                        @endif
                                                    </select>
                                                </div>
                                                <div class="form-group ml-2">
                                                    <div class="custom-control custom-switch custom-switch-off-secondary custom-switch-on-primary">
                                                        <input required type="checkbox" class="custom-control-input roleAccountCheckbox" id="customSwitch{{ $accounts->id }}" name="acctive1" {{ $accounts->acctive == 1 ? 'checked' : ''}} >
                                                        <label class=" custom-control-label" for="customSwitch{{ $accounts->id }}">II. {{__('msg.status')}}</label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="mb-0" for="code1">III. {{__('msg.code')}}</label>
                                                    <input required class="form-control" type="text" name="code1" value="{{ $accounts->code }}">
                                                </div>
                                                <div class="form-group">
                                                    <label class="mb-0" for="email">IV. {{__('msg.email')}}</label>
                                                    <input required class="form-control" type="text" name="email1" value="{{ $accounts->email }}"required>
                                                </div>
                                                <div class="form-group">
                                                    <label>V. {{__('msg.note')}}</label>
                                                    <textarea class="form-control" name="note1" placeholder="ex: {{__('msg.note')}}">{{ $accounts->note }}</textarea>
                                                </div>
                                            </div>
                                            <div class="text-right card-footer">
                                                <button type="submit" class="btn btn-primary">{{__('msg.save')}}</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!-- modal form sửa thông tin tổ -->
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- danh sách tài khoản  -->
        </div>
    </div>
</section>
<!-- thêm tài khoản -->
<div class="modal fade" id="Addnew" tabindex="-1" role="dialog" aria-hidden="true" style="z-index:1050; display:none">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h3 class="card-title">{{__('msg.addAccount')}}</h3>
                <button type="button" class="close" data-dismiss="modal" area-label="Close">
                    <span aria-hidden="true"><i class="fa fa-close"></i> </span>
                </button>
            </div> <!-- /.card-header --> <!-- form start -->
            <form action="{{route('account-addnew')}}" method="post"> 
                @csrf
                 <div class="modal-body">
                    <div class="form-group">
                        <label>I. {{__('msg.useBy')}}</label>
                        <?php $num1 = 0; ?>
                        <select required class="form-control select2 select2-primary" data-dropdown-css-class="select2-primary" name="employeeID" id="employeeID" style="width: 100%;" data-search="true">
                            <option value="" disabled selected>{{__('msg.chooseEmployee')}}</option>
                            @foreach($dropListEmployees as $employee)
                            <option value="{{ $employee->id }}">{{++$num1}}. {{ $employee->firstName }} {{ $employee->lastName }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="mb-0" class="mb-0 text-danger">II. {{__('msg.permission')}} </label>
                        <select required  class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" name="roleAccountID" style="width: 100%;">
                            <option value="" disabled selected>{{__('msg.choosePermission')}}</option>
                            <?php $numRole = 0; ?>
                            @if (!empty($listRoleAccount))
                            @foreach($listRoleAccount as $roleAccount)
                            <option value="{{ $roleAccount->id }}">{{ ++$numRole }}. {{ $roleAccount->name }} </option>
                            @endforeach
                            @else
                            <option value="">...</option>
                            @endif
                        </select>
                    </div>
                    <div class="form-group ml-2">
                        <div class="custom-control custom-switch custom-switch-off-secondary custom-switch-on-primary">
                            <input type="checkbox" name="acctive" value="1" checked class="custom-control-input" id="customSwitchAaccountAddnew">
                            <label class="mb-0 custom-control-label" for="customSwitchAaccountAddnew">III. {{__('msg.status')}}</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="mb-0" for="code">IV. {{__('msg.code')}}</label>
                        <input class="form-control" type="text" name="code" id="code" disabled>
                        <input type="hidden" id="hiddenCode" name="hiddenCode" value="">
                    </div>

                    <div class="form-group">
                        <label class="mb-0" for="email">V. {{__('msg.email')}}</label>
                        <input class="form-control" type="text" name="email" id="email" disabled>
                        <input type="hidden" id="hiddenEmail" name="hiddenEmail" value="">

                    </div>
                    <div class="form-group">
                        <label>VI. {{__('msg.note')}}</label>
                        <textarea class="form-control" name="note" placeholder="ex: {{__('msg.note')}}"></textarea>
                    </div>
                </div> <!-- /.card-body -->
                <div class="text-right card-footer">
                    <button type="submit" class="btn btn-primary">{{__('msg.save')}}</button>
                </div>
            </form>
        </div>
    </div>
</div> <!-- thêm tài khoản -->
@push('scripts_fixPushMenu')
<script src="../../dist/js/adminlte.min.js?v=3.2.0"></script>
@endpush
@endsection