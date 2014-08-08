@include('core.header')


<!--</div>-->
<h1></h1>

<div style="margin-bottom: 20px;" class="row">
    <div class="span12">
        <div class="well" id="vatsimparagraph" style="display: none; position: relative;"><span id="top-right" class="fui-cross"></span>VATSIM is an online community created for enthusiasts of flight simulation and air traffic control. One of the main goals of VATSIM is to create an environment which is fun and, at the same time, an educational and realistic simulation of procedures followed by pilots and air traffic controllers everyday around the world. We recognize the contributions of virtual airlines as significant and integral parts of the flight simulation community which allows many online pilots to experience the unique characteristics of the airline industry combined with authentic live air traffic control.  </div>

    </div>
</div>
<div id="moduleApply" style="display: none;">
<div style="margin-bottom: 20px;" class="row">
    <div class="span8">
        <h2 id="applyTitle"><i class="fa fa-user fa-fw"></i> Apply to be a VATSIM Virtual Airline Partner</h2>
    </div>
</div>
<div class="row">
<div class="span12">
<div id="applyStep1">
    <div class="well">
        All airlines listed in the VATSIM database must meet these basic requirements:<br /><br /><br />
        (1) The airline management supports VATSIM and encourages their pilots to use VATSIM approved software for flying on the VATSIM network.<br /><br />

        (2) Many of their pilots regularly fly online, giving the airline a presence on the VATSIM network. The requirement is a minimum of ten pilots who have flown on VATSIM under your VA callsign within the last 90 days<br /><br />

        (3) The airline must have been in existence for at least three months. The three month period starts when your VA is fully functional and open for new pilots to sign up.<br /><br />

        (4) Each airline has 10 or more pilots with a verified VATSIM PID/CID, listed in an easy to find roster or rosters (if hub based), who fly actively on the VATSIM Network. If your roster is not easily visible, send us a list with PID/CID. <strong>Those virtual airlines that use VA Financials must open a support ticket containing their roster of pilots who use VATSIM accompanied by their CID.</strong><br /><br />

        (5) Each airline displays a VATSIM logo, with link, on their website homepage, preferably in a conspicuous location. This is usually the front page or alternatively in a Partners page linked from the main page. VATSIM logos can now be found by navigating here: http://www.vatsim.net/network/docs/library/, then log in, then navigate to VATSIM logos on the left hand side".<br /><br />

        (6) The VA must have a dedicated website. No free website services are permitted.<br /><br />

        (7) All VAs must maintain an active email address from which they can be contacted by VATSIM officials.<br /><br />

        (8) As a VA Partner, each VA will maintain decorum and respect both on the VATSIM network and in their own website communications regarding comments, discussions and interactions with other VATSIM members and participants.<br /><br />

        *ALSO NOTE*<br /><br />

        A) VAs, when applying for partnership, must include all the requested information from above to help the application be processed promptly. To apply for affiliation, use the form below.<br /><br />

        B) An airline may be removed from the database at any time for any valid reason as deemed by VATSIM officials to include, but not limited to: Dead links, bad email addresses, continuous misbehavior by pilots on the network, or failure to adhere to the above stated affiliation requirements.<br /><br />
    </div>
    <button id="applyToStep2" class="btn"><i class="fa fa-check fa-fw"></i> I have read and fully understand these rules and regulations</button>
</div>
<div style="display:none;" id="applyStep2Success">
    <div class="alert alert-success">
        Congratulations your submission was submitted successfully. You should receive an email with further details. Please now login and upload a banner for your virtual airline.
    </div>
</div>
<div style="display: none;" id="applyStep2">
<div style="display: none;" id="applyStep2Errors"></div>
<form id="vaApplicationForm" class="form-horizontal">
<input type="hidden" name="_token" value="{{ csrf_token(); }}">
<div class="control-group">
    <label class="control-label" for="inputCid">VATSIM CID</label>
    <div class="controls">
        <input name="inputCid" type="text" id="inputCid" placeholder="CID" />
    </div>
</div>
<div class="control-group">
    <label class="control-label" for="inputVaName">VA Name</label>
    <div class="controls">
        <input name="inputVaName" type="text" id="inputVaName" placeholder="VA Name" />
    </div>
