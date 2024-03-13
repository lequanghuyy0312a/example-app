<!-- start - check domain name -->

<script>
    setTimeout(function() {
        document.getElementById('viewLunchReservation').classList.add('section', 'delayed');
    }, 500); // Adjust the delay in milliseconds
    function changeLanguage(locale) {
        var currentUrl = window.location.href;

        // Remove trailing slashes if present
        currentUrl = currentUrl.replace(/\/+$/, '');

        // Match the language segment at the start of the URL
        var match = currentUrl.match(/^(http:\/\/[a-z0-9.:-]+)\/(en|vi|ja)/);
        // var match = currentUrl.match(/^(https?:\/\/[a-z.:-]+)\/(en|vi|ja)/i);

        if (match) {
            var baseUrl = match[1];
            var newUrl = baseUrl + '/' + locale + currentUrl.substring(match[0].length);
            window.location.href = newUrl;
        } else {
            // If no language segment is present, add it
            var newUrl = currentUrl + '/' + locale;
            window.location.href = newUrl;
        }
    }
</script>
<!-- start - check domain name -->

<!-- start - tạo table -->
<script>
    $(document).ready(function() {
        console.log('Script is running');
        $(".open-position-modal").click(function() {
            var jobId = $(this).data("jobid");
            $("#updatePosition" + jobId).modal("show");
        });

        $(".open-info-modal").click(function() {
            var jobId = $(this).data("jobid");
            $("#updateInfoJobEmployee" + jobId).modal("show");
        });
    });

    $(function() {

        $("#categoryTable").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "paging": true,
            "buttons": ["copy", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#categoryTable_wrapper .col-md-6:eq(0)');

        $("#typeTable").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "paging": true,
            "buttons": ["copy", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#typeTable_wrapper .col-md-6:eq(0)');

        $("#groupTable").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "paging": true,
            "buttons": ["copy", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#groupTable_wrapper .col-md-6:eq(0)');

        $("#phaseTable").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "paging": true,
            "buttons": ["copy", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#phaseTable_wrapper .col-md-6:eq(0)');

        $("#processTable").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "paging": true,
            "buttons": ["copy", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#processTable_wrapper .col-md-6:eq(0)');

        // $("#productTable").DataTable({
        //     "responsive": true,
        //     "lengthChange": false,
        //     "autoWidth": false,
        //     "paging": false,
        //     "buttons": ["copy", "excel", "pdf", "print", "colvis"]
        // }).buttons().container().appendTo('#productTable_wrapper .col-md-6:eq(0)');


        $("#productByPhaseTable").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "paging": true,
            "buttons": ["copy", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#productByPhaseTable_wrapper .col-md-6:eq(0)');

        $("#warehouseTable").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "paging": true,
            "buttons": ["copy", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#warehouseTable_wrapper .col-md-6:eq(0)');

        $("#BoMTable").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "paging": true,
            "buttons": ["copy", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#BoMTable_wrapper .col-md-6:eq(0)');


    });
    // <!-- end - tạo table -->

    // start - task quản lý vật tư - supply
    document.addEventListener('DOMContentLoaded', function() { // xem tất cả yêu cầu cấp thiết bị
        const showAllCheckbox = document.getElementById('customSwitchDeviceRequirement');
        const itemList = document.getElementById('itemList');

        showAllCheckbox.addEventListener('change', function() {
            const statusDevice1Items = itemList.querySelectorAll('.statusDevice-1');
            const statusDevice0Items = itemList.querySelectorAll('.statusDevice-0');
            if (this.checked) {
                statusDevice1Items.forEach(item => {
                    item.style.display = '';
                });
                statusDevice0Items.forEach(item => {
                    item.style.display = '';
                });
            } else {
                statusDevice1Items.forEach(item => {
                    item.style.display = 'none';
                });
                statusDevice0Items.forEach(item => {
                    item.style.display = '';
                });
            }
        });


    });

    document.addEventListener('DOMContentLoaded', function() { // xem tất cả yêu cầu cấp vật tư
        const showAllCheckbox = document.getElementById('customSwitchSupplyRequirement');
        const itemList = document.getElementById('itemList');

        showAllCheckbox.addEventListener('change', function() {
            const status1Items = itemList.querySelectorAll('.status-1');
            const status0Items = itemList.querySelectorAll('.status-0');

            if (this.checked) {
                status1Items.forEach(item => {
                    item.style.display = '';
                });
                status0Items.forEach(item => {
                    item.style.display = 'none';
                });
            } else {
                status1Items.forEach(item => {
                    item.style.display = 'none';
                });
                status0Items.forEach(item => {
                    item.style.display = '';
                });
            }
        });
    });


    $(function() {
        $(document).on('click', '[data-toggle="lightbox"]', function(event) {
            event.preventDefault();
            $(this).ekkoLightbox({
                alwaysShowClose: true
            });
        });

        $('.filter-container').filterizr({
            gutterPixels: 3
        });
        $('.btn[data-filter]').on('click', function() {
            $('.btn[data-filter]').removeClass('active');
            $(this).addClass('active');
        });
    });

    $(function() {
        //Initialize Select2 Elements
        $('.select2').select2()

        //Initialize Select2 Elements
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })
    });

    $(document).ready(function() {
        $('.select2').select2({
            dropdownParent: '#AddForm' // tạo select cho form add new
        });
        $('.select2-BoM').select2({});
        $('.select2-bom-material').select2({});
        $('.select2-product-category').select2({});
        $('.select2-product-type').select2({});
        $('.select2-product-group').select2({});
        $('.select2-product-phase').select2({});
        $('.select2-product-warehouse').select2({});
        $('.select2-productByPhase').select2({});
        $('.select2-warehouse').select2({});
        $('.select2-process-export').select2({});
        $('.select2-process-import').select2({});

    });
    $(function() {
        //Initialize Select2 Elements
        //Datemask dd/mm/yyyy
        $('#datemask').inputmask('yyyy/mm/dd', {
            'placeholder': 'yyyy/mm/dd'
        })
        //Datemask2 mm/dd/yyyy
        $('#datemask2').inputmask('yyyy/mm/dd', {
            'placeholder': 'yyyy/mm/dd HH:MM'
        })

        //Money Euro
        $('[data-mask]').inputmask()

        //Date picker
        $('#reservationdate').datetimepicker({
            format: 'Y/M/D',
        });

        //Date and time picker
        $('#reservationdatetime').datetimepicker({
            icons: {
                time: 'far fa-clock'
            }
        });
        //Date range picker
        $('#reservation').daterangepicker()
        //Date range picker with time picker
        $('#reservationtime').daterangepicker({
            timePicker: true,
            timePickerIncrement: 30,
            locale: {
                format: 'MM/DD/YYYY hh:mm A'
            }
        })
        //Date range as a button
        $('#daterange-btn').daterangepicker({
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                },
                startDate: moment().subtract(29, 'days'),
                endDate: moment()
            },
            function(start, end) {
                $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
            }
        )
        $.widget.bridge('uibutton', $.ui.button)
        //Timepicker
        $('#timepicker').datetimepicker({
            format: 'LT'
        })

        //Bootstrap Duallistbox
        $('.duallistbox').bootstrapDualListbox()

        //Colorpicker
        $('.my-colorpicker1').colorpicker()
        //color picker with addon
        $('.my-colorpicker2').colorpicker()

        $('.my-colorpicker2').on('colorpickerChange', function(event) {
            $('.my-colorpicker2 .fa-square').css('color', event.color.toString());
        })
    })
    // BS-Stepper Init
    document.addEventListener('DOMContentLoaded', function() {
        window.stepper = new Stepper(document.querySelector('.bs-stepper'))
    })

    Dropzone.autoDiscover = false
    var previewNode = document.querySelector("#template")
    previewNode.id = ""
    var previewTemplate = previewNode.parentNode.innerHTML
    previewNode.parentNode.removeChild(previewNode)

    var myDropzone = new Dropzone(document.body, {
        url: "/target-url", // Set the url
        thumbnailWidth: 80,
        thumbnailHeight: 80,
        parallelUploads: 20,
        previewTemplate: previewTemplate,
        autoQueue: false,
        previewsContainer: "#previews",
        clickable: ".fileinput-button"
    })

    myDropzone.on("addedfile", function(file) {
        // Hookup the start button
        file.previewElement.querySelector(".start").onclick = function() {
            myDropzone.enqueueFile(file)
        }
    })

    // Update the total progress bar
    myDropzone.on("totaluploadprogress", function(progress) {
        document.querySelector("#total-progress .progress-bar").style.width = progress + "%"
    })

    myDropzone.on("sending", function(file) {
        // Show the total progress bar when upload starts
        document.querySelector("#total-progress").style.opacity = "1"
        // And disable the start button
        file.previewElement.querySelector(".start").setAttribute("disabled", "disabled")
    })

    // Hide the total progress bar when nothing's uploading anymore
    myDropzone.on("queuecomplete", function(progress) {
        document.querySelector("#total-progress").style.opacity = "0"
    })
    document.querySelector("#actions .start").onclick = function() {
        myDropzone.enqueueFiles(myDropzone.getFilesWithStatus(Dropzone.ADDED))
    }
    document.querySelector("#actions .cancel").onclick = function() {
        myDropzone.removeAllFiles(true)
    }
</script>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        fetch('/your-route')
            .then(response => {
                if (response.status === 403) {
                    return response.json();
                } else {
                    return Promise.resolve();
                }
            })
            .then(data => {
                if (data && data.error === 'Unauthorized') {
                    if (confirm('Are you sure you want to proceed?')) {
                        window.history.back();
                    } else {
                        console.log('User canceled');
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });


    });
    ////////////////////////////////////////////////////////////////
    // format money input tag
    function formatCurrency(input) {
        var numericValue = input.value.replace(/\D/g, '');
        var formattedValue = parseFloat(numericValue).toLocaleString('en-US');
        input.value = formattedValue;
    }
</script>

<!-- check password dùng để mở chức năng remove all, import all -->
<script>
    $('#goButton').click(function() {
        var enteredPassword = $('#passwordInput').val();
        if (enteredPassword === '123456') {
            $('#checkPassword').modal('hide');
            $('#touchAll').modal('show');
            $('#passwordInput').val('');
        } else {
            alert('Mật khẩu sai');
        }
    });
</script>

<!-- show password form đổi mật khẩu-->
<script>
    $(document).on('click', '.toggle-password', function() {
        const selector = $(this).attr('toggle');
        const input = $(selector);

        if (input.attr('type') === 'password') {
            input.attr('type', 'text');
            $(this).find('i').removeClass('fa-eye-slash text-secondary').addClass('fa-eye text-primary');
        } else {
            input.attr('type', 'password');
            $(this).find('i').removeClass('fa-eye text-primary]').addClass('fa-eye-slash text-secondary');
        }
    });

    $('#saveEvent').click(function() {
        var title = $('#eventTitle').val();
        var start = $('#eventStart').val();
        var end = $('#eventEnd').val();
        var note = $('#eventNote').val();
        var backgroundColor = $('#eventBackgroundColor').val();

        $('#Addnew').modal('hide');
    });
</script>

<!-- thông báo, tự tắt sau 3 giây -->
<script>
    setTimeout(function() {
        document.getElementById('success-alert').style.display = 'none';
    }, 3000);
</script>
<!-- //////////////////////////////////////////////////////////////// -->

<!-- nắm kéo thả diagram tổ chức công ty -->
<script>
    var isMouseDown = false;
    var startX;
    var startY;
    var scrollLeft;
    var scrollTop;

    var container = document.querySelector('.tree-view-container');

    container.addEventListener('mousedown', function(e) {
        isMouseDown = true;
        startX = e.pageX - container.offsetLeft;
        startY = e.pageY - container.offsetTop;
        scrollLeft = container.scrollLeft;
        scrollTop = container.scrollTop;
    });

    container.addEventListener('mouseup', function() {
        isMouseDown = false;
        container.style.cursor = 'grab';
    });

    container.addEventListener('mousemove', function(e) {
        if (!isMouseDown) return;
        e.preventDefault();
        container.style.cursor = 'grabbing';
        const x = e.pageX - container.offsetLeft;
        const y = e.pageY - container.offsetTop;
        const walkX = x - startX;
        const walkY = y - startY;
        container.scrollLeft = scrollLeft - walkX;
        container.scrollTop = scrollTop - walkY;
    });
</script>

<!--xử lý lọc theo tên khi sửa chức vụ từ giao diện chi tiết nhân viên-->

<script>
    var logoutTimer;

    function startLogoutTimer() {
        logoutTimer = setTimeout(function() {
            // Gửi yêu cầu đăng xuất ở đây
            window.location.href = '/logout';
            alert('Bạn đã tự động đăng xuất vì không hoạt động');
        }, 15 * 60 * 1000); // 15 phút
    }
    document.addEventListener('click', resetLogoutTimer);
    document.addEventListener('keydown', resetLogoutTimer);
    document.addEventListener('mousemove', resetLogoutTimer);
    // Gọi hàm khi đăng nhập hoặc trang web được tải
    startLogoutTimer();
</script>
<script>
    document.addEventListener("DOMContentLoaded", function() {

    });
</script>


<script>




    document.addEventListener('DOMContentLoaded', function() {
        var moneyInputs = document.querySelectorAll('.money-load');
        moneyInputs.forEach(function(input) {
            var value = parseFloat(input.value);
            if (!isNaN(value)) {
                input.value = value.toLocaleString('en-US', {
                    minimumFractionDigits: 0,
                    maximumFractionDigits: 0,
                });
            }
        });
    });
</script>

<script>

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
            }else{
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
            }else{
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
            }else{
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

            formatCurrency($('#costPriceEdit')[0]);
            formatCurrency($('#sellingPriceEdit')[0]);

            // Open the modal
            $('#editModalProduct').modal('show');
        },
        error: function() {
            console.log('Error fetching data.');
        }
    });
});

        $('#toggleLink').on('click', function(e) {
            e.preventDefault();
            $('#iconA, #iconB').toggle();
            $('#divListBoM').toggle();
            $('.divTreeBoM').toggle();
        });


    });
