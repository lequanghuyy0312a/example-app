<div class="modal fade" id="editBoMModal" tabindex="-1" role="dialog" aria-labelledby="updateQuantityModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{__('msg.editQuantity')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="/bom-edit-submit" method="post">
                @method("PATCH")
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="productIDHidden" id="productIDHidden" value="">
                    <input type="hidden" name="materialIDHidden" id="materialIDHidden" value="">
                    <input type="hidden" name="hiddenProductIdParrentEditBoM" id="hiddenProductIdParrentEditBoM" value="">
                    <div class="form-group text-center">
                        <h5 class="text-center">
                            <b id="showPhaseEdit"></b> 
                        </h5>
                        <p id="showNameEdit"></p>
                    </div>
                    <div class="form-group">
                        <label for="quantity">1. {{__('msg.quantity')}}</label>
                        <input type="number" name="quantityEdit" min="1" class="form-control" id="showQuantityEdit" required>
                    </div>
                    <div class="form-group">
                        <label for="quantity">2. {{__('msg.ratio')}}</label>
                        <input type="number" name="weightEdit" min="0" step="any" class="form-control" id="showWeightEdit" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('msg.close')}}</button>
                    <button type="submit" class="btn btn-primary">{{__('msg.upgrade')}}</button>
                </div>
            </form>
        </div>
    </div>
</div>
