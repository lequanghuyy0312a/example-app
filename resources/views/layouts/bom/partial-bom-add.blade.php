<div id="modal-container">
    <div class="modal fade" id="addBoMModal" tabindex="0" role="dialog" aria-hidden="true" style="z-index: 1050; display: none" aria-labelledby="editUserModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content" style="width: 800px;">
                <div class="modal-header bg-primary">
                    <h3 class="card-title" id="editUserModalLabel">Thêm Linh kiện vào Sản phẩm</h3>
                    <button type="button" class="close" data-dismiss="modal" area-label="Close">
                        <span aria-hidden="true"><i class="fa fa-close"></i> </span>
                    </button>
                </div>
                <form action="/bom-add-submit" method="post">
                    @csrf
                    <div class="modal-body">

                        <div class="form-group text-center">
                            <input hidden class="form-control" name="productIDAdd" id="showIDAdd" />
                            <h5><b id="showPhaseAdd"></b> - <b id="showCodeAdd"></b></h5>
                            <p id="showNameAdd"></p>
                        </div>

                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th style="width: 78%" class="text-center">Product / Material</th>
                                    <th style="width: 10%" class="text-center">Quantity</th>
                                    <th style="width: 11%" class="text-center">Ratio</th>
                                    <th style="width: 1%" class="text-center">
                                        <a class="btn btn-add-row text-success p-0 m-0" id="addRowBtn">
                                            <i class="fa-solid fa-plus"></i>
                                        </a>
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="dynamicRowsContainer">
                                <tr class="dynamic-row ">
                                    <td>
                                        <select hidden class="form-control select2-danger"   data-dropdown-css-class="select2-danger" id name="materialIDAdd[]" style="width: 100%;"  >
                                            <option selected disabled>Chọn Linh kiện</option>
                                            <?php $numAdd = 0;
                                            $sortedProducts = collect($getListProducts)->sortBy('costPrice')->all(); ?>
                                            @foreach($sortedProducts as $product)
                                            <option value="{{ $product->id }}">{{ ++$numAdd }}.{{ $product->phase }} - {{ $product->name }}: {{ $product->costPrice }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <input hidden class="form-control p-0 px-1" name="quantityAdd[]" type="number" min="0" step="any"   />
                                    </td>
                                    <td>
                                        <input hidden class="form-control p-0 px-1" name="weightAdd[]" type="number" min="0" step="any"   />
                                    </td>
                                    <td>
                                        <a hidden class="btn btn-remove-row text-danger p-0 m-0 pt-2">
                                            <i class="fa-solid fa-xmark"></i>
                                        </a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="text-right card-footer">
                        <button type="submit" class="btn btn-primary">{{__('msg.save')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
