@extends('layouts.app')

@section('css')

@endsection

@section('javascript')

@endsection

@section('content')
    <div class="page-content">
        <h3 class="page-title">
            Import Budget Manageres
        </h3>
        <form action="{{ action("$currentNamespace\ServiceController@doImportBudgetManagers") }}" method="post"novalidate enctype="multipart/form-data">
            {!! csrf_field() !!}
            <div class="row">
                <div class="col-md-12">
                    <div class="portlet box blue">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-user"></i>
                                Budget Managers (csv)
                                <span class="required" aria-required="true">*</span>
                            </div>
                        </div>
                        <div class="portlet-body form">
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group{{ $errors->has('file') ? ' has-error' : '' }}">
                                            <label for="file">Upload file:</label>
                                            <input type="file" name="file" id="file">
                                            @if ($errors->has('name'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('file') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> 
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <button class="btn green pull-right" type="Submit">Submit</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection