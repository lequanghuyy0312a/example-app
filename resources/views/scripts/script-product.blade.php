<script>
    $(document).ready(function() {
        initializeSelect2('#InsertForm', '.select2');
        initializeSelect2('#RemoveForm', '.select2');
        $('.select2-product-category').select2({});
        $('.select2-product-type').select2({});
        $('.select2-products-phase').select2({});
        $('.select2-product-group').select2({});
        $('.select2-product-phase').select2({});
        $('.select2-product-warehouse').select2({});
        $('.select2-warehouse').select2({});
        $('.select2-process-export').select2({});
        $('.select2-process-import').select2({});
        $('.select2-product-insert-current').select2({});
        $('.select2-product-insert-selection').select2({});
    });

    function initializeSelect2(parentElement, selector) {
        $(parentElement).find(selector).select2({
            dropdownParent: parentElement
        });
    }

    ////////////////////////////////////////////////////////////////

    $(document).ready(function() {
        // Use event delegation to handle dynamically added elements
        $(document).on('click', '.product-btn-edit', function() {
            var productId = $(this).data('product-id');
            var formAction = "{{ route('product-edit-submit', ':id') }}";
            formAction = formAction.replace(':id', productId);
            $('#editProductForm').attr('action', formAction);
            var selectedPhaseID; // Thêm dòng này để định nghĩa biến selectedPhaseID
            $.ajax({
                url: '/product/modal/' + productId,
                type: 'GET',
                dataType: 'json', // Specify the expected data type
                success: function(data) {
                    $('#codeEdit').val(data.getProductToEdit[0].code);
                    $('#nameEdit').val(data.getProductToEdit[0].name);
                    $('#sellingPriceEdit').val(data.getProductToEdit[0].sellingPrice);
                    $('#costPriceEdit').val(data.getProductToEdit[0].costPrice);
                    $('#orderCodeEdit').val(data.getProductToEdit[0].orderCode);
                    $('#unitEdit').val(data.getProductToEdit[0].unit);
                    $('#idEditHidden').val(productId);

                    $('#phaseIDEdit').empty();
                    $('#categoryIDEdit').empty();
                    $('#typeIDEdit').empty();
                    $('#groupIDEdit').empty();
                    $('#warehouseIDEdit').empty();

                    // phase
                    $.each(data.getDropListPhases, function(index, phase) {
                        var option = $('<option>', {
                            value: phase.id,
                            text: (++index) + '. ' + phase.name
                        });
                        if (phase.id == data.getProductToEdit[0].phaseID) {
                            option.prop('selected', true);
                        }
                        $('#phaseIDEdit').append(option);
                    });
                    // category
                    if (!data.getProductToEdit[0].categoryID) {
                        $('#categoryIDEdit').append('<option value="0" selected>Không thuộc Chủng </option>');
                    } else {
                        $('#categoryIDEdit').append('<option value="0" >Không thuộc Chủng </option>');
                    }
                    $.each(data.getDropListCategories, function(index, category) {
                        var option = $('<option>', {
                            value: category.id,
                            text: (++index) + '. ' + category.name
                        });
                        if (category.id == data.getProductToEdit[0].categoryID) {
                            option.prop('selected', true);
                        }
                        $('#categoryIDEdit').append(option);
                    });
                    // type
                    if (!data.getProductToEdit[0].typeID) {
                        $('#typeIDEdit').append('<option value="0" selected>Không thuộc Loại </option>');
                    } else {
                        $('#typeIDEdit').append('<option value="0">Không thuộc Loại </option>');

                    }
                    $.each(data.getDropListTypes, function(index, type) {
                        var option = $('<option>', {
                            value: type.id,
                            text: (++index) + '. ' + type.name
                        });
                        if (type.id == data.getProductToEdit[0].typeID) {
                            option.prop('selected', true);
                        }
                        $('#typeIDEdit').append(option);
                    });
                    // group
                    if (!data.getProductToEdit[0].groupID) {
                        $('#groupIDEdit').append('<option value="0" selected>Không thuộc Nhóm </option>');
                    } else {
                        $('#groupIDEdit').append('<option value="0" >Không thuộc Nhóm </option>');
                    }
                    $.each(data.getDropListGroups, function(index, group) {
                        var option = $('<option>', {
                            value: group.id,
                            text: (++index) + '. ' + group.name
                        });
                        if (group.id == data.getProductToEdit[0].groupID) {
                            option.prop('selected', true);
                        }
                        $('#groupIDEdit').append(option);
                    });
                    // warehouse
                    $.each(data.getDropListWarehouses, function(index, warehouse) {
                        var option = $('<option>', {
                            value: warehouse.id,
                            text: (++index) + '. ' + warehouse.name
                        });
                        if (warehouse.id == data.getProductToEdit[0].warehouseID) {
                            option.prop('selected', true);
                        }
                        $('#warehouseIDEdit').append(option);
                    });

                    // Open the modal
                    $('#editModalProduct').modal('show');
                },
                error: function() {
                    console.log('Error fetching data.');
                }
            });
        });



    });
</script>
<script>
    var offset = 50; // Initial offset
    var limit = 50; // Number of items to load each time
    var numList = 0;
    var debounceTimer;
    var phaseIDSelected;
    $(document).ready(function() {
        function showLoading() {
            // Thêm spinner hoặc thông báo loading vào vị trí mong muốn
            $('#loadingIndicator').show(); // Ví dụ: #loadingIndicator là ID của spinner hoặc thông báo loading
        }

        // Function để ẩn hiệu ứng loading
        function hideLoading() {
            // Ẩn spinner hoặc thông báo loading
            $('#loadingIndicator').hide();
        }
        showLoading();

        // Lấy giá trị mặc định được gán từ HTML
        phaseIDSelected = $('#phaseIDSelectionToList').val(); // load dssp với phaseID mới nhất
        // Gọi hàm loadFirstData với giá trị mặc định
        loadFirstData(phaseIDSelected);
        $('#phaseIDSelectionToList').change(function() { // event thay đổi giá trị của PhaseID
            console.log('changed');
            phaseIDSelected = $(this).val(); // gán giá trị PhaseID
            if ($('#searchInput').val() == '') {
                showLoading();

                loadFirstData(phaseIDSelected);
            } else {
                showLoading();

                // Gọi hàm filterTable và truyền giá trị phaseIDSelected vào
                filterTable(phaseIDSelected);
            }
        });
        $(document).ajaxStop(function() {
            hideLoading();
        });
    });

    /////////////////////// start - scroll ///////////////////////
    $(window).scroll(function() { // cuộn để hiển thị thêm dssp
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(function() {
            if ($(window).scrollTop() + $(window).height() >= $(document).height() - 50) {
                loadMoreData(phaseIDSelected);
            }
        }, 100);
    });

    function loadMoreData(phaseIDSelected) { // load khi cuộn
        $.ajax({
            url: '/load-more-products',
            type: 'GET',
            data: {
                phaseIDSelectionToList: phaseIDSelected,
                offset: offset,
                limit: limit
            },
            success: function(response) {
                appendRows(response.data)
                offset += limit;
            },
            error: function() {
                console.error('Error loading data.');
            }
        });
    }
    $(document).ready(function() { // back to top
        $(window).scroll(function() {
            if ($(this).scrollTop() > 100) {
                $('#backToTopBtn').fadeIn();
            } else {
                $('#backToTopBtn').fadeOut();
            }
        });
    });

    function scrollToTop() { // Smooth scroll to top
        $('html, body').animate({
            scrollTop: 0
        }, 'slow');
    }
    /////////////////////// end - scroll ///////////////////////

    /////////////////////// start - load first ///////////////////////
    function loadFirstData(phaseIDSelected) { // load lần đầu
        $('#productTable tbody').empty();
        numList = 0;
        $.ajax({
            url: '/initial-load-products',
            type: 'GET',
            data: {
                phaseIDSelectionToList: phaseIDSelected, // Pass the selected phase ID
                offset: offset,
                limit: limit
            },
            success: function(response) {
                if (response.data.length > 0) {
                    appendRows(response.data);
                }
            },
            error: function() {
                console.error('Error loading data.');
            }
        });
    }
    /////////////////////// end - load first ///////////////////////

    /////////////////////// start - append rows ///////////////////////
    function appendRows(data) {
        console.log('load ok');
        var tableBody = $('#productTable tbody');
        $.each(data, function(index, product) {
            var newRow = '<tr>' +
            '<td class="text-center p-1 text-xs"><a href="/bill-of-material/' + product.id + '">' + (++numList) + '</a> </td>' +
                '<td class="address p-1 text-xs">' + product.thuocky + '</td>' +
                '<td class="address p-1 text-xs">' + product.thuocchung + '</td>' +
                '<td class="address p-1 text-xs">' + product.thuocloai + '</td>' +
                '<td class="address p-1 text-xs">' + product.thuocnhom + '</td>' +
                '<td class="address p-1 text-xs">' + product.code + '</td>' +
                '<td class="address p-1 text-xs">' + product.name + '</td>' +
                '<td class=" p-1 text-xs">' + product.unit + '</td>' +
                '<td class="address p-1 text-xs">' + product.thuockhonhapve + '</td>' +
                '<td class="project-actions text-center  p-0">' +
                '<div style="position: sticky; right:0px;" class="btn btn-group  p-1">' +
                '<a class="btn btn-link btn-sm  p-0 product-btn-edit" id="btn-edit-' + product.id + '" data-product-id="' + product.id + '">' +
                '<i class="fas fa-pencil-alt"></i>' +
                '</a>' +
                '<a class="btn btn-link btn-sm ml-2  p-0" type="submit" href="/product/' + product.id + '/delete" ' +
                'onclick="return confirm(\'Bạn chọn xoá sản phẩm số: ' + numList + '\')">' +
                '<i class="fas fa-trash"></i>' +
                '</a>' +
                '</div>' +
                '</td>' +
                '</tr>';
            tableBody.append(newRow);
        });
        $('#hiddenNumList').text(numList);
    }
    /////////////////////// start - append rows ///////////////////////

    /////////////////////// start - search ///////////////////////
    $('#searchInput').keyup(function() { // chức năng tìm kiếm
        if ($('#searchInput').val() == '') {
            loadFirstData(phaseIDSelected);
        } else {
            // Gọi hàm filterTable và truyền giá trị phaseIDSelected vào
            filterTable(phaseIDSelected);
        }
    });


    function filterTable(phaseIDSelected) { // gọi JS
        var search = $('#searchInput').val();
        console.log('search: ' + search);

        // Gửi yêu cầu AJAX đến điểm cuối tìm kiếm trên máy chủ
        $.ajax({
            url: '/search-products',
            type: 'GET',
            data: {
                phaseIDSelectionToList: phaseIDSelected,
                search: search
            },
            success: function(response) {
                updateTable(response.data);
            },
            error: function() {
                console.error('Error searching products.');
            }
        });
    }

    function updateTable(data) { // load data sau khi search ra table
        $('#productTable tbody').empty();
        var numList = parseInt($('#hiddenNumList').text());
        if (isNaN(numList)) {
            numList = 0;
        }
        $.each(data, function(index, product) {
            var newRow = '<tr>' +
            '<td class="text-center p-1 text-xs"><a href="/bill-of-material/' + product.id + '">' + (++numList) + '</a> </td>' +
                '<td class="address p-1 text-xs">' + product.thuocky + '</td>' +
                '<td class="address p-1 text-xs">' + product.thuocchung + '</td>' +
                '<td class="address p-1 text-xs">' + product.thuocloai + '</td>' +
                '<td class="address p-1 text-xs">' + product.thuocnhom + '</td>' +
                '<td class="address p-1 text-xs">' + product.code + '</td>' +
                '<td class="address p-1 text-xs">' + product.name + '</td>' +
                '<td class=" p-1 text-xs">' + product.unit + '</td>' +
                '<td class="address p-1 text-xs">' + product.thuockhonhapve + '</td>' +
                '<td class="project-actions text-center  p-0">' +
                '<div style="position: sticky; right:0px;" class="btn btn-group  p-1">' +
                '<a class="btn btn-link btn-sm  p-0 product-btn-edit" id="btn-edit-' + product.id + '" data-product-id="' + product.id + '">' +
                '<i class="fas fa-pencil-alt"></i>' +
                '</a>' +
                '<a class="btn btn-link btn-sm ml-2  p-0" type="submit" href="/product/' + product.id + '/delete" ' +
                'onclick="return confirm(\'Bạn chọn xoá sản phẩm số: ' + numList + '\')">' +
                '<i class="fas fa-trash"></i>' +
                '</a>' +
                '</div>' +
                '</td>' +
                '</tr>';
            $('#productTable tbody').append(newRow);
        });
        $('#hiddenNumList').text(numList);

    }
    /////////////////////// end - search ///////////////////////
