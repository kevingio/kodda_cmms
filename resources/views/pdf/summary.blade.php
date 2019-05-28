<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    </head>
    <body>
        <div id="wrapper">
            <div class="content-page">
                <div class="content" id="dashboard-page">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="page-title-box">
                                    <h4 class="page-title">Dashboard</h4>
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item active">
                                            Welcome to Kodda!
                                        </li>
                                    </ol>
                                    <div class="state-information d-none d-sm-block">
                                        <div class="row">
                                            <div class="col-md-12 text-right">
                                                <h5 class="mt-0">Royal Ambarukmo Yogyakarta</h5>
                                                <h6>{{ date('l, dS F Y') }}</h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="page-title-box">
                                    <h4 class="page-title">Work Order</h4>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xl-3 col-md-6">
                                <div class="card mini-stat bg-danger">
                                    <div class="card-body mini-stat-img">
                                        <div class="mini-stat-icon">
                                            <i class="mdi mdi-calendar float-right"></i>
                                        </div>
                                        <div class="text-white">
                                            <h6 class="text-uppercase mb-3">Not Started</h6>
                                            <h4 class="mb-4" id="not-started">{{ isset($data['workOrderStatus']['not-started']) ? $data['workOrderStatus']['not-started'] : 0 }}</h4>
                                            <i class="mdi mdi-refresh"></i> <span class="ml-2">Updated {{ date('H:i') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card mini-stat bg-primary">
                                    <div class="card-body mini-stat-img">
                                        <div class="mini-stat-icon">
                                            <i class="mdi mdi-calendar-clock float-right"></i>
                                        </div>
                                        <div class="text-white">
                                            <h6 class="text-uppercase mb-3">In Progress</h6>
                                            <h4 class="mb-4" id="in-progress">{{ isset($data['workOrderStatus']['in-progress']) ? $data['workOrderStatus']['in-progress'] : 0 }}</h4>
                                            <i class="mdi mdi-refresh"></i> <span class="ml-2">Updated {{ date('H:i') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card mini-stat bg-warning">
                                    <div class="card-body mini-stat-img">
                                        <div class="mini-stat-icon">
                                            <i class="mdi mdi-calendar-multiple float-right"></i>
                                        </div>
                                        <div class="text-white">
                                            <h6 class="text-uppercase mb-3">Waiting</h6>
                                            <h4 class="mb-4" id="waiting">{{ (isset($data['workOrderStatus']['waiting-for-part']) ? $data['workOrderStatus']['waiting-for-part'] : 0) + (isset($data['workOrderStatus']['waiting-for-quotation']) ? $data['workOrderStatus']['waiting-for-quotation'] : 0) }}</h4>
                                            <i class="mdi mdi-refresh"></i> <span class="ml-2">Updated {{ date('H:i') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card mini-stat bg-success">
                                    <div class="card-body mini-stat-img">
                                        <div class="mini-stat-icon">
                                            <i class="mdi mdi-calendar-check float-right"></i>
                                        </div>
                                        <div class="text-white">
                                            <h6 class="text-uppercase mb-3">Completed</h6>
                                            <h4 class="mb-4" id="completed">{{ isset($data['workOrderStatus']['completed']) ? $data['workOrderStatus']['completed'] : 0 }}</h4>
                                            <i class="mdi mdi-refresh"></i> <span class="ml-2">Updated {{ date('H:i') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xl-6">
                                <div class="card m-b-20">
                                    <div class="card-body">

                                        <h4 class="mt-0 header-title">Water Chart</h4>

                                        <div id="chart-water"></div>

                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="card m-b-20">
                                    <div class="card-body">
                                        <h4 class="mt-0 header-title">Electricity Chart</h4>
                                        <div id="chart-electricity"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="page-title-box">
                                    <h4 class="page-title">Pool Management</h4>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-3 col-md-6">
                                <div class="card mini-stat {{ !empty($data['poolLog']) && $data['poolLog']->cl <= 3 ? 'bg-success' : 'bg-danger' }}" id="cl-card">
                                    <div class="card-body mini-stat-img">
                                        <div class="mini-stat-icon">
                                            <i class="mdi mdi-speedometer float-right"></i>
                                        </div>
                                        <div class="text-white">
                                            <h6 class="text-uppercase mb-3">Chlorine</h6>
                                            <h4 class="mb-4" id="cl-value">{{ !empty($data['poolLog']->cl) ? $data['poolLog']->cl : 'no record' }}</h4>
                                            <i class="mdi mdi-refresh"></i> <span class="ml-2">Updated {{ date('H:i') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card mini-stat {{ !empty($data['poolLog']) && $data['poolLog']->ph >= 7.6 && $data['poolLog']->ph <= 7.8 ? 'bg-success' : 'bg-danger' }}" id="ph-card">
                                    <div class="card-body mini-stat-img">
                                        <div class="mini-stat-icon">
                                            <i class="mdi mdi-speedometer float-right"></i>
                                        </div>
                                        <div class="text-white">
                                            <h6 class="text-uppercase mb-3">pH</h6>
                                            <h4 class="mb-4" id="ph-value">{{ !empty($data['poolLog']->ph) ? $data['poolLog']->ph : 'no record' }}</h4>
                                            <i class="mdi mdi-refresh"></i> <span class="ml-2">Updated {{ date('H:i') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 col-md-12">
                                <div class="card mini-stat bg-warning">
                                    <div class="card-body mini-stat-img">
                                        <div class="mini-stat-icon">
                                            <i class="mdi mdi-note-outline float-right"></i>
                                        </div>
                                        <div class="text-white">
                                            <h6 class="text-uppercase mb-3">Remark</h6>
                                            <h4 class="mb-4" id="remark">{{ !empty($data['poolLog']) && $data['poolLog']->remark != '' ? $data['poolLog']->remark :'-' }}</h4>
                                            <i class="mdi mdi-refresh"></i> <span class="ml-2">Updated {{ date('H:i') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="card m-b-30">
                                    <div class="card-body">
                                        <h4 class="mt-0 m-b-30 header-title">Maintenance Done</h4>
                                        <div class="table-responsive">
                                            <table class="table table-vertical" id="datatable">
                                                <thead>
                                                    <tr class="font-weight-bold">
                                                        <th width="170">MT Number</th>
                                                        <th width="180" class="no-sort">Model</th>
                                                        <th class="no-sort no-search">Serial Number</th>
                                                        <th width="200" class="no-sort no-search">Location</th>
                                                        <th width="150" class="no-sort">Status</th>
                                                        <th width="150" class="no-sort no-search text-center">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody></tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xl-6">
                                <div class="card m-b-20">
                                    <div class="card-body">
                                        <h4 class="mt-0 m-b-30 header-title text-success">Inventory In</h4>
                                        <div class="table-responsive">
                                            <table class="table table-vertical">
                                                <thead>
                                                    <tr>
                                                        <th>Name</th>
                                                        <th>Model</th>
                                                        <th>Qty</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>Cat Dulux</td>
                                                        <td>Civil</td>
                                                        <td>4</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Kawat</td>
                                                        <td>Mechanic</td>
                                                        <td>3</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Baterai ABC</td>
                                                        <td>Electric</td>
                                                        <td>4</td>
                                                    </tr>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-6">
                                <div class="card m-b-20">
                                    <div class="card-body">
                                        <h4 class="mt-0 m-b-30 header-title text-danger">Inventory Out</h4>
                                        <div class="table-responsive">
                                            <table class="table table-vertical">
                                                <thead>
                                                    <tr>
                                                        <th>Name</th>
                                                        <th>Model</th>
                                                        <th>Qty</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>Terpal</td>
                                                        <td>Civil</td>
                                                        <td>2</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Baterai ABC</td>
                                                        <td>Electric</td>
                                                        <td>3</td>
                                                    </tr>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @include('layouts.footer')
            </div>
        </div>
        <script src="{{ asset('js/app.js') }}"></script>
    </body>
</html>