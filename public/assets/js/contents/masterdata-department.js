$(document).ready(function () {
    var $page = $('#masterdata-department-page');

    var masterDataDepartmentPage = {
        dtTable: {},
        init: function () {
            this.initDatatable();
            this.customFunction();
		},
        customFunction: function () {
            var data_id = null;

            $(document).on('click', '.add-department', function () {
                $('#addDepartmentModal').modal('show');
                $('#add-department-record-form').on('submit', function (e) {
                    e.preventDefault();
                    var data = $(this).serializeArray();
                    $(this).find("input, textarea").val('');
                    $('#add-department-record-form select').val('1').trigger('change');
                    $.post('/master-data/department', data)
                    .done(function () {
                        $('button.close').click();
    					masterDataDepartmentPage.dtTable.ajax.reload(null, false);
    					swal(
                            "Success!",
    						"Data has been added!",
    						"success"
                        );
                    });
                });
            });

            $(document).on('click', '.edit-department', function () {
                data_id = $(this).attr('data-id');
                $.get('/master-data/department/' + data_id)
                .done(function (response) {
                    $('#edit-department-record-form input[name=name]').val(response.name);
                    $('#edit-department-record-form select').val(response.department_id).trigger('change');
                    $('#editDepartmentModal').modal('show');
                });
            });

            $('#edit-department-record-form').on('submit', function (e) {
                e.preventDefault();
                var data = $(this).serializeArray();
                $.ajax({
                    url: '/master-data/department/' + data_id,
                    data: data,
                    type: 'PUT',
                    success: function(response) {
                        if(response.status == 200) {
                            $(this).find("input, textarea").val('');
                            $('#edit-department-record-form select').val('1').trigger('change');
                            $('button.close').click();
                            swal(
                                "Success!",
                                "Data has been edited!",
                                "success"
                            );
                            masterDataDepartmentPage.dtTable.ajax.reload(null, false);
                        }
                    }
                });
            });

            $(document).on('click', '.delete-department', function () {
                data_id = $(this).attr('data-id');
                swal({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'No, cancel!',
                    confirmButtonClass: 'btn btn-danger',
                    cancelButtonClass: 'btn btn-primary m-l-10',
                    buttonsStyling: false
                }).then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            url: '/master-data/department/' + data_id,
                            type: 'DELETE',
                            success: function(response) {
                                masterDataDepartmentPage.dtTable.ajax.reload(null, false);
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
			$table = $page.find('#department-datatable');
			masterDataDepartmentPage.dtTable = $table.DataTable({
                "pageLength": 4,
				"aaSorting": [],
		        "processing": true,
	            "serverSide": true,
	            "searching": true,
	            "lengthChange": false,
                "responsive": true,
	            "ajax": {
	                url: "/ajax/department",
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
	            ]
            });
		}
    };

    var masterDataJobPage = {
        dtTable: {},
        init: function () {
            this.initDatatable();
            this.initSelect2();
            this.customFunction();
		},
        customFunction: function () {
            $(document).on('click', '.add-job', function () {
                $('#addJobModal').modal('show');
                $('#add-job-record-form').on('submit', function (e) {
                    e.preventDefault();
                    var data = $(this).serializeArray();
                    $(this).find("input, textarea").val('');
                    $('#add-job-record-form select').val('1').trigger('change');
                    $.post('/master-data/job', data)
                    .done(function () {
                        $('button.close').click();
    					masterDataJobPage.dtTable.ajax.reload(null, false);
    					swal(
                            "Success!",
    						"Data has been added!",
    						"success"
                        );
                    });
                });
            });

            $(document).on('click', '.edit-job', function () {
                var data_id = $(this).attr('data-id');
                $.get('/master-data/job/' + data_id)
                .done(function (response) {
                    $('#edit-job-record-form input[name=title]').val(response.title);
                    $('#edit-job-record-form select').val(response.department_id).trigger('change');
                    $('#editJobModal').modal('show');
                });

                $('#edit-job-record-form').on('submit', function (e) {
                    e.preventDefault();
                    var data = $(this).serializeArray();
                    $.ajax({
    					url: '/master-data/job/' + data_id,
    					data: data,
    					type: 'PUT',
    					success: function(response) {
    						if(response.status == 200) {
                                $(this).find("input, textarea").val('');
                                $('#edit-job-record-form select').val('1').trigger('change');
        						$('button.close').click();
                                swal(
                                    "Success!",
            						"Data has been edited!",
            						"success"
                                );
        						masterDataJobPage.dtTable.ajax.reload(null, false);
                            }
    					}
    				});
                });
            });

            $(document).on('click', '.delete-job', function () {
                var data_id = $(this).attr('data-id');
                swal({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'No, cancel!',
                    confirmButtonClass: 'btn btn-danger',
                    cancelButtonClass: 'btn btn-primary m-l-10',
                    buttonsStyling: false
                }).then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            url: '/master-data/job/' + data_id,
                            type: 'DELETE',
                            success: function(response) {
                                masterDataJobPage.dtTable.ajax.reload(null, false);
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
            $('#add-job-record-form select').select2({
                dropdownParent: $('#addJobModal')
            });

            $('#edit-job-record-form select').select2({
                dropdownParent: $('#editJobModal')
            });
        },
        initDatatable: function () {
			$table = $page.find('#job-datatable');
			masterDataJobPage.dtTable = $table.DataTable({
				"aaSorting": [],
		        "processing": true,
	            "serverSide": true,
	            "searching": true,
	            "lengthChange": false,
	            "ajax": {
	                url: "/ajax/job",
	                type: "POST",
	                data: function (d) { d.mode = 'datatable'; }
	            },
		        "columns": [
		            { data: 'title', name: 'name' },
                    { data: 'department', name: 'department' },
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
        masterDataDepartmentPage.init();
        masterDataJobPage.init();
    }
});
