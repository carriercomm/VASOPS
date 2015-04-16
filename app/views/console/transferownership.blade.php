@include('console.core.header')
@include('console.core.navbartop')
@include('console.core.navbarside')


<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header"><i class="fa fa-arrows-h fa-fw"></i> Transfer VA Ownership </h1>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            @if (Session::get('message') != '')
                <div class="alert alert-warning">{{{ Session::get('message') }}}</div>
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <pre style="word-wrap: normal;"><strong>Please Read:</strong> This tool allows an administrator to change the primary key (the CID of the Owner for any VA added after the migration from LinksManager) of any VA. It subsequently updates any reference to this primary key with that of the CID entered. Note that VA CEOs log in with an email and password and not a CID however so you will also need tochange the email associated with the VA to actually transfer ownership. This tool primarily fixes the issue of a VA CEO leaving a VA and not being able to create another VA because his CID is in use</pre>
        </div>
    </div>
    <div id="transferVAAJAXDiv" style="margin-bottom: 40px; display: none;" class="row">
        <div class="col-lg-12">
            <div style="height: 500px;" class="shell-warp">
                <p class="shell-top-bar">Transfer VA Ownership Task</p>
                <ul style="height: 100%;" class="shell-body" id="transferVAAJAXResults">
                </ul>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="alert alert-danger" style="display: none;" id="transferOwnershipFormErrors"></div>
            <form class="form" action="#" method="POST">
                <input type="hidden" name="_token" id="inputToken" value="{{ csrf_token() }}" />
                <div class="form-group">
                    <label>Current VA ID (often times CID)</label>
                    <input type="text" class="form-control" style="width: 90px;" name="inputCurrentCid" id="inputCurrentCid" placeholder="Old ID" />
                </div>
                <div class="form-group">
                    <label>New CID</label>
                    <input type="text" style="width: 90px;" class="form-control" name="inputNewCid" id="inputNewCid" placeholder="New CID" />
                </div>
                <div class="form-actions">
                    <button id="submitTransferOwnership" class="btn btn-danger"><i style="display: none;" class="fa fa-circle-o-notch fa-spin fa-fw"></i> Transfer Ownership</button>
                </div>
            </form>
        </div>
    </div>
</div>

@section('consolejs')
    $('#submitTransferOwnership').on('click', function(e) {
        e.preventDefault();
        var btn = $(this);
        btn.prop("disabled", true);
        var loader = $(this).find('i');
        loader.fadeIn('slow');
        var inputToken = $('#inputToken').val();
        var currentCid = $('#inputCurrentCid').val();
        var newCid = $('#inputNewCid').val();
        $.ajax({
            'url':  '{{ URL::route('consoleposttransferownership') }}',
            'type': 'POST',
            'data': {'_token': inputToken, 'currentCid' : currentCid, 'newCid' : newCid},
        })
            .success(function(response) {
                if (response == 0) {
                    $('#transferOwnershipFormErrors').html("The current Cid is not linked to a Virtual Airline.").fadeIn();
                    loader.hide();
                    btn.prop("disabled", false);

                }
                else if (response == 1) {
                    $('#transferOwnershipFormErrors').html("The new CID cannot be linked to an existing Virtual Airline ").fadeIn();
                    loader.hide();
                    btn.prop("disabled", false);
                }
                else {
                    $('.form-group').fadeOut();
                    $('#transferVAAJAXDiv').slideDown();
                }
            });
    });
@endsection
@include('console.core.footer')
