<form action="{{ $requestForm->id ? action("$currentNamespace\RequestFormController@update", $requestForm->id) : action("$currentNamespace\RequestFormController@store") }}" method="post" class="request-form" novalidate enctype="multipart/form-data">
    {!! csrf_field() !!}
    @if ($requestForm->id)
        <input name="_method" type="hidden" value="PUT">
    @endif
    <div class="row">
        <div class="col-md-2">
            <div class="form-group">
                <input type="text" class="form-control {{ Entrust::hasRole(['admin', 'budget_manager']) ? 'datepicker' : '' }}" name="created_at"  value="{{ old('created_at', $requestForm->created_at->format('m/d/Y')) }}" {{ Entrust::hasRole(['admin', 'budget_manager']) ? '' : 'readonly' }}>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="portlet box blue">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-user"></i>
                        Person Requesting Funds
                        <span class="required" aria-required="true">*</span>
                    </div>
                </div>
                <div class="portlet-body form">
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-user"></i>
                                        </span>
                                        <input placeholder="Full Name" type="text" class="form-control" name="name" value="{{ old('name', $requestForm->name) }}">
                                    </div>
                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-envelope"></i>
                                        </span>
                                        <input placeholder="Your Email Address" type="text" class="form-control" name="email" value="{{ old('email', $requestForm->email) }}">
                                    </div>
                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-phone"></i>
                                        </span>
                                        <input placeholder="Phone Number" type="text" class="form-control" name="phone" value="{{ old('phone', $requestForm->phone) }}">
                                    </div>
                                    @if ($errors->has('phone'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('phone') }}</strong>
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
            <div class="portlet box blue">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-credit-card"></i>
                        Need money from NCC?
                        <span class="required" aria-required="true">*</span>
                        <a href="javascript:;" class="custom-popover" data-container="body" data-title="Need to become an approved Contractor?" data-trigger="hover" data-placement="bottom">
                            <span>Need to become an approved Contractor?</span>
                        </a>
                        <div class="popover-content" style="display: none;">
                            <div class="text-center">
                                <div class="bold">Need to become an approved Contractor?</div>
                                <div>Download and submit these forms</div>
                                <div>to the finance department</div>
                                <div>
                                    <a href="javascript:;">W9</a> &
                                    <a href="javascript:;">Direct Deposit form</a>
                                </div>
                                <div>finance@theaterchurch.com</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="portlet-body form">
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group{{ $errors->has('type') ? ' has-error' : '' }}">
                                    <label>Are you requesting…</label>
                                    <div class="radio-list">
                                        @foreach ($types as $key => $type)
                                            <label>
                                                <input type="radio" name="type" data-key="{{ $key }}" value="{{ $type }}" {{ old('type', $requestForm->type) == $type  ? ' checked="checked"' : '' }}>
                                                {{ $type }}
                                            </label>
                                        @endforeach
                                    </div>
                                    @if ($errors->has('type'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('type') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('payment_method') ? ' has-error' : '' }}" id="payment_methods_wrapper">
                                    @foreach($paymentMethods as $paymentMethodGroupKey => $paymentMethodGroup)
                                        <select name="payment_method_{{ $paymentMethodGroupKey }}" class="form-control input-x-large hidden payment_method_select" data-key="{{ $paymentMethodGroupKey }}">
                                            @foreach($paymentMethodGroup as $key => $paymentMethod)
                                                <option data-key="{{ $key }}" value="{{ $paymentMethod }}"  {{ old('payment_method', $requestForm->payment_method) == $paymentMethod  ? ' selected' : '' }}>{{ $paymentMethod }}</option>
                                            @endforeach
                                        </select>
                                    @endforeach
                                    @if ($errors->has('payment_method'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('payment_method') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="files">Upload your Receipt or Invoice here:</label>
                                    <input type="file" multiple="multiple" name="files[]" id="files">
                                </div>
                                <ul class="feeds documents">
                                    @foreach($requestForm->documents as $document)
                                        <input type="hidden" name="old_files[]" value="{{ $document->id }}">
                                        <li>
                                            <div class="col1">
                                                <a href="{{ action("$currentNamespace\DocumentController@download", $document->id) }}">
                                                    {{ $document->original_name }}
                                                </a>
                                            </div>
                                            <div class="col2">
                                                <a href="javascript:;" data-action="{{ action("$currentNamespace\DocumentController@destroy", $document->id) }}" data-id="{{ $document->id }}" class="btn default btn-xs red delete-document" data-token="{{ csrf_token() }}">
                                                    <i class="fa fa-times"></i>
                                                    Delete
                                                </a>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="col-md-8">
                                <div id="mailing-address" class="hidden">
                                    <label>
                                        Mailing Address
                                    </label>
                                    <div class="form-group{{ $errors->has('address1') ? ' has-error' : '' }}">
                                        <input placeholder="Address 1" class="form-control" type="text" name="address1" value="{{ old('address1', $requestForm->address1) }}">
                                        @if ($errors->has('address1'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('address1') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group{{ $errors->has('address2') ? ' has-error' : '' }}">
                                        <input placeholder="Address 2" class="form-control" type="text" name="address2" value="{{ old('address2', $requestForm->address2) }}">
                                        @if ($errors->has('address2'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('address2') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group{{ $errors->has('city') || $errors->has('state') || $errors->has('zip') ? ' has-error' : '' }}">
                                        <div class="row">
                                            <div class="col-md-7">
                                                <input placeholder="City" class="form-control" type="text" name="city" value="{{ old('city', $requestForm->city) }}">
                                                @if ($errors->has('city'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('city') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="col-md-2">
                                                <input placeholder="State" class="form-control" type="text" name="state" value="{{ old('state', $requestForm->state) }}">
                                                @if ($errors->has('state'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('state') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="col-md-3">
                                                <input placeholder="Zip" class="form-control" type="text" name="zip" value="{{ old('zip', $requestForm->zip) }}">
                                                @if ($errors->has('zip'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('zip') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="direct-deposit" class="hidden">
                                    <div class="form-group{{ $errors->has('account_type') ? ' has-error' : '' }}">
                                        <div class="radio-list">
                                            <label class="radio-inline">Account Type:</label>
                                            @foreach ($accountTypes as $key => $type)
                                                <label class="radio-inline">
                                                    <input type="radio" name="account_type" data-key="{{ $key }}" value="{{ $type }}" {{ old('account_type', $requestForm->account_type) == $type  ? ' checked="checked"' : '' }}>
                                                    {{ $type }}
                                                </label>
                                            @endforeach
                                        </div>
                                        @if ($errors->has('account_type'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('account_type') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group{{ $errors->has('bank_type') ? ' has-error' : '' }}">
                                        <input placeholder="Bank Name" class="form-control" type="text" name="bank_name" value="{{ old('bank_name', $requestForm->bank_name) }}">
                                        @if ($errors->has('bank_type'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('bank_type') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group{{ $errors->has('routing_number') ? ' has-error' : '' }}">
                                        <input placeholder="Routing Number" class="form-control" type="text" name="routing_number" value="{{ old('routing_number', $requestForm->routing_number) }}">
                                        @if ($errors->has('routing_number'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('routing_number') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group{{ $errors->has('account_number') ? ' has-error' : '' }}">
                                        <input placeholder="Account Number" class="form-control" type="text" name="account_number" value="{{ old('account_number', $requestForm->account_number) }}">
                                        @if ($errors->has('account_number'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('account_number') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div id="per-diem-worksheet" class="hidden">
                                    <a href="/files/Per Diem Cash Request.xlsx">Download Per Diem Cash Request Worksheet</a>
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
            <div class="portlet box blue">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-users"></i>
                        Give us some specifics
                        <span class="required" aria-required="true">*</span>
                    </div>
                </div>
                <div class="portlet-body form">
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group{{ $errors->has('payable_to_name') ? ' has-error' : '' }}">
                                    <input placeholder="Who’s getting the money? (Full Name)" type="text" class="form-control" name="payable_to_name" value="{{ old('payable_to_name', $requestForm->payable_to_name) }}">
                                    @if ($errors->has('payable_to_name'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('payable_to_name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('amount') ? ' has-error' : '' }}">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-usd"></i>
                                        </span>
                                        <input placeholder="Amount" type="text" class="form-control" name="amount" value="{{ old('amount', $requestForm->amount) }}">
                                    </div>
                                    @if ($errors->has('amount'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('amount') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('explanation') ? ' has-error' : '' }}">
                                    <textarea placeholder="Please provide an explanation of the purpose of the payment, for example, the service provided or item purchased. For Short Term Missions Cash requests, please let us know the day and time you would like to pick up the money, and the bill denominations needed." name="explanation" class="form-control" rows="3">{{ old('explanation', $requestForm->explanation) }}</textarea>
                                    @if ($errors->has('explanation'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('explanation') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div id="cash-request-notification" class="hidden">
                                    <div class="note note-info">
                                        <h4 class="block">Please note:</h4>
                                        <p>
                                            Please be sure in the request details you let us know the date and time when the cash needs to be ready!
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group{{ $errors->has('budget_manager_id') ? ' has-error' : '' }}">
                                    <select name="budget_manager_id" class="form-control">
                                        <option value="">Please Select Budget Manager</option>
                                        <option value="">Budget manager not listed</option>
                                        @foreach($budgetManagers as $budgetManager)
                                            <option value="{{ $budgetManager->id }}"  {{ old('budget_manager_id', $requestForm->budget_manager_id) == $budgetManager->id  ? ' selected' : '' }}>{{ $budgetManager->name }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('budget_manager_id'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('budget_manager_id') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group{{ $errors->has('budget_category_id') ? ' has-error' : '' }}">
                                    @foreach($budgetManagers as $budgetManager)
                                        <select name="budget_category_id" class="form-control hidden" data-manager-id="{{ $budgetManager->id }}">
                                            <option value="">Select the Budget Category</option>
                                            <option value="">Unknown</option>
                                            @foreach($budgetManager->budgetCategories as $budgetCategory)
                                                <option value="{{ $budgetCategory->id }}"  {{ old('budget_category_id', $requestForm->budget_category_id) == $budgetCategory->id  ? ' selected' : '' }}>{{ $budgetCategory->name }}</option>
                                            @endforeach
                                        </select>
                                    @endforeach
                                    @if ($errors->has('budget_category_id'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('budget_category_id') }}</strong>
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
                <button class="btn green pull-right" type="Submit">Submit Request</button>
            </div>
        </div>
    </div>
</form>