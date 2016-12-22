<table class="table table-striped table-bordered datatable">
    <thead>
        <tr>
            <th>Status</th>
            <th>Date Submitted</th>
            <th>Requester</th>
            <th>Amount of Request</th>
            <th>Budget Manager</th>
            <th>Budget Category</th>
            <th>Actions</th>
            <th>Export</th>
        </tr>
    </thead>
    <tbody>
        @foreach($requestForms as $requestForm)
            <tr>
                <td>
                    <span class="label label-sm label-{{ getLabelCssClassByStatus($requestForm->status) }}">
                        {{ $requestForm->status }}
                    </span>
                </td>
                <td>{{ $requestForm->created_at->format('m/d/Y') }}</td>
                <td>{{ $requestForm->name }}</td>
                <td>{{ $requestForm->amount }}</td>
                <td>{{ $requestForm->budgetManager ? $requestForm->budgetManager->name : '' }}</td>
                <td>{{ $requestForm->budgetCategory ? $requestForm->budgetCategory->name : '' }}</td>
                <td>
                    <form action="{{ action("$currentNamespace\RequestFormController@destroy", $requestForm->id) }}" method="POST">
                        <input type="hidden" name="_method" value="DELETE">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <a href="{{ action("$currentNamespace\RequestFormController@show", $requestForm->id) }}" class="btn default btn-xs black">
                            <i class="fa fa-eye"></i>
                            View 
                        </a>
                        @if ($requestForm->isUserCanEdit())
                            <a href="{{ action("$currentNamespace\RequestFormController@edit", $requestForm->id) }}" class="btn default btn-xs purple">
                                <i class="fa fa-edit"></i>
                                Edit 
                            </a>
                            <a class="btn default btn-xs red delete-request-form" href="javascript:;">
                                <i class="fa fa-times"></i>
                                Delete
                            </a>
                        @endif
                        @if ($requestForm->isAdminCanApprove())
                            <a href="{{ action("$currentNamespace\RequestFormController@approve", $requestForm->id) }}" class="btn default btn-xs green">
                                <i class="fa fa-thumbs-up"></i>
                                Approved
                            </a>
                        @endif
                        @if ($requestForm->isAdminCanDecline())
                            <a href="#decline-modal" data-id="{{ $requestForm->id }}" data-toggle="modal" class="btn default btn-xs red">
                                <i class="fa fa-thumbs-down"></i>
                                Declined
                            </a>
                        @endif
                        @if ($requestForm->isAdminCanPay())
                            <a href="{{ action("$currentNamespace\RequestFormController@pay", $requestForm->id) }}" class="btn btn-xs blue primary">
                                <i class="fa fa-check"></i>
                                Completed
                            </a>
                        @endif
                    </form>
                </td>
                <td>
                    <a href="{{ action("$currentNamespace\RequestFormController@export", $requestForm->id) }}" class="btn btn-xs yellow primary">
                        <i class="fa fa-file-pdf-o"></i>
                        PDF
                    </a>
                </td>
            </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr class="bold">
            <td>Totals:</td>
            <td></td>
            <td></td>
            <td>{{ $requestForms->count() > 0 ? $requestForms->sum('amount') : '' }}</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
    </tfoot>
</table>