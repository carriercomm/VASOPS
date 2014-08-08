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
    <div class="row">
        <div class="col-lg-12">
            <div class="alert alert-warning"><i class="fa fa-bullhorn fa-fw"></i> <strong>Warning</strong>:  Please exercise caution when using the Category Manager as certain actions are destructive.</div>
        </div>
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
                        <div class="form-group">
                            <label>Hidden: <small>(If checked, this category will not be selectable by a VA. VA's must be added to this category by an audit manager)</small></label>
                            <input name="categoryHidden" value="1" class="checkbox" type="checkbox" />
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
            <div class="table-responsive">
                <table class="table table-bordered table-responsive table-striped">
                    <tr><th>ID</th><th>Category Name</th><th>Actions</th></tr>
                    @foreach($potentialparents as $potentialparent)
                    <tr><td>{{{ $potentialparent->id }}}</td><td><strong>{{{ $potentialparent->name }}}</strong></td><td><a class="nolinkstyle" href="{{ URL::route('consolecategories') }}/edit/{{{ $potentialparent->id }}}"><i class="fa fa-edit fa-fw"></i></a> @if (in_array($potentialparent->id, $parentsarray)) <span class="deleteParentCategory pointer"> @else <span class="deleteCategory pointer"> @endif <i id="{{{ $potentialparent->id }}}" class="fa fa-times fa-fw"></i></span></td></tr>
                    @foreach($children as $child)

                    @if($child->parentid == $potentialparent->id)
                    <tr><td>{{{ $child->id }}}</td><td><i class="fa fa-arrow-right fa-fw"></i> {{{ $child->name }}}</td><td><a class="nolinkstyle" href="{{ URL::route('consolecategories') }}/edit/{{{ $child->id }}}"><i class="fa fa-edit fa-fw"></i></a> <span class="deleteChildCategory pointer"><i id="{{{ $child->id }}}" class="fa fa-times fa-fw"></i></span></td></tr>
                    @endif

                    @endforeach
                    @endforeach
                </table>
            </div>
        </div>
    </div>

    <!--/#deleteParentCategoriesModal -->
    <div class="modal fade" id="deleteParentCategoriesModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times fa-fw"></i></button>
                    <h3 class="modal-title" id="myModalLabel">Warning</h3>
                </div>
                <div class="modal-body">
                    Deleting this parent category will <strong>remove all child categories</strong>. Are you sure you want to continue?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button id="btnDeleteCategoryConfirmed" type="button" data-dismiss="modal" class="btn btn-danger deleteParentCategory">Delete Category</button>
                </div>
            </div>
        </div>
    </div>
    <!-- /#page-wrapper -->
    @include('console.core.footer')