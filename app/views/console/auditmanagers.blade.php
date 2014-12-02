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
            <h1 class="page-header"><i class="fa fa-users fa-fw"></i> Audit Managers</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    @if (count($errors) > 0)
    <div class="row">
        <div class="col-lg-12">
            @foreach ($errors->all() as $error)
            <div class="alert alert-danger">{{ $error }}</div>
            @endforeach
        </div>
    </div>
    @endif
    <div class="row">
        <div class="col-lg-2">
            <button id="addAuditManagerBtn" class="btn btn-info"><i class="fa fa-plus-circle fa-fw"></i> Add Audit Manager</button>
        </div>
    </div>
    <div style="margin-top: 15px;" class="row">
        <div class="col-lg-12">
            <h4>Active Audit Managers</h4>
            <div class="table-responsive">
                <table class="table table-bordered table-responsive">
                    <tr><th>CID</th><th>Name</th><th>Access Level</th><th>Last Logged In</th><th>Created At</th><th>Actions</th></tr>
                    @foreach ($auditors as $auditor)
                    <tr><td>{{{ $auditor->cid }}}</td><td>{{{ $auditor->name }}}</td><td>@if ($auditor->access == 0) <span class="label label-default">Audit Manager</span> @elseif ($auditor->access == 1) <span class="label label-danger">Administrator</span> @endif</td><td>@if ($auditor->updated_at == $auditor->created_at || $auditor->updated_at == "") Never @elseif ($auditor->cid == 1095510) <small>Always Bug Fixing <i class="fa fa-bug fa-fw"></i></small> @else {{{ $auditor->updated_at }}} @endif</td><td>@if ($auditor->cid == 1095510) <small>The Beginning of History <i class="fa fa-smile-o fa-fw"></i></small> @else {{{ $auditor->created_at }}} @endif</td><td><i data-title="Edit Audit Manager" data-cid="{{{ $auditor->cid }}}" data-name="{{{ $auditor->name }}}" data-access="{{{ $auditor->access }}}" class="fa fa-edit fa-fw editAuditManagerBtn pointer tooltip-right"></i></td></tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
    <div style="margin-top: 15px;" class="row">
        <div class="col-lg-12">
            <h4>Removed Audit Managers</h4>
            <div class="table-responsive">
                <table class="table table-bordered table-responsive">
                    <tr><th>CID</th><th>Name</th><th>Access Level</th><th>Created At</th><th>Actions</th></tr>
                    @foreach ($inactiveAuditors as $inactiveAuditor)
                    <tr><td>{{{ $inactiveAuditor->cid }}}</td><td>{{{ $inactiveAuditor->name }}}</td><td>@if ($inactiveAuditor->access == -1) <span class="label label-default"><i class="fa fa-ban fa-fw"></i>Removed</span>@endif</td><td>{{{ $inactiveAuditor->created_at }}}</td><td><a class="nolinkstyle" href="{{ URL::route('consoleauditmanagers') }}/restore/{{{ $inactiveAuditor->cid }}}"><i data-title="Restore Audit Manager Access" class="fa fa-history fa-fw tooltip-right"></i></a></td></tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
</div>
<!-- /#page-wrapper -->

<!--/#addAuditManagerModal -->
<div class="modal fade" id="addAuditManagerModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times fa-fw"></i></button>
                <h3 class="modal-title" id="myModalLabel">Add New Audit Manager</h3>
            </div>
            <form class="form" action="{{ Url::route('consoleaddauditmanager') }}" method="POST">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                <div class="modal-body">
                    <div class="form-group">
                        <label>CID: </label>
                        <input type="text" class="form-control" placeholder="1095510" name="inputCid" />
                    </div>
                    <div class="form-group">
                        <label>Name: </label>
                        <input type="text" class="form-control" placeholder="Colin Schoen" name="inputName" />
                    </div>
                    <div class="form-group">
                        <label>Access Level: </label>
                        <select class="form-control" name="inputAccess">
                            <option value="0">Audit Manager</option>
                            <option value="1">Administrator</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <input class="btn btn-info" type="submit" value="Add Audit Manager" />
                </div>
            </form>
        </div>
    </div>
</div>

<!--/#editAuditManagerModal -->
<div class="modal fade" id="editAuditManagerModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times fa-fw"></i></button>
                <h3 class="modal-title" id="myModalLabel">Edit Audit Manager</h3>
            </div>
            <form class="form" action="{{ Url::route('consoleeditauditmanager') }}" method="POST">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                <input type="hidden" id="editAuditManagerInputCid" name="cid" value="" />
                <div class="modal-body">
                    <div class="form-group">
                        <label>CID: </label>
                        <input disabled="disabled" type="text" class="form-control" value="" id="editAuditManagerInputCidDisabled" name="editAuditManagerInputCid" />
                    </div>
                    <div class="form-group">
                        <label>Name: </label>
                        <input type="text" class="form-control" value="" id="editAuditManagerInputName" name="editAuditManagerInputName" />
                    </div>
                    <div class="form-group">
                        <label>Access Level: </label>
                        <select id="editAuditManagerInputAccess" class="form-control" name="editAuditManagerInputAccess">
                            <option value="0">Audit Manager</option>
                            <option value="1">Administrator</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <input name="editAuditManagerInputRemove" class="btn btn-danger" type="submit" value="Remove Audit Manager" />
                    <input class="btn btn-info" type="submit" value="Edit Audit Manager" />
                </div>
            </form>
        </div>
    </div>
</div>
@include('console.core.footer')