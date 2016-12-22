@extends('layouts.app')

@section('css')
    <link rel="stylesheet" type="text/css" href="/assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css">
    <link rel="stylesheet" type="text/css" href="/assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css"/>
@endsection

@section('javascript')
    <script type="text/javascript" src="/assets/global/plugins/datatables/media/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="/assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js"></script>
    <script type="text/javascript" src="/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
    <script src="/assets/app/js/requestForm.js" type="text/javascript"></script>
@endsection

@section('content')
    <div class="page-content">
        <h3 class="page-title">
            Request Forms
        </h3>
        <div class="table-toolbar">
            <div class="row">
                <div class="col-md-12">
                    <div>
                        <a class="btn green" href="{{ action("$currentNamespace\RequestFormController@create") }}">
                            Add New <i class="fa fa-plus"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="dashboard-calendar">
            <a class="navigate-prev btn blue" href="{{ action("$currentNamespace\RequestFormController@index", $date->subMonth(1)->format('Y-m')) }}">
                <i class="fa fa-chevron-left"></i>
                {{ $date->format('F Y') }} <span class="badge">{{ $prevMonthCount }}</span>
            </a>
            <a class="navigate-cur btn blue" href="javascript:;">
                <i class="fa fa-calendar"></i>
                {{ $date->addMonth(1)->format('F Y') }} <span class="badge">{{ $requestForms->count() }}</span>
            </a>
            <a class="navigate-next btn blue {{ $date->year == \Carbon\Carbon::now()->year && $date->month == \Carbon\Carbon::now()->month ? 'disabled' : '' }}" href="{{ action("$currentNamespace\RequestFormController@index", $date->addMonth(1)->format('Y-m')) }}">
                {{ $date->format('F Y') }} <span class="badge">{{ $nextMonthCount }}</span>
                <i class="fa fa-chevron-right"></i>
            </a>
        </div>
        @include("$currentNamespace.requestForms._table", [])
    </div>
    @if (Entrust::hasRole(['admin', 'budget_manager']))
        <div class="modal fade" id="decline-modal" tabindex="-1" role="basic" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form id="decline-form" action="{{ action("$currentNamespace\RequestFormController@decline", 0) }}" method="POST">
                        {!! csrf_field() !!}
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                            <h4 class="modal-title">Reason</h4>
                        </div>
                        <div class="modal-body">
                            <textarea class="form-control" name="decline_reason" rows="6" placeholder="Please add reason."></textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn red">Decline request</button>
                        </div>
                    </form>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    @endif
@endsection