@extends('home._layout')
@section('title', 'My profile')
@section('content')
<section class="content my-2">
    @if(session()->has('success'))
    <div class="alert alert-success" id="success-alert">
        {{ session('success') }}
    </div>
    @elseif($errors->has('error'))
    <div class="alert alert-danger" id="success-alert">
        {{ $errors->first('error') }}
    </div>
    @endif
    <div class="row" style="min-height:1080px">
        <div class="col-lg-5">
            @if(empty($employee))
            <h4>__('msg.noData')<a href="/employess">{{__('msg.list')}}</a></h4>
            @else
            <div class="card ">
                <div class="card-header bg-gradient-navy py-1">
                    <h3 class="card-title mt-2">{{__('msg.myProfile')}}</h3>
                    <a href="/print-profile-staff/{{ $employee->id }}" rel="noopener" target="_blank" class="btn bg-gradient-light float-right"><i class="fas fa-print"></i> Print</a>
                    <a class="btn bg-gradient-orange float-right mr-2 swalDefaultSuccess " data-toggle="modal" data-target="#changePassword">
                        <i class="fas fa-key"></i>
                        </i>
                    </a>
                </div>
                <!-- /.card-header -->
                <div class="card-body ">
                    <div class="card card-widget widget-user">
                        <!-- Add the bg color to the header using any of the bg-* classes -->
                        <div class="widget-user-header bg-gradient-info">

                            <h3 class="widget-user-username"> <a>{{ $employee->code }}</a> - {{ $employee->firstName }} {{ $employee->lastName }}</h3>
                            <h5 class="widget-user-desc my-2">{{ collect($listJobTitles)->pluck('role_NAME')->first() }} </h5>
                        </div>
                        <div class="widget-user-image">
                            <img class="img-circle elevation-2" src="{{ asset('assets/employees/' . $employee->image) }}" style="width:80px; height:80px;">
                        </div>
                        <div class="card-footer text-dark pt-4">
                            <div class="row">
                                <div class="col-sm-4 border-right">
                                    <div class="description-block">
                                        <h5 class="description-header text-sm text-muted">{{__('msg.directorate')}}</h5>
                                        <span class="description-text"><a href="/directors" class="text-danger"> {{ collect($listJobTitles)->pluck('directorate_NAME')->first() }}</a></span>
                                    </div>
                                    <!-- /.description-block -->
                                </div>
                                <!-- /.col -->
                                <div class="col-sm-4 border-right">
                                    <div class="description-block">
                                        <h5 class="description-header text-sm text-muted">{{__('msg.department')}}</h5>
                                        <span class="description-text"><a href="/department/{{ collect($listJobTitles)->pluck('department_ID')->first() }}" class="text-primary"> {{ collect($listJobTitles)->pluck('department_NAME')->first() }} </a></span>
                                    </div>
                                    <!-- /.description-block -->
                                </div>
                                <!-- /.col -->
                                <div class="col-sm-4">
                                    <div class="description-block">
                                        <h5 class="description-header text-sm text-muted">{{__('msg.section')}}</h5>
                                        <span class="description-text"><a href="/sections" class="text-info"> {{ collect($listJobTitles)->pluck('section_NAME')->first() }} </a></span>
                                    </div>
                                    <!-- /.description-block -->
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->
                        </div>
                    </div>
                    @if(count($listJobTitles) >1 )
                    <li class="nav-item dropdown float-right">
                        <a class="nav-link " data-toggle="dropdown" href="#">
                            <text class="text-dark">{{__('msg.otherPosition')}}</u></text>
                            <i class="fa-sharp fa-solid fa-user-tie text-navy mx-2"></i>
                            <span class="badge badge-warning navbar-badge">{{count($listJobTitles)-1}}</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                            @foreach ($listJobTitles as $key => $jobTitles)
                            @if ($key > 0)
                            <div class="dropdown-divider"></div>
                            <a href="#" class="dropdown-item col-12 ">
                                @php
                                $colorClass = '';
                                $showName = '';
                                switch ($jobTitles->role_ID) {
                                case '1':
                                $colorClass = 'badge-danger';
                                $showName = 'directorate_NAME';
                                break;
                                case '2':
                                $colorClass = 'badge-primary';
                                $showName = 'department_NAME';
                                break;
                                case '3':
                                $colorClass = 'badge-info';
                                $showName = 'section_NAME';
                                break;
                                default:
                                $colorClass = 'badge-warning';
                                $showName = 'section_NAME';
                                }
                                @endphp
                                <span class="badge {{ $colorClass }} col-6 text-center {{ strlen($jobTitles->role_NAME) < 7 ? 'px-5' : '' }}">
                                    {{ $jobTitles->role_NAME }}
                                </span>
                                <span class="col-6">
                                    {{ $jobTitles->$showName }}
                                </span>

                            </a>
                            @endif
                            @endforeach
                        </div>
                    </li>
                    @endif
                    <div class="row col-12 mx-0 px-0 mt-3">
                        <div class="col-xl-6 ml-0 pl-0">
                            <strong><i class="fa-sharp fa-solid fa-cake-candles mr-1  text-primary" aria-hidden="true"></i>{{__('msg.birthDay')}} </strong>
                            <p class="text-muted my-0"> {{ $employee->birthDay }} ({{ $age }} {{__('msg.age')}}) </p>
                            <hr class="my-0">
                        </div>
                        <div class="col-xl-6 mx-0 px-0">
                            <strong><i class="fas fa-venus-mars mr-1 text-primary"></i> {{__('msg.sex')}} </strong>
                            @if ($employee->sex== '1' )
                            <p class="text-muted my-0"> {{__('msg.male')}} </p>
                            @else
                            <p class="text-muted my-0"> {{__('msg.female')}} </p>
                            @endif
                            <hr class="my-0">
                        </div>
                    </div>

                    <div class="row col-12 mx-0 px-0 mt-3">
                        <div class="col-xl-6 ml-0 pl-0">

                            <strong><i class="fa-solid fa-envelope mr-1 text-primary"></i> {{__('msg.email')}} </strong>
                            <p class="text-muted my-0"> {{ $employee->email ?: __('msg.noData')}} </p>
                            <hr class="my-0">
                        </div>
                        <div class="col-xl-6 mx-0 px-0">
                            <strong><i class="fa-solid fa-phone mr-1 text-primary"></i> {{__('msg.phoneNumber')}} </strong>
                            <p class="text-muted my-0" class="form-control" data-inputmask='"mask": "9999.999.999"' data-mask> {{ $employee->phoneNumber ?: "0000000000" }} </p>
                            <hr class="my-0">
                        </div>
                    </div>

                    <div class="mt-3">
                        <strong><i class="fas fa-calendar-check mr-1 text-success"></i>{{__('msg.startOnUTC')}}</strong>
                        <p class="text-muted my-0"> {{ $employee->startOnUTC ?: __('msg.noData') }} </p>
                        <hr class="my-0">
                    </div>

                    <div class="mt-3">
                        <strong><i class="fas fa-map-marker-alt mr-1 text-success"></i>{{__('msg.permanentAddress')}}</strong>
                        <p class="text-muted my-0">{{ $employee->permanentAddress ?: __('msg.noData') }}</p>
                        <hr class="my-0">
                    </div>

                    <div class="mt-3">
                        <strong><i class="fas fa-map-marker-alt mr-1 text-secondary"></i> {{__('msg.temporaryAddress')}}</strong>
                        <p class="text-muted my-0">{{ $employee->temporaryAddress ?: __('msg.noData') }}</p>
                        <hr class="my-0">
                    </div>
                    <div class="row col-12 mx-0 px-0 mt-3">
                        <div class="col-xl-6 ml-0 pl-0">
                            <strong><i class="fas mr-1 fa-id-card text-danger"></i> {{__('msg.citizenID')}}</strong>
                            <p class="text-muted my-0" data-inputmask='"mask": "9999-9999-9999"' data-mask> {{ $employee->citizenID ?: __('msg.noData') }} </p>
                            <hr class="my-0">
                        </div>
                        <div class="col-xl-6 mx-0 px-0">
                            <strong><i class="fas fa-map-marker-alt mr-1  text-danger"></i>{{__('msg.issuedBy')}}</strong>
                            <p class="text-muted my-0"> {{ $employee->issuedBy ?: __('msg.noData') }} </p>
                            <hr class="my-0">
                        </div>
                    </div>
                    <div class="mt-3">
                        <strong><i class="far fa-file-alt mr-1 text-danger"></i> {{__('msg.nationality')}}</strong>
                        <p class="text-muted my-0"> {{ $employee->nationality ?: __('msg.noData') }}</p>
                        <hr class="my-0">
                    </div>
                </div>
            </div>
            @endif
        </div>
        <div class="col-lg-7">
            <div class="card    ">
                <!-- card-navy card-outline -->
                <div class="card-header bg-gradient-navy d-flex py-1">
                    <ul class="nav nav-pills">
                        <li class="nav-item"><a class="nav-link active text-light" href="#activity" data-toggle="tab">Slide show</a></li>
                        <li class="nav-item"><a class="nav-link text-light" href="#timeline" data-toggle="tab">List</a></li>
                        <div class="mt-2 ml-3">
                            <h3 class="card-title">{{__('msg.addedInfor')}} {{ count($countlistDetailInforEmployee) }}/{{ count($listTypeDetails) }} </h3>

                        </div>
                    </ul>

                </div><!-- /.card-header -->
                <div class="card-body p-0">
                    <div class="tab-content">
                        <!-- slide show -->
                        <div class="active tab-pane" id="activity">
                            <div class="card-body p-3">
                                <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel" data-interval="4000">
                                    <ol class="carousel-indicators">

                                        @if (!empty($listAddedDetailInforEmployee))
                                        <?php $num1 = 0; ?>
                                        @foreach($listAddedDetailInforEmployee as $detailInfor)
                                        <li data-target="#carouselExampleIndicators" data-slide-to="{{ $num1 }}" class="{{ $num1 === 0 ? 'active' : '' }} bg-secondary"></li>
                                        <?php $num1++; ?>
                                        @endforeach
                                        @else
                                        @endif
                                    </ol>
                                    <div class="carousel-inner">
                                        @if (!empty($listAddedDetailInforEmployee))
                                        <?php $num1 = 0; ?>
                                        @foreach($listAddedDetailInforEmployee as $detailInfor)
                                        <div class="carousel-item {{ $num1 === 0 ? 'active' : '' }} text-center">
                                            <iframe src="{{ asset('assets/inforuploads/' . trim($employee->lastName.'_'.$employee->firstName ).'/'. $detailInfor->fileName) }}"></iframe>
                                        </div>
                                        <?php $num1++; ?>
                                        @endforeach
                                        @else
                                        <div class="form-group text-center">
                                            <p>Not found!</p>
                                            <a href="/contact" class="btn btn-danger">{{__('msg.contactUS')}}</a>
                                        </div>
                                        @endif
                                    </div>
                                    <a class="carousel-control-prev py-5 my-5" href="#carouselExampleIndicators" role="button" data-slide="prev">
                                        <span class="carousel-control-custom-icon" aria-hidden="true">
                                            <i class="fas fa-chevron-left text-secondary"></i>
                                        </span>
                                        <span class="sr-only">Previous</span>
                                    </a>
                                    <a class="carousel-control-next py-5 my-5" href="#carouselExampleIndicators" role="button" data-slide="next">
                                        <span class="carousel-control-custom-icon" aria-hidden="true">
                                            <i class="fas fa-chevron-right text-secondary"></i>
                                        </span>
                                        <span class="sr-only">Next</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- slide show -->

                        <div class="tab-pane text-dark" id="timeline">
                            <div class="timeline timeline-inverse">
                                <div class="col-12 pt-2" id="accordion">
                                    <!-- danh sách thông tin -->
                                    @if (!empty($listDetailInforEmployee))
                                    <?php $num = 1; ?>
                                    <!-- danh sách thông tin chưa bổ sung  -->
                                    @foreach($listDetailInforEmployee as $detailInfor)
                                    @if($detailInfor->fileName == NULL)
                                    <div class="card card-danger card-outline">
                                        <a class="d-block h-50 w-100" data-toggle="collapse" href="#collapse{{ $num }}">
                                            <div class="card-header">
                                                <h4 class="card-title w-100 text-danger">
                                                    {{ $num  }}. <td>{{ $detailInfor->name }}</td>
                                                    <i class="fa-solid fa-circle-exclamation"></i>
                                                </h4>

                                            </div>
                                        </a>
                                        <div id="collapse{{ $num }}" class="collapse" data-parent="#accordion">
                                            <div class="ml-4">
                                                <i>Chưa có dữ liệu</i>
                                                @if(session('loginID')=='2')
                                                <a class="btn btn-link" href="/employee-edit/{{ $employee->id }}">Thêm ngay</a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <?php $num++; ?>
                                    <!-- danh sách thông tin chưa bổ sung  -->
                                    <!-- danh sách thông tin đã bổ sung  -->
                                    @else
                                    <div class="card card-info card-outline">
                                        <a class="d-block h-50 w-100" data-toggle="collapse" href="#collapse{{ $num }}">
                                            <div class="card-header">
                                                <h4 class="card-title w-100 text-dark">
                                                    {{ $num  }}. <td>{{ $detailInfor->name }}</td>
                                                </h4>
                                            </div>
                                        </a>
                                        <div id="collapse{{ $num }}" class="collapse" data-parent="#accordion">
                                            <div class="ml-4">
                                                <i>{{ $detailInfor->fileName }}</i> 
                                            </div>
                                        </div>
                                    </div>
                                    <?php $num++; ?>
                                    @endif
                                    @endforeach
                                    @else
                                    <div class="form-froup text-center">
                                        <p class="">
                                            Not found!
                                        </p>
                                        <a href="/contact" class="btn btn-info">{{__('msg.contactUS')}}</a>
                                    </div>
                                    @endif
                                    <!-- danh sách thông tin đã bổ sung  -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div><!-- /.container-fluid -->
        </div><!-- /.container-fluid -->
    </div>
