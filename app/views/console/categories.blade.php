@include('console.core.header')
@include('console.core.navbartop')
@include('console.core.navbarside')
<div id="page-wrapper">
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
                    <form role="form" action="{{ URL::route('consolecategoriesnew') }}" method="POST">
                        <div class="form-group">
                            <input type="text" class="form-control" name="inputCategoryName" id="inputCategorySubject" placeholder="Category Name" />
                        </div>
                        <div class="form-group">
                            <select id="inputCategoryParent" name="inputCategoryParent">
                                <option style="font-style: italic;" value="">(Optional) Select a Parent Category</option>
                            </select>
                        </div>
                        <div class="form-actions">
                            <input id="createCategoryBtn" type="submit" class="btn btn-success" value="Add Category" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /#page-wrapper -->
    @include('console.core.footer')