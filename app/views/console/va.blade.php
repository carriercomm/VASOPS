@include('console.core.header')
@include('console.core.navbartop')
@include('console.core.navbarside')
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header"><i class="fa fa-plane fa-fw"></i> VA Account: {{{ $va->vaname }}}</h1>
        </div>
    </div>
</div>
<!-- /#page-wrapper -->
@include('console.core.footer')