<h1>Request was approved by: {{ $requestForm->budgetManager->name }}.</h1>

<div>
    <a href="{{ action("User\RequestFormController@show", $requestForm->id) }}">View form in app.</a>
</div>