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
            Users
        </h3>
        <div class="table-toolbar">
            <div class="row">
                <div class="col-md-12">
                    <div class="btn-group">
                        <a class="btn green" href="{{ action("$currentNamespace\UserController@create") }}">
                            Add New <i class="fa fa-plus"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <table class="table table-striped table-bordered datatable">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Access</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->roles()->first() ? $user->roles()->first()->display_name : '' }}</td>
                        <td>
                            <form action="{{ action("$currentNamespace\UserController@destroy", $user->id) }}" method="POST">
                                <input type="hidden" name="_method" value="DELETE">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                <a href="{{ action("$currentNamespace\UserController@edit", $user->id) }}" class="btn default btn-xs purple">
                                    <i class="fa fa-edit"></i>
                                    Edit 
                                </a>
                                <a class="btn default btn-xs red delete-user" href="javascript:;">
                                    <i class="fa fa-times"></i>
                                    Delete
                                </a>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection