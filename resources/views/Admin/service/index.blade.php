@extends('layouts.app')

@section('css')
    <link rel="stylesheet" type="text/css" href="/assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css">
@endsection

@section('javascript')
    <script type="text/javascript" src="/assets/global/plugins/datatables/media/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="/assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js"></script>
@endsection

@section('content')
    <div class="page-content">
        <h3 class="page-title">
            Service Tools
        </h3>
        <div class="table-toolbar">
            <div class="row">
            </div>
        </div>
        <table class="table table-striped table-bordered datatable-ajax">
            <thead>
                <tr>
                    <th>Name</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <a href="{{ action("$currentNamespace\ServiceController@importBudgetManagers") }}">Import Budget Managers (csv)</a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
@endsection