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
    <div style="margin-bottom: 25px;" class="row">
        <div class="col-lg-2">
            <a href="{{ URL::route('consolecategories') }}"><button class="btn btn-primary"><i class="fa fa-arrow-left fa-fw"></i> Return</button></a>
        </div>
    </div>
    <!-- /.row -->
    <div class="row">
       <div class="col-lg-12">
           <form class="form" action="{{ URL::route('consolecategories') }}/edit/{{{ $category->id }}}" method="POST">
               <input type="hidden" name="_token" value="{{ csrf_token() }}" />
               <div class="form-group">
                       <input class="form-control" name="categoryName" type="text" placeholder="Category Name" value="{{{ $category->name }}}" />
               </div>
               <div class="form-group">
                   <label>Parent Category <span style="font-weight: normal; font-style: italic">(Optional)</span</label>
                    <select class="form-control" name="categoryParent">
                        <option value="0">**No Parent**</option>
                        @foreach ($potentialParents as $potentialParent)
                        <option value="{{{ $potentialParent->id }}}" @if ($potentialParent->id == $category->parentid) selected="selected" @endif>{{{ $potentialParent->name }}}</option>
                        @endforeach
                    </select>
               </div>
               <div class="form-actions">
                   <input type="submit" class="btn btn-success" value="Edit Category" /> <input style="color: white;" type="reset" class="btn" value="Cancel" />
               </div>
           </form>
       </div>
    </div>
<!-- /#page-wrapper -->
@include('console.core.footer')