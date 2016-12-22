@if (!$deleted_at)
    <a href="{{ action("$currentNamespace\RequestFormController@show", $id) }}" class="btn default btn-xs black">
        <i class="fa fa-eye"></i>
        View 
    </a>
@endif
@if ($deleted_at)
    <a href="{{ action("$currentNamespace\RequestFormController@restore", $id) }}" class="btn default btn-xs green">
        <i class="fa fa-undo"></i>
        Restore 
    </a>
@endif