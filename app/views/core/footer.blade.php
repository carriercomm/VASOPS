<footer>
    <div class="container">
        <div class="row">
            <div class="span7">
                <img src="images/logo.gif" alt="Vatsim"/>

                <h3 class="footer-title">Subscribe</h3>

                <p>VATSIM Virtual Airline System Beta
                </p>

                <p class="pvl">
                </p>

            </div>
            <!-- /span8 -->

            <div class="span5">
                <div class="footer-banner">
                    <h3 class="footer-title">CS</h3>
                    <ul>
                        <li>Cool contact info here</li>
                        <li>Many places to find help</li>
                        <li>VATSIM Rules</li>
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
<script src="js/bootstrap.min.js"></script>
<script src="js/bootstrap-select.js"></script>
<script src="js/bootstrap-switch.js"></script>
<script src="js/flatui-checkbox.js"></script>
<script src="js/flatui-radio.js"></script>
<script src="js/jquery.tagsinput.js"></script>
<script src="js/jquery.placeholder.js"></script>
<script src="js/jquery.stacktable.js"></script>
<script src="http://vjs.zencdn.net/c/video.js"></script>
<script src="js/application.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#top-right').click(function () {
            $('#vatsimparagraph').fadeOut('slow');
            return false;
        });

        $('#findBtn').click(function () {
            $('#moduleCurrent').hide();
            $('#moduleApply').hide();
            $('#moduleFind').fadeIn();
            return false;
        });
        $('#currentBtn').click(function () {
            $('#moduleApply').hide();
            $('#moduleFind').hide();
            $('#moduleCurrent').fadeIn();
            return false;
        });
        $('#applyBtn').click(function () {
            $('#moduleFind').hide();
            $('#moduleCurrent').hide();
            $('#moduleApply').fadeIn();
            return false;
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

        $('#goLogin').click(function() {
            $('#loginForm').hide();
            $('#helloUser').fadeIn();
            return false;
        })

        $('#inputDescription').keyup(function() {
            var tlength = $('#inputDescription').val().length;
            $('#inputDescription').val($('#inputDescription').val().substring(0, '200'));
            var tlength = $('#inputDescription').val().length;
            var remain = 200 - tlength;
            $('#inputDescriptionRemaining').text(remain);
        });

        $('#applyToStep2').click(function() {
            $('#applyStep1').hide();
            $('#applyStep2').fadeIn('slow');
            $('#applyClosingFormTag').show();
        });

        $('#submitVAForm').click(function() {
            $('#applyStep2').hide('slow');
            $('#submittingAJAX').fadeIn();
            var vaFormData;
            vaFormData =  $("#vaApplicationForm").serialize();
          //  alert(vaFormData);
            $.ajax({
                type: "POST",
                url: "{{URL::route('ajaxRegistration')}}",
                data: { data: vaFormData }
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

        $("input[name='inputCategory[]']").change(function () {
            var maxAllowed = 5;
            var cnt = $("input[name='inputCategory[]']:checked").length;
            if (cnt > maxAllowed) {
               $('#chooseOrRemove').text('Remove');
               $('#numberOfChoicesLabel').text(Math.abs(maxAllowed - cnt)).prop('class','label label-important');
            }
            if (cnt < maxAllowed) {
                $('#chooseOrRemove').text('Choose');
                $('#numberOfChoicesLabel').text(maxAllowed - cnt).prop('class','label label-success');
            }
            if (cnt == maxAllowed)
            {
                $('#chooseOrRemove').text('Choose');
                $('#numberOfChoicesLabel').text(maxAllowed - cnt).prop('class','label label-warning');
            }
        });
    });




</script>
</body>
</html>