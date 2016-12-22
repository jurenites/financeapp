<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
    <meta charset="utf-8"/>
    <title>Funds Request App</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport"/>
    <meta content="" name="description"/>
    <meta content="" name="author"/>
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css"/>
    <link href="/assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
    <link href="/assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css"/>
    <link href="/assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="/assets/global/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css"/>
    <link href="/assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css"/>
    <!-- END GLOBAL MANDATORY STYLES -->
    <!-- BEGIN THEME STYLES -->
    <link href="/assets/global/css/components.css" rel="stylesheet" type="text/css"/>
    <link href="/assets/global/css/plugins.css" rel="stylesheet" type="text/css"/>
    <link href="/assets/admin/layout/css/layout.css" rel="stylesheet" type="text/css"/>
    <link href="/assets/admin/layout/css/themes/default.css" rel="stylesheet" type="text/css" id="style_color"/>
    <link href="/assets/admin/layout/css/custom.css" rel="stylesheet" type="text/css"/>
    <link href="/assets/global/plugins/bootstrap-toastr/toastr.min.css" rel="stylesheet" type="text/css"/>
    <!-- END THEME STYLES -->
    <!-- BEGIN CUSTOM STYLES -->
    @yield('css')
    <link href="/assets/app/css/common.css" rel="stylesheet" type="text/css"/>
    <!-- END CUSTOM STYLES -->
    <link rel="shortcut icon" href="favicon.ico"/>
</head>
<!-- END HEAD -->
<body class="page-header-fixed page-quick-sidebar-over-content page-full-width">
    <!-- BEGIN HEADER -->
    @if (!Auth::guest())
        <div class="page-header navbar navbar-fixed-top">
            <!-- BEGIN HEADER INNER -->
            <div class="page-header-inner">
                <!-- BEGIN LOGO -->
                <div class="page-logo">
                    <a href="/" class="navbar-brand">
                        Funds Request App
                    </a>
                </div>
                <!-- END LOGO -->

                <!-- BEGIN RESPONSIVE MENU TOGGLER -->
                <div class="hor-menu">
                    <ul class="nav navbar-nav">
                        <li class="classic-menu-dropdown {{ Request::is('user/dashboard') || Request::is('manager/dashboard') || Request::is('admin/dashboard') ? ' active ' : '' }}">
                            <a href="/">
                            Dashboard <span class="selected">
                            </span>
                            </a>
                        </li>
                        @if (Entrust::hasRole(['admin', 'budget_manager']))
                            <li class="classic-menu-dropdown {{ Request::is('user/report') || Request::is('manager/report') || Request::is('admin/report') ? ' active ' : '' }}">
                                <a href="{{ action("$currentNamespace\RequestFormController@report") }}">
                                Reports <span class="selected">
                                </span>
                                </a>
                            </li>
                        @endif
                        @if (Entrust::hasRole(['admin']))
                            <li class="classic-menu-dropdown {{ Request::is('user/users') || Request::is('manager/users') || Request::is('admin/users') ? ' active ' : '' }}">
                                <a href="{{ action("$currentNamespace\UserController@index") }}">
                                Users <span class="selected">
                                </span>
                                </a>
                            </li>
                            <li class="classic-menu-dropdown {{ Request::is('user/categories') || Request::is('manager/categories') || Request::is('admin/categories') ? ' active ' : '' }}">
                                <a href="{{ action("$currentNamespace\BudgetCategoryController@index") }}">
                                Categories <span class="selected">
                                </span>
                                </a>
                            </li>
                        @endif
                        @if (Entrust::hasRole(['admin', 'budget_manager']))
                            <li class="classic-menu-dropdown {{ Request::is('user/archive') || Request::is('manager/archive') || Request::is('admin/archive') ? ' active ' : '' }}">
                                <a href="{{ action("$currentNamespace\RequestFormController@archive") }}">
                                Archive <span class="selected">
                                </span>
                                </a>
                            </li>
                        @endif
                    </ul>
                </div>
                <!-- END RESPONSIVE MENU TOGGLER -->
                <!-- BEGIN TOP NAVIGATION MENU -->
                <div class="top-menu">
                    <ul class="nav navbar-nav pull-right">
                        <!-- BEGIN USER LOGIN DROPDOWN -->
                        <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                        <li class="dropdown dropdown-user">
                            <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                <span class="username">
                                {{ Auth::user()->name }} </span>
                                <i class="fa fa-angle-down"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-default">
                                <li>
                                    <a href="{{ action("$currentNamespace\UserController@edit", Auth::user()->id) }}">
                                    <i class="icon-user"></i> My Profile </a>
                                </li>
                                <li class="divider">
                                </li>
                                <li>
                                    <a href="/logout">
                                        <i class="icon-key"></i> Log Out
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="dropdown dropdown-quick-sidebar-toggler">
                            <a href="/logout" class="dropdown-toggle">
                                <i class="icon-logout"></i>
                            </a>
                        </li>
                    </ul>
                </div>
                <!-- END TOP NAVIGATION MENU -->
            </div>
            <!-- END HEADER INNER -->
        </div>
    @endif
    <!-- END HEADER -->
    <div class="clearfix"></div>
    <!-- BEGIN CONTAINER -->
    <div class="{{ Auth::guest() ? '' : 'page-container' }}">
        <!-- BEGIN CONTENT -->
        <div class="page-content-wrapper">
            <!-- BEGIN PAGE CONTENT-->
            @yield('content')
            <!-- END PAGE CONTENT-->
        </div>
        <!-- END CONTENT -->
    </div>
    <!-- END CONTAINER -->
    <!-- BEGIN FOOTER -->
