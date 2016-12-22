<div class="row">
    <div class="col-md-12">
        <div class="portlet box blue">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-comment"></i>
                    Notes
                </div>
            </div>
            <div class="portlet-body">
                <div class="scroller" data-always-visible="1" data-rail-visible1="1">
                    <ul class="chats">
                        @foreach($requestForm->requesterNotes as $note)
                            <li class="in">
                                <div>
                                    <span class="name">
                                        {{ $note->author ? $note->author->name : 'N\A' }}
                                    </span>
                                    <span class="datetime">
                                        {{ $note->created_at->format('m/d/Y h:ia') }}
                                    </span>
                                    <span class="body">
                                        {!! nl2br($note->text) !!}
                                    </span>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>