@include('console.core.header')
@include('console.core.navbartop')
@include('console.core.navbarside')
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header"><i class="fa fa-envelope fa-fw"></i> Mass Email</h1>
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
            <form class="form" action="{{ URL::route('consoleemailsend') }}" method="POST">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                <div class="form-group">
                    <label>Recipients: </label>
                    <div class="form-group">
                        <select class="form-control" name="inputRecipients">
                            <option value="0">({{{ $pendingCount  }}}) Pending VAs</option>
                            <option value="1">({{{ $activeCount }}}) Active VAs</option>
                            <option value="2">({{{$activeCount + $pendingCount}}}) Active & Pending VAs</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Email Subject: </label>
                        <input class="form-control" name="inputSubject" type="text" place-holder="Subject" />
                    </div>
                    <div class="form-group">
                        <label>Email Body: </label>
                        <span style="line-height: 40px;" class="pointer"><pre class="variableLabels">[name]</pre> <pre class="variableLabels">[vaname]</pre> <pre class="variableLabels">[cid]</pre> <pre class="variableLabels">[email]</pre> <pre class="variableLabels">[auditorname]</pre></span>
                        <textarea id="inputBody" class="form-control" name="inputBody" rows="10"></textarea>
                    </div>
                    <div class="form-actions">
                        <input type="submit" class="btn btn-success" value="Send Emails" />
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@section('consolejs')
CKEDITOR.replace('inputBody');
@endsection
@include('console.core.footer')