</script>

<script>
    $(document).ready(function() {
        // Prevent click event propagation from child elements
        $('.expandable-trigger').click(function(event) {
            event.stopPropagation();
            // Toggle your expandable-table here
            // Example: $('#parentRow').expandableTable('toggle');
        });

        // Prevent click event propagation for delete button
        $(document).on('click', '.addBtn-trigger', function(event) {
            event.stopPropagation();
        });
        $(document).on('click', '.deleteBtn-trigger', function(event) {
            event.preventDefault();
            event.stopPropagation();
        });
        $(document).on('click', '.updateBtn-trigger', function(event) {
            event.stopPropagation();
        });
        $("#printButton").click(function() {
            console.log("Button clicked!");
            calculateGrandTotal();
        });
    });
    document.addEventListener("DOMContentLoaded", function() {
        var parentRows = document.querySelectorAll('.parent-row');
        parentRows.forEach(function(parentRow) {
            var totalQuantityElement = parentRow.querySelector('.total-quantity');
            var totalAmountElement = parentRow.querySelector('.total-amount'); // Add this line
            var costPriceProduct = parentRow.querySelector('.costPriceProduct'); // Add this line

            var childRows = parentRow.nextElementSibling.querySelectorAll('.child-row');

            var totalQuantity = 0;
            var totalAmount = 0; // Add this line

            childRows.forEach(function(childRow) {
                var quantityElement = childRow.querySelector('.countQuantity');
                var amountElement = childRow.querySelector('.totalAmount'); // Add this line

                if (quantityElement) {
                    totalQuantity += parseFloat(quantityElement.textContent.trim());
                }
                if (amountElement) {
                    // Assuming the amount is a numeric value; adjust as needed
                    totalAmount += parseFloat(amountElement.textContent.trim());
                }

            });
            if (totalAmount == 0) {
                totalAmount = parseFloat(costPriceProduct.textContent.trim());
            }

            totalQuantityElement.textContent = (totalQuantity);
            totalAmountElement.textContent = formatNumber(totalAmount); // Display the total amount
            function formatNumber(number) {
                return new Intl.NumberFormat('en-US', {
                    minimumFractionDigits: 0,
                    maximumFractionDigits: 2
                }).format(number);
            }
        });
        /// tính chi phí


        var initialQuantity = parseInt(document.querySelector('.updateQuantity').textContent, 10);

        function updateQuantity(inputField) {
            var currentNumber = parseInt(document.getElementById('quantity-field').value, 10);
            var quantityElement = document.querySelector('.updateQuantity');
            var tempValue = currentNumber * initialQuantity;
            // quantityElement.textContent = tempValue;
            updateGrandTotal();
        }

        $('.input-group').on('click', '.button-plus', function(e) {
            incrementValue(e);
            updateQuantity($(this));
        });

        $('.input-group').on('click', '.button-minus', function(e) {
            decrementValue(e);
            updateQuantity($(this));
        });
        $('.input-group').on('input', '.quantity-field', function(e) {
            var inputValue = $(this).val();
            if (inputValue === '' || isNaN(inputValue)) {
                $(this).val(1);
            }
            updateQuantity($(this));
        });


        function incrementValue(e) { // tăng số lượng
            e.preventDefault();
            var fieldName = $(e.target).data('field');
            var parent = $(e.target).closest('div');
            var inputField = parent.find('input[name=' + fieldName + ']');
            var currentVal = parseInt(inputField.val(), 10);

            if (!isNaN(currentVal)) {
                inputField.val(currentVal + 1);
            }
        }

        function decrementValue(e) { // giảm số lượng
            e.preventDefault();
            var fieldName = $(e.target).data('field');
            var parent = $(e.target).closest('div');
            var inputField = parent.find('input[name=' + fieldName + ']');
            var currentVal = parseInt(inputField.val(), 10);

            if (!isNaN(currentVal) && currentVal > 0) {
                inputField.val(currentVal - 1);
            }
        }
        updateGrandTotal();

        function updateGrandTotal() {
            var totalAmountElements = document.querySelectorAll('.totalBoMList, .totalBoMListChild');
            var grandTotalElement = document.getElementById('grandTotalBomList');
            var currentNumber = parseInt(document.getElementById('quantity-field').value, 10);
            var grandTotal = 0;

            totalAmountElements.forEach(function(totalAmountElement) {
                var value = parseFloat(totalAmountElement.textContent.replace(',', ''));
                if (!isNaN(value)) {
                    grandTotal += value;
                }
            });
            grandTotalElement.textContent = formatNumber(grandTotal * currentNumber);
        }

        function formatNumber(number) {
            return new Intl.NumberFormat('en-US', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            }).format(number);
        }
    });
</script>
