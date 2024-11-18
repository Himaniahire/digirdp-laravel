<body>

    @php
    $sidebarItem = Config::get('app.sidebar',[]);
    $sidemenu = [];
  @endphp

  @php
      $permission_array = [];
      $permission = Auth::user()->permission;
      $permission_array = ($permission && $permission != 'null' )? json_decode($permission) : [];

      foreach($sidebarItem as $permi):
          if(in_array($permi['route'],$permission_array)){
            $sidemenu[] = $permi;
          }
      endforeach;

  @endphp
    <div class="wrapper">
        <!-- Sidebar -->
        <div class="sidebar" data-background-color="dark">
            <div class="sidebar-logo">
                <!-- Logo Header -->
                <div class="logo-header" data-background-color="dark">
                    <a href="{{ url('index') }}" class="logo">
                        <img src="{{ asset('assets/img/bg.png') }}" alt="navbar brand"
                            class="navbar-brand" height="40" />
                    </a>
                    <div class="nav-toggle">
                        <button class="btn btn-toggle toggle-sidebar">
                            <i class="gg-menu-right"></i>
                        </button>
                        <button class="btn btn-toggle sidenav-toggler">
                            <i class="gg-menu-left"></i>
                        </button>
                    </div>
                    <button class="topbar-toggler more">
                        <i class="gg-more-vertical-alt"></i>
                    </button>
                </div>
                <!-- End Logo Header -->
            </div>
            <div class="sidebar-wrapper scrollbar scrollbar-inner">
                <div class="sidebar-content">
                    <ul class="nav nav-secondary">
                        <li class="nav-item">
                            <a>
                                <i class="fas fa-home"></i>
                                <p>Dashboard</p>

                            </a>
                        </li>
                        <li class="nav-section">
                            <span class="sidebar-mini-icon">
                                <i class="fa fa-ellipsis-h"></i>
                            </span>
                            <h4 class="text-section">Components</h4>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('about.index')}}">
                                <i class="fas fa-info-circle"></i>
                                <p>About</p>

                            </a>
                        </li>
                        <li class="nav-item">
                            <a data-bs-toggle="" href="{{route('configuration.index')}}">
                                <i class="fas fa-cog"></i>
                                <p>Configuration</p>

                            </a>
                        </li>
                        <li class="nav-item">
                            <a data-bs-toggle="" href="{{route('user.index')}}">
                                <i class="fas fa-user"></i>
                                <p>User</p>

                            </a>
                        </li>
                        <li class="nav-item">
                            <a data-bs-toggle="" href="{{route('policies.index')}}">
                                <i class="fas fa-shield-alt"></i>
                                <p>Policies</p>

                            </a>
                        </li>
                        <li class="nav-item">
                            <a data-bs-toggle=""  href="{{route('sliders.index')}}">
                                <i class="fas fa-sliders-h"></i>
                                <p>Sliders</p>

                            </a>
                        </li>
                        <li class="nav-item">
                            <a data-bs-toggle="" href="{{route('testimonials.index')}}">
                                <i class="fas fa-comments"></i>
                                <p>Testimonials</p>

                            </a>
                        </li>
                        <li class="nav-item">
                            <a data-bs-toggle="" href="{{route('faq.index')}}">
                                <i class="fas fa-question-circle"></i>
                                <p>FAQ</p>

                            </a>
                        </li>
                        <li class="nav-item">
                            <a data-bs-toggle="" href="{{route('features.index')}}">
                                <i class="fas fa-star"></i>
                                <p>Features</p>

                            </a>
                        </li>
                        <li class="nav-item">
                            <a data-bs-toggle="" href="{{route('offer.index')}}">
                                <i class=" fas fa-tag"></i>
                                <p>Offer</p>

                            </a>
                        </li>
                        <li class="nav-item">
                            <a data-bs-toggle="" href="{{route('rdp.index')}}">
                                <i class="fas fa-laptop"></i>
                                <p>Windows RDP</p>

                            </a>
                        </li>
                        <li class="nav-item">
                            <a data-bs-toggle="" href="{{route('rdpplan.index')}}">
                                <i class="fas fa-laptop"></i>
                                <p>Windows RDP Plan</p>

                            </a>
                        </li>
                        <li class="nav-item">
                            <a data-bs-toggle="" href="{{route('hosting.index')}}">
                                <i class="fas fa-globe"></i>
                                <p>Web Hosting</p>

                            </a>
                        </li>
                        <li class="nav-item">
                            <a data-bs-toggle="" href="{{route('rdplocation.index')}}">
                                <i class="fas fa-flag"></i>
                                <p>RDP By Location</p>

                            </a>
                        </li>
                        <li class="nav-item">
                            <a data-bs-toggle="" href="{{route('rdplocationplan.index')}}">
                                <i class="fas fa-flag"></i>
                                <p>RDP By Location Plan</p>

                            </a>
                        </li>
                        <li class="nav-item">
                            <a data-bs-toggle="" href="{{route('hostingplan.index')}}">
                                <i class="fas fa-globe"></i>
                                <p>Web Hosting Plan</p>

                            </a>
                        </li>
                        <li class="nav-item">
                            <a data-bs-toggle="" href="{{route('vps.index')}}">
                                <i class="fas fa-cloud"></i>
                                <p>CLOUD VPS</p>

                            </a>
                        </li>
                        <li class="nav-item">
                            <a data-bs-toggle="" href="{{route('vpsplan.index')}}">
                                <i class="fas fa-cloud"></i>
                                <p>CLOUD VPS Plan</p>

                            </a>
                        </li>
                        <li class="nav-item">
                            <a data-bs-toggle="" href="{{route('dedicated.index')}}">
                                <i class="fas fa-server"></i>
                                <p>Dedicated Server</p>

                            </a>
                        </li>
                        <li class="nav-item">
                            <a data-bs-toggle="" href="{{route('dedicatedplan.index')}}">
                                <i class="fas fa-server"></i>
                                <p> Dedicated Server Plans</p>

                            </a>
                        </li>
                        <li class="nav-item">
                            <a data-bs-toggle="" href="{{route('category.index')}}">
                                <i class="fas fa-list"></i>
                                <p>Categories</p>

                            </a>
                        </li>
                        <li class="nav-item">
                            <a data-bs-toggle="" href="{{route('blogs.index')}}">
                                <i class="fab fa-blogger-b"></i>
                                <p>Blogs</p>

                            </a>
                        </li>
                        <li class="nav-item">
                            <a data-bs-toggle="" href="{{route('location.index')}}">
                                <i class="fas fa-map-marker-alt"></i>
                                <p>Location</p>

                            </a>
                        </li>







                    </ul>
                </div>
            </div>
        </div>
