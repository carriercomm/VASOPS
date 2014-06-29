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
            <h1 class="page-header"><i class="fa fa-exchange fa-fw"></i> Assign Audit Managers</h1>
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
    <form action="{{ URL::route('consoleassignauditorsnew') }}" method="POST">
        <div class="row">
            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
            <div class="col-lg-5">
                <div class="table-responsive">
                    <table class="table table-bordered table-responsive">
                        <tr><th>Select</th><th>Category Name</th><th># of VAs</th></tr>
                        @foreach($potentialparents as $potentialparent)
                        <tr><td><input class="categoryCheckBox" name="categoryCheckBox[]" type="checkbox" value="{{{ $potentialparent->id }}}" /></td><td><strong>{{{ $potentialparent->name }}}</strong></td><td>{{{ $vaInCategories[$potentialparent->id] }}}</td>
                        @foreach($children as $child)
                        @if($child->parentid == $potentialparent->id)
                        <tr><td><input class="categoryCheckBox" name="categoryCheckBox[]" type="checkbox" value="{{{ $child->id }}}" /></td><td><i class="fa fa-arrow-right fa-fw"></i> {{{ $child->name }}}</td><td>{{{ $vaInCategories[$child->id] }}}</td>
                        @endif
                        @endforeach
                        @endforeach
                    </table>
                </div>
            </div>
            <div class="col-lg-2">
                <h4>Assign To <i class="fa fa-arrow-right fa-fw"></i></h4>
            </div>
            <div class="col-lg-5">
                <div class="table-responsive">
                    <table class="table table-bordered table-responsive">
                        <tr><th>Select</th><th>Auditor Name</th><th># of Pending VA Audits Assigned</th></tr>
                        @foreach ($auditors as $auditor)
                        <tr><td><input type="checkbox" id="auditorCheckBox[]" name="auditorCheckBox[]" class="auditorCheckBox" value="{{{ $auditor->cid }}}" /></td><td>{{{ $auditor->name }}}</td><td>{{{ $assignmentsPerAuditor[$auditor->cid] }}}</td></tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-offset-5">
                <input type="submit" class="btn btn-success" value="Submit Assignments" />
            </div>
        </div>
    </form>
</div>
@include('console.core.footer')