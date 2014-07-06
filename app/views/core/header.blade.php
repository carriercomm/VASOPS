<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>VATSIM Virtual Airline System 1.0</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{ HTML::style('bootstrap/css/bootstrap.css') }}
    {{ HTML::style('css/flat-ui.css') }}
    {{ HTML::style('css/custom.css') }}
    <!-- Vatsim Favicon -->
    <link rel="shortcut icon" href="images/favicon.ico">

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->
    <!--[if lt IE 9]>
    <script src="{{ URL::to('/') }}/js/html5shiv.js"></script>
    <![endif]-->
</head>
<body>
<div class="container">
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
                    <a id="applyBtn" class="btn btn-success" href="#">Apply to be a VA Partner</a>
                    @endif
                    <a id="currentBtn" class="btn btn-success" href="#">Current VAs</a>
                    <a id="findBtn" class="btn btn-success" href="#">Search VAs</a>
                    @if(Auth::user()->check())
                    <a class="btn" href="{{URL::to('va')}}">Manage VA</a>
                    @endif
                    @else
                    @if(!Auth::user()->check())
                    <a id="applyBtn" class="btn btn-success" href="{{URL::to('/')}}/#moduleApply">Apply to be a VA Partner</a>
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
        <div style="margin-top: -15px; display: none;" id="loginErrorCid" class="span2 offset4">
            <span class="label label-important">Invalid VATSIM CID. Please try again.</span>
        </div>
        <div style="margin-top: -15px; display: none;" id="loginErrorPassword" class="span2 offset4">
            <span class="label label-important">Invalid VATSIM Password. Please try again.</span>
        </div>
        @if (!Auth::user()->check())
        <p class="span3 offset1">
        <form id="loginForm" style=" margin-top: 10px;" class="form-inline">
            <div class="controls controls-row">
                <input name="inputCid" id="login_cid" class="input-medium" type="text" value="" placeholder="CID" class="span3"/>
                <input name="inputPassword" class="input-medium" type="password" value="" placeholder="Password" class="span3"/>
                <input id="submitLoginForm" type="submit" class="btn btn-success" value="Go" class="span3"/>
            </div>
        </form>
        </p>
        @endif
    </div>