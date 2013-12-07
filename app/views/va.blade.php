@include('core.header')
<div style="margin-top: 20px;" class="row">
    <div class="span12">
        <h2>Manage Your Virtual Airline</h2>
    </div>
</div>
<div style="margin-top: 20px; margin-bottom: 50px;" class="row">
    <div class="span12">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#status" data-toggle="tab">Status</a></li>
            <li><a href="#editva" data-toggle="tab">Edit VA</a></li>
            <li><a href="#clicks" data-toggle="tab">Clicks</a></li>
        </ul>
        <div class="tile">
            <div class="tab-content">
                <div class="tab-pane fade in active" id="status">
                    <h3>Status</h3>
                    <div style="text-align: left;" class="span2">
                        <h4>Active</h4>
                    </div>
                    <div class="span2 offset6">
                        <h4><i class="fui-cross"></i></h4>
                    </div>
                    <div style="text-align: left;" class="span2">
                        <h4>Image Link Back</h4>
                    </div>
                    <div class="span2 offset6">
                        <h4><i class="fui-check"></i></h4>
                    </div>
                </div>
                <div class="tab-pane fade in" id="editva">
                    <h3>Edit Virtual Airline</h3>
                </div>
                <div class="tab-pane fade in" id="clicks">
                    <h3>Clicks</h3>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <tr><th>August</th><th>September</th><th>October</th><th>November</th></tr>
                            <tr><td>203</td><td>2233</td><td>3</td><td>2803</td></tr>
                            <tr><td>297</td><td>973</td><td>5643</td><td>8703</td></tr>
                            <tr><td>754</td><td>2565</td><td>66</td><td>878</td></tr>
                            <tr><td>186</td><td>3</td><td>8644</td><td>453</td></tr>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

@include('core.footer')