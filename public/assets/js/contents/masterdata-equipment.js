$(document).ready(function () {
    var $page = $('#masterdata-equipment-page');

    var masterDataEquipmentPage = {
        dtTable: {},
        init: function () {
            this.initDatatable();
            this.customFunction();
		},
        customFunction: function () {
            var data_id = null;

            $(document).on('click', '.add-model', function () {
                $('#addModelModal').modal('show');
                $('#add-model-record-form').on('submit', function (e) {
                    e.preventDefault();
                    var data = $(this).serializeArray();
                    $(this).find("input, textarea").val('');
                    $('#add-model-record-form select').val('1').trigger('change');
                    $.post('/master-data/equipment-model', data)
                    .done(function () {
                        $('button.close').click();
    					masterDataEquipmentPage.dtTable.ajax.reload(null, false);
    					swal(
                            "Success!",
    						"Data has been added!",
    						"success"
                        );
                    });
                });
            });

            $(document).on('click', '.edit-model', function () {
                data_id = $(this).attr('data-id');
                $.get('/master-data/equipment-model/' + data_id)
                .done(function (response) {
                    $('#edit-model-record-form input[name=name]').val(response.name);
                    $('#editModelModal').modal('show');
                });
            });

            $('#edit-model-record-form').on('submit', function (e) {
                e.preventDefault();
                var data = $(this).serializeArray();
                $.ajax({
                    url: '/master-data/equipment-model/' + data_id,
                    data: data,
                    type: 'PUT',
                    success: function(response) {
                        if(response.status == 200) {
                            $(this).find("input, textarea").val('');
                            $('button.close').click();
                            swal(
                                "Success!",
                                "Data has been edited!",
                                "success"
                            );
                            masterDataEquipmentPage.dtTable.ajax.reload(null, false);
                        }
                    }
                });
            });

            $(document).on('click', '.delete-model', function () {
                data_id = $(this).attr('data-id');
                swal({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'No, cancel!',
                    confirmButtonClass: 'btn btn-danger btn-lg',
                    cancelButtonClass: 'btn btn-primary btn-lg m-l-10',
                    buttonsStyling: false
                }).then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            url: '/master-data/equipment-model/' + data_id,
                            type: 'DELETE',
                            success: function(response) {
                                masterDataEquipmentPage.dtTable.ajax.reload(null, false);
                                swal(
                                    "Success!",
                                    "Data has been deleted!",
                                    "success"
                                );
                            }
                        });
                    }
                }).catch(swal.noop);
            });
        },
        initDatatable: function () {
			$table = $page.find('#equipment-datatable');
			masterDataEquipmentPage.dtTable = $table.DataTable({
                "pageLength": 4,
				"aaSorting": [],
		        "processing": true,
	            "serverSide": true,
	            "searching": true,
	            "lengthChange": false,
                "responsive": true,
	            "ajax": {
	                url: "/ajax/equipment-model",
	                type: "POST",
	                data: function (d) { d.mode = 'datatable'; }
	            },
		        "columns": [
		            { data: 'name', name: 'name' },
		            { data: 'action', name: 'action' },
		        ],
		        "columnDefs": [
	                { targets: 'no-sort', orderable: false },
	                { targets: 'no-search', searchable: false },
					{ targets: 'text-center', className: 'text-center' },
	            ]});
		}
    };

    var masterDataMaintenancePage = {
        dtTable: {},
        init: function () {
            this.initDatatable();
            this.initSelect2();
            this.customFunction();
		},
        customFunction: function () {
            $(document).on('click', '.add-maintenance', function () {
                $('#addMaintenanceModal').modal('show');
                $('#add-maintenance-record-form').on('submit', function (e) {
                    e.preventDefault();
                    var data = $(this).serializeArray();
                    $(this).find("input, textarea").val('');
                    $('#add-maintenance-record-form select').val('1').trigger('change');
                    $.post('/master-data/maintenance-task', data)
                    .done(function () {
                        $('button.close').click();
    					masterDataMaintenancePage.dtTable.ajax.reload(null, false);
    					swal(
                            "Success!",
    						"Data has been added!",
    						"success"
                        );
                    });
                });
            });

            $(document).on('click', '.edit-maintenance', function () {
                var data_id = $(this).attr('data-id');
                $.get('/master-data/maintenance-task/' + data_id)
                .done(function (response) {
                    $('#edit-maintenance-record-form textarea[name=task]').val(response.task);
                    $('#edit-maintenance-record-form select').val(response.inventory_model_id).trigger('change');
                    $('#editMaintenanceModal').modal('show');
                });

                $('#edit-maintenance-record-form').on('submit', function (e) {
                    e.preventDefault();
                    var data = $(this).serializeArray();
                    $.ajax({
    					url: '/master-data/maintenance-task/' + data_id,
    					data: data,
    					type: 'PUT',
    					success: function(response) {
    						if(response.status == 200) {
                                $(this).find("input, textarea").val('');
                                $('#edit-maintenance-record-form select').val('1').trigger('change');
        						$('button.close').click();
                                swal(
                                    "Success!",
            						"Data has been edited!",
            						"success"
                                );
        						masterDataMaintenancePage.dtTable.ajax.reload(null, false);
                            }
    					}
    				});
                });
            });

            $(document).on('click', '.delete-maintenance', function () {
                var data_id = $(this).attr('data-id');
                swal({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'No, cancel!',
                    confirmButtonClass: 'btn btn-danger btn-lg',
                    cancelButtonClass: 'btn btn-primary btn-lg m-l-10',
                    buttonsStyling: false
                }).then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            url: '/master-data/maintenance-task/' + data_id,
                            type: 'DELETE',
                            success: function(response) {
                                masterDataMaintenancePage.dtTable.ajax.reload(null, false);
                                swal(
                                    "Success!",
                                    "Data has been deleted!",
                                    "success"
                                );
                            }
                        });
                    }
                }).catch(swal.noop);
            });
        },
        initSelect2: function () {
            $('#add-maintenance-record-form select').select2({
                dropdownParent: $('#addMaintenanceModal')
            });

            $('#edit-maintenance-record-form select').select2({
                dropdownParent: $('#editMaintenanceModal')
            });
        },
        initDatatable: function () {
			$table = $page.find('#maintenance-datatable');
			masterDataMaintenancePage.dtTable = $table.DataTable({
				"aaSorting": [],
		        "processing": true,
	            "serverSide": true,
	            "searching": true,
	            "lengthChange": false,
                "responsive": true,
	            "ajax": {
	                url: "/ajax/maintenance-task",
	                type: "POST",
	                data: function (d) { d.mode = 'datatable'; }
	            },
		        "columns": [
		            { data: 'task', name: 'task' },
		            { data: 'model', name: 'model' },
		            { data: 'action', name: 'action' },
		        ],
		        "columnDefs": [
	                { targets: 'no-sort', orderable: false },
	                { targets: 'no-search', searchable: false },
					{ targets: 'text-center', className: 'text-center' },
	            ]
            });
		}
    };

    if($page.length) {
        masterDataEquipmentPage.init();
        masterDataMaintenancePage.init();
    }
});
