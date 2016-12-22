<h1>Request was declined by: {{ $note->author->name }}.</h1>
<h2>Reason:</h2>
<p>
    {{ $note->text ?: 'N\A'}}
</p>
<div>
    <a href="{{ action("BudgetManager\RequestFormController@show", $requestForm->id) }}">View form in app.</a>
</div>