<!doctype html>
<html lang="en">

@include('app.head')

<body>
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">
    
    @include('app.sidebar')

    <div class="body-wrapper">
     
    @include('app.header')
    
      <div class="container-fluid">

        @yield('content')

      </div>

    </div>
  </div>

  @include('app.script')

</body>

</html>