          <!-- Left Sidebar  -->
            <div class="left-menu ">
                <div class="menubar-content">
                    <nav class="animated bounceInDown">
                        <ul class="nav nav-pills nav-sidebar nav-child-indent flex-column" id="sidebar">
                            <li class="lii {{ (request()->is('dashboard') || request()->is('dashboard/*') ) ? 'active' : '' }}">
                                <a href="{{ route('dashboard') }}"><i class="bi fs-5 pe-2 bi-graph-up-arrow"></i><span
                                        class="hide-menu ">{{ __('general.Dashboard') }}</span></a>
                            </li>
                            <li class="lii {{ (request()->is('customer') || request()->is('customer/*') ) ? 'active' : '' }}">
                                <a href="{{ route('customer.index') }}"><i class="bi fs-5 pe-2 bi-people-fill"></i><span
                                    class="hide-menu ">{{ __('general.Users') }}</span></a>
                            </li>
                            <li class="lii {{ (request()->is('product') || request()->is('product/*') ) ? 'active' : '' }}">
                                <a href="{{ route('product.index') }}"><i class="bi fs-5 pe-2 bi-boxes"></i><span
                                    class="hide-menu ">{{ __('general.Products') }}</span></a>
                            </li>

                            <li class="lii {{ (request()->is('deal') || request()->is('deal/*') ) ? 'active' : '' }}">
                                <a href="{{ route('deal.index') }}"><i class="bi fs-5 pe-2 bi-wallet2"></i><span
                                        class="hide-menu ">{{ __('general.Deal') }}</span></a>
                            </li>

                            <li class="lii {{ (request()->is('purchase') || request()->is('purchase/*') ) ? 'active' : '' }}">
                                <a href="{{ route('purchase.index') }}"><i class="bi fs-5 pe-2 bi-receipt-cutoff"></i><span
                                        class="hide-menu ">{{ __('general.Purchase') }}</span></a>
                            </li>
                            <li class="lii {{ (request()->is('sale') || request()->is('sale/*') ) ? 'active' : '' }}">
                                <a href="{{ route('sale.index') }}"><i class="bi fs-5 pe-2 bi-cart4"></i><span
                                        class="hide-menu ">{{ __('general.Sale') }}</span></a>
                            </li>



                            <li class="lii {{ (request()->is('expense') || request()->is('expense/*') ) ? 'active' : '' }}">
                                <a href="{{ route('expense.index') }}"><i class="bi fs-5 pe-2 bi-wallet2"></i><span
                                        class="hide-menu ">{{ __('general.Expense') }}</span></a>
                            </li>

                            {{-- <li class="lii {{ (request()->is('production') || request()->is('production/*') ) ? 'active' : '' }}">
                                <a href="{{ route('production.index') }}"><i class="bi fs-5 pe-2 bi-repeat"></i><span
                                        class="hide-menu ">{{ __('general.Production') }}</span></a>
                            </li> --}}



                        </ul>
                    </nav>
                </div>
            </div>
            <!-- End Left Sidebar  -->

            <div class="content-wrapper">
                <div class="min-height-css">
