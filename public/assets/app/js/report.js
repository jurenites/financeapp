$(function () {
    $('.bs-select').selectpicker({
        iconBase: 'fa',
        tickIcon: 'fa-check'
    });
    $('#reportrange').daterangepicker({
            opens: (Metronic.isRTL() ? 'left' : 'right'),
            startDate: moment($('input[name="from"]').val()),
            endDate: moment($('input[name="to"]').val()),
            showDropdowns: true,
            showWeekNumbers: true,
            ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract('days', 1), moment().subtract('days', 1)],
                'Last 7 Days': [moment().subtract('days', 6), moment()],
                'Last 30 Days': [moment().subtract('days', 29), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract('month', 1).startOf('month'), moment().subtract('month', 1).endOf('month')]
            },
            buttonClasses: ['btn'],
            applyClass: 'green',
            cancelClass: 'default',
            format: 'MM/DD/YYYY',
            separator: ' to ',
            locale: {
                applyLabel: 'Apply',
                fromLabel: 'From',
                toLabel: 'To',
                customRangeLabel: 'Custom Range',
                daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
                monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                firstDay: 1
            }
        },
        function (start, end) {
            $('input[name="from"]').val(start.format('YYYY-MM-DD'));
            $('input[name="to"]').val(end.format('YYYY-MM-DD'));
            $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        }
    );
    //Set the initial state of the picker label
    $('#reportrange span').html(moment($('input[name="from"]').val()).format('MMMM D, YYYY') + ' - ' + moment($('input[name="to"]').val()).format('MMMM D, YYYY'));
});
