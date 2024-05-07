@foreach ($getBoMs as $bomChild)
@if ($bomChild->product_code == $materialCode_List
&& $bomChild->product_phase == $materialPhase_List )
<tr>
    <td class="text-center p-0"> {{ $bomChild->material_phase}} </td>
    <td class="py-0 address"> {{ $bomChild->material_code }} </td>
    <td class="py-0 address"> {{ $bomChild->material_name}} </td>
    <td class="py-0"> {{ $bomChild->product_unit}}  </td>
    <td class="py-0 text-right"> {{ number_format($bomChild->quantity) }} </td>
    <td class="py-0 text-right"> {{ $bomChild->weight }} </td>

</tr>
<tr>
    <td class="py-0">
        @include('partials.child-bom-process-list', [
        'materialCode_List' => $bomChild->material_code,
        'materialPhase_List' => $bomChild->material_phase, 
        'getBoMs' => $getBoMs,
        ])
    </td>
</tr>
@endif
@endforeach
