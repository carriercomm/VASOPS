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
    <div style="margin-bottom: 25px;" class="row">
        <div class="col-lg-2">
            <a href="{{ URL::route('consoleemailtemplates') }}"><button class="btn btn-primary"><i class="fa fa-arrow-left fa-fw"></i> Return</button></a>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <form role="form" action="{{ URL::route('consoleemailtemplates') }}/edit/{{{ $template->id }}}" method="POST">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                <div class="form-group">
                    <label>Internal Template Name</label>
                    <input type="text" name="inputName" class="form-control" value="{{{ $template->name }}}" placeholder="Internal Template Name" />
                </div>
                <div class="form-group">
                    <label>Subject</label>
                    <input type="text" name="inputSubject" class="form-control" value="{{{ $template->subject }}}" placeholder="Subject" />
                </div>
                <div class="form-group">
                    <label>Body</label>
                    <span style="line-height: 40px;" class="pointer"><pre class="variableLabels">[name]</pre> <pre class="variableLabels">[vaname]</pre> <pre class="variableLabels">[cid]</pre> <pre class="variableLabels">[email]</pre> <pre class="variableLabels">[auditorname]</pre></span>
                    <textarea style="margin-top: 10px;" rows="15;" class="form-control" name="inputContent" id="inputEmailTemplateContent" placeholder="Body">{{ $template->content }}</textarea>
                </div>
                <div class="checkbox">
                    <label>Public</label>
                    <input name="inputPublic" type="checkbox" @if ($template->public == 1) checked="checked" @endif value="1" />
                </div>
                <div class="form-actions">
                    <input type="submit" class="btn btn-success" value="Edit Template" />
                    <input type="reset" class="btn btn-default" value="Cancel" />
                </div>
            </form>
        </div>
    </div>
</div>
@section('consolejs')
CKEDITOR.replace('inputEmailTemplateContent');
@endsection
<!-- /#page-wrapper -->
@include('console.core.footer')