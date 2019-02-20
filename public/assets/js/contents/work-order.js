$(document).ready(function () {
    var $page = $('#work-order-page');

    var workOrderPage = {
        dtTable: {},
        dtTableInventory: {},
        dataSetInventory: [],
        init: function () {
            this.initSelect2();
            this.initDatepicker();
            this.validateTime();
            this.customFunction();
            this.initDatatable();
            this.initDatatableInventory();
            this.inventory();
            this.imageDetail();
		},
        customFunction: function () {
            let self = this;
            var data_id = null;

            $(document).on('change', 'select[name=type]', function () {
				workOrderPage.dtTable.ajax.reload();
			});

            $('.add-work-order').on('click', function () {
                $('#addModal').modal('show');
            });

            $('input[name=image]').on('change', function () {
                self.readURL(this);
            });

            $(document).on('click', '.info', function () {
                data_id = $(this).attr('data-id');
                $.get('/work-order/' + data_id)
                .done(function (response) {
                    $('#detailModal h5').text(response.task);
                    $('#detailModal strong[name=co_workers]').text(response.engineers_in_string != '' ? response.engineers_in_string : '-');
                    $('#detailModal strong[name=assignor]').text(response.assignor.name);
                    $('#detailModal strong[name=location]').text(response.location.area + '-' + response.location.floor.description);
                    $('#detailModal strong[name=due_date]').text(response.due_date_formatted);
                    $('#detailModal span[name=status]').text(response.status);
                    $('#detailModal strong[name=comment]').text(response.comment ? response.comment : '-');
                    if(response.image) {
                        $('#detailModal img').attr('src', response.image);
                        $('#image-preview-detail').show();
                    } else {
                        $('#image-preview-detail').hide();
                    }
                    $('#detailModal').modal('show');
                });
            });

            $('#edit-record-form select[name=status]').on('select2:select', function () {
                let data = $(this).val();
                workOrderPage.dataSetInventory = [];
                workOrderPage.dtTableInventory.clear().rows.add(workOrderPage.dataSetInventory).draw(false);
                if(data == 'completed') {
                    $('#inventory-section').show(500);
                } else {
                    $('#inventory-section').hide(300);
                }
            });

            $('#add-record-form').on('submit', function (e) {
                e.preventDefault();
                var formData = new FormData(this);
                $.ajax({
                    url: "/work-order",
                    type: "POST",
                    data:  formData,
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: (response) => {
                        $(this).find("input[name!=due_date], textarea").val('');
                        $('#add-record-form select').val('low').trigger('change');

                        var waiting = (response['waiting-for-part'] ? response['waiting-for-part'] : 0) + (response['waiting-for-quotation'] ? response['waiting-for-quotation'] : 0)
                        $('#not-started').text(response['not-started'] ? response['not-started'] : 0);
                        $('#in-progress').text(response['in-progress'] ? response['in-progress'] : 0);
                        $('#waiting').text(waiting);
                        $('#completed').text(response['completed'] ? response['completed'] : 0);
                        $('#add-record-form img').attr('src', 'assets/images/default-photo.png');
                        $('button.close').click();
                        workOrderPage.dtTable.ajax.reload(null, false);
                        swal(
                            "Success!",
                            "Work order has been updated!",
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

            $(document).on('click', '.finish', function () {
                data_id = $(this).attr('data-id');
                $.get('/work-order/' + data_id).
                done(function (response) {
                    $('#edit-record-form select[multiple]').val(response.engineers).trigger('change');
                    $('#edit-record-form select[name=status]').val(response.status).trigger('change');
                    $('#edit-record-form textarea[name=comment]').val(response.comment);
                    $('select[alt=inventory_name]').val(null).trigger('change');
                    $('#editModal').modal('show');
                });
            });

            $('#edit-record-form').on('submit', function (e) {
                e.preventDefault();
                var formData = new FormData(this);
                formData.append('_method', 'PATCH');
                formData.append('inventories', JSON.stringify(workOrderPage.dataSetInventory));
                $.ajax({
                    url: "/work-order/" + data_id,
                    type: "POST",
                    data:  formData,
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: (response) => {
                        console.log(response);
                        $(this).find("input").val('');
                        $('#edit-record-form select[multiple]').val(null).trigger('change');
                        $('#edit-record-form select[name=status]').val(1).trigger('change');
                        var waiting = (response['waiting-for-part'] ? response['waiting-for-part'] : 0) + (response['waiting-for-quotation'] ? response['waiting-for-quotation'] : 0)
                        $('#not-started').text(response['not-started'] ? response['not-started'] : 0);
                        $('#in-progress').text(response['in-progress'] ? response['in-progress'] : 0);
                        $('#waiting').text(waiting);
                        $('#completed').text(response['completed'] ? response['completed'] : 0);
                        $('#inventory-section').hide();
                        $('select[alt=inventory_name]').val(null).trigger('change');
                        $('button.close').click();
                        workOrderPage.dtTable.ajax.reload(null, false);
                        swal(
                            "Success!",
                            "Work order has been updated!",
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
                            url: '/work-order/' + data_id,
                            type: 'DELETE',
                            success: function(response) {
                                var waiting = (response['waiting-for-part'] ? response['waiting-for-part'] : 0) + (response['waiting-for-quotation'] ? response['waiting-for-quotation'] : 0)
                                $('#not-started').text(response['not-started'] ? response['not-started'] : 0);
                                $('#in-progress').text(response['in-progress'] ? response['in-progress'] : 0);
                                $('#waiting').text(waiting);
                                $('#completed').text(response['completed'] ? response['completed'] : 0);
                                workOrderPage.dtTable.ajax.reload(null, false);
                                swal(
                                    "Success!",
                                    "Work order has been deleted!",
                                    "success"
                                );
                            }
                        });
                    }
                }).catch(swal.noop);
            });
        },
        inventory: function () {
            var data;

            // init select2
            $('select[alt=inventory_name]').select2({
                placeholder: '-- Please Select --',
                width: '100%',
                ajax: {
                    url: '/ajax/inventory',
                    method: "POST",
                    dataType: 'json',
                    data: function (params) {
                        return {
                            search: params.term,
                            mode: 'select2'
                        }
                    },
                    processResults: function(data) {
                        return {
                            results: data
                        }
                    },
                    cache: true
                },
                minimumInputLength: 2,
                dropdownParent: $('#editModal .modal-content')
            });

            $('#inventory-form select').on('select2:select', function () {
                let data = $('select[alt=inventory_name]').select2('data')[0];
                stock = data.qty;
                var diff = stock;
                workOrderPage.dataSetInventory.forEach(function (item) {
                    if(item.id == data.id) {
                        diff = data.qty - item.qty;
                    }
                });
                $('input[alt=qty]').attr('max', stock).attr('placeholder', diff).focus();
            });

            $(document).on('click', '.remove', function () {
                let id = $(this).attr('data');
                workOrderPage.dataSetInventory = workOrderPage.dataSetInventory.filter(function(value, index, arr){
                    return value.id != id;
                });
                workOrderPage.dtTableInventory.clear().rows.add(workOrderPage.dataSetInventory).draw(false);
            });

            $('#inventory-form button').on('click', function () {
                if($('input[alt=qty]').val() != '' && $('input[alt=qty]').val()) {
                    var id = $('select[alt=inventory_name]').val();
                    var name = $('select[alt=inventory_name] option:selected').text();
                    var qty = $('input[alt=qty]').val();

                    $('select[alt=inventory_name]').val(1).trigger('change');
                    $('input[alt=qty]').val('').attr('placeholder', '');

                    let temp = {
                        id: id,
                        name: name,
                        qty: qty,
                        action: '<button type="button" class="btn btn-sm btn-danger remove" data="' + id + '"><span>&times;</span></button>'
                    };
                    addItem(temp);
                    workOrderPage.dtTableInventory.clear().rows.add(workOrderPage.dataSetInventory).draw(false);
                } else {
                    $('input[alt=qty]').focus();
                }
            });

            $('input[alt=qty]').on('keyup', function (e) {
                if(e.keyCode === 13) {
                    e.preventDefault();
                    $('#inventory-form button').click();
                } else {
                    if($('input[alt=qty]').val() > stock) {
                        $('input[alt=qty]').val(stock)
                    }
                }
            });

            function addItem(value) {
                var flag = 1;
                workOrderPage.dataSetInventory.forEach((item) => {
                    if(item.id == value.id) {
                        item.qty = parseInt(item.qty) + parseInt(value.qty);
                        flag = null;
                    }
                });
                if(flag) {
                    workOrderPage.dataSetInventory.push(value);
                }
                $('select[alt=inventory_name]').val(null).trigger('change');
            }
        },
        imageDetail: function () {
            $(document).on('click', 'img[alt=thumbnail]', function () {
                $('#imageModal img').attr('src', $(this).attr('src'));
                $('#imageModal').modal('show');
            });
        },
        validateTime: function () {
            $(document).on('keyup', 'input[name=time]', function() {
                var val = ($(this).val()).split(':');
                if(val.length == 2) {
                    val.forEach((item) => {
                        if(!item.match('/^\d+$/') || item == '') {
                            $(this).addClass('bcolor-danger');
                        }
                    });
                    if(val[1] != '' && val[1].length == 2) {
                        if(val[0] <= 23 && val[0] >= 0 && val[1] >= 0 && val[1] <= 59) {
                            $(this).removeClass('bcolor-danger');
                        } else {
                            $(this).addClass('bcolor-danger');
                        }
                    }
                } else {
                    $(this).addClass('bcolor-danger');
                }
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
        initDatepicker: function () {
            $('input[name=due_date]').datepicker({
                autoclose: true,
            });
            $('input[name=due_date]').datepicker('setDate', 'today');
        },
        readURL: function (input) {
			if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $(input).siblings('img').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
			}
		},
        initDatatable: function () {
			$table = $page.find('#work-order-datatable');
			workOrderPage.dtTable = $table.DataTable({
				"aaSorting": [],
		        "processing": true,
	            "serverSide": true,
	            "searching": true,
	            "lengthChange": false,
                "responsive": true,
                "dom": '<"toolbar">frtip',
	            "ajax": {
	                url: "/ajax/work-order",
	                type: "POST",
	                data: function (d) { d.mode = 'datatable'; d.type = $('select[name=type]').val(); }
	            },
		        "columns": [
		            { data: 'task', name: 'task' },
		            { data: 'location', name: 'location' },
		            { data: 'priority', name: 'priority' },
                    { data: 'status', name: 'status' },
                    { data: 'due_date', name: 'due_date' },
                    { data: 'action', name: 'action' },
		        ],
		        "columnDefs": [
	                { targets: 'no-sort', orderable: false },
	                { targets: 'no-search', searchable: false },
					{ targets: 'text-center', className: 'text-center' },
	            ],
		    });

            $('div.toolbar').html('<select class="form-control" name="type"><option value="today">Today</option><option value="history">History</option></select>');
		},
        initDatatableInventory: function () {
			workOrderPage.dtTableInventory = $('#inventory-datatable').DataTable({
                "ordering": false,
                "paging": false,
	            "searching": false,
                "responsive": true,
	            "data": workOrderPage.dataSetInventory,
		        "columns": [
		            { data: 'name', name: 'name' },
		            { data: 'qty', name: 'qty' },
		            { data: 'action', name: 'action' },
		        ],
		        "columnDefs": [
	                { targets: 'no-sort', orderable: false },
	                { targets: 'no-search', searchable: false },
					{ targets: 'text-center', className: 'text-center' },
	            ],
            })
		}
    };

    if($page.length) {
        workOrderPage.init();
    }
});
