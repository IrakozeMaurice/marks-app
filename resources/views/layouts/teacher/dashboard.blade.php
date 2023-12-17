<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>AUCA | Home</title>

  <!-- Custom fonts for this template-->
  <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
  <link
    href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
    rel="stylesheet">

  <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">
  <link href="{{ asset('css/fontawesome-all.css') }}" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
  <link href="{{ asset('css/bulma.min.css') }}" rel="stylesheet">
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">

  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Nunito&display=swap" rel="stylesheet" />

  {{-- datatables --}}

  <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('css/jquery.datatables.min.css') }}">
  <script src="{{ asset('js/jquery-3.5.1.min.js') }}"></script>
  <script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>

  {{-- datatables --}}

  <style>
    body {
      font-family: "Nunito", monospace;
    }

    tr:has(td.rollno) {
      background-color: #17a2b8;
    }

    select {
      width: 80px !important;
    }
  </style>

</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar"
      style="background: #61c2d3;">

      <!-- Sidebar - Brand -->

      <!-- Divider -->

      <!-- Nav Item - Dashboard -->
      <li class="nav-item">
        <div class="py-3 px-2">
          <img src="{{ asset('images/aucaLogo.png') }}" alt="Auca logo">
        </div>
      </li>

      <!-- Divider -->
      <hr class="mt-2">

      <!-- Heading -->

      <!-- Nav Item -->
      <li class="nav-item font-bold">
        <a class="nav-link" href="{{ route('teacher.marks.index') }}">
          <i class="fas fa-fw fa-plus"></i>
          <span>Marks</span></a>
      </li>

      <!-- Nav Item -->
      <li class="nav-item font-bold">
        <a class="nav-link" href="{{ route('teacher.claims.index') }}">
          <i class="fas fa-fw fa-users"></i>
          <span>Claims</span></a>
      </li>

    </ul>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

          <!-- Topbar Search -->

          <!-- Topbar Navbar -->

          <!-- Nav Item - User Information -->
          <li class="nav-item dropdown no-arrow" style="position: absolute;right:50px;">
            <a class="nav-link dropdown-toggle" href="#"
              data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ auth()->user()->name }}</span>
              <img class="img-profile rounded-circle"
                src="{{ asset('images/undraw_profile.svg') }}">
            </a>
            <!-- Dropdown - User Information -->
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
              aria-labelledby="userDropdown">
              {{-- <a class="dropdown-item" href="#">
                                <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                Profile
                            </a>
                            <div class="dropdown-divider"></div> --}}
              <form method="POST" action="{{ route('teacher.logout') }}">
                @csrf
                <a class="dropdown-item" href="{{ route('teacher.logout') }}"
                  onclick="event.preventDefault();
          this.closest('form').submit();">
                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                  Logout
                </a>
              </form>
            </div>
          </li>

          </ul>

        </nav>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">TEACHER Dashboard</h1>
          </div>

          <!-- Content Row -->

          <div>
            @yield('content')
          </div>

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

      <!-- Footer -->
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright &copy; Auca 2023</span>
          </div>
        </div>
      </footer>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
  <script src="{{ asset('js/jquery-3.5.1.min.js') }}"></script>
  <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>
  <script src="{{ asset('js/sb-admin-2.min.js') }}"></script>

  @yield('scripts')

  @yield('dataTableFooter')

</body>

</html>
