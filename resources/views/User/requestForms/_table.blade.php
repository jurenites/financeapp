<table class="table table-striped table-bordered datatable">
    <thead>
        <tr>
            <th>Status</th>
            <th>Date Submitted</th>
            <th>Amount of Request</th>
            <th>Budget Manager</th>
            <th>Budget Category</th>
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
                <td>{{ $requestForm->amount }}</td>
                <td>{{ $requestForm->budgetManager ? $requestForm->budgetManager->name : '' }}</td>
                <td>{{ $requestForm->budgetCategory ? $requestForm->budgetCategory->name : 
                    ($requestForm->budgetManager ? 'Unknown' : '') }}</td>
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
                </td>
            </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr class="bold">
            <td>Totals:</td>
            <td></td>
            <td>{{ $requestForms->sum('amount') }}</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
    </tfoot>
</table>