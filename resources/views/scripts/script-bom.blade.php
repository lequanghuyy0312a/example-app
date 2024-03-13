<script>
    $(document).ready(function() {
        $(document).on('click', '.btn-add-bom', function() {
            var productId = $(this).data('product-id');
            $('#productByPhaseIDAdd').val(productId);
            $.ajax({
                url: '/bom/modal/' + productId,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    $('#showCodeAdd').text(data.getProductToAdd[0].code);
                    $('#showIDAdd').val(data.getProductToAdd[0].id);
                    $('#showNameAdd').text(data.getProductToAdd[0].name);
                    $('#showPhaseAdd').text(data.getProductToAdd[0].phase);
                    // Open the modal
                    $('#addBoMModal').modal('show');
                    $('#defaultSelect').select2({
                        theme: 'bootstrap4',
                        placeholder: '...',
                        dropdownParent: '#addBoMModal'
                    });
                },
                error: function() {
                    console.log('Error fetching data.');
                }

            });
        });
    });
    $(document).ready(function() {
        AddRowButton();
        // Xử lý sự kiện khi click nút remove
        $("#dynamicRowsContainer").on("click", ".btn-remove-row", function() {
            $(this).closest(".dynamic-row").remove();

        });
    });

    function AddRowButton() {
        $("#addRowBtn").click(function() {
            var newRow = $(".dynamic-row:first").clone();

            // Generate a unique ID for the new select element
            var newSelectId = "select2-" + $(".dynamic-row").length;

            // Assign the new ID to the select element in the cloned row
            newRow.find("select").attr("id", newSelectId);

            // Remove the disabled attribute for all cloned rows except the first one
            if ($(".dynamic-row").length > 0) {
                newRow.find("select").removeAttr("hidden");
                newRow.find("input").removeAttr("hidden");
                newRow.find("input").removeAttr("hidden");
                newRow.find("a").removeAttr("hidden");
            }

            $("#dynamicRowsContainer").append(newRow);

            // Khởi tạo Select2 cho dropdown mới
            $("#" + newSelectId).select2({
                theme: 'bootstrap4',
                placeholder: '...',
                dropdownParent: '#addBoMModal' // tạo select cho form add new
            });
        });
    }
    document.addEventListener("DOMContentLoaded", function() {
        var formattedNumbers = document.querySelectorAll('.formatted-number');
        formattedNumbers.forEach(function(numberElement) {
            var value = parseFloat(numberElement.textContent);
            if (!isNaN(value)) {
                numberElement.textContent = formatNumberPrice(value);
            }
        });

        function formatNumberPrice(number) {
            return new Intl.NumberFormat('en-US', {
                minimumFractionDigits: 0,
                maximumFractionDigits: 0
            }).format(number);
        }
    });
    $(document).ready(function() {
        $('.select2').select2({
            dropdownParent: '#addBoMModal' // tạo select cho form add new
        });
    });

    ////////////////////EDIT//////////////////////////////
    $(document).ready(function() {
        $(document).on('click', '.btn-edit-bom', function() {
            var productId = $(this).data('bom-productid');
            var materialId = $(this).data('bom-materialid');
            console.log("Product ID:", productId);
            console.log("Material ID:", materialId);

            console.log(productId, materialId);
            $.ajax({
                url: '/bom-edit/modal/' + productId + '/' + materialId,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    $('#showCodeEdit').text(data.getMaterialEdit[0].code);
                    $('#showNameEdit').text(data.getMaterialEdit[0].name);
                    $('#showPhaseEdit').text(data.getMaterialEdit[0].phase);
                    // Open the modal
                    $('#editBoMModal').modal('show');
                    $('#productIDHidden').val(productId);
                    $('#materialIDHidden').val(materialId);
                },
                error: function() {
                    console.log('Error fetching data.');
                }

            });
        });
    });
</script>
