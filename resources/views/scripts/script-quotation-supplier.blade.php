<script>
    $(document).ready(function() {
        $('.select2-quotation-phaseIDSelectionToQuotation').select2({});
        initializeSelect2('#addModalQuotation', '.select2');

        $(window).scroll(function() {
            if ($(this).scrollTop() > 100) {
                $('#backToTopBtn').fadeIn();
            } else {
                $('#backToTopBtn').fadeOut();
            }
        });

        showLoading();
        // Lấy giá trị mặc định được gán từ HTML
        selectedPhaseID = $('#phaseIDSelectionToQuotation').val(); // load dssp với phaseID mới nhất
        // Gọi hàm loadFirstData với giá trị mặc định
        loadFirstData(selectedPhaseID);

    });

    function initializeSelect2(parentElement, selector) {
        $(parentElement).find(selector).select2({
            dropdownParent: parentElement
        });
    }

    ////////////////////////////////////////////////////////////////
    // EDIT
    $(document).on('click', '.quotation-btn-edit', function() {
        var quotationId = $(this).data('quotation-id');
        var formAction = "{{ route('quotation-edit-submit', ':id') }}";
        formAction = formAction.replace(':id', quotationId);
        $('#editQuotationForm').attr('action', formAction);
        var selectedPhaseID; // Thêm dòng này để định nghĩa biến selectedPhaseID
        $.ajax({
            url: '/quotation/modal-edit/' + quotationId,
            type: 'GET',
            dataType: 'json', // Specify the expected data type
            success: function(data) {
                $('#quotationNoEdit').val(data.getQuotationToEdit[0].quotationNo);
                $('#quotationDateEdit').val(data.getQuotationToEdit[0].quotationDate);
                $('#validityDateEdit').val(data.getQuotationToEdit[0].validityDate);
                $('#partnerIDEdit').val(data.getQuotationToEdit[0].partnerID);

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

                $('#editModalQuotation').modal('show');
            },
            error: function() {
                console.log('Error fetching data.');
            }
        });
    });

    // event thay đổi giá trị của PhaseID
    $('#phaseIDSelectionToQuotation').change(function() {
        console.log('changed');
        selectedPhaseID = $(this).val(); // gán giá trị PhaseID
        if ($('#searchInput').val() == '') {
            console.log('first');
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

    // ADD
    $(document).on('click', '.quotation-btn-add', function() {
        var phaseIDSelected = $('#phaseIDSelectionToQuotation').val();
        $.ajax({
            url: '/showmodal/quotation-add',
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                var numPartner = 0;
                var numProduct = 0;
                $('#partnerIDQuotationAdd').empty();

                $.each(data.getDropListPartners, function(index, partner) {
                    var option = $('<option>', {
                        value: partner.id,
                        text: (++numPartner) + '/ ' + partner.name
                    });
                    $('#partnerIDQuotationAdd').append(option);
                });
                $.each(data.getDropListProducts, function(index, product) {
                    if (product.phaseID == phaseIDSelected) {
                        var option = $('<option>', {
                            value: product.id,
                            text: (++numProduct) + '/ ' + product.code
                        });
                        $('#productIDAdd').append(option);
                    }
                });


                $('#hiddenPhaseID').val(phaseIDSelected);

                $('#addModalQuotation').modal('show');
            },
            error: function(xhr, status, error) {
                console.log('Error fetching product details data for add:', error);
            }
        });
    });
    // ADD row detail
    AddRowButton();
    // Xử lý sự kiện khi click nút remove
    $("#dynamicRowsContainerQuotation").on("click", ".btn-remove-row", function() {
        $(this).closest(".dynamic-row-quotation").remove();

    });
    // INFO
    $(document).on('click', '.quotation-btn-info', function() {
        var quotationId = $(this).data('quotation-id');
        var selectedPhaseID; // Thêm dòng này để định nghĩa biến selectedPhaseID
        $('.btn-approve-info').removeAttr('data-quotation-id');
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
                $('#hiddenSelectedQuotationID').val(quotationId);

                //table
                numList = 0;
                var tableBody = $('#quotationDetailTable tbody');
                tableBody.empty(); // Clear previous rows before appending new ones
                var subTotal = 0;
                $.each(data.getQuotationDetailToInfo, function(index, detail) {

                    var newRow = '<tr>' +
                        '<td class="text-center p-1">' + (++numList) + '</td>' +
                        '<td class="p-1 email">' + detail.product_code + '</td>' +
                        '<td class=" p-1  address"> <b>' + detail.orderProductName + '</b></td>' +
                        '<td class="p-1  email">' + detail.orderCode + '</td>' +
                        '<td class="p-1  email">' + detail.description + '</td>' +
                        '<td class="text-center email p-1">' + detail.unit + '</td>' +
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
                $('#infoModalQuotation').modal('show');
            },
            error: function() {
                console.log('Error fetching data.');
            }
        });
    });
    // APPROVE
    $(document).on('click', '#btnApprove', function() {
        var quotationId = $('#hiddenSelectedQuotationID').val();
        console.log('quotationId: ' + quotationId);
        $.ajax({
            url: '/quotation/approve/' + quotationId, // URL without quotationId
            type: 'GET',
            dataType: 'json',
            data: {
                id: quotationId // Pass quotationId as data in the request
            },
            success: function(response) {
                $('#infoModalQuotation').modal('hide');
                $('#success-alert').text(response.message).show();
                loadFirstData(selectedPhaseID);
            },
            error: function(xhr, status, error) {
                // Handle error
                console.error("Error approving quotation:", error);
            }
        });
    });
    //DELETE
    $(document).on('click', '#btnDelete', function() {
        var quotationId = $(this).data('quotation-id');
        console.log('quotationId: ' + quotationId);
        $.ajax({
            url: '/quotation/' + quotationId + '/delete', // URL without quotationId
            type: 'GET',
            dataType: 'json',
            data: {
                id: quotationId // Pass quotationId as data in the request
            },
            success: function(response) {
                $('#success-alert').text(response.message).show();
                loadFirstData(selectedPhaseID);
            },
            error: function(xhr, status, error) {
                // Handle error
                console.error("Error approving quotation:", error);
            }
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

    function showLoading() {
        // Thêm spinner hoặc thông báo loading vào vị trí mong muốn
        $('#loadingIndicator').show(); // Ví dụ: #loadingIndicator là ID của spinner hoặc thông báo loading
    }

    // Function để ẩn hiệu ứng loading
    function hideLoading() {
        // Ẩn spinner hoặc thông báo loading
        $('#loadingIndicator').hide();
    }

    function AddRowButton() {
        $("#addRowBtnQuotation").click(function() {
            console.log("hi");
            var newRow = $(".dynamic-row-quotation:first").clone();

            // Generate a unique ID for the new select element
            var newSelectId = "select2-" + $(".dynamic-row-quotation").length;

            // Assign the new ID to the select element in the cloned row
            newRow.find("select").attr("id", newSelectId);

            // Remove the disabled attribute for all cloned rows except the first one
            if ($(".dynamic-row-quotation").length > 0) {
                newRow.find("select").removeAttr("hidden");
                newRow.find("input").removeAttr("hidden");
                newRow.find("a").removeAttr("hidden");
            }

            $("#dynamicRowsContainerQuotation").append(newRow);

            // Khởi tạo Select2 cho dropdown mới
            $("#" + newSelectId).select2({
                theme: 'bootstrap4',
                placeholder: '...',
                dropdownParent: '#addModalQuotation' // tạo select cho form add new
            });
        });
    }

    function formatNumber(number) {
        return new Intl.NumberFormat('en-US', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        }).format(number);
    }

    function loadMoreData(selectedPhaseID) { // load khi cuộn
        $.ajax({
            url: '/load-more-quotations',
            type: 'GET',
            data: {
                phaseIDSelectionToQuotation: selectedPhaseID,
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

    function scrollToTop() { // Smooth scroll to top
        $('html, body').animate({
            scrollTop: 0
        }, 'slow');
    }
    /////////////////////// end - scroll ///////////////////////
    var offset = 20; // Initial offset
    var limit = 20; // Number of items to load each time
    var numList = 0;
    var debounceTimer;
    var selectedPhaseID;
    /////////////////////// start - load first ///////////////////////
    function loadFirstData(selectedPhaseID) { // load lần đầu
        $('#quotationTable tbody').empty();
        numList = 0;
        $.ajax({
            url: '/initial-load-quotations',
            type: 'GET',
            data: {
                phaseIDSelectionToQuotation: selectedPhaseID, // Pass the selected phase ID
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
        var tableBody = $('#quotationTable tbody');
        $.each(data, function(index, quotation) {
            var newRow = '<tr>' +
                '<td class="text-center p-1">' + (++numList) + '</a> </td>' +
                '<td class="p-1">' + quotation.phase_name + '</td>' +
                '<td class="email p-1">' + quotation.partner_name + '</td>' +
                '<td class="email p-1">' + quotation.quotationNo + '</td>' +
                '<td class="address  text-right p-1">' + quotation.quotationDate + '</td>' +
                '<td class="email p-1">' + quotation.validityDate + '</td>' +
                '<td class="email text-right p-1">' + quotation.createdOnUTC.substr(0, 16) + '</td>' +
                '<td class="address p-1 text-center">' + (quotation.approve == 0 ? '<b class="text-secondary">{{ __("msg.pending") }}</b>' : '<b class="text-success"> {{ __("msg.accepted") }} </b>') + '</td>' +
                '<td class="address p-1">' + quotation.note + '</td>' +
                '<td class="project-actions text-center  p-0">' +
                '<div style="position: sticky; right:0px;" class="btn btn-group p-0 ">' +
                '<a class="btn btn-link btn-sm mx-1  text-info  px-0 quotation-btn-info" id="btn-info-' + quotation.id + '" data-quotation-id="' + quotation.id + '">' +
                '<i class="fa-solid fa-eye"></i>' +
                '</a>' +
                '<a class="btn btn-link btn-sm  text-warning  px-0 quotation-btn-edit" id="btn-edit-' + quotation.id + '" data-quotation-id="' + quotation.id + '">' +
                '<i class="fas fa-pencil-alt"></i>' +
                '</a>' +
                '<a class="btn btn-link btn-sm mx-1 px-0" id="btnDelete" id="btn-edit-' + quotation.id + '" data-quotation-id="' + quotation.id + '" onclick="return confirm(\'Bạn chọn xoá đối tác: ' + numList + '\')">' +
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
        console.log('search: ' + search);
        console.log('selectedPhaseID: ' + selectedPhaseID);

        // Gửi yêu cầu AJAX đến điểm cuối tìm kiếm trên máy chủ
        $.ajax({
            url: '/search-quotations',
            type: 'GET',
            data: {
                phaseIDSelectionToQuotation: selectedPhaseID,
                search: search
            },
            success: function(response) {
                updateTable(response.data);
                console.error('data ok');
                console.error('data ok: ' + response.data);

            },
            error: function(response) {
                console.error('Error searching quotations.');
            }
        });
    }

    function updateTable(data) { // load data sau khi search ra table
        $('#quotationTable tbody').empty();
        var numList = parseInt($('#hiddenNumList').text());
        if (isNaN(numList)) {
            numList = 0;
        }

        $.each(data, function(index, quotation) {
            var newRow = '<tr>' +
                '<td class="text-center p-1">' + (++numList) + '</a> </td>' +
                '<td class="p-1">' + quotation.phase_name + '</td>' +
                '<td class="email p-1">' + quotation.partner_name + '</td>' +
                '<td class="email p-1">' + quotation.quotationNo + '</td>' +
                '<td class="address  text-right p-1">' + quotation.quotationDate + '</td>' +
                '<td class="email p-1">' + quotation.validityDate + '</td>' +
                '<td class="email text-right p-1">' + quotation.createdOnUTC.substr(0, 16) + '</td>' +
                '<td class="address p-1 text-center">' + (quotation.approve == 0 ? '<b class="text-secondary">{{ __("msg.pending") }}</b>' : '<b class="text-success"> {{ __("msg.accepted") }} </b>') + '</td>' +
                '<td class="address p-1">' + quotation.note + '</td>' +
                '<td class="project-actions text-center  p-0">' +
                '<div style="position: sticky; right:0px;" class="btn btn-group p-0 ">' +
                '<a class="btn btn-link btn-sm mx-1  text-info  px-0 quotation-btn-info" id="btn-info-' + quotation.id + '" data-quotation-id="' + quotation.id + '">' +
                '<i class="fa-solid fa-eye"></i>' +
                '</a>' +
                '<a class="btn btn-link btn-sm  text-warning  px-0 quotation-btn-edit" id="btn-edit-' + quotation.id + '" data-quotation-id="' + quotation.id + '">' +
                '<i class="fas fa-pencil-alt"></i>' +
                '</a>' +
                '<a class="btn btn-link btn-sm mx-1 px-0" type="submit" onclick="return confirm(\'Bạn chọn xoá đối tác: ' + numList + '\')">' +
                '<i class="fas fa-trash"></i>' +
                '</a>' +
                '</div>' +
                '</td>' +
                '</tr>';
            $('#quotationTable tbody').append(newRow);
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
