@extends('layouts.app')

@section('css')
    <link rel="stylesheet" type="text/css" href="/assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css">
@endsection

@section('javascript')
    <script type="text/javascript" src="/assets/global/plugins/datatables/media/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="/assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js"></script>
    <script src="/assets/app/js/archive.js" type="text/javascript"></script>
@endsection

@section('content')
    <div class="page-content">
        <h3 class="page-title">
            Archive
        </h3>
        <div class="table-toolbar">
            <div class="row">
            </div>
        </div>
        <table class="table table-striped table-bordered datatable-ajax">
            <thead>
                <tr>
                    <th>Status</th>
                    <th>Date Submitted</th>
                    <th>Requester</th>
                    <th>Amount of Request</th>
                    <th>Budget Manager</th>
                    <th>Budget Category</th>
                    <th>Actions</th>
                    <th>Export</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
@endsection