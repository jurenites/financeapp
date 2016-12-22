<table class="table table-striped table-bordered datatable">
    <thead>
        <tr>
            <th>Status</th>
            <th>Date Submitted</th>
            <th>Person Requesting Funds</th>
            <th>Amount of Request</th>
            <th>Budget Category</th>
            <th>Explanation of Expense</th>
            <th>Actions</th>
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
                <td>{{ str_limit($requestForm->name, $limit = 64, $end = '...') }}</td>
                <td>{{ $requestForm->amount }}</td>
                <td>{{ $requestForm->budgetCategory ? $requestForm->budgetCategory->name : 'Unknown' }}</td>
                <td>{{ str_limit($requestForm->explanation, $limit = 255, $end = '...') }}</td>
                <td>
                    <a href="{{ action("$currentNamespace\RequestFormController@show", $requestForm->id) }}" class="btn default btn-xs black">
                        <i class="fa fa-eye"></i>
                        View 
                    </a>
                    @if ($requestForm->isUserCanEdit())
                        <a href="{{ action("$currentNamespace\RequestFormController@edit", $requestForm->id) }}" class="btn default btn-xs purple">
                            <i class="fa fa-edit"></i>
                            Edit 
                        </a>
                    @endif
                    @if ($requestForm->isManagerCanApprove())
                        <a href="{{ action("$currentNamespace\RequestFormController@approve", $requestForm->id) }}" class="btn default btn-xs green">
                            <i class="fa fa-thumbs-up"></i>
                            Approve 
                        </a>
                    @endif
                    @if ($requestForm->isManagerCanDecline())
                        <a href="#decline-modal" data-id="{{ $requestForm->id }}" data-toggle="modal" class="btn default btn-xs red">
                            <i class="fa fa-thumbs-down"></i>
                            Decline 
                        </a>
                    @endif
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