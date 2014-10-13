@include('core.header')
<div style="margin-top: 20px;" class="row">
    <div class="span12">
        <h2>Manage Your Virtual Airline</h2>
    </div>
</div>
<div style="margin-top: 20px; margin-bottom: 50px;" class="row">
    <div class="span12">
        <ul id="VaTabs" class="nav nav-tabs">
            <li class="active"><a href="#status" data-toggle="tab">Status</a></li>
            <li><a href="#editva" data-toggle="tab">Edit VA</a></li>
            <li><a href="#roster" data-toggle="tab">Roster</a></li>
            <li><a href="#banner" data-toggle="tab">Banner</a></li>
            <li><a href="#clicks" data-toggle="tab">Clicks</a></li>
            <li><a href="#help" data-toggle="tab">Help</a></li>
        </ul>
        <div class="tile">
            <div class="tab-content">
                <div class="tab-pane fade in active" id="status">
                    @if ($record->status == 1 && $record->linkbackstatus == 1)
                    <span id="statusEnabled"><img src="{{ URL::to('/') }}/images/checkbox.png" alt="Check Box"></span>
                    <span id="statusDisabled" style="display: none;"><img src="{{ URL::to('/') }}/images/x.png" alt="X"></span>
                    @else
                    <span id="statusEnabled" style="display: none;"><img src="{{ URL::to('/') }}/images/checkbox.png" alt="Check Box"></span>
                    <span id="statusDisabled"><img src="{{ URL::to('/') }}/images/x.png" alt="X"></span>
                    @endif
                    <h3>Status</h3>
                    <div style="text-align: left;" class="span3">
                        <h4><i class="fui fui-check-inverted"></i> Approved</h4>
                    </div>
                    <div class="span2 offset6">
                        @if ($record->status == 1)
                        <h4><i class="fui-check"></i></h4>
                        @else
                        <h4><i class="fui-cross"></i></h4>
                        @endif
                    </div>
                    <div style="text-align: left;" class="span3">
                        <h4><i class="fui fui-photo"></i>  Image Link Back</h4>
                    </div>
                    <div class="span2 offset6">
                        @if ($record->linkbackstatus == 1)
                        <h4><i class="fui-check"></i></h4>
                        @else
                        <h4><i id="imageLinkBackError" class="fui-cross"></i><span style="display: none;" id="imageLinkBackLoader"><img width="24px" height="24px" src="{{ URL::to('/') }}/images/circularloader.gif" alt="Loading..." /></span></h4><button id="btnRefreshImageLinkBack" style="float: right; position: absolute; right: 30px; top: 130px;" class="btn"><i class="fui-eye"></i></button>
                        @endif
                    </div>
                </div>
                <div class="tab-pane fade in" id="editva">
                    <h3 style="margin-bottom: 15px;">Edit Virtual Airline</h3>

                    @include('ajax.submitting')

                    <div id="vaEditFormErrors"></div>
                    <div style="display: none;" class="alert alert-success" id="vaEditFormSuccess">Saved</div>

                    <form id="vaEditForm" class="form-horizontal">
                    <input type="hidden" name="_token" value="{{ csrf_token(); }}">
                    <div class="control-group">
                        <label class="control-label" for="inputVaName">VA Name</label>
                        <div class="controls">
                            <input name="inputVaName" type="text" id="inputVaName" value="{{$record->vaname}}" />
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="inputUrl">URL</label>
                        <div class="controls">
                            <input name="inputUrl" class="" type="text" id="inputUrl" value="{{$record->url}}" />
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="inputDescription">Description (<strong><span id="inputDescriptionRemaining">200</span></strong> characters left)</label>
                        <div class="controls">
                            <textarea max-length="200" name="inputDescription" id="inputDescription" rows="3">{{$record->description}}</textarea>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="inputVatsimImagePageLink">Link to Vatsim Image Page</label>
                        <div class="controls">
                            <input name="inputVatsimImagePageLink" type="text" id="inputVatsimImagePageLink" value="{{$record->vatsimimagepagelink}}" />
                        </div>
                    </div>
                    <div class="control-group">
                    <label class="control-label" for="inputCountry">Country</label>
                    <div class="controls">
                    <select name="inputCountry" id="inputCountry">
                    <option id="selectedCountry" value="{{$record->country}}" selected="selected">{{$record->country}}</option>
                    <option value="USA">USA</option>
                    <option value="Afghanistan">Afghanistan</option>
                    <option value="Albania">Albania</option>
                    <option value="Algeria">Algeria</option>
                    <option value="American Samoa">American Samoa</option>
                    <option value="Andorra">Andorra</option>
                    <option value="Angola">Angola</option>
                    <option value="Anguilla">Anguilla</option>
                    <option value="Antarctica">Antarctica</option>
                    <option value="Antigua and Barbuda">Antigua and Barbuda</option>
                    <option value="Argentina">Argentina</option>
                    <option value="Armenia">Armenia</option>
                    <option value="Aruba">Aruba</option>
                    <option value="Australia">Australia</option>
                    <option value="Austria">Austria</option>
                    <option value="Azerbaijan">Azerbaijan</option>
                    <option value="Bahamas">Bahamas</option>
                    <option value="Bahrain">Bahrain</option>
                    <option value="Bangladesh">Bangladesh</option>
                    <option value="Barbados">Barbados</option>
                    <option value="Belarus">Belarus</option>
                    <option value="Belgium">Belgium</option>
                    <option value="Belize">Belize</option>
                    <option value="Benin">Benin</option>
                    <option value="Bermuda">Bermuda</option>
                    <option value="Bhutan">Bhutan</option>
                    <option value="Bolivia">Bolivia</option>
                    <option value="Bosnia and Herzegowina">Bosnia and Herzegowina</option>
                    <option value="Botswana">Botswana</option>
                    <option value="Bouvet Island">Bouvet Island</option>
                    <option value="Brazil">Brazil</option>
                    <option value="Brunei Darussalam">Brunei Darussalam</option>
                    <option value="Bulgaria">Bulgaria</option>
                    <option value="Burkina Faso">Burkina Faso</option>
                    <option value="Burundi">Burundi</option>
                    <option value="Cambodia">Cambodia</option>
                    <option value="Cameroon">Cameroon</option>
                    <option value="Canada">Canada</option>
                    <option value="Cape Verde">Cape Verde</option>
                    <option value="Cayman Islands">Cayman Islands</option>
                    <option value="Central African Republic">Central African Republic</option>
                    <option value="Chad">Chad</option>
                    <option value="Chile">Chile</option>
                    <option value="China">China</option>
                    <option value="Christmas Island">Christmas Island</option>
                    <option value="Cocos (Keeling) Islands">Cocos (Keeling) Islands</option>
                    <option value="Colombia">Colombia</option>
                    <option value="Comoros">Comoros</option>
                    <option value="Congo">Congo</option>
                    <option value="Cook Islands">Cook Islands</option>
                    <option value="Costa Rica">Costa Rica</option>
                    <option value="Cote D'Ivoire">Cote D'Ivoire</option>
                    <option value="Croatia">Croatia</option>
                    <option value="Cuba">Cuba</option>
                    <option value="Cyprus">Cyprus</option>
                    <option value="Czech Republic">Czech Republic</option>
                    <option value="Denmark">Denmark</option>
                    <option value="Djibouti">Djibouti</option>
                    <option value="Dominica">Dominica</option>
                    <option value="Dominican Republic">Dominican Republic</option>
                    <option value="East Timor">East Timor</option>
                    <option value="Ecuador">Ecuador</option>
                    <option value="Egypt">Egypt</option>
                    <option value="El Salvador">El Salvador</option>
                    <option value="Equatorial Guinea">Equatorial Guinea</option>
                    <option value="Eritrea">Eritrea</option>
                    <option value="Estonia">Estonia</option>
                    <option value="Ethiopia">Ethiopia</option>
                    <option value="Falkland Islands">Falkland Islands</option>
                    <option value="Faroe Islands">Faroe Islands</option>
                    <option value="Fiji">Fiji</option>
                    <option value="Finland">Finland</option>
                    <option value="France">France</option>
                    <option value="France, Metropolitan">France, Metropolitan</option>
                    <option value="French Guiana">French Guiana</option>
                    <option value="French Polynesia">French Polynesia</option>
                    <option value="Gabon">Gabon</option>
                    <option value="Gambia">Gambia</option>
                    <option value="Georgia">Georgia</option>
                    <option value="Germany">Germany</option>
                    <option value="Ghana">Ghana</option>
                    <option value="Gibraltar">Gibraltar</option>
                    <option value="Greece">Greece</option>
                    <option value="Greenland">Greenland</option>
                    <option value="Grenada">Grenada</option>
                    <option value="Guadeloupe">Guadeloupe</option>
                    <option value="Guam">Guam</option>
                    <option value="Guatemala">Guatemala</option>
                    <option value="Guinea">Guinea</option>
                    <option value="Guinea-Bissau">Guinea-Bissau</option>
                    <option value="Guyana">Guyana</option>
                    <option value="Haiti">Haiti</option>
                    <option value="Honduras">Honduras</option>
                    <option value="Hong Kong SAR, PRC">Hong Kong SAR, PRC</option>
                    <option value="Hungary">Hungary</option>
                    <option value="Iceland">Iceland</option>
                    <option value="India">India</option>
                    <option value="Indonesia">Indonesia</option>
                    <option value="Iran">Iran</option>
                    <option value="Iraq">Iraq</option>
                    <option value="Ireland">Ireland</option>
                    <option value="Israel">Israel</option>
                    <option value="Italy">Italy</option>
                    <option value="Jamaica">Jamaica</option>
                    <option value="Japan">Japan</option>
                    <option value="Jordan">Jordan</option>
                    <option value="Kazakhstan">Kazakhstan</option>
                    <option value="Kenya">Kenya</option>
                    <option value="Kiribati">Kiribati</option>
                    <option value="D.P.R. Korea">D.P.R. Korea</option>
                    <option value="Korea">Korea</option>
                    <option value="Kuwait">Kuwait</option>
                    <option value="Kyrgyzstan">Kyrgyzstan</option>
                    <option value="Lao People's Republic">Lao People's Republic</option>
                    <option value="Latvia">Latvia</option>
                    <option value="Lebanon">Lebanon</option>
                    <option value="Lesotho">Lesotho</option>
                    <option value="Liberia">Liberia</option>
                    <option value="Libyan Arab Jamahiriya">Libyan Arab Jamahiriya</option>
                    <option value="Liechtenstein">Liechtenstein</option>
                    <option value="Lithuania">Lithuania</option>
                    <option value="Luxembourg">Luxembourg</option>
                    <option value="Macau">Macau</option>
                    <option value="Macedonia">Macedonia</option>
                    <option value="Madagascar">Madagascar</option>
                    <option value="Malawi">Malawi</option>
                    <option value="Malaysia">Malaysia</option>
                    <option value="Maldives">Maldives</option>
                    <option value="Mali">Mali</option>
                    <option value="Malta">Malta</option>
                    <option value="Marshall Islands">Marshall Islands</option>
                    <option value="Martinique">Martinique</option>
                    <option value="Mauritania">Mauritania</option>
                    <option value="Mauritius">Mauritius</option>
                    <option value="Mayotte">Mayotte</option>
                    <option value="Mexico">Mexico</option>
                    <option value="Micronesia">Micronesia</option>
                    <option value="Moldova">Moldova</option>
                    <option value="Monaco">Monaco</option>
                    <option value="Mongolia">Mongolia</option>
                    <option value="Montserrat">Montserrat</option>
                    <option value="Morocco">Morocco</option>
                    <option value="Mozambique">Mozambique</option>
                    <option value="Myanmar">Myanmar</option>
                    <option value="Namibia">Namibia</option>
                    <option value="Nauru">Nauru</option>
                    <option value="Nepal">Nepal</option>
                    <option value="Netherlands">Netherlands</option>
                    <option value="Netherlands Antilles">Netherlands Antilles</option>
                    <option value="New Caledonia">New Caledonia</option>
                    <option value="New Zealand">New Zealand</option>
                    <option value="Nicaragua">Nicaragua</option>
                    <option value="Niger">Niger</option>
                    <option value="Nigeria">Nigeria</option>
                    <option value="Niue">Niue</option>
                    <option value="Norfolk Island">Norfolk Island</option>
                    <option value="Northern Mariana Islands">Northern Mariana Islands</option>
                    <option value="Norway">Norway</option>
                    <option value="Oman">Oman</option>
                    <option value="Pakistan">Pakistan</option>
                    <option value="Palau">Palau</option>
                    <option value="Panama">Panama</option>
                    <option value="Papua New Guinea">Papua New Guinea</option>
                    <option value="Paraguay">Paraguay</option>
                    <option value="Peru">Peru</option>
                    <option value="Philippines">Philippines</option>
                    <option value="Pitcairn">Pitcairn</option>
                    <option value="Poland">Poland</option>
                    <option value="Portugal">Portugal</option>
                    <option value="170">Puerto Rico>170>Puerto Rico</option>
                    <option value="Qatar">Qatar</option>
                    <option value="Reunion">Reunion</option>
                    <option value="Romania">Romania</option>
                    <option value="Russian Federation">Russian Federation</option>
                    <option value="Rwanda">Rwanda</option>
                    <option value="Saint Kitts and Nevis">Saint Kitts and Nevis</option>
                    <option value="Saint Lucia">Saint Lucia</option>
                    <option value="Samoa">Samoa</option>
                    <option value="San Marino">San Marino</option>
                    <option value="Sao Tome and Principe">Sao Tome and Principe</option>
                    <option value="Saudi Arabia">Saudi Arabia</option>
                    <option value="Senegal">Senegal</option>
                    <option value="Seychelles">Seychelles</option>
                    <option value="Sierra Leone">Sierra Leone</option>
                    <option value="Singapore">Singapore</option>
                    <option value="Slovakia">Slovakia</option>
                    <option value="Slovenia">Slovenia</option>
                    <option value="Solomon Islands">Solomon Islands</option>
                    <option value="Somalia">Somalia</option>
                    <option value="South Africa">South Africa</option>
                    <option value="Spain">Spain</option>
                    <option value="Sri Lanka">Sri Lanka</option>
                    <option value="St Helena">St Helena</option>
                    <option value="St Pierre and Miquelon">St Pierre and Miquelon</option>
                    <option value="Sudan">Sudan</option>
                    <option value="Suriname">Suriname</option>
                    <option value="Swaziland">Swaziland</option>
                    <option value="Sweden">Sweden</option>
                    <option value="Switzerland">Switzerland</option>
                    <option value="Syrian Arab Republic">Syrian Arab Republic</option>
                    <option value="Taiwan Region">Taiwan Region</option>
                    <option value="Tajikistan">Tajikistan</option>
                    <option value="Tanzania">Tanzania</option>
                    <option value="Thailand">Thailand</option>
                    <option value="Togo">Togo</option>
                    <option value="Tokelau">Tokelau</option>
                    <option value="Tonga">Tonga</option>
                    <option value="Trinidad and Tobago">Trinidad and Tobago</option>
                    <option value="Tunisia">Tunisia</option>
                    <option value="Turkey">Turkey</option>
                    <option value="Turkmenistan">Turkmenistan</option>
                    <option value="Turks and Caicos Islands">Turks and Caicos Islands</option>
                    <option value="Tuvalu">Tuvalu</option>
                    <option value="Uganda">Uganda</option>
                    <option value="Ukraine">Ukraine</option>
                    <option value="United Arab Emirates">United Arab Emirates</option>
                    <option value="United Kingdom">United Kingdom</option>
                    <option value="Uruguay">Uruguay</option>
                    <option value="Uzbekistan">Uzbekistan</option>
                    <option value="Vanuatu">Vanuatu</option>
                    <option value="Vatican City State">Vatican City State</option>
                    <option value="Venezuela">Venezuela</option>
                    <option value="Viet Nam">Viet Nam</option>
                    <option value="Virgin Islands (British)">Virgin Islands (British)</option>
                    <option value="Virgin Islands (US)">Virgin Islands (US)</option>
                    <option value="Wallis and Futuna Islands">Wallis and Futuna Islands</option>
                    <option value="Yugoslavia">Yugoslavia</option>
                    <option value="Yemen">Yemen</option>
                    <option value="Zaire">Zaire</option>
                    <option value="Zambia">Zambia</option>
                    <option value="Zimbabwe">Zimbabwe</option>
                    <option value="Other-Not Shown">Other-Not Shown</option>

                    </select>
                    </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="inputName">Full Name</label>
                        <div class="controls">
                            <input name="inputName" type="text" id="inputName" value="{{$record->name}}" />
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="inputEmail">Email Address</label>
                        <div class="controls">
                            <input name="inputEmail" type="text" id="inputEmail" value="{{$record->email}}" />
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="inputPassword">Password</label>
                        <div class="controls">
                            <input name="inputPassword" type="password" id="inputPassword" placeholder="Leave blank unless changing" />
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="inputPassword_confirmation">Confirm Password</label>
                        <div class="controls">
                            <input name="inputPassword_confirmation" type="password" id="inputPassword_confirmation" placeholder="Leave blank unless changing" />
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="inputCategory"><span id="chooseOrRemove">Choose</span> <span id="numberOfChoicesLabel" class="label label-success"></span> <span id="lessOrMore">or less</span> categories</label>
                        <div style="text-align: left; width: 30%; margin-left: 45%;" class="controls">
                            @foreach ($categories as $category)
                            <div class="checkbox">
                                <label>
                                    <input class="limitToFiveCategories" name="inputCategory[]" type="checkbox" data-toggle="checkbox" value="{{ $category->id }}">
                                        {{ $category->name }}
                                </label>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <hr />
                    <div class="control-group">
                        <div class="controls">
                            <button id="submitEditVAForm" class="btn btn-success">Submit <i class="fui fui-check"></i></button>
                        </div>
                    </div>
                    <!--   </form> -->
                </div>
                <div style="display: none;" id="applyClosingFormTag">
                    </form>
                </div>
                <div class="tab-pane fade in" id="roster">
                    <h3 style="margin-bottom: 15px;">Roster</h3>
                    @if (!empty($va->rosterdata))
                    <div class="well">
                        {{ $va->rosterdata }}
                    </div>
                    @elseif (!empty($va->rosterfile))
                    <pre>Download Roster File: <a href="{{ URL::to('/') }}{{{ Setting::fetch('roster_directory') }}}/{{{ $va->rosterfile }}}" download="{{{ $va->rosterfile }}}">Click Here</a></pre>
                    @else
                    <div class="alert alert-warning">No roster data linked to your VA.</div>
                    <!--<button id="copyAndPasteVARosterBtn" class="btn btn-info"><i class="fa fa-list-ol fa-fw"></i> Copy and Paste VA Roster</button> <small>or</small> <button id="uploadVARosterBtn" class="btn btn-info"><i class="fa fa-upload fa-fw"></i> Upload VA Roster Data</button>
                    <div style="margin-top: 7px; display: none;" id="copyVARosterDiv" class="well">
                        VATSIM requires that your VA has 10 pilots with active VATSIM CIDs. Active means more than 1 hour flying time on VATSIM, using your VA's callsign, in the last 3 months, as verified by VATSIM Server Records. Please provide a roster of your pilots on your website available with CIDs so we may quickly identify your 10 or more VATSIM pilots. You may copy and paste the data into the text area below.
                        <hr>
                        <div style="margin-top: 8px;"><textarea rows="7" style="width: 80%;" id="inputCopyVARoster" name="inputCopyVARoster" placeholder="Please copy your VA roster here..."></textarea></div>
                    </div>
                    <div style="display: none; margin-top: 7px;" id="uploadVARosterDiv" class="well">
                        VATSIM requires that your VA has 10 pilots with active VATSIM CIDs. Active means more than 1 hour flying time on VATSIM, using your VA's callsign, in the last 3 months, as verified by VATSIM Server Records. Please provide a roster of your pilots on your website available with CIDs so we may quickly identify your 10 or more VATSIM pilots. You may upload one of the following file types: .doc, .docx, .csv, .xls, .xlsx, .txt, .rtf.
                        <hr>
                        <div style="margin-top: 8px;"><input type="file" id="inputUploadVARoster" name="inputUploadVARoster"></div>
                    </div>-->
                    @endif
                    <strong>Please submit any roster data via a help desk ticket.</strong>
                </div>
                <div class="tab-pane fade in" id="banner">
                    <h3 style="margin-bottom: 15px;">Banner</h3>
                    <p id="errorBannerEmpty" style="display: none;" class="alert alert-danger">You must select an image to upload. Please try again.</p>
                    <p id="errorBannerInvalidType" style="display: none;" class="alert alert-danger">Invalid file type. Please upload a jpg or png image only.</p>
                    <p id="errorBannerDelete" style="display: none;" class="alert alert-danger">Oops. Sorry about that. We had trouble deleting your banner. Please use the help desk to seek support.</p>
                    @if ($banner)
                    <div id="currentBanner">
                    <img style="margin-bottom: 20px;" class="img-polaroid" src="{{{ $banner }}}" alt="banner" />
                    <div id="currentBannerActions" class="form-actions">
                        <button id="uploadNewBannerBtn" style="margin-right: 7px;" class="btn btn-success">Upload New Banner</button><button id="deleteBannerBtn" class="btn btn-danger">Delete Banner</button>
                    </div>
                    </div>
                    @endif
                    <form id="uploadBannerForm" style="@if ($banner) display: none; @endif" action="{{ URL::route('uploadbanner') }}" enctype="multipart/form-data" method="POST" id="banner-form" class="form-inline">
                        <input type="hidden" name="_token" value="{{ csrf_token(); }}">
                        <div class="control-group">
                            <div class="controls">
                                <input name="inputBanner" type="file" id="inputBanner" />
                            </div>
                        </div>
                        <p style="font-style: italic;">(jpg or png image only, max size 500px x 200px)</p>
                        <div class="control-group">
                            <div class="form-actions">
                                <input id="bannerUploadSubmit" type="submit" class="btn btn-success" value="Upload" />
                                <input id="bannerUploadCancel" type="reset" class="btn" value="Cancel" />
                            </div>
                        </div>
                    </form>
                </div>
                <div class="tab-pane fade in" id="clicks">
                    <h3>Clicks</h3>
                    <div><small>(More detailed stats coming soon)</small></div>
                    <div style="margin-top: 20px;">Total Number of Clicks: <span class="label label-warning"><strong>{{{ $clicks }}}</strong></span></div>
                </div>
                <div class="tab-pane fade in" id="help">
                    <h3>Contact an Audit Manager</h3>
                    <span><button id="btnNewTicket" style="width: 80%;" class="btn btn-info">New Ticket</button></span>
                    <div id="submittingNewTicketAJAX" style="display:none;">

                        <img alt="Loading..." src="{{ URL::to('/') }}/images/loader.gif">

                    </div>
                    <div style="padding-top: 5px; width: 80%; display:none; margin-left: 10%" id="newTicketFormErrors"></div>
                    <div style="display: none; margin-top: 10px;" id="divNewTicketForm">
                        <form id="newTicketForm" class="form-inline">
                            <input type="hidden" name="_token" value="{{ csrf_token(); }}">
                            <div class="control-group">
                                <div class="controls">
                                    <input style="width: 79%;" id="inputTicketSubject" name="inputTicketSubject" type="text" placeholder="Please enter a subject..." />
                                </div>
                            </div>
                            <div class="control-group">
                                <div class="controls">
                                    <textarea style="width: 78%;" name="inputTicketContent" id="inputTicketContent" rows="5" placeholder="Please detail your question..."></textarea>
                                </div>
                            </div>
                            <div class="control-group">
                                <div class="form-actions">
                                    <button id="submitNewTicketForm" class="btn btn-success">Create Ticket <i class="fui fui-check"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div style="margin-top: 40px;">
                        <span style="text-align: left;"><h4><i class="fui fui-chat"></i>  Open Tickets - <span id="openTicketsCount" class="label label-warning">{{ $tickets['opentickets_count'] }}</span></h4></span>
                        <p id="noOpenTickets" style="@if ($tickets['opentickets_count'] != 0) display: none; @endif">You currently have no open tickets.</p>
                        <div id="newOpenTicketsTemplate" style="text-align: left; display: none;" class="well">
                        </div>
                        <div id="containerNewOpenTickets">
                            @foreach ($tickets['opentickets'] as $ticket)
                            <div id="newOpenTickets" style="text-align: left; padding-right: 150px;" class="well">
                                <h6 style="font-style: italic; text-transform: none;"><span class="label">{{ $ticket->updated_at }}</span>  <strong>{{{ $ticket->subject }}}</strong>: {{ $ticket->description }}</h6><span id="btnReopenTicket" style="float: right; position: relative; top: -25px; right: -145px; display: none;"><button class="btn btn-success" value="{{ $ticket->id }}"><i class="fui fui-plus"></i> Reopen Ticket</button></span><span id="btnCloseTicket" style="float: right; position: relative; top: -25px; right: -145px; display: none;"><button class="btn btn-danger" value="{{ $ticket->id }}"><i class="fui fui-cross"></i> Close Ticket</button></span>
                                <div style="display: none;" id="newOpenTickets_expanded">
                                    @foreach ($tickets['replies'] as $reply)
                                    @if ($reply->tid == $ticket->id)
                                    <hr style="width: 80%" />
                                    <div><span style="text-align: left; margin-right: 20px;">@if ($reply->staff == 1) <span class="label label-important"><i class="icon icon-bookmark icon-white"></i> {{{ ConsoleUser::getName($reply->author) }}}</span> @else <strong>{{{ User::getFullName($reply->author) }}}</strong>@endif</span><span style="">{{ $reply->content }}</span></div>
                                    @endif
                                    @endforeach

                                    <div id="replyTicketDiv" style="width: 80%">
                                        <hr />
                                        <div id="replyTicketErrors" style="display: none;"></div>
                                        <form id="replyTicketForm" class="form-inline">
                                            <input type="hidden" name="_token" value="{{ csrf_token(); }}" />
                                            <input type="hidden" name="tid" value="{{ $ticket->id }}" />
                                            <div id="inputReplyTicketControlGroup" class="control-group">
                                                <div class="controls">
                                                    <textarea style="width: 95%;" id="inputReplyTicket" name="inputReplyTicket" placeholder="Please detail your reply..."></textarea>
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <div class="form-actions">
                                                    <button id="replyTicketSubmitBtn" class="btn btn-success">Submit Reply</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @endforeach

                            <div id="replyTicketDivTemplate" style="width: 80%; display: none;">
                                <hr />
                                <div id="replyTicketErrors" style="display: none;"></div>
                                <form id="replyTicketForm" class="form-inline">
                                    <input type="hidden" name="_token" value="{{ csrf_token(); }}" />
                                    <input type="hidden" name="tid" value="" />
                                    <div id="inputReplyTicketControlGroup" class="control-group">
                                        <div class="controls">
                                            <textarea style="width: 95%;" id="inputReplyTicket" name="inputReplyTicket" placeholder="Please detail your reply..."></textarea>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <div class="form-actions">
                                            <button id="replyTicketSubmitBtn" class="btn btn-success">Submit Reply</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div style="margin-top: 40px;">
                        <span style="text-align: left"><h4><i class="fui fui-time"></i>  Closed Tickets - <span id="closedTicketsCount" class="label label-warning">{{ $tickets['closedtickets_count'] }}</span></h4></span>
                        <p id="noClosedTickets" style="@if ($tickets['closedtickets_count'] != 0) display: none; @endif">You currently have no closed tickets.</p>
                        <div id="containerNewClosedTickets">
                            @foreach ($tickets['closedtickets'] as $ticket)
                            <div id="newClosedTickets" style="text-align: left; padding-right: 150px;" class="well">
                                <input type="hidden" name="ticket_id" value="{{ $ticket->id }}" />
                                <h6 style="text-transform: none;"><span class="label">{{ $ticket->updated_at }}</span>  <strong>{{{ $ticket->subject }}}</strong>: {{ $ticket->description }}</h6><span id="btnReopenTicket" style="float: right; position: relative; top: -25px; right: -145px; display: none;"><button class="btn btn-success" value="{{ $ticket->id }}"><i class="fui fui-plus"></i> Reopen Ticket</button></span><span id="btnCloseTicket" style="float: right; position: relative; top: -25px; right: -145px; display: none;"><button class="btn btn-danger" value="{{ $ticket->id }}"><i class="fui fui-cross"></i> Close Ticket</button></span>
                                <div style="display: none;" id="newClosedTickets_expanded">
                                    @foreach ($tickets['replies'] as $reply)
                                    @if ($reply->tid == $ticket->id)
                                    <hr style="width: 80%" />
                                    <div><span style="text-align: left; margin-right: 20px;">@if ($reply->staff == 1) <span class="label label-important"><i class="icon icon-bookmark icon-white"></i> {{{ ConsoleUser::getName($reply->author) }}}</span> @else<strong>{{{ User::getFullName($reply->author) }}}</strong> @endif </span><span style="">{{ $reply->content }}</span></div>
                                    @endif
                                    @endforeach
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    var vaSelectedCategories = "{{$record->categories}}";
</script>

@include('core.footer')