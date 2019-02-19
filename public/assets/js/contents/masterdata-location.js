$(document).ready(function () {
    var $page = $('#masterdata-location-page');

    var masterDataFloorPage = {
        dtTable: {},
        init: function () {
            this.initDatatable();
            this.customFunction();
		},
        customFunction: function () {
            var data_id = null;

            $(document).on('click', '.add-floor', function () {
                $('#addFloorModal').modal('show');
                $('#add-floor-record-form').on('submit', function (e) {
                    e.preventDefault();
                    var data = $(this).serializeArray();
                    $(this).find("input, textarea").val('');
                    $.post('/master-data/floor', data)
                    .done(function () {
                        $('button.close').click();
    					masterDataFloorPage.dtTable.ajax.reload(null, false);
    					swal(
                            "Success!",
    						"Data has been added!",
    						"success"
                        );
                    });
                });
            });

            $(document).on('click', '.edit-floor', function () {
                data_id = $(this).attr('data-id');
                $.get('/master-data/floor/' + data_id)
                .done(function (response) {
                    $('#edit-floor-record-form textarea[name=description]').val(response.description);
                    $('#editFloorModal').modal('show');
                });
            });

            $('#edit-floor-record-form').on('submit', function (e) {
                e.preventDefault();
                var data = $(this).serializeArray();
                $.ajax({
                    url: '/master-data/floor/' + data_id,
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
                            masterDataFloorPage.dtTable.ajax.reload(null, false);
                        }
                    }
                });
            });

            $(document).on('click', '.delete-floor', function () {
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
                            url: '/master-data/floor/' + data_id,
                            type: 'DELETE',
                            success: function(response) {
                                masterDataFloorPage.dtTable.ajax.reload(null, false);
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
			$table = $page.find('#floor-datatable');
			masterDataFloorPage.dtTable = $table.DataTable({
                "pageLength": 4,
				"aaSorting": [],
		        "processing": true,
	            "serverSide": true,
	            "searching": true,
	            "lengthChange": false,
                "responsive": true,
	            "ajax": {
	                url: "/ajax/floor",
	                type: "POST",
	                data: function (d) { d.mode = 'datatable'; }
	            },
		        "columns": [
		            { data: 'description', name: 'description' },
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

    var masterDataAreaPage = {
        dtTable: {},
        init: function () {
            this.initDatatable();
            this.initSelect2();
            this.customFunction();
		},
        customFunction: function () {
            var data_id = null;

            $(document).on('click', '.add-area', function () {
                $('#addAreaModal').modal('show');
                $('#add-area-record-form').on('submit', function (e) {
                    e.preventDefault();
                    var data = $(this).serializeArray();
                    $(this).find("input, textarea").val('');
                    $('#add-area-form select').val('1').trigger('change');
                    $.post('/master-data/location', data)
                    .done(function () {
                        $('button.close').click();
    					masterDataAreaPage.dtTable.ajax.reload(null, false);
    					swal(
                            "Success!",
    						"Data has been added!",
    						"success"
                        );
                    });
                });
            });

            $(document).on('click', '.edit-area', function () {
                data_id = $(this).attr('data-id');
                $.get('/master-data/location/' + data_id)
                .done(function (response) {
                    $('#edit-area-record-form input[name=area]').val(response.area);
                    $('#edit-area-record-form input[name=description]').val(response.description);
                    $('#edit-record-form select').val(response.floor_id).trigger('change');
                    $('#editAreaModal').modal('show');
                });
            });

            $('#edit-area-record-form').on('submit', function (e) {
                e.preventDefault();
                var data = $(this).serializeArray();
                $.ajax({
                    url: '/master-data/location/' + data_id,
                    data: data,
                    type: 'PUT',
                    success: function(response) {
                        if(response.status == 200) {
                            $(this).find("input, textarea").val('');
                            $('#edit-area-form select').val('1').trigger('change');
                            $('button.close').click();
                            swal(
                                "Success!",
                                "Data has been edited!",
                                "success"
                            );
                            masterDataAreaPage.dtTable.ajax.reload(null, false);
                        }
                    }
                });
            });

            $(document).on('click', '.delete-area', function () {
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
                            url: '/master-data/location/' + data_id,
                            type: 'DELETE',
                            success: function(response) {
                                masterDataAreaPage.dtTable.ajax.reload(null, false);
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
            $('select').select2({
                dropdownParent: $('#addAreaModal')
            });

            $('#edit-area-form select').select2({
                dropdownParent: $('#editAreaModal')
            });
        },
        initDatatable: function () {
			$table = $page.find('#area-datatable');
			masterDataAreaPage.dtTable = $table.DataTable({
				"aaSorting": [],
		        "processing": true,
	            "serverSide": true,
	            "searching": true,
	            "lengthChange": false,
                "responsive": true,
	            "ajax": {
	                url: "/ajax/location",
	                type: "POST",
	                data: function (d) { d.mode = 'datatable'; }
	            },
		        "columns": [
		            { data: 'area', name: 'area' },
                    { data: 'floor', name: 'floor' },
                    { data: 'description', name: 'description' },
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
        masterDataFloorPage.init();
        masterDataAreaPage.init();
    }
});
