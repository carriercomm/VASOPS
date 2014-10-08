<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav" id="side-menu">
            <li class="sidebar-search">
                <form id="searchForm">
                    <div class="input-group custom-search-form">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                        <input name="searchInput" id="searchInput" type="text" class="form-control" placeholder="Search for a VA...">
                                <span class="input-group-btn">
                                    <button id="searchBtn" class="btn btn-default" type="button">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </span>

                    </div>
                </form>
                <!-- /input-group -->
            </li>
            <li>
                <a href="{{ URL::route('console') }}"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
            </li>
            <li>
                <a href="#"><i class="fa fa-comments fa-fw"></i> Help Desk <span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{{ URL::route('console') }}/helpdesk/assigned"> <i class="fa fa-eye fa-fw"></i> Tickets Assigned to Me</a>
                    </li>
                    <li>
                        <a href="{{ URL::route('console') }}/helpdesk/open"> <i class="fa fa-comment fa-fw"></i> Open Tickets</a>
                    </li>
                    <li>
                        <a href="{{ URL::route('console') }}/helpdesk/closed"> <i class="fa fa-clock-o fa-fw"></i> Closed Tickets</a>
                    </li>
                </ul>
                <!-- /.nav-second-level -->
            </li>
            <li>
                <a href="{{ URL::route('consoleassignments') }}"><i class="fa fa-pencil fa-fw"></i> Audit Assignments @if (Assignment::get_NumAssignments() > 0)<span class="label label-warning">{{{ Assignment::get_NumAssignments() > 0 }}}</span>@endif</a>
            </li>
            <li>
                <a href="{{ URL::route('consoleemailtemplates') }}"><i class="fa fa-envelope fa-fw"></i> Email Templates</a>
            </li>
            <li>
                <a href="{{ URL::route('consolestats') }}"><i class="fa fa-bar-chart-o fa-fw"></i> Global Statistics</a>
            </li>
            @if (Auth::consoleuser()->get()->access > 0)
            <li>
                <a href="#"><i class="fa fa-bookmark fa-fw"></i> Administrator Functions<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{{ URL::route('consolebroadcasts') }}"> <i class="fa fa-bullhorn fa-fw"></i> Console Broadcasts</a>
                    </li>
                    <li>
                        <a href="{{ URL::route('consoleemail') }}"><i class="fa fa-envelope fa-fw"></i> Mass Email</a>
                    </li>
                    <li>
                        <a href="{{ URL::route('consoleauditmanagers') }}"> <i class="fa fa-users fa-fw"></i> Manage Audit Managers</a>
                    </li>
                    <li>
                        <a href="{{ URL::route('consoleassignauditors') }}"> <i class="fa fa-exchange fa-fw"></i> Assign Auditors</a>
                    </li>
                    <li>
                        <a href="{{ URL::route('consolecategories') }}"> <i class="fa fa-ellipsis-h fa-fw"></i> Manage Categories</a>
                    </li>
                </ul>
                <!-- /.nav-second-level -->
            </li>
            @endif
        </ul>
        <!-- /#side-menu -->
    </div>
    <!-- /.sidebar-collapse -->
</nav>
<!-- /.navbar-static-side -->