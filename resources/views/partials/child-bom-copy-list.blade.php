@foreach ($getBoMs as $bomChild)
@if ($bomChild->product_code == $materialCode_List
&& $bomChild->product_phase == $materialPhase_List )
<tr>
    <td class="py-0 address getMaterialCode"> {{ $bomChild->material_code }} </td>
    <td class="py-0 text-right"> {{ number_format($bomChild->quantity) }} </td>
    <td class="py-0 text-right"> {{ $bomChild->weight }} </td>

</tr>
<tr>
    <td class="py-0">
        @include('partials.child-bom-copy-list', [
        'materialCode_List' => $bomChild->material_code,
        'materialPhase_List' => $bomChild->material_phase,
        'getBoMs' => $getBoMs,
        ])
    </td>
</tr>
@endif
@endforeach
