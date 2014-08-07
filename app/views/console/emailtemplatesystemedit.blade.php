@include('console.core.header')
@include('console.core.navbartop')
@include('console.core.navbarside')
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header"><i class="fa fa-envelope fa-fw"></i> Edit Email Template <small>{{{ $template->id }}}</small></h1>
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
            <form action="{{ URL::route('consolesystememailtemplatesave') }}" method="POST">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                <input type="hidden" name="id" value="{{{ $template->id }}}" />
                <div class="form-group">
                    <label>ID: </label>
                    <input type="text" disabled="disabled" class="form-control" value="{{{ $template->id }}}" />
                </div>
                <div class="form-group">
                    <label>Subject: </label>
                    <input type="text" name="subject" placeholder="Enter a subject..." class="form-control" value="{{{ $template->subject }}}" />
                </div>
                <div class="form-group">
                    <label>Content: </label>
                    <textarea class="form-control" name="content" id="content">{{ $template->content }}</textarea>
                </div>
                <div class="form-actions">
                    <input type="submit" class="btn btn-success" value="Edit Template" />
                    <input type="reset" class="btn btn-default" value="Cancel" />
                </div>
            </form>
        </div>
    </div>
    @section('consolejs')
    CKEDITOR.replace('content');

    @endsection
@include('console.core.footer')