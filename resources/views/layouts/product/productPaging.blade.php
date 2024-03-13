<div id="infinite-scroll-container">
    <table id="productTable" class="table table-bordered table-striped">
        <thead style="position: sticky; top: 0; background-color: #fff; z-index: 1;">
            <tr>
                <th style="width: 1%">
                    STT
                </th>
                <th>
                    Mã Sản phẩm
                </th>
                <th>
                    Tên hiển thị
                </th>
                <th>
                    Order Code
                </th>
                <th>
                    ĐVT
                </th>
                <th>
                    Kho nhập về
                </th>
                <th style="width: 1%" class="text-center">
                    <a href="/product-add-form" class="btn btn-success btn-sm col " data-toggle="modal" data-target="#AddForm">
                        <i class="fas fa-plus"></i>
                        <span>Add</span> </a>
                </th>
            </tr>
        </thead>
        <tbody>
            <?php
            $numList = 0;
            ?>
            @foreach($getProducts as $product)
            <tr>
                <td class="text-center "> {{ ++$numList }}</a> </td>
                <td class="address">
                    {{$product->code }}
                </td>
                <td class="address">
                    {{$product->name }}
                </td>
                <td class="address">
                    {{$product->orderCode }}
                </td>
                <td>
                    {{$product->unit }}
                </td>
                <td>
                    {{$product->warehouse }}
                </td>
                <td class="project-actions text-center  py-0">
                    <div class="btn btn-group">
                        <a class="btn btn-link btn-sm mx-1 product-btn-edit" id="btn-edit-{{ $product->id }}" data-product-id="{{ $product->id }}">
                            <i class=" fas fa-pencil-alt">
                            </i>
                        </a>
                        <a class="btn btn-link btn-sm" type="submit" href="/product/{{$product->id}}/delete" onclick="return confirm('Bạn chọn xoá sản phẩm số: {{ $numList }}')">
                            <i class="fas fa-trash">
                            </i>
                        </a>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $getProducts->links() }}

</div>
