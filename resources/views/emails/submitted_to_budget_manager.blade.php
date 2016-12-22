<style>
    table {
        border-collapse: collapse;
    }

    table, th, td {
        border: 1px solid black;
    }

    table th, table td {
        padding: 10px;
    }

    .table-header {
        font-weight: bold;
        text-align: center;
    }

    .field-name {
        font-weight: bold;
        width: 200px;
    }
</style>
<h1>New request form was submitted:</h1>
<div>
    <table>
        <thead>
        </thead>
        <tbody>
            <tr>
                <td colspan="2" class="table-header">
                    Person Requesting Funds
                </td>
            </tr>
            <tr>
                <td class="field-name">Request Date</td>
                <td>{{ $requestForm->created_at->format('m/d/Y') }}</td>
            </tr>
            <tr>
                <td class="field-name">Requester</td>
                <td>{{ $requestForm->name }}</td>
            </tr>
            <tr>
                <td class="field-name">Email</td>
                <td>{{ $requestForm->email }}</td>
            </tr>
            <tr>
                <td class="field-name">Phone</td>
                <td>{{ $requestForm->phone }}</td>
            </tr>
            <tr>
                <td colspan="2" class="table-header">
                    Request Type
                </td>
            </tr>
            <tr>
                <td class="field-name">Request Type</td>
                <td>{{ $requestForm->getType() }}</td>
            </tr>
            <tr>
                <td class="field-name">Method of Payment</td>
                <td>{{ $requestForm->payment_method ?: 'N\A' }}</td>
            </tr>
            <tr>
                <td class="field-name">Amount</td>
                <td>${{ $requestForm->amount }}</td>
            </tr>
            <tr>
                <td class="field-name">Make Payable To</td>
                <td>{{ $requestForm->payable_to_name }}</td>
            </tr>
            <tr>
                <td class="field-name">Budget Category</td>
                <td>{{ $requestForm->budgetCategory ? $requestForm->budgetCategory->name : 
                    ($requestForm->budgetManager ? 'Unknown' : 'N\A') }}</td>
            </tr>
            @if (shouldShowMailingAddressBlock($requestForm))
                <tr>
                    <td colspan="2" class="table-header">
                        Mailing Address
                    </td>
                </tr>
                <tr>
                    <td class="field-name">Address 1</td>
                    <td>{{ $requestForm->address1 ?: 'N\A' }}</td>
                </tr>
                <tr>
                    <td class="field-name">Address 2</td>
                    <td>{{ $requestForm->address2 ?: 'N\A' }}</td>
                </tr>
                <tr>
                    <td class="field-name">City</td>
                    <td>{{ $requestForm->city ?: 'N\A' }}</td>
                </tr>
                <tr>
                    <td class="field-name">State / Zip</td>
                    <td>{{ $requestForm->state ?: 'N\A' }} / {{ $requestForm->zip ?: 'N\A' }}</td>
                </tr>
            @endif
            @if (shouldShowDirectDepositBlock($requestForm))
                <tr>
                    <td colspan="2" class="table-header">
                        Direct Deposit Information
                    </td>
                </tr>
                <tr>
                    <td class="field-name">Bank Name</td>
                    <td>{{ $requestForm->bank_name ?: 'N\A' }}</td>
                </tr>
                <tr>
                    <td class="field-name">Account Type</td>
                    <td>{{ $requestForm->account_type ?: 'N\A' }}</td>
                </tr>
                <tr>
                    <td class="field-name">Routing Number</td>
                    <td>{{ $requestForm->routing_number ?: 'N\A' }}</td>
                </tr>
                <tr>
                    <td class="field-name">Account Number</td>
                    <td>{{ $requestForm->account_number ?: 'N\A' }}</td>
                </tr>
            @endif
            <tr>
                <td colspan="2" class="table-header">
                    Request Explanation
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    {{ $requestForm->explanation }}
                </td>
            </tr>
            <tr>
                <td colspan="2" class="table-header">
                    Actions
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <a href="{{ action("Shared\HomeController@token", $actionToken->token) }}">Approve</a>
                    <a href="{{ action("BudgetManager\RequestFormController@show", $requestForm->id) }}">View in app</a>
                </td>
            </tr>
        </tbody>
    </table>
</div>
