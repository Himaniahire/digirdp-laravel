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
                        <li class="nav-item active">
                            <a data-bs-toggle="collapse" href="#dashboard" class="collapsed" aria-expanded="false">
                                <i class="fas fa-home"></i>
                                <p>Dashboard</p>
                                <span class="caret"></span>
                            </a>
                            <div class="collapse" id="dashboard">
                                <ul class="nav nav-collapse">
                                    <li>
                                        <a href="{{ url('index')}}">
                                            <span class="sub-item">Dashboard 1</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
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
                                <span class="caret"></span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a data-bs-toggle="" href="{{route('configuration.index')}}">
                                <i class="fas fa-cog"></i>
                                <p>Configuration</p>
                                <span class="caret"></span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a data-bs-toggle="" href="{{route('user.index')}}">
                                <i class="fas fa-user"></i>
                                <p>User</p>
                                <span class="caret"></span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a data-bs-toggle="" href="{{route('policies.index')}}">
                                <i class="fas fa-shield-alt"></i>
                                <p>Policies</p>
                                <span class="caret"></span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a data-bs-toggle=""  href="{{route('sliders.index')}}">
                                <i class="fas fa-sliders-h"></i>
                                <p>Sliders</p>
                                <span class="caret"></span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a data-bs-toggle="" href="{{route('testimonials.index')}}">
                                <i class="fas fa-comments"></i>
                                <p>Testimonials</p>
                                <span class="caret"></span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a data-bs-toggle="" href="{{route('faq.index')}}">
                                <i class="fas fa-question-circle"></i>
                                <p>FAQ</p>
                                <span class="caret"></span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a data-bs-toggle="" href="{{route('features.index')}}">
                                <i class="fas fa-star"></i>
                                <p>Features</p>
                                <span class="caret"></span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a data-bs-toggle="" href="{{route('offer.index')}}">
                                <i class=" fas fa-tag"></i>
                                <p>Offer</p>
                                <span class="caret"></span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a data-bs-toggle="" href="{{route('rdp.index')}}">
                                <i class="fas fa-laptop"></i>
                                <p>Windows RDP</p>
                                <span class="caret"></span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a data-bs-toggle="" href="{{route('rdpplan.index')}}">
                                <i class="fas fa-laptop"></i>
                                <p>Windows RDP Plan</p>
                                <span class="caret"></span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a data-bs-toggle="" href="{{route('hosting.index')}}">
                                <i class="fas fa-globe"></i>
                                <p>Web Hosting</p>
                                <span class="caret"></span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a data-bs-toggle="" href="{{route('rdplocation.index')}}">
                                <i class="fas fa-flag"></i>
                                <p>RDP By Location</p>
                                <span class="caret"></span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a data-bs-toggle="" href="{{route('rdplocationplan.index')}}">
                                <i class="fas fa-flag"></i>
                                <p>RDP By Location Plan</p>
                                <span class="caret"></span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a data-bs-toggle="" href="{{route('hostingplan.index')}}">
                                <i class="fas fa-globe"></i>
                                <p>Web Hosting Plan</p>
                                <span class="caret"></span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a data-bs-toggle="" href="{{route('vps.index')}}">
                                <i class="fas fa-cloud"></i>
                                <p>CLOUD VPS</p>
                                <span class="caret"></span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a data-bs-toggle="" href="{{route('vpsplan.index')}}">
                                <i class="fas fa-cloud"></i>
                                <p>CLOUD VPS Plan</p>
                                <span class="caret"></span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a data-bs-toggle="" href="{{route('dedicated.index')}}">
                                <i class="fas fa-server"></i>
                                <p>Dedicated Server</p>
                                <span class="caret"></span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a data-bs-toggle="" href="{{route('dedicatedplan.index')}}">
                                <i class="fas fa-server"></i>
                                <p> Dedicated Server Plans</p>
                                <span class="caret"></span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a data-bs-toggle="" href="{{route('category.index')}}">
                                <i class="fas fa-list"></i>
                                <p>Categories</p>
                                <span class="caret"></span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a data-bs-toggle="" href="{{route('blogs.index')}}">
                                <i class="fab fa-blogger-b"></i>
                                <p>Blogs</p>
                                <span class="caret"></span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a data-bs-toggle="" href="{{route('location.index')}}">
                                <i class="fas fa-map-marker-alt"></i>
                                <p>Location</p>
                                <span class="caret"></span>
                            </a>
                        </li>







                    </ul>
                </div>
            </div>
        </div>
