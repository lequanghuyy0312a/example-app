<table class="table divTreeBoM">
    <tbody>
        @foreach ($getBoMs as $bom)
        @if ( $bom->product_code == $materialCode_Tree
        && $bom->product_phase == $materialPhase_Tree )
        <tr data-widget="expandable-table" aria-expanded="false" class="child-row">
            <td class=" border-right-0 border-top-0  p-0 pt-2 pr-1">
                <div class="col-12 row m-0 p-0">
                    <div class="col-9 px-0 ">
                        <span class=""> <b>- {{ $bom->material_phase }}</b></span>
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
                            <a class="btn text-secondary p-0 addBtn-trigger btn-add-bom" data-product-id="{{ $bom->materialID }}">
                                <i class="fas fa-circle-plus"></i>
                            </a>
                            <a class="btn text-secondary mx-1 p-0 updateBtn-trigger  btn-edit-bom" data-bom-productid="{{ $bom->productID }}" data-bom-materialid="{{ $bom->materialID }}">
                                <i class="fa-solid fa-pencil"></i>
                            </a>
                            <a class="btn text-secondary p-0 " type="submit" href="/bom/{{$bom->productID}}/{{$bom->materialID}}/delete/{{$productIDParrent}}" onclick="return confirm('Are you sure you want to delete: {{ $bom->material_name }}?')">
                                <i class="fa-solid fa-trash"></i>
                            </a>
                        </div>
                    </div>

                </div>

            </td>
        </tr>
        <tr class="expandable-body">
            <td class=" border-right-0 p-0 ">
                <div class="m-0 p-0  border-right-0 ">
                    @include('partials.child-bom-process-tree', [
                    'materialCode_Tree' => $bom->material_code,
                    'materialPhase_Tree' => $bom->material_phase,
                    'productIDParrent' => $productIDParrent ,

                    'getBoMs' => $getBoMs])
                </div>
            </td>
        </tr>
        @endif
        @endforeach
    </tbody>
</table>
