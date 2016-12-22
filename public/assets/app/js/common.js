$(function () {
    if ($(document).dataTable) {
        $('.datatable').dataTable({
            "pageLength": 25,
            aaSorting: []
        });
    }
});
