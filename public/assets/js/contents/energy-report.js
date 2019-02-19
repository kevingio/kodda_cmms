$(document).ready(function () {
    var $page = $('#energy-report-page');

    var energyReportPage = {
        dtTable: {},
        init: function () {
            this.initDatatable();
            this.initSelect2();
            this.customFunction();
        },
        customFunction: function () {
            var data_id = null;


        },
        initSelect2: function () {
            $('select[name=month]').select2({
                placeholder: '-- Please Select --',
            });
            $('select[name=year]').select2({
                placeholder: '-- Please Select --',
                data: [
                    {
                        id: 2017,
                        text: '2017'
                    },
                    {
                        id: 2018,
                        text: '2018'
                    },
                    {
                        id: 2019,
                        text: '2019'
                    }
                ]
            });
        },
        initDatatable: function () {
            $('.dt-table').DataTable({
                responsive: true,
            });
        },
    };

    if($page.length) {
        energyReportPage.init();
    }
});
