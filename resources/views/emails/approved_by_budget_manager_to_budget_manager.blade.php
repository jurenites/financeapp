<p>
    You recently approved Request {{ $requestForm->created_at->format('m/d/Y') }} from {{ $requestForm->name }}
</p>
<div>
    <a href="{{ action("BudgetManager\RequestFormController@show", $requestForm->id) }}">View form in app.</a>
</div>