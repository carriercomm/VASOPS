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

        });
    </script>
    </body>
</html>