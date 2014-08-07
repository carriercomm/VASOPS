<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>VASOPS Error 500</title>
    {{ HTML::style('bootstrap/css/bootstrap.css') }}
    {{ HTML::style('css/flat-ui.css') }}
    {{ HTML::style('css/custom.css') }}
    {{ HTML::style('css/plugins/font-awesome/css/font-awesome.css') }}
    <!-- Vatsim Favicon -->
    <link rel="shortcut icon" href="images/favicon.ico">
    <style type="text/css">
        html {
            background: url({{ URL::to('/') }}/images/clouds.jpg) no-repeat center center fixed;
        -webkit-background-size: cover;
        -moz-background-size: cover;
        -o-background-size: cover;
        background-size: cover;
        }
    </style>

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->
    <!--[if lt IE 9]>
    <script src="{{ URL::to('/') }}/js/html5shiv.js"></script>
    <![endif]-->
</head>
<body>
<div id="container" class="container">
    <div class="row">
        <div class="span12">
            <h1>Woops, I'm afraid something has gone wrong on our end. <small>500</small></h1>
        </div>
    </div>
</div>
</body>
</html>