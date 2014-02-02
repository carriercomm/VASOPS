@include('console.core.header')
<div class="container">
    <div class="row" style="margin-bottom: 40px;">
        <div class="col-md-5 col-md-offset-4">
            <h1><strong>VA Auditor Console</strong></h1>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            @if (Session::get('message') != '')
            <div class="alert alert-warning">
            {{ Session::get('message') }}
            </div>
            @endif
            <div class="login-panel panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Please sign in</h3>
                </div>
                <div class="panel-body">
                    <form action="{{ URL::route('postconsolelogin') }}" method="POST" role="form">
                        <fieldset>
                            <div class="form-group">
                                <input class="form-control" placeholder="CID" name="cid" value="{{ Session::get('cid') }}" autofocus>
                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="Password" name="password" type="password" value="">
                            </div>
                            <input type="submit" class="btn btn-lg btn-success btn-block" value="Login" />
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@include('console.core.footer')