$(document).ready(function () {
    var $page = $('#energy-report-page');

    var energyPage = {
        init: function () {
            this.customFunction();
        },
        customFunction: function () {
            $('.nav-energy .nav-item').on('click', function () {
                electricityReportPage.dtTable.ajax.reload(null, false);
                gasReportPage.dtTable.ajax.reload(null, false);
                waterReportPage.dtTable.ajax.reload(null, false);
            });

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
                            $('button.close').click();
                            swal(
                                "Success!",
                                "Energy has been updated!",
                                "success"
                            );
                            $(this).find("input, textarea").val('');
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
            this.customFunction();
            this.initDatatable();
        },
        customFunction: function () {
            var data_id = null;

            $('#electricity-pane select[name="month"], #electricity-pane select[name="year"]').on('select2:select', function () {
                electricityReportPage.dtTable.ajax.reload();
            });

            $(document).on('click', '.edit-electricity', function () {
                data_id = $(this).attr('data-id');
                $.get('/electricity/' + data_id)
                    .done(function (response) {
                        $('#edit-electricity-record-form input[name=lwbp]').val(response.lwbp);
                        $('#edit-electricity-record-form input[name=wbp]').val(response.wbp);
                        $('#edit-electricity-record-form input[name=occupancy]').val(response.occupancy);
                        $('#editElectricityModal').modal('show');
                    });
            });

            $('#edit-electricity-record-form').on('submit', function (e) {
                e.preventDefault();
                let data = $(this).serializeArray();
                $.ajax({
                    url: '/electricity/' + data_id,
                    data: data,
                    type: 'PUT',
                    success: function (response) {
                        if (response.status == 200) {
                            $(this).find("input, textarea").val('');
                            electricityReportPage.dtTable.ajax.reload(null, false);
                            $('button.close').click();
                            swal(
                                "Success!",
                                "Report has been updated!",
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
        },
        initSelect2: function () {
            $('#electricity-pane select[name=month]').select2({
                placeholder: '-- Please Select --',
            });
            $.post('/ajax/energy', { mode: 'select2', type: 'electricity' })
            .done(function (response) {
                let date = new Date();
                $('#electricity-pane select[name=year]').select2({
                    data: response
                });
                $('#electricity-pane select[name=year]').val(date.getFullYear()).trigger('change');
            });
        },
        initDatatable: function () {
            $table = $page.find('#electricity-datatable');
            if ($page.find('#admin').length) {
                electricityReportPage.dtTable = $table.DataTable({
                    "aaSorting": [],
                    "processing": true,
                    "serverSide": true,
                    "searching": false,
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
                        { data: 'lwbp_cost', name: 'lwbp_cost' },
                        { data: 'wbp', name: 'wbp' },
                        { data: 'wbp_total', name: 'wbp_total' },
                        { data: 'wbp_cost', name: 'wbp_cost' },
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
            } else {
                electricityReportPage.dtTable = $table.DataTable({
                    "aaSorting": [],
                    "processing": true,
                    "serverSide": true,
                    "searching": false,
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
                        { data: 'lwbp_cost', name: 'lwbp_cost' },
                        { data: 'wbp', name: 'wbp' },
                        { data: 'wbp_total', name: 'wbp_total' },
                        { data: 'wbp_cost', name: 'wbp_cost' },
                        { data: 'cost_total', name: 'cost_total' },
                        { data: 'occupancy', name: 'occupancy' },
                        { data: 'electricity_per_room', name: 'electricity_per_room' },
                        { data: 'month_to_date_cost', name: 'month_to_date_cost' },
                    ],
                    "columnDefs": [
                        { targets: 'no-sort', orderable: false },
                        { targets: 'no-search', searchable: false },
                        { targets: 'text-center', className: 'text-center' },
                    ]
                });
            }
        },
    };

    var gasReportPage = {
        dtTable: {},
        init: function () {
            this.initSelect2();
            this.customFunction();
            this.initDatatable();
        },
        customFunction: function () {
            var data_id = null;

            $('#gas-pane select[name="month"], #gas-pane select[name="year"]').on('select2:select', function () {
                gasReportPage.dtTable.ajax.reload();
            });

            $(document).on('click', '.edit-gas', function () {
                data_id = $(this).attr('data-id');
                $.get('/gas/' + data_id)
                    .done(function (response) {
                        $('#edit-gas-record-form input[name=lpg]').val(response.value);
                        $('#editGasModal').modal('show');
                    });
            });

            $('#edit-gas-record-form').on('submit', function (e) {
                e.preventDefault();
                let data = $(this).serializeArray();
                $.ajax({
                    url: '/gas/' + data_id,
                    data: data,
                    type: 'PUT',
                    success: function (response) {
                        if (response.status == 200) {
                            $(this).find("input, textarea").val('');
                            gasReportPage.dtTable.ajax.reload(null, false);
                            $('button.close').click();
                            swal(
                                "Success!",
                                "Report has been updated!",
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
        },
        initSelect2: function () {
            $('#gas-pane select[name=month]').select2({
                placeholder: '-- Please Select --',
            });
            $.post('/ajax/energy', { mode: 'select2', type: 'gas' })
            .done(function (response) {
                let date = new Date();
                $('#gas-pane select[name=year]').select2({
                    data: response
                });
                $('#gas-pane select[name=year]').val(date.getFullYear()).trigger('change');
            });
        },
        initDatatable: function () {
            $table = $page.find('#gas-datatable');
            if($page.find('#admin').length) {
                gasReportPage.dtTable = $table.DataTable({
                    "aaSorting": [],
                    "processing": true,
                    "serverSide": true,
                    "searching": false,
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
                        { data: 'day', name: 'day' },
                        { data: 'value', name: 'value' },
                        { data: 'consumption', name: 'consumption' },
                        { data: 'cost', name: 'cost' },
                        { data: 'month_to_date', name: 'month_to_date' },
                        { data: 'action', name: 'action' },
                    ],
                    "columnDefs": [
                        { targets: 'no-sort', orderable: false },
                        { targets: 'no-search', searchable: false },
                        { targets: 'text-center', className: 'text-center' },
                    ]
                });
            } else {
                gasReportPage.dtTable = $table.DataTable({
                    "aaSorting": [],
                    "processing": true,
                    "serverSide": true,
                    "searching": false,
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
                        { data: 'day', name: 'day' },
                        { data: 'value', name: 'value' },
                        { data: 'consumption', name: 'consumption' },
                        { data: 'cost', name: 'cost' },
                        { data: 'month_to_date', name: 'month_to_date' },
                    ],
                    "columnDefs": [
                        { targets: 'no-sort', orderable: false },
                        { targets: 'no-search', searchable: false },
                        { targets: 'text-center', className: 'text-center' },
                    ]
                });
            }
        },
    };

    var waterReportPage = {
        dtTable: {},
        init: function () {
            this.initSelect2();
            this.customFunction();
            this.initDatatable();
        },
        customFunction: function () {
            var data_id = null;

            $('#water-pane select[name="month"], #water-pane select[name="year"]').on('select2:select', function () {
                waterReportPage.dtTable.ajax.reload();
            });

            $(document).on('click', '.edit-water', function () {
                data_id = $(this).attr('data-id');
                $.get('/water/' + data_id)
                    .done(function (response) {
                        $('#edit-water-record-form input[name=pdam]').val(response.pdam);
                        $('#edit-water-record-form input[name=deep_well]').val(response.deep_well);
                        $('#edit-water-record-form input[name=occupancy]').val(response.occupancy);
                        $('#editWaterModal').modal('show');
                    });
            });

            $('#edit-water-record-form').on('submit', function (e) {
                e.preventDefault();
                let data = $(this).serializeArray();
                $.ajax({
                    url: '/water/' + data_id,
                    data: data,
                    type: 'PUT',
                    success: function (response) {
                        if (response.status == 200) {
                            $(this).find("input, textarea").val('');
                            waterReportPage.dtTable.ajax.reload(null, false);
                            $('button.close').click();
                            swal(
                                "Success!",
                                "Report has been updated!",
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
        },
        initSelect2: function () {
            $('#water-pane select[name=month]').select2({
                placeholder: '-- Please Select --',
            });
            $.post('/ajax/energy', { mode: 'select2', type: 'water' })
            .done(function (response) {
                let date = new Date();
                $('#water-pane select[name=year]').select2({
                    data: response
                });
                $('#water-pane select[name=year]').val(date.getFullYear()).trigger('change');
            });
        },
        initDatatable: function () {
            $table = $page.find('#water-datatable');
            if($page.find('#admin').length) {
                waterReportPage.dtTable = $table.DataTable({
                    "aaSorting": [],
                    "processing": true,
                    "serverSide": true,
                    "searching": false,
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
                        { data: 'pdam_consumption', name: 'pdam_consumption' },
                        { data: 'pdam_cost', name: 'pdam_cost' },
                        { data: 'pdam_month_to_date', name: 'pdam_month_to_date' },
                        { data: 'deep_well', name: 'deep_well' },
                        { data: 'deep_well_consumption', name: 'deep_well_consumption' },
                        { data: 'deep_well_cost', name: 'deep_well_cost' },
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
            } else {
                waterReportPage.dtTable = $table.DataTable({
                    "aaSorting": [],
                    "processing": true,
                    "serverSide": true,
                    "searching": false,
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
                        { data: 'pdam_consumption', name: 'pdam_consumption' },
                        { data: 'pdam_cost', name: 'pdam_cost' },
                        { data: 'pdam_month_to_date', name: 'pdam_month_to_date' },
                        { data: 'deep_well', name: 'deep_well' },
                        { data: 'deep_well_consumption', name: 'deep_well_consumption' },
                        { data: 'deep_well_cost', name: 'deep_well_cost' },
                        { data: 'occupancy', name: 'occupancy' },
                        { data: 'water_per_room', name: 'water_per_room' },
                    ],
                    "columnDefs": [
                        { targets: 'no-sort', orderable: false },
                        { targets: 'no-search', searchable: false },
                        { targets: 'text-center', className: 'text-center' },
                    ]
                });
            }
        },
    };

    if($page.length) {
        energyPage.init();
        electricityReportPage.init();
        gasReportPage.init();
        waterReportPage.init();
    }
});
