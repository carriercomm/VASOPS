@include('console.core.header')
@include('console.core.navbartop')
@include('console.core.navbarside')
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header"><i class="fa fa-plane fa-fw"></i>{{{ $va->vaname }}}</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-2">
            <h4><small>cid</small></h4>
            <h4><small>name</small></h4>
            <h4><small>email</small></h4>
            <h4><small>url</small></h4>
            <h4><small>city</small></h4>
            <h4><small>state</small></h4>
            <h4><small>postal code</small></h4>
            <h4><small>description</small></h4>
            <h4><small>updated</small></h4>
            <h4><small>created</small></h4>
        </div>
        <div class="col-lg-3">
            <h4>{{{ $va->cid }}}</h4>
            <h4>{{{ $va->name }}}</h4>
            <h4>{{{ $va->email }}}</h4>
            <h4>{{{ $va->url }}}</h4>
            <h4>{{{ $va->city }}}</h4>
            <h4>{{{ $va->stateprovince }}}</h4>
            <h4>{{{ $va->zip }}}</h4>
            <h4>{{{ $va->description }}}</h4>
            <h4>{{{ $va->updated_at }}}</h4>
            <h4>{{{ $va->created_at }}}</h4>
       </div>
    </div>
</div>
<!-- /#page-wrapper -->
@include('console.core.footer')