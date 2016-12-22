@if (!$deleted_at)
    <a href="{{ action("Admin\RequestFormController@export", $id) }}" class="btn btn-xs yellow primary">
        <i class="fa fa-file-pdf-o"></i>
        PDF
    </a>
@endif