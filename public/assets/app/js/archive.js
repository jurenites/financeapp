$(function () {
    if ($(document).dataTable) {
        $('.datatable-ajax').dataTable({
            pageLength: 25,
            aaSorting: [],
            processing: true,
            serverSide: true,
            ajax: {
                url: '/api/admin/archive',
                type: 'POST'
            },
            columns: [
                { data: 'status', name: 'status' },
                { data: 'created_at', name: 'created_at' },
                { data: 'requester.name', name: 'requester.name' },
                { data: 'amount', name: 'amount' },
                { data: 'budget_manager.name', name: 'budget_manager.name' },
                { data: 'budget_category.name', name: 'budget_category.name' },
                { data: 'actions', name: 'actions', sortable: false },
                { data: 'export', name: 'export', sortable: false }
            ]
        });
    }
});
