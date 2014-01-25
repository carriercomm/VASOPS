@include('console.core.header')
@include('console.core.navbartop')
@include('console.core.navbarside')
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Auditor Dashboard</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-8">
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
                            <td><a href="#"><i class="fa fa-edit fa-fw"</a></td>
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
        <div class="col-lg-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-bullhorn fa-fw"></i> Administrator Broadcasts <span style="float: right;" class="label label-warning">2</span>
                </div>
                <div class="panel-body">
                    <div class="panel-group">
                        <div class="panel panel-info">
                            <div class="panel-heading">
                               <span style="margin-right: 5px;" class="label label-primary">Roger Curtiss</span> Audits Schedule <span style="float:right;" class="label label-info">2013-12-03 18:12:02</span>
                            </div>
                            <div class="panel-body">
                                Please ensure that you have completed all of the assigned audits within the next two weeks.
                            </div>
                        </div>
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                <span style="margin-right: 5px;" class="label label-primary">Romana Lara</span> Logging <span style="float:right;" class="label label-info">2013-12-05 18:11:08</span>
                            </div>
                            <div class="panel-body">
                                Audit managers, ensure that you properly log all of your edits within the console.
                            </div>
                        </div>
                    </div>
                    </div>
            </div>
        </div>
    </div>
</div>
<!-- /#page-wrapper -->

@include('console.core.footer')
