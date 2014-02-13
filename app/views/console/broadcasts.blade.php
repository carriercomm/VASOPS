@include('console.core.header')
@include('console.core.navbartop')
@include('console.core.navbarside')
<div id="page-wrapper">

    @if (Session::get('message') != '')
    <div class="row">
        <div class="col-lg-12">
            <div style="margin-top: 20px;" class="alert alert-warning">{{ Session::get('message') }}</div>
        </div>
    </div>
    @endif
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header"><i class="fa fa-bullhorn fa-fw"></i> Broadcast Manager</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-primary">
                <div id="createBroadcastToggle" style="cursor: pointer;" class="panel-heading">
                    <i class="fa fa-bullhorn fa-fw"></i> Create a Broadcast <i class="fa fa-plus fa-fw"></i>
                </div>
                <div id="createBroadcastPanelBody" style="display: none;" class="panel-body">
                    <form role="form" action="{{ URL::route('consolebroadcastsnew') }}" method="POST">
                        <div class="form-group">
                            <input type="text" class="form-control" name="inputSubject" id="inputSubject" placeholder="Subject" />
                        </div>
                        <div class="form-group">
                            <textarea class="form-control" name="inputContent" id="inputContent" placeholder="Please detail your broadcast..."></textarea>
                        </div>
                        <div class="form-actions">
                            <input type="submit" class="btn btn-success" value="Create Broadcast" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-bullhorn fa-fw"></i>Current Administrator Broadcasts <span style="float: right;" class="label label-warning">{{ count($broadcasts) }}</span>
                </div>
                <div class="panel-body">
                    <div class="panel-group">
                        @foreach ($broadcasts as $broadcast)
                        @if ($broadcast->status == 1)
                        <div class="panel panel-info">
                        @else
                        <div class="panel panel-default">
                        @endif
                            <div class="panel-heading">
                                @if ($broadcast->status == 1) <i class="fa fa-eye fa-fw"></i> @else <i class="fa fa-eye-slash fa-fw"></i> @endif<span style="margin-right: 5px;" @if ($broadcast->status == 1) class="label label-primary" @else class="label label-default" @endif>{{{ ConsoleUser::getName($broadcast->author) }}}</span> {{{ $broadcast->subject }}}
                                <span style="float: right; width: 180px;">
                                    <span class="broadcast-date label label-info">{{{ $broadcast->created_at }}}</span> | <a href="{{ URL::route('consolebroadcasts') }}/vis/{{ $broadcast->id }}"><span class="label label-primary"><i @if ($broadcast->status == 1) class="fa fa-eye-slash" fa-fw @else class="fa fa-eye @endif"></i></span></a>  <a href="{{ URL::route('consolebroadcasts') }}/remove/{{ $broadcast->id }}"><span class="label label-primary"><i class="fa fa-times fa-fw"></i></span></a>
                                </span>
                            </div>
                            <div class="panel-body">
                                {{{ $broadcast->content }}}
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