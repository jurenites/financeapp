$(function () {
    var $budgetCategoriesTable = $('#budget_categories_table');
    var $addNewCategoryButton = $('#add_new_budget_category');

    init();

    function init() {
        initBudgetCategories();
    }

    function initBudgetCategories() {
        var table = $budgetCategoriesTable;

        var oTable = table.dataTable({
            "pageLength": 25,
            "columnDefs": [{
                'orderable': true,
                'targets': [0]
            }, {
                "searchable": true,
                "targets": [0]
            }],
            "order": [
                [0, "asc"]
            ]
        });

        var nEditing = null;
        var nNew = false;

        $addNewCategoryButton.click(function (e) {
            e.preventDefault();

            if (nNew && nEditing) {
                saveRow(oTable, nEditing);
                $(nEditing).find("td:first").html("Untitled");
                nEditing = null;
                nNew = false;
            }

            var aiNew = oTable.fnAddData(['', '', '', '', '', '']);
            var nRow = oTable.fnGetNodes(aiNew[0]);
            editRow(oTable, nRow);
            nEditing = nRow;
            nNew = true;
        });

        $budgetCategoriesTable.on('click', '.delete', function (e) {
            var self = this;
            $(self).confirmation({
                href: 'javascript:;',
                placement: 'left',
                onConfirm: function () {
                    deleteHandler.call(self);
                }
            });

            $(this).confirmation('show');
        });

        function deleteHandler() {
            var nRow = $(this).parents('tr')[0];
            oTable.fnDeleteRow(nRow);
            destroy(nRow);
        }

        table.on('click', '.cancel', function (e) {
            e.preventDefault();
            if (nNew) {
                oTable.fnDeleteRow(nEditing);
                nEditing = null;
                nNew = false;
            } else {
                restoreRow(oTable, nEditing);
                nEditing = null;
            }
        });

        table.on('click', '.edit', function (e) {
            e.preventDefault();

            /* Get the row as a parent of the link that was clicked on */
            var nRow = $(this).parents('tr')[0];

            if (nEditing !== null && nEditing != nRow) {
                /* Currently editing - but not this row - restore the old before continuing to edit mode */
                restoreRow(oTable, nEditing);
                editRow(oTable, nRow);
                nEditing = nRow;
            } else if (nEditing == nRow && this.innerHTML.indexOf('Save') !== -1) {
                /* Editing this row and want to save it */
                saveRow(oTable, nEditing);
                nEditing = null;
                store(nRow);
                nNew = false;
            } else {
                /* No edit in progress - let's start one */
                editRow(oTable, nRow);
                nEditing = nRow;
            }
        });
    }

    function restoreRow(oTable, nRow) {
        var aData = oTable.fnGetData(nRow);
        var jqTds = $('>td', nRow);

        for (var i = 0, iLen = jqTds.length; i < iLen; i++) {
            oTable.fnUpdate(aData[i], nRow, i, false);
        }

        oTable.fnDraw();
    }

    function editRow(oTable, nRow) {
        var aData = oTable.fnGetData(nRow);
        var jqTds = $('>td', nRow);
        jqTds[0].innerHTML = '<input type="text" class="form-control" value="' + aData[0] + '">';
        jqTds[1].innerHTML = '<a class="edit btn default btn-xs green" href="javascript:;"><i class="fa fa-edit"></i> Save</a>';
        jqTds[2].innerHTML = '<a class="cancel btn default btn-xs red" href="javascript:;"><i class="fa fa-ban"></i> Cancel</a>';
    }

    function saveRow(oTable, nRow) {
        var jqInputs = $('input', nRow);
        oTable.fnUpdate(jqInputs[0].value, nRow, 0, false);
        oTable.fnUpdate('<a class="edit btn default btn-xs purple" href="javascript:;"><i class="fa fa-edit"></i> Edit</a>', nRow, 1, false);
        oTable.fnUpdate('<a class="delete btn default btn-xs red" href="javascript:;"><i class="fa fa-times"></i> Delete</a>', nRow, 2, false);
        oTable.fnDraw();
    }

    function cancelEditRow(oTable, nRow) {
        var jqInputs = $('input', nRow);
        oTable.fnUpdate(jqInputs[0].value, nRow, 0, false);
        oTable.fnUpdate('<a class="edit btn default btn-xs purple" href="javascript:;"><i class="fa fa-edit"></i> Edit</a>', nRow, 1, false);
        oTable.fnDraw();
    }

    function store(row) {
        var id = $(row).data('id');
        var token = $budgetCategoriesTable.data('token');
        var name = $(row).children('td').first().text();
        if (id) {
            $.ajax({
                url: '/admin/categories/' + id,
                type: 'post',
                data: {_method: 'put', _token: token, name: name},
                success: function() {
                    toastr.success('Category "' + name + '" updated.');
                }
            });
        } else {
            $.ajax({
                url: '/admin/categories',
                type: 'post',
                data: {_method: 'post', _token: token, name: name},
                success: function(id) {
                    $(row).data('id', id);
                    toastr.success('Category "' + name + '" created.');
                }
            });
        }
    }

    function destroy(row) {
        var id = $(row).data('id');
        var token = $budgetCategoriesTable.data('token');
        var name = $(row).children('td').first().text();
        $.ajax({
            url: '/admin/categories/' + id,
            type: 'post',
            data: {_method: 'delete', _token: token},
            success: function() {
                toastr.success('Category "' + name + '" removed.');
            }
        });
    }
});
