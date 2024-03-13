@extends('home._layout')
@section('title', 'Structure | Team')

@section('content')
<link rel="stylesheet" href="{{ asset('dist/css/myCSS_diagram.css') }}">

<section class="content-header bg-gradient-navy py-1">
    <div class="container-fluid">
        <div class="row ">
            <div class="col-sm-6">
                <h1 class="m-0 text-white">{{__('msg.team')}}</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right ">
                    <li class="breadcrumb-item "><a href="/structure-dashboard">
                            <h4 class="text-white m-0 pt-1 ">Dashboard</h4>
                        </a></li>
                    <li class="breadcrumb-item active text-white m-0 pt-1 ">{{__('msg.list')}}</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</section>
<section class="content my-2">
    <div class="">

        <!-- danh sách team  -->
        <div class="card">
            <div class="card-header btn bg-navy pb-0" data-card-widget="collapse">
                <h3 class="card-title text-white ">{{__('msg.list')}}</h3>
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
                <table id="teamTable" class="table table-bordered table-striped">
                    <thead>
                        <tr class="text-center">
                            <th style="width: 1%">
                                {{__('msg.num')}}
                            </th>
                            <th style="width: 30%">
                                {{__('msg.belongingSection')}}
                            </th>
                            <th style="width: 20%">
                                {{__('msg.teamName')}}
                            </th>
                            <th style="width: 20%">
                                {{__('msg.teamCode')}}
                            </th>
                            <th style="width: 1%" class="text-center">
                                {{__('msg.status')}}
                            </th>
                            <th style="width: 27%">
                                {{__('msg.note')}}
                            </th>
                            @if (session('loginRoleAccount')== 2)
                            <th style="width: 1%" class="text-center">
                                <a href="/team-add" class="btn btn-success btn-sm col " data-toggle="modal" data-target="#Addnew">
                                    <i class="fas fa-plus"></i>
                                    <span>Add</span> </a>
                            </th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @if (!empty($getTeams))
                        <?php
                        $numList = 0;
                        ?>
                        @foreach($getTeams as $team)
                        <tr>
                            <td class="text-center "> {{ ++$numList }}</a> </td>
                            <td class="email">
                                {{$team->section_KEY }}
                            </td>
                            <td class="email"> {{$team->name}} </td>
                            <td class="email"> {{$team->keyword}} </td>
                            @if($team->acctive == '1')
                            <td class="project-state text-center">
                                <span class="badge badge-success">{{__('msg.acctive')}}</span>
                            </td>
                            @else
                            <td class="project-state text-center">
                                <span class="badge badge-secondary">{{__('msg.suspended')}}</span>
                            </td>
                            @endif
                            <td class="email">
                                {{$team->note}}
                            </td>
                            @if (session('loginRoleAccount')== 2)
                            <td class="project-actions text-center  py-0">
                                <div class="btn btn-group">
                                    <a class="btn btn-warning btn-sm mx-1" data-toggle="modal" data-target="#editTeam{{ $team->id }}">
                                        <i class="fas fa-pencil-alt">
                                        </i>
                                    </a>
                                    <a class="btn btn-danger btn-sm" type="submit" href="/team/{{$team->id}}/delete" onclick="return confirm('Bạn chọn team: {{ $numList }} -- {{ $team->name}}?')">
                                        <i class="fas fa-trash">
                                        </i>
                                    </a>
                                </div>
                            </td>
                            @endif
                        </tr>
                        <!-- modal form sửa thông tin team -->
                        <div class="modal fade" id="editTeam{{ $team->id }}" role="dialog" aria-hidden="true" style="z-index:1050; display:none" aria-labelledby="editUserModalLabel">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header bg-primary">
                                        <h3 class="card-title" id="editUserModalLabel">{{__('msg.editTeam')}}</h3>
                                        <button type="button" class="close" data-dismiss="modal" area-label="Close">
                                            <span aria-hidden="true"><i class="fa fa-close"></i> </span>
                                        </button>
                                    </div>
                                    <form action="{{route('team-update', $team->id)}}" method="post">
                                        @method("PATCH")
                                        @csrf
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label class="mb-0 text-danger">I. {{__('msg.sectionName')}}</label>
                                                <select class="form-control select2 select2-danger select2-team" data-dropdown-css-class="select2-danger" name="sectionID" style="width: 100%;">
                                                    <option selected disabled>{{__('msg.chooseSection')}}</option>
                                                    <?php $numEdit = 1; ?>
                                                    @if (!empty($dropListSections))
                                                    @foreach($dropListSections as $section)
                                                    @if ($section->id == $team->sectionID)
                                                    <option value="{{ $section->id }}" selected>{{ $numEdit }}. {{ $section->name }}</option>
                                                    @else
                                                    <option value="{{ $section->id }}">{{ $numEdit }}. {{ $section->name }}</option>
                                                    @endif
                                                    <?php $numEdit++; ?>
                                                    @endforeach
                                                    @else <option value="" disabled>...</option>
                                                    @endif
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label class="mb-0">II. {{__('msg.code')}}</label>
                                                <input class="form-control" name="keyword1" value="{{ $team->keyword }}" required>
                                            </div>
                                            <div class="form-group">
                                                <label class="mb-0">III. {{__('msg.teamName')}}</label>
                                                <input class="form-control" name="name1" value="{{ $team->name }}" required>
                                            </div>
                                            <div class="form-group pl-2">
                                                <div class="custom-control custom-switch custom-switch-off-secondary custom-switch-on-danger">
                                                    <input type="checkbox" class="custom-control-input roleAccountCheckbox" id="customSwitch{{ $team->id }}" name="acctive1" {{$team->acctive == 1 ? 'checked' : ''}}>
                                                    <label class="mb-0 custom-control-label" for="customSwitch{{ $team->id }}">IV. {{__('msg.status')}}</label>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="mb-0">V. {{__('msg.note')}}</label>
                                                <textarea class="form-control" name="note1">{{ $team->note }}</textarea>
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
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</section>
<!-- thêm hoặc sửa team phát triển -->
<div class="modal fade" id="Addnew" tabindex="-1" role="dialog" aria-hidden="true" style="z-index:1050; display:none">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h3 class="card-title">{{__('msg.addTeam')}}</h3>
                <button type="button" class="close" data-dismiss="modal" area-label="Close">
                    <span aria-hidden="true"><i class="fa fa-close"></i> </span>
                </button>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="{{route('team-addnew')}}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label class="mb-0 text-danger">I. {{__('msg.sectionName')}}</label>
                        <select required class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" name="sectionID" style="width: 100%;">
                            <option value="" selected disabled>{{__('msg.chooseSection')}}</option>
                            <?php $numAdd = 0; ?>
                            @if (!empty($dropListSections))
                            @foreach($dropListSections as $section)
                            <option value="{{ $section->id }}">{{ ++$numAdd }}. {{ $section->name }} </option>
                            @endforeach
                            @else
                            <option value="">...</option>
                            @endif
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="mb-0">II. {{__('msg.code')}}</label>
                        <input class="form-control" name="keyword" placeholder="ex: Team 1 .T" required>
                    </div>
                    <div class="form-group">
                        <label class="mb-0">III. {{__('msg.teamName')}}</label>
                        <input class="form-control" name="name" placeholder="ex: Team 1" required>
                    </div>

                    <div class="form-group pl-2">
                        <div class="custom-control custom-switch custom-switch-off-secondary custom-switch-on-primary">
                            <input type="checkbox" name="acctive" value="1" checked class="custom-control-input" id="customSwitchDeparmentAddNew">
                            <label class="mb-0 custom-control-label" for="customSwitchDeparmentAddNew">III. {{__('msg.status')}}</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="mb-0">V. {{__('msg.note')}}</label>
                        <textarea class="form-control" name="note" placeholder="ex: ghi chú"></textarea>

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
