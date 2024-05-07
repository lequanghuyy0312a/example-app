@extends('home._layout')
@section('title', 'Partner | List')
@section('content')
<section class="content-header bg-gradient-white shadow py-1">
    <div class="container-fluid">
        <div class="row ">
            <div class="col-sm-6">

                <h1 class="m-0 text-dark">{{__('msg.partnerList')}}<i class="text-muted text-md">( {{ $countPartners }} partners )</i></h1>
            </div><!-- /.col -->

        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</section>
<section class="content my-2">
    <div class="">
        <!-- danh sách partner  -->
        <div class="card">
            <div class="card-header bg-white pb-0">
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
                            <select class="form-control select2 select2-primary" data-dropdown-css-class="select2-primary" name="typePartner" id="typePartner" style="width: 30%;" required>
                                <option selected value="1"> 1. {{__('msg.customer')}} </option>
                                <option value="2"> 2. {{__('msg.supplier')}} </option>
                                <option value="12"> 3. {{__('msg.customerSupplier')}} </option>
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
                <table id="partnerTable" class="table table-bordered table-striped">
                    <thead style="position: sticky; top:60px; background-color: #fff; z-index: 1;">
                        <tr class="text-center">
                            <th style="width: 1%">
                                {{__('msg.num')}}

                            </th>
                            <th class="address" style="width: 43%">
                                {{__('msg.partnerName')}}
                            </th>
                            <th class="email" style="width: 1%">
                                {{__('msg.partnerType')}}
                            </th>
                            <th class="email" style="width: 10%">
                                {{__('msg.tax')}}
                            </th>
                            <th class="address" style="width: 14%">
                                {{__('msg.address')}}
                            </th>
                            <th class="email" style="width: 10%">
                                {{__('msg.email')}}
                            </th>
                            <th class="email" style="width: 10%">
                                {{__('msg.phone')}}
                            </th>
                            <th class="address" style="width: 10%">
                                {{__('msg.note')}}
                            </th>
                            <th style="position: sticky; right:0px; width: 1%" class="text-center">
                                <a href="/partner-add-form" class="btn btn-success btn-sm col " data-toggle="modal" data-target="#AddForm">
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
    <button id="backToTopBtn" onclick="scrollToTop()">
        <i class="fa-solid fa-circle-chevron-up text-success rounded-circle bg-white text-xl"></i>
        <p class="text-success ">Back to top</p>
    </button>
</section>
<!-- thêm hoặc sửa partner phát triển -->



<!-- ADD -->
<div class="modal fade" id="AddForm" tabindex="-1" role="dialog" aria-hidden="true" style= "z-index:1050; display:none; ">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="width: 800px;">
            <div class="modal-header bg-primary">
                <h3 class="card-title">{{__('msg.addNewPartner')}}</h3>
                <button type="button" class="close" data-dismiss="modal" area-label="Close">
                    <span aria-hidden="true"><i class="fa fa-close"></i> </span>
                </button>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="{{route('partner-add-submit')}}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label class="mb-0 text-primary">1. {{__('msg.belongPartnerType')}}</label>
                        <select class="form-control select2 select2-primary" data-dropdown-css-class="select2-primary" name="typeAdd" style="width: 100%;" required>
                            <option value="1"> 1. {{__('msg.customer')}} </option>
                            <option value="2"> 2. {{__('msg.supplier')}} </option>
                            <option value="12"> 3. {{__('msg.customerSupplier')}} </option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="mb-0">2. {{__('msg.partnerName')}}</label>
                        <input class="form-control" name="nameAdd" required>
                    </div>
                    <div class="form-group">
                        <label class="mb-0">3. {{__('msg.tax')}}</label>
                        <input class="form-control" name="taxAdd" required>
                    </div>
                    <div class="form-group">
                        <label class="mb-0">4. {{__('msg.address')}}</label>
                        <input class="form-control" name="addressAdd" required>
                    </div>
                    <div class="form-group">
                        <label class="mb-0">5. {{__('msg.email')}}</label>
                        <input class="form-control" name="emailAdd" required>
                    </div>
                    <div class="form-group">
                        <label class="mb-0">6. {{__('msg.phone')}}</label>
                        <input class="form-control" name="phoneAdd" required>
                    </div>
                    <div class="form-group">
                        <label class="mb-0">7. {{__('msg.note')}}</label>
                        <input class="form-control" name="noteAdd" required>
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
    <div class="modal fade" id="editModalPartner" tabindex="0" role="dialog" aria-hidden="true" style="z-index:1050; display:none" aria-labelledby="editUserModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content" style="width: 800px;">
                <div class="modal-header bg-primary">
                    <h3 class="card-title" id="editUserModalLabel">{{__('msg.editPartner')}}</h3>
                    <button type="button" class="close" data-dismiss="modal" area-label="Close">
                        <span aria-hidden="true"><i class="fa fa-close"></i> </span>
                    </button>
                </div>
                <form id="editPartnerForm" method="post">
                    @method("PATCH")
                    @csrf
                    <div class="modal-body    ">
                        <div class="form-group">
                            <label class="mb-0 text-primary">1. {{__('msg.belongPartnerType')}}</label>
                            <select class="form-control select2 select2-primary" data-dropdown-css-class="select2-primary" name="typeEdit" id="typeEdit" style="width: 100%;" required>


                            </select>
                        </div>
                        <div class="form-group">
                            <label class="mb-0">2. {{__('msg.partnerName')}}</label>
                            <input class="form-control" name="nameEdit" id="nameEdit" required>
                        </div>
                        <div class="form-group">
                            <label class="mb-0">3. {{__('msg.tax')}}</label>
                            <input class="form-control" name="taxEdit" id="taxEdit" required>
                        </div>
                        <div class="form-group">
                            <label class="mb-0">4. {{__('msg.address')}}</label>
                            <input class="form-control" name="addressEdit" id="addressEdit" required>
                        </div>
                        <div class="form-group">
                            <label class="mb-0">5. {{__('msg.email')}}</label>
                            <input class="form-control" name="emailEdit" id="emailEdit" required>
                        </div>
                        <div class="form-group">
                            <label class="mb-0">6. {{__('msg.phone')}}</label>
                            <input class="form-control" name="phoneEdit" id="phoneEdit" required>
                        </div>
                        <div class="form-group">
                            <label class="mb-0">7. {{__('msg.note')}}</label>
                            <input class="form-control" name="noteEdit" id="noteEdit" required>
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

@section('scripts-partner')
@include('scripts.script-partner')
@endsection
@push('scripts_fixPushMenu')
<script src="../../dist/js/adminlte.min.js?v=3.2.0"></script>
@endpush
@endsection
