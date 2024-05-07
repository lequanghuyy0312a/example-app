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

    ////////////////////////////////////////////////////////////////

    $(document).ready(function() {
        //add
        $(document).on('click', '.purchase-order-btn-add', function() {
            var phaseIDSelected = $('#phaseIDSelectionToPurchaseOrder').val();
            $.ajax({
                url: '/showmodal/purchase-order-add',
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    var numPartner = 0;
                    $('#partnerIDPurchaseOrderAdd').empty();
                    $('#partnerIDPurchaseOrderAdd').append('<option value="0" disabled selected> ... </option>');

                    $.each(data.getDropListPartners, function(index, partner) {
                        var option = $('<option>', {
                            value: partner.id,
                            text: (++numPartner) + '/ ' + partner.name
                        });
                        $('#partnerIDPurchaseOrderAdd').append(option);
                    });

                    $('#hiddenPhaseID').val(phaseIDSelected);
                    $('#addModalPurchaseOrder').modal('show');
                },
                error: function(xhr, status, error) {
                    console.log('Error fetching product details data for add:', error);
                }
            });
        });

        $('#partnerIDPurchaseOrderAdd').change(function() {
            var selectedPartnerID = $(this).val();
            var phaseIDSelected = $('#phaseIDSelectionToPurchaseOrder').val();
            $.ajax({
                url: '/purchase-order-add/get-info',
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    // Giữ lại hàng gốc

                    $('#productIDPOAdd').empty();

                    $('#productIDPOAdd').append('<option value="0" disabled selected> ... </option>');

                    var numProduct = 0;
                    $.each(data.getDropListProducts, function(index, product) {
                        if (product.phaseID == phaseIDSelected && product.partnerID == selectedPartnerID) {
                            var option = $('<option>', {
                                value: product.id,
                                text: (++numProduct) + '/ ' + product.code
                            });
                            $('#productIDPOAdd').append(option);
                        }
                    });

                    var originalRow = $('.dynamic-row-purchase-order:first').clone();

                    // Xóa các hàng cũ trừ hàng gốc
                    $('.dynamicrow-purchase-order:not(:first)').remove();


                    if (data.getQuotationToAddPO && data.getQuotationToAddPO.length > 0) {
                        var newRowPromises = [];
                        data.getQuotationToAddPO.forEach(function(rowData) {
                            // Kiểm tra quotationID
                            if (rowData.partnerID == selectedPartnerID && rowData.phaseID == $('#phaseIDSelectionToPurchaseOrder').val()) {
                                // Sao chép hàng gốc và thêm vào container
                                var newRow = originalRow.clone();
                                var newSelectId = "select2-" + $(".dynamic-row-purchase-order").length;
                                // Assign the new ID to the select element in the cloned row
                                newRow.find("select").attr("id", newSelectId);
                                // Remove the disabled attribute for all cloned rows except the first one
                                if ($(".dynamic-row-purchase-order").length > 0) {
                                    newRow.find("select").removeAttr("hidden");
                                    newRow.find("input").removeAttr("hidden");
                                    newRow.find("a").removeAttr("hidden");
                                }
                                $("#dynamicRowsContainerPurchaseOrder").append(newRow);
                                // Khởi tạo Select2 cho dropdown mới
                                $("#" + newSelectId).select2({
                                    theme: 'bootstrap4',
                                    dropdownParent: '#addModalPurchaseOrder' // tạo select cho form add new
                                });
                                // Cập nhật giá trị cho hàng mới
                                if (rowData.product_id) { // Kiểm tra xem có giá trị product_id hay không
                                    newRow.find("#" + newSelectId).val(rowData.product_id).trigger('change');
                                }

                                newRow.find('#orderProductNameAdd').val(rowData.orderProductName);
                                newRow.find('#purchaseOrderCodeAdd').val(rowData.orderCode);
                                newRow.find('#descriptionAdd').val(rowData.description);
                                newRow.find('#unitAdd').val(rowData.unit);
                                newRow.find('#quantityAdd').val(rowData.quantity);
                                newRow.find('#unitPriceAdd').val(rowData.unitPrice);
                                newRow.find('#VATAdd').val(rowData.VAT);
                                newRow.find('#deliveryDateAdd').val(rowData.deliveryDate);
                                newRow.find('#descriptionAdd').val(rowData.description);
                                // Thêm hàng mới vào container


                                $('#dynamicRowsContainerPurchaseOrder').append(newRow);
                            }
                        });


                        // Chờ tất cả các select2 được tạo hoàn thành trước khi hiển thị modal
                        Promise.all(newRowPromises).then(function() {
                            // Hiển thị modal sau khi đã thêm xong các hàng
                            $('#addModalPurchaseOrder').modal('show');
                        });
                    } else {
                        console.log('No data received or empty data array.');
                    }
                },
                error: function(xhr, status, error) {
                    console.log('Error fetching product details data for add:', error);
                }
            });
        });




        $(document).ready(function() {
            $("#addRowBtnPurchaseOrder").click(function() {
                AddRowButton();

            });

            $("#dynamicRowsContainerPurchaseOrder").on("click", ".btn-remove-row", function() {
                $(this).closest(".dynamic-row-purchase-order").remove();
            });


        });



        function AddRowButton() {
            var newRow = $(".dynamic-row-purchase-order:first").clone();
            // Generate a unique ID for the new select element
            var newSelectId = "select2-" + $(".dynamic-row-purchase-order").length;
            // Assign the new ID to the select element in the cloned row
            newRow.find("select").attr("id", newSelectId);
            // Remove the disabled attribute for all cloned rows except the first one
            if ($(".dynamic-row-purchase-order").length > 0) {
                newRow.find("select").removeAttr("hidden");
                newRow.find("input").removeAttr("hidden");
                newRow.find("a").removeAttr("hidden");
            }
            $("#dynamicRowsContainerPurchaseOrder").append(newRow);
            // Khởi tạo Select2 cho dropdown mới
            $("#" + newSelectId).select2({
                theme: 'bootstrap4',
                placeholder: '...',
                dropdownParent: '#addModalPurchaseOrder' // tạo select cho form add new
            });
        }
        // $(document).ready(function() {
        //     $('.select2').select2({
        //         dropdownParent: '#addModalPurchaseOrder' // tạo select cho form add new
        //     });
        // });
        //edit
        $(document).on('click', '.purchase-order-btn-edit', function() {
            var purchaseOrderId = $(this).data('purchase-order-id');
            var formAction = "{{ route('purchase-order-edit-submit', ':id') }}";
            formAction = formAction.replace(':id', purchaseOrderId);
            $('#editPurchaseOrderForm').attr('action', formAction);
            var selectedPhaseID; // Thêm dòng này để định nghĩa biến selectedPhaseID
            $.ajax({
                url: '/purchase-order/modal-edit/' + purchaseOrderId,
                type: 'GET',
                dataType: 'json', // Specify the expected data type
                success: function(data) {
                    $('#purchaseOrderNoEdit').val(data.getPurchaseOrderToEdit[0].purchaseOrderNo);
                    $('#purchaseOrderDateEdit').val(data.getPurchaseOrderToEdit[0].purchaseOrderDate);
                    $('#validityDateEdit').val(data.getPurchaseOrderToEdit[0].validityDate);
                    $('#partnerIDEdit').val(data.getPurchaseOrderToEdit[0].partnerID);
                    $('#productIDEdit').empty();
                    $('#partnerIDEdit').empty();

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

                    $('#editModalPurchaseOrder').modal('show');
                },
                error: function() {
                    console.log('Error fetching data.');
                }
            });
        });
    });
    //info
    $(document).ready(function() {


        // Use event delegation to handle dynamically added elements
        // Hàm để hiển thị thông tin đơn hàng mua
        function showPurchaseOrderInfo(purchaseOrderId) {
            $.ajax({
                url: '/purchase-order/info-modal/' + purchaseOrderId,
                type: 'GET',
                dataType: 'json', // Specify the expected data type
                success: function(data) {
                    //header - left
                    $('#showPartnerName').text(data.getPurchaseOrderToInfo[0].partner_name);
                    $('#showPartnerAddress').text(data.getPurchaseOrderToInfo[0].partner_address);
                    $('#showPartnerContact').text(data.getPurchaseOrderToInfo[0].partner_phone);
                    $('#showATTN').text(data.getPurchaseOrderToInfo[0].ATTN);
                    //header - right
                    $('#showPurchaseOrderNo').text(data.getPurchaseOrderToInfo[0].purchaseOrderNo);
                    $('#showPOOnUTC').text(data.getPurchaseOrderToInfo[0].POOnUTC);
                    $('#showPurchaseOrderContact').text(data.getPurchaseOrderToInfo[0].contact);
                    $('#showCurrency').text(data.getPurchaseOrderToInfo[0].currency);
                    $('#showRate').text(data.getPurchaseOrderToInfo[0].rate);
                    //footer
                    $('#showNote').text(data.getPurchaseOrderToInfo[0].note);

                    //table
                    numList = 0;
                    var tableBody = $('#purchaseOrderDetailTable tbody');
                    tableBody.empty(); // Clear previous rows before appending new ones
                    var subTotal = 0;
                    var totalAmount = 0;

                    $.each(data.getPurchaseOrderDetailToInfo, function(index, detail) {
                        subTotal = (detail.MOQ * detail.unitPrice) + ((detail.MOQ * detail.unitPrice * detail.vat) / 100);
                        var newRow = '<tr>' +
                            '<td class="text-center p-1">' + (++numList) + '</td>' +
                            '<td class="p-1 email">' + detail.product_code + '</td>' +
                            '<td class="p-1 email">' + detail.orderCode + '</td>' +
                            '<td class="p-1"> <b>' + detail.product_name + '</b></td>' +
                            '<td class="text-center p-1 email">' + detail.unit + '</td>' +
                            '<td class="text-right p-1 email">' + formatNumber(detail.unitPrice) + '</td>' +
                            '<td class="text-right p-1 email">' + formatNumber(detail.MOQ) + '</td>' +
                            '<td class="text-right p-1 email">' + formatNumber(detail.vat) + '</td>' +
                            '<td class="text-right p-1 email">' + formatNumber(subTotal) + '</td>' +
                            '<td class="text-center p-1 email">' + detail.deliveryDate + '</td>' +
                            '<td class="text-center p-1 email">' + detail.note + '</td>' +
                            '</tr>';
                        tableBody.append(newRow);
                        totalAmount += subTotal;
                    });
                    var lastRow = '<tr>' +
                        '<td colspan="10" class="text-right"><u><b>Total:</u></b> </td>' +
                        '<td colspan="2" class="bg-success"> <a id="showTotal" class="text-sm ml-2"></a></td> </tr>';
                    tableBody.append(lastRow);
                    // tính giá
                    $('#showTotal').text(formatNumber(totalAmount));


                    $('#infoModalPurchaseOrder').modal('show');
                },
                error: function() {
                    console.log('Error fetching data.');
                }
            });
        }

        // Xử lý sự kiện click cho purchase-order-btn-info
        $(document).on('click', '.purchase-order-btn-info', function() {
            var purchaseOrderId = $(this).data('purchase-order-id');
            showPurchaseOrderInfo(purchaseOrderId);
            var printLink = '/print-PO/' + purchaseOrderId;
            $('#printPO').attr('href', printLink);
        });


        function formatNumber(number) {
            return new Intl.NumberFormat('en-US', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            }).format(number);
        }



    });

    var offset = 20; // Initial offset
    var limit = 20; // Number of items to load each time
    var numList = 0;
    var debounceTimer;
    var selectedPhaseID;
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
        loadFirstData(selectedPhaseID);
        // Lấy giá trị mặc định được gán từ HTML
        selectedPhaseID = $('#phaseIDSelectionToPurchaseOrder').val(); // load dssp với phaseID mới nhất
        // Gọi hàm loadFirstData với giá trị mặc định
        loadFirstData(selectedPhaseID);
        $('#phaseIDSelectionToPurchaseOrder').change(function() { // event thay đổi giá trị của PhaseID
            selectedPhaseID = $(this).val(); // gán giá trị PhaseID
            if ($('#searchInput').val() == '') {
                showLoading();
                loadFirstData(selectedPhaseID);
            } else {
                // Gọi hàm filterTable và truyền giá trị selectedPhaseID vào
                showLoading();
                filterTable(selectedPhaseID);
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
                loadMoreData(selectedPhaseID);
            }
        }, 100);
    });

    function loadMoreData(selectedPhaseID) { // load khi cuộn
        $.ajax({
            url: '/load-more-purchase-orders',
            type: 'GET',
            data: {
                phaseIDSelectionToPurchaseOrder: selectedPhaseID,
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
    function loadFirstData(selectedPhaseID) { // load lần đầu
        $('#purchaseOrderTable tbody').empty();
        numList = 0;
        $.ajax({
            url: '/initial-load-purchase-orders',
            type: 'GET',
            data: {
                phaseIDSelectionToPurchaseOrder: selectedPhaseID, // Pass the selected phase ID
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
        var tableBody = $('#purchaseOrderTable tbody');
        $.each(data, function(index, purchaseOrder) {
            var newRow = '<tr>' +
                '<td class="text-center p-1">' + (++numList) + '</a> </td>' +
                '<td class="address p-1"> <a class="btn btn-link p-0" href="/po-process/'+ purchaseOrder.id+'" >' + purchaseOrder.purchaseOrderNo + '</a> </td>' +
                '<td class="address  p-1">' + purchaseOrder.POOnUTC + '</td>' +
                '<td class="address p-1 text-right">' + purchaseOrder.currency + '</td>' +
                '<td class="address p-1 ">' + purchaseOrder.partner_name + '</td>' +
                '<td class="address p-1 text-center ">' + (purchaseOrder.approve == 0 ? '<b class="text-secondary">{{ __("msg.pending") }}</b>' :
                    (purchaseOrder.approve == 1 ? '<b class="text-success"> {{ __("msg.accepted") }}</b>' : '<b class="text-primary">{{ __("msg.received") }}</b>')) + '</td>' +
                '<td class="address  p-1">' + (purchaseOrder.acceptedBy == null ? '' : purchaseOrder.acceptedBy) + '</td>' +
                '<td class="address  p-1 text-right">' + (purchaseOrder.acceptedOnUTC == null ? '' : purchaseOrder.acceptedOnUTC.substr(0, 16)) + '</td>' +
                '<td class="address  p-1 text-center ">' + purchaseOrder.createdBy + '</td>' +
                '<td class="address  p-1">' + purchaseOrder.note + '</td>' +
                '<td class="project-actions text-center  p-0">' +
                '<div style="position: sticky; right:0px;" class="btn btn-group p-0">' +
                '<a class="btn btn-link btn-sm p-1 text-info  px-0 purchase-order-btn-info" id="btn-info-' + purchaseOrder.id + '" data-purchase-order-id="' + purchaseOrder.id + '">' +
                '<i class="fa-solid fa-eye"></i>' +
                '</a>' +
                '<a class="btn btn-link btn-sm mx-1  p-1 text-warning  px-0  mx-0 purchase-order-btn-edit" id="btn-edit-' + purchaseOrder.id + '" data-purchase-order-id="' + purchaseOrder.id + '">' +
                '<i class="fas fa-pencil-alt"></i>' +
                '</a>' +
                '<a class="btn btn-link btn-sm  px-0 mx-0 p-1" type="submit" href="/purchase-order/' + purchaseOrder.id + '/delete" ' +
                'onclick="return confirm(\'Bạn chọn xoá đối tác: ' + numList + '\')">' +
                '<i class="fas fa-trash"></i>' +
                '</a>' +
                '</div>' +
                '</td>' +
                '</tr>';
            tableBody.append(newRow);
        });
        $('#loadingIndicator').hide();
    }
    /////////////////////// start - append rows ///////////////////////

    /////////////////////// start - search ///////////////////////
    $('#searchInput').keyup(function() { // chức năng tìm kiếm
        if ($('#searchInput').val() == '') {
            loadFirstData(selectedPhaseID);
        } else {
            // Gọi hàm filterTable và truyền giá trị selectedPhaseID vào
            filterTable(selectedPhaseID);
        }
    });


    function filterTable(selectedPhaseID) { // gọi JS
        var search = $('#searchInput').val();
        // Gửi yêu cầu AJAX đến điểm cuối tìm kiếm trên máy chủ
        $.ajax({
            url: '/search-purchase-orders',
            type: 'GET',
            data: {
                phaseIDSelectionToPurchaseOrder: selectedPhaseID,
                search: search
            },
            success: function(response) {
                updateTable(response.data);
            },
            error: function(response) {
                console.error('Error searching purchaseOrders.');
            }
        });
    }

    function updateTable(data) { // load data sau khi search ra table
        $('#purchaseOrderTable tbody').empty();
        var numList = parseInt($('#hiddenNumList').text());
        if (isNaN(numList)) {
            numList = 0;
        }

        $.each(data, function(index, purchaseOrder) {
            var newRow = '<tr>' +
                '<td class="text-center p-1">' + (++numList) + '</a> </td>' +
                '<td class="address p-1"> <a class="btn btn-link p-0" href="/po-process/'+ purchaseOrder.id+'" >' + purchaseOrder.purchaseOrderNo + '</a> </td>' +
                '<td class="address  p-1">' + purchaseOrder.POOnUTC + '</td>' +
                '<td class="address p-1 text-right">' + purchaseOrder.currency + '</td>' +
                '<td class="address p-1 ">' + purchaseOrder.partner_name + '</td>' +
                '<td class="address p-1 text-center ">' + (purchaseOrder.approve == 0 ? '<b class="text-secondary">{{ __("msg.pending") }}</b>' :
                    (purchaseOrder.approve == 1 ? '<b class="text-success"> {{ __("msg.accepted") }}</b>' : '<b class="text-primary">{{ __("msg.received") }}</b>')) + '</td>' +
                '<td class="address  p-1">' + (purchaseOrder.acceptedBy == null ? '' : purchaseOrder.acceptedBy) + '</td>' +
                '<td class="address  p-1 text-right">' + (purchaseOrder.acceptedOnUTC == null ? '' : purchaseOrder.acceptedOnUTC.substr(0, 16)) + '</td>' +
                '<td class="address  p-1 text-center ">' + purchaseOrder.createdBy + '</td>' +
                '<td class="address  p-1">' + purchaseOrder.note + '</td>' +
                '<td class="project-actions text-center  p-0">' +
                '<div style="position: sticky; right:0px;" class="btn btn-group p-0">' +
                '<a class="btn btn-link btn-sm p-1 text-info  px-0 purchase-order-btn-info" id="btn-info-' + purchaseOrder.id + '" data-purchase-order-id="' + purchaseOrder.id + '">' +
                '<i class="fa-solid fa-eye"></i>' +
                '</a>' +
                '<a class="btn btn-link btn-sm mx-1  p-1 text-warning  px-0  mx-0 purchase-order-btn-edit" id="btn-edit-' + purchaseOrder.id + '" data-purchase-order-id="' + purchaseOrder.id + '">' +
                '<i class="fas fa-pencil-alt"></i>' +
                '</a>' +
                '<a class="btn btn-link btn-sm  px-0 mx-0 p-1" type="submit" href="/purchase-order/' + purchaseOrder.id + '/delete" ' +
                'onclick="return confirm(\'Bạn chọn xoá đối tác: ' + numList + '\')">' +
                '<i class="fas fa-trash"></i>' +
                '</a>' +
                '</div>' +
                '</td>' +
                '</tr>';
            $('#purchaseOrderTable tbody').append(newRow);
        });
        $('#hiddenNumList').text(numList);

    }
    /////////////////////// end - search ///////////////////////


    function formatNumber(number) {
        return new Intl.NumberFormat('en-US', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        }).format(number);
    }

    // price input
    function formatInput(input) {
        // Lấy giá trị từ trường input
        var value = input.value;
        // Xóa các ký tự không phải là số (nếu có)
        var newValue = value.replace(/\D/g, '');
        // Định dạng giá trị theo dạng XXX.XXX.XXX
        newValue = newValue.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        // Gán giá trị đã định dạng lại cho trường input
        input.value = newValue;
    }
</script>
