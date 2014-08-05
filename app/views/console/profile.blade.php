@include('console.core.header')
@include('console.core.navbartop')
@include('console.core.navbarside')
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header"><i class="fa fa-user fa-fw"></i> Account Profile <small>{{{ $auditor->name }}}</small></h1>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            @if (Session::get('message') != '')
            <div class="alert alert-warning">{{{ Session::get('message') }}}</div>
            @endif
        </div>
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
            <form class="form" action="{{ URL::route('consoleprofilesave') }}" method="POST">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                <div class="form-group">
                    <label>CID: </label>
                    <input class="form-control" type="text" disabled="disabled" value="{{{ $auditor->cid }}}" />
                </div>
                <div class="form-group">
                    <label>Name: </label>
                    <input name="inputName" class="form-control" placeholder="Enter your name..." type="text" value="{{{ $auditor->name }}}" />
                </div>
                <div class="form-group">
                    <label>Email: </label>
                    <input name="inputEmail" class="form-control" placeholder="Enter your email address..." type="text" value="{{{ $auditor->email }}}" />
                </div>
                <div class="form-group">
                    <label>Password: </label>
                    <input name="inputPassword" class="form-control" placeholder="Enter a password... (if changing)" type="password" value="" />
                </div>
                <div class="form-group">
                    <label>New Ticket Email Notifications: </label>
                    <select class="form-control" name="inputTicketNotifications">
                        <option value="1" @if ($auditor->ticketnotifications == 1) selected="selected" @endif>Yes</option>
                        <option value="0" @if ($auditor->ticketnotifications == 0) selected="selected" @endif>No</option>
                    </select>
                </div>
                <div class="form-actions">
                    <input type="submit" class="btn btn-success" value="Save Profile" />
                    <input type="reset" class="btn" style="color: white;" value="Cancel" />
                </div>
            </form>
        </div>
    </div>
</div>
@include('console.core.footer')