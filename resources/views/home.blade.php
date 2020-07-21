
<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Aung Clinic</title>

  <link rel="stylesheet" href="/css/app.css">
</head>
<body>
<div id="app">

  <!--Navbar-->
<nav class="navbar navbar-expand-lg navbar-dark primary-color">

    <!-- Navbar brand -->
    <a class="navbar-brand" href="#">Aung Clinic</a>

  
    <!-- Collapsible content -->
    <div class="collapse navbar-collapse" id="basicExampleNav">
  
      <!-- Links -->
      <ul class="navbar-nav mr-auto">
        <li class="nav-item active">
          <router-link class="nav-link" to="/">Home
            <span class="sr-only">(current)</span>
          </router-link>
        </li>
        <li class="nav-item">
          <router-link class="nav-link" to="/pharmacy">Pharmacy</router-link>
        </li>
        <li class="nav-item">
          <router-link class="nav-link" to="/pharmacysale">Pharmacy Sale</router-link>
        </li>
  
        <!-- Dropdown -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">Management</a>
          <div class="dropdown-menu dropdown-primary" aria-labelledby="navbarDropdownMenuLink">
            <router-link to="/revenue" class="dropdown-item" href="#">Revenue</router-link>
            <a class="dropdown-item" href="#">Another action</a>
            <a class="dropdown-item" href="#">Something else here</a>
          </div>
        </li>
  
      </ul>
      <!-- Links -->
      <ul class="navbar-nav ml-auto">
      <consult></consult>
      <booking :userid="{{Auth::id()}}"></booking>
      <notification :userid="{{Auth::id()}}"></notification>
      <audio id="noti_sound" src="{{asset('audio/glass_ping.mp3')}}"></audio>
        <li class="nav-item dropdown">
            <a id="navbarDropdown" class="nav-link dropdown-toggle text-white" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                {{ Auth::user()->name }} <span class="caret"></span>
            </a>

            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="{{ route('logout') }}"
                   onclick="event.preventDefault();
                                 document.getElementById('logout-form').submit();">
                    {{ __('Logout') }}
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </li>
    </ul>
    </div>
    <!-- Collapsible content -->
  
  </nav>
  <!--/.Navbar-->

    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
          <router-view></router-view>
          <vue-progress-bar></vue-progress-bar>
      </div><!-- /.container-fluid -->


    <!-- /.content -->
  </div>


  <!-- Main Footer -->
  {{-- <footer class="main-footer"> --}}
    <!-- To the right -->
    {{-- <div class="float-right d-none d-sm-inline">
      Developed By Dr.Kyaw Soe
    </div> --}}
    <!-- Default to the left -->
    {{-- <strong>Developed By Dr.Kyaw Soe <a href="https://adminlte.io">Aung Clinic</a>.
  </footer>
</div> --}}
<!-- ./wrapper -->

@auth
  <script>
    window.user = @JSON(auth()->user());
  </script>  
@endauth
<!-- REQUIRED SCRIPTS -->
<script src="/js/app.js"></script>
</body>
</html>
