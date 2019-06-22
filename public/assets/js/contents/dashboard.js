$(document).ready(function () {
    var $page = $('#dashboard-page');

    var dashboardPage = {
        dtTable: {},
        init: function () {
            this.initWaterChart();
            this.initElectricityChart();
            this.initDatatable();
            this.customFunction();
		},
        customFunction: function() {

        },
        initWaterChart: function() {
            $.post('/ajax/energy', {
                mode: 'water-chart',
            }).then(function (response) {
                // water chart
                c3.generate({
                    bindto: '#chart-water',
                    data: {
                        x: 'x',
                        columns: [
                            response.dates,
                            response.pdam,
                            response.deep_well
                        ],
                        types: {
                            PDAM: 'line',
                            DeepWell: 'line'
                            // 'line', 'spline', 'step', 'area', 'area-step' are also available to stack
                        },
                        colors: {
                            PDAM: '#222222',
                            DeepWell: '#007bff',
                        }
                    },
                    axis: {
                        x: {
                            type: 'timeseries',
                            format: '%Y-%m-%d'
                        }
                    }
                });
            })
        },
        initElectricityChart: function() {
            $.post('/ajax/energy', {
                mode: 'electricity-chart',
            }).then(function (response) {
                // electricity chart
                c3.generate({
                    bindto: '#chart-electricity',
                    data: {
                        x: 'x',
                        columns: [
                            response.dates,
                            response.lwbp,
                            response.wbp
                        ],
                        types: {
                            LWBP: 'line',
                            WBP: 'line',
                            // 'line', 'spline', 'step', 'area', 'area-step' are also available to stack
                        },
                        colors: {
                            LWBP: '#222222',
                            WBP: '#007bff',
                        }
                    },
                    axis: {
                        x: {
                            type: 'timeseries',
                            format: '%Y-%m-%d'
                        }
                    }
                });
            })
        },
        initDatatable: function () {
            $table = $page.find('#maintenance-datatable');
            dashboardPage.dtTable = $table.DataTable({
                "aaSorting": [],
                "processing": true,
                "serverSide": true,
                "searching": true,
                "lengthChange": false,
                "responsive": true,
                "ajax": {
                    url: "/ajax/maintenance-report",
                    type: "POST",
                    data: function (d) { d.mode = 'datatable-done'; }
                },
                "columns": [
                    { data: 'mt_number', name: 'mt_number' },
                    { data: 'model', name: 'model' },
                    { data: 'serial_number', name: 'serial_number' },
                    { data: 'location', name: 'location' },
                    { data: 'status', name: 'status' },
                ],
                "columnDefs": [
                    { targets: 'no-sort', orderable: false },
                    { targets: 'no-search', searchable: false },
                    { targets: 'text-center', className: 'text-center' },
                ],
            });
		}
    };

    if($page.length) {
        dashboardPage.init();
    }
});
