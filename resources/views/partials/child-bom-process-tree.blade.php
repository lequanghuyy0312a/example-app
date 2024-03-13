<table class="table divTreeBoM" style="display: none;">
    <tbody>
        @foreach ($getBoMs as $bom)
        @if ( $bom->product_code == $materialCode_Tree
        && $bom->product_phase == $materialPhase_Tree
        && $bom->product_costPrice == $materialCostPrice_Tree)
        <tr data-widget="expandable-table" aria-expanded="true" class="child-row">
            <td class=" border-right-0 p-0 pt-2 pr-1">
                <div class="col-12 row m-0 p-0">
                    <div class="col-12">
                        <span class=""> <b>{{ $bom->material_phase }}</b></span>
                        @if (in_array($bom->material_code, array_column($getBoMs, 'product_code'))
                        && in_array($bom->material_phase, array_column($getBoMs, 'product_phase'))
                        && in_array($bom->material_costPrice, array_column($getBoMs, 'product_costPrice')))
                        <span>
                            <i class="expandable-table-caret fas fa-caret-right fa-fw"></i>
                            {{ $bom->material_code }} - {{ $bom->material_name }}
                        </span>
                        @else
                        <span class=" ml-4"> {{ $bom->material_code }} - {{ $bom->material_name }}
                        </span>
                        @endif 
                    </div>
                </div>

            </td>
        </tr>
        <tr class="expandable-body">
            <td class=" border-right-0 p-0 ">
                <div class=" p-0  border-right-0 pl-5">
                    @include('partials.child-bom-process-tree', [
                    'materialCode_Tree' => $bom->material_code,
                    'materialPhase_Tree' => $bom->material_phase,
                    'materialCostPrice_Tree' => $bom->material_costPrice,
                    'getBoMs' => $getBoMs])
                </div>
            </td>
        </tr>
        @endif
        @endforeach
    </tbody>
</table>
