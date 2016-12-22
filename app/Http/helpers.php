<?php

use App\RequestForm;
use App\RequestFormEvent;

if (!function_exists('getLabelCssClassByStatus'))
{
    function getLabelCssClassByStatus($requestFormStatus)
    {
        switch ($requestFormStatus) {
            case RequestForm::STATUS_SUBMITTED:
            case RequestForm::STATUS_RESUBMITTED:
                return 'warning';

            case RequestForm::STATUS_APPROVED_BY_MANAGER:
            case RequestForm::STATUS_APPROVED_BY_ADMIN:
                return 'success';

            case RequestForm::STATUS_DECLINED_BY_MANAGER:
            case RequestForm::STATUS_DECLINED_BY_ADMIN:
                return 'danger';

            case RequestForm::STATUS_COMPLETED:
                return 'info';
            
            default:
                return 'default';
        }
    }
}

if (!function_exists('getLabelCssClassByEventStatus'))
{
    function getLabelCssClassByEventStatus($requestFormEventStatus)
    {
        switch ($requestFormEventStatus) {
            case RequestFormEvent::TYPE_SUBMITTED:
                return 'warning';

            case RequestFormEvent::TYPE_EDITED:
                return 'primary';

            case RequestFormEvent::TYPE_NOTE_ADDED:
            case RequestFormEvent::TYPE_COMPLETED:
                return 'info';

            case RequestFormEvent::TYPE_APPROVED:
                return 'success';

            case RequestFormEvent::TYPE_DECLINED:
                return 'danger';

            default:
                return 'default';
        }
    }
}

if (!function_exists('getIconCssClassByEventStatus'))
{
    function getIconCssClassByEventStatus($requestFormEventStatus)
    {
        switch ($requestFormEventStatus) {
            case RequestFormEvent::TYPE_SUBMITTED:
                return 'fa-plus-circle';

            case RequestFormEvent::TYPE_EDITED:
                return 'fa-pencil';

            case RequestFormEvent::TYPE_APPROVED:
                return 'fa-thumbs-up';

            case RequestFormEvent::TYPE_DECLINED:
                return 'fa-thumbs-down';

            case RequestFormEvent::TYPE_NOTE_ADDED:
                return 'fa-plus';

            case RequestFormEvent::TYPE_COMPLETED:
                return 'fa-check';

            default:
                return '';
        }
    }
}

if (!function_exists('shouldShowMailingAddressBlock'))
{
    function shouldShowMailingAddressBlock($requestForm)
    {
        return $requestForm->payment_method == RequestForm::$paymentMethods['CHECK']['MAIL'];
    }
}

if (!function_exists('shouldShowDirectDepositBlock'))
{
    function shouldShowDirectDepositBlock($requestForm)
    {
        // TODO: remove this block
        return false;
    }
}