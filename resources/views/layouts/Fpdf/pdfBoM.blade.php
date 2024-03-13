<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BoM | Print</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
</head>

<body>
    <div class="wrapper mx-4 my-4 ">
        <!-- Main content -->
        <section class="invoice">
            <!-- title row -->
            <div class="row">
                <div class="col-12 row">
                    <div class="row col-12 mx-3">
                        <h5>
                            Công Ty Cổ Phần Katsura VN <br>
                            Lô 3C-5, Đường số 12, KCN Long Hậu 3(Giai đoạn 1), Xã Long Hậu, Huyện Cần Giuộc, Tỉnh Long An.
                        </h5>
                    </div>
                    <div class="col-12 row mt-5">
                        <div class="col-6 ">
                            <img src="{{ asset('assets/img/logo_kvn.jpg') }}" class="col-8">
                        </div>
                        <div class="col-6 mt-3">
                            <h3 class="page-header text-right text-uppercase">
                                <b>Bộ phận quản lý sản xuất</b>
                            </h3>
                            <hr>
                            <div class="col-12 mr-0 pr-0">
                                <p class=" text-right"><b>Ngày tạo </b>{{ __(' :day / :month  / :year', ['day' => now()->format('d'), 'month' => now()->format('m'), 'year' => now()->format('Y')]) }}</p>
                            </div>
                        </div>
                    </div>

                </div>
                <div class=" pb-5 col-12">
                    <h1 class="text-center">
                        <b>
                            {{ collect($getDropListProducts)->pluck('p_code')->first() }} -
                            {{ collect($getDropListProducts)->pluck('p_name')->first() }}
                        </b>

                    </h1>
                </div>
                <div class="col-12 py-2 m-0">
                    <table id="testTable" class="table table-bordered">
                        <thead>
                            <tr>
                                <th> Kỳ </th>
                                <th> Mã LK / SP </th>
                                <th> Tên LK / SP </th>
                                <th> ĐVT </th>
                                <th> Số lượng </th>
                                <th> Đơn giá (VND) </th>
                                <th> Thành tiền </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($getBoMs as $bom)
                            @if ($bom->product_code == collect($getDropListProducts)->pluck('p_code')->first() )
                            <tr class=" ">
                                <td class="text-center p-0"> {{ $bom->material_phase}} </td>
                                <td class="py-0"> {{ $bom->material_code }} </td>
                                <td class="py-0"> {{ $bom->material_name}} </td>
                                <td class="py-0"> cái </td>
                                <td class="py-0 text-right"> {{ $bom->quantity }} </td>
                                <td class="py-0 text-right"> {{ number_format($bom->material_costPrice) }} </td>
                                <td class="py-0 text-right"> {{ number_format($bom->material_costPrice * $bom->quantity) }} </td>
                            </tr>

                            <tr>
                                <td class="py-0">
                                    @include('partials.print-child-bom', [
                                    'parentMaterial' => $bom->material_code,
                                    'parentMaterialPhase' => $bom->material_phase,
                                    'getBoMs' => $getBoMs,
                                    ])
                                </td>
                            </tr>
                            @endif
                            @endforeach
                            <tr>
                                <td colspan="7" class="text-right"><b>Tổng:</b> <b id="grandTotalAmount"> </b></td>
                            </tr>
                        </tbody>

                    </table>
                </div>
        </section>
        <!-- /.content -->
    </div>
    <!-- ./wrapper -->
    <!-- Page specific script -->
    <script>
        window.addEventListener("load", window.print());
    </script>
</body>

</html>
