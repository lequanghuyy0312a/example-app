<script>
    $(document).ready(function() {

        $('#toggleLink').on('click', function(e) {
            e.preventDefault();
            $('#iconA, #iconB').toggle();
            $('#divListBoM').toggle();
            $('.divTreeBoM').toggle();
        });

        $(document).on('click', '.btn-copy-bom', function() {
            var productId = $(this).data('product-id');
            $('#productByPhaseIDCopy').val(productId);
            $("#notifiCheckProductExist").hide(); // Ẩn thông báo khi load view
            $("#divCheckOptionToDelete").hide(); // Ẩn div option khi load view

            $("#btnSaveCopyBoM").attr("disabled", "disabled"); // Vô hiệu hóa nút

            $.ajax({
                url: '/bom/modal-copy/' + productId,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    $('#showCodeCopy').text(data.getProductToCopy[0].code);
                    $('#hiddenShowCodeCopy').val(data.getProductToCopy[0].code);
                    $('#showProductIDCopy').val(productId);
                    $('#showNameCopy').text(data.getProductToCopy[0].name);
                    $('#showPhaseCopy').text(data.getProductToCopy[0].phase);
                    $('#hiddenPhaseIDCurrent').val(data.getProductToCopy[0].phaseID);

                    console.log('id: ' + data.getProductToCopy[0].phaseID);
                    $('#copyBoMModal').modal('show');

                    $('#phaseIDcopy').select2({
                        theme: 'bootstrap4',
                        placeholder: '...',
                        dropdownParent: '#copyBoMModal'
                    });

                    // Gọi hàm kiểm tra vật liệu
                    checkMaterialInList(data.getProductToCheck);
                },
                error: function() {
                    console.log('Error fetching data.');
                }
            });
        });

        // Hàm kiểm tra vật liệu
        function checkMaterialInList(getProductToCheck) {
            $(".checkMaterialNotEmpty").click(function() {
                var materialCodes = [];
                $("table#checkTable tbody tr").find('.getMaterialCode').css('color', '');

                var phaseNameSelected = $('#phaseIDcopy').val().trim();
                var productCode = $('#showCodeCopy').text().trim();
                var notifiElement = $("#notifiCheckProductExist");
                var divCheckOptionToDelete = $("#divCheckOptionToDelete");
                notifiElement.hide(); // Ẩn thông báo khi không có dòng nào có chữ màu đỏ
                divCheckOptionToDelete.hide();
                var redRowCount = 0; // Biến đếm số lượng dòng có chữ màu đỏ

                // Duyệt qua từng dòng trong bảng
                $("table#checkTable tbody tr").each(function() {
                    var row = $(this);
                    var materialCode = row.find(".getMaterialCode").text().trim();
                    var isMaterialInList = false;

                    // Kiểm tra xem vật liệu có tồn tại trong danh sách sản phẩm không
                    for (var j = 0; j < getProductToCheck.length; j++) {
                        if (getProductToCheck[j].phaseID == phaseNameSelected && getProductToCheck[j].code == materialCode) {
                            isMaterialInList = true;
                            break;
                        }
                    }

                    // Đổi màu chữ của hàng tương ứng
                    if (isMaterialInList == false) {
                        row.find('.getMaterialCode').css('color', 'red');
                    }
                });

                var anyRedRow = $("table#checkTable tbody tr").find('.getMaterialCode').filter(function() {
                    return $(this).css('color') === 'rgb(255, 0, 0)'; // Kiểm tra xem màu của chữ có phải là màu đỏ không
                }).length > 0;
                if (anyRedRow) {
                    notifiElement.show(); // Hiển thị thông báo nếu có ít nhất một dòng có chữ màu đỏ
                    divCheckOptionToDelete.hide();

                    $("#btnSaveCopyBoM").attr("disabled", "disabled"); // Vô hiệu hóa nút
                } else {
                    notifiElement.hide(); // Ẩn thông báo nếu không có dòng nào có chữ màu đỏ
                    divCheckOptionToDelete.show();

                    $("#btnSaveCopyBoM").removeAttr("disabled"); // Bật nút lại


                }
            });
        }

    });
    // sửa số lượng và tỉ lệ của 01 row trong bom
    $(document).ready(function() {
        $(document).on('click', '.btn-edit-bom', function() {
            var productId = $(this).data('bom-productid');
            var materialId = $(this).data('bom-materialid');
            var hiddenProductIdParrentEditBoM = $('[name="hiddenProductID"]').val(); // Lấy giá trị của hiddenProductID

            console.log(productId, materialId);
            $.ajax({
                url: '/bom-edit/modal/' + productId + '/' + materialId,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    $('#showCodeEdit').text(data.getMaterialEdit[0].code);
                    $('#showNameEdit').text(data.getMaterialEdit[0].name);
                    $('#showPhaseEdit').text(data.getMaterialEdit[0].phase);
                    $('#hiddenProductIdParrentEditBoM').val(hiddenProductIdParrentEditBoM);
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
    // add mới 01 row trong bom
    document.addEventListener('DOMContentLoaded', function() { // xem tất cả yêu cầu cấp thiết bị
        $(document).on('click', '.btn-add-bom', function() {
            var productId = $(this).data('product-id');
            $('#productByPhaseIDAdd').val(productId);
            var hiddenProductIdParrentAddBoM = $('[name="hiddenProductID"]').val(); // Lấy giá trị của hiddenProductID

            $.ajax({
                url: '/bom/modal/' + productId,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    $('#showCodeAdd').text(data.getProductToAdd[0].code);
                    $('#showIDAdd').val(data.getProductToAdd[0].id);
                    $('#showNameAdd').text(data.getProductToAdd[0].name);
                    $('#showPhaseAdd').text(data.getProductToAdd[0].phase);
                    $('#hiddenProductIdParrentAddBoM').val(hiddenProductIdParrentAddBoM);
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
</script>
