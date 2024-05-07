<script>
 

    $(document).ready(function() {
        var selectedPhaseID = $('#phaseID').val(); // Thêm dòng này để định nghĩa biến selectedPhaseID
        var selectedPartnerID = $('#selectedPartnerID').val();
        console.log('selectedPhaseID: ' + selectedPhaseID);
        console.log('selectedPartnerID: ' + selectedPartnerID);
        $.ajax({
            url: '/partner/jsoninfo/' + selectedPartnerID,
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                var partner = data.getPartner[0];
                if (partner) {
                    $('#showPartnerName').text(partner.name);
                    $('#showAddress').text(partner.address);
                    $('#showTax').text(partner.tax);
                    $('#showNote').text(partner.note);
                    var partnerType = (partner.type == 1 ? 'Khách hàng' : (partner.type == 2 ? 'Nhà cung cấp' : (partner.type == 12 ? 'Khách hàng & Nhà cung cấp' : 'Chưa xác định')));
                    $('#showType').text(partnerType);
                    $('#showNumQuotations').text(data.numQuotations);
                    $('#showNumPOs').text(data.numPOs);
                    $('#showNumProductsBuy').text(data.numProductsBuy);
                } else {
                    console.error('No partner data received.');
                }
            },
            error: function() {
                console.log('Error fetching data.');
            }
        });

        loadQuotationTable(selectedPhaseID, selectedPartnerID);
        loadPOTable(selectedPhaseID, selectedPartnerID);
        loadProductTable(selectedPhaseID, selectedPartnerID);

        $('#phaseID').change(function() { // event thay đổi giá trị của PhaseID
            console.log('changed');
            selectedPhaseID = $(this).val(); // gán giá trị PhaseID
            loadQuotationTable(selectedPhaseID, selectedPartnerID);
            loadPOTable(selectedPhaseID, selectedPartnerID);
            loadProductTable(selectedPhaseID, selectedPartnerID);

        });



    });


    var numList = 0;
    var debounceTimer;
    var selectedPhaseID;
    // $(document).ready(function() {
    //     function showLoading() {
    //         // Thêm spinner hoặc thông báo loading vào vị trí mong muốn
    //         $('#loadingIndicator').show(); // Ví dụ: #loadingIndicator là ID của spinner hoặc thông báo loading
    //     }

    //     // Function để ẩn hiệu ứng loading
    //     function hideLoading() {
    //         // Ẩn spinner hoặc thông báo loading
    //         $('#loadingIndicator').hide();
    //     }
    //     showLoading();
    //     loadQuotationTable(selectedPhaseID);
    //     // Lấy giá trị mặc định được gán từ HTML
    //     selectedPhaseID = $('#phaseID').val(); // load dssp với phaseID mới nhất
    //     // Gọi hàm loadQuotationTable với giá trị mặc định
    //     loadQuotationTable(selectedPhaseID);
    //     $('#phaseID').change(function() { // event thay đổi giá trị của PhaseID
    //         console.log('changed');
    //         selectedPhaseID = $(this).val(); // gán giá trị PhaseID
    //         showLoading();
    //         loadQuotationTable(selectedPhaseID);
    //     });
    //     $(document).ajaxStop(function() {
    //         hideLoading();
    //     });
    // });

    /////////////////////// start - quotation table ///////////////////////
    function loadQuotationTable(selectedPhaseID, selectedPartnerID) { // load lần đầu
        $('#detailPartnerQuotation tbody').empty();

        numList = 0;
        $.ajax({
            url: '/partner/jsonquotation/' + selectedPhaseID + '/' + selectedPartnerID,
            type: 'GET',
            data: {
                selectedPhaseID: selectedPhaseID,
                selectedPartnerID: selectedPartnerID,
            },
            success: function(response) {
                appendRowsQuotation(response.data);

            },
            error: function() {
                console.error('Error loading data.');
            }
        });
    }

    function appendRowsQuotation(data) {
        var tableBody = $('#detailPartnerQuotation tbody');
        var numQuotation = 0;
        $.each(data, function(index, quotation) {
            var newRow = '<tr>' +
                '<td class="p-1 text-center">' + (++numQuotation) + '</td>' +
                '<td class="p-1 email">' + quotation.quotationNo + '</td>' +
                '<td class="p-1 email">' + quotation.product_code + '</td>' +
                '<td class="p-1 email">' + quotation.orderCode + '</td>' +
                '<td class="p-1 email">' + quotation.orderProductName + '</td>' +
                '<td class="p-1 email text-center">' + quotation.unit + '</td>' +
                '<td class="p-1 email text-right">' + quotation.quantity + '</td>' +
                '<td class="p-1 email text-right">' + quotation.unitPrice + '</td>' +
                '<td class="p-1 email text-right">' + quotation.VAT + '</td>' +
                '<td class="p-1 email text-center">' + (quotation.approve == 0 ? '<b class="text-secondary"><i class="fa-regular fa-square"></i></b>' : '<b class="text-success"><i class="fa-regular fa-square-check"></i></b>') + '</td>' +
                '</tr>';
            tableBody.append(newRow);
        });
        $('#loadingIndicator').hide();
    }
    /////////////////////// start - quotation table ///////////////////////

    /////////////////////// start - po table ///////////////////////
    function loadPOTable(selectedPhaseID, selectedPartnerID) {
        $('#detailPartnerPO tbody').empty();
        numList = 0;
        $.ajax({
            url: '/partner/jsonpo/' + selectedPhaseID + '/' + selectedPartnerID,
            type: 'GET',
            data: {
                selectedPhaseID: selectedPhaseID,
                selectedPartnerID: selectedPartnerID,
            },
            success: function(response) {
                appendRowsPO(response.data);
            },
            error: function() {
                console.error('Error loading data.');
            }
        });
    }

    function appendRowsPO(data) {
        var tableBody = $('#detailPartnerPO tbody');
        var numPO = 0;
        $.each(data, function(index, po) {
            var newRow = '<tr>' +
                '<td class="p-1 text-center">' + (++numPO) + '</td>' +
                '<td class="p-1 email">' + po.product_code + '</td>' +
                '<td class="p-1 email text-center">' + po.unit + '</td>' +
                '<td class="p-1 email text-right">' + po.MOQ + '</td>' +
                '<td class="p-1 email text-right">' + po.unitPrice + '</td>' +
                '<td class="p-1 email">' + po.description + '</td>' +
                '<td class="p-1 email text-right">' + po.vat + '</td>' +
                '<td class="p-1 email">' + po.deliveryDate + '</td>' +
                '<td class="p-1 email">' + po.po_createdUTC + '</td>' +
                '<td class="p-1 email">' + po.note + '</td>' +
                '<td class="p-1 email text-center">' + (po.approve == 0 ? '<b class="text-secondary"><i class="fa-regular fa-square"></i></b>' :
                    (po.approve == 1 ? '<b class="text-success"><i class="fa-regular fa-square-check"></i> </b>' :
                        '<b class="text-primary"><i class="fa-solid fa-people-carry-box"></i></b>')) +
                '</td>' +
                '</tr>';
            tableBody.append(newRow);
        });
        $('#loadingIndicator').hide();
    }
    /////////////////////// start - po table ///////////////////////
    /////////////////////// start - product buy table ///////////////////////
    function loadProductTable(selectedPhaseID, selectedPartnerID)  {
        $('#detailPartnerProduct tbody').empty();

        numList = 0;
        $.ajax({
            url: '/partner/jsonproduct/' + selectedPhaseID + '/' + selectedPartnerID,
            type: 'GET',
            data: {
                selectedPhaseID: selectedPhaseID,
                selectedPartnerID: selectedPartnerID,
            },
            success: function(response) {
                appendRowsProduct(response.data);
            },
            error: function() {
                console.error('Error loading data.');
            }
        });
    }

    function appendRowsProduct(data) {
        var tableBody = $('#detailPartnerProduct tbody');
        var numProduct = 0;
        $.each(data, function(index, product) {
            var newRow = '<tr>' +
                '<td class="p-1 text-center">' + (++numProduct) + '</td>' +
                '<td class="p-1 email text-center">' + product.product_code + '</td>' +
                '<td class="p-1 email text-right text-success"> <b>' + product.importedPhase + '</b> </td>' +
                '<td class="p-1 email text-right text-danger"><b>' + product.exportedPhase + '</b></td>' +
                '<td class="p-1 email text-right text-success">' + product.beginningInventory + '</td>' +
                '<td class="p-1 email text-right text-danger">' + product.endingInventory + '</td>' +
                '<td class="p-1 email">' + product.orderCode + '</td>' +
                '<td class="p-1 email text-right">' + product.createdOnUTC + '</td>' +
                '</tr>';
            tableBody.append(newRow);
        });
        $('#loadingIndicator').hide();
    }
    /////////////////////// start - product buy table ///////////////////////

    function formatNumber(number) {
        return new Intl.NumberFormat('en-US', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        }).format(number);
    }
</script>
