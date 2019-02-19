$(document).ready(function () {
    var $page = $('#inventory-page');

    var inventoryPage = {
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
                    var formData = new FormData(this);
                    $.ajax({
                        url: "/inventory",
                        type: "POST",
                        data:  formData,
                        contentType: false,
                        cache: false,
                        processData: false,
                        success: (response) => {
                            $(this).find("input").val('');
                            $('button.close').click();
        					inventoryPage.dtTable.ajax.reload(null, false);
        					swal(
                                "Success!",
        						"Data has been added!",
        						"success"
                            );
                        },
                        error: function(response) {
                            swal(
                                "Oops!",
                                "Something went wrong, please refresh the page!",
                                "error"
                            );
                        }
                    });
                });
            });

            $(document).on('click', '.edit', function () {
                data_id = $(this).attr('data-id');
                $.get('inventory/' + data_id)
                .done(function (response) {
                    $('#edit-record-form input[name=name]').val(response.name);
                    $('#edit-record-form select[name=inventory_model_id]').val(response.inventory_model_id).trigger('change');
                    $('#edit-record-form input[name=qty]').val(response.qty);
                    $('#edit-record-form input[name=min_stock]').val(response.min_stock);
                    $('#editModal').modal('show');
                });
            });

            $('#edit-record-form').on('submit', function (e) {
                e.preventDefault();
                var formData = new FormData(this);
                formData.append('_method', 'PATCH');
                $.ajax({
                    url: "/inventory/" + data_id,
                    type: "POST",
                    data:  formData,
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: (response) => {
                        $(this).find("input, textarea").val('');
                        $('button.close').click();
                        inventoryPage.dtTable.ajax.reload(null, false);
                        swal(
                            "Success!",
                            "Data has been edited!",
                            "success"
                        );
                    },
                    error: function(response) {
                        swal(
                            "Oops!",
                            "Something went wrong, please refresh the page!",
                            "error"
                        );
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
                            url: '/inventory/' + data_id,
                            type: 'DELETE',
                            success: function(response) {
                                inventoryPage.dtTable.ajax.reload(null, false);
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
			$table = $page.find('#inventory-datatable');
			inventoryPage.dtTable = $table.DataTable({
				"aaSorting": [],
		        "processing": true,
	            "serverSide": true,
	            "searching": true,
	            "lengthChange": false,
                "responsive": true,
	            "ajax": {
	                url: "/ajax/inventory",
	                type: "POST",
	                data: function (d) { d.mode = 'datatable'; }
	            },
		        "columns": [
		            { data: 'name', name: 'name' },
		            { data: 'model', name: 'model' },
		            { data: 'qty', name: 'qty' },
                    { data: 'min_stock', name: 'min_stock' },
                    { data: 'status', name: 'status' },
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
        inventoryPage.init();
    }
});