</div>
<div class="control-group">
    <label class="control-label" for="inputUrl">URL</label>
    <div class="controls">
        <div class="input-prepend">
            <span class="add-on">http://</span>
            <input name="inputUrl" class="" type="text" id="inputUrl" placeholder="www." />
        </div>
    </div>
</div>
<div class="control-group">
    <label class="control-label" for="inputDescription">Description (<strong><span id="inputDescriptionRemaining">200</span></strong> characters left)</label>
    <div class="controls">
        <textarea max-length="200" name="inputDescription" id="inputDescription" rows="3"></textarea>
    </div>
</div>
<div class="control-group">
    <label class="control-label" for="inputVatsimImagePageLink">Link to Vatsim Image Page</label>
    <div class="controls">
        <input name="inputVatsimImagePageLink" type="text" id="inputVatsimImagePageLink" placeholder="Link to Vatsim Image Page" />
    </div>
</div>
<div class="control-group">
<label class="control-label" for="inputCountry">Country</label>
<div class="controls">
<select name="inputCountry" id="inputCountry">
<option value="" selected="selected">Please Select</option>
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
        <input name="inputName" type="text" id="inputName" placeholder="" />
    </div>
</div>
<div class="control-group">
    <label class="control-label" for="inputEmail">Email Address</label>
    <div class="controls">
        <input name="inputEmail" type="text" id="inputEmail" placeholder="" />
    </div>
</div>
<div class="control-group">
    <label class="control-label" for="inputPassword">Password</label>
    <div class="controls">
        <input name="inputPassword" type="password" id="inputPassword" placeholder="" />
    </div>
</div>
<div class="control-group">
    <label class="control-label" for="inputPassword_confirmation">Confirm Password</label>
    <div class="controls">
        <input name="inputPassword_confirmation" type="password" id="inputPassword_confirmation" placeholder="" />
    </div>
</div>
<div class="control-group">
    <label><span id="chooseOrRemove">Choose</span> <span id="numberOfChoicesLabel" class="label label-success"></span> <span id="lessOrMore">or less</span> categories</label>
    <div class="controls">
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
<div class="control-group">
    <label>Virtual Airline Roster: </label>
    <div class="controls">
        <button id="copyAndPasteVARosterBtn" class="btn btn-info"><i class="fa fa-list-ol fa-fw"></i> Copy and Paste VA Roster</button><small> or </small><button id="uploadVARosterBtn" class="btn btn-info"><i class="fa fa-upload fa-fw"></i> Upload VA Roster File</button>
        <div style="display:none; margin-top: 7px;" id="copyVARosterDiv" class="well">
            VATSIM requires that your VA has 10 pilots with active VATSIM CIDs. Active means more than 1 hour flying time on VATSIM, using your VA's callsign, in the last 3 months, as verified by VATSIM Server Records. Please provide a roster of your pilots on your website available with CIDs so we may quickly identify your 10 or more VATSIM pilots. You may copy and paste the data into the text area below.
            <hr />
            <div style="margin-top: 8px;"><textarea rows="7" style="width: 80%;" id="inputCopyVARoster" name="inputCopyVARoster" placeholder="Please copy your VA roster here..."></textarea></div>
        </div>
        <div style="display: none; margin-top: 7px;" id="uploadVARosterDiv" class="well">
            VATSIM requires that your VA has 10 pilots with active VATSIM CIDs. Active means more than 1 hour flying time on VATSIM, using your VA's callsign, in the last 3 months, as verified by VATSIM Server Records. Please provide a roster of your pilots on your website available with CIDs so we may quickly identify your 10 or more VATSIM pilots. You may upload one of the following file types: .doc, .docx, .csv, .xls, .xlsx, .txt, .rtf.
            <hr />
            <div style="margin-top: 8px;"><input type="file" id="inputUploadVARoster" name="inputUploadVARoster" /></div>
        </div>
    </div>
</div>
<hr />
<div class="control-group">
    <div class="controls">
        <button id="submitVAForm" class="btn btn-success">Submit <i class="fa fa-arrow-right fa-fw"></i></button>
    </div>
