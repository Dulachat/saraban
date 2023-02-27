<nav class="navbar navbar-vertical fixed-left navbar-expand-md navbar-light bg-white" id="sidenav-main">
    <div class="container-fluid">
        <!-- Toggler -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#sidenav-collapse-main"
            aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <!-- Brand -->
        <a class="navbar-brand pt-0" href="{{ route('home') }}">
            <img src="{{ asset('argon') }}/img/brand/sci.png" class="navbar-brand-img" alt="...">
        </a>
        <!-- User -->
        <ul class="nav align-items-center d-md-none">
            <li class="nav-item dropdown">
                <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false">
                    <div class="media align-items-center">
                        <span class="avatar avatar-sm rounded-circle">
                            <img alt="Image placeholder" src="{{ asset('argon') }}/img/theme/team-1-800x800.jpg">
                        </span>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right">
                    <div class=" dropdown-header noti-title">
                        <h6 class="text-overflow m-0">{{ __('Welcome!') }}</h6>
                    </div>
                    <a href="{{ route('profile.edit') }}" class="dropdown-item">
                        <i class="ni ni-single-02"></i>
                        <span>{{ __('My profile') }}</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="{{ route('logout') }}" class="dropdown-item"
                        onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                        <i class="ni ni-user-run"></i>
                        <span>{{ __('Logout') }}</span>
                    </a>
                </div>
            </li>
        </ul>
        <!-- Collapse -->
        <div class="collapse navbar-collapse" id="sidenav-collapse-main">
            <!-- Collapse header -->
            <div class="navbar-collapse-header d-md-none">
                <div class="row">
                    <div class="col-6 collapse-brand">
                        <a href="{{ route('home') }}">
                            <img src="{{ asset('argon') }}/img/brand/sci.png">
                        </a>
                    </div>
                    <div class="col-6 collapse-close">
                        <button type="button" class="navbar-toggler" data-toggle="collapse"
                            data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false"
                            aria-label="Toggle sidenav">
                            <span></span>
                            <span></span>
                        </button>
                    </div>
                </div>
            </div>
            <!-- Form -->
            <form class="mt-4 mb-3 d-md-none">
                <div class="input-group input-group-rounded input-group-merge">
                    <input type="search" class="form-control form-control-rounded form-control-prepended"
                        placeholder="{{ __('Search') }}" aria-label="Search">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <span class="fa fa-search"></span>
                        </div>
                    </div>
                </div>
            </form>
            <!-- Navigation -->
           
                <ul class="navbar-nav">
                    @if (auth()->user()->u_level_id == 1  ) 
                    {{-- //แอดมิน --}}
                     
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('home') }}">
                                <i class="ni ni-tv-2 text-primary"></i> {{ __('หน้าแรก') }}
                            </a>
                        </li>                  
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin') }}">
                                <i class="ni ni-tv-2 text-primary"></i> {{ __('จัดการข้อมูลทั่วไป') }}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('generalDocs.ajax') }}">
                                <i class="ni ni-tv-2 text-primary"></i> {{ __('จัดการข้อมูลเอกสาร') }}
                            </a>
                        </li>
                        
                    @endif

                    @if (auth()->user()->u_level_id == 2) 
                    {{-- //อาจารย์ --}}
                        
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('homeUser') }}">
                            <i class="ni ni-tv-2 text-primary"></i> {{ __('หน้าแรก') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('UserDocsAll') }}">
                            <i class="ni ni-tv-2 text-primary"></i> {{ __('เอกสารทั้งหมด') }}
                        </a>
                    </li>
                        
                    @endif

                    @if (auth()->user()->u_level_id == 3) 
                    {{-- //จนท. คณะ --}}
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home2') }}">
                            <i class="ni ni-tv-2 text-primary"></i> {{ __('หน้าแรก') }}
                        </a>
                    </li>
                   
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('generalDocs2.ajax') }}">
                            <i class="ni ni-tv-2 text-primary"></i> {{ __('จัดการข้อมูลเอกสาร') }}
                        </a>
                    </li> 
                              
                    @endif
                    @if (auth()->user()->u_level_id == 4) 
                    {{-- //จนท.ภาควิชา --}}
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('homestaff.ajax') }}">
                            <i class="ni ni-tv-2 text-primary"></i> {{ __('หน้าแรก') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('StaffDocsAll.ajax') }}">
                            <i class="ni ni-tv-2 text-primary"></i> {{ __('เอกสารทั้งหมด') }}
                        </a>
                    </li>
                  
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('generalDocs2.ajax') }}">
                            <i class="ni ni-tv-2 text-primary"></i> {{ __('จัดการข้อมูลเอกสาร') }}
                        </a>
                    </li> 
                        
                    @endif
                    @if (auth()->user()->u_level_id == 5) 
                    {{-- //ผู้บริหาร --}}
                                   
                    @endif
                    @if (auth()->user()->u_level_id == 6) 
                    {{-- // คณะบดี --}}
                        
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('homeDean.ajax') }}">
                            <i class="ni ni-tv-2 text-primary"></i> {{ __('หน้าแรก') }}
                        </a>
                    </li>
                        
                    @endif

                </ul>
          

            <!-- Divider -->

        </div>
    </div>
</nav>
