<form action="{{ $user->id ? action("$currentNamespace\UserController@update", $user->id) : action("$currentNamespace\UserController@store") }}" method="post" class="user-form" novalidate enctype="multipart/form-data">
    {!! csrf_field() !!}
    @if ($user->id)
        <input name="_method" type="hidden" value="PUT">
        <input name="id" type="hidden" value="{{ $user->id }}">
    @endif
    <div class="row">
        <div class="col-md-12">
            <div class="portlet box blue">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-user"></i>
                        Personal info
                        <span class="required" aria-required="true">*</span>
                    </div>
                </div>
                <div class="portlet-body form">
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-user"></i>
                                        </span>
                                        <input placeholder="Full Name" type="text" class="form-control" name="name" value="{{ old('name', $user->name) }}">
                                    </div>
                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-envelope"></i>
                                        </span>
                                        <input placeholder="Email Address" type="text" class="form-control" name="email" value="{{ old('email', $user->email) }}">
                                    </div>
                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-phone"></i>
                                        </span>
                                        <input placeholder="Phone Number" type="text" class="form-control" name="phone" value="{{ old('phone', $user->phone) }}">
                                    </div>
                                    @if ($errors->has('phone'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('phone') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-lock"></i>
                                        </span>
                                        <input id="password" class="form-control placeholder-no-fix" type="password" autocomplete="off" placeholder="Password" name="password">
                                    </div>
                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-check"></i>
                                        </span>
                                        <input class="form-control placeholder-no-fix" type="password" autocomplete="off" placeholder="Re-type Password" name="password_confirmation">
                                    </div>
                                    @if ($errors->has('password_confirmation'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('password_confirmation') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-12">
                                @if (Entrust::hasRole('admin'))
                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="fa fa-unlock"></i>
                                            </span>
                                            <select name="role" class="form-control">
                                                @foreach($roles as $key => $role)
                                                    <option data-key="{{ $role->name }}" value="{{ $role->id }}"  {{ old('role', $user->hasRole($role->name) ? $role->id : '') == $role->id ? ' selected' : '' }}>{{ $role->display_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                @else
                                    <input type="hidden" name="role" value="{{ $user->roles()->first() ? $user->roles()->first()->id : $roles->where('name', 'user')->first()->id }}">
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div> 
        </div>
    </div>
    @if (Entrust::hasRole(['budget_manager', 'admin']))
        <div class="row hidden" id="budget-categories">
            <div class="col-md-12">
                <div class="portlet box blue">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-bars"></i>
                            Budget Categories
                        </div>
                    </div>
                    <div class="portlet-body">
                        <table class="table table-striped table-bordered inline-edit-datatable">
                            <thead>
                                <tr>
                                    <th><i class="fa fa-check-square-o"></i></th>
                                    <th>Name</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($budgetCategories as $budgetCategory)
                                    <tr>
                                        <td><input type="checkbox" name="budgetCategories[]" value="{{ $budgetCategory->id }}" {{ $user->budgetCategories->find($budgetCategory->id) ? 'checked' : '' }}></td>
                                        <td>{{ $budgetCategory->name }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div> 
            </div>
        </div>
    @endif

    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <button class="btn green pull-right" type="Submit">Save User</button>
            </div>
        </div>
    </div>
</form>