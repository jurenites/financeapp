@extends('layouts.app')

@section('css')
    <link rel="stylesheet" type="text/css" href="/assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css">
@endsection

@section('javascript')
    <script type="text/javascript" src="/assets/global/plugins/datatables/media/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="/assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js"></script>
    <script src="/assets/app/js/budgetCategory.js" type="text/javascript"></script>
@endsection

@section('content')
    <div class="page-content">
        <h3 class="page-title">
            Categories
        </h3>
        <div class="table-toolbar">
            <div class="row">
                <div class="col-md-12">
                    <div class="btn-group">
                        <a class="btn green" href="javascript:;" id="add_new_budget_category">
                            Add New <i class="fa fa-plus"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <table class="table table-striped table-bordered" id="budget_categories_table" data-token="{{ csrf_token() }}">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                @foreach($budgetCategories as $category)
                    <tr data-id="{{ $category->id }}">
                        <td>{{ $category->name }}</td>
                        <td>
                            <a href="javascript:;" class="edit btn default btn-xs purple">
                                <i class="fa fa-edit"></i>
                                Edit 
                            </a>
                        </td>
                        <td>
                            <a href="javascript:;" class="delete btn default btn-xs red">
                                <i class="fa fa-times"></i>
                                Delete 
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection