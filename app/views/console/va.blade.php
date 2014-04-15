@include('console.core.header')
@include('console.core.navbartop')
@include('console.core.navbarside')
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header"><i class="fa fa-plane fa-fw"></i>{{{ $va->vaname }}}</h1>
        </div>
    </div>

    @if (!empty($banner))

    <div style="margin-bottom: 25px;" class="row">
        <div class="col-lg-12">
            <img style="max-width:90%; max-height:90%;" class="img-polaroid" src="{{{ $banner }}}" alt="Banner" />
        </div>
    </div>
    @endif
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
                                            <button class="btn btn-success">
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
                                            <button class="btn btn-success">
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
                                            <button class="btn btn-success">
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
                                            <button class="btn btn-success">
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
                                            <button class="btn btn-success">
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
                                            <button class="btn btn-success">
                                                Save
                                            </button>
                                            <input id="vaZipInputReset" type="reset" class="btn btn-warning" value="Cancel"/>
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
                                            <button class="btn btn-success">
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
<!-- /#page-wrapper -->
@include('console.core.footer')