$(document).ready(function () {
    var $page = $('#maintenance-page');

    var maintenancePage = {
        dtTable: {},
        dtTableInventory: {},
        dataSetInventory: [],
        init: function () {
            this.initSelect2();
            this.initDatatable();
            this.initFullCalendar();
            this.customFunction();
            this.initDatatableInventory();
            this.inventory();
        },
        customFunction: function () {
            var data_id = null;

            $(document).on('click', '.finish', function () {
                data_id = $(this).attr('data-id');
                $.get('/maintenance/' + data_id).
                done(function (response) {
                    $('#edit-record-form select[multiple]').val(response.engineers).trigger('change');
                    $('#editModal select[name=status]').val(response.status).trigger('change');
                    $('#editModal textarea[name=description]').val(response.description);
                    $('select[alt=inventory_name]').val(null).trigger('change');
                    $('#editModal').modal('show');
                });
            });

            $('#edit-record-form select[name=status]').on('select2:select', function () {
                let data = $(this).val();
                maintenancePage.dataSetInventory = [];
                maintenancePage.dtTableInventory.clear().rows.add(maintenancePage.dataSetInventory).draw(false);
                if(data == 'completed') {
                    $('#inventory-section').show(500);
                } else {
                    $('#inventory-section').hide(300);
                }
            });

            $('#edit-record-form').on('submit', function (e) {
                e.preventDefault();
                var data = $(this).serializeArray();
                let temp = {
                    name: 'inventories',
                    value: JSON.stringify(maintenancePage.dataSetInventory)
                };
                data.push(temp);
                console.log(data);
                $.ajax({
                    url: '/maintenance/' + data_id,
                    data: data,
                    type: 'PUT',
                    success: function(response) {
                        if(response.status == 200) {
                            $(this).find("input, textarea").val('');
                            $('select').val(null).trigger('change');
                            $('button.close').click();
                            swal(
                                "Success!",
                                "Data has been edited!",
                                "success"
                            );
                            maintenancePage.dtTable.ajax.reload(null, false);
                        } else {
                            swal(
                                "Oops!",
                                "Something went wrong, please refresh the page!",
                                "danger"
                            );
                        }
                    }
                });
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
                maintenancePage.dataSetInventory.forEach(function (item) {
                    if(item.id == data.id) {
                        diff = data.qty - item.qty;
                    }
                });
                $('input[alt=qty]').attr('max', stock).attr('placeholder', diff).focus();
            });

            $(document).on('click', '.remove', function () {
                let id = $(this).attr('data');
                maintenancePage.dataSetInventory = maintenancePage.dataSetInventory.filter(function(value, index, arr){
                    return value.id != id;
                });
                maintenancePage.dtTableInventory.clear().rows.add(maintenancePage.dataSetInventory).draw(false);
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
                    maintenancePage.dtTableInventory.clear().rows.add(maintenancePage.dataSetInventory).draw(false);
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
                maintenancePage.dataSetInventory.forEach((item) => {
                    if(item.id == value.id) {
                        item.qty = parseInt(item.qty) + parseInt(value.qty);
                        flag = null;
                    }
                });
                if(flag) {
                    maintenancePage.dataSetInventory.push(value);
                }
                $('select[alt=inventory_name]').val(null).trigger('change');
            }
        },
        initSelect2: function () {
            $('#edit-record-form select').select2({
                dropdownParent: $('#editModal')
            });
        },
        initFullCalendar: function () {
            $.post('/ajax/equipment', {mode: 'maintenance'})
            .done(function (response) {
                var data = response;
                $('#maintenance-calendar').fullCalendar({
                    header: {
                        left: 'title',
                        center: '',
                        right: 'prev,next today'
                    },
                    editable: false,
                    firstDay: 1, //  1(Monday) this can be changed to 0(Sunday) for the USA system
                    selectable: true,
                    defaultView: 'month',

                    axisFormat: 'h:mm',
                    columnFormat: {
                        month: 'ddd',    // Mon
                        week: 'ddd d', // Mon 7
                        day: 'dddd M/d',  // Monday 9/7
                        agendaDay: 'dddd d'
                    },
                    titleFormat: {
                        month: 'MMMM YYYY', // September 2009
                    },
                    allDaySlot: false,
                    selectHelper: false,
                    events: data,
                    viewRender: function(view, element) {
                        if(moment().isAfter(view.intervalStart)) {
                            $('.fc-prev-button').addClass('fc-state-disabled');
                        } else {
                            $('.fc-prev-button').removeClass('fc-state-disabled');
                        }
                    },
                    dayRender: function(date,cell) {
                        // Get all events
                        var events = $('#maintenance-calendar').fullCalendar('clientEvents').length ? $('#maintenance-calendar').fullCalendar('clientEvents') : data;

                        // Start of a day timestamp
                        var dateTimestamp = date.hour(0).minutes(0);
                        var recurringEvents = new Array();

                        // find all events with monthly repeating flag, having id, repeating at that day few months ago
                        var monthlyEvents = events.filter(function (event) {
                            return event.id &&
                            moment(event.start).hour(0).minutes(0).diff(dateTimestamp, 'months', true) % event.repeat == 0
                        });

                        recurringEvents = monthlyEvents;

                        $.each(recurringEvents, function(key, event) {
                            var timeStart = moment(event.start);
                            var eventData = {
                                id: event.id,
                                allDay: event.allDay,
                                title: event.title,
                                description: event.description,
                                start: date.hour(timeStart.hour()).minutes(timeStart.minutes()).format("YYYY-MM-DD"),
                                end: event.end ? event.end.format("YYYY-MM-DD") : "",
                                className: event.className
                            };

                            // Removing events to avoid duplication
                            $('#equipment-calendar').fullCalendar('removeEvents', function (event) {
                                return eventData.id === event.id &&
                                moment(event.start).isSame(date, 'day');
                            });
                            // Render event
                            $('#equipment-calendar').fullCalendar('renderEvent', eventData, true);
                        });
                    },
                    dayClick: function(date, jsEvent, view) {
                        window.location.href = '/maintenance/' + date.format();
                    }
                });
            });
        },
        initDatatable: function () {
            $table = $page.find('#maintenance-list-datatable');
            maintenancePage.dtTable = $table.DataTable({
                "aaSorting": [],
                "processing": true,
                "serverSide": true,
                "searching": true,
                "lengthChange": false,
                "responsive": true,
                "ajax": {
                    url: "/ajax/maintenance-report",
                    type: "POST",
                    data: function (d) { d.mode = 'datatable'; d.date = $('#date').text(); }
                },
                "columns": [
                    { data: 'mt_number', name: 'mt_number' },
                    { data: 'model', name: 'model' },
                    { data: 'serial_number', name: 'serial_number' },
                    { data: 'location', name: 'location' },
                    { data: 'status', name: 'status' },
                    { data: 'action', name: 'action' },
                ],
                "columnDefs": [
                    { targets: 'no-sort', orderable: false },
                    { targets: 'no-search', searchable: false },
                    { targets: 'text-center', className: 'text-center' },
                ],
            });
        },
        initDatatableInventory: function () {
			maintenancePage.dtTableInventory = $('#inventory-datatable').DataTable({
                "ordering": false,
                "paging": false,
	            "searching": false,
                "responsive": true,
	            "data": maintenancePage.dataSetInventory,
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
        maintenancePage.init();
    }
});
