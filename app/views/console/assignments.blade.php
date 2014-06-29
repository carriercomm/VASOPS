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
            <h1 class="page-header"><i class="fa fa-pencil fa-fw"></i> Auditor Assignments</h1>
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
        <div class="col-lg-12">
            <h4>Your Assignments @if (count($assignments) > 0) <span class="label label-warning">{{{ count($assignments) }}}</span> @endif</h4>
            <div class="table-responsive">
                <table class="table table-responsive table-bordered">
                    <tr><th>ID</th><th>Categories</th><th>Auditors Assigned</th><th>Assigned At</th><th>Actions</th>@if (Auth::consoleuser()->get()->access > 0)<th>Admin</th> @endif</tr>
                    @foreach ($assignments as $assignment)
                    <tr><td>{{{ $assignment->id }}}</td><td>{{ $categoriesPerAssignment[$assignment->id] }}</td><td>{{ $auditorsPerAssignment[$assignment->id] }}</td><td>{{{ $assignment->created_at }}}</td><td><button id="completeAuditsBtn" class="btn btn-info"><i class="fa fa-pencil fa-fw"></i> Complete Audits</button></td>@if (Auth::consoleuser()->get()->access > 0)<td><button style="color: white;" class="btn"><i class="fa fa-edit fa-fw"></i> Edit</button> <a href="{{ URL::route('consoleassignments') }}/delete/{{{ $assignment->id }}}"><button class="btn btn-danger"><i class="fa fa-times fa-fw"></i> Remove</button></a> @endif</td></tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
    @if (Auth::consoleuser()->get()->access > 0)
    <div class="row">
        <div class="col-lg-12">
            <h4>Other's Assignments @if (count($othersAssignments) > 0) <span class="label label-warning">{{{ count($othersAssignments) }}}</span> @endif</h4>
            <div class="table-responsive">
                <table class="table table-responsive table-bordered">
                    <tr><th>ID</th><th>Categories</th><th>Auditors Assigned</th><th>Assigned At</th><th>Admin</th></tr>
                    @foreach ($othersAssignments as $othersAssignment)
                    <tr><td>{{{ $othersAssignment->id }}}</td><td>{{ $categoriesPerAssignment[$othersAssignment->id] }}</td><td>{{ $auditorsPerAssignment[$othersAssignment->id] }}</td><td>{{{ $othersAssignment->created_at }}}</td><td><a href="{{ URL::route('consoleassignments') }}/delete/{{{ $othersAssignment->id }}}"><button class="btn btn-danger"><i class="fa fa-times fa-fw"></i> Remove</button></a></td></tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
    @endif
    <div id="completeAuditsRow" class="row">
        <div class="col-lg-12">
            <h3>Complete Audits</h3>
            <div class="table-responsive">
                <table class="table table-responsive">
                    <tr><th>Assignment ID</th><th>VA Name</th><th>Audit VA</th><th>Mark Complete</th></tr>
                    @foreach ($vasList as $va)
                    <tr><td>{{{ $va['assignmentid'] }}}</td><td>{{{ $va['vaname'] }}}</td><td><a target="_blank" href="{{ URL::route('console') }}/va/{{{ $va['cid'] }}}"><button class="btn btn-info"><i class="fa fa-pencil fa-fw"></i> VA Profile</button></a></td><td><a href="{{ URL::route('consoleassignments') }}/complete/{{{ $va['assignmentid'] }}}/{{{ $va['cid'] }}}"><button class="btn btn-primary"><i class="fa fa-check-circle-o fa-fw"></i> Mark Complete</button></a></td></tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
</div>
@include('console.core.footer')