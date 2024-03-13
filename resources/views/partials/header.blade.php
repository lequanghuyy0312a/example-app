<nav class="main-header navbar navbar-expand navbar-white navbar-light position-sticky" style="top:0px;">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#"><i class="fa fa-bars text-dark"></i></a>
        </li>
        <li class="nav-item ml-2">
          <!-- <a href="/" class="nav-link text-primary border-left">
            <i class="fa fa-home text-primary" aria-hidden="true"></i>
            <u class="ml-1  d-none d-md-inline-block">Home</u>
          </a> -->
        </li>
        <!-- nhân viên -->

        <li class="nav-item dropdown d-none d-sm-inline-block">
          <a class="nav-link border-left dropdown-toggle dropdown-toggle" data-toggle="dropdown" href="#">
            <i class="fas fa-users text-muted"></i>
            <u class="ml-1 text-muted   d-none d-xl-inline-block">{{__('msg.employees')}}</u>
          </a>
          <div class="dropdown-menu dropdown-menu-lg dropdown-menu-left">
            <div class="dropdown-divider"></div>
            <a href="/employee-dashboard" class="dropdown-item">
              <i class="fa fa-users-cog mr-2 text-warning"></i>{{__('msg.overview')}}
            </a>
            <div class="dropdown-divider"></div>
            <a href="/employees" class="dropdown-item">
              <i class="fas fa-list-ol mr-2 text-primary"></i> {{__('msg.list')}}
            </a>
            @if (session('loginRoleAccount')== 2)
            <div class="dropdown-divider"></div>
            <a href="employee-add" wire:navigate class="dropdown-item">
              <i class="fa fa-user-plus mr-2 text-success"></i>{{__('msg.employeeAdd')}}
            </a>
            @endif
            <div class="dropdown-divider"></div>
            <a href="/information-list" class="dropdown-item ">
              <i class="fa-solid fa-file-pdf mr-2 text-info"></i> {{__('msg.typeInformation')}}
            </a>
          </div>
        </li>
        <!-- nhân viên -->
        <!-- tổ chức -->
        <li class="nav-item dropdown d-none d-sm-inline-block">
          <a class="nav-link border-left dropdown-toggle" data-toggle="dropdown" href="#">
            <i class="fa-sharp fa-solid fa-network-wired text-muted"></i>
            <u class="ml-1 text-muted  d-none d-xl-inline-block">{{__('msg.organization')}}</u>
          </a>
          <div class="dropdown-menu dropdown-menu-lg dropdown-menu-left">
            <div class="dropdown-divider"></div>
            <a href="/structure-dashboard" class="dropdown-item">
              <i class="fa-solid fa-sitemap mr-2 text-warning"></i>{{__('msg.overview')}}
            </a>

            <div class="dropdown-divider"></div>
            <a href="/directors" class="dropdown-item">
              <i class="fa-solid fa-user-gear mr-2 text-danger"></i>{{__('msg.directorate')}}
            </a>

            <div class="dropdown-divider"></div>
            <a href="/departments" class="dropdown-item">
              <i class="fas fa-people-arrows  mr-2 text-primary"></i>{{__('msg.department')}}
            </a>

            <div class="dropdown-divider"></div>
            <a href="sections" class="dropdown-item">
              <i class="fa-solid fa-users-viewfinder mr-2 text-info"></i>{{__('msg.section')}}
            </a>

            <div class="dropdown-divider"></div>
            <a href="teams" class="dropdown-item">
              <i class="fa-solid fa-users-rectangle mr-2 text-orange"></i>{{__('msg.team')}}
            </a>

            <div class="dropdown-divider"></div>
            <a href="/jobemployees" class="dropdown-item">
              <i class="fa-solid fa-user-tag mr-2 text-success"></i>{{__('msg.jobPosition')}}
            </a>
          </div>
        </li>
        <!-- tổ chức -->
        <!-- cho công việc -->
        <li class="nav-item dropdown d-none d-sm-inline-block">
          <a class="nav-link border-left dropdown-toggle" data-toggle="dropdown" href="#">
            <i class="fa-solid fa-business-time text-muted"></i>
            <u class="ml-1 text-muted  d-none d-xl-inline-block">{{__('msg.forWork')}}</u>
          </a>

          <div class="dropdown-menu dropdown-menu-lg dropdown-menu-left">
            <div class="dropdown-divider"></div>
            <a href="/fullcalendar" class="dropdown-item">
              <i class="fa-solid fa-calendar-plus mr-2 text-warning"></i>{{__('msg.calendar')}}
            </a>

            <!-- cho công việc -->

            <!-- tài khoản -->
            @if (session('loginRoleAccount')== 1)
        <li class="nav-item dropdown d-none d-sm-inline-block">
          <a class="nav-link border-left dropdown-toggle" data-toggle="dropdown" href="#">
            <i class="fa-solid fa-chalkboard-user text-muted"></i>
            <u class="ml-1 text-muted  d-none d-xl-inline-block">{{__('msg.account')}}</u>
          </a>
          <div class="dropdown-menu dropdown-menu-lg dropdown-menu-left">
            <div class="dropdown-divider"></div>
            <a href="/accounts" class="dropdown-item">
              <i class="mr-2 text-primary fas fa-list-ol"></i>{{__('msg.list')}}
            </a>

            <div class="dropdown-divider"></div>
            <a href="/account-dashboard" class="dropdown-item">
              <i class="fa-solid fa-sitemap mr-2 text-warning"></i>{{__('msg.overview')}}
            </a>
          </div>
        </li>
        @endif
        <!-- tài khoản -->
        <!-- thiết bị -->
        @if (session('loginRoleAccount')== 1 || session('loginRoleAccount')== 3 )
        <li class="nav-item dropdown d-none d-sm-inline-block">
          <a class="nav-link border-left dropdown-toggle" data-toggle="dropdown" href="#">
            <i class="fa-solid fa-computer  text-muted"></i>
            <u class="ml-1 text-muted  d-none d-xl-inline-block">{{__('msg.device')}}</u>
          </a>
          <div class="dropdown-menu dropdown-menu-lg dropdown-menu-left">
            <div class="dropdown-divider"></div>
            <a href="{{ session('loginRoleAccount') == 1 ? '/admin-devices' : '/manager-devices' }}" class="dropdown-item">
              <i class="mr-2 text-primary fas fa-list-ol"> </i> {{__('msg.list')}}
            </a>
          </div>
        </li>
        @endif
        <!-- thiết bị -->
        <!-- tổng vụ -->
        <li class="nav-item dropdown d-none d-sm-inline-block ">
          <a class="nav-link border-left dropdown-toggle" data-toggle="dropdown" href="#" >
            <i class="fa-solid fa-swatchbook text-muted"></i>
            <u class="ml-1 text-muted  d-none d-xl-inline-block">{{__('msg.generalAffairs')}} </u>
          </a>
          <div class="dropdown-menu dropdown-menu-lg dropdown-menu-left">
            <div class="dropdown-divider"></div>
            <a href="/supplies" class="dropdown-item">
              <i class="mr-2 text-danger fa-solid fa-code-pull-request"> </i> {{__('msg.overview')}}
            </a>
            <div class="dropdown-divider"></div>
            <a href="/supply-requirements" class="dropdown-item">
              <i class="mr-2 text-primary fa-sharp fa-solid fa-share-from-square "> </i>{{__('msg.itemSupply')}}
            </a>
          </div>
          
        </li>
        <!-- tổng vụ -->
        <!-- tuyển dụng -->
        <li class="nav-item dropdown d-none d-sm-inline-block">
          <a class="nav-link border-left dropdown-toggle" data-toggle="dropdown" href="#">
            <i class="fa-solid fa-people-pulling text-muted"></i>
            <u class="ml-1 text-muted  d-none d-xl-inline-block">{{__('msg.recruitment')}}</u>
          </a>
          <div class="dropdown-menu dropdown-menu-lg dropdown-menu-left">
            <div class="dropdown-divider"></div>
            <a href="/candidates" class="dropdown-item">
              <i class="mr-2 text-danger fa-solid fa-arrows-down-to-people "> </i> {{__('msg.candidate')}}
            </a>
          </div>
        </li>
        <!-- tuyển dụng -->
        <!-- công cụ khác -->
        <li class="nav-item dropdown d-none d-sm-inline-block">
          <a class="nav-link border-left dropdown-toggle  border-right" data-toggle="dropdown" href="#">
            <i class="fa-solid fa-screwdriver-wrench text-muted"></i>
            <u class="ml-1 text-muted  d-none d-xl-inline-block">{{__('msg.other')}}</u>
          </a>
          <div class="dropdown-menu dropdown-menu-lg dropdown-menu-left">
            @if (session('loginRoleAccount')== 1)
            <div class="dropdown-divider"></div>
            <a href="/histories" class="dropdown-item">
              <i class="mr-2 text-danger fa-solid fa-heading "> </i> {{__('msg.operationHistory')}}
            </a>
            @endif
            <div class="dropdown-divider"></div>
            <a href="/instructions" class="dropdown-item">
              <i class="mr-2 text-primary fas fa-chalkboard-teacher "> </i>{{__('msg.userManual')}}
            </a>
            <div class="dropdown-divider"></div>
            <a href="/contact" class="dropdown-item">
              <i class="fas fa-phone mr-2 "></i> {{__('msg.contactSupport')}}
            </a>
          </div>
        </li>
        <!-- công cụ khác -->

      </ul>
      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto ">
        <!-- Navbar Search -->
        <!-- Messages Dropdown Menu -->
        <li class="nav-item dropdown">
          <a class="nav-link" data-toggle="dropdown" href="#" aria-haspopup="true" aria-expanded="false" id="dropdown01">
            <i class="fa-solid fa-globe"></i>
          </a>
          <div class="dropdown-menu p-0 py-2" aria-labelledby="dropdown01">
            <a class="dropdown-item" href="javascript:void(0);" onclick="changeLanguage('vi')"> <img class="mr-1" style="width: 25px; border: 0.5px solid #000;" src="https://upload.wikimedia.org/wikipedia/commons/thumb/2/21/Flag_of_Vietnam.svg/510px-Flag_of_Vietnam.svg.png"> Tiếng Việt</a>
            <a class="dropdown-item" href="javascript:void(0);" onclick="changeLanguage('ja')"> <img class="mr-1" style="width: 25px; border: 0.5px solid #000;" src="https://upload.wikimedia.org/wikipedia/en/thumb/9/9e/Flag_of_Japan.svg/800px-Flag_of_Japan.svg.png"> 日本語</a>
            <a class="dropdown-item" href="javascript:void(0);" onclick="changeLanguage('en')"> <img class="mr-1" style="width: 25px; border: 0.5px solid #000;" src="https://upload.wikimedia.org/wikipedia/commons/thumb/a/a5/Flag_of_the_United_Kingdom_%281-2%29.svg/1200px-Flag_of_the_United_Kingdom_%281-2%29.svg.png"> English</a>
          </div>
        </li>

        <li class="nav-item">
          <a class="nav-link" data-widget="fullscreen" href="#" role="button">
            <i class="fas fa-expand-arrows-alt"></i>
          </a>
        </li>
      </ul>
    </nav>