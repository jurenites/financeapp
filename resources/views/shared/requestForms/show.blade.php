@extends('layouts.app')

@section('css')

@endsection

@section('javascript')

@endsection

@section('content')
    <div class="page-content">
        <h3 class="page-title">
            <a href="{{ action("$currentNamespace\RequestFormController@index") }}" class="btn green">
                <i class="fa fa-arrow-left"></i>
                Back
            </a>
            Request Details: {{ $requestForm->created_at->format('m/d/Y') }} from {{ $requestForm->name }}
            <span class="label label-{{ getLabelCssClassByStatus($requestForm->status) }}">
                {{ $requestForm->status }}
            </span>
        </h3>
        <div class="row">
            <div class="col-md-4">
                <div class="portlet box blue">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-user"></i>
                            Person Requesting Funds
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div class="row static-info">
                            <div class="col-md-4 name">
                                Request Date
                            </div>
                            <div class="col-md-8 value">
                                {{ $requestForm->created_at->format('m/d/Y') }}
                            </div>
                        </div>
                        <div class="row static-info">
                            <div class="col-md-4 name">
                                Requester
                            </div>
                            <div class="col-md-8 value">
                                {{ $requestForm->name }}
                            </div>
                        </div>
                        <div class="row static-info">
                            <div class="col-md-4 name">
                                E-mail
                            </div>
                            <div class="col-md-8 value">
                                {{ $requestForm->email }}
                            </div>
                        </div>
                        <div class="row static-info">
                            <div class="col-md-4 name">
                                Phone
                            </div>
                            <div class="col-md-8 value">
                                {{ $requestForm->phone }}
                            </div>
                        </div>
                        <div class="row static-info">
                            <div class="col-md-4 name">
                                Budget Manager
                            </div>
                            <div class="col-md-8 value">
                                {{ $requestForm->budgetManager ? $requestForm->budgetManager->name : 'N\A' }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="portlet box blue">
                    <div class="portlet-title">
                        <div class="caption">
                            Request Information
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div class="row static-info">
                            <div class="col-md-5 name">
                                Budget Category
                            </div>
                            <div class="col-md-7 value">
                                {{ $requestForm->budgetCategory ? $requestForm->budgetCategory->name : 
                                    ($requestForm->budgetManager ? 'Unknown' : 'N\A') }}
                            </div>
                        </div>
                        <div class="row static-info">
                            <div class="col-md-5 name">
                                Request Type
                            </div>
                            <div class="col-md-7 value">
                                {{ $requestForm->getType() }}
                            </div>
                        </div>
                        <div class="row static-info">
                            <div class="col-md-5 name">
                                Method of Payment
                            </div>
                            <div class="col-md-7 value">
                                {{ $requestForm->payment_method ?: 'N\A' }}
                            </div>
                        </div>
                        <div class="row static-info">
                            <div class="col-md-5 name">
                                Amount
                            </div>
                            <div class="col-md-7 value">
                                ${{ $requestForm->amount }}
                            </div>
                        </div>
                        <div class="row static-info">
                            <div class="col-md-5 name">
                                Make Payable To
                            </div>
                            <div class="col-md-7 value">
                                {{ $requestForm->payable_to_name }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @if (shouldShowMailingAddressBlock($requestForm))
                <div class="col-md-4">
                    <div class="portlet box blue">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-map-marker"></i>
                                Mailing Address
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div class="row static-info">
                                <div class="col-md-3 name">
                                    Address 1
                                </div>
                                <div class="col-md-9 value">
                                    {{ $requestForm->address1 ?: 'N\A' }}
                                </div>
                            </div>
                            <div class="row static-info">
                                <div class="col-md-3 name">
                                    Address 2
                                </div>
                                <div class="col-md-9 value">
                                    {{ $requestForm->address2 ?: 'N\A' }}
                                </div>
                            </div>
                            <div class="row static-info">
                                <div class="col-md-3 name">
                                    City
                                </div>
                                <div class="col-md-9 value">
                                    {{ $requestForm->city ?: 'N\A' }}
                                </div>
                            </div>
                            <div class="row static-info">
                                <div class="col-md-3 name">
                                    State
                                </div>
                                <div class="col-md-9 value">
                                    {{ $requestForm->state ?: 'N\A' }}
                                </div>
                            </div>
                            <div class="row static-info">
                                <div class="col-md-3 name">
                                    Zip
                                </div>
                                <div class="col-md-9 value">
                                    {{ $requestForm->zip ?: 'N\A' }} 
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            @if (shouldShowDirectDepositBlock($requestForm))
                <div class="col-md-4">
                    <div class="portlet box blue">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-credit-card"></i>
                                Direct Deposit Information
                            </div>
                        </div>
                        <div class="portlet-body additional-portlet-body">
                            <div class="row static-info">
                                <div class="col-md-4 name">
                                    Bank Name
                                </div>
                                <div class="col-md-8 value">
                                    {{ $requestForm->bank_name ?: 'N\A' }}
                                </div>
                            </div>
                            <div class="row static-info">
                                <div class="col-md-4 name">
                                    Account Type
                                </div>
                                <div class="col-md-8 value">
                                    {{ $requestForm->account_type ?: 'N\A' }}
                                </div>
                            </div>
                            <div class="row static-info">
                                <div class="col-md-4 name">
                                    Routing Number 
                                </div>
                                <div class="col-md-8 value">
                                    {{ $requestForm->routing_number ?: 'N\A' }}
                                </div>
                            </div>
                            <div class="row static-info">
                                <div class="col-md-4 name">
                                    Account Number
                                </div>
                                <div class="col-md-8 value">
                                    {{ $requestForm->account_number ?: 'N\A' }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="portlet box blue">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-file-text-o"></i>
                            Documents
                        </div>
                    </div>
                    <div class="portlet-body">
                        <ul class="feeds">
                            @foreach($requestForm->documents as $document)
                                <li>
                                    <div class="col1">
                                        <a href="{{ action("$currentNamespace\DocumentController@download", $document->id) }}">
                                            {{ $document->original_name }}
                                        </a>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>     
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="portlet box blue">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-history"></i>
                            Event log
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div class="scroller scroller-fixed" data-always-visible="1" data-rail-visible1="1">
                            <ul class="feeds">
                                @foreach($requestForm->eventLog as $event)
                                    <li>
                                        <div class="col1">
                                            <div class="cont">
                                                <div class="cont-col1">
                                                    <div class="label label-sm label-{{ getLabelCssClassByEventStatus($event->type) }}">
                                                        <i class="fa {{ getIconCssClassByEventStatus($event->type) }}"></i>
                                                    </div>
                                                </div>
                                                <div class="cont-col2">
                                                    <div class="desc">
                                                        {{ $event->getMessage() }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col2 wide-col2">
                                            <div class="date">
                                                {{ $event->created_at->format('m/d/Y h:ia') }}
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>     
            </div>
            <div class="col-md-6">
                <div class="portlet box blue">
                    <div class="portlet-title">
                        <div class="caption">
                            Request Explanation
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div class="scroller scroller-fixed" data-always-visible="1" data-rail-visible1="1">
                            <div class="row static-info">
                                <div class="col-md-12 name">
                                    {{ $requestForm->explanation }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include("$currentNamespace.requestForms._notes")
    </div>
@endsection