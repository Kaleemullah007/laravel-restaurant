@extends('layouts.master')
@yield('title','Home')

@section('content')
    <section id="dashboard-top-sec">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8">
                    <div class="bg-white top-chart-earn">
                        <div class="row">
                            <div class="col-sm-4 my-2 pe-0">
                                <div class="last-month">
                                    <h5>Dashboard</h5>
                                    <p>Overview of Latest Month</p>
                                    <div class="earn">
                                        <h2>$6783.35</h2>
                                        <p>Current Month Sales</p>
                                    </div>
                                    <div class="sale mb-3">
                                        <h2>95</h2>
                                        <p>Current Month Sales</p>
                                    </div>
                                    <a href="#" class="di-btn btn purple-gradient">Last Month Summary</a>
                                </div>
                            </div>
                            <div class="col-sm-8 my-2 ps-0">
                                <div class="classic-tabs">
                                    <!-- -------Nav Tabs ------ -->
                                    <div class="tabs-wrapper">
                                        <ul class="nav nav-pills chart-header-tab mb-3" id="pills-tab" role="tablist">
                                            <li class="nav-item">
                                                <a href="" class="nav-link chart-nav active" id="pills-week-tab"
                                                    data-bs-toggle="pill" data-bs-target="#pills-week" type="button"
                                                    role="tab" aria-controls="pills-week" aria-selected="true">Week</a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="" class="nav-link chart-nav" id="pills-month-tab"
                                                    data-bs-toggle="pill" data-bs-target="#pills-month" type="button"
                                                    role="tab" aria-controls="pills-month"
                                                    aria-selected="false">Month</a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="" class="nav-link chart-nav" id="pills-year-tab"
                                                    data-bs-toggle="pill" data-bs-target="#pills-year" type="button"
                                                    role="tab" aria-controls="pills-year" aria-selected="false">Year</a>
                                            </li>
                                        </ul>
                                        <div class="tab-content" id="pills-tabContent">
                                            <div class="tab-pane fade show active" id="pills-week" role="tabpanel"
                                                aria-labelledby="pills-week-tab" tabindex="0">
                                                <div class="widget-content">
                                                    <div id="weekly"></div>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="pills-month" role="tabpanel"
                                                aria-labelledby="pills-month-tab" tabindex="0">month</div>
                                            <div class="tab-pane fade" id="pills-year" role="tabpanel"
                                                aria-labelledby="pills-year-tab" tabindex="0">Year</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="wre-sec">
                            <div class="row">
                                <div class="col-md-3 col-sm-3 col-6 my-1 bdr-cls">
                                    <div class="earn-view">
                                        <span><i class="bi bi-currency-dollar earn-icon wallet"></i></span>
                                        <div class="earn-view-text">
                                            <p class="name-text">
                                                Wallet Balance
                                            </p>
                                            <h6 class="balance-text">
                                                $2351.32
                                            </h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-3 col-6 my-1 bdr-cls">
                                    <div class="earn-view">
                                        <span><i class="bi bi-heart-fill earn-icon referral"></i></span>
                                        <div class="earn-view-text">
                                            <p class="name-text">
                                                Referral Earnings
                                            </p>
                                            <h6 class="balance-text">
                                                $1151.32
                                            </h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-3 col-6 my-1 bdr-cls">
                                    <div class="earn-view">
                                        <span><i class="bi bi-graph-up-arrow earn-icon sales"></i></span>
                                        <div class="earn-view-text">
                                            <p class="name-text">
                                                Estimate Sales
                                            </p>
                                            <h6 class="balance-text">
                                                $151.32
                                            </h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-3 col-6 my-1 bdr-cls">
                                    <div class="earn-view">
                                        <span><i class="bi bi-cash-coin earn-icon earning"></i></span>
                                        <div class="earn-view-text">
                                            <p class="name-text">
                                                Earning
                                            </p>
                                            <h6 class="balance-text">
                                                $15351.32
                                            </h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="bg-white top-chart-earn h-custom2">
                        <div class="traffice-title">
                            <p>Traffic</p>
                        </div>
                        <div class="traffic">
                            <div id="chart-2">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section>
        <div class="sm-chart-sec my-5">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-3 col-md-6 col-sm-6 my-2">
                        <div class="revinue revinue-one_hybrid">
                            <div class="revinue-hedding">
                                <div class="w-title">
                                    <div class="w-icon">
                                        <i class="bi bi-people-fill"></i>
                                    </div>
                                    <div class="sm-chart-text">
                                        <p class="w-value">35.4k</p>
                                        <h5>Followers</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="revinue-content">
                                <div id="hybrid-followers"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 my-2">
                        <div class="revinue page-one_hybrid">
                            <div class="revinue-hedding">
                                <div class="w-title">
                                    <div class="sm-chart-text">
                                        <p class="w-value">851.5k</p>
                                        <h5>Page View</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="revinue-content">
                                <div id="hybrid-followers1"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 my-2">
                        <div class="revinue bounce-one_hybrid">
                            <div class="revinue-hedding">
                                <div class="w-title">
                                    <div class="sm-chart-text">
                                        <p class="w-value">$512.6k</p>
                                        <h5>Bounce Rate</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="revinue-content">
                                <div id="hybrid-followers3"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 my-2">
                        <div class="revinue rv-status-one_hybrid">
                            <div class="revinue-hedding">
                                <div class="w-title">
                                    <div class="sm-chart-text">
                                        <p class="w-value">$ 763<small>Jan 01 - Jan 10</small></p>
                                        <h5>Revinue Status</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="revinue-content">
                                <div id="hybrid-followers4"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Admin and order status table -->
    <section>
        <div class="all-admin my-5">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-4 col-sm-5">
                        <div class="admin-list">
                            <p class="admin-ac-title">All Admins</p>
                            <ul class="admin-ul">
                                <li class="admin-li">
                                    <img src="/assets/images/user1.png" alt="Image" class="admin-image">
                                    <div class="admin-ac-details">
                                        <div>
                                            <a href="#" class="admin-name">Kaleem Ullah</a>
                                            <p class="activity-text">Active Now</p>
                                        </div>
                                        <div class="status bg-success"></div>
                                    </div>
                                </li>
                                <li class="admin-li">
                                    <img src="/assets/images/user2.png" alt="Image" class="admin-image">
                                    <div class="admin-ac-details">
                                        <div>
                                            <a href="#" class="admin-name">Muhammad Uzair</a>
                                            <p class="activity-text">Active 15 min ago</p>
                                        </div>
                                        <div class="status bg-primary"></div>
                                    </div>
                                </li>
                                <li class="admin-li">
                                    <img src="/assets/images/user3.png" alt="Image" class="admin-image">
                                    <div class="admin-ac-details">
                                        <div>
                                            <a href="#" class="admin-name">Ali Khan</a>
                                            <p class="activity-text">Active 30 min ago</p>
                                        </div>
                                        <div class="status bg-warning"></div>
                                    </div>
                                </li>
                                <li class="admin-li">
                                    <img src="/assets/images/user4.png" alt="Image" class="admin-image">
                                    <div class="admin-ac-details">
                                        <div>
                                            <a href="#" class="admin-name">Ahmad Khan</a>
                                            <p class="activity-text">Active 2 days ago</p>
                                        </div>
                                        <div class="status bg-danger"></div>
                                    </div>
                                </li>
                                <li class="admin-li">
                                    <img src="/assets/images/user5.png" alt="Image" class="admin-image">
                                    <div class="admin-ac-details">
                                        <div>
                                            <a href="#" class="admin-name">Shan Khan</a>
                                            <p class="activity-text">Active Now</p>
                                        </div>
                                        <div class="status bg-success"></div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-8 col-sm-7">
                        <div class="order-list">
                            <p class="order-ac-title">Order Status</p>
                            <div class="data-table-section table-responsive">
                                <table id="order-table" class="table table-striped" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Position</th>
                                            <th>Office</th>
                                            <th>Age</th>
                                        </tr>
                                    </thead>
                                    <tbody class="order-view-tb">
                                        <tr>
                                            <td>Tiger Nixon</td>
                                            <td>System Architect</td>
                                            <td>Edinburgh</td>
                                            <td>
                                                <a href="#" class="status-tb-btn bg-cla">Success</a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Garrett Winters</td>
                                            <td>Accountant</td>
                                            <td>Tokyo</td>
                                            <td>
                                                <a href="#" class="status-tb-btn bg-clb">Open</a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Ashton Cox</td>
                                            <td>Junior Technical Author</td>
                                            <td>San Francisco</td>
                                            <td>
                                                <a href="#" class="status-tb-btn bg-clc">On Hold</a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Cedric Kelly</td>
                                            <td>Senior Javascript Developer</td>
                                            <td>Edinburgh</td>
                                            <td>
                                                <a href="#" class="status-tb-btn bg-cld">Checked</a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Cedric Kelly</td>
                                            <td>Senior Javascript Developer</td>
                                            <td>Edinburgh</td>
                                            <td>
                                                <a href="#" class="status-tb-btn bg-cla">Process</a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Cedric Kelly</td>
                                            <td>Senior Javascript Developer</td>
                                            <td>Edinburgh</td>
                                            <td>
                                                <a href="#" class="status-tb-btn bg-clb">Open</a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </section>
@endsection
