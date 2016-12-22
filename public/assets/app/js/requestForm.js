$(function () {
    var $paymentMethod = $('select.payment_method_select');
    var $type = $('input[name="type"]');
    var $mailingAddress = $('#mailing-address');
    var $directDeposit = $('#direct-deposit');
    var $perDiemWorksheet = $('#per-diem-worksheet');
    var $cashRequestNotification = $('#cash-request-notification');
    var $budgetManager = $('select[name="budget_manager_id"]');
    var $budgetCategory = $('select[name="budget_category_id"]');
    var $documents = $('.documents');
    var $customPopover = $('.custom-popover');
    var $declineButton = $('a[href="#decline-modal"]');
    var $declineForm = $('#decline-form');
    var declineActionPattern = /request_forms\/(\d+)\/decline/g;
    var $paymentMethodsWrapper = $('#payment_methods_wrapper');


    var paymentMethodRequiredAddressVal = $paymentMethod.find('[data-key="MAIL"]').val();
    var paymentMethodsRequiredDirectDeposit = [
        $paymentMethod.find('[data-key="STAFF"]').val(),
        $paymentMethod.find('[data-key="INDEPENDENT_CONTRACTOR"]').val()
    ];
    var paymentMethodPerDiem = $paymentMethod.find('[data-key="PER_DIEM"]').val();
    var typeWithNotificationVal = $type.filter('[data-key="CASH"]').val();
    var typeWithoutPaymentMethod = $type.filter('[data-key="CASH"]').val();

    init();

    function init() {
        initPopover();
        initMailingAddress();
        initDirectDeposit();
        initPerDiemWorksheet();
        initCashRequestNotification();
        initBudgetCategories();
        initValidation();
        initDatepicker();
        initDeleteButtons();
        initPaymentMethodSelect();

        $paymentMethod.on('change', function () {
            initMailingAddress();
            initDirectDeposit();
            initPerDiemWorksheet();
        });

        $type.on('change', function () {
            initMailingAddress();
            initDirectDeposit();
            initPerDiemWorksheet();
            initCashRequestNotification();
            initPaymentMethodSelect();
        });

        $budgetManager.on('change', initBudgetCategories);

        $declineButton.on('click', initDeclineForm);

        $('.delete-document').each(function (index, deleteButton) {
            $(deleteButton).confirmation({
                href: 'javascript:;',
                placement: 'left',
                onConfirm: function () {
                    deleteDocument.call(deleteButton);
                }
            });
        });

        $customPopover.popover({
            html : true, 
            content: function() {
              return $(this).siblings('.popover-content').html();
            },
            delay: {show: 50, hide: 400}
        });
    }

    function deleteDocument() {
        var self = this;
        var token = $(self).data('token');
        var action = $(self).data('action');

        $.ajax({
            url: action,
            type: 'post',
            data: {_method: 'delete', _token: token},
            success: function() {
                $(self).closest('li').remove();
                toastr.success('Document removed.')
            }
        });
    }

    function initMailingAddress() {
        var $paymentMethodSelect = getPaymentMethodSelect();
        var typeKey = $('input[name="type"]:checked').data('key');
        if ($paymentMethodSelect.val() == paymentMethodRequiredAddressVal &&
            typeKey == 'CHECK') {
            $mailingAddress.removeClass('hidden');
        } else {
            $mailingAddress.addClass('hidden');
        }
    }

    function initDirectDeposit() {
        // TODO: Remove Direct Deposit block at all
        $directDeposit.addClass('hidden');
    }

    function initPerDiemWorksheet() {
        var $paymentMethodSelect = getPaymentMethodSelect();
        var typeKey = $('input[name="type"]:checked').data('key');
        if ($paymentMethodSelect.val() == paymentMethodPerDiem &&
            typeKey == 'CASH') {
            $perDiemWorksheet.removeClass('hidden');
        } else {
            $perDiemWorksheet.addClass('hidden');
        }
    }

    function initPaymentMethodSelect() {
        var $paymentMethodSelect = getPaymentMethodSelect();
        $paymentMethod.addClass('hidden');
        $paymentMethodSelect.removeClass('hidden');
    }

    function initCashRequestNotification() {
        if ($type.filter(':checked').val() == typeWithNotificationVal) {
            $cashRequestNotification.removeClass('hidden');
        } else {
            $cashRequestNotification.addClass('hidden');
        }
    }

    function initBudgetCategories() {
        $budgetCategory.addClass('hidden');
        $budgetCategory.filter('[data-manager-id="' + $budgetManager.val() + '"]').removeClass('hidden');
    }

    function initDeclineForm() {
        var id = $(this).data('id');
        var newAction = $declineForm.attr('action').replace(declineActionPattern, 'request_forms/' + id + '/decline')
        $declineForm.attr('action', newAction);
    }

    function initValidation() {
        $('.request-form').validate({
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
                    required: true
                },
                type: {
                    required: true
                },
                payable_to_name: {
                    required: true
                },
                amount: {
                    required: true,
                    number: true
                },
                explanation: {
                    required: true
                },
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
                $budgetCategory.not('[data-manager-id="' + $budgetManager.val() + '"]').remove();
                form.submit();
            }
        });
    }

    function initPopover() {
        // Keep Bootstrap Popover open when you hover over content (http://jsfiddle.net/raving/2thfaxeu/)
        var originalLeave = $.fn.popover.Constructor.prototype.leave;
        $.fn.popover.Constructor.prototype.leave = function(obj){
          var self = obj instanceof this.constructor ?
            obj : $(obj.currentTarget)[this.type](this.getDelegateOptions()).data('bs.' + this.type)
          var container, timeout;

          originalLeave.call(this, obj);

          if(obj.currentTarget) {
            container = $('.popover'); // FIXME
            timeout = self.timeout;
            container.on('mouseenter', function(){
              //We entered the actual popover – call off the dogs
              clearTimeout(timeout);
              //Let's monitor popover content instead
              container.on('mouseleave', function(){
                $.fn.popover.Constructor.prototype.leave.call(self, self);
              });
            })
          }
        };
    }

    function initDatepicker() {
        $('.datepicker').datepicker({
            orientation: "top",
            autoclose: true
        });
        $('.navigate-cur').datepicker({
            orientation: "top",
            autoclose: true,
            minViewMode: 1,
            endDate: "0d"
        }).on('changeDate', function (e) {
            var pos = location.pathname.indexOf('dashboard') + 9;
            location.href = location.pathname.substr(0, pos) + '/' + moment(e.date).format('YYYY-MM');
        });
    }

    function initDeleteButtons() {
        $('.datatable').on('click', '.delete-request-form', function (e) {
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

    function getPaymentMethodSelect() {
        var typeKey = $('input[name="type"]:checked').data('key');
        return $('select[name="payment_method_' + typeKey + '"]');
    }
});
