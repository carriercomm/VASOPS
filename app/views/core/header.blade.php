<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>VATSIM Virtual Airline System 1.0</title>
    {{ HTML::style('bootstrap/css/bootstrap.css') }}
    {{ HTML::style('css/flat-ui.css') }}
    {{ HTML::style('css/custom.css') }}
    {{ HTML::style('css/plugins/font-awesome/css/font-awesome.css') }}
    <!-- Vatsim Favicon -->
    <link rel="shortcut icon" href="images/favicon.ico">

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->
    <!--[if lt IE 9]>
    <script src="{{ URL::to('/') }}/js/html5shiv.js"></script>
    <![endif]-->
</head>
<body>
<div id="container" class="container">
    @if (Session::get('topmessage') != "")
    <div style="margin-top: 35px;" class="row">
        <div class="span12">
            <div class="alert alert-warning">{{{ Session::get('topmessage') }}}</div>
        </div>
    </div>
    @endif
    <div class="demo-headline">
        <h1 id="title" class="demo-logo">
            <!--<div class="logo"></div>-->
            VATSIM VA System
            <small>1.0</small>
        </h1>
    </div>
    <!-- /demo-headline -->
    <div class="row">
        <div class="span3">
            <div class="btn-toolbar">
                <div class="btn-group">
                    @if (Route::currentRouteName() == "index")
                    @if(!Auth::user()->check())
                    <a id="applyBtn" class="btn btn-success" href="#"><i class="fa fa-user fa-fw"></i> Apply</a>
                    @endif
                    <a id="currentBtn" class="btn btn-success" href="#"><i class="fa fa-bars fa-fw"></i> Current VAs</a>
                    <a id="findBtn" class="btn btn-success" href="#"><i class="fa fa-search fa-fw"></i> Search VAs</a>
                    @if(!Auth::user()->check())
                    <a id="supportBtn" class="btn btn-success" href="{{URL::to('/')}}/#moduleSupport"><i class="fa fa-support fa-fw"></i> Support</a>
                    @endif
                    @if(Auth::user()->check())
                    <a class="btn" href="{{URL::to('va')}}">Manage VA</a>
                    @endif
                    @else
                    @if(!Auth::user()->check())
                    <a id="applyBtn" class="btn btn-success" href="{{URL::to('/')}}/#moduleApply">Apply</a>
                    @endif
                    <a id="currentBtn" class="btn btn-success" href="{{URL::to('/')}}/#moduleCurrent">Current VAs</a>
                    <a id="findBtn" class="btn btn-success" href="{{URL::to('/')}}/#moduleFind">Search VAs</a>
                    @if(Auth::user()->check())
                    <a class="btn" href="{{URL::to('va')}}">Manage VA</a>
                    @endif
                    @endif

                </div>
            </div>
        </div>
        <!--<div class="span6 offset5">-->
        @if (Auth::user()->check())
        <div style="margin-top: 10px; position: relative;" id="helloUser" class="span2 offset7">
            <a id="helloUser" class="btn btn-inverse"><i id="helloUserIcon" class="fui-user"></i>Hello, <span id="helloUserName">{{Session::get('fname');}}</span></a>
        </div>
        @else
        <div style="margin-top: 10px; display: none; position: relative;" id="helloUser" class="span2 offset7">
            <a id="helloUser" class="btn btn-inverse"><i id="helloUserIcon" class="fui-user"></i> Hello, <span id="helloUserName"></span></a>
        </div>
        @endif
        <p style="margin-top: 10px; display: none;" id="loginLoading" class="span2 offset7">
            <img alt="Loading..." src="{{ URL::to('/') }}/images/loader.gif">
        </p>
        <div style="margin-top: -15px; display: none;" id="loginErrorEmail" class="span2 offset4">
            <span class="label label-important">Invalid email. Please try again.</span>
        </div>
        <div style="margin-top: -15px; display: none;" id="loginErrorPassword" class="span2 offset4">
            <span class="label label-important">Invalid password. Please try again.</span>
        </div>
        <div style="margin-top: -15px; display: none;" id="forgotPassErrorEmail" class="span2 offset4">
            <span class="label label-important">That email doesn't appear to be associated with an account.</span>
        </div>
        <div style="margin-top: -15px; display: none;" id="forgotPassSuccess" class="span2 offset4">
            <span class="label label-success">Please check your email for a link to reset your password.</span>
        </div>
        @if (!Auth::user()->check())
        <div class="span6 offset3">
        <form id="loginForm" style=" margin-top: 10px;" class="form-inline">
            <div class="controls controls-row">
                <span id="loginFormContainer">
                    <input name="inputEmail" id="login_cid" class="input-medium" type="text" value="" placeholder="Email" />
                    <input name="inputPassword" class="input-medium" type="password" value="" placeholder="Password" />
                    <input id="submitLoginForm" type="submit" class="btn btn-success" value="Go" />
                    <button data-title="Forgot Password" id="forgotPassBtn" class="btn btn-default tooltip-bottom"><i class="fa fa-question fa-fw"></i></button>
                </span>
                <span style="display: none;" id="forgotPassFormContainer">
                    <input id="forgotPassInputEmail" type="text" class="input-large" placeholder="Enter your account email..." />
                    <button class="btn btn-info" id="forgotPassInputSubmitBtn"><i style="display: none;" class="fa fa-circle-o-notch fa-fw fa-spin"></i> Reset Password</button>
                    <button data-title="Return to Login" id="cancelForgotPassBtn" class="btn btn-default tooltip-bottom"><i class="fa fa-arrow-right fa-fw"></i></button>
                </span>
            </div>
        </form>
        </div>
        @endif
    </div>