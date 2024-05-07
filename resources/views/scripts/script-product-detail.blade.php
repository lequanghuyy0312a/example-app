<script>
    $(document).ready(function() {
        initializeSelect2('#InsertForm', '.select2');
        initializeSelect2('#RemoveForm', '.select2');
        $('.select2-product-details-product').select2({});
        $('.select2-product-details-partner').select2({});
    });

    function initializeSelect2(parentElement, selector) {
        $(parentElement).find(selector).select2({
            dropdownParent: parentElement
        });
    }

    ////////////////////////////////////////////////////////////////

    $(document).ready(function() {

        // Use event delegation to handle dynamically added elements
        $(document).on('click', '.product-details-btn-edit', function() {
            var productDetailId = $(this).data('product-detail-id');
            var formAction = "{{ route('product-details-edit-submit', ':id') }}";
            formAction = formAction.replace(':id', productDetailId);
            $('#editProductDetailForm').attr('action', formAction);
            var phaseIDSelected = $('#phaseIDSelectionToProductList').val();
            $.ajax({
                url: '/product-details/modal-edit/' + productDetailId,
                type: 'GET',
                dataType: 'json', // Specify the expected data type
                success: function(data) {

                    $('#exportedPhaseEdit').val(data.getProductDetailToEdit[0].exportedPhase);
                    $('#importedPhaseEdit').val(data.getProductDetailToEdit[0].importedPhase);
                    $('#beginningInventoryEdit').val(data.getProductDetailToEdit[0].beginningInventory);
                    $('#endingInventoryEdit').val(data.getProductDetailToEdit[0].endingInventory);
                    $('#orderCodeEdit').val(data.getProductDetailToEdit[0].orderCode);
                    $('#idEditHidden').val(productDetailId);
                    $('#partnerIDProductEdit').empty();
                    var numPartner = 0;

                    $.each(data.getDropListPartners, function(index, partner) {
                        var option = $('<option>', {
                            value: partner.id,
                            text: (++numPartner) + '/ ' + partner.name
                        });
                        if (partner.id == data.getProductDetailToEdit[0].partnerID) {
                            option.prop('selected', true);
                        }
                        $('#partnerIDProductEdit').append(option);
                    });


                    $('#productIDByPhaseEdit').empty();
                    var numProduct = 0;
                    $.each(data.getDropListProducts, function(index, product) {
                        if (product.phaseID == phaseIDSelected) {
                            var option = $('<option>', {
                                value: product.id,
                                text: (++numProduct) + '/ ' + product.name
                            });
                            if (product.id == data.getProductDetailToEdit[0].productID) {
                                option.prop('selected', true);
                            }
                            $('#productIDByPhaseEdit').append(option);
                        }
                    });

                    // Open the modal
                    $('#editModalProductDetail').modal('show');

                },
                error: function() {
                    console.log('Error fetching product details data.');
                }
            });
        });
        $(document).on('click', '#product-details-btn-add', function() {
            var phaseIDSelected = $('#phaseIDSelectionToProductList').val();
            console.log('phaseIDSelected :' + phaseIDSelected);
            $.ajax({
                url: '/showmodal-product-details',
                type: 'GET',
                dataType: 'json',
                success: function(data) {

                    var numPartner = 0;
                    $.each(data.getDropListPartners, function(index, partner) {
                        var option = $('<option>', {
                            value: partner.id,
                            text: (++numPartner) + '/ ' + partner.name
                        });
                        $('#partnerIDProductAdd').append(option);
                    });

                    var numProduct = 0;
                    $.each(data.getDropListProducts, function(index, product) {
                        if (product.phaseID == phaseIDSelected) {
                            var option = $('<option>', {
                                value: product.id,
                                text: (++numProduct) + '/ ' + product.name
                            });
                            $('#productIDByPhaseAdd').append(option);
                        }
                    });
                    $('#addModalProductDetail').modal('show');

                },
                error: function(xhr, status, error) {
                    console.log('Error fetching product details data for add:', error);
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
        // Lấy giá trị mặc định được gán từ HTML
        phaseIDSelected = $('#phaseIDSelectionToProductList').val(); // load dssp với phaseID mới nhất
        // Gọi hàm loadFirstData với giá trị mặc định
        loadFirstData(phaseIDSelected);
        $('#phaseIDSelectionToProductList').change(function() { // event thay đổi giá trị của PhaseID
            console.log('changed');
            phaseIDSelected = $(this).val(); // gán giá trị PhaseID
            if ($('#searchProduct').val() == '') {
                loadFirstData(phaseIDSelected);
            } else {
                // Gọi hàm filterTable và truyền giá trị phaseIDSelected vào
                filterTable(phaseIDSelected);
            }
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
            url: '/load-more-product-details',
            type: 'GET',
            data: {
                phaseIDSelectionToProductList: phaseIDSelected,
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
        $('#productDetailTable tbody').empty();

        numList = 0;
        $.ajax({
            url: '/initial-load-product-details',
            type: 'GET',
            data: {
                phaseIDSelectionToProductList: phaseIDSelected, // Pass the selected phase ID
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
        var tableBody = $('#productDetailTable tbody');
        $.each(data, function(index, productDetail) {
            var newRow = '<tr>' +
                '<td class="text-center p-1 text-xs "><a href="/bill-of-material/' + productDetail.productID + '">' + (++numList) + '</a> </td>' +
                '<td class="address p-1 text-xs  text-center">' + productDetail.phase_name + '</td>' +
                '<td class="address p-1 text-xs">' + productDetail.product_code + '</td>' +
                '<td class="address p-1 text-xs text-right text-success"> <b>' + productDetail.importedPhase + '</b></td>' +
                '<td class="address p-1 text-xs text-right text-danger"><b>' + productDetail.exportedPhase + '</b></td>' +
                '<td class="address p-1 text-xs text-right">' + productDetail.beginningInventory + '</td>' +
                '<td class="address p-1 text-xs text-right">' + productDetail.endingInventory + '</td>' +
                '<td class="address p-1 text-xs">' + productDetail.orderCode + '</td>' +
                '<td class="address p-1 text-xs">' + productDetail.partner_name + '</td>' +
                '<td class="address p-1 text-xs  text-right">' + productDetail.createdOnUTC.substr(0, 16) + '</td>' +
                '<td class="project-actions text-center  p-0">' +
                '<div style="position: sticky; right:0px;" class="btn btn-group p-1">' +
                '<a  class="btn btn-link btn-sm p-0 disabled product-details-btn-edit" id="btn-edit-' + productDetail.id + '" data-product-detail-id="' + productDetail.id + '">' +
                '<i class="fas fa-pencil-alt"></i>' +
                '</a>' +
                '<a class="btn btn-link btn-sm p-0 ml-2" type="submit" href="/product-detail/' + productDetail.id + '/delete" ' +
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
    $('#searchProduct').keyup(function() { // chức năng tìm kiếm
        if ($('#searchProduct').val() == '') {
            loadFirstData(phaseIDSelected);
        } else {
            // Gọi hàm filterTable và truyền giá trị phaseIDSelected vào
            filterTable(phaseIDSelected);
        }
    });


    function filterTable(phaseIDSelected) { // gọi JS
        var search = $('#searchProduct').val();
        // Gửi yêu cầu AJAX đến điểm cuối tìm kiếm trên máy chủ
        $.ajax({
            url: '/search-product-details',
            type: 'GET',
            data: {
                phaseIDSelectionToProductList: phaseIDSelected,
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
        $('#productDetailTable tbody').empty();
        var numList = parseInt($('#hiddenNumList').text());
        if (isNaN(numList)) {
            numList = 0;
        }
        $.each(data, function(index, productDetail) {
            var newRow = '<tr>' +
                '<td class="text-center p-1 text-xs "><a href="/bill-of-material/' + productDetail.productID + '">' + (++numList) + '</a> </td>' +
                '<td class="address p-1 text-xs  text-center">' + productDetail.phase_name + '</td>' +
                '<td class="address p-1 text-xs">' + productDetail.product_code + '</td>' +
                '<td class="address p-1 text-xs text-right text-success"> <b>' + productDetail.importedPhase + '</b></td>' +
                '<td class="address p-1 text-xs text-right text-danger"><b>' + productDetail.exportedPhase + '</b></td>' +
                '<td class="address p-1 text-xs text-right">' + productDetail.beginningInventory + '</td>' +
                '<td class="address p-1 text-xs text-right">' + productDetail.endingInventory + '</td>' +
                '<td class="address p-1 text-xs">' + productDetail.orderCode + '</td>' +
                '<td class="address p-1 text-xs">' + productDetail.partner_name + '</td>' +
                '<td class="address p-1 text-xs  text-right">' + productDetail.createdOnUTC.substr(0, 16) + '</td>' +
                '<td class="project-actions text-center  p-0">' +
                '<div style="position: sticky; right:0px;" class="btn btn-group p-1">' +
                '<a  class="btn btn-link btn-sm p-0 disabled product-details-btn-edit" id="btn-edit-' + productDetail.id + '" data-product-detail-id="' + productDetail.id + '">' +
                '<i class="fas fa-pencil-alt"></i>' +
                '</a>' +
                '<a class="btn btn-link btn-sm p-0 ml-2" type="submit" href="/product-detail/' + productDetail.id + '/delete" ' +
                'onclick="return confirm(\'Bạn chọn xoá sản phẩm số: ' + numList + '\')">' +
                '<i class="fas fa-trash"></i>' +
                '</a>' +
                '</div>' +
                '</td>' +
                '</tr>';
            $('#productDetailTable tbody').append(newRow);
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

    function formatNumber(number) {
        return new Intl.NumberFormat('en-US', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        }).format(number);
    }
</script>
