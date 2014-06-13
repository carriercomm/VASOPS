@include('console.core.header')
@include('console.core.navbartop')
@include('console.core.navbarside')
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header"><i class="fa fa-comments fa-fw"></i> Help Desk Ticket <small><i class="fa fa-slack fa-fw"></i>{{{ $ticket->id }}}</small></h1>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Ticket <i class="fa fa-slack fa-fw"></i>{{{ $ticket->id }}}
                    <div>
                        <div class="float-right">
                            <ul style="margin-top: -30px;" class="nav">
                                <li class="dropdown">
                                    <a class="dropdown-toggle" href="#" data-toggle="dropdown">Actions<i class="fa fa-caret-down fa-fw"></i></a>
                                <ul class="dropdown-menu dropdown-messages ticket-dropdown-actions">
                                    @if ($ticket->status == 1)
                                    <li>
                                        <a href="#">
                                            <div>
                                                <i class="fa fa-check-square fa-fw"></i> Close Ticket
                                            </div>
                                        </a>
                                    </li>
                                    @else
                                    <li>
                                        <a href="#">
                                            <div>
                                                <i class="fa fa-history fa-fw"></i> ReOpen Ticket
                                            </div>
                                        </a>
                                    </li>
                                    @endif
                                    @if ($ticket->assigned != Auth::consoleuser()->get()->cid)
                                    <li>
                                        <a href="#">
                                            <div>
                                                <i class="fa fa-hand-o-up fa-fw"></i> Assign To Me
                                            </div>
                                        </a>
                                    </li>
                                    @endif
                                    <li>
                                        <a href="#">
                                            <div>
                                                <i class="fa fa-users fa-fw"></i> Assign To
                                            </div>
                                        </a>
                                    </li>
                                    @if (Auth::consoleuser()->get()->access > 0)
                                    <li class="divider"></li>
                                    <li>
                                        <a href="#">
                                            <div>
                                                <i class="fa fa-times fa-fw"></i> Delete Ticket
                                            </div>
                                        </a>
                                    </li>
                                    @endif
                                </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="col-lg-4">
                        <div class="well ticket-info">
                            <div class="table-responsive">
                                <table class="table table-responsive table-borderless">
                                    <tr><td>ID: </td><td><i class="fa fa-slack fa-fw"></i>{{{ $ticket->id }}}</td></tr>
                                    <tr><td>CID: </td><td>{{{ $ticket->vid }}}</td></tr>
                                    <tr><td>Name: </td><td>{{{ User::getFullName($ticket->vid) }}}</td></tr>
                                    <tr><td>VA Name: </td><td>{{{ User::getVaName($ticket->vid) }}}</td></tr>
                                    <tr><td>Last Updated: </td><td>{{{ $ticket->updated_at }}}</td></tr>
                                    <tr><td>Created: </td><td>{{{ $ticket->created_at }}}</td></tr>
                                    <tr><td>Assigned: </td><td>@if ($ticket->assigned != 0) <span class="label label-danger">{{{ ConsoleUser::getName($ticket->assigned) }}}</span> @else <span class="label label-default">Unassigned</span> @endif</td></tr>
                                    <tr><td>Status: </td><td>@if ($ticket->status == 1) <span class="label label-success">Open</span> @else <span class="label label-primary">Closed</span> @endif</td></tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <h4>{{{ $ticket->subject }}}</h4>
                        <hr />
                        <p>{{{ $ticket->description }}}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <span class="label label-warning">{{ count($replies) }}</span> Replies
                </div>
                <div class="panel-body">
                    Here are the replies
                </div>
            </div>
        </div>
    </div>


</div>
<!-- /#page-wrapper -->
@include('console.core.footer')