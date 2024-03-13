@extends('home._layout')
@section('title', 'Product | List')

@section('content')
<section class="content-header bg-gradient-white py-1 shadow">
    <div class="container-fluid">
        <div class="row ">
            <div class="col-sm-6">
                <h1 class="m-0 text-fatk">Bill of Material</h1>
            </div><!-- /.col -->

        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</section>
<section class="content my-2">
    <div class="">
        <div class="card mt-2">
            <div class="card-header btn bg-dark pb-0" data-card-widget="collapse">
                <h3 class="card-title text-white ">Danh sách Sản phẩm và Linh kiện cấu thành</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool text-white" data-card-widget="collapse">
                        <i class="fas fa-minus"></i> </button>
                </div>
            </div>
            <div class="card-body">
                <table id="BoMTable" class="table table-bordered  ">
                    <thead>
                        <tr class="text-center">
                            <th style="width: 1%" class="py-1"> STT </th>
                            <th style="width: 5%" class="py-1"> Kỳ</th>
                            <th style="width: 13%" class="py-1 py-1 d-none d-sm-table-cell"> Mã LK / SP </th>
                            <th style="width: 80%" class="py-1"> Tên LK / SP </th>
                            <th style="width: 1%">
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $numList = 0;
                        ?>
                        @foreach ($getListProducts as $product)
                        <tr>
                            <td class="text-center p-0"><a href="/bill-of-material/{{$product->id}}">{{ ++$numList }}</a></td>
                            <td class="py-0"> {{ $product->phase }} </td>
                            <td class="py-0 py-1 d-none d-sm-table-cell"> <a href="/bill-of-material/{{$product->id}}">{{ $product->code }}</a> </td>
                            <td class="p-0 border-top-0 ">
                                <table class="table">
                                    <tbody>
                                        <tr data-widget="expandable-table" aria-expanded="false" class="parent-row">
                                            <td class="ml-2 pt-2 pb-0 border-right-0 pr-0 ">
                                                <div>
                                                    @if(in_array($product->id, array_column($getBoMs, 'productID')))
                                                    <span class="col-6 pl-0 ">
                                                        <i class="expandable-table-caret fas fa-caret-right fa-fw"></i>
                                                        <b> {{ $product->name }}</b>
                                                    </span>
                                                    @else
                                                    <span class="  col-6 ml-4 pl-0">
                                                        <b> {{ $product->name }}</b>
                                                    </span>
                                                    @endif
                                                    <span class="float-right mr-2">(Số LK: <b class="total-quantity"></b> = <b class="total-amount "></b>)</span>
                                                    <i class="text-primary text-muted formatted-number ">(Chi phí: <a class="costPriceProduct">{{ ($product->costPrice) }})</a></i>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr class="expandable-body">
                                            <td class="border-top-1 border-right-0">
                                                <div class=" d-flex m-0 border-bottom p-0 py-1 pr-1 text-right " style="background-color: #DDDDDD;">
                                                    <div class="col-7 p-0 m-0 text-wrap  text-center"><b>Material name</b></div>
                                                    <div class="col-1 p-0 m-0 text-wrap"><i class="fa-solid fa-dollar-sign"></i></div>
                                                    <div class="col-1 p-0 m-0 text-wrap"><i class="fa-solid fa-list-ol"></i></div>
                                                    <div class="col-1 p-0 m-0 text-wrap"><i class="fa-solid fa-weight-scale"></i></div>
                                                    <div class="col-1 p-0 m-0 text-wrap"><i class="fa-solid fa-sack-dollar"></i></div>
                                                    <div class="col-1 p-0 m-0 text-wrap"> </div>
                                                </div>
                                                <?php $numchild = 0; ?>
                                                @foreach ($getBoMs as $bom)
                                                @if ($bom->product_code == $product->code
                                                && $bom->product_phase == $product->phase
                                                && $bom->product_costPrice == $product->costPrice)
                                                <div class="m-0 p-0 " style="background-color: #DDDDDD;">
                                                    <table class="table ">
                                                        <tbody>
                                                            <tr data-widget="expandable-table" aria-expanded="false" class="child-row">
                                                                <td class=" border-right-0 p-0 pt-2 pr-1 ">
                                                                    <div class="col-12 row m-0 p-0">
                                                                        <div class="col-7 px-0">
                                                                            <span class=""> <b>{{ $bom->material_phase }}</b></span>
                                                                            @if (in_array($bom->material_code, array_column($getBoMs, 'product_code'))
                                                                            && in_array($bom->material_phase, array_column($getBoMs, 'product_phase'))
                                                                            && in_array($bom->material_costPrice, array_column($getBoMs, 'product_costPrice')))
                                                                            <span class="">
                                                                                <i class="expandable-table-caret fas fa-caret-right fa-fw"></i>
                                                                                {{ $bom->material_name }}
                                                                            </span>
                                                                            @else
                                                                            <span class="ml-4"> {{ $bom->material_name }} </span>
                                                                            @endif
                                                                        </div>
                                                                        <div class="col-1 p-0 text-right">
                                                                            <span class="formatted-number">{{ ($bom->material_costPrice) }}</span>
                                                                        </div>
                                                                        <div class="col-1 p-0 text-right countQuantity">
                                                                            <span class="">{{ number_format($bom->quantity) }}</span>
                                                                        </div>
                                                                        <div class="col-1 p-0 text-right">
                                                                            <span class="">{{ ($bom->weight) }}</span>
                                                                        </div>
                                                                        <div class="col-1 p-0 text-right totalAmount">
                                                                            <b class="formatted-number">{{ ($bom->material_costPrice * $bom->quantity * $bom->weight ) }}</b>
                                                                        </div>
                                                                        <div class="col-1 p-0 text-right">
                                                                            <div class="btn btn-group p-0">

                                                                                <a class="btn text-secondary p-0 addBtn-trigger btn-add-bom" data-product-id="{{ $bom->materialID }}">
                                                                                    <i class="fas fa-circle-plus"></i>
                                                                                </a>
                                                                                <a class="btn text-secondary p-0 mx-1 updateBtn-trigger btn-edit-bom" data-bom-productid="{{ $bom->productID }}" data-bom-materialid="{{ $bom->materialID }}">
                                                                                    <i class="fa-solid fa-pencil"></i>
                                                                                </a>
                                                                                <a class="btn text-secondary p-0 " type="submit" href="/bom/{{$bom->productID}}/{{$bom->materialID}}/delete" onclick="return confirm('Bạn chọn xoá: {{ $bom->material_name }}?')">
                                                                                    <i class="fa-solid fa-trash"></i>
                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </td>

                                                            </tr>
                                                            <tr class="expandable-body">
                                                                <td class="border-right-0 p-0">
                                                                    <div class="p-0  border-right-0">
                                                                        @include('layouts.bom.child-bom', [
                                                                        'parentMaterial' => $bom->material_code,
                                                                        'materialPhase' => $bom->material_phase,
                                                                        'materialCostPrice' => $bom->material_costPrice,
                                                                        'currentLevel' => 2, 'getBoMs' => $getBoMs])
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                @endif
                                                @endforeach
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                            <td class="p-0">
                                <div class="btn btn-group-vertical p-0">
                                    <a class="btn text-success btn-default  p-0 px-3 addBtn-trigger btn-add-bom" data-product-id="{{ $product->id }}">
                                        <i class="fas fa-circle-plus"></i>
                                    </a>
                                    <!-- <a href="/print-BoM/{{$product->id}}" rel="noopener" target="_blank" class="btn btn-sm  mx-2 p-0 text-warning printBtn-trigger"><i class="fas fa-print"></i></a> -->
                                    <a class="btn text-danger p-0 btn-default px-3" type="submit" href="/bom/{{$product->id}}/remove" onclick="return confirm('Bạn chọn xoá : {{ $product->name}}?')">
                                        <i class="fa-solid fa-trash"></i>
                                    </a>
                                </div>
                            </td>

                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @include('layouts.bom.partial-bom-add', [ 'getListProducts' => $getListProducts])
    @include('layouts.bom.partial-bom-edit')


</section>


@section('scripts-bom')
@include('scripts.script-bom')
@endsection
@endsection
