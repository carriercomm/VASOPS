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
        @if (Session::get('message') != '')
        <div class="alert alert-warning">{{{ Session::get('message') }}}</div>
        @endif
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
                                    <a class="dropdown-toggle" href="#" data-toggle="dropdown"><i class="fa fa-bolt fa-fw"></i> Actions<i class="fa fa-caret-down fa-fw"></i></a>
                                <ul class="dropdown-menu dropdown-messages ticket-dropdown-actions">
                                    <li>
                                        <a data-scroll href="#consoleTicketReply">
                                            <div>
                                                <i class="fa fa-reply fa-fw"></i> Reply to Ticket
                                            </div>
                                        </a>
                                    </li>
                                    @if ($ticket->status == 1)
                                    <li>
                                        <a href="{{ Url::route('console') }}/helpdesk/close/{{{ $ticket->id }}}">
                                            <div>
                                                <i class="fa fa-check-square fa-fw"></i> Close Ticket
                                            </div>
                                        </a>
                                    </li>
                                    @else
                                    <li>
                                        <a href="{{ Url::route('console') }}/helpdesk/open/{{{ $ticket->id }}}">
                                            <div>
                                                <i class="fa fa-history fa-fw"></i> ReOpen Ticket
                                            </div>
                                        </a>
                                    </li>
                                    @endif
                                    @if ($ticket->assigned != Auth::consoleuser()->get()->cid)
                                    <li>
                                        <a href="{{ Url::route('console') }}/helpdesk/assign/{{{ $ticket->id }}}/{{{ Auth::consoleuser()->get()->cid }}}">
                                            <div>
                                                <i class="fa fa-hand-o-up fa-fw"></i> Assign To Me
                                            </div>
                                        </a>
                                    </li>
                                    @endif
                                    <li>
                                        <a href="#assignToTicketModal">
                                            <div>
                                                <i class="fa fa-users fa-fw"></i> Assign To
                                            </div>
                                        </a>
                                    </li>
                                    @if (Auth::consoleuser()->get()->access > 0)
                                    <li class="divider"></li>
                                    <li>
                                        <a id="verifyDeleteTicketTriggerModal" href="#">
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
                        <a class="nolinkstyle" href="{{ URL::route('console') }}/va/{{{ $ticket->vid }}}">
                            <div class="well ticket-info">
                                <div class="table-responsive">
                                    <table class="table table-responsive table-borderless">
                                        <tr><td>ID: </td><td><i class="fa fa-slack fa-fw"></i>{{{ $ticket->id }}}</td></tr>
                                        <tr><td>CID: </td><td>{{{ $ticket->vid }}}</td></tr>
                                        <tr><td>Name: </td><td>{{{ User::getFullName($ticket->vid) }}}</td></tr>
                                        <tr><td>VA Name: </td><td>{{{ User::getVaName($ticket->vid) }}}</td></tr>
                                        <tr><td>Last Updated: </td><td>{{{ $ticket->updated_at }}}</td></tr>
                                        <tr><td>Created: </td><td>{{{ $ticket->created_at }}}</td></tr>
                                        <tr><td>Assigned: </td><td>@if ($ticket->assigned != 0) <span class="label label-danger"><i class="fa fa-bookmark fa-fw"></i> {{{ ConsoleUser::getName($ticket->assigned) }}}</span> @else <span class="label label-default">Unassigned</span> @endif</td></tr>
                                        <tr><td>Status: </td><td>@if ($ticket->status == 1) <span class="label label-success">Open</span> @else <span class="label label-primary">Closed</span> @endif</td></tr>
                                    </table>
                                </div>
                            </div>
                        </a>
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
                    <span class="label label-warning">{{ count($replies) }}</span> @if (count($replies) == 1) Reply @else Replies @endif
                </div>
                <div class="panel-body repliesbg">
                    @foreach ($replies as $reply)
                    <div id="ticketReply{{{ $reply->id }}}" class="panel panel-default repliespanelbg">
                        <div class="panel-body">
                            <div class="col-lg-3">
                                @if ($reply->staff == 1) <span class="label label-danger"><i class="fa fa-bookmark fa-fw"></i> {{{ ConsoleUser::getName($reply->author) }}}</span> @else <a class="nolinkstyle" href="{{ URL::route('console') }}/va/{{{ $reply->author }}}"><strong>{{{ User::getFullName($reply->author) }}} ({{{ $reply->author }}})</strong></a> @endif
                            </div>
                            <div class="col-lg-9">
                                <span style="font-style: italic;">Reply written: {{{ $reply->created_at }}}</span>
                                <hr />
                                {{{ $reply->content }}}
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-primary">
                <div id="consoleTicketReply" class="panel-heading">
                    Submit Reply
                </div>
                <div class="panel-body">
                    <form class="form" action="{{ URL::route('console') }}/helpdesk/reply/{{ $ticket->id }}" method="POST">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                        <div class="form-group">
                            <textarea id="inputConsoleTicketReplyContent" rows="5" class="form-control" name="inputReplyContent" placeholder="Detail your response..."></textarea>
                        </div>
                        <div class="form-actions">
                            @if ($ticket->status == 1) <input id="inputConsoleTicketReplySubmit" name="replySubmit" class="btn btn-info" type="submit" value="Reply" /> <input id="inputConsoleTicketReplyAndCloseSubmit" name="replyAndCloseSubmit" class="btn btn-success" type="submit" value="Reply and Close Ticket" /> @else <input id="inputConsoleTicketReplyAndOpenSubmit" name="replyAndOpenSubmit" class="btn btn-info" type="submit" value="Reply and Reopen Ticket" />  @endif <input type="reset" class="btn" style="color: white;" type="submit" value="Cancel" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


</div>
<!-- /#page-wrapper -->

<!--/#verifyDeleteTicketModal -->
<div class="modal fade" id="verifyDeleteTicketModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times fa-fw"></i></button>
                <h3 class="modal-title" id="myModalLabel">Warning</h3>
            </div>
            <div class="modal-body">
                Are you sure you want to <strong>permanently delete</strong> this ticket and all of its replies?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <a href="{{ Url::route('console') }}/helpdesk/delete/{{{ $ticket->id }}}"><button type="button" class="btn btn-danger">Delete Ticket</button></a>
            </div>
        </div>
    </div>
</div>
@include('console.core.footer')