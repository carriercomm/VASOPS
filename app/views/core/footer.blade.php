</div><!-- /container -->
<footer style="margin-top: 300px;">
    <div class="container">
        <div class="row">
            <div class="span7">
                <a href="http://vatsim.net" target="_blank"><img src="images/logo.gif" alt="Vatsim"/></a>

                <h3 class="footer-title">VATSIM Virtual Airline System</h3>

                <p><small>Developed by Colin Schoen</small>
                </p>

                <p class="pvl">
                </p>

            </div>
            <!-- /span8 -->

            <div class="span5">
                <div class="footer-banner">
                    <h3 class="footer-title">VASOPS 1.0</h3>
                    <ul>
                        <li><a href="/console">Auditor Console</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</footer>

<!-- Load JS here for greater good =============================-->

<script src="js/jquery-1.8.3.min.js"></script>
<script src="js/jquery-ui-1.10.3.custom.min.js"></script>
<script src="js/jquery.ui.touch-punch.min.js"></script>
<script src="js/bootstrap.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/bootstrap-select.js"></script>
<script src="js/bootstrap-switch.js"></script>
<script src="js/flatui-checkbox.js"></script>
<script src="js/flatui-radio.js"></script>
<script src="js/jquery.tagsinput.js"></script>
<script src="js/jquery.placeholder.js"></script>
<script src="js/jquery.stacktable.js"></script>
<script src="js/retina.js"></script>
<script src="js/application.js"></script>
<script src="ckeditor/ckeditor.js"></script>
<script src="js/smooth-scroll.js"></script>
<script type="text/javascript">
    $(document).ready(function () {

        $('.tooltip-bottom').tooltip({
            placement: 'bottom',
        });
        $('.tooltip-top').tooltip({
            placement: 'top',
        });
        $('.tooltip-right').tooltip({
            placement: 'right',
        });
        $('.tooltip-top').tooltip({
            placement: 'left',
        });

        smoothScroll.init({
            speed: 850,
            easing: 'easeInOutQuad',
        });


        $('#top-right').click(function () {
            $('#vatsimparagraph').fadeOut('slow');
            localStorage.setItem('vatsimparagraph', 1);
            return false;
        });

        if (localStorage.getItem('vatsimparagraph') != 1)
            $('#vatsimparagraph').fadeIn();

    @if (Route::currentRouteName() == "index")
        $('#findBtn').click(function () {
            moduleFind();
            return false;
        });
        $('#currentBtn').click(function () {
            moduleCurrent();
            return false;
        });
        $('#applyBtn').click(function () {
            moduleApply();
            return false;
        });
        $('#supportBtn').click(function () {
            moduleSupport();
            return false;
        })
    @endif

        var hash = window.location.hash;
        switch (hash) {
            case '#moduleFind':
                moduleFind();
                smoothScroll.animateScroll(null, '#moduleFind');
                break;
            case '#moduleCurrent':
                moduleCurrent();
                smoothScroll.animateScroll(null, '#moduleCurrent');
                break;
            case '#moduleApply':
                moduleApply();
                smoothScroll.animateScroll(null, '#moduleApply');
                break;
            case '#moduleSupport':
                moduleSupport();
                smoothScroll.animateScroll(null, '#moduleSupport');
                break;
            default:
                moduleCurrent();
                break;
        }

        function moduleFind() {
            $('#moduleCurrent, #moduleApply, #moduleSupport').hide();
            $('#moduleFind').fadeIn();
            return false;
        }

        function moduleCurrent() {
            $('#moduleApply, #moduleFind, #moduleSupport').hide();
            $('#moduleCurrent').fadeIn();
            return false;
        }

        function moduleApply() {
            $('#moduleFind, #moduleCurrent, #moduleSupport').hide();
            $('#moduleApply').fadeIn();
            return false;
        }

        function moduleSupport() {
            $('#moduleFind, #moduleCurrent, #moduleApply').hide();
            $('#moduleSupport').fadeIn();
            return false;
        }

        $('#supportNewTicketBtn').on('click', function() {
            $('#supportNewTicketForm').slideToggle('fast');
        });
        $('#supportInputResetBtn').on('click', function() {
           $('#supportNewTicketForm').slideUp('fast');
        });


        $('#q1').click(function () {
            $('#progressBar').animate({width: '15%'});
            $('#q1').animate({opacity:.2});
            $('#q2').fadeIn('slow');
            return false;
        });

        $('#moduleCurrent').mouseover(function() {
            $('#tooltip').fadeIn(1500);
        })

        function calculateInputDescription() {
                var tlength = $('#inputDescription').val().length;
                $('#inputDescription').val($('#inputDescription').val().substring(0, 200));
                var tlength = $('#inputDescription').val().length;
                var remain = 200 - tlength;
                $('#inputDescriptionRemaining').text(remain);
        }

        calculateInputDescription();
        $('#inputDescription').keyup(calculateInputDescription);

        $('#applyToStep2').click(function() {
            $('#applyStep1').hide();
            $('#applyStep2').fadeIn('slow');
            $('#applyClosingFormTag').show();
        });

        $('#submitVAForm').click(function() {
            $('#applyStep2').hide('slow');
            $('#applyStep2Errors').hide();
            $('#submittingAJAX').fadeIn();
            var _token = "{{ csrf_token() }}";
            var vaFormData;
//            vaFormData =  $("#vaApplicationForm").serialize();
            vaFormData = new FormData($('#vaApplicationForm')[0]);
            $.ajax({
                type: "POST",
                url: "{{URL::route('ajaxRegistration')}}",
                data: vaFormData,
                processData: false,
                contentType: false,
                cache: false,
            })
                .done(function(received) {
                    if (received != "") {
                        $('#submittingAJAX').hide();
                        $('#applyStep2').show('slow');
                        $('#applyStep2Errors').html(received).show('slow');
                    }
                    else {
                        $('#submittingAJAX').hide();
                        $('#applyStep2Success').fadeIn('slow');
                    }
                });
            return false;
        });

        $('#submitLoginForm').click(function() {
            $('#loginForm').hide();
            $('#loginErrorEmail').hide();
            $('#loginErrorPassword').hide();
            $('#loginLoading').show('slow');
            var loginFormData;
            loginFormData = $("#loginForm").serialize();
            $.ajax({
                type: "POST",
                url: "{{URL::route('ajaxLogin')}}",
                data: { data: loginFormData }
            })
                .done(function(received) {
                    $('#loginLoading').hide();
                    if (received == "/errorBadPassword") {
                        $('#loginForm').fadeIn('medium');
                        $('#loginErrorPassword').fadeIn('medium');
                    }
                    else if (received == "/errorBadEmail") {
                        $('#loginForm').fadeIn('medium');
                        $('#loginErrorEmail').fadeIn('medium');
                    }
                    else {
                        $('#helloUserName').html(received);
                        $('#helloUser').fadeIn('slow');
                        window.location.replace('{{ URL::route('va') }}')
                    }
                });
            return false;
        });

        function calculateInputCategory() {

            var maxAllowed = {{{ Setting::fetch('max_categories') }}};
            var cnt = $("input[name='inputCategory[]']:checked").length;
            if (cnt > maxAllowed) {
                $('#chooseOrRemove').text('Remove');
                $('#lessOrMore').text('or more');
                $('#numberOfChoicesLabel').text(Math.abs(maxAllowed - cnt)).prop('class','label label-important');
            }
            if (cnt < maxAllowed) {
                $('#chooseOrRemove').text('Choose');
                $('#lessOrMore').text('or less');
                $('#numberOfChoicesLabel').text(maxAllowed - cnt).prop('class','label label-success');
            }
            if (cnt == maxAllowed)
            {
                $('#chooseOrRemove').text('Choose');
                $('#lessOrMore').text('more');
                $('#numberOfChoicesLabel').text(maxAllowed - cnt).prop('class','label label-warning');
            }

        }
        calculateInputCategory();
        $("input[name='inputCategory[]']").change(calculateInputCategory);

        $(document).on('click', '#btnVaCategoryParent', function() {
            $(this).siblings("#selectedVaInformation").slideToggle('fast');
        });

        $(document).on('click', '#btnSelectVaCategory, #btnVaCategoryParent', function() {
            $('#vaCategoryAjaxData').hide();
            $('#vaCategoryLoader').fadeIn();
            var categoryName = $(this).text();
            $('#vaCategoryNameHeader').html(categoryName).slideDown();
            //Make the ajax call to fetch the data
            $.ajax({
                type: "POST",
                url: "{{URL::route('ajaxGetVasByCategory')}}",
                data: { data: categoryName }
            })
                .done(function(received) {
                    //Update the container and remove the loader
                    $('#vaCategoryLoader').hide();
                    $('#vaCategoryAjaxData').html(received).fadeIn('fast');
                });

        });

        $('#ajaxSearchVAs').keypress(function(e) {
            var key = e.which;
            if (key == 13) {
                $('#vaSearchAjaxData').hide();
                $('#vaSearchAjaxData').html("<h4>Loading...</h4>").fadeIn();
                var query = $('#ajaxSearchVAs').val();
                $.ajax({
                    type: "POST",
                    url: "{{ URL::route('ajaxSearchVAs') }}",
                    data: { _token: "{{ csrf_token() }}", query: query}
                })
                    .done(function(received) {
                        $('#vaSearchAjaxData').hide();
                        if (received == "") {
                            $('#vaSearchAjaxData').html("<h4>No Virtual Airlines Found...</h4>").fadeIn();
                        }
                        else {
                            $('#vaSearchAjaxData').html(received).fadeIn();
                        }
                    });
            }
        });

        $('#searchvasbtn').on('click', function(e) {
            $('#vaSearchAjaxData').hide();
            $('#vaSearchAjaxData').html("<h4>Loading...</h4>").fadeIn();
            var query = $('#ajaxSearchVAs').val();
            $.ajax({
                type: "POST",
                url: "{{ URL::route('ajaxSearchVAs') }}",
                data: { _token: "{{ csrf_token() }}", query: query}
            })
                .done(function(received) {
                    $('#vaSearchAjaxData').hide();
                    if (received == "") {
                        $('#vaSearchAjaxData').html("<h4>No Virtual Airlines Found...</h4>").fadeIn();
                    }
                    else {
                        $('#vaSearchAjaxData').html(received).fadeIn();
                    }
                });
        })

        $('#supportInputNewSubmit').on('click', function(e) {
            $('#supportNewTicketFormErrors').slideUp();
            e.preventDefault();
            var btn = $(this);
            var loader = $(this).find('i');
            loader.fadeIn();
            //I know, this is cheating
            $('#supportInputDescription').val(CKEDITOR.instances['supportInputDescription'].getData());
            var data = $('#supportNewTicketFormID').serialize();
            $.ajax({
                type: "POST",
                url: "{{ URL::route('ajaxnewguestticket') }}",
                data: { data: data }
            })
                .success(function(received) {
                    loader.fadeOut();
                    if (received == 1) {
                        btn.html('Ticket Created').attr('disabled', 'disabled');
                        $('#supportNewTicketFormErrors').html('<div class="alert alert-success">Ticket Created Successfully. Please check your email for further details.</div>').slideDown();
                    }
                    else {
                        $('#supportNewTicketFormErrors').html(received).slideDown();
                    }

                });

        });

    $('#supportFindTicketBtn').on('click', function() {
       $('#supportViewTicketForm').slideToggle('fast');
    });

    $('#supportFindTicketInputReset').on('click', function() {
        $('#supportViewTicketForm').slideUp('fast');
    });

    $('#supportFindTicketInputSubmit').on('click', function(e) {
        $('#supportViewTicketFormErrors').slideUp();
        e.preventDefault();
        var btn = $(this);
        var loader = btn.find('i');
        loader.fadeIn();
        var _token = "{{ csrf_token() }}";
        var email = $('#supportFindTicketInputEmail').val();
        var ticketid = $('#supportFindTicketInputId').val();
        $.ajax({
            type: 'POST',
            url: "{{ URL::route('ajaxguestfindticket') }}",
            data: { _token: _token, email: email, ticketid: ticketid }
        })
            .success(function(received) {
                loader.fadeOut();
                var status = received.slice(0,1);
                if (status != 1 && status != 0) {
                    $('#supportViewTicketFormErrors').html(received).slideDown();
                }
                else {
                    $('#supportViewTicketFormErrors').html('<div class="alert alert-success">Ticket ID# ' + ticketid + ' located successfully.</div>').slideDown()
                    $('#supportViewTicketResponse').html(received.substring(1)).slideDown();
                    $('#supportViewTicketResponseReply').fadeIn('fast');
                    if (status == 1) {
                        $('#supportFindTicketCloseTicket').show();
                        $('#supportFindTicketReopenTicket').hide();
                    }
                    else if (status == 0) {
                        $('#supportFindTicketReopenTicket').show();
                        $('#supportFindTicketCloseTicket').hide();
                    }
                }
            });
    })

    $('#supportFindTicketReplySubmit').on('click', function(e) {
        e.preventDefault();
        var btn = $(this);
        var loader = btn.find('i');
        var _token = "{{ csrf_token() }}";
        var content = CKEDITOR.instances['supportFindTicketInputReply'].getData();
        if (content == '') {
            CKEDITOR.instances.supportFindTicketInputReply.setData('Please detail your reply...');
        }
        else {
            loader.fadeIn();
            var ticketdiv = $('#ticketreceived');
            var ticketid = ticketdiv.attr('data-ticketid');
            var tickethash = ticketdiv.attr('data-tickethash');
            $.ajax({
                type: 'POST',
                url: "{{ URL::route('ajaxguestsubmitreply') }}",
                data: { _token: _token, content: content, ticketid: ticketid, hash: tickethash }
            })
                .success(function(received) {
                    loader.fadeOut();
                    CKEDITOR.instances.supportFindTicketInputReply.setData('');
                   //Append the response to the current response div
                    var responsediv = $('#supportViewTicketResponse');
                    responsediv.html(responsediv.html() + received);
                });
        }
    });
    $('#supportFindTicketCloseTicket').on('click', function(e) {
        e.preventDefault();
        var btn = $(this);
        var loader = btn.find('.loader');
        loader.fadeIn();
        var _token = "{{ csrf_token() }}";
        var ticketdiv = $('#ticketreceived');
        var ticketid = ticketdiv.attr('data-ticketid');
        var tickethash = ticketdiv.attr('data-tickethash');
        $.ajax({
            type: "POST",
            url: "{{ URL::route('ajaxguestcloseticket') }}",
            data: { _token: _token, ticketid: ticketid, hash: tickethash }
        })
            .success(function(received) {
                loader.fadeOut();
                $('#supportFindTicketCloseTicket').hide();
                $('#supportFindTicketReopenTicket').fadeIn();
                $('#supportViewTicketResponse').html(received);
            });
    });

    $('#supportFindTicketReopenTicket').on('click', function(e) {
        e.preventDefault();
        var btn = $(this);
        var loader = btn.find('.loader');
        loader.fadeIn();
        var _token = "{{ csrf_token() }}";
        var ticketdiv = $('#ticketreceived');
        var ticketid = ticketdiv.attr('data-ticketid');
        var tickethash = ticketdiv.attr('data-tickethash');
        $.ajax({
            type: "POST",
            url: "{{ URL::route('ajaxguestreopenticket') }}",
            data: { _token: _token, ticketid: ticketid, hash: tickethash }
        })
            .success(function(received) {
                loader.fadeOut();
                $('#supportFindTicketReopenTicket').hide();
                $('#supportFindTicketCloseTicket').fadeIn();
                $('#supportViewTicketResponse').html(received);
            });
    });

    @if (Session::has('ticketid'))
    $('#supportViewTicketForm').slideDown('fast');
    $('#supportFindTicketInputEmail').val('{{ Session::get('ticketemail') }}');
    $('#supportFindTicketInputId').val({{ Session::get('ticketid') }});
    $('#supportFindTicketInputSubmit').click();
    @endif

    $('#forgotPassBtn').on('click', function(e) {
        e.preventDefault();
        $('#loginErrorEmail, #loginErrorPassword').hide();
        $('#loginFormContainer').hide();
        $('#forgotPassFormContainer').fadeIn();
    });

    $('#cancelForgotPassBtn').on('click', function(e) {
        e.preventDefault();
        $('#forgotPassErrorEmail, #forgotPassSuccess').hide();
        $('#forgotPassFormContainer').hide();
        $('#loginFormContainer').fadeIn();
    });

    $('#forgotPassInputSubmitBtn').on('click', function(e) {
        e.preventDefault();
        $('#forgotPassErrorEmail, #forgotPassSuccess').hide();
        var btn = $(this);
        var email = $('#forgotPassInputEmail').val();
        var _token = "{{ csrf_token() }}";
        if (email != "") {
            var loader = btn.find('i');
            loader.fadeIn();
            $.ajax({
                url: "{{ Url::route('ajaxforgotpass') }}",
                type: "POST",
                data: { _token: _token, email: email }
            })
                .success(function(received) {
                   loader.fadeOut();
                   if (received == -1) {
                       $('#forgotPassErrorEmail').fadeIn();
                   }
                   if (received == 1) {
                       $('#forgotPassSuccess').fadeIn();
                   }
                });


        }
    });

    $('#copyAndPasteVARosterBtn').on('click', function(e) {
        e.preventDefault();
        $('#uploadVARosterDiv').hide();
        $('#copyVARosterDiv').slideToggle('fast');
    });

    $('#uploadVARosterBtn').on('click', function(e) {
        e.preventDefault();
        $('#copyVARosterDiv').hide();
        $('#uploadVARosterDiv').slideToggle('fast');

    });

    @yield('publicjs')





//      ***********************************************************************************
//        *************************** Require auth **************************************
//           ***********************************************************************
//              ****************************************************************
//                       *******************************************
//                              **************************
//                                      **********
//                                          ***
//                                           *





        @if (Auth::user()->check())

        $("#helloUser").mouseenter(function (){
            $('#helloUserIcon').hide();
            $('#helloUserIcon').prop('class', 'fui-cross').fadeIn('slow');
        });
        $("#helloUser").mouseleave(function (){
            $('#helloUserIcon').hide();
            $('#helloUserIcon').prop('class', 'fui-user').fadeIn('slow');
        });

        $("#helloUser").click(function (){
            $.ajax({
                type: "POST",
                url: "{{URL::route('ajaxLogout')}}"
            })
                .done(function() {
                    $("#helloUser").hide();
                    window.location = '{{URL::to('/')}}';
                });
            return false;
        });

        //Remove duplicate select options.
        $("select>option").each( function(){
            var $option = $(this);
            $option.siblings()
                .filter( function(){ return $(this).val() == $option.val() } )
                .remove()
        })

        //Edit VA Form
        $('#submitEditVAForm').click(function() {
            $('#vaEditFormSuccess').hide();
            $('#vaEditFormErrors').hide();
            $('#vaEditForm').hide('slow');
            $('#submittingAJAX').fadeIn();
            var vaFormData;
            vaFormData =  $("#vaEditForm").serialize();
            $.ajax({
                type: "POST",
                url: "{{URL::route('ajaxVAEdit')}}",
                data: { data: vaFormData }
            })
                .done(function(received) {
                    if (received != "") {
                        $('#submittingAJAX').hide();
                        $('#vaEditForm').show('slow');
                        $('#vaEditFormErrors').html(received).show('slow');
                    }
                    else {
                        $('#submittingAJAX').hide();
                        $('#vaEditFormSuccess').fadeIn('slow');
                        $('#vaEditForm').show('slow');
                    }
                });
            return false;
        })

        //Select our categories in our edit VA page
        if (typeof vaSelectedCategories != 'undefined') {
            vaSelectedCategories =  vaSelectedCategories.split(',');

            var i;
            for ( i=0; i < vaSelectedCategories.length; i++ ) {
                $('.limitToFiveCategories:checkbox').each(function() {
                    if (vaSelectedCategories[i] == $(this).val()) {
                        $(this).prop('checked', true);
                    }
                });
            }
        }
        //Now update our count
        calculateInputCategory();

        $('#btnNewTicket').click(function() {
            $('#divNewTicketForm').slideToggle();
            $('#newTicketFormErrors').fadeOut('fast');
        });

        //AJAX Submit New Ticket
        $('#submitNewTicketForm').click(function() {
            $('#divNewTicketForm').hide();
            $('#newTicketFormErrors').hide();
            $('#submittingNewTicketAJAX').fadeIn();
            var newTicketFormData;
            newTicketFormData =  $("#newTicketForm").serialize();
            $.ajax({
                type: "POST",
                url: "{{URL::route('ajaxNewTicket')}}",
                data: { data: newTicketFormData }
            })
                .done(function(received) {
                    //Verify return value is or is not an integer to decide whether to return an error or success with ticked ID to populate the close ticket button.
                    if (!$.isNumeric(received)) {
                        $('#submittingNewTicketAJAX').hide();
                        $('#divNewTicketForm').fadeIn('slow');
                        $('#newTicketFormErrors').html(received).fadeIn('slow');
                    }
                    else {
                        $('#submittingNewTicketAJAX').hide();
                        $('#noOpenTickets').hide();
                        var subject = $("#inputTicketSubject").val();
                        var description = $('#inputTicketContent').val();
                        $('#containerNewOpenTickets').prepend('<div id="newOpenTickets" style="text-align: left; padding-right: 150px; display: none;" class="well"><h6 style="text-transform: none;"><span class="label">Now</span>  <strong>' + subject + '</strong>: ' + description + '</h6><span id="btnReopenTicket" style="float: right; position: relative; top: -25px; right: -145px; display: none;"><button class="btn btn-success" value="' + received + '"><i class="fui fui-plus"></i> Reopen Ticket</button></span><span id="btnCloseTicket" style="float: right; position: relative; top: -25px; right: -145px;"><button class="btn btn-danger" value="' + received + '"><i class="fui fui-cross"></i> Close Ticket</button></span></div>');
                        var replyTicketDivTemplate = $('#replyTicketDivTemplate').clone().attr('id', 'replyTicketDiv');
                        $('#containerNewOpenTickets').find('#newOpenTickets').append(replyTicketDivTemplate).find('#replyTicketDiv').fadeIn().find("input[name='tid']").attr('value', received);
                        //Finally fade in our element
                        $('#containerNewOpenTickets div:first-child').fadeIn();
                        var openTicketsCount = $("#openTicketsCount").text();
                        openTicketsCount++;
                        $("#openTicketsCount").html(openTicketsCount).fadeOut().fadeIn();
                        $("#newTicketForm")[0].reset();
                    }
                });
            return false;
        });

        //Select each well for **closed tickets** and **open tickets** and add create the handlers for the button actions
        function createTicketBtn() {
            $('#containerNewClosedTickets, #containerNewOpenTickets').children('div').each(function() {
                //Create the event handler to listen for mouse over
                $(this).on('mouseenter', '', function() {
                    if ($(this).attr('id') == 'newClosedTickets') {
                        $(this).find('#btnReopenTicket').fadeIn('fast');
                    }
                    if ($(this).attr('id') == 'newOpenTickets') {
                        $(this).find('#btnCloseTicket').fadeIn('fast');
                    }
                });
                //Create the event handler to listen for mouse exit
                $(this).on('mouseleave', '', function() {
                    if ($(this).attr('id') == 'newClosedTickets') {
                        $(this).find('#btnReopenTicket').fadeOut('fast');
                    }
                    if ($(this).attr('id') == 'newOpenTickets') {
                        $(this).find('#btnCloseTicket').fadeOut('fast');
                    }
                });

            });
        }
        //Call our function
        createTicketBtn();

        //btnCloseTicket action -- use on because some buttons may have been added after the page load
        $(document).on('click', '#btnCloseTicket > button', function () {
            var btn = $(this);
            btn.html('<img height="77px" width="77px" alt="Loading..." src="{{ URL::to('/') }}/images/loader.gif">');
            //Make the AJAX call
                var ticketid = $(this).val();
                $.ajax({
                    type: "POST",
                    url: "{{URL::route('ajaxCloseTicket')}}",
                    data: { data: ticketid }
                })
                    .done(function(received) {
                        if (received == "") {
                            //Well crap that's an error
                            console.log('Error closing ticket');
                        }
                        else if (received == "1") {
                            //Update the page
                            var openTicketsCount = $("#openTicketsCount").text();
                            //Subtract one from our open tickets count.
                            openTicketsCount--;
                            $("#openTicketsCount").html(openTicketsCount).fadeOut().fadeIn();
                            //If we now have 0 open tickets let's fade in the no open tickets div
                            if (openTicketsCount == 0) {
                                $('#noOpenTickets').fadeIn();
                            }
                            //We need to update the number of closed tickets by one.
                            var closedTicketsCount = $("#closedTicketsCount").text();
                            closedTicketsCount++;
                            $("#closedTicketsCount").html(closedTicketsCount).fadeOut().fadeIn();
                            //If there were not any closed tickets before, there are now, so lets fade out the no closed ticket div.
                            $('#noClosedTickets').fadeOut();
                            //We need to remove the closed ticket button from the ticket div and for good measure we will add back the original text.
                            btn.html('<i class="fui fui-cross"></i> Close Ticket').closest('#btnCloseTicket').hide();
                            //Now lets ensure our reopen ticket button is visible. Look up the DOM until we find the btnCloseTicket span then look across for the btnReopenTicket sibling.
                            btn.closest('#btnCloseTicket').siblings('#btnReopenTicket').find('btn').show();
                            //Finally we need to look for the closest div up the DOM then fade it out, add it to our closed tickets container and fade it in.
                            btn.closest('div').prependTo('#containerNewClosedTickets').fadeIn();
                            //Now let's update our ids and remove the reply ticket form
                            btn.closest('#newOpenTickets').attr('id', 'newClosedTickets').find('#newOpenTickets_expanded').attr('id', 'newClosedTickets_expanded').find('#replyTicketDiv').remove();
                        }
                    });
                return false;
            });


        //btnReopenTicket action -- use on because some buttons may have been added after the page load
        $(document).on('click', '#btnReopenTicket > button', function () {
            var btn = $(this);
            btn.html('<img height="77px" width="77px" alt="Loading..." src="{{ URL::to('/') }}/images/loader.gif">')
            //Make the AJAX call
            var ticketid = $(this).val();
            $.ajax({
                type: "POST",
                url: "{{URL::route('ajaxReopenTicket')}}",
                data: { data: ticketid }
            })
                .done(function(received) {
                    if (received == "") {
                        //Well crap that's an error
                        console.log('Error reopening ticket');
                    }
                    else if (received == "1") {
                        //Update the page
                        var closedTicketsCount = $("#closedTicketsCount").text();
                        //Subtract one from our closed tickets count.
                        closedTicketsCount--;
                        $("#closedTicketsCount").html(closedTicketsCount).fadeOut().fadeIn();
                        //If we now have 0 closed tickets let's fade in the no open tickets div
                        if (closedTicketsCount == 0) {
                            $('#noClosedTickets').fadeIn();
                        }
                        //We need to update the number of open tickets by one.
                        var openTicketsCount = $("#openTicketsCount").text();
                        openTicketsCount++;
                        $("#openTicketsCount").html(openTicketsCount).fadeOut().fadeIn();
                        //If there were not any open tickets before, there are now, so lets fade out the no open ticket div.
                        $('#noOpenTickets').fadeOut();
                        //We need to remove the reopen ticket button from the ticket div and for good measure we will add back the original text.
                        btn.html('<i class="fui fui-plus"></i> Reopen Ticket').closest('#btnReopenTicket').hide();
                        //Now lets ensure our closed ticket button is visible. Look up the DOM until we find the btnCloseTicket span then look across for the btnReopenTicket sibling.
                        btn.closest('#btnReopenTicket').siblings('#btnCloseTicket').find('btn').show();
                        //Finally we need to look for the closest div up the DOM then fade it out, add it to our closed tickets container and fade it in.
                        btn.closest('div').prependTo('#containerNewOpenTickets').fadeIn();
                        //Clone our replyTicketDivTemplate
                        var replyTicketDivTemplateClone = $('#replyTicketDivTemplate').clone().attr('id', 'replyTicketDiv').show();
                        //Change the hidden input ticket id with the ticket_id element
                        var inputTid = replyTicketDivTemplateClone.find("input[name='tid']");
                        if (inputTid.val() == '') {
                            var ticket_id = btn.closest('#newClosedTickets').find("input[name='ticket_id']").val();
                            inputTid.val(ticket_id);
                        }
                        //Now we will change the id of container and add the expanded div
                        btn.closest('#newClosedTickets').attr('id', 'newOpenTickets').find('#newClosedTickets_expanded').attr('id', 'newOpenTickets_expanded').append(replyTicketDivTemplateClone);
                    }
                });
            return false;
        });

        //Expand open tickets action
        $(document).on('click', '#newOpenTickets', function(e) {
            //We want to make sure that we are not triggering this with clicking on the text box or the submit button.
            if (e.target.id != 'inputReplyTicket' && e.target.id != 'replyTicketSubmitBtn') {
                $(this).children('#newOpenTickets_expanded').slideToggle();
            }
        });

        //Expand closed tickets action
        $(document).on('click', '#newClosedTickets, #newClosedTickets > h6', function() {
                $(this).children('#newClosedTickets_expanded').slideToggle();
        });

        //Submit ticket reply
        $(document).on('click', '#replyTicketSubmitBtn', function() {
            var btn = $(this);
            var errors = btn.closest('form').siblings('#replyTicketErrors');
            //It isn't clearing the error.
            errors.hide().html('');
            //Put the loading icon in the button
            $(this).html('<img height="77px" width="77px" alt="Loading..." src="{{ URL::to('/') }}/images/loader.gif">');
            var replyTicketForm;
            replyTicketForm =  btn.closest("#replyTicketForm");
            var replyTicketForm_serialized = replyTicketForm.serialize();
            $.ajax({
                type: "POST",
                url: "{{URL::route('ajaxReplyTicket')}}",
                data: { data: replyTicketForm_serialized }
            })
                .done(function(received) {
                    if (received != "1") {
                        //Well crap that's an error. We will advise the user
                        errors.html(received).fadeIn();
                        btn.html('Submit Reply');
                    }
                    else if (received == "1") {
                        //Success - now Update the page
                        var content = replyTicketForm.find('#inputReplyTicket').val();
                        //Possible error here.
                        content.replace('/(<([^>]+)>)/ig',"");
                        //Fix this line
                        btn.closest('#replyTicketDiv').before('<hr style="width: 80%" /><div><span style="text-align: left; margin-right: 20px;"><strong>{{ Auth::user()->get()->name; }}</strong></span><span style="">' + content + '</span></div>');
                        //Edit our button content from the ajax loader.
                        btn.html('Submit Reply');
                        //Reset our form.
                        replyTicketForm[0].reset();
                    }
                });
            return false;
        });

        //Refresh image link back status.
        $(document).on('click', '#btnRefreshImageLinkBack', function() {
            $('#imageLinkBackError').hide();
            $('#imageLinkBackLoader').show();
            $.ajax({
                type: "POST",
                url: "{{URL::route('ajaxCheckImageLinkBack')}}"
            })
                .done(function(received) {
                    if (received == "1") {
                        //Great the link appears to exist, let's update the field
                        $('#imageLinkBackLoader').hide();
                        $('#imageLinkBackError').attr('class', 'fui-check').fadeIn();
                        $('#btnRefreshImageLinkBack').fadeOut();
                    }
                    else if (received == "1!") {
                        //Great the link appears to exist as well as their status is active so we can update the field and the change the red X to a check at the top.
                        $('#imageLinkBackLoader').hide();
                        $('#imageLinkBackError').attr('class', 'fui-check').fadeIn();
                        $('#statusDisabled').hide();
                        $('#statusEnabled').fadeIn();
                        $('#btnRefreshImageLinkBack').fadeOut();

                    }
                    else if (received == "0") {
                        //No luck
                        $('#imageLinkBackLoader').hide();
                        $('#imageLinkBackError').fadeIn();
                    }
                    else {
                        //Well crap that's an error. We will advise the user
                        console.log('Error processing the link back request');
                    }
                });
        });

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

        switch(window.location.hash) {
            case('#status'):
                $('#VaTabs a[href="#status"]').tab('show')
                break;
            case('#editva'):
                $('#VaTabs a[href="#editva"]').tab('show')
                break;
            case('#banner'):
                $('#VaTabs a[href="#banner"]').tab('show')
                break;
            case('#clicks'):
                $('#VaTabs a[href="#clicks"]').tab('show')
                break;
            case('#help'):
                $('#VaTabs a[href="#help"]').tab('show')
                break;
        }

        $('#uploadNewBannerBtn').on('click', function() {
            $('#currentBannerActions').slideUp('fast');
            $('#uploadBannerForm').slideDown('fast');
        });
        $('#bannerUploadCancel').on('click', function() {
            if ($('#currentBanner').length) {
                $('#uploadBannerForm').slideUp('fast');
                $('#currentBannerActions').slideDown('fast');
                $('#errorBannerInvalidType').slideUp('fast');
                $('#errorBannerEmpty').slideUp('fast');
            }
        });

        $('#deleteBannerBtn').on('click', function() {
            $(this).html('<img height="77px" width="77px" alt="Loading..." src="{{ URL::to('/') }}/images/loader.gif">');
            $.ajax({
                type: "POST",
                url: "{{URL::route('ajaxDeleteBanner')}}",
                data: { _token: "{{ csrf_token(); }}" }
            })
                .done(function(received) {
                    if (received == "1") {
                        //Great the image was deleted successfully.
                        $('#currentBanner').slideUp('fast');
                        $('#bannerUploadCancel').remove();
                        $('#uploadBannerForm').slideDown('fast');
                    }
                    else {
                        //Well crap that's an error. We will log it in the console and advise the user.
                        console.log('Error deleting the image. ');
                        $(this).html('Delete Banner');
                    }
                });

        });

        @yield('authjs')


        @endif


    });



</script>
</body>
</html>
