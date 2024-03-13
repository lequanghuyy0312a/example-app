<table class="table">
    <tbody>
        @foreach ($getBoMs as $bom)
        @if ($bom->product_code == $parentMaterial && $bom->product_phase == $materialPhase && $bom->product_costPrice == $materialCostPrice)
        <tr data-widget="expandable-table" aria-expanded="false" class="child-row ">
            <td class=" border-right-0 p-0 pt-2 pr-1">
                <div class="col-12 row m-0 p-0">
                    <div class="col-7 px-0  ellipsis-span">

                        <span class=""> <b>{{ $bom->material_phase }}</b></span>
                        @if (in_array($bom->material_code, array_column($getBoMs, 'product_code'))
                        && in_array($bom->material_phase, array_column($getBoMs, 'product_phase')))
                        <span class="">
                            <i class="expandable-table-caret fas fa-caret-right fa-fw"></i>
                            {{ $bom->material_name }}
                        </span>
                        @else
                        <span class=" ml-4"> {{ $bom->material_name }} </span>
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
                        <b class="formatted-number ">{{ ($bom->material_costPrice * $bom->quantity * $bom->weight ) }}</b>
                    </div>
                    <div class="col-1 p-0 text-right">
                        <div class="btn btn-group p-0">
                            <a class="btn text-secondary p-0 addBtn-trigger btn-add-bom" data-product-id="{{ $bom->materialID }}">
                                <i class="fas fa-circle-plus"></i>
                            </a>
                            <a class="btn text-secondary mx-1 p-0 updateBtn-trigger  btn-edit-bom" data-bom-productid="{{ $bom->productID }}" data-bom-materialid="{{ $bom->materialID }}">
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
            <td class=" border-right-0  ">
                <div class="p-0  border-right-0">
                    @include('layouts.bom.child-bom', [
                    'parentMaterial' => $bom->material_code,
                    'materialPhase' => $bom->material_phase,
                    'materialCostPrice' => $bom->material_costPrice,
                    'currentLevel' => 2, 'getBoMs' => $getBoMs])
                </div>
            </td>
        </tr>
        @endif
        @endforeach
    </tbody>
</table>
