<!-- Sidebar Menu -->
<nav class="mt-0 ">
    <ul class="nav nav-pills nav-sidebar flex-column " data-widget="treeview" role="menu" data-accordion="false">

        <li class="nav-item mt-3  shadow   ">
            <a href="" class="nav-link text-white shadow bg-gradient-info ">
                <i class="fas fa-users nav-icon"></i>
                <p class="ml-2">
                {{__('msg.productClassification')}}
                    <i class="fas fa-angle-left right"></i>
                </p>
            </a>
            <ul class="nav nav-treeview mt-1 ml-4 ">
                <li class="nav-item">
                    <a href="/categories" class="nav-link">
                        <p class="text-dark text-sm">{{__('msg.categoryProduct')}}</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/types" class="nav-link">
                        <p class="text-dark text-sm">{{__('msg.typeProduct')}}</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/groups" class="nav-link">
                        <p class="text-dark text-sm">{{__('msg.groupProduct')}}</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/phases" class="nav-link">
                        <p class="text-dark text-sm">{{__('msg.phase')}}</p>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item mt-2  shadow  menu-open">
            <a href="#" class="nav-link text-white shadow bg-gradient-info ">
                <i class="fa-solid fa-business-time nav-icon "></i>
                <p class="ml-2">
                {{__('msg.warehouse')}}
                    <i class="fas fa-angle-left right"></i>
                </p>
            </a>

            <ul class="nav nav-treeview mt-1 ml-4">
                <li class="nav-item">
                    <a href="/warehouses" class="nav-link">
                        <p class="text-dark text-sm">{{__('msg.warehouseList')}}</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/import-export" class="nav-link">
                        <p class="text-dark text-sm">{{__('msg.importExport')}}</p>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item mt-2  shadow  menu-open">
            <a href="" class="nav-link  text-white shadow bg-gradient-info ">
                <i class="fa-sharp fa-solid fa-network-wired nav-icon"></i>
                <p class="ml-2">
                {{__('msg.originalProduct')}}
                    <i class="fas fa-angle-left right"></i>
                </p>
            </a>
            <ul class="nav nav-treeview mt-1 ml-4">
                <li class="nav-item">
                    <a href="/products" class="nav-link">
                        <p class="text-dark text-sm">{{__('msg.originalProductList')}}</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/product-details" class="nav-link">
                        <p class="text-dark text-sm">{{__('msg.productDetails')}}</p>
                    </a>
                </li>
            </ul>
        </li>

        <li class="nav-item mt-2  shadow  menu-open">
            <a href="" class="nav-link  text-white shadow bg-gradient-info ">
            <i class="fa-solid fa-handshake nav-icon"></i>

                <p class="ml-2">
                {{__('msg.partner')}}
                    <i class="fas fa-angle-left right"></i>

                </p>
            </a>
            <ul class="nav nav-treeview mt-1 ml-4">
                <li class="nav-item">
                    <a href="/partners" class="nav-link">
                        <p class="text-dark text-sm">{{__('msg.partnerList')}}</p>
                    </a>
                </li>
            </ul>
        </li>

        <li class="nav-item mt-2  shadow  menu-open">
            <a href="" class="nav-link  text-white shadow bg-gradient-info ">
            <i class="fa-solid fa-money-bill nav-icon"></i>
                <p class="ml-2">
                {{__('msg.quotation')}}
                    <i class="fas fa-angle-left right"></i>
                </p>
            </a>
            <ul class="nav nav-treeview mt-1 ml-4">
                <li class="nav-item">
                    <a href="/quotations" class="nav-link">
                        <p class="text-dark text-sm">{{__('msg.quotationList')}}</p>
                    </a>
                </li>
            </ul>
            <ul class="nav nav-treeview mt-1 ml-4">
                <li class="nav-item">
                    <a href="/compare-prices" class="nav-link">
                        <p class="text-dark text-sm">{{__('msg.comparePrices')}}</p>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item mt-2  shadow  menu-open">
            <a href="" class="nav-link  text-white shadow bg-gradient-info ">
            <i class="fa-solid fa-basket-shopping nav-icon"></i>

                <p class="ml-2">
                {{__('msg.purchaseOrder')}}
                    <i class="fas fa-angle-left right"></i>

                </p>
            </a>
            <ul class="nav nav-treeview mt-1 ml-4">
                <li class="nav-item">
                    <a href="/purchase-orders" class="nav-link">
                        <p class="text-dark text-sm">{{__('msg.purchaseOrderList')}}</p>
                    </a>
                </li>
            </ul>
        </li>

        <li class="nav-item mt-2  shadow">
        </li>

    </ul>
</nav>
