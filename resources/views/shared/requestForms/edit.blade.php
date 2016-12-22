@extends('layouts.app')

@section('css')
    <link rel="stylesheet" type="text/css" href="/assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css">
@endsection

@section('javascript')
    <script type="text/javascript" src="/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
    <script src="/assets/app/js/requestForm.js" type="text/javascript"></script>
@endsection

@section('content')
    <div class="page-content">
        <h3 class="page-title pull-left">
            Funds Request Form
        </h3>
        @include('shared.requestForms._form')
    </div>
@endsection