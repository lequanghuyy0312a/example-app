@extends('home._layout')
@section('title', 'Product | List')

@section('content')
<link rel="stylesheet" href="{{ asset('dist/css/myCSS_diagram.css') }}">

<section class="content-header bg-gradient-white py-1 shadow">
    <div class="container-fluid">
        <div class="row ">
            <div class="col-sm-6">
                <h1 class="m-0 text-fatk">{{__('msg.processProduction')}}</h1>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</section>
<section class="content my-2">
    <div class="card ">
        <div class=" col-12 mt-2 px-0">
            <h3 class="text-center">
                <b>
                    <input hidden name="hiddenProductID" value="{{ collect($getDropListProducts)->pluck('id')->first() }}">

                    {{ collect($getDropListProducts)->pluck('phase')->first() }} -
                    {{ collect($getDropListProducts)->pluck('code')->first() }} -
                    {{ collect($getDropListProducts)->pluck('name')->first() }}
                    <td class="p-0">
                        <div class="btn btn-group float-right p-0">
                            <a class="btn text-danger btn-default" type="submit" href="/bom/{{ collect($getDropListProducts)->pluck('id')->first() }}/remove" onclick="return confirm('Are you sure you want to delete?')">
                                <i class="fa-solid fa-trash"></i>
                            </a>
                            <a class="btn text-success btn-default ml-1 addBtn-trigger btn-add-bom" data-product-id="{{ collect($getDropListProducts)->pluck('id')->first() }}">
                                <i class="fas fa-circle-plus"></i>
                            </a>
                        </div>
                    </td>
                </b>
            </h3>
        </div>

        <div class="card">
            <div class="card-header btn bg-dark pb-0" data-card-widget="collapse">
                <h3 class="card-title text-white ">1. {{__('msg.materialsAndProductionProcess')}}</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool text-white" data-card-widget="collapse">
                        <i class="fas fa-minus"></i> </button>
                </div>
            </div>
            @if(session()->has('success'))
            <div class="alert alert-success" id="success-alert">
                {{ session('success') }}
            </div>
            @elseif($errors->has('error'))
            <div class="alert alert-danger" id="danger-alert">
                {{ $errors->first('error') }}
            </div>
            @endif
            <div class="card-body m-0 p-0 mt-2">
                <div class="row p-0 m-0 px-2 "  style="max-height: 500px; overflow-y: auto;">
                    <div class="p-0 m-0 row  col-12 " style="position: sticky; top:0px; background-color: #fff; z-index: 1;">
                        <a id="toggleLink" href="#" class="btn btn-outline-secondary ">
                            <i id="iconB" class="fa-solid  fa-folder-tree"></i>
                            <i id="iconA" class="fa-solid  fa-list" style="display: none;"></i>
                        </a>
                        <a class="btn ml-2 btn-outline-success btn-copy-bom" data-product-id="{{ collect($getDropListProducts)->pluck('id')->first() }}">
                            <i class="fa-solid fa-copyright"></i>
                        </a>
                        <i class="m-0 ml-3 text-muted"> <h4>{{$countBomData }} rows</h4></i>
                    </div>
                    <input hidden name="hiddenProductID" value="{{ collect($getDropListProducts)->pluck('id')->first() }}">

                    <!-- LIST -->
                    <div class="col-12 px-0 mt-2" id="divListBoM" style="display: none;">
                        <table id="tableListBoM" class="table table-bordered">
                            <thead >
                                <tr class=" text-center" style="position: sticky; top:36px; background-color: #fff; z-index: 1;">
                                    <th style="width: 1%;"> {{__('msg.phase')}}</th>
                                    <th style="width: 21%;"> {{__('msg.originalProductCode')}} </th>
                                    <th style="width: 75%;"> {{__('msg.originalProductName')}}</th>
                                    <th style="width: 1%;"> {{__('msg.unit')}} </th>
                                    <th style="width: 1%;"> {{__('msg.quantity')}}</th>
                                    <th style="width: 1%;"> {{__('msg.ratio')}} </th>
                                </tr>
                            </thead>
                            <tbody>

                                <tr style="background-color: #DDDDDD; " class="text-md">
                                    <td class="text-center p-0"> {{ collect($getDropListProducts)->pluck('phase')->first() }}</td>
                                    <td class="py-0 address"> {{ collect($getDropListProducts)->pluck('code')->first() }}</td>
                                    <td class="py-0 address"> {{ collect($getDropListProducts)->pluck('name')->first() }}</td>
                                    <td class="py-0"> {{ collect($getDropListProducts)->pluck('unit')->first() }}</td>
                                    <td class="py-0 text-right "> 1 </td>
                                    <td class="py-0 text-right">1</td>
                                </tr>

                                @foreach ($getBoMs as $bom)
                                @if ($bom->product_code == collect($getDropListProducts)->pluck('code')->first()
                                && $bom->product_phase == collect($getDropListProducts)->pluck('phase')->first() )
                                <tr class=" ">
                                    <td class="text-center p-0"> {{ $bom->material_phase}} </td>
                                    <td class="py-0 address"> {{ $bom->material_code }} </td>
                                    <td class="py-0 address"> {{ $bom->material_name}} </td>
                                    <td class="py-0"> {{ $bom->product_unit}} </td>
                                    <td class="py-0 text-right "> {{ number_format($bom->quantity) }} </td>
                                    <td class="py-0 text-right"> {{ ($bom->weight) }} </td>
                                </tr>
                                <tr class="">
                                    <td class="py-0 ">
                                        @include('partials.child-bom-process-list', [
                                        'materialCode_List' => $bom->material_code,
                                        'materialPhase_List' => $bom->material_phase,
                                        'getBoMs' => $getBoMs,
                                        ])
                                    </td>
                                </tr>
                                @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- TREE -->
                    <div class="row col-12 p-0 m-0  divTreeBoM ">
                        <table class="table table-bordered py-0 my-0">
                            <div class=" d-flex col-12 border-bottom m-0 p-0 py-1 pr-1 mt-2  text-right " style="background-color: #DDDDDD; ">
                                <div class="col-9 p-0 m-0 text-wrap  text-center"><b> {{__('msg.materialName')}}</b></div>
                                <div class="col-1 p-0 m-0 text-wrap"><i class="fa-solid fa-list-ol"></i> {{__('msg.quantity')}}</div>
                                <div class="col-1 p-0 m-0 text-wrap"><i class="fa-solid fa-weight-scale"></i>  {{__('msg.ratio')}}</div>
                                <div class="col-1 p-0 m-0 text-wrap"> </div>
                            </div>
                            <tbody>
                                <?php $numList = 0;?>
                                @foreach ($getBoMs as $bom)
                                @if ($bom->product_code == collect($getDropListProducts)->pluck('code')->first()
                                && $bom->product_phase == collect($getDropListProducts)->pluck('phase')->first() )
                                <div class=" col-12 m-0 p-0">
                                    <table class="table divTreeBoM mx-0">
                                        <tbody>
                                            <tr data-widget="expandable-table" aria-expanded="false" class="child-row">
                                                <td class=" border-right-0 border-top-0 p-0 pt-2 pr-1 ">
                                                    <div class="col-12 row m-0 p-0">
                                                        <div class="col-9 px-0">
                                                            <span class=""> <b> <u>{{++$numList}}. {{ $bom->material_phase }}</u></b></span>
                                                            @if (in_array($bom->material_code, array_column($getBoMs, 'product_code'))
                                                            && in_array($bom->material_phase, array_column($getBoMs, 'product_phase')) )
                                                            <span class="">
                                                                <i class="expandable-table-caret fas fa-caret-right fa-fw"></i>
                                                                {{ $bom->material_code }} | {{ $bom->material_name }}
                                                            </span>
                                                            @else
                                                            <span class="ml-4"> {{ $bom->material_code }} | {{ $bom->material_name }} </span>
                                                            @endif
                                                        </div>
                                                        <div class="col-1 p-0 text-right countQuantity">
                                                            <span class="">{{ number_format($bom->quantity) }}</span>
                                                        </div>
                                                        <div class="col-1 p-0 text-right">
                                                            <span class="">{{ ($bom->weight) }}</span>
                                                        </div>

                                                        <div class="col-1 p-0 text-right">
                                                            <div class="btn btn-group p-0">
                                                                <a class="btn text-success p-0 addBtn-trigger btn-add-bom" data-product-id="{{ $bom->materialID }}">
                                                                    <i class="fas fa-circle-plus"></i>
                                                                </a>
                                                                <a class="btn text-warning mx-1 p-0 updateBtn-trigger  btn-edit-bom" data-bom-productid="{{ $bom->productID }}" data-bom-materialid="{{ $bom->materialID }}">
                                                                    <i class="fa-solid fa-pencil"></i>
                                                                </a>
                                                                <a class="btn text-danger p-0 btn-delete-bom" type="submit" href="/bom/{{$bom->productID}}/{{$bom->materialID}}/delete/{{collect($getDropListProducts)->pluck('id')->first()}}" onclick="return confirm('Are you sure you want to delete: {{ $bom->material_name }}?')">
                                                                    <i class="fa-solid fa-trash"></i>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr class="expandable-body ">
                                                <td class="border-right-0 p-0  ">
                                                    <div class="p-0 m-0 border-right-0">
                                                        @include('partials.child-bom-process-tree', [
                                                        'materialCode_Tree' => $bom->material_code,
                                                        'materialPhase_Tree' => $bom->material_phase,
                                                        'productIDParrent' => collect($getDropListProducts)->pluck('id')->first() ,

                                                        'getBoMs' => $getBoMs,])
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                @endif
                                @endforeach
                        </table>
                    </div>

                </div>
            </div>
        </div>
        <!-- DIAGRAM -->
        <div class="card">
            <div class="card-header btn bg-dark pb-0" data-card-widget="collapse">
                <h3 class="card-title text-white ">2. Diagram</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool text-white" data-card-widget="collapse">
                        <i class="fas fa-minus"></i> </button>
                </div>
            </div>
            <div class="card-body p-0 m-0">
                <div class="col-sm-12 mr-0 pr-0">
                    <div class="diagram-container">
                        <div class="tree genealogy-scroll genealogy-body  tree-view-container" style="max-height:420px" id="card1">
                            <ul>
                                <li>
                                    <a class="p-2"><img style="width: 100px; height:100px;"><span class="bg-primary text-md">{{collect($getDropListProducts)->pluck('code')->first()}}</span>
                                        <p class="m-0 text-muted">{{collect($getDropListProducts)->pluck('process_name')->first()}}</p>
                                    </a>
                                    <ul>
                                        @foreach($getBoMs as $bomDiagram)
                                        @if ($bomDiagram->product_code == collect($getDropListProducts)->pluck('code')->first()
                                        && $bomDiagram->product_phase == collect($getDropListProducts)->pluck('phase')->first() )
                                        <li>
                                            <a><img class="" style="width: 50px; height:50px;"><span class="bg-info text-sm">
                                                    {{$bomDiagram->material_code}}
                                                    <i class="fa-solid fa-weight-scale">{{ number_format($bomDiagram->weight)}}</i>
                                                    <label class="m-0">
                                                        x{{ number_format($bomDiagram->quantity)}}
                                                    </label>
                                                </span>
                                            </a>
                                            @include('partials.child-bom-process-diagram',
                                            ['materialCode_Diagram' => $bomDiagram->material_code,
                                            'materialPhase_Diagram' => $bomDiagram->material_phase,
                                            'getBoMs' => $getBoMs,
                                            ])
                                        </li>
                                        @endif
                                        @endforeach
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('layouts.bom.partial-bom-add', [ 'getListProducts' => $getListProducts, 'phaseID' => collect($getDropListProducts)->pluck('product_PhaseID')->first() ])
    @include('layouts.bom.partial-bom-edit',  ['phaseID' => collect($getDropListProducts)->pluck('product_PhaseID')->first() ])
    @include('layouts.bom.partial-bom-copy')

</section>




@section('scripts-bom')
@include('scripts.script-bom')
@endsection

@push('scripts_fixPushMenu')
<script src="../../dist/js/adminlte.min.js?v=3.2.0"></script>
@endpush

@endsection
