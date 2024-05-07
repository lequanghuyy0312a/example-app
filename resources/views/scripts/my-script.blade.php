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
           //ip local
        var match = currentUrl.match(/^(http:\/\/[a-z0-9.:-]+)\/(en|vi|ja)/);
        // domain
        // var match = currentUrl.match(/^(https?:\/\/[a-z.:-]+)\/(en|vi|ja)/i);
        // ip server
        // var match = currentUrl.match(/^(https:\/\/[a-z0-9.:-]+)\/(en|vi|ja)/i);

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


    $(function() {
        //Initialize Select2 Elements
        $('.select2').select2()

        //Initialize Select2 Elements
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })
    });

    $(document).ready(function() {
        initializeSelect2('#AddForm', '.select2');
        $('.select2-BoM').select2({});
        $('.select2-bom-material').select2({});
        $('.select2-warehouse').select2({});
        $('.select2-process-export').select2({});
        $('.select2-process-import').select2({});
    });

    function initializeSelect2(parentElement, selector) {
        $(parentElement).find(selector).select2({
            dropdownParent: parentElement
        });
    }
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
        var moneyInputs = document.querySelectorAll('.money-load');
        moneyInputs.forEach(function(input) {
            var value = parseFloat(input.value);
            if (!isNaN(value)) {
                input.value = value.toLocaleString('en-US', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2,
                });
            }
        });
    });
    ////////////////////////////////////////////////////////////////
    function formatCurrency(input) {
        // Loại bỏ tất cả các ký tự không phải là số khỏi giá trị nhập vào
        var numericValue = input.value.replace(/[^\d.]/g, '');
        // Kiểm tra số lượng dấu chấm trong giá trị nhập
        var dotIndex = numericValue.indexOf('.');
        if (dotIndex !== -1) {
            // Nếu đã có dấu chấm, chỉ cho phép nhập thêm chữ số sau dấu thập phân
            numericValue = numericValue.substring(0, dotIndex + 1) + numericValue.substring(dotIndex + 1).replace(/\./g, '');
        }
        // Chuyển đổi giá trị thành số dấu phẩy ngăn cách hàng nghìn
        var parts = numericValue.split('.');
        parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ',');
        // Nếu có phần thập phân, chỉ giữ lại hai chữ số sau dấu thập phân
        if (parts.length > 1) {
            parts[1] = parts[1].substring(0, 2);
        }
        // Ghép lại các phần để tạo ra giá trị đã định dạng
        var formattedValue = parts.join('.');
        // Cập nhật giá trị của input với giá trị đã định dạng
        input.value = formattedValue;
    }


    setTimeout(function() {
        document.getElementById('success-alert').style.display = 'none';
    }, 3000);

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


    $(document).ready(function() {
        // Tạo một hàm để định dạng giá trị
        function formatPrice(value) {
            // Sử dụng hàm toLocaleString() để định dạng giá trị
            return Number(value).toLocaleString('en-US', {
                minimumFractionDigits: 2
            });
        }

        // Sự kiện khi trường input mất focus
        $(".input-price").blur(function() {
            // Lấy giá trị từ trường input
            var inputValue = $(this).val();
            // Định dạng giá trị
            var formattedValue = formatPrice(inputValue);
            // Gán giá trị đã định dạng lại cho trường input
            $(this).val(formattedValue);
        });
    });
</script>
