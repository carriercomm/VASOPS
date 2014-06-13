@include('console.core.header')
@include('console.core.navbartop')
@include('console.core.navbarside')
    <div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header"><i class="fa fa-comments fa-fw"></i> Help Desk <small>{{{ $subheader }}}</small></h1>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="table-responsive">
                <table class="table table-responsive table-bordered table-striped">
                    <tr><th><i class="fa fa-slack fa-fw"></i></th><th>VA Name</th><th>Name</th><th>Subject</th><th>Replies</th><th>Assigned</th><th>Status</th><th>Last Update</th><th>Created</th><th><i class="fa fa-eye fa-fw"></i></th></tr>
                    @foreach ($tickets as $ticket)
                    <tr><td>{{{ $ticket->id }}}</td><td><a style="font-style: italic;" class="nolinkstyle" href="{{ Url::route('console') }}/va/{{{ $ticket->vid }}}">{{{ User::getVaName($ticket->vid) }}}</a></td><td>{{{ User::getFullName($ticket->vid) }}}</td><td>{{{ $ticket->subject }}}</td><td>{{{ $repliescount[$ticket->id] }}}</td><td>@if ($ticket->assigned == 0) <span class="label label-default">Unassigned</span> @else<span class="label label-danger">{{{ ConsoleUser::getName($ticket->assigned) }}} <i class="fa fa-fw fa-bookmark"></i></span>@endif</td><td>@if ($ticket->status == 1) <span class="label label-success">Open</span> @else <span class="label label-primary">Closed</span> @endif</td><td>{{{ $ticket->updated_at }}}</td><td>{{{ $ticket->created_at }}}</td><td><a href="{{ Url::route('console') }}/helpdesk/view/{{{ $ticket->id }}}"><i style="color: #000000;" class="fa fa-eye fa-fw"</a></td></tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>


    </div>
<!-- /#page-wrapper -->
@include('console.core.footer')