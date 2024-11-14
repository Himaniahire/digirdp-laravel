<body>
    <div class="wrapper">
        <!-- Sidebar -->
        <div class="sidebar" data-background-color="dark">
            <div class="sidebar-logo">
                <!-- Logo Header -->
                <div class="logo-header" data-background-color="dark">
                    <a href="index.html" class="logo">
                        <img src="{{ asset('assets/img/kaiadmin/logo_light.svg') }}" alt="navbar brand"
                            class="navbar-brand" height="20" />
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
                                <i class="fas fa-layer-group"></i>
                                <p>About</p>
                                <span class="caret"></span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a data-bs-toggle="" href="{{route('configuration.index')}}">
                                <i class="fas fa-layer-group"></i>
                                <p>Configuration</p>
                                <span class="caret"></span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a data-bs-toggle="" href="{{route('user.index')}}">
                                <i class="fas fa-layer-group"></i>
                                <p>User</p>
                                <span class="caret"></span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a data-bs-toggle="" href="{{route('policies.index')}}">
                                <i class="fas fa-layer-group"></i>
                                <p>Policies</p>
                                <span class="caret"></span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a data-bs-toggle=""  href="{{route('sliders.index')}}">
                                <i class="fas fa-layer-group"></i>
                                <p>Sliders</p>
                                <span class="caret"></span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a data-bs-toggle="" href="{{route('testimonials.index')}}">
                                <i class="fas fa-layer-group"></i>
                                <p>Testimonials</p>
                                <span class="caret"></span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a data-bs-toggle="" href="{{route('faq.index')}}">
                                <i class="fas fa-layer-group"></i>
                                <p>FAQ</p>
                                <span class="caret"></span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a data-bs-toggle="" href="{{route('features.index')}}">
                                <i class="fas fa-layer-group"></i>
                                <p>Features</p>
                                <span class="caret"></span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a data-bs-toggle="" href="{{route('offer.index')}}">
                                <i class="fas fa-layer-group"></i>
                                <p>Offer</p>
                                <span class="caret"></span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a data-bs-toggle="" href="{{route('rdp.index')}}">
                                <i class="fas fa-layer-group"></i>
                                <p>Windows RDP</p>
                                <span class="caret"></span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a data-bs-toggle="" href="{{route('rdpplan.index')}}">
                                <i class="fas fa-layer-group"></i>
                                <p>Windows RDP Plan</p>
                                <span class="caret"></span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a data-bs-toggle="" href="{{route('hosting.index')}}">
                                <i class="fas fa-layer-group"></i>
                                <p>Web Hosting</p>
                                <span class="caret"></span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a data-bs-toggle="" href="{{route('rdplocation.index')}}">
                                <i class="fas fa-layer-group"></i>
                                <p>RDP By Location</p>
                                <span class="caret"></span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a data-bs-toggle="" href="{{route('rdplocationplan.index')}}">
                                <i class="fas fa-layer-group"></i>
                                <p>RDP By Location Plan</p>
                                <span class="caret"></span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a data-bs-toggle="" href="{{route('hostingplan.index')}}">
                                <i class="fas fa-layer-group"></i>
                                <p>Web Hosting Plan</p>
                                <span class="caret"></span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a data-bs-toggle="" href="{{route('vps.index')}}">
                                <i class="fas fa-layer-group"></i>
                                <p>CLOUD VPS</p>
                                <span class="caret"></span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a data-bs-toggle="" href="{{route('vpsplan.index')}}">
                                <i class="fas fa-layer-group"></i>
                                <p>CLOUD VPS Plan</p>
                                <span class="caret"></span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a data-bs-toggle="" href="{{route('dedicated.index')}}">
                                <i class="fas fa-layer-group"></i>
                                <p>Dedicated Server</p>
                                <span class="caret"></span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a data-bs-toggle="" href="{{route('dedicatedplan.index')}}">
                                <i class="fas fa-layer-group"></i>
                                <p> Dedicated Server Plans</p>
                                <span class="caret"></span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a data-bs-toggle="" href="{{route('category.index')}}">
                                <i class="fas fa-layer-group"></i>
                                <p>Categories</p>
                                <span class="caret"></span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a data-bs-toggle="" href="{{route('category.index')}}">
                                <i class="fas fa-layer-group"></i>
                                <p>Blogs</p>
                                <span class="caret"></span>
                            </a>
                        </li>







                    </ul>
                </div>
            </div>
        </div>
