$(document).ready(function () {
    var $page = $('#masterdata-energy-page');

    var masterDataEnergyPage = {
        dtTable: {},
        init: function () {
            this.initDatatable();
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
                    $.post('/master-data/energy', data)
                    .done(function () {
                        $('button.close').click();
    					masterDataEnergyPage.dtTable.ajax.reload(null, false);
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
                $.get('/master-data/energy/' + data_id)
                .done(function (response) {
                    $('#edit-record-form input[name=name]').val(response.name);
                    $('#edit-record-form input[name=price]').val(response.price);
                    $('#edit-record-form input[name=unit]').val(response.unit);
                    $('#editModal').modal('show');
                });
            });

            $('#edit-record-form').on('submit', function (e) {
                e.preventDefault();
                var data = $(this).serializeArray();
                $.ajax({
                    url: '/master-data/energy/' + data_id,
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
                            masterDataEnergyPage.dtTable.ajax.reload(null, false);
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
                            url: '/master-data/energy/' + data_id,
                            type: 'DELETE',
                            success: function(response) {
                                masterDataEnergyPage.dtTable.ajax.reload(null, false);
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
			$table = $page.find('#energy-datatable');
			masterDataEnergyPage.dtTable = $table.DataTable({
				"aaSorting": [],
		        "processing": true,
	            "serverSide": true,
	            "searching": true,
	            "lengthChange": false,
                "responsive": true,
	            "ajax": {
	                url: "/ajax/energy",
	                type: "POST",
	                data: function (d) { d.mode = 'datatable'; }
	            },
		        "columns": [
		            { data: 'name', name: 'name' },
		            { data: 'price', name: 'price' },
		            { data: 'unit', name: 'unit' },
		            { data: 'updated_at', name: 'updated_at' },
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
        masterDataEnergyPage.init();
    }
});
