<script>
    $(document).ready(function() {
        $('.select2-purchase-order-phaseIDSelectionToPurchaseOrder').select2({});
        initializeSelect2('#addModalPurchaseOrder', '.select2');

    });

    function initializeSelect2(parentElement, selector) {
        $(parentElement).find(selector).select2({
            dropdownParent: parentElement
        });
    }
</script>
 
