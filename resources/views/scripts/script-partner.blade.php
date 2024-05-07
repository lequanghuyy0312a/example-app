<script>
    $(document).ready(function() {
        $('.select2-partner-typePartner').select2({});
    });

    function initializeSelect2(parentElement, selector) {
        $(parentElement).find(selector).select2({
            dropdownParent: parentElement
        });
    }
   
    ////////////////////////////////////////////////////////////////

    $(document).ready(function() {
        // Use event delegation to handle dynamically added elements
        $(document).on('click', '.partner-btn-edit', function() {
            var partnerId = $(this).data('partner-id');
            var formAction = "{{ route('partner-edit-submit', ':id') }}";
            formAction = formAction.replace(':id', partnerId);
            $('#editPartnerForm').attr('action', formAction);
            var selectedPhaseID; // Thêm dòng này để định nghĩa biến selectedPhaseID
            $.ajax({
                url: '/partner/modal/' + partnerId,
                type: 'GET',
                dataType: 'json', // Specify the expected data type
                success: function(data) {
                    $('#nameEdit').val(data.getPartnerToEdit[0].name);
                    $('#taxEdit').val(data.getPartnerToEdit[0].tax);
                    $('#addressEdit').val(data.getPartnerToEdit[0].address);
                    $('#emailEdit').val(data.getPartnerToEdit[0].email);
                    $('#phoneEdit').val(data.getPartnerToEdit[0].phone);
                    $('#typeEdit').val(data.getPartnerToEdit[0].type);
                    $('#noteEdit').val(data.getPartnerToEdit[0].note);

                    $('#typeEdit').empty();

                    var options = [
                        '<option value="1">1. {{__("msg.customer")}}</option>',
                        '<option value="2">2. {{__("msg.supplier")}}</option>',
                        '<option value="12">3. {{__("msg.customerSupplier")}}</option>'
                    ];

                    // Xác định giá trị cần chọn
                    var selectedValue = data.getPartnerToEdit[0].type;

                    // Tạo các option từ mảng và thêm thuộc tính selected khi cần
                    var selectHTML = '';
                    options.forEach(function(option, index) {
                        if (index + 1 === selectedValue) {
                            // Thêm thuộc tính selected vào option tương ứng
                            selectHTML += option.replace('<option', '<option selected');
                        } else {
                            selectHTML += option;
                        }
                    });

                    // Thêm options vào select
                    $('#typeEdit').html(selectHTML);

                    $('#editModalPartner').modal('show');
                },
                error: function() {
                    console.log('Error fetching data.');
                }
            });
        });
    });

    var offset = 30; // Initial offset
    var limit = 30; // Number of items to load each time
    var numList = 0;
    var debounceTimer;
    var typePartnerID;
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
        loadFirstData(typePartnerID);
        // Lấy giá trị mặc định được gán từ HTML
        typePartnerID = $('#typePartner').val(); // load dssp với phaseID mới nhất
        // Gọi hàm loadFirstData với giá trị mặc định
        loadFirstData(typePartnerID);
        $('#typePartner').change(function() { // event thay đổi giá trị của PhaseID
            typePartnerID = $(this).val(); // gán giá trị PhaseID
            if ($('#searchInput').val() == '') {
                showLoading();
                loadFirstData(typePartnerID);
            } else {
                // Gọi hàm filterTable và truyền giá trị typePartnerID vào
                showLoading();
                filterTable(typePartnerID);
            }
        });
        $(document).ajaxStop(function() {
            hideLoading();
        });

        /////////////////////// start - scroll ///////////////////////
        $(window).scroll(function() { // cuộn để hiển thị thêm dssp
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(function() {
                if ($(window).scrollTop() + $(window).height() >= $(document).height() - 50) {
                    loadMoreData(typePartnerID);
                }
            }, 100);
        });
        $(window).scroll(function() {
            if ($(this).scrollTop() > 100) {
                $('#backToTopBtn').fadeIn();
            } else {
                $('#backToTopBtn').fadeOut();
            }
        });
    });

    /////////////////////// start - search ///////////////////////
    $('#searchInput').keyup(function() { // chức năng tìm kiếm
        if ($('#searchInput').val() == '') {
            loadFirstData(typePartnerID);
        } else {
            // Gọi hàm filterTable và truyền giá trị typePartnerID vào
            filterTable(typePartnerID);
        }
    });

    function loadMoreData(typePartnerID) { // load khi cuộn
        $.ajax({
            url: '/load-more-partners',
            type: 'GET',
            data: {
                typePartner: typePartnerID,
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

    /////////////////////// start - load first ///////////////////////
    function loadFirstData(typePartnerID) { // load lần đầu
        $('#partnerTable tbody').empty();
        numList = 0;
        $.ajax({
            url: '/initial-load-partners',
            type: 'GET',
            data: {
                typePartner: typePartnerID, // Pass the selected phase ID
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
        var tableBody = $('#partnerTable tbody');
        $.each(data, function(index, partner) {
            var newRow = '<tr>' +
                '<td class="text-center p-0 text-xs"> <a class="btn btn-link p-0" href="/partner/' + partner.id + '"> ' + (++numList) + '</a> </td>' +
                '<td class="address p-1 pb-0 text-xs">' + partner.name + '</td>' +
                '<td class="email text-center p-1 pb-0 text-xs">' + (partner.type == 1 ? 'KH' : (partner.type == 2 ? 'NCC' : 'KH & NCC')) + '</td>' +
                '<td class="email p-1 pb-0 text-xs">' + partner.tax + '</td>' +
                '<td class="address p-1 pb-0 text-xs">' + partner.address + '</td>' +
                '<td class="email p-1 pb-0 text-xs">' + partner.email + '</td>' +
                '<td class="email p-1 pb-0 text-xs">' + partner.phone + '</td>' +
                '<td class="address p-1 pb-0 text-xs">' + partner.note + '</td>' +
                '<td class="project-actions text-center  p-0">' +
                '<div style="position: sticky; right:0px;" class="btn btn-group   p-1 pb-0 text-xs">' +
                '<a class="btn btn-link btn-sm  p-0 partner-btn-edit" id="btn-edit-' + partner.id + '" data-partner-id="' + partner.id + '">' +
                '<i class="fas fa-pencil-alt"></i>' +
                '</a>' +
                '<a class="btn btn-link btn-sm ml-2 p-0" type="submit" href="/partner/' + partner.id + '/delete" ' +
                'onclick="return confirm(\'Bạn chọn xoá đối tác: ' + numList + '\')">' +
                '<i class="fas fa-trash"></i>' +
                '</a>' +
                '</div>' +
                '</td>' +
                '</tr>';
            tableBody.append(newRow);
        });
        $('#loadingIndicator').hide();
        $('#hiddenNumList').text(numList);
    }
    /////////////////////// start - append rows ///////////////////////



    function filterTable(typePartnerID) { // gọi JS
        var search = $('#searchInput').val();

        // Gửi yêu cầu AJAX đến điểm cuối tìm kiếm trên máy chủ
        $.ajax({
            url: '/search-partners',
            type: 'GET',
            data: {
                typePartner: typePartnerID,
                search: search
            },
            success: function(response) {
                updateTable(response.data);
            },
            error: function() {
                console.error('Error searching partners.');

            }
        });
    }

    function updateTable(data) { // load data sau khi search ra table

        $('#partnerTable tbody').empty();
        var numList = parseInt($('#hiddenNumList').text());
        if (isNaN(numList)) {
            numList = 0;
        }
        $.each(data, function(index, partner) {
            var newRow = '<tr>' +
                '<td class="text-center p-1 pb-0  text-xs"> <a class="btn btn-link p-0" href="/partner/' + partner.id + '"> ' + (++numList) + '</a> </td>' +
                '<td class="address p-0 text-xs">' + partner.name + '</td>' +
                '<td class="email text-center p-1 pb-0 text-xs">' + (partner.type == 1 ? 'KH' : (partner.type == 2 ? 'NCC' : 'KH & NCC')) + '</td>' +
                '<td class="email p-1 pb-0 text-xs">' + partner.tax + '</td>' +
                '<td class="address p-1 pb-0 text-xs">' + partner.address + '</td>' +
                '<td class="email p-1 pb-0 text-xs">' + partner.email + '</td>' +
                '<td class="email p-1 pb-0 text-xs">' + partner.phone + '</td>' +
                '<td class="address p-1 pb-0 text-xs">' + partner.note + '</td>' +
                '<td class="project-actions text-center  p-0">' +
                '<div style="position: sticky; right:0px;" class="btn btn-group   p-1 pb-0 text-xs">' +
                '<a class="btn btn-link btn-sm  p-0 partner-btn-edit" id="btn-edit-' + partner.id + '" data-partner-id="' + partner.id + '">' +
                '<i class="fas fa-pencil-alt"></i>' +
                '</a>' +
                '<a class="btn btn-link btn-sm ml-2 p-0" type="submit" href="/partner/' + partner.id + '/delete" ' +
                'onclick="return confirm(\'Bạn chọn xoá đối tác: ' + numList + '\')">' +
                '<i class="fas fa-trash"></i>' +
                '</a>' +
                '</div>' +
                '</td>' +
                '</tr>';
            $('#partnerTable tbody').append(newRow);
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
</script>
