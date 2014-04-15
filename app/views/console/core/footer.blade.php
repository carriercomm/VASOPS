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


        });
    </script>
    </body>
</html>