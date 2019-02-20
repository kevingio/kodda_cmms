$(document).ready(function () {
    var $page = $('#energy-report-page');

    var energyPage = {
        init: function () {
            this.customFunction();
        },
        customFunction: function () {
            $('.edit').on('click', function () {
                $.get('/energy-report/777')
                .done(function (response) {
                    $('#edit-record-form input[name="lwbp"]').val(response.lwbp);
                    $('#edit-record-form input[name="wbp"]').val(response.wbp);
                    $('#edit-record-form input[name="pdam"]').val(response.pdam);
                    $('#edit-record-form input[name="deep_well"]').val(response.deep_well);
                    $('#edit-record-form input[name="lpg"]').val(response.lpg);
                    $('#editModal').modal('show');
                });
            });

            $('#edit-record-form').on('submit', function (e) {
                e.preventDefault();
                let data = $(this).serializeArray();
                $.ajax({
                    url: '/energy-report/777',
                    data: data,
                    type: 'PUT',
                    success: function (response) {
                        if (response.status == 200) {
                            $(this).find("input, textarea").val('');
                            $('button.close').click();
                            swal(
                                "Success!",
                                "Energy has been updated!",
                                "success"
                            );
                        } else {
                            swal(
                                "Oops!",
                                "Something went wrong, please refresh the page!",
                                "error"
                            );
                        }
                    }
                });
            });

            $('#add-record-form').on('submit', function (e) {
                e.preventDefault();
                let data = $(this).serializeArray();
                $.ajax({
                    url: '/energy-report',
                    data: data,
                    type: 'POST',
                    success: function (response) {
                        if (response.status == 200) {
                            $(this).find("input, textarea").val('');
                            electricityReportPage.dtTable.ajax.reload(null, false);
                            gasReportPage.dtTable.ajax.reload(null, false);
                            waterReportPage.dtTable.ajax.reload(null, false);
                            $('button.close').click();
                            swal(
                                "Success!",
                                "Energy has been updated!",
                                "success"
                            );
                        } else {
                            swal(
                                "Oops!",
                                "Something went wrong, please refresh the page!",
                                "error"
                            );
                        }
                    }
                });
            })
        },
    };

    var electricityReportPage = {
        dtTable: {},
        init: function () {
            this.initSelect2();
            this.initDatatable();
            this.customFunction();
        },
        customFunction: function () {
            var data_id = null;


        },
        initSelect2: function () {
            $('#electricity-pane select[name=month]').select2({
                placeholder: '-- Please Select --',
            });
            $('#electricity-pane select[name=year]').select2({
                placeholder: '-- Please Select --',
                data: [
                    {
                        id: 2017,
                        text: '2017'
                    },
                    {
                        id: 2018,
                        text: '2018'
                    },
                    {
                        id: 2019,
                        text: '2019'
                    }
                ]
            });
            $('#electricity-pane select[name=year]').val(2019).trigger('change');
        },
        initDatatable: function () {
            $table = $page.find('#electricity-datatable');
            electricityReportPage.dtTable = $table.DataTable({
                "aaSorting": [],
                "processing": true,
                "serverSide": true,
                "searching": true,
                "lengthChange": false,
                "responsive": true,
                "ajax": {
                    url: "/ajax/energy",
                    type: "POST",
                    data: function (d) {
                        d.mode = 'electricity';
                        d.month = $('#electricity-pane select[name=month]').val();
                        d.year = $('#electricity-pane select[name=year]').val();
                    }
                },
                "columns": [
                    { data: 'day', name: 'day' },
                    { data: 'lwbp', name: 'lwbp' },
                    { data: 'lwbp_total', name: 'lwbp_total' },
                    { data: 'lwbp_price', name: 'lwbp_price' },
                    { data: 'wbp', name: 'wbp' },
                    { data: 'wbp_total', name: 'wbp_total' },
                    { data: 'wbp_price', name: 'wbp_price' },
                    { data: 'cost_total', name: 'cost_total' },
                    { data: 'occupancy', name: 'occupancy' },
                    { data: 'electricity_per_room', name: 'electricity_per_room' },
                    { data: 'month_to_date_cost', name: 'month_to_date_cost' },
                    { data: 'action', name: 'action' },
                ],
                "columnDefs": [
                    { targets: 'no-sort', orderable: false },
                    { targets: 'no-search', searchable: false },
                    { targets: 'text-center', className: 'text-center' },
                ]
            });
        },
    };

    var gasReportPage = {
        dtTable: {},
        init: function () {
            this.initSelect2();
            this.initDatatable();
            this.customFunction();
        },
        customFunction: function () {
            var data_id = null;


        },
        initSelect2: function () {
            $('#gas-pane select[name=month]').select2({
                placeholder: '-- Please Select --',
            });
            $('#gas-pane select[name=year]').select2({
                placeholder: '-- Please Select --',
                data: [
                    {
                        id: 2017,
                        text: '2017'
                    },
                    {
                        id: 2018,
                        text: '2018'
                    },
                    {
                        id: 2019,
                        text: '2019'
                    }
                ]
            });
            $('#gas-pane select[name=year]').val(2019).trigger('change');
        },
        initDatatable: function () {
            $table = $page.find('#gas-datatable');
            gasReportPage.dtTable = $table.DataTable({
                "aaSorting": [],
                "processing": true,
                "serverSide": true,
                "searching": true,
                "lengthChange": false,
                "responsive": true,
                "ajax": {
                    url: "/ajax/energy",
                    type: "POST",
                    data: function (d) {
                        d.mode = 'gas';
                        d.month = $('#gas-pane select[name=month]').val();
                        d.year = $('#gas-pane select[name=year]').val();
                    }
                },
                "columns": [
                    { data: 'dat', name: 'day' },
                    { data: 'value', name: 'value' },
                    { data: 'consumption', name: 'consumption' },
                    { data: 'price', name: 'price' },
                    { data: 'month_to_date', name: 'month_to_date' },
                    { data: 'action', name: 'action' },
                ],
                "columnDefs": [
                    { targets: 'no-sort', orderable: false },
                    { targets: 'no-search', searchable: false },
                    { targets: 'text-center', className: 'text-center' },
                ]
            });
        },
    };

    var waterReportPage = {
        dtTable: {},
        init: function () {
            this.initSelect2();
            this.initDatatable();
            this.customFunction();
        },
        customFunction: function () {
            var data_id = null;


        },
        initSelect2: function () {
            $('#water-pane select[name=month]').select2({
                placeholder: '-- Please Select --',
            });
            $('#water-pane select[name=year]').select2({
                placeholder: '-- Please Select --',
                data: [
                    {
                        id: 2017,
                        text: '2017'
                    },
                    {
                        id: 2018,
                        text: '2018'
                    },
                    {
                        id: 2019,
                        text: '2019'
                    }
                ]
            });
            $('#water-pane select[name=year]').val(2019).trigger('change');
        },
        initDatatable: function () {
            $table = $page.find('#water-datatable');
            waterReportPage.dtTable = $table.DataTable({
                "aaSorting": [],
                "processing": true,
                "serverSide": true,
                "searching": true,
                "lengthChange": false,
                "responsive": true,
                "ajax": {
                    url: "/ajax/energy",
                    type: "POST",
                    data: function (d) {
                        d.mode = 'water';
                        d.month = $('#water-pane select[name=month]').val();
                        d.year = $('#water-pane select[name=year]').val();
                    }
                },
                "columns": [
                    { data: 'day', name: 'day' },
                    { data: 'pdam', name: 'pdam' },
                    { data: 'pdam_consuption', name: 'pdam_consuption' },
                    { data: 'pdam_price', name: 'pdam_price' },
                    { data: 'pdam_month_to_date', name: 'pdam_month_to_date' },
                    { data: 'deep_well', name: 'deep_well' },
                    { data: 'deep_well_consumption', name: 'deep_well_consumption' },
                    { data: 'deep_well_total', name: 'deep_well_total' },
                    { data: 'occupancy', name: 'occupancy' },
                    { data: 'water_per_room', name: 'water_per_room' },
                    { data: 'action', name: 'action' },
                ],
                "columnDefs": [
                    { targets: 'no-sort', orderable: false },
                    { targets: 'no-search', searchable: false },
                    { targets: 'text-center', className: 'text-center' },
                ]
            });
        },
    };

    if($page.length) {
        energyPage.init();
        electricityReportPage.init();
        gasReportPage.init();
        waterReportPage.init();
    }
});
