<h1>Your request was declined{{ $requestForm->budgetManager ? ' by: ' . $requestForm->budgetManager->name : ''}}.</h1>
<h2>Reason:</h2>
<p>
    {{ $note->text ?: 'N\A'}}
</p>
<div>
    You can <a href="{{ action("User\RequestFormController@edit", $requestForm->id) }}">Re-submit</a> form.
</div>