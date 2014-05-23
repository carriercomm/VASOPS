@include('console.core.header')
@include('console.core.navbartop')
@include('console.core.navbarside')
<div id="page-wrapper">
    @if (Session::get('message') != '')
    <div class="row">
        <div class="col-lg-12">
            <div style="margin-top: 20px;" class="alert alert-warning">{{ Session::get('message') }}</div>
        </div>
    </div>
    @endif
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header"><i class="fa fa-ellipsis-h fa-fw"></i> Category Manager</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-primary">
                <div id="createCategoryToggle" style="cursor: pointer;" class="panel-heading">
                    Add Category <i class="fa fa-plus fa-fw"></i>
                </div>
                <div id="createCategoryPanelBody" style="display: none;" class="panel-body">
                    <form id="createCategoryForm" role="form" action="{{ URL::route('consolecategoriesnew') }}" method="POST">
                        <input name="_token" type="hidden" value="{{ csrf_token() }}" />
                        <div id="createCategoryFormGroup" class="form-group">
                            <input type="text" class="form-control" name="inputCategoryName" id="inputCategoryName" placeholder="Category Name" />
                        </div>
                        <div class="form-group">
                            <label style="font-weight: normal; font-style: italic;">(Optional)</label>
                            <select class="form-control" id="inputCategoryParent" name="inputCategoryParent">
                                <option>Select a Parent Category</option>
                                @foreach ($potentialparents as $potentialparent)
                                <option value="{{{ $potentialparent->id }}}">{{{ $potentialparent->name }}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-actions">
                            <input id="createCategoryBtn" type="submit" class="btn btn-success" value="Add Category" />
                            <input style="color: white;" id="resetCategoryBtn" type="reset" class="btn" value="Cancel" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <table class="table table-bordered table-responsive table-striped">
                <tr><th>Category Name</th><th>Actions</th></tr>
                @foreach($potentialparents as $potentialparent)
                <tr><td><strong>{{{ $potentialparent->name }}}</strong></td><td><i class="fa fa-edit fa-fw"></i> <i class="fa fa-times fa-fw"></i></td></tr>
                @foreach($children as $child)

                @if($child->parentid == $potentialparent->id)
                <tr><td><i class="fa fa-arrow-right fa-fw"></i> {{{ $child->name }}}</td><td><i class="fa fa-edit fa-fw"></i> <span class="deleteChildCategory"><i id="{{{ $child->id }}}" class="fa fa-times fa-fw"></i></span></td></tr>
                @endif

                @endforeach
                @endforeach
            </table>
        </div>
    </div>
    <!-- /#page-wrapper -->
    @include('console.core.footer')