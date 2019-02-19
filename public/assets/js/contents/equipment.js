$(document).ready(function () {
    var $page = $('#equipment-page');

    var equipmentPage = {
        dtTable: {},
        init: function () {
            this.initDatatable();
            this.initSelect2();
            this.customFunction();
		},
        customFunction: function () {
            var data_id = null;

            $(document).on('click', '.add', function () {
                $('#addModal').modal('show');
                $('#add-record-form').on('submit', function (e) {
                    e.preventDefault();
                    var data = $(this).serializeArray();
                    $(this).find("input, textarea").val('');
                    $.post('/equipment', data)
                    .done(function () {
                        $('button.close').click();
    					equipmentPage.dtTable.ajax.reload(null, false);
    					swal(
                            "Success!",
    						"Data has been added!",
    						"success"
                        );
                    });
                });
            });

            $(document).on('click', '.edit', function () {
                data_id = $(this).attr('data-id');
                $.get('equipment/' + data_id)
                .done(function (response) {
                    $('#edit-record-form select[name=equipment_model_id]').val(response.equipment_model_id).trigger('change');
                    $('#edit-record-form input[name=manufacturer]').val(response.manufacturer);
                    $('#edit-record-form textarea[name=description]').val(response.description);
                    $('#edit-record-form select[name=location_id]').val(response.location_id).trigger('change');
                    $('#edit-record-form input[name=maintenance_period]').val(response.maintenance_period);
                    $('#edit-record-form input[name=contact]').val(response.contact);
                    $('#editModal').modal('show');
                });
            });

            $('#edit-record-form').on('submit', function (e) {
                e.preventDefault();
                var data = $(this).serializeArray();
                $.ajax({
                    url: '/equipment/' + data_id,
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
                            equipmentPage.dtTable.ajax.reload(null, false);
                        }
                    }
                });
            });

            $(document).on('click', '.delete', function () {
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
                            url: '/equipment/' + data_id,
                            type: 'DELETE',
                            success: function(response) {
                                equipmentPage.dtTable.ajax.reload(null, false);
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
            $('#add-record-form select').select2({
                dropdownParent: $('#addModal')
            });

            $('#edit-record-form select').select2({
                dropdownParent: $('#editModal')
            });
        },
        initDatatable: function () {
			$table = $page.find('#equipment-datatable');
			equipmentPage.dtTable = $table.DataTable({
				"aaSorting": [],
		        "processing": true,
	            "serverSide": true,
	            "searching": true,
	            "lengthChange": false,
                "responsive": true,
	            "ajax": {
	                url: "/ajax/equipment",
	                type: "POST",
	                data: function (d) { d.mode = 'datatable'; }
	            },
		        "columns": [
                    { data: 'serial_number', name: 'serial_number' },
		            { data: 'model', name: 'model' },
		            { data: 'manufacturer', name: 'manufacturer' },
                    { data: 'description', name: 'description' },
                    { data: 'location', name: 'location' },
                    { data: 'maintenance_period', name: 'maintenance_period' },
                    { data: 'contact', name: 'contact' },
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
        equipmentPage.init();
    }
});
