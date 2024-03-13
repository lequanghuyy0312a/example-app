@extends('home._layout')
@section('title', 'Product | List')

@section('content')
<link rel="stylesheet" href="{{ asset('dist/css/myCSS_diagram.css') }}">

<section class="content-header bg-gradient-white py-1 shadow">
    <div class="container-fluid">
        <div class="row ">
            <div class="col-sm-6">
                <h1 class="m-0 text-fatk">Quy trình công đoạn</h1>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</section>
<section class="content my-2">
    <div class="card ">
        <div class=" col-12 mt-2">
            <h3 class="text-center">
                <b>
                    {{ collect($getDropListProducts)->pluck('code')->first() }} -
                    {{ collect($getDropListProducts)->pluck('name')->first() }}
                </b>
            </h3>
        </div>

        <div class="card">
            <div class="card-header btn bg-dark pb-0" data-card-widget="collapse">
                <h3 class="card-title text-white ">1. Danh sách linh kiện cấu thành và quy trình sản xuất</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool text-white" data-card-widget="collapse">
                        <i class="fas fa-minus"></i> </button>
                </div>
            </div>
            <div class="card-body m-0 p-0 mt-2">
                <div class="row p-0 m-0 px-2">
                    <div class="p-0 m-0 row  col-12 text-right">
                        <a id="toggleLink" href="#" class="btn btn-outline-secondary ">
                            <i id="iconA" class="fa-solid  fa-list" style="display: none;"></i>
                            <i id="iconB" class="fa-solid  fa-folder-tree"></i>
                        </a>
                    </div>
                    <div class="row col-12 p-0 m-0  col-12 divTreeBoM " style="display: none;">
                        <table class="table table-bordered">
                            <tbody>
                                <?php $numList = 0; ?>
                                @foreach ($getBoMs as $bom)
                                @if ($bom->product_code == collect($getDropListProducts)->pluck('code')->first()
                                && $bom->product_phase == collect($getDropListProducts)->pluck('phase')->first()
                                && $bom->product_costPrice == collect($getDropListProducts)->pluck('costPrice')->first())
                                <div class="m-0 p-0 col-12">
                                    <table class="table divTreeBoM" style="display: none;">
                                        <tbody>
                                            <tr data-widget="expandable-table" aria-expanded="true" class="child-row">
                                                <td class=" border-right-0 border-top-0 p-0 pt-2 pr-2 " style="background-color: #DDDDDD;">
                                                    <div class=" row m-0 p-0">
                                                        <div class="pl-2 col-12">
                                                            <span> {{ ++$numList }}. </span>
                                                            <span class="ml-2"> <b> {{ $bom->material_phase }}</b> </span>
                                                            @if (in_array($bom->material_code, array_column($getBoMs, 'product_code'))
                                                            && in_array($bom->material_phase, array_column($getBoMs, 'product_phase'))
                                                            && in_array($bom->material_costPrice, array_column($getBoMs, 'product_costPrice')))
                                                            <span class="">
                                                                <i class="expandable-table-caret fas fa-caret-right fa-fw"></i>
                                                                {{ $bom->material_code }} - {{ $bom->material_name }}
                                                            </span>
                                                            @else
                                                            <span class="ml-4"> {{ $bom->material_code }} - {{ $bom->material_name }} </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr class="expandable-body">
                                                <td class="border-right-0 p-0">
                                                    <div class="p-0 m-0 px-0  border-right-0 pl-5">
                                                        @include('partials.child-bom-process-tree', [
                                                        'materialCode_Tree' => $bom->material_code,
                                                        'materialPhase_Tree' => $bom->material_phase,
                                                        'materialCostPrice_Tree' => $bom->material_costPrice,
                                                        'getBoMs' => $getBoMs])
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
                    <div class=" row col-12 p-0  my-0 ml-2 pr-3 mt-2" id="divListBoM">
                        <table id="tableListBoM" class="table table-bordered">
                            <thead>
                                <tr class=" text-center">
                                    <th style="width: 1%;"> Kỳ </th>
                                    <th style="width: 20%;"> Mã LK / SP </th>
                                    <th style="width: 74%;"> Tên LK / SP </th>
                                    <th style="width: 1%;"> ĐVT </th>
                                    <th style="width: 1%;"> Số lượng </th>
                                    <th style="width: 1%;"> tỷ lệ </th>
                                    <th style="width: 1%;"> Chi phí </th>
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
                                    <td class="py-0 text-right">{{ number_format(collect($getDropListProducts)->pluck('costPrice')->first()) }}</td>

                                </tr>

                                @foreach ($getBoMs as $bom)
                                @if ($bom->product_code == collect($getDropListProducts)->pluck('code')->first()
                                && $bom->product_phase == collect($getDropListProducts)->pluck('phase')->first()
                                && $bom->product_costPrice == collect($getDropListProducts)->pluck('costPrice')->first())
                                <tr class=" ">
                                    <td class="text-center p-0"> {{ $bom->material_phase}} </td>
                                    <td class="py-0 address"> {{ $bom->material_code }} </td>
                                    <td class="py-0 address"> {{ $bom->material_name}} </td>
                                    <td class="py-0"> {{ $bom->product_unit}} </td>
                                    <td class="py-0 text-right "> {{ number_format($bom->quantity) }} </td>
                                    <td class="py-0 text-right"> {{ ($bom->weight) }} </td>
                                    <td class="py-0 text-right"> {{ number_format($bom->material_costPrice) }} </td>
                                </tr>
                                <tr>
                                    <td class="py-0">
                                        @include('partials.child-bom-process-list', [
                                        'materialCode_List' => $bom->material_code,
                                        'materialPhase_List' => $bom->material_phase,
                                        'materialCostPrice_List' => $bom->material_costPrice,
                                        'getBoMs' => $getBoMs,
                                        ])
                                    </td>
                                </tr>
                                @endif
                                @endforeach
                                <!-- <tr>
                                    <td colspan="7" class=" p-2 m-0">
                                        <div class="row col-12 p-0 m-0">
                                            <span class="input-group col-sm-3 m-0 p-0">
                                                <input type="button" value="-" class="button-minus" data-field="quantity">
                                                <input type="number" step="1" max="" value="1" min="1" name="quantity" class="quantity-field" id="quantity-field">
                                                <input type="button" value="+" class="button-plus" data-field="quantity">
                                            </span>
                                            <span class="col-sm-9 m-0 p-0 text-right">
                                                Chi phí sản xuất sản phẩm: <b>
                                                    {{ collect($getDropListProducts)->pluck('code')->first() }} -
                                                    {{ collect($getDropListProducts)->pluck('name')->first() }}
                                                </b>
                                            </span>
                                        </div>
                                    </td>
                                    <td colspan="3" class="text-right bg-info p-2"> <b class="text-lg" id="grandTotalBomList">0.00</b></td>
                                </tr> -->
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>
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
                                        && $bomDiagram->product_phase == collect($getDropListProducts)->pluck('phase')->first()
                                        && $bomDiagram->product_costPrice == collect($getDropListProducts)->pluck('costPrice')->first())
                                        <li>
                                            <a><img class="" style="width: 50px; height:50px;"><span class="bg-info text-sm">
                                                    {{$bomDiagram->material_code}}
                                                    <i style="font-size: 13px;">x{{ number_format($bomDiagram->quantity)}}</i>
                                                </span>
                                            </a>
                                            @include('partials.child-bom-process-diagram',
                                            ['materialCode_Diagram' => $bomDiagram->material_code,
                                            'materialPhase_Diagram' => $bomDiagram->material_phase,
                                             'materialCostPrice_Diagram' => $bomDiagram->material_costPrice,
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
</section>

@push('scripts_fixPushMenu')
<script src="../../dist/js/adminlte.min.js?v=3.2.0"></script>
@endpush
@endsection
