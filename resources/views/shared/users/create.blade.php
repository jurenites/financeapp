@extends('layouts.app')

@section('css')
	<link rel="stylesheet" type="text/css" href="/assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css">
@endsection

@section('javascript')
    <script type="text/javascript" src="/assets/global/plugins/datatables/media/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="/assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js"></script>
    <script src="/assets/app/js/user.js" type="text/javascript"></script>
@endsection

@section('content')
    <div class="page-content">
        <h3 class="page-title">
            Create User
        </h3>
        @include('shared.users._form')
    </div>
@endsection