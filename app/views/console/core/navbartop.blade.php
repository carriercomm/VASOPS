<div id="wrapper">

<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
<div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
    </button>
    <a class="navbar-brand" href="{{ URL::route('console') }}"><strong>VA Auditor Console</strong> 1.0</a>
</div>
<!-- /.navbar-header -->

<ul class="nav navbar-top-links navbar-right">
<li class="dropdown">
    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
        <i class="fa fa-user fa-fw"></i> {{{ ConsoleUser::getName(Auth::consoleuser()->get()->cid) }}} <i class="fa fa-caret-down"></i>
    </a>
    <ul class="dropdown-menu dropdown-user">
        <li><a href="{{ URL::route('consolelogout') }}"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
        </li>
    </ul>
    <!-- /.dropdown-user -->
</li>
<!-- /.dropdown -->
</ul>
<!-- /.navbar-top-links -->

</nav>
<!-- /.navbar-static-top -->