</script>
<script>
    var offset = 50; // Initial offset
    var limit = 50; // Number of items to load each time
    var numList = 0;
    var debounceTimer;

    $(document).ready(function() {
        loadFirstData();
        $(window).scroll(function() {
            // Use a timeout to delay the function call
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(function() {
                if ($(window).scrollTop() + $(window).height() >= $(document).height() - 50) {
                    loadMoreData();

                }
            }, 100); // Adjust the time interval (in milliseconds) as needed
        });
    });

    function loadFirstData() {
        $('#productTable tbody').empty();

        numList = 0;
        $.ajax({
            url: '/initial-load-products',
            type: 'GET',
            data: {
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

    function loadMoreData() {

        $.ajax({
            url: '/load-more-products',
            type: 'GET',
            data: {
                offset: offset,
                limit: limit
            },
            success: function(response) {
                console.log
                if (response.data.length > 0) {
                    appendRows(response.data)
                    offset += limit;
                }
            },
            error: function() {
                console.error('Error loading data.');
            }
        });
    }

    function appendRows(data) {

        var tableBody = $('#productTable tbody');
        $.each(data, function(index, product) {
            var newRow = '<tr>' +
                '<td class="text-center">' + (++numList) + '</td>' +
                '<td class="address">' + product.thuocky + '</td>' +
                '<td class="address">' + product.thuocchung + '</td>' +
                '<td class="address">' + product.thuocloai + '</td>' +
                '<td class="address">' + product.thuocnhom + '</td>' +
                '<td class="address">' + product.code + '</td>' +
                '<td class="address">' + product.name + '</td>' +
                '<td>' + product.unit + '</td>' +
                '<td class="address">' + product.orderCode + '</td>' +
                '<td class="text-right">' + formatCurrency(product.costPrice) + '</td>' +
                '<td class="text-right">' + formatCurrency(product.sellingPrice) + '</td>' +
                '<td class="address">' + product.thuockhonhapve + '</td>' +
                '<td class="project-actions text-center  py-0">' +
                '<div class="btn btn-group">' +
                '<a class="btn btn-link btn-sm mx-1 product-btn-edit" id="btn-edit-' + product.id + '" data-product-id="' + product.id + '">' +
                '<i class="fas fa-pencil-alt"></i>' +
                '</a>' +
                '<a class="btn btn-link btn-sm" type="submit" href="/product/' + product.id + '/delete" ' +
                'onclick="return confirm(\'Bạn chọn xoá sản phẩm số: ' + numList + '\')">' +
                '<i class="fas fa-trash"></i>' +
                '</a>' +
                '</div>' +
                '</td>' +
                '</tr>';
            tableBody.append(newRow);

            function formatCurrency(amount) {
                return new Intl.NumberFormat('en-US', {
                    currency: 'USD' // You can change the currency code as needed
                }).format(amount);
            }
        });


        $('#hiddenNumList').text(numList);
    }

    // Show/hide back to top button based on scroll position
    $(document).ready(function() {
        $(window).scroll(function() {
            if ($(this).scrollTop() > 100) {
                $('#backToTopBtn').fadeIn();
            } else {
                $('#backToTopBtn').fadeOut();
            }
        });
    });

    // Smooth scroll to top
    function scrollToTop() {
        $('html, body').animate({
            scrollTop: 0
        }, 'slow');
    }
    ////////////////////////////// filter //////////////////////////////////
    $(document).ready(function() {
        $('#searchInput').keyup(function() {
            if ($('#searchInput').val() == '') {
                loadFirstData();
            } else {
                filterTable();

            }
        });
    });

    function filterTable() {
        var search = $('#searchInput').val();
        console.log('search: ' + search);
        // Send an AJAX request to the server-side search endpoint
        $.ajax({
            url: '/search-products',
            type: 'GET',
            data: {
                search: search
            },
            success: function(response) {
                // Update the table with the filtered data
                console.log('data: ' + response);
                updateTable(response.data);
            },
            error: function() {
                console.error('Error searching products.');
            }
        });
    }

    function updateTable(data) {
        // Clear the current table body
        $('#productTable tbody').empty();

        // Retrieve the last numList value from the hiddenNumList element
        var numList = parseInt($('#hiddenNumList').text());

        // If numList is NaN or undefined, set it to 0
        if (isNaN(numList)) {
            numList = 0;
        }

        // Append new rows with the filtered data
        $.each(data, function(index, product) {
            var newRow = '<tr>' +
                '<td class="text-center">' + (++numList) + '</td>' +
                '<td class="address">' + product.thuocky + '</td>' +
                '<td class="address">' + product.thuocchung + '</td>' +
                '<td class="address">' + product.thuocloai + '</td>' +
                '<td class="address">' + product.thuocnhom + '</td>' +
                '<td class="address">' + product.code + '</td>' +
                '<td class="address">' + product.name + '</td>' +
                '<td>' + product.unit + '</td>' +
                '<td class="address">' + product.orderCode + '</td>' +
                '<td class="text-right">' + formatCurrency(product.costPrice) + '</td>' +
                '<td class="text-right">' + formatCurrency(product.sellingPrice) + '</td>' +
                '<td class="address">' + product.thuockhonhapve + '</td>' +
                '<td class="project-actions text-center  py-0">' +
                '<div class="btn btn-group">' +
                '<a class="btn btn-link btn-sm mx-1 product-btn-edit" id="btn-edit-' + product.id + '" data-product-id="' + product.id + '">' +
                '<i class="fas fa-pencil-alt"></i>' +
                '</a>' +
                '<a class="btn btn-link btn-sm" type="submit" href="/product/' + product.id + '/delete" ' +
                'onclick="return confirm(\'Bạn chọn xoá sản phẩm số: ' + numList + '\')">' +
                '<i class="fas fa-trash"></i>' +
                '</a>' +
                '</div>' +
                '</td>' +
                '</tr>';
            $('#productTable tbody').append(newRow);
        });
        $('#hiddenNumList').text(numList);

        function formatCurrency(amount) {
            return new Intl.NumberFormat('en-US', {
                currency: 'USD' // You can change the currency code as needed
            }).format(amount);
        }
    }
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

