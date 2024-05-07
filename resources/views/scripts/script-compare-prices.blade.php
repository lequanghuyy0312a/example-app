<script>
    $(document).ready(function() {
        $('.select2-compare-prices-productIDSelectionToCompare').select2({});
        $('.select2-compare-prices-productIDSelectionToCompare').select2({});
    });

    function initializeSelect2(parentElement, selector) {
        $(parentElement).find(selector).select2({
            dropdownParent: parentElement
        });
    }


    var numList = 0;
    var debounceTimer;
    var selectedProductID;


    $(document).ready(function() {
        phaseIDSelected = $('#phaseIDSelectionToCompare').val(); // load dssp với phaseID mới nhất
        loadDropList(phaseIDSelected);
        $('#phaseIDSelectionToCompare').change(function() {
            loadDropList($(this).val());
            $('#comparePricesTable tbody').empty();

        });

        function loadDropList(phaseIDSelected) {
            // Gửi yêu cầu AJAX để lấy danh sách sản phẩm dựa trên phaseIDSelected
            $.ajax({
                url: '/load-droplist-view', // Đặt URL tương ứng với route của bạn
                type: 'GET',
                data: 'json',
                success: function(data) {
                    // Xóa tất cả các tùy chọn hiện có trong select productIDSelectionToCompare
                    $('#productIDSelectionToCompare').empty();
                    // Thêm một tùy chọn mặc định
                    $('#productIDSelectionToCompare').append('<option value="">...</option>');
                    num = 0;
                    // Lặp qua danh sách sản phẩm và thêm các tùy chọn vào select
                    $.each(data.getDropListProducts, function(index, product) {
                        if (product.product_PhaseID == phaseIDSelected) {
                            $('#productIDSelectionToCompare').append('<option value="' + product.product_id + '">' + (++num) + '/ ' + product.product_code + ' - ' + product.product_name + '</option>');
                        }
                    });
                },
                error: function(xhr, status, error) {
                    console.log('Error fetching product data:', error);
                }
            });
        }
    });

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
        loadFirstData(selectedProductID);
        // Lấy giá trị mặc định được gán từ HTML
        selectedProductID = $('#productIDSelectionToCompare').val(); // load dssp với phaseID mới nhất
        // Gọi hàm loadFirstData với giá trị mặc định
        loadFirstData(selectedProductID);
        $('#productIDSelectionToCompare').change(function() { // event thay đổi giá trị của PhaseID
            selectedProductID = $(this).val(); // gán giá trị PhaseID
            showLoading();
            loadFirstData(selectedProductID);
        });
        $(document).ajaxStop(function() {
            hideLoading();
        });


        /////////////////////// start - scroll ///////////////////////

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
        function loadFirstData(selectedProductID) { // load lần đầu
            $('#comparePricesTable tbody').empty();
            numList = 0;
            $.ajax({
                url: '/load-compare-prices',
                type: 'GET',
                data: {
                    productIDSelectionToCompare: selectedProductID, // Pass the selected phase ID
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
            var tableBody = $('#comparePricesTable tbody');
            $.each(data, function(index, compare) {
                var newRow = '<tr class="text-xs">' +
                    '<td class="text-center p-1"> <a class="btn text-primary  quotation-btn-info-to-compare" id="btn-info-' + compare.quotationID + '" data-quotation-id="' + compare.quotationID + '">' + (++numList) + '</a> </td>' +
                    '<td class="p-1">' + compare.partner_name + '</td>' +
                    '<td class="p-1">' + compare.orderCode + '</td>' +
                    '<td class="text-right p-1">' + compare.unitPrice + '</td>' +
                    '<td class="p-1">' + compare.description + '</td>' +
                    '<td class="p-1">' +
                    '<p class="py-0 my-0"><b>Delivery: </b>' + compare.delivery + ' </p>'+
                    '<p class="py-0 my-0"><b>Lead time: </b>' + compare.leadTime + ' </p>'+
                    '<p class="py-0 my-0"><b>Note: </b>' + compare.note + ' </p>'+
                    '<td class="p-1">' + compare.orderProductName + '</td>' +
                    '</td>' +
                '</tr>';
                tableBody.append(newRow);
            });
            $('#loadingIndicator').hide();
            $('#hiddenNumList').text(numList);
        }


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
    });




    ////////////////////////////////////////////////////////////////
    $(document).on('click', '.quotation-btn-info-to-compare', function() {
        console.log('compare');
        var quotationId = $(this).data('quotation-id');
            var selectedPhaseID; // Thêm dòng này để định nghĩa biến selectedPhaseID
            console.log('clicked: ' + quotationId);
            $.ajax({
                url: '/quotation/info-modal/' + quotationId,
                type: 'GET',
                dataType: 'json', // Specify the expected data type
                success: function(data) {
                    //header - left
                    $('#showPartnerName').text(data.getQuotationToInfo[0].partner_name);
                    $('#showPartnerAddress').text(data.getQuotationToInfo[0].partner_address);
                    $('#showPartnerContact').text(data.getQuotationToInfo[0].partner_phone);
                    //header - right
                    $('#showQuotationNo').text(data.getQuotationToInfo[0].quotationNo);
                    $('#showQuotationDate').text(data.getQuotationToInfo[0].quotationDate);
                    $('#showQuotationContact').text(data.getQuotationToInfo[0].contact);
                    $('#showReceivedFrom').text(data.getQuotationToInfo[0].receivedFrom);
                    $('#showSavedBy').text(data.getQuotationToInfo[0].savedBy);
                    //footer
                    $('#showDelivery').text(': ' + data.getQuotationToInfo[0].delivery);
                    $('#showLeadTime').text(': ' + data.getQuotationToInfo[0].leadTime);
                    $('#showPayment').text(': ' + data.getQuotationToInfo[0].payment);
                    $('#showExchangeRate').text(': ' + data.getQuotationToInfo[0].exchangeRate);
                    $('#showValidity').text(': ' + data.getQuotationToInfo[0].validityDate);

                    //table
                    numList = 0;
                    var tableBody = $('#quotationDetailTable tbody');
                    tableBody.empty(); // Clear previous rows before appending new ones
                    var subTotal = 0;
                    $.each(data.getQuotationDetailToInfo, function(index, detail) {

                        var newRow = '<tr>' +
                            '<td class="text-center p-1">' + (++numList) + '</td>' +
                            '<td class="p-1">' + detail.product_code + '</td>' +
                            '<td class=" p-1"> <b>' + detail.orderProductName + '</b></td>' +
                            '<td class="p-1">' + detail.orderCode + '</td>' +
                            '<td class="p-1">' + detail.description + '</td>' +
                            '<td class="text-center p-1">' + detail.unit + '</td>' +
                            '<td class="text-right p-1 email">' + formatNumber(detail.quantity) + '</td>' +
                            '<td class="text-right p-1 email">' + formatNumber(detail.unitPrice) + '</td>' +
                            '<td class="text-right p-1 email">' + formatNumber(detail.VAT) + '</td>' +
                            '</tr>';
                        tableBody.append(newRow);
                        var lineTotal = detail.quantity * detail.unitPrice * detail.VAT;
                        subTotal += lineTotal;
                    });
                    var lastRow = '<tr><td colspan="9"><u><b>Ghi chú:</u></b> ' + data.getQuotationToInfo[0].note + '</td></tr>';
                    tableBody.append(lastRow);

                    $('#showTotal').text(formatNumber(subTotal));

                    $('#infoModalCompare').modal('show');
                },
                error: function() {
                    console.log('Error fetching data.');
                }
            });
        });
        function formatNumber(number) {
            return new Intl.NumberFormat('en-US', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            }).format(number);
        }
</script>
