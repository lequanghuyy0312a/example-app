<div id="modal-container " >
    <div class="modal fade" id="copyBoMModal" tabindex="0" role="dialog" aria-hidden="true" style="z-index: 1050; display: none" aria-labelledby="editUserModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content" style="width: 800px; ">
                <div class="modal-header bg-primary pb-0">
                    <h3 class="card-title" id="editUserModalLabel"> {{__('msg.makeCopyBoM')}}</h3>
                    <button type="button" class="close" data-dismiss="modal" area-label="Close">
                        <span aria-hidden="true"><i class="fa fa-close"></i> </span>
                    </button>
                </div>
                <form action="/bom-copy-submit" method="post">
                    @csrf
                    <div class="modal-body"  style="height: 560px; overflow-y: auto;">

                        <div class="form-group text-center">
                            <input hidden class="form-control" name="showProductIDCopy" id="showProductIDCopy" />
                            <input hidden class="form-control" name="hiddenShowCodeCopy" id="hiddenShowCodeCopy" />
                            <h5><b id="showCodeCopy"></b></h5>
                            <p id="showNameCopy"></p>
                        </div>

                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th style="width: 50%" class="text-center">{{__('msg.currentPhase')}}( <b id="showPhaseCopy"></b> )</th>
                                    <input hidden class="form-control" name="hiddenPhaseIDCurrent" id="hiddenPhaseIDCurrent" />

                                    <th style="width: 50%" class="text-center">
                                        <select class="form-control select2" data-dropdown-css-class="select2-primary" name="phaseIDcopy" id="phaseIDcopy" style="width: 100%;" required>
                                            <option selected disabled>{{__('msg.choosePhasePickup')}}</option>
                                            <?php $numCopy = 0; ?>
                                            @foreach($getDropListPhasesToCopy as $phase)
                                            <option value="{{ $phase->id }}">{{ ++$numCopy }}. {{ $phase->name }}</option>
                                            @endforeach
                                        </select>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="p-0 pr-1">
                                        <table class="table table-bordered">
                                            <thead class="bg-warning">
                                                <tr class=" text-center">
                                                    <th style="width: 60%;"> {{__('msg.materialCode')}}</th>
                                                    <th style="width: 20%;"> {{__('msg.quantity')}} </th>
                                                    <th style="width: 20%;"> {{__('msg.ratio')}} </th>
                                                </tr>
                                            </thead>
                                            <tbody style="background-color:lemonchiffon">
                                                @foreach ($getBoMs as $bom)
                                                @if ($bom->product_code == collect($getDropListProducts)->pluck('code')->first()
                                                && $bom->product_phase == collect($getDropListProducts)->pluck('phase')->first() )
                                                <tr class=" ">
                                                    <td class="py-0 address"> {{ $bom->material_code }} </td>
                                                    <td class="py-0 text-right "> {{ number_format($bom->quantity) }} </td>
                                                    <td class="py-0 text-right"> {{ ($bom->weight) }} </td>
                                                </tr>
                                                <tr class="">
                                                    <td class="py-0 ">
                                                        @include('partials.child-bom-copy-list', [
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
                                    </td>
                                    <td class="p-0 pl-1">
                                        <table class="table table-bordered" id="checkTable">
                                            <thead class="bg-primary">
                                                <tr class=" text-center">
                                                    <th style="width: 60%;">  {{__('msg.materialCode')}}</th>
                                                    <th style="width: 20%;">  {{__('msg.quantity')}} </th>
                                                    <th style="width: 20%;"> {{__('msg.ratio')}} </th>
                                                </tr>
                                            </thead>
                                            <tbody style="background-color: aliceblue;">
                                                @foreach ($getBoMs as $bom)
                                                @if ($bom->product_code == collect($getDropListProducts)->pluck('code')->first()
                                                && $bom->product_phase == collect($getDropListProducts)->pluck('phase')->first() )
                                                <tr class=" ">
                                                    <td class="py-0 address getMaterialCode"> {{ $bom->material_code }} </td>
                                                    <td class="py-0 text-right "> {{ number_format($bom->quantity) }} </td>
                                                    <td class="py-0 text-right">{{ ($bom->weight) }}</td>
                                                </tr>
                                                <tr class="">
                                                    <td class="py-0 ">
                                                        @include('partials.child-bom-copy-list', [
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
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <label class="text-danger" id="notifiCheckProductExist">{{__('msg.checkProductNotExist')}}<a href="/products" class="btn btn-link" target="_blank"> {{__('msg.addNow')}}</a></label>
                        <div id="divCheckOptionToDelete">
                            <!-- radio -->
                            <div class="form-group clearfix">
                                <div class="icheck-danger">
                                    <input type="radio" name="checkOptionToDelete" value="0" checked id="radioDanger1">
                                    <label for="radioDanger1">
                                    {{__('msg.chooseKeepOld')}}
                                    </label>
                                </div>
                                <div class="icheck-danger">
                                    <input type="radio" name="checkOptionToDelete" value="1" id="radioDanger2">
                                    <label for="radioDanger2"> {{__('msg.chooseDeleteAll')}}
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class=" card-footer">
                        <a class="btn btn-secondary float-right btnCancelModal text-white ml-2" class="close" data-dismiss="modal" area-label="Close">{{__('msg.cancel')}}</a>
                        <a class="btn btn-warning float-right checkMaterialNotEmpty">{{__('msg.check')}}</a>
                        <button id="btnSaveCopyBoM" type="submit" onclick="return confirm('You have selected the correct copy format?')" class="btn btn-primary">{{__('msg.save')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
 