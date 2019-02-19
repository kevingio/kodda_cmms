$(document).ready(function () {
    var $page = $('#pool-page');

    var poolPage = {
        dtTable: {},
        init: function () {
            this.initDatatable();
            this.initSelect2();
            this.initDatepicker();
            this.validateTime();
            this.customFunction();
        },
        customFunction: function () {
            var data_id = null;

            $(document).on('click', '.add', function () {
                $('#addModal').modal('show');
                $('#add-record-form').on('submit', function (e) {
                    e.preventDefault();
                    var data = $(this).serializeArray();
                    $(this).find("input").val('');
                    $.post('/pool-management', data)
                    .done(function (response) {
                        $('#cl-value').text(response.cl);
                        $('#ph-value').text(response.ph);
                        $('#remark').text(response.remark == '' ? '-' : response.remark);

                        let cl_card = $('#cl-card');
                        cl_card.removeClass('bg-success').removeClass('bg-danger');
                        if(response.cl <= 3) {
                            cl_card.addClass('bg-success');
                        } else {
                            cl_card.addClass('bg-danger');
                        }

                        let ph_card = $('#ph-card');
                        ph_card.removeClass('bg-success').removeClass('bg-danger');
                        if(response.ph >= 7.6 && response.ph <= 7.8) {
                            ph_card.addClass('bg-success');
                        } else {
                            ph_card.addClass('bg-danger');
                        }

                        poolPage.dtTable.ajax.reload(null, false);
                        $('button.close').click();
                        swal(
                            "Success!",
                            "Data has been added!",
                            "success"
                        );
                    });
                });
            });
        },
        validateTime: function () {
            $(document).on('keyup', 'input[name=time]', function() {
                var val = ($(this).val()).split(':');
                if(val.length == 2) {
                    val.forEach((item) => {
                        if(!item.match('/^\d+$/') || item == '') {
                            console.log('ok');
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
        initDatepicker: function () {
            $('input[name=date]').datepicker({
                autoclose: true,
            });
            $('input[name=date]').datepicker('setDate', 'today');
        },
        initSelect2: function () {
            $('#add-record-form select').select2({
                dropdownParent: $('#addModal'),
                placeholder: '-- Please Select --',
            });
        },
        initDatatable: function () {
            $table = $page.find('#log-datatable');
            poolPage.dtTable = $table.DataTable({
                "ordering": false,
                "processing": true,
                "serverSide": true,
                "searching": false,
                "lengthChange": false,
                "responsive": true,
                "ajax": {
                    url: "/ajax/pool-log",
                    type: "POST",
                    data: function (d) { d.mode = 'datatable'; }
                },
                "columns": [
                    { data: 'date', name: 'date' },
                    { data: 'time', name: 'time' },
                    { data: 'method', name: 'method' },
                    { data: 'cl', name: 'cl' },
                    { data: 'ph', name: 'ph' },
                    { data: 'chemical', name: 'chemical' },
                    { data: 'done_by', name: 'done_by' },
                    { data: 'remark', name: 'remark' },
                ],
                "columnDefs": [
                    { targets: 'no-sort', orderable: false },
                    { targets: 'no-search', searchable: false },
                    { targets: 'text-center', className: 'text-center' },
                ]
            });
        },
    };

    if($page.length) {
        poolPage.init();
    }
});
