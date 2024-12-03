<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    {{-- <meta http-equiv="X-UA-Compatible" content="IE=edge"> --}}
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('plugins/images/favicon.png') }}">
    <title>SI CUTI @yield('title')</title>
    <!-- Bootstrap Core CSS -->
    <link href="{{ asset('bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('plugins/bower_components/datatables/jquery.dataTables.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="https://cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('plugins/bower_components/bootstrap-extension/css/bootstrap-extension.css') }}"
        rel="stylesheet">
    <!-- Menu CSS -->
    <link href="{{ asset('plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.css') }}" rel="stylesheet">
    <!-- morris CSS -->
    <link href="{{ asset('plugins/bower_components/morrisjs/morris.css') }}" rel="stylesheet">
    <!-- animation CSS -->
    <link href="{{ asset('css/animate.css') }}" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <!-- color CSS -->
    <link href="{{ asset('css/colors/default.css') }}" id="theme" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
    <script>
        (function(i, s, o, g, r, a, m) {
            i['GoogleAnalyticsObject'] = r;
            i[r] = i[r] || function() {
                (i[r].q = i[r].q || []).push(arguments)
            }, i[r].l = 1 * new Date();
            a = s.createElement(o), m = s.getElementsByTagName(o)[0];
            a.async = 1;
            a.src = g;
            m.parentNode.insertBefore(a, m)
        })(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');
        ga('create', 'UA-19175540-9', 'auto');
        ga('send', 'pageview');
    </script>

    <style>
        /* Menu utama */
        li.has-submenu>a {
            cursor: pointer;
        }

        /* Menyembunyikan submenu secara default */
        ul.submenu {
            display: none;
            list-style-type: none;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
            border-left: 2px solid #ddd;
            margin-top: 5px;
        }

        /* Menampilkan submenu saat menu utama di-hover */
        li.has-submenu:hover>ul.submenu {
            display: block;
        }

        /* Gaya untuk submenu item */
        ul.submenu li a {
            display: block;
            padding: 10px 20px;
            color: #333;
            text-decoration: none;
            font-size: 14px;
            transition: background-color 0.3s;
        }

        /* Menambahkan efek hover pada submenu item */
        ul.submenu li a:hover {
            background-color: #f0f0f0;
            color: #007bff;
        }
    </style>
</head>

<body>
    <!-- Preloader -->
    <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2"
                stroke-miterlimit="10" />
        </svg>
    </div>
    <div id="wrapper">
        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top m-b-0">
            <div class="navbar-header"> <a class="navbar-toggle hidden-sm hidden-md hidden-lg "
                    href="javascript:void(0)" data-toggle="collapse" data-target=".navbar-collapse"><i
                        class="ti-menu"></i></a>
                <div class="top-left-part"><a class="logo" href="{{ route('dashboard') }}"><b><img
                                src="{{ asset('plugins/images/logo-rs.png') }}" alt="home" width="50"
                                height="50" /></b><span class="hidden-xs"><img
                                src="{{ asset('plugins/images/eliteadmin-text.png') }}" alt="home" /></span></a>
                </div>
                <ul class="nav navbar-top-links navbar-left hidden-xs">
                    <li><a href="javascript:void(0)" class="open-close hidden-xs waves-effect waves-light"><i
                                class="icon-arrow-left-circle ti-menu"></i></a></li>
                    <!-- <li>
                        <form role="search" class="app-search hidden-xs">
                            <input type="text" placeholder="Search..." class="form-control"> <a href=""><i class="fa fa-search"></i></a>
                        </form>
                    </li> -->
                </ul>
                <ul class="nav navbar-top-links navbar-right pull-right">


                    <li class="dropdown">
                        <a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#"> <img
                                src="{{ asset('plugins/images/users/user.png') }}" alt="user-img" width="36"
                                height="36" class="img-circle"> {{ Auth::user()->name }} </a>
                        <ul class="dropdown-menu dropdown-user scale-up">
                            <li>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                    style="display: none;">
                                    @csrf
                                </form>
                                <a href="#"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fa fa-power-off"></i> Logout
                                </a>
                            </li>
                        </ul>
                        <!-- /.dropdown-user -->
                    </li>

                </ul>
            </div>
            <!-- /.navbar-header -->
            <!-- /.navbar-top-links -->
            <!-- /.navbar-static-side -->
        </nav>
        <!-- Left navbar-header -->
        <div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav navbar-collapse slimscrollsidebar">
                <ul class="nav" id="side-menu">
                    {{-- <li class="sidebar-search hidden-sm hidden-md hidden-lg">
                        <!-- input-group -->
                        <div class="input-group custom-search-form">
                            <input type="text" class="form-control" placeholder="Search..."> <span
                                class="input-group-btn">
                                <button class="btn btn-default" type="button"> <i class="fa fa-search"></i>
                                </button>
                            </span>
                        </div>
                        <!-- /input-group -->
                    </li> --}}

                    <li class="nav-small-cap m-t-10">--- Main Menu</li>
                    @if (Auth::user()->role == 'staff admin')
                        <li>
                            <a href="{{ route('dashboard') }}" class="waves-effect ">
                                <i class="zmdi zmdi-view-dashboard zmdi-hc-fw fa-fw"></i>
                                <span class="hide-menu"> Home </span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('pegawai.index') }}" class="waves-effect ">
                                <i class="zmdi zmdi-account-box zmdi-hc-fw fa-fw"></i>
                                <span class="hide-menu"> Manage Pegawai </span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('pengajuan-cuti.index') }}" class="waves-effect ">
                                <i class="zmdi zmdi-collection-text zmdi-hc-fw fa-fw"></i>
                                <span class="hide-menu"> Pengajuan Cuti </span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('rekap-cuti') }}" class="waves-effect ">
                                <i class="zmdi zmdi-border-all zmdi-hc-fw fa-fw"></i>
                                <span class="hide-menu"> Rekap Data Cuti </span>
                            </a>
                        </li>
                        <li class="ms-hover">
                            <a href="#" class="waves-effect">
                                <i class="zmdi zmdi-settings zmdi-hc-fw fa-fw"></i>
                                <span class="hide-menu"> Master </span>
                            </a>
                            <ul class="submenu">
                                <li><a href="{{ route('jabatan.index') }}">Manage Bagian</a></li>
                                <li><a href="{{ route('konfig_cuti.index') }}">Manage Konfig Cuti</a></li>
                                <li><a href="{{ route('jenis_cuti.index') }}">Manage Jenis Cuti</a></li>
                            </ul>
                        </li>
                    @elseif (Auth::user()->role == 'direktur')
                        <li>
                            <a href="{{ route('dashboard') }}" class="waves-effect ">
                                <i class="zmdi zmdi-view-dashboard zmdi-hc-fw fa-fw"></i>
                                <span class="hide-menu"> Home </span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('direktur.pengajuan-cuti') }}" class="waves-effect ">
                                <i class="zmdi zmdi-collection-text zmdi-hc-fw fa-fw"></i>
                                <span class="hide-menu"> Pengajuan Cuti </span>
                            </a>
                        </li>
                    @elseif (Auth::user()->role == 'pegawai')
                        <li>
                            <a href="{{ route('dashboard') }}" class="waves-effect ">
                                <i class="zmdi zmdi-view-dashboard zmdi-hc-fw fa-fw"></i>
                                <span class="hide-menu"> Home </span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('pegawai.pengajuan-cuti') }}" class="waves-effect ">
                                <i class="zmdi zmdi-file-text zmdi-hc-fw fa-fw"></i>
                                <span class="hide-menu"> Pengajuan Cuti </span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('pegawai.riwayat-cuti') }}" class="waves-effect ">
                                <i class="zmdi zmdi-folder zmdi-hc-fw fa-fw"></i>
                                <span class="hide-menu"> Riwayat Cuti </span>
                            </a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
        <!-- Left navbar-header end -->
        <!-- Page Content -->
        <div id="page-wrapper">
            @yield('konten')
            <footer class="footer text-center"> {{ date('Y') }} &copy; SI CUTI template by themedesigner.in
                created by Radhinal Akbar </footer>
        </div>
        <!-- /#page-wrapper -->
    </div>
    <!-- /#wrapper -->
    <!-- jQuery -->
    <script src="{{ asset('plugins/bower_components/jquery/dist/jquery.min.js') }}"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="{{ asset('bootstrap/dist/js/tether.min.js') }}"></script>
    <script src="{{ asset('bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('plugins/bower_components/bootstrap-extension/js/bootstrap-extension.min.js') }}"></script>
    <!-- Menu Plugin JavaScript -->
    <script src="{{ asset('plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.js') }}"></script>
    <!--slimscroll JavaScript -->
    <script src="{{ asset('js/jquery.slimscroll.js') }}"></script>
    <!--Wave Effects -->
    <script src="{{ asset('js/waves.js') }}"></script>
    <!--weather icon -->
    <script src="{{ asset('plugins/bower_components/skycons/skycons.js') }}"></script>
    <!--Counter js -->
    <script src="{{ asset('plugins/bower_components/waypoints/lib/jquery.waypoints.js') }}"></script>
    <script src="{{ asset('plugins/bower_components/counterup/jquery.counterup.min.js') }}"></script>
    <!--Morris JavaScript -->
    <script src="{{ asset('plugins/bower_components/raphael/raphael-min.js') }}"></script>
    <script src="{{ asset('plugins/bower_components/morrisjs/morris.js') }}"></script>
    <!-- Custom Theme JavaScript -->
    <script src="{{ asset('js/custom.min.js') }}"></script>
    <script src="{{ asset('js/dashboard4.js') }}"></script>
    <!-- Sparkline chart JavaScript -->
    <script src="{{ asset('plugins/bower_components/jquery-sparkline/jquery.sparkline.min.js') }}"></script>
    <script src="{{ asset('plugins/bower_components/jquery-sparkline/jquery.charts-sparkline.js') }}"></script>
    <script src="{{ asset('plugins/bower_components/datatables/jquery.dataTables.min.js') }}"></script>
    <!-- start - This is for export functionality only -->
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
    <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
    <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js"></script>
    <!-- end - This is for export functionality only -->
    <script>
        $(document).ready(function() {
            $('#myTable').DataTable();
            $(document).ready(function() {
                var table = $('#example').DataTable({
                    "columnDefs": [{
                        "visible": false,
                        "targets": 2
                    }],
                    "order": [
                        [2, 'asc']
                    ],
                    "displayLength": 25,
                    "drawCallback": function(settings) {
                        var api = this.api();
                        var rows = api.rows({
                            page: 'current'
                        }).nodes();
                        var last = null;

                        api.column(2, {
                            page: 'current'
                        }).data().each(function(group, i) {
                            if (last !== group) {
                                $(rows).eq(i).before(
                                    '<tr class="group"><td colspan="5">' + group +
                                    '</td></tr>'
                                );

                                last = group;
                            }
                        });
                    }
                });

                // Order by the grouping
                $('#example tbody').on('click', 'tr.group', function() {
                    var currentOrder = table.order()[0];
                    if (currentOrder[0] === 2 && currentOrder[1] === 'asc') {
                        table.order([2, 'desc']).draw();
                    } else {
                        table.order([2, 'asc']).draw();
                    }
                });
            });
        });
        $('#example23').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        });
    </script>
    <!--Style Switcher -->
    <script src="{{ asset('plugins/bower_components/styleswitcher/jQuery.style.switcher.js') }}"></script>
</body>

</html>
