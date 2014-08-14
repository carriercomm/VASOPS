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
    <div class="row">
        <div class="col-lg-12">
            @if (Session::get('message') != '')
            <div class="alert alert-warning">{{{ Session::get('message') }}}</div>
            @endif
        </div>
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-5">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Recent Audit Log
                </div>
                <div class="panel-body">
                    <a class="nolinkstyle" href="{{ URL::route('console') }}/va/{{{ $auditLog1->va }}}#audit"><div style="position: relative; top: 10px; left: 15px;" class="label label-default">{{{ User::getVaName($auditLog1->va) }}}</div><div style="position: relative; top: 10px; left: 40px;" class="label label-primary"><i class="fa fa-bookmark fa-fw"></i> {{{ ConsoleUser::getName($auditLog1->author) }}}</div><div class="well" style="overflow: auto;">
                        {{ $auditLog1->content }}
                    </div></a>
                    <a class="nolinkstyle" href="{{ URL::route('console') }}/va/{{{ $auditLog2->va }}}#audit"><div style="position: relative; top: 10px; left: 15px;" class="label label-default">{{{ User::getVaName($auditLog2->va) }}}</div><div style="position: relative; top: 10px; left: 40px;" class="label label-primary"><i class="fa fa-bookmark fa-fw"></i> {{{ ConsoleUser::getName($auditLog2->author) }}}</div><div class="well" style="overflow: auto;">
                        {{ $auditLog2->content }}
                    </div></a>
                </div>
            </div>
        </div>
        <div class="col-lg-7">
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
                                <span style="margin-right: 5px;" class="label label-primary"><i class="fa fa-bookmark fa-fw"></i> {{{ ConsoleUser::getName($broadcast->author) }}}</span> {{{ $broadcast->subject }}} <span style="float:right;" class="broadcast-date label label-info">{{{ $broadcast->created_at }}}</span>
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
                    <i class="fa fa-comments fa-fw"></i> HelpDesk Unassigned Tickets <span style="float: right;" class="label label-warning">{{ count($tickets) }}</span>
                </div>
                <div class="panel-body">
                    <div class="panel-group">
                        @if (count($tickets) == 0)
                        <p style="font-style: italic;">There are currently no unassigned tickets...</p>
                        @else
                        @foreach ($tickets as $ticket)
                        <div class="panel panel-success">
                            <div class="panel-heading">
                                <span style="margin-right: 5px;" class="label label-success">@if ($ticket->vid == -1) {{{ $ticket->name }}} @else {{{ User::getFullName($ticket->vid) }}} @endif</span> {{{ $ticket->subject }}} <span style="float:right;" class="broadcast-date label label-limegreen">{{{ $ticket->created_at }}}</span>
                            </div>
                            <div class="panel-body">
                                <div class="col-lg-11">
                                    {{{ strip_tags($ticket->description) }}}
                                </div>
                                <div class="col-lg-1">
                                    <a style="text-decoration: none;" href="{{ URL::route('console') }}/helpdesk/view/{{{ $ticket->id }}}"><button class="btn btn-info"><i class="fa fa-eye fa-fw"></i> View</button></a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        @endif
                    </div>
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
                            <th>VAID</th>
                            <th>Name</th>
                            <th>Flags</th>
                            <th>Date</th>
                            <th><i class="fa fa-edit fa-fw"></i></th>
                            <th><i class="fa fa-info-circle fa-fw"></i></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($pendingVAs as $pendingVA)
                        <tr>
                            <td>{{{ $pendingVA->vaname }}}</td>
                            <td><a href="{{{ $pendingVA->url }}}" target="_blank">{{{ $pendingVA->url }}}</a></td>
                            <td>{{{ $pendingVA->cid }}}</td>
                            <td>{{{ $pendingVA->name }}}</td>
                            <td><span @if ($pendingVA->awaiting_response != 1) style="display: none;" @endif class="label label-warning awaiting_response_flag"><i class="fa fa-info fa-fw"></i> Awaiting Response <i style="display: none;" class="fa fa-spinner fa-spin fa-fw loader"></i><a data-vaid="{{{ $pendingVA->cid }}}" data-title="Remove Awaiting Response Flag" style="color: #ffffff" href="#" class="flagVAAwaitingResponseDeleteBtn tooltip-top"><i class="fa fa-times-circle fa-fw"></i></a></span></td>
                            <td>{{{ $pendingVA->created_at }}}</td>
                            <td><a data-title="Edit VA" class="tooltip-top" href="{{ URL::route('console') }}/va/{{{ $pendingVA->cid }}}"><i class="fa fa-edit fa-fw"></i></a></td>
                            <td><i style="display: none;" class="fa fa-spinner fa-spin fa-fw loader"></i><a data-vaid="{{{ $pendingVA->cid }}}" data-title="Flag VA as Awaiting Response" class="flagVAAwaitingResponseBtn tooltip-top" href="#"><i class="fa fa-info-circle fa-fw"></i></a></td>
                        </tr>
                        @endforeach
                        </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /#page-wrapper -->
@section('consolejs')
$('.flagVAAwaitingResponseDeleteBtn').on('click', function(e){
    e.preventDefault();
    var btn = $(this);
    var vaid = btn.attr('data-vaid');
    var _token = "{{ csrf_token() }}";
    var loader = btn.siblings('.loader');
    btn.hide();
    loader.show();
    $.ajax({
        "type": "post",
        "url": "{{ URL::route('consoleflagvaawaitingresponsedelete') }}",
        "data": { vaid: vaid, _token: _token }
    })
        .success(function(received) {
            loader.hide();
            btn.show();
            btn.closest('.awaiting_response_flag').fadeOut();
        });

});

$('.flagVAAwaitingResponseBtn').on('click', function(e){
    e.preventDefault();
    var btn = $(this);
    var vaid = btn.attr('data-vaid');
    var _token = "{{ csrf_token() }}";
    var loader = btn.siblings('.loader');
    btn.hide();
    loader.show();
    $.ajax({
        "type": "post",
        "url": "{{ URL::route('consoleflagvaawaitingresponse') }}",
        "data": { vaid: vaid, _token: _token }
    })
        .success(function(received) {
            loader.hide();
            btn.show();
            btn.closest('tr').find('.awaiting_response_flag').fadeIn();
        });

});


@endsection
@include('console.core.footer')