</section>
<div class="modal fade" id="changePassword" tabindex="-1" role="dialog" aria-hidden="true" style="z-index:1050; display:none" aria-labelledby="editUserModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h3 class="card-title" id="editUserModalLabel">{{__('msg.changePassword')}}</h3>
                <button type="button" class="close" data-dismiss="modal" area-label="Close">
                    <span aria-hidden="true"><i class="fa fa-close"></i> </span>
                </button>
            </div>
            <form action="{{ route('account/password-change') }}" method="post" enctype="multipart/form-data">
                @method('PATCH')
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="oldPassword">I. {{ __('msg.oldPassword') }}.</label>
                        <div class="input-group">
                            <input class="form-control" type="password" name="oldPassword" value="" placeholder="Nhập mật khẩu cũ." id="oldPassword" required>
                            <div class="input-group-append">
                                <span class="input-group-text toggle-password" toggle="#oldPassword">
                                    <i class="fa fa-eye-slash"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="form-group">
                        <label for="newPassword">II. {{ __('msg.newPassword') }}.</label>
                        <div class="input-group">
                            <input class="form-control" type="password" name="newPassword" value="" placeholder="Nhập mật khẩu mới." id="newPassword" required>
                            <div class="input-group-append">
                                <span class="input-group-text toggle-password" toggle="#newPassword">
                                    <i class="fa fa-eye-slash"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="confirmPassword">III. {{ __('msg.confirmPassword') }}.</label>
                        <div class="input-group">
                            <input class="form-control" type="password" name="newPassword_confirmation" value="" placeholder="Nhập lại mật khẩu mới." id="newPassword_confirmation" required>
                            <div class="input-group-append">
                                <span class="input-group-text toggle-password" toggle="#newPassword_confirmation">
                                    <i class="fa fa-eye-slash"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-right card-footer">
                    <button type="submit" class="btn btn-primary">{{ __('msg.save') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- modal form sửa thông tin tổ -->
@push('scripts_fixPushMenu')
<script src="../../dist/js/adminlte.min.js?v=3.2.0"></script>
@endpush
@endsection