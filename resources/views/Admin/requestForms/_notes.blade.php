<div class="row">
    <div class="col-md-4">
        <div class="portlet box blue">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-comment"></i>
                    Notes to Requester
                </div>
            </div>
            <div class="portlet-body">
                <div class="scroller">
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
                <form action="{{ action("$currentNamespace\RequestFormController@addRequesterNote", $requestForm->id) }}" method="post">
                    {!! csrf_field() !!}
                    <div class="chat-form form-group">
                        <textarea class="form-control" name="note" type="text" cols="5" placeholder="Type a note here..."></textarea>
                    </div>
                    <div class="form-group pull-right">
                        <input type="submit" value="Add note" class="btn blue">
                    </div>
                    <div class="clearfix"></div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="portlet box blue">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-comment"></i>
                    Notes to Budget Manager
                </div>
            </div>
            <div class="portlet-body">
                <div class="scroller" data-always-visible="1" data-rail-visible1="1">
                    <ul class="chats">
                        @foreach($requestForm->budgetManagerNotes as $note)
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
                <form action="{{ action("$currentNamespace\RequestFormController@addBudgetManagerNote", $requestForm->id) }}" method="post">
                    {!! csrf_field() !!}
                    <div class="chat-form form-group">
                        <textarea class="form-control" name="note" type="text" cols="5" placeholder="Type a note here..."></textarea>
                    </div>
                    <div class="form-group pull-right">
                        <input type="submit" value="Add note" class="btn blue">
                    </div>
                    <div class="clearfix"></div>
                </form>
            </div>
        </div>     
    </div>
    <div class="col-md-4">
        <div class="portlet box blue">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-comment"></i>
                    Notes to Finance Team
                </div>
            </div>
            <div class="portlet-body">
                <div class="scroller" data-always-visible="1" data-rail-visible1="1">
                    <ul class="chats">
                        @foreach($requestForm->adminNotes as $note)
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
                <form action="{{ action("$currentNamespace\RequestFormController@addAdminNote", $requestForm->id) }}" method="post">
                    {!! csrf_field() !!}
                    <div class="chat-form form-group">
                        <textarea class="form-control" name="note" type="text" cols="5" placeholder="Type a note here..."></textarea>
                    </div>
                    <div class="form-group pull-right">
                        <input type="submit" value="Add note" class="btn blue">
                    </div>
                    <div class="clearfix"></div>
                </form>
            </div>
        </div>
    </div>
</div>