<ul class="">
    @foreach($getBoMs as $bomDiagram)
    @if ($bomDiagram->product_code == $materialCode_Diagram
    && $bomDiagram->product_phase == $materialPhase_Diagram )
    <li>
        <a><img><span class="bg-secondary px-1 text-xs">{{$bomDiagram->material_code}}
                <label class="m-0" style="font-size: 13px;">
                    <i class="fa-solid fa-weight-scale" style="font-size: 13px;"></i>
                    {{ number_format($bomDiagram->weight)}}
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
