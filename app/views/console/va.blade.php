@include('console.core.header')
@include('console.core.navbartop')
@include('console.core.navbarside')
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header"><i class="fa fa-plane fa-fw"></i>{{{ $va->vaname }}}</h1>
        </div>
    </div>
    <div style="margin-bottom: 20px;" class="row">
        <div class="col-lg-12">
            <ul class="nav nav-pills">
                <li class="active">
                    <a href="#profile" data-toggle="tab">
                        Profile
                    </a>
                </li>
                <li>
                  <a href="#banner" data-toggle="tab">
                      Banner
                  </a>
                </li>
                <li>
                    <a href="#status" data-toggle="tab">
                        Status
                    </a>
                </li>
                <li>
                    <a href="#audit" data-toggle="tab">
                        Audit Log
                    </a>
                </li>
            </ul>

        </div>
    </div>
    <div class="tab-content">
        <div id="profile" class="tab-pane fade in active">
            <div class="row">
            <div class="col-lg-6">
            <table style="min-width: 100%; cursor: pointer;" class="table-responsive">
            <tbody>
            <tr>
                <td><h4><small>cid</small></h4></td><td><h4>{{{ $va->cid }}}</h4></td>
            </tr>
            <tr>
                <td><h4><small>name</small></h4></td>
                <td>
                    <h4 id="vaNameField">{{{ $va->name }}}</h4>
                    <form>
                        <div class="input-group" style="display: none;" id="vaNameInputDiv">
                            <input class="form-control" id="vaNameInput" type="text" value="{{{ $va->name }}}" />
                                            <span class="input-group-btn">
                                                <button id="vaEditInputSubmit" class="btn btn-success">
                                                    Save
                                                </button>
                                                <input id="vaNameInputReset" type="reset" class="btn btn-warning" value="Cancel"/>
                                            </span>
                        </div>
                    </form>
                </td>
            </tr>
            <tr>
                <td><h4><small>email</small></h4></td><td><h4 id="vaEmailField">{{{ $va->email }}}</h4>
                    <form>
                        <div class="input-group" style="display: none;" id="vaEmailInputDiv">
                            <input class="form-control" id="vaEmailInput" type="text" value="{{{ $va->email }}}" />
                                            <span class="input-group-btn">
                                                <button id="vaEditInputSubmit" class="btn btn-success">
                                                    Save
                                                </button>
                                                <input id="vaEmailInputReset" type="reset" class="btn btn-warning" value="Cancel"/>
                                            </span>
                        </div>
                    </form>
                </td>
            </tr>
            <tr>
                <td><h4><small>url</small></h4></td><td><h4 id="vaUrlField">{{{ $va->url }}}</h4>
                    <form>
                        <div class="input-group" style="display: none;" id="vaUrlInputDiv">
                            <input class="form-control" id="vaUrlInput" type="text" value="{{{ $va->url }}}" />
                                            <span class="input-group-btn">
                                                <button id="vaEditInputSubmit" class="btn btn-success">
                                                    Save
                                                </button>
                                                <input id="vaUrlInputReset" type="reset" class="btn btn-warning" value="Cancel"/>
                                            </span>
                        </div>
                    </form>
                </td>
            </tr>
            <tr>
                <td><h4><small>city</small></h4></td><td><h4 id="vaCityField">{{{ $va->city }}}</h4>
                    <form>
                        <div class="input-group" style="display: none;" id="vaCityInputDiv">
                            <input class="form-control" id="vaCityInput" type="text" value="{{{ $va->city }}}" />
                                            <span class="input-group-btn">
                                                <button id="vaEditInputSubmit" class="btn btn-success">
                                                    Save
                                                </button>
                                                <input id="vaCityInputReset" type="reset" class="btn btn-warning" value="Cancel"/>
                                            </span>
                        </div>
                    </form>
                </td>
            </tr>
            <tr>
                <td><h4><small>state</small></h4></td><td><h4 id="vaStateProvinceField">{{{ $va->stateprovince }}}</h4>
                    <form>
                        <div class="input-group" style="display: none;" id="vaStateProvinceInputDiv">
                            <input class="form-control" id="vaStateProvinceInput" type="text" value="{{{ $va->stateprovince }}}" />
                                            <span class="input-group-btn">
                                                <button id="vaEditInputSubmit" class="btn btn-success">
                                                    Save
                                                </button>
                                                <input id="vaStateProvinceInputReset" type="reset" class="btn btn-warning" value="Cancel"/>
                                            </span>
                        </div>
                    </form>
                </td>
            </tr>
            <tr>
                <td><h4><small>postal</small></h4></td><td><h4 id="vaZipField">{{{ $va->zip }}}</h4>
                    <form>
                        <div class="input-group" style="display: none;" id="vaZipInputDiv">
                            <input class="form-control" id="vaZipInput" type="text" value="{{{ $va->zip }}}" />
                                            <span class="input-group-btn">
                                                <button id="vaEditInputSubmit" class="btn btn-success">
                                                    Save
                                                </button>
                                                <input id="vaZipInputReset" type="reset" class="btn btn-warning" value="Cancel"/>
                                            </span>
                        </div>
                    </form>
                </td>
            </tr>
            <tr>
            <td><h4><small>country</small></h4></td><td><h4 id="vaCountryField">{{{ $va->country }}}</h4>
            <form>
            <div class="input-group" style="display: none;" id="vaCountryInputDiv">
            <select class="form-control" id="vaCountryInput">
            <option value="">Choose a country...</option>
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
                                            <span style="margin-left: -3px;" class="input-group-btn">
                                                <button id="vaEditInputSubmit" class="btn btn-success">
                                                    Save
                                                </button>
                                                <input id="vaCountryInputReset" type="reset" class="btn btn-warning" value="Cancel"/>
                                            </span>
            </div>
            </form>
            </td>
            </tr>
            <tr>
                <td><h4><small>description</small></h4></td><td><h4 id="vaDescriptionField">{{{ $va->description }}}</h4>
                    <form>
                        <div class="input-group" style="display: none;" id="vaDescriptionInputDiv">
                            <input class="form-control" id="vaDescriptionInput" type="text" value="{{{ $va->description }}}" />
                                            <span class="input-group-btn">
                                                <button id="vaEditInputSubmit" class="btn btn-success">
                                                    Save
                                                </button>
                                                <input id="vaDescriptionInputReset" type="reset" class="btn btn-warning" value="Cancel"/>
                                            </span>
                        </div>
                    </form>
                </td>
            </tr>
            <tr>
                <td><h4><small>updated</small></h4></td><td><h4 id="vaUpdatedField">{{{ $va->updated_at }}}</h4>
                    <form>
                        <div id="vaUpdatedInputDiv" class="input-group" style="display: none;">
                            <input id="vaUpdatedInput" disabled="disabled" class="form-control" type="text" value="{{{ $va->updated_at }}}" />
                                            <span class="input-group-btn">
                                                <button disabled="disabled" class="btn btn-success">
                                                    Save
                                                </button>
                                                <input id="vaUpdatedInputReset" type="reset" class="btn btn-warning" value="Cancel"/>
                                            </span>
                        </div>
                    </form>
                </td>
            </tr>
            <tr>
                <td><h4><small>created</small></h4></td><td><h4 id="vaCreatedField">{{{ $va->created_at }}}</h4>
                    <form>
                        <div id="vaCreatedInputDiv" class="input-group" style="display: none;">
                            <input id="vaCreatedInput" disabled="disabled" class="form-control" type="text" value="{{{ $va->created_at }}}" />
                                            <span class="input-group-btn">
                                                <button disabled="disabled" class="btn btn-success">
                                                    Save
                                                </button>
                                                <input id="vaCreatedInputReset" type="reset" class="btn btn-warning" value="Cancel"/>
                                            </span>
                        </div>
                    </form>
                </td>
            </tr>
            </tbody>

            </table>
            </div>

            </div>
        </div>
        <div id="banner" class="tab-pane fade in">
            <div style="margin-top: 35px;" class="row">
                <div class="col-lg-4">
                    @if (empty($banner))
                    <p id="errorBannerEmpty" style="display: none;" class="alert alert-danger">You must select an image to upload. Please try again.</p>
                    <p id="errorBannerInvalidType" style="display: none;" class="alert alert-danger">Invalid file type. Please upload a jpg or png image only.</p>
                    <form id="uploadBannerForm" action="{{ URL::route('consoleuploadbanner') }}" enctype="multipart/form-data" method="POST" id="banner-form" class="form-inline">
                        <input type="hidden" name="_token" value="{{ csrf_token(); }}" />
                        <input type="hidden" name="va" value="{{{ $va->cid }}}" />
                        <div class="control-group">
                            <div class="controls">
                                <input name="inputBanner" type="file" id="inputBanner" />
                            </div>
                        </div>
                        <p style="font-style: italic;">(jpg or png image only, max size {{{ $banner_maxwidth }}}px x {{{ $banner_maxheight }}}px)</p>
                        <div class="control-group">
                            <div class="form-actions">
                                <input id="bannerUploadSubmit" type="submit" class="btn btn-success" value="Upload" />
                                <input style="color: #FFFFFF;" id="bannerUploadCancel" type="reset" class="btn" value="Cancel" />
                            </div>
                        </div>
                    </form>
                    @else
                    <p id="errorBannerDelete" style="display: none;" class="alert alert-danger">Oops. Sorry about that. We had trouble deleting the banner.</p>
                    <span style="margin: 0 auto;">
                        <img style="margin-bottom: 20px;" class="img-polaroid" src="{{{ $banner }}}" alt="banner" />
                    </span>
                    <form id="removeBannerForm" action="{{ URL::route('consoleremovebanner') }}" method="POST">
                    <input type="hidden" name="_token" value="{{ csrf_token(); }}" />
                    <input type="hidden" name="va" value="{{{ $va->cid }}}" />
                    <div class="control-group">
                        <div class="form-actions">
                            <input style="margin-left: 25%;" type="submit" class="btn btn-danger" value="Remove Banner" />
                        </div>
                    </div>
                    </form>
                    @endif
                </div>
            </div>
        </div>
        <div id="status" class="tab-pane fade in">

        </div>
        <div id="audit" class="tab-pane fade in">
            <div class="row">
                <div class="col-lg-4">
                    <button id="showAuditInput" style="width: 100%;" class="btn btn-info">
                        Add a notation
                    </button>
                    <div style="display: none;" id="auditInputFormActions">
                        <button class="btn btn-success" style="width: 49%; margin-right: 2px;" id="submitAuditInput">Submit</button><button class="btn" style="width: 49%; color: white;" id="cancelAuditInput">Cancel</button>
                    </div>
                    <form style="margin-top: 3px; display: none;" id="auditInputForm" class="form" action="#" method="post">
                        <input type="hidden" id="_token" value="{{ csrf_token() }}" />
                        <div class="form-group">
                            <textarea name="inputAuditLog" id="inputAuditLog" class="form-control" rows="5" placeholder="Detail your comments..."></textarea>
                        </div>
                    </form>
                    <hr />
                    <div id="auditLogDiv">
                        @foreach ($audit_log as $log)
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <small>{{{ $log->created_at }}} - {{{ ConsoleUser::getName($log->author) }}}</small>
                            </div>
                            <div class="panel-body">
                                {{{ $log->content }}}
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /#page-wrapper -->
<script>
    var vacid = {{{ $va->cid }}};
    var name = '{{{ Auth::consoleuser()->get()->name }}}';
</script>
@include('console.core.footer')