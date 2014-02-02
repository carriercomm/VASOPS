    <div id="ajaxSearchResults" style="display: none;">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header"><i class="fa fa-search fa-fw"></i> Search Results/h1>
            </div>
        </div>
        <div class="row">
            <div class="table-responsive">
                <table class="table table-hover">
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
                    <tbody>


                    <tr>
                        <td>VA NAME HERE</td>
                        <td><a href="VA URL HERE" target="_blank">VA URL HERE</a></td>
                        <td>VA CID</td>
                        <td>VA NAME</td>
                        <td>CREATED AT</td>
                        <td><a href="#"><i class="fa fa-edit fa-fw"</a></td>
                    </tr>


                    </tbody>
                </table>
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
                if ($('#searchInput').val != '') {

                    var form = $('#searchForm');
                    var form_serialized = form.serialize();
                    $.ajax({
                        type: "POST",
                        url: "{{URL::route('consoleajaxsearch')}}",
                        data: { data: form_serialized },
                        dataType: 'json'
                    })
                        .done(function(received) {

                            if (received == '0') {
                                console.log('No Records Found');
                            }
                            else {
                                $(received).each(function () {
                                    console.log($(this).name);
                                });
                            }
                        });
                    return false;

                }
                else {

                    $('#ajaxSearchResultsActive').hide();
                    $('#page-wrapper').fadeIn();

                }
            }


            $('#searchInput').on('keyup', ajaxSearch);
            $('#searchBtn').on('click', ajaxSearch);

        });
    </script>
    </body>
</html>