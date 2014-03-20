@include('console.core.header')
@include('console.core.navbartop')
@include('console.core.navbarside')
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header"><i class="fa fa-dashboard fa-fw"></i> Auditor Dashboard</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Recent Audit Log
                </div>
                <div class="panel-body">
                    <div class="well">
                        Test Audit Log #1
                    </div>
                    <div class="well">
                        Test Audit Log #2
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-bullhorn fa-fw"></i> Administrator Broadcasts <span style="float: right;" class="label label-warning">{{ count($activeBroadcasts) }}</span>
                </div>
                <div class="panel-body">
                    @if (count($activeBroadcasts) > 0)
                    <div class="panel-group">
                        @foreach ($activeBroadcasts as $broadcast)
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                <span style="margin-right: 5px;" class="label label-primary">{{{ ConsoleUser::getName($broadcast->author) }}}</span> {{{ $broadcast->subject }}} <span style="float:right;" class="broadcast-date label label-info">{{{ $broadcast->created_at }}}</span>
                            </div>
                            <div class="panel-body">
                                {{{ $broadcast->content }}}
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    There are no active broadcasts.
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-plane fa-fw"></i> Pending Virtual Airlines <span style="float: right;" class="label label-warning">{{ count($pendingVAs) }}</span>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>VA Name</th>
                            <th>URL</th>
                            <th>CID</th>
                            <th>Name</th>
                            <th>Date</th>
                            <th><i class="fa fa-edit fa-fw"></i></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($pendingVAs as $pendingVA)
                        <tr>
                            <td>{{{ $pendingVA->vaname }}}</td>
                            <td><a href="{{{ $pendingVA->url }}}" target="_blank">{{{ $pendingVA->url }}}</a></td>
                            <td>{{{ $pendingVA->cid }}}</td>
                            <td>{{{ $pendingVA->name }}}</td>
                            <td>{{{ $pendingVA->created_at }}}</td>
                            <td><a href="{{ URL::route('console') }}/va/{{{ $pendingVA->cid }}}"><i class="fa fa-edit fa-fw"</a></td>
                        </tr>
                        @endforeach
                        </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-comments fa-fw"></i> HelpDesk Updates <span style="float: right;" class="label label-warning">{{ count($tickets) }}</span>
                </div>
                <div class="panel-body">
                    <div class="panel-group">
                        @foreach ($tickets as $ticket)
                        <div class="panel panel-success">
                            <div class="panel-heading">
                                <span style="margin-right: 5px;" class="label label-success">@if ($ticket->type == 1) {{{ User::getFullName($ticket->vid) }}} @elseif ($ticket->type == 2) {{{ User::getFullName($ticket->ticket_author) }}} @endif</span> {{{ $ticket->subject }}} <span style="float:right;" class="broadcast-date label label-limegreen">{{{ $ticket->created_at }}}</span>
                            </div>
                            <div class="panel-body">
                                @if ($ticket->type == 1) {{{ $ticket->description }}} @elseif ($ticket->type == 2) <i class="fa fa-mail-forward fa-fw"></i> {{{ $ticket->content }}} @if ($ticket->ticket_author != $ticket->author) <span style="float: right;"><span class="label label-danger"><i class="fa fa-bookmark fa-fw"></i> {{{ ConsoleUser::getName($ticket->author) }}}</span></span> @endif @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /#page-wrapper -->

@include('console.core.footer')
