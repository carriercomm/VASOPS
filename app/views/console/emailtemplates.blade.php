@include('console.core.header')
@include('console.core.navbartop')
@include('console.core.navbarside')
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header"><i class="fa fa-envelope fa-fw"></i> Email Templates</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            @if (Session::get('message') != '')
            <div class="alert alert-warning">{{{ Session::get('message') }}}</div>
            @endif
            @if (Session::get('error') != '')
            <div class="alert alert-danger">{{{ Session::get('error') }}}</div>
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-primary">
                <div id="createEmailTemplateToggle" style="cursor: pointer;" class="panel-heading">
                    <i class="fa fa-envelope fa-fw"></i> Create an Email Template <i class="fa fa-plus fa-fw"></i>
                </div>
                <div id="createEmailTemplatePanelBody" @if (Session::get('error') == '') style="display: none;" @endif class="panel-body">
                    <form role="form" action="{{ URL::route('consoleemailtemplatenew') }}" method="POST">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                        <div class="form-group">
                            <input type="text" style="width: 60%;" class="form-control" name="inputName" id="inputEmailTemplateName" @if (Session::get('inputName') != '') value="{{{ Session::get('inputName') }}}" @endif placeholder="Internal Template Name" />
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" name="inputSubject" id="inputEmailTemplateSubject" @if (Session::get('inputSubject') != '') value="{{{ Session::get('inputSubject') }}}" @endif placeholder="Subject" />
                        </div>
                        <div class="form-group">
                            <label>Reference Variables: </label>
                            <span class="pointer"><pre class="variableLabels" style="display: inline;">[name]</pre> <pre class="variableLabels" style="display: inline;">[vaname]</pre> <pre class="variableLabels" style="display: inline;">[cid]</pre> <pre class="variableLabels" style="display: inline;">[email]</pre> <pre class="variableLabels" style="display: inline;">[auditorname]</pre></span>
                            <textarea style="margin-top: 10px;" rows="15;" class="form-control" name="inputContent" id="inputEmailTemplateContent" placeholder="Please compose your new template...">@if (Session::get('inputContent') != '') {{{ Session::get('inputContent') }}} @endif</textarea>
                        </div>
                        <div class="checkbox">
                            <label>Public</label>
                            <input name="inputPublic" type="checkbox" value="1" />
                        </div>
                        <div class="form-actions">
                            <input id="createEmailTemplateBtn" type="submit" class="btn btn-success" value="Create Template" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <h4>Your Templates</h4>
            <table class="table table-bordered table-responsive table-striped">
                <tr><th>Name</th><th>Subject</th><th>Body</th><th>Visibility</th><th>Actions</th></tr>
                @if (count($myTemplates) < 1)
                <tr><td colspan="5">No templates found...</td></tr>
                @else
                @foreach ($myTemplates as $myTemplate)
                <tr data-templateid="{{{ $myTemplate->id }}}"><td>{{{ $myTemplate->name }}}</td><td>{{{ $myTemplate->subject }}}</td><td>{{{ substr($myTemplate->content,0,100) }}}...</td><td>@if ($myTemplate->public == 1) <span class="label label-primary">Public</span> @else <span class="label label-default">Private</span> @endif</td><td><i class="fa fa-edit fa-fw pointer"></i><span class="emailTemplateDeleteX"><i class="fa fa-times fa-fw pointer"></i></span></td></tr>
                @endforeach
                @endif
            </table>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <h4>Shared Templates</h4>
            <table class="table table-bordered table-responsive table-striped">
                <tr><th>Name</th><th>Subject</th><th>Body</th>@if (Auth::consoleuser()->get()->access > 0) <th>Actions</th> @endif</tr>
                @if (count($sharedTemplates) < 1)
                <tr><td @if (Auth::consoleuser()->get()->access > 0) colspan="4" @else colspan="3" @endif>No shared templates found...</td></tr>
                @else
                @foreach ($sharedTemplates as $sharedTemplate)
                <tr data-templateid="{{{ $sharedTemplate->id }}}"><td>{{{ $sharedTemplate->name }}}</td><td>{{{ $sharedTemplate->subject }}}</td><td>{{{ substr($sharedTemplate->content,0,100) }}}...</td>@if (Auth::consoleuser()->get()->access > 0) <td><i class="fa fa-edit fa-fw pointer"></i><span class="emailTemplateDeleteX"><i class="fa fa-times fa-fw pointer"></i></span></td> @endif</tr>
                @endforeach
                @endif
            </table>
        </div>
    </div>


</div>
<!--/#deleteEmailTemplateModal -->
<div class="modal fade" id="deleteEmailTemplateModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times fa-fw"></i></button>
                <h3 class="modal-title" id="myModalLabel">Warning</h3>
            </div>
            <div class="modal-body">
                Are you sure you want to <strong>permanently delete</strong> this email template?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button id="btnDeleteEmailTemplateConfirmed" type="button" class="btn btn-danger">Delete Template</button>
            </div>
        </div>
    </div>
</div>
<!-- /#page-wrapper -->
@include('console.core.footer')