$(function () {
    var $role = $('select[name="role"]');
    var $budgetCategories = $('#budget-categories');

    var selectBudgetCategoriesRoleVal = $role.find('[data-key="budget_manager"]').val();

    init();

    function init() {
        initValidation();
        initBudgetCategories();
        initDeleteButtons();

        $role.on('change', function (e) {
            initBudgetCategories();
        });
    }

    function initValidation() {
        var isEditForm = $('input[name="_method"]').val() == 'PUT';

        $('.user-form').validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            ignore: "",
            rules: {
                name: {
                    required: true
                },
                email: {
                    required: true,
                    email: true
                },
                phone: {
                    // required: true
                },
                password: {
                    required: !isEditForm
                },
                password_confirmation: {
                    equalTo: "#password"
                }
            },

            messages: { // custom messages for radio buttons and checkboxes

            },

            invalidHandler: function(event, validator) { //display error alert on form submit   

            },

            highlight: function(element) { // hightlight error inputs
                $(element)
                    .closest('.form-group').addClass('has-error'); // set error class to the control group
            },

            success: function(label) {
                label.closest('.form-group').removeClass('has-error');
                label.remove();
            },

            errorPlacement: function(error, element) {
                if (element.siblings('.input-group-addon').size() === 1) {
                    error.insertAfter(element.closest('.input-group'));
                } else if (element.closest('.radio-list').size() === 1) {
                    error.insertAfter(element.closest('.radio-list'));
                } else {
                    error.insertAfter(element);
                }
            },

            submitHandler: function(form) {
                form.submit();
            }
        });
    }

    function initBudgetCategories() {
        if ($(document).dataTable && !$.fn.DataTable.isDataTable('.inline-edit-datatable')) {
            $('.inline-edit-datatable').dataTable({
                aaSorting: [],
                aoColumnDefs: [
                    { bSortable: false, aTargets: [0] }
                ]
            });
        }

        if ($role.val() == selectBudgetCategoriesRoleVal) {
            $budgetCategories.removeClass('hidden');
        } else {
            $budgetCategories.addClass('hidden');
        }
    }

    function initDeleteButtons() {
        $('.datatable').on('click', '.delete-user', function (e) {
            var self = this;
            $(self).confirmation({
                href: 'javascript:;',
                placement: 'left',
                onConfirm: function () {
                    deleteUser.call(self);
                }
            });

            $(self).confirmation('show');
        });
    }

    function deleteUser() {
        $(this).closest('form').submit()
    }
});
