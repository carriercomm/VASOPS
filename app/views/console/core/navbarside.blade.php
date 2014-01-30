<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav" id="side-menu">
            <li class="sidebar-search">
                <div class="input-group custom-search-form">
                    <input type="text" class="form-control" placeholder="Search for a VA...">
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="button">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                </div>
                <!-- /input-group -->
            </li>
            <li>
                <a href="{{ URL::route('console') }}"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
            </li>
            <li>
                <a href="#"><i class="fa fa-comments fa-fw"></i> Help Desk <span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="#"> <i class="fa fa-eye fa-fw"></i> Tickets Assigned to Me</a>
                    </li>
                    <li>
                        <a href="#"> <i class="fa fa-comment fa-fw"></i> Open Tickets</a>
                    </li>
                    <li>
                        <a href="#"> <i class="fa fa-clock-o fa-fw"></i> Closed Tickets</a>
                    </li>
                </ul>
                <!-- /.nav-second-level -->
            </li>
            <li>
                <a href="#"><i class="fa fa-envelope fa-fw"></i> Email Templates</a>
            </li>
            <li>
                <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i> Global Statistics</a>
            </li>
            <li>
                <a href="#"><i class="fa fa-bookmark fa-fw"></i> Administrator Functions<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{{ URL::route('consolebroadcasts') }}"> <i class="fa fa-bullhorn fa-fw"></i> Console Broadcasts</a>
                    </li>
                    <li>
                        <a href="blank.html"> <i class="fa fa-users fa-fw"></i> Manage Audit Managers</a>
                    </li>
                    <li>
                        <a href="login.html"> <i class="fa fa-exchange fa-fw"></i> Assign Auditors</a>
                    </li>
                    <li>
                        <a href="login.html"> <i class="fa fa-ellipsis-h fa-fw"></i> Manage Categories</a>
                    </li>
                </ul>
                <!-- /.nav-second-level -->
            </li>
        </ul>
        <!-- /#side-menu -->
    </div>
    <!-- /.sidebar-collapse -->
</nav>
<!-- /.navbar-static-side -->