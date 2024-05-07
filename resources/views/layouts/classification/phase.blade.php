@extends('home._layout')
@section('title', 'Classification | Phase')

@section('content')
<section class="content-header bg-gradient-white shadow py-1">
    <div class="container-fluid">
        <div class="row ">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">{{__('msg.phase')}}</h1>
            </div><!-- /.col -->

        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</section>
<section class="content my-2">
    <div class="">
        <!-- danh sách team  -->
        <div class="card">
            <div class="card-header btn bg-white pb-0" data-card-widget="collapse">
                <h3 class="card-title text-dark ">{{__('msg.phaseList')}}</h3>
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
                <table id="phaseTable" class="table table-bordered table-striped">
                    <thead>
                        <tr class="text-center">
                            <th style="width: 1%">
                            {{__('msg.num')}}
                            </th>
                            <th style="width: 18%">
                            {{__('msg.phaseCode')}}
                            </th>
                            <th style="width: 20%">
                                USD to VND
                            </th>
                            <th style="width: 20%">
                                USD to JPY
                            </th>
                            <th style="width: 20%">
                                JPY to VND
                            </th>
                            <th style="width: 20%">
                            {{__('msg.priceAl')}}
                            </th>
                            <th style="width: 1%" class="text-center">
                                <a href="/phase-add-form" class="btn btn-success btn-sm col " data-toggle="modal" data-target="#AddForm">
                                    <i class="fas fa-plus"></i> </a>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $numList = 0;
                        ?>
                        @foreach($getPhases as $phase)
                        <tr>
                            <td class="text-center "> {{ ++$numList }}</a> </td>
                            <td>
                                {{$phase->name }}
                            </td>
                            <td>
                                {{ number_format($phase->USDtoVND, 2, '.', ',') }}
                            </td>
                            <td>
                                {{ number_format($phase->USDtoJPY, 2, '.', ',') }}
                            </td>
                            <td>
                                {{ number_format($phase->JPYtoVND, 2, '.', ',') }}
                            </td>
                            <td>
                                {{ number_format($phase->Al, 2, '.', ',') }}
                            </td>
                            <td class="project-actions text-center  py-0">
                                <div class="btn btn-group">
                                    <a class="btn btn-link btn-sm mx-1" data-toggle="modal" data-target="#EditForm{{ $phase->id }}">
                                        <i class="fas fa-pencil-alt">
                                        </i>
                                    </a>
                                    <a class="btn btn-link btn-sm" type="submit" href="/phase/{{$phase->id}}/delete" onclick="return confirm('Are you sure you want to delete: {{ $numList }} -- {{ $phase->name}}?')">
                                        <i class="fas fa-trash">
                                        </i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <!-- modal form sửa thông tin team -->
                        <div class="modal fade" id="EditForm{{ $phase->id }}" tabindex="0" role="dialog" aria-hidden="true" style="z-index:1050; display:none" aria-labelledby="editUserModalLabel">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header bg-primary">
                                        <h3 class="card-title" id="editUserModalLabel">{{__('msg.editPhase')}}</h3>
                                        <button type="button" class="close" data-dismiss="modal" area-label="Close">
                                            <span aria-hidden="true"><i class="fa fa-close"></i> </span>
                                        </button>
                                    </div>
                                    <form action="{{route('phase-edit-submit', $phase->id)}}" method="post">
                                        @method("PATCH")
                                        @csrf
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label class="mb-0">1. {{__('msg.phaseCode')}}</label>
                                                <input class="form-control money-load" name="nameEdit" value="{{ $phase->name }}" required>
                                            </div>
                                            <div class="form-group">
                                                <label class="mb-0">2. USD to VND</label>
                                                <input class="form-control money-load" name="usdToVNDEdit" type="text" value="{{ ($phase->USDtoVND) }}" required oninput="formatCurrency(this)">
                                            </div>
                                            <div class="form-group">
                                                <label class="mb-0">3. USD to JPY</label>
                                                <input class="form-control money-load" name="usdToJPYEdit" type="text" value="{{ ($phase->USDtoJPY) }}" required oninput="formatCurrency(this)">
                                            </div>
                                            <div class="form-group">
                                                <label class="mb-0">4. JPY to VND</label>
                                                <input class="form-control money-load" name="jpyToVNDEdit" type="text" value="{{ ($phase->JPYtoVND) }}" required oninput="formatCurrency(this)">
                                            </div>
                                            <div class="form-group ">
                                                <label class="mb-0">5. {{__('msg.priceAl')}} {{__('msg.priceAl')}}</label>
                                                <input class="form-control money-load" name="AlEdit" type="text" value="{{ ($phase->Al) }}" required oninput="formatCurrency(this)">
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
                <h3 class="card-title"> {{__('msg.addNewPhase')}}</h3>
                <button type="button" class="close" data-dismiss="modal" area-label="Close">
                    <span aria-hidden="true"><i class="fa fa-close"></i> </span>
                </button>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="{{route('phase-add-submit')}}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label class="mb-0">1. {{__('msg.newPhaseCode')}}</label>
                        <input class="form-control" name="nameAdd" placeholder="ex: K13" required>
                    </div>
                    <div class="form-group">
                        <label class="mb-0">2. USD to VND</label>
                        <input class="form-control" name="usdToVNDAdd" type="text"   required oninput="formatCurrency(this)">
                    </div>
                    <div class="form-group">
                        <label class="mb-0">3. USD to JPY</label>
                        <input class="form-control" name="usdToJPYAdd" type="text" required oninput="formatCurrency(this)">
                    </div>
                    <div class="form-group">
                        <label class="mb-0">4. JPY to VND</label>
                        <input class="form-control" name="jpyToVNDAdd" type="text" required oninput="formatCurrency(this)">
                    </div>
                    <div class="form-group">
                        <label class="mb-0">5. {{__('msg.priceAl')}}</label>
                        <input class="form-control" name="AlAdd" type="text" required oninput="formatCurrency(this)">
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