<!--     <div class="page-footer">

    </div> -->
    <!-- END FOOTER -->
    <!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
    <!-- BEGIN CORE PLUGINS -->
    <!--[if lt IE 9]>
    <script src="/assets/global/plugins/respond.min.js"></script>
    <script src="/assets/global/plugins/excanvas.min.js"></script> 
    <![endif]-->
    <script src="/assets/global/plugins/jquery.min.js" type="text/javascript"></script>
    <script src="/assets/global/plugins/jquery-migrate.min.js" type="text/javascript"></script>
    <!-- IMPORTANT! Load jquery-ui-1.10.3.custom.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
    <script src="/assets/global/plugins/jquery-ui/jquery-ui.min.js" type="text/javascript"></script>
    <script src="/assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="/assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script>
    <script src="/assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
    <script src="/assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
    <script src="/assets/global/plugins/jquery.cokie.min.js" type="text/javascript"></script>
    <script src="/assets/global/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
    <script src="/assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
    <script src="/assets/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
    <script src="/assets/global/plugins/moment.min.js" type="text/javascript"></script>
    <!-- END CORE PLUGINS -->
    <script src="/assets/global/scripts/metronic.js" type="text/javascript"></script>
    <script src="/assets/admin/layout/scripts/layout.js" type="text/javascript"></script>
    <script src="/assets/global/plugins/bootstrap-toastr/toastr.min.js" type="text/javascript"></script>
    <script src="/assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js" type="text/javascript"></script>
    <script src="/assets/app/js/common.js" type="text/javascript"></script>
    <script>
        jQuery(document).ready(function() {    
            Metronic.init(); // init metronic core components
            Layout.init(); // init current layout

            @if (Session::has('success'))
                toastr.success('{{ Session::get('success') }}');
            @endif
            @if (Session::has('info'))
                toastr.info('{{ Session::get('info') }}');
            @endif
            @if (Session::has('warning'))
                toastr.warning('{{ Session::get('warning') }}');
            @endif
            @if (Session::has('error'))
                toastr.error('{{ Session::get('error') }}');
            @endif
        });
    </script>
    @yield('javascript')
    <!-- END JAVASCRIPTS -->
</body>
</html>