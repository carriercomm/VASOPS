    <div id="ajaxSearchResults" style="display: none;">
        <div class="page-wrapper" style="display: block;">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header"><i class="fa fa-search fa-fw"></i> Search Results <img style="display: none;" id="searchLoader" alt="loading..." src="{{ URL::to('/') }}/images/loader.gif" /></h1>
                </div>
            </div>
            <div class="row">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-responsive">
                        <thead>
                        <tr>
                            <th>VA Name</th>
                            <th>URL</th>
                            <th>CID</th>
                            <th>Name</th>
                            <th>Date</th>
                            <th><i class="fa fa-edit fa-fw"></i></th>
                        </tr>
                        </thead>
                        <tbody id="searchTableBody"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ URL::to('/') }}/js/jquery-1.8.3.min.js"></script>
    <script src="{{ URL::to('/') }}/js/bootstrap.js"></script>
    <script src="{{ URL::to('/') }}/js/sb-admin.js"></script>
    <script src="{{ URL::to('/') }}/js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="{{ URL::to('/') }}/js/plugins/morris/raphael-2.1.0.min.js"></script>
    <script src="{{ URL::to('/') }}/js/plugins/morris/morris.js"></script>
    <script>
        $(document).ready(function() {
            $('#page-wrapper').fadeIn();

            $('#createBroadcastToggle').on('click', function() {
                $('#createBroadcastPanelBody').slideToggle('fast');
            });

            function ajaxSearch() {
                if ($('#searchInput').val() != '') {
                    $('#page-wrapper').hide();
                    $('#ajaxSearchResults').fadeIn();
                    $('#searchLoader').fadeIn();

                    var form = $('#searchForm');
                    var form_serialized = form.serialize();
                    $.ajax({
                        type: "POST",
                        url: "{{URL::route('consoleajaxsearch')}}",
                        data: { data: form_serialized }
                    })
                        .done(function(received) {
                            $('#searchLoader').hide();

                            if (received == '0') {
                                $('#searchTableBody').empty().prepend('<tr><td colspan="6">No Virtual Airline Records Located...</td></tr>');
                            }
                            else {
                                $('#searchTableBody').empty().prepend(received);
                            }
                        });
                    return false;

                }
                else {

                    $('#ajaxSearchResults').hide();
                    $('#page-wrapper').fadeIn();

                }
            }


            $('#searchInput').on('keyup', ajaxSearch);
            $('#searchBtn').on('click', ajaxSearch);

            $('button[id="vaEditInputSubmit"]').on('click', function(e) {
                $(this).html('<img height="7px" alt="Loading..." src="{{ URL::to('/') }}/images/loader.gif">');
                var btn = $(this);
                e.preventDefault();
                var _token = '{{ csrf_token(); }}';
                //Declare our submitted field to pass via AJAX or use later
                var field = $(this).closest('td').siblings('td').find('small').html();
                //Check to see if we are working with the country select box
                if (field == 'country') {
                    var value = $(this).closest('span').siblings('select').val();
                }
                else {
                    var value = $(this).closest('span').siblings('input').val();
                }
                var inputdiv = $(this).closest('div');
                var inputfield = $(this).closest('td').find('h4');
                    $.ajax({
                        type: "POST",
                        url: "{{ URL::route('consoleajaxvaedit') }}",
                        data: { va: vacid, _token: _token, field: field, value: value }
                    })
                        .done(function(received) {
                           btn.html('Save');
                           if (received == '1') {
                               //Success
                               inputdiv.hide();
                               inputfield.html(value);
                               //Update the default value of the input in case they happen to hit cancel. We want it to revert back to the newly saved input
                               inputdiv.find('input').attr('val', value);
                               inputfield.fadeIn();
                           }
                           else {
                               //Alert the user of an error
                               console.log('Error');
                           }
                        });
            });

            $('#vaNameField').on('click', function(){
                $('#vaNameField').hide();
                $('#vaNameInputDiv').fadeIn('fast');
            });
            $('#vaNameInputReset').on('click', function() {
                $('#vaNameInputDiv').hide();
                $('#vaNameField').fadeIn();
            })

            $('#vaEmailField').on('click', function(){
                $('#vaEmailField').hide();
                $('#vaEmailInputDiv').fadeIn('fast');
            });
            $('#vaEmailInputReset').on('click', function() {
                $('#vaEmailInputDiv').hide();
                $('#vaEmailField').fadeIn();
            })

            $('#vaUrlField').on('click', function(){
                $('#vaUrlField').hide();
                $('#vaUrlInputDiv').fadeIn('fast');
            });
            $('#vaUrlInputReset').on('click', function() {
                $('#vaUrlInputDiv').hide();
                $('#vaUrlField').fadeIn();
            })

            $('#vaVatsimImagePageLinkField').on('click', function(){
                $('#vaVatsimImagePageLinkField').hide();
                $('#vaVatsimImagePageLinkInputDiv').fadeIn('fast');
            });
            $('#vaVatsimImagePageLinkInputReset').on('click', function() {
                $('#vaVatsimImagePageLinkInputDiv').hide();
                $('#vaVatsimImagePageLinkField').fadeIn();
            })

            $('#vaCityField').on('click', function(){
                $('#vaCityField').hide();
                $('#vaCityInputDiv').fadeIn('fast');
            });
            $('#vaCityInputReset').on('click', function() {
                $('#vaCityInputDiv').hide();
                $('#vaCityField').fadeIn();
            })

            $('#vaStateProvinceField').on('click', function(){
                $('#vaStateProvinceField').hide();
                $('#vaStateProvinceInputDiv').fadeIn('fast');
            });
            $('#vaStateProvinceInputReset').on('click', function() {
                $('#vaStateProvinceInputDiv').hide();
                $('#vaStateProvinceField').fadeIn();
            })

            $('#vaZipField').on('click', function(){
                $('#vaZipField').hide();
                $('#vaZipInputDiv').fadeIn('fast');
            });
            $('#vaZipInputReset').on('click', function() {
                $('#vaZipInputDiv').hide();
                $('#vaZipField').fadeIn();
            })

            $('#vaCountryField').on('click', function() {
                $('#vaCountryField').hide();
                $('#vaCountryInputDiv').fadeIn();
            })
            $('#vaCountryInputReset').on('click', function() {
                $('#vaCountryInputDiv').hide();
                $('#vaCountryField').fadeIn();
            })

            $('#vaDescriptionField').on('click', function(){
                $('#vaDescriptionField').hide();
                $('#vaDescriptionInputDiv').fadeIn('fast');
            });
            $('#vaDescriptionInputReset').on('click', function() {
                $('#vaDescriptionInputDiv').hide();
                $('#vaDescriptionField').fadeIn();
            })

            $('#vaUpdatedField').on('click', function(){
                $('#vaUpdatedField').hide();
                $('#vaUpdatedInputDiv').fadeIn('fast');
            });
            $('#vaUpdatedInputReset').on('click', function() {
                $('#vaUpdatedInputDiv').hide();
                $('#vaUpdatedField').fadeIn();
            })

            $('#vaCreatedField').on('click', function(){
                $('#vaCreatedField').hide();
                $('#vaCreatedInputDiv').fadeIn('fast');
            });
            $('#vaCreatedInputReset').on('click', function() {
                $('#vaCreatedInputDiv').hide();
                $('#vaCreatedField').fadeIn();
            })

            $('#showAuditInput').on('click', function() {
                $(this).hide();
                $('#auditInputFormActions').fadeIn('fast');
                $('#auditInputForm').slideToggle('fast');
            })
            $('#cancelAuditInput').on('click', function() {
                $('#errorAuditEmpty').hide();
                $('#auditInputForm').slideToggle('fast');
                $('#inputAuditLog').removeAttr('disabled');
                $('#auditInputFormActions').hide();
                $('#showAuditInput').fadeIn('fast');
            })

            $('#submitAuditInput').on('click', function() {
                //Hide our errors, if any.
                $('#errorAuditEmpty').hide();
                //Ensure that it is not blank
                if ($('#inputAuditLog').val() == '') {
                    $('#errorAuditEmpty').fadeIn();
                }
                else {
                    //Disable the input
                    $('#inputAuditLog').attr('disabled', 'disabled');
                    var content = $('#inputAuditLog').val();
                    var va = vacid;
                    var _token = $('#_token').val();
                    $.ajax ({
                        type: "POST",
                        url: "{{ URL::route('consoleajaxcreateauditlog') }}",
                        data: { va: va, content: content, _token: _token }
                    })
                        .success(function(received) {
                                console.log('Function called');
                                //"Undisabled" the input and reset it
                                $('#inputAuditLog').removeAttr('disabled');
                                $('#auditInputForm')[0].reset();
                                //Manually add our new notation
                                $('#auditLogDiv').before('<div class="panel panel-default"><div class="panel-heading"><small>Now - ' + name + '</small></div><div class="panel-body">' + content + '</div></div>');
                        });
                }
            })

            $('#bannerUploadSubmit').on('click', function(e) {
                //Hide error messages that may have been displayed previously
                $('#errorBannerInvalidType').hide();
                $('#errorBannerEmpty').hide();

                // get the file name, possibly with path (depends on browser)
                var filename = $('#inputBanner').val();
                //Check and see if there is anything even submitted
                if (filename.length < 1) {
                    e.preventDefault();
                    $('#errorBannerEmpty').fadeIn('slow');
                }
                else {
                    // Use a regular expression to trim everything before final dot
                    var extension = filename.replace(/^.*\./, '');

                    // If there is no dot anywhere in filename, we would have extension == filename,
                    // so we account for this possibility now
                    if (extension == filename) {
                        extension = '';
                    } else {
                        extension = extension.toLowerCase();
                    }

                    switch (extension) {
                        case 'jpg':
                        case 'jpeg':
                        case 'png':
                            break;
                        default:
                            // Cancel the form submission
                            e.preventDefault();
                            $('#errorBannerInvalidType').fadeIn('slow');

                    }
                }
            });

            $('#createBroadcastBtn').on('click', function(e) {
                if ($('#inputBroadcastSubject').val() == '' || $('#inputBroadcastContent').val() == '') {
                    e.preventDefault();
                }
            })

            $('#linkBackRefreshBtn').on('click', function(e) {
                e.preventDefault();
                var va = $('#linkBackVa').val();
                var Iconclass = $('#linkBackRefreshIcon').attr('class');
                $('#linkBackRefreshIcon').attr('class', Iconclass + ' fa-spin');
                //Prepare the ajax request
                var _token = "{{ csrf_token() }}";
                $.ajax({
                    type: "POST",
                    url: "{{ URL::route('consoleajaxfindlinkback') }}",
                    data: { va: va, _token: _token }
                })
                    .success(function(received) {
                        $('#linkBackRefreshIcon').attr('class', Iconclass);
                        if (received == '1') {
                            //Hide the not found (if present) and fade in the found label
                            $('#linkbackNotFoundLabel').hide();
                            $('#linkbackFoundLabel').fadeIn();
                        }
                        else {
                            //Hide the found (if present) and fade in the not found label
                            $('#linkbackFoundLabel').hide();
                            $('#linkbackNotFoundLabel').fadeIn();
                        }
                    });
            })

            $('#createCategoryToggle').on('click', function() {
               $('#createCategoryPanelBody').slideToggle('fast');
            });
            $('#resetCategoryBtn').on('click', function() {
               $('#createCategoryPanelBody').slideUp('fast');
               $('#createCategoryForm')[0].reset();
            });

            $('#createCategoryBtn').on('click', function(e) {
                if ($('#inputCategoryName').val() == '') {
                    e.preventDefault();
                    $('#createCategoryFormGroup').attr('class', 'form-group has-error');
                }

            })

            $('.deleteChildCategory').on('click', function() {
                //Pull the category ID
                var id = $(this).find('i').attr('id')
                var _token = "{{ csrf_token() }}";
                //Format the ajax request
                $.ajax({
                    type: "POST",
                    url: "{{ URL::route('consolecategoriesdeletechild') }}",
                    data: { id: id, _token: _token }
                })

                    .success(function(received) {
                        //Remove the row
                    });
            })


        });
    </script>
    </body>
</html>