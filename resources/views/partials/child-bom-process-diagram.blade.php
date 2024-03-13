<ul class="">
    @foreach($getBoMs as $bomDiagram)
    @if ($bomDiagram->product_code == $materialCode_Diagram
    && $bomDiagram->product_phase == $materialPhase_Diagram
    && $bomDiagram->product_costPrice == $materialCostPrice_Diagram)
    <li>
        <a><img><span class="bg-secondary px-1 text-xs">{{$bomDiagram->material_code}}
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
