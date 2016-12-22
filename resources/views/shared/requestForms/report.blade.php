@extends('layouts.app')

@section('css')
    <link rel="stylesheet" type="text/css" href="/assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css">
    <link rel="stylesheet" type="text/css" href="/assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css"/>
    <link rel="stylesheet" type="text/css" href="/assets/global/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css"/>
    <link rel="stylesheet" type="text/css" href="/assets/global/plugins/bootstrap-select/bootstrap-select.min.css"/>
    <link rel="stylesheet" type="text/css" href="/assets/global/plugins/select2/select2.css"/>
@endsection

@section('javascript')
    <script type="text/javascript" src="/assets/global/plugins/datatables/media/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="/assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js"></script>
    <script type="text/javascript" src="/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
    <script type="text/javascript" src="/assets/global/plugins/bootstrap-daterangepicker/moment.min.js"></script>
    <script type="text/javascript" src="/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.js"></script>
    <script type="text/javascript" src="/assets/global/plugins/bootstrap-select/bootstrap-select.min.js"></script>
    <script type="text/javascript" src="/assets/global/plugins/select2/select2.min.js"></script>
    <script src="/assets/app/js/report.js" type="text/javascript"></script>
@endsection

@section('content')
    <div class="page-content">
        <form action="">
            <h3 class="page-title">
                Report
                <div id="reportrange" class="btn default">
                    <i class="fa fa-calendar"></i>
                    &nbsp; <span>
                    </span>
                    <b class="fa fa-angle-down"></b>
                </div>
                <input type="hidden" name="from" value="{{ $from->format('Y-m-d') }}">
                <input type="hidden" name="to" value="{{ $to->format('Y-m-d') }}">
                <select class="bs-select form-control" data-show-subtext="true" name="status" id="report-status">
                    @foreach($statuses as $_status)
                        <option {{ $status == $_status ? 'selected' : ''}} data-content="<span class='label label-sm label-{{ getLabelCssClassByStatus($_status) }}''>{{ $_status }}</span>">{{ $_status }}</option>
                    @endforeach
                </select>
                <button type="submit" name="format" value="" class="btn green" id="report-refresh">
                    Refresh
                    <i class="fa fa-refresh"></i>
                </button>
                <button type="submit" name="format" value="csv" class="btn yellow" id="report-csv">
                    Export
                    <i class="fa fa-file-excel-o"></i>
                </a>
            </h3>
        </form>
        <table class="table table-striped table-bordered datatable">
            <thead>
                <tr>
                    <th>Date submitted</th>
                    <th>Payable Name</th>
                    <th>Amount</th>
                    <th>Budget Category</th>
                    <th>Method of payment</th>
                </tr>
            </thead>
            <tbody>
                @foreach($requestForms as $requestForm)
                    <tr>
                        <td>{{ $requestForm->created_at->format('m/d/Y') }}</td>
                        <td>{{ $requestForm->payable_to_name }}</td>
                        <td>{{ $requestForm->amount }}</td>
                        <td>{{ $requestForm->budgetCategory ? $requestForm->budgetCategory->name : 'Unknown' }}</td>
                        <td>{{ $requestForm->payment_method ?: 'N\A' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection