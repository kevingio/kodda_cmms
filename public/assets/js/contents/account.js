$(document).ready(function () {
    var $page = $('#account-page');

    var accountPage = {
        dtTable: {},
        init: function () {
            this.initDatatable();
            this.initSelect2();
            this.customFunction();
            this.showHidePassword();
            this.showAvatar();
		},
        showHidePassword: function () {
            $(document).on('click', '.input-group-text', function () {
                if($(this).parent().siblings('input').attr('type') == 'password') {
                    $(this).parent().siblings('input').attr('type', 'text');
                    $(this).find('i').attr('class', 'mdi mdi-eye');
                } else {
                    $(this).parent().siblings('input').attr('type', 'password');
                    $(this).find('i').attr('class', 'mdi mdi-eye-off');
                }
            });
        },
        showAvatar: function () {
            $(document).on('click', 'img[alt=user-image]', function () {
                $('#avatarModal img').attr('src', $(this).attr('src'));
                $('#avatarModal').modal('show');
            });
        },
        customFunction: function () {
            var data_id = null;

            $(document).on('click', '.add', function () {
                $('#addModal').modal('show');
                $('#add-record-form').on('submit', function (e) {
                    e.preventDefault();
                    var data = $(this).serializeArray();
                    $(this).find("input, textarea").val('');
                    $.post('/account', data)
                    .done(function () {
                        $('button.close').click();
                        $('#add-record-form select').val(1).trigger('change');
    					accountPage.dtTable.ajax.reload(null, false);
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
                $.get('account/' + data_id)
                .done(function (response) {
                    $('#edit-record-form input[name=name]').val(response.name);
                    $('#edit-record-form input[name=username]').val(response.username);
                    $('#edit-record-form input[name=email]').val(response.email);
                    $('#edit-record-form input[name=contact]').val(response.contact);

                    $('#edit-record-form select[name=department_id]').val(response.department_id).trigger('change');
                    $('#edit-record-form select[name=job_id]').val(response.job_id).trigger('change');
                    $('#edit-record-form select[name=role_id]').val(response.role_id).trigger('change');
                    $('#editModal').modal('show');
                });
            });

            $('#edit-record-form').on('submit', function (e) {
                e.preventDefault();
                var data = $(this).serializeArray();
                $.ajax({
                    url: '/account/' + data_id,
                    data: data,
                    type: 'PUT',
                    success: function(response) {
                        if(response.status == 200) {
                            $(this).find("input, textarea").val('');
                            $('#edit-record-form select').val(1).trigger('change');
                            $('button.close').click();
                            swal(
                                "Success!",
                                "Data has been edited!",
                                "success"
                            );
                            accountPage.dtTable.ajax.reload(null, false);
                        }
                    },
                    error: function () {
                        swal(
                            "Oops!",
                            "Something went wrong!",
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
                            url: '/account/' + data_id,
                            type: 'DELETE',
                            success: function(response) {
                                accountPage.dtTable.ajax.reload(null, false);
                                swal(
                                    "Success!",
                                    "User has been deleted!",
                                    "success"
                                );
                            }
                        });
                    } else {
                        swal(
                            "Oops!",
                            "Something went wrong!",
                            "error"
                        );
                    }
                }).catch(swal.noop);
            });

            $(document).on('click', '.reset', function () {
                data_id = $(this).attr('data-id');
                $('#reset-password-form input').val('');
                $('#reset-password-form .error-msg').addClass('d-none');
                $('#resetModal').modal('show');
            });

            $('#reset-password-form').on('submit', function (e) {
                e.preventDefault();
                var data = $(this).serializeArray();
                data.push({ name: '_method', value: 'PATCH' });
                $.ajax({
                    url: '/change-password/' + data_id,
                    data: data,
                    type: 'POST',
                    success: function (response) {
                        if (response.status == 200) {
                            $(this).find("input, textarea").val('');
                            $('button.close').click();
                            swal(
                                "Success!",
                                "Password has been reset!",
                                "success"
                            );
                        }
                    },
                    error: function () {
                        swal(
                            "Oops!",
                            "Something went wrong!",
                            "error"
                        );
                    }
                });
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
			$table = $page.find('#account-datatable');
			accountPage.dtTable = $table.DataTable({
				"aaSorting": [],
		        "processing": true,
	            "serverSide": true,
	            "searching": true,
	            "lengthChange": false,
                "responsive": true,
	            "ajax": {
	                url: "/ajax/account",
	                type: "POST",
	                data: function (d) { d.mode = 'datatable'; }
	            },
		        "columns": [
		            { data: 'name', name: 'name' },
		            { data: 'department', name: 'department' },
		            { data: 'job', name: 'job' },
                    { data: 'contact', name: 'contact' },
                    { data: 'role', name: 'role' },
		            { data: 'updated_at', name: 'updated_at' },
		            { data: 'action', name: 'action' },
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
        accountPage.init();
    }
});
