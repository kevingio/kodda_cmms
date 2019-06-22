$(document).ready(function () {
    var $page = $('#work-report-page');

    var workReportPage = {
        dtTable: {},
        init: function () {
            this.initDatatable();
            this.customFunction();
		},
        customFunction: function () {
            var data_id = null;

            $('#add-record-form').on('submit', function (e) {
                e.preventDefault();
                var data = $(this).serializeArray();
                console.log(data);
                $.post('/work-report', data)
                .done(function () {
                    swal({
                        title: "Success!",
                        text: "You won't be able to revert this!",
                        type: "success",
                        showCancelButton: false,
                        confirmButtonClass: 'btn btn-success',
                    }).then(function () {
                        window.location.href = '/work-report';
                    })
                });
            });

            $(document).on('click', '.info', function () {
                data_id = $(this).attr('data-id');
                $.get('work-report/' + data_id)
                .done(function (response) {
                    $('#detailModal strong[name=name]').text(response.user.name);
                    $('#detailModal strong[name=department]').text(response.user.job.department.name);
                    $('#detailModal strong[name=job]').text(response.user.job.title);
                    $('#detailModal strong[name=work_date]').text(response.work_date);
                    $('#detailModal strong[name=activity]').text(response.activity);
                    $('#detailModal strong[name=submitted]').text(response.created_at);
                    $('#detailModal').modal('show');
                });
            });

        },
        initDatatable: function () {
			$table = $page.find('#work-report-datatable');
			workReportPage.dtTable = $table.DataTable({
				"aaSorting": [],
		        "processing": true,
	            "serverSide": true,
	            "searching": true,
	            "lengthChange": false,
                "responsive": true,
	            "ajax": {
	                url: "/ajax/work-report",
	                type: "POST",
	                data: function (d) { d.mode = 'datatable'; }
	            },
		        "columns": [
		            { data: 'name', name: 'name' },
		            { data: 'department', name: 'department' },
		            { data: 'job', name: 'job' },
                    { data: 'work_date', name: 'work_date' },
		            { data: 'created_at', name: 'created_at' },
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
        workReportPage.init();
    }
});
