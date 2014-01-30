@include('console.core.header')
@include('console.core.navbartop')
@include('console.core.navbarside')
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header"><i class="fa fa-bullhorn fa-fw"></i> Broadcast Manager</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-bullhorn fa-fw"></i>Current Administrator Broadcasts <span style="float: right;" class="label label-warning">{{ count($broadcasts) }}</span>
            </div>
            <div class="panel-body">
                <div class="panel-group">
                    @foreach ($broadcasts as $broadcast)
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <span style="margin-right: 5px;" class="label label-primary">{{{ ConsoleUser::getName($broadcast->author) }}}</span> {{{ $broadcast->subject }}} <span style="margin-top: -2px; margin-left: 2px; float: right;"> | <span class="label label-primary"><i class="fa fa-eye fa-fw"></i></span>  <span class="label label-primary"><i class="fa fa-times fa-fw"></i></span> </span><span style="float: right;" class="broadcast-date label label-info">{{{ $broadcast->created_at }}}</span>
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
<!-- /#page-wrapper -->

@include('console.core.footer')