</div>
<!--   </form> -->
</div>
<div style="display: none;" id="applyClosingFormTag">
    </form>
</div>


@include('ajax.submitting')
</div>
</div>
</div>
<div id="moduleCurrent" style="display: none;">
    <div style="height: 90px;" class="row">
        <div id="tooltip" style="display: none;" class="span3 offset4">
            <div id="va-tooltip" class="tooltip fade top in" style="">
                <div class="tooltip-arrow"></div>
                <div class="tooltip-inner">Select a Virtual Airline Category</div>
            </div>
        </div>
    </div>
    <div style="margin: 0 auto;" class="row">
        <div class="span12">
            <hr />
            @foreach($categories as $category)
            @if (array_key_exists($category->id, $categoryChildren) && Category::countChildren($category->id) > 0)
            <span>
                <button id="btnVaCategoryParent" style="margin-bottom: 25px;" class="btn btn-info">{{{ $category->name }}}  <i class="fui fui-plus"></i></button>
                <div id="selectedVaInformation" style="display: none; margin-bottom: 10px;">
                    <blockquote>
                        @foreach ($categoryChildren[$category->id] as $child)
                        <button id="btnSelectVaCategory" style="margin-bottom: 5px;" class="btn btn-success">{{ $child }}</button>
                        @endforeach
                    </blockquote>
                </div>
            </span>
            @elseif (array_key_exists($category->id, $categoryChildren) && Category::countChildren($category->id) == 0)
            <span>
                <button id="btnSelectVaCategory" style="margin-bottom: 25px;" class="btn btn-info">{{{ $category->name }}}</button>
            </span>
            @endif
            @endforeach
            <hr />
        </div>
    </div>
    <div class="row">
        <div class="span12">
            <div class="alert alert-warning" style="display: none;" id="vaCategoryNameHeader"></div>
            <span id="vaCategoryLoader" style="text-align: center; display: none;"><img alt="Loading..." src="{{ URL::to('/') }}/images/loader.gif"></span>
            <div id="vaCategoryAjaxData" style="display: none;">
            </div>
        </div>
    </div>
</div>
<div id="moduleFind" style="display: none;">
    <div style="margin-bottom: 30px;" class="row">
        <div class="span5">
            <h2><i class="fa fa-search fa-fw"></i> Search for Virtual Airlines</h2>
        </div>
    </div>
    <div class="row">
        <div class="span12">
            <div class="control-group">
                <div class="controls">
                    <div style="width: 100%;" class="input-append">
                    <input id="ajaxSearchVAs" style="width: 100%;" class="input-large" type="text" placeholder="Virtual Airline Name..." />
                    <span class="add-on"><i class="fa fa-search fa-fw"></i></span>
                    </div>
                </div>
                <div class="form-actions">
                    <button id="searchvasbtn" class="btn btn-success"><i class="fa fa-search fa-fw"></i> Search</button>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="span12">
            <div id="vaSearchAjaxData" style="display: none;"></div>
        </div>
    </div>
</div>
<div id="moduleSupport" style="display: none;">
    <div class="row">
        <div class="span12">
            <h2><i class="fa fa-support fa-fw"></i> Contact an Audit Manager</h2>
        </div>
    </div>
    <div style="margin-top: 20px;" class="row">
        <div class="span12">
            <button id="supportNewTicketBtn" style="width: 100%;" class="btn btn-primary"><i class="fa fa-plus fa-fw"></i> Create a New Ticket</button>
        </div>
        <div id="supportNewTicketForm" style="display: none; padding:top: 20px; margin-top: 20px;" class="span12">
            <div class="well">
                <div style="display: none;" id="supportNewTicketFormErrors">
                </div>
                <div class="form-horizontal">
                    <form id="supportNewTicketFormID" class="form" method="POST">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                        <div style="" class="control-group">
                            <label class="control-label" for="supportInputName">Name: </label>
                            <div class="controls">
                                <input style="" id="supportInputName" name="supportInputName" placeholder="Enter your name..." type="text" class="input-xlarge" />
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="supportInputEmail">Email: </label>
                            <div class="controls">
                                <input style="" id="supportInputEmail" name="supportInputEmail" placeholder="Enter your email..." type="text" class="input-xlarge" />
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="supportInputSubject">Subject: </label>
                            <div class="controls">
                                <input style="" id="supportInputSubject" name="supportInputSubject" placeholder="Enter a subject..." type="text" class="input-xxlarge" />
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="supportInputDescription">Description: </label>
                            <div class="controls">
                                <textarea rows="7" class="input-xxlarge" name="supportInputDescription" id="supportInputDescription" placeholder="Please detail your inquiry..."></textarea>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="supportInputHuman">What is the parent organization that VASOPS falls under? </label>
                            <div class="controls">
                                <input style="" id="supportInputHuman" name="supportInputHuman" placeholder="Enter your anti-spam answer... (Hint: the answer is in this website's domain)" type="text" class="input-xxlarge" />
                            </div>
                        </div>
                        <div class="control-group">
                            <div class="form-actions">
                                <div class="controls">
                                    <button class="btn btn-success" id="supportInputNewSubmit"><i style="display: none;" class="fa fa-circle-o-notch fa-spin"></i> Submit Ticket</button>
                                    <input id="supportInputResetBtn" type="reset" class="btn btn-default" value="Cancel" />
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <hr />
    <div style="margin-top: 10px;" class="row">
        <div class="span12">
            <button id="supportFindTicketBtn" style="width: 100%;" class="btn btn-warning"><i class="fa fa-search fa-fw"></i> View a Ticket</button>
        </div>
        <div id="supportViewTicketForm" style="display:none;">
            <div style="padding-top: 20px; margin-top: 20px;" class="span12">
                <div class="well">
                    <div style="display: none;" id="supportViewTicketFormErrors">
                    </div>
                    <form>
                        <div class="form-horizontal">
                            <div class="control-group">
                                <label class="control-label" for="supportFindTicketInputEmail">Email Address: </label>
                                <div class="controls">
                                    <input id="supportFindTicketInputEmail" type="text" class="input-xlarge" placeholder="Email Address..." />
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="supportFindTicketInputId">Ticket ID <i class="fa fa-slack fa-fw"></i>: </label>
                                <div class="controls">
                                    <input type="text" id="supportFindTicketInputId" class="input-small" placeholder="Ticket ID #..." />
                                </div>
                            </div>
                            <div class="form-actions">
                                <button id="supportFindTicketInputSubmit" class="btn btn-success"><i style="display: none;" class="fa fa-circle-o-notch fa-spin fa-fw"></i> Locate Ticket</button>
                                <input id="supportFindTicketInputReset" class="btn btn-default" type="reset" value="Cancel" />
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="span12">
                <div style="display: none;" id="supportViewTicketResponse" class="well">
                </div>
                <div style="display: none;" id="supportViewTicketResponseReply" class="well">
                    <form>
                        <textarea rows="8" class="input-xxlarge" id="supportFindTicketInputReply" name="supportFindTicketInputReply" placeholder="Please detail your reply..."></textarea>
                        <div class="form-actions">
                            <button id="supportFindTicketReplySubmit" class="btn btn-success"><i style="display: none;" class="fa fa-circle-o-notch fa-spin fa-fw loader"></i> Submit Reply <i class="fa fa-arrow-right fa-fw"></i></button>
                            <button style="display: none;" id="supportFindTicketCloseTicket" class="btn btn-info"><i style="display: none;" class="fa fa-circle-o-notch fa-spin fa-fw loader"></i> Close Ticket <i class="fa fa-check-circle fa-fw"></i></button>
                            <button style="display: none;" id="supportFindTicketReopenTicket" class="btn btn-warning"><i style="display: none;" class="fa fa-circle-o-notch fa-spin fa-fw loader"></i> Reopen Ticket <i class="fa fa-history fa-fw"></i></button>
                            <input type="reset" value="Cancel" class="btn btn-default" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@section('publicjs')
CKEDITOR.replace('supportInputDescription');
CKEDITOR.replace('supportFindTicketInputReply');
@endsection
@include('core.footer')