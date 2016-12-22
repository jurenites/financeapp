$(function () {
    if ($(document).dataTable) {
        var id = $('.datatable-ajax').data('id');

        $('.datatable-ajax').dataTable({
            pageLength: 25,
            aaSorting: [],
            processing: true,
            serverSide: true,
            ajax: {
                url: '/api/manager/' + id + '/archive',
                type: 'POST'
            },
            columns: [
                { data: 'status', name: 'status' },
                { data: 'created_at', name: 'created_at' },
                { data: 'requester.name', name: 'requester.name' },
                { data: 'budget_category.name', name: 'budget_category.name' },
                { data: 'amount', name: 'amount' },
                { data: 'explanation', name: 'explanation' },
                { data: 'actions', name: 'actions', sortable: false },
            ]
        });
    }
});
