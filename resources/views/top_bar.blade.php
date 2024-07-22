<header id="header">
    <div class="row">
        <div class="col-sm-4 col-xl-2 header-left">
            <div class="logo float-xs-left">
                <a href="{!! route('backend.home') !!}"><img src="{!! asset_url()  !!}/global/image/mac_icon.png" alt="logo"></a>

            </div>
            <button class="left-menu-toggle float-xs-right">
                <i class="icon_menu toggle-icon"></i>
            </button>
            <button class="right-menu-toggle float-xs-right">
                <i class="arrow_carrot-left toggle-icon"></i>
            </button>
        </div>
        <div class="col-xl-8 header-center">
            <div class="menucontainer">
                <div class="overlapblackbg"></div>
                <a id="navtoggle" class="animated-arrow"><span></span></a>
                <nav id="nav" class="topmenu" role="navigation">
                    <div class="sidebar-search">
                        <input id="live-search-box" type="search" class="form-control input-sm" placeholder="@lang('labels.general.search')">
                        <a href="javascript:void(0)"><i class="search-close icon_search"></i></a>
                    </div>
                    <ul class="menu-list live-search-list">
                        <li>
                            @permission('view_compliance_menu')
                            <a href="javascript:void(0)">
                                <span class="icon fa fa-university" aria-hidden="true"></span>&nbsp;@lang('menus.backend.employers.title')<span class="arrow_carrot-down header-arrow-down" aria-hidden="true"></span>
                            </a>
                            <ul class="dropNav">
                                <li>
                                    <a href="{!! route('backend.compliance.employee.index') !!}">@lang('menus.backend.employers.employees')</a>
                                </li>
                                <li>
                                    <a href="{!! route('backend.compliance.employer.index') !!}">@lang('menus.backend.employers.employers')</a>
                                </li>

                                @permission('view_treasury_employees',1)
                                <li>
                                    <a href="{!! route('backend.finance.treasury.employees') !!}">Treasury Employees</a>
                                </li>
                                @endauth
                            </ul>
                            @else
                            <a href="#" class="permission-check">
                                <span class="icon fa fa-university" aria-hidden="true"></span>&nbsp;@lang('menus.backend.employers.title')<span class="arrow_carrot-down header-arrow-down" aria-hidden="true"></span></a>
                            @endauth
                        </li>
                        <li>

                            @permission('view_finance_menu')
                            <a href="{!! route('backend.finance.menu') !!}">
                                {{--<span class="icon_tags_alt header-icon" aria-hidden="true"></span>--}}
                                <span class="icon fa fa-money" aria-hidden="true"></span>
                                {{--<i class="icon fa fa-money" aria-hidden="true"></i>--}}
                                @lang('menus.backend.finance.title')
                            </a>
                            @else
                            <a href="#" class="permission-check">
                                <span class="icon fa fa-money" aria-hidden="true"></span>&nbsp;@lang('menus.backend.finance.title')
                            </a>
                            @endauth

                            <ul class="dropNav">
                                {{-- <!-- First Level Menu -->
                                                                <li>
                                                                    <a href="index-2.html">@lang('menus.backend.employers.members')</a>
                                                                </li>
                                                                <!-- Second Level Menu -->
                                                                <li><a href="javascript:void(0)">@lang('menus.backend.finance.receipts')<span class="arrow_carrot-right submenu-arrow-right" aria-hidden="true"></span></a>
                                                                    <ul class="submenu-sub dropNav">
                                                                        <li>
                                                                            <a href="userlist.html">Userlist</a>
                                                                        </li>
                                                                        <!-- Third Level Menu -->
                                                                        <li><a href="javascript:void(0)">Mailbox<span class="arrow_carrot-right submenu-arrow-right" aria-hidden="true"></span></a>
                                                                            <ul class="submenu-sub-sub">
                                                                                <li>
                                                                                    <a href="mail_box.html">Inbox</a>
                                                                                </li>
                                                                            </ul>
                                                                        </li>
                                                                    </ul>
                                                                </li>--}}
                            </ul>
                        </li>
                        <li>
                            @permission('view_compliance_menu')
                            <a href="{!! route('backend.compliance.menu') !!}">
                                <span class="icon fa fa-book" aria-hidden="true"></span>&nbsp;@lang('menus.backend.compliance.title')
                            </a>
                            @else
                            <a href="#" class="permission-check">
                                <span class="icon fa fa-book" aria-hidden="true"></span>&nbsp;@lang('menus.backend.compliance.title')
                            </a>
                            @endauth
                            <ul class="dropNav">

                            </ul>
                        </li>
                        <li>
                            @permission('view_claim_menu')
                            <a href="{!! route('backend.claim.menu') !!}">
                                <span class="icon fa fa-wheelchair header-icon" aria-hidden="true"></span>@lang('menus.backend.claims.title')
                            </a>
                            @else
                            <a href="#" class="permission-check">
                                <span class="icon fa fa-wheelchair header-icon" aria-hidden="true"></span>&nbsp;@lang('menus.backend.claims.title')
                            </a>
                            @endauth
                            <ul class="dropNav">

                            </ul>
                        </li>
                        <li>
                            @permission('view_claim_assessment_menu')
                            <a href="{!! route('backend.assessment.menu') !!}">
                                <span class="icon fa fa-user-md header-icon" aria-hidden="true"></span>@lang('menus.backend.assessment.title')
                            </a>
                            @else
                            <a href="#" class="permission-check">
                                <span class="icon fa fa-user-md header-icon" aria-hidden="true"></span>&nbsp;@lang('menus.backend.assessment.title')
                            </a>
                            @endauth
                            <ul class="dropNav">

                            </ul>
                        </li>
                        <li>
                            <!--Remember to change permission to investment-->
                            @permission('view_investment_menu')
                            <a href="{!! route('backend.investment.menu') !!}">
                                <span class="icon fa fa-briefcase header-icon" aria-hidden="true"></span>@lang('menus.backend.investment.title')
                            </a>
                            @else
                            <a href="#" class="permission-check">
                                <span class="icon fa fa-briefcase header-icon" aria-hidden="true"></span>&nbsp;@lang('menus.backend.investment.title')
                            </a>
                            @endauth
                            <ul class="dropNav">

                            </ul>
                        </li>
                        <li>
                            @permission('view_osh_menu')
                            <a href="{!! route('backend.workplace_risk_assesment.menu') !!}">
                                <span class="icon fa fa-universal-access" aria-hidden="true"></span>&nbsp;@lang('menus.backend.osh.title')
                            </a>
                            @else
                            <a href="#" class="permission-check">
                                <span class="icon fa fa-universal-access" aria-hidden="true"></span>&nbsp;@lang('menus.backend.osh.title')
                            </a>
                            @endauth
                            <ul class="dropNav">

                            </ul>
                        </li>
                        <li>
                            {{-- @permission("view_legal") --}}
                            <a href="{!! route('backend.legal.menu') !!}">
                                <span class="icon fa fa-legal" aria-hidden="true"></span>&nbsp;Legal</a>
                            {{-- @else
                                                                <a href="#" class="permission-check">
                                                                    <span class="icon fa fa-legal" aria-hidden="true"></span>&nbsp;Legal</a>
                                                                    @endauth --}}
                            <ul class="dropNav">

                            </ul>
                        </li>

                    </ul>
                </nav>
                <nav id="nav-mega">
                    <ul class="menu-list">
                        <li class="dropdown dropdown-mega-item">
                            <a href="#" data-toggle="dropdown" data-open="true" aria-haspopup="true" aria-expanded="false">
                                <span class="icon_ul header-icon" aria-hidden="true"></span><span class="mega-title">@lang('menus.backend.mis')</span>
                                <span class="arrow_carrot-down header-arrow-down" aria-hidden="true"></span>
                            </a>
                            <div class="dropdown-menu dropdown-mega-menu">
                                <div class="mega-menu-container">
                                    <div class="row">
                                        <div class="col-xl-2 col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                            <div class="mega-menu-title">
                                                <span>@lang('menus.backend.admin.title')</span>
                                            </div>
                                            <ul>
                                                <li>
                                                    {{-- @usermanagement() --}}
                                                    <a href="{!! route('backend.user.index') !!}"><span class="icon fa fa-user" aria-hidden="true"></span>@lang('menus.backend.admin.users')</a>
                                                    {{-- @else
                                                    <a href="#" class="permission-check"><span class="icon fa fa-user" aria-hidden="true"></span>@lang('menus.backend.admin.users')</a>
                                                    @endauth --}}
                                                </li>
                                                {{--<li><a href="{!! route('backend.organization.menu') !!}"><span class="icon fa fa-institution" aria-hidden="true"></span>@lang('menus.backend.admin.organization')</a></li>To be added later--}}
                                                <li>
                                                    @permission('system')
                                                    <a href="{!! route('backend.system.menu') !!}"><span class="icon fa fa-cogs" aria-hidden="true"></span>@lang('menus.backend.admin.system')</a>
                                                    @else
                                                    <a href="#" class="permission-check"><span class="icon fa fa-cogs" aria-hidden="true"></span>@lang('menus.backend.admin.system')</a>
                                                    @endauth
                                                </li>

                                                <li>
                                                    @permission('organisation')
                                                    <a href="{!! route('backend.organization.menu') !!}"><span class="icon fa fa-building" aria-hidden="true"></span>@lang('menus.backend.admin.organization')</a>
                                                    @else
                                                    <a href="#" class="permission-check"><span class="icon fa fa-building" aria-hidden="true"></span>@lang('menus.backend.admin.organization')</a>
                                                    @endauth
                                                </li>



                                            </ul>
                                        </div>
                                        <div class="divider-xs-megamenu-spacing"></div>
                                        <div class="col-xl-2 col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                            <div class="mega-menu-title">
                                                <span>@lang('menus.backend.units')</span>
                                            </div>
                                            <ul>
                                                <li>
                                                    {{-- @permission("view_legal") --}}
                                                    <a href="{!! route('backend.legal.menu') !!}">
                                                        <span class="icon fa fa-legal" aria-hidden="true"></span>@lang('labels.backend.legal.title.main')</a>
                                                    {{-- @else
                                                                                        <a href="#" class="permission-check">
                                                                                            <span class="icon fa fa-legal" aria-hidden="true"></span>@lang('labels.backend.legal.title.main')</a>
                                                                                            @endauth
                                                                                        </li> --}}

                                            </ul>
                                        </div>
                                        <div class="divider-md-spacing"></div>
                                        <div class="col-xl-2 col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                            <div class="mega-menu-title">
                                                <span>@lang('menus.backend.reports.title')</span>
                                            </div>

                                            <ul>
                                                <li>
                                                    <a href="{!! route('backend.report.configurable.refresh') !!}">
                                                        <span class="icon fa fa-refresh" aria-hidden="true"></span>Refresh Configurable Report</a>
                                                    @permission('view_reports_all')
                                                    <a href=" {!! route('backend.finance.report.index', 0) !!}">
                                                        <span class="icon fa fa-list-alt" aria-hidden="true"></span>@lang('menus.backend.reports.all')</a>
                                                    @else
                                                    <a href="#" style="pointer-events: none;">
                                                        <span class="icon fa fa-list-alt" aria-hidden="true"></span>@lang('menus.backend.reports.all')</a>
                                                    
                                                    @endauth
                                                </li>
                                                {{--<li>--}}
                                                {{--@permission('members')--}}
                                                {{--<a href="#">--}}
                                                {{--<span class="icon fa fa-list-alt" aria-hidden="true"></span>@lang('menus.backend.employers.title')</a>--}}
                                                {{--@else--}}
                                                {{--<a href="#" style="pointer-events: none;">--}}
                                                {{--<span class="icon fa fa-list-alt" aria-hidden="true"></span>@lang('menus.backend.employers.title')</a>--}}
                                                {{--@endauth--}}
                                                {{--</li>--}}

                                                <li>
                                                    @permission('finance')
                                                    <a href="{!! route('backend.finance.report.index', 2)!!}">
                                                        <span class="icon fa fa-list-alt" aria-hidden="true"></span>@lang('menus.backend.finance.title')</a>
                                                    @else
                                                    <a href="{!! route('backend.finance.report.index', 2)!!} " style="pointer-events: none;">
                                                        <span class="icon fa fa-list-alt" aria-hidden="true"></span>@lang('menus.backend.finance.title')</a>
                                                    @endauth
                                                </li>

                                                <li>
                                                    @permission('compliance')
                                                    <a href="{!! route('backend.finance.report.index', 3)!!}">
                                                        <span class="icon fa fa-list-alt" aria-hidden="true"></span>@lang('menus.backend.compliance.title')</a>

                                                    @else
                                                    <a href="#" style="pointer-events: none;">
                                                        <span class="icon fa fa-list-alt" aria-hidden="true"></span>@lang('menus.backend.compliance.title')</a>
                                                    @endauth
                                                </li>

                                                <li>
                                                    @permission('claims')
                                                    <a href="{!! route('backend.finance.report.index', 1)!!}">
                                                        <span class="icon fa fa-list-alt" aria-hidden="true"></span>@lang('menus.backend.claims.title')</a>
                                                    @else
                                                    <a href="#" style="pointer-events: none;">
                                                        <span class="icon fa fa-list-alt" aria-hidden="true"></span>@lang('menus.backend.claims.title')</a>
                                                    @endauth
                                                </li>

                                                <li>
                                                    @permission('assessment')
                                                    <a href="{!! route('backend.finance.report.index', 11)!!}">
                                                        <span class="icon fa fa-list-alt" aria-hidden="true"></span>@lang('menus.backend.assessment.title')</a>
                                                    @else
                                                    <a href="#" style="pointer-events: none;">
                                                        <span class="icon fa fa-list-alt" aria-hidden="true"></span>@lang('menus.backend.assessment.title')</a>
                                                    @endauth
                                                </li>


                                                <li>
                                                    @permission('claims')
                                                    <a href="{!! route('backend.finance.report.index', 4)!!}">
                                                        <span class="icon fa fa-list-alt" aria-hidden="true"></span>@lang('menus.backend.payroll.title')</a>
                                                    @else
                                                    <a href="#" style="pointer-events: none;">
                                                        <span class="icon fa fa-list-alt" aria-hidden="true"></span>@lang('menus.backend.payroll.title')</a>
                                                    @endauth
                                                </li>
                                                <li>
                                                    @permission('audit')
                                                    <a href="{!! route('backend.finance.report.index', 5)!!}">
                                                        <span class="icon fa fa-list-alt" aria-hidden="true"></span>Audit</a>
                                                    @else
                                                    <a href="#" style="pointer-events: none;">
                                                        <span class="icon fa fa-list-alt" aria-hidden="true"></span>Audit</a>
                                                    @endauth
                                                </li>
                                                <li>
                                                    @permission('information_technology')
                                                    <a href="{!! route('backend.finance.report.index', 10)!!}">
                                                        <span class="icon fa fa-list-alt" aria-hidden="true"></span>Information Technology</a>
                                                    @else
                                                    <a href="#" style="pointer-events: none;">
                                                        <span class="icon fa fa-list-alt" aria-hidden="true"></span>Information Technology</a>
                                                    @endauth
                                                </li>

                                                                                                                                                <li>
                                                                                                                                                    @permission('external_audit')
                                                                                                                                                    <a href="{!! route('backend.finance.report.index', 8)!!}">
                                                                                                                                                        <span class="icon fa fa-list-alt"
                                                                                                                                                        aria-hidden="true"></span>External Audit</a>
                                                                                                                                                        @else
                                                                                                                                                        <a href="#" style="pointer-events: none;">
                                                                                                                                                            <span class="icon fa fa-list-alt"
                                                                                                                                                            aria-hidden="true"></span>External Audit</a>
                                                                                                                                                            @endauth
                                                                                                                                                        </li>
                                                                                                                                                         <li>
        @permission('view_legal')
        <a href="{!! route('backend.finance.report.index', 9)!!}">
            <span class="icon fa fa-list-alt" aria-hidden="true"></span>
        @lang('menus.backend.legal.title')</a>
        @else
        <a href="#" style="pointer-events: none;">
            <span class="icon fa fa-list-alt"
            aria-hidden="true"></span>@lang('menus.backend.legal.title')</a>
            @endauth
        </li>
                                                                                                                                                        {{-- <li>
                                                                                                                                                            @permission('investment')
                                                                                                                                                            <a href="{!! route('backend.finance.report.index', 7)!!}">
                                                                                                                                                                <span class="icon fa fa-list-alt" aria-hidden="true"></span>@lang('menus.backend.investment.title')</a>

                                                                                                                                                                @else
                                                                                                                                                                <a href="#" style="pointer-events: none;">
                                                                                                                                                                    <span class="icon fa fa-list-alt" aria-hidden="true"></span>@lang('menus.backend.investment.title')</a>
                                                                                                                                                                    @endauth
                                                                                                                                                                </li> --}}

                                            </ul>

                                        </div>
                                        <div class="divider-md-spacing"></div>
                                        <div class="col-xl-2 col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                            <div class="mega-menu-title">
                                                <span>@lang('menus.backend.documentation.title')</span>
                                            </div>
                                            <ul>
                                                <li>
                                                    <a href="{!! route("guide") !!}" target="_blank">
                                                        <span class="icon fa fa-book" aria-hidden="true"></span>@lang('menus.backend.documentation.manual')
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="divider-md-spacing"></div>
                                        <div class="col-xl-2 col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                            <div class="mega-menu-title">
                                                <span>@lang('menus.backend.help.title')</span>
                                            </div>
                                            <ul>
                                                <li>
                                                    <a href="#">
                                                        <span class="icon fa fa-info" aria-hidden="true"></span>@lang('menus.backend.help.about')
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="divider-md-spacing"></div>
                                                                                                                                                        <div class="col-xl-2 col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                                                                                                                                            <div class="mega-menu-title">
                                                                                                                                                                <span>NOTIFICATION CENTER</span>
                                                                                                                                                            </div>
                                                                                                                                                            <ul>
                                                                                                                                                                <li>
                                                                                                                                                                    <a href="{!! route("backend.portal_notification.create") !!}" target="_blank">
                                                                                                                                                                        <span class="icon fa fa-pencil-square-o" aria-hidden="true"></span>Create Notification
                                                                                                                                                                    </a>
                                                                                                                                                                </li>
                                                                                                                                                            </ul>
                                                                                                                                                        </div>

                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            {{--<img src="{!! asset_url()  !!}/global/image/menuimg_wcf.png" alt="" class="tabimage"/>--}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
        <div class="col-sm-8 col-xl-10 header-right">
            <div class="header-inner-right">
                {{--/*---------SEARCH BOX FOR SEARCH OVERLAY FOR NAVIGATION------------*/--}}
                {{--<div class="float-default searchbox" >--}}
                {{--<div class="right-icon hidden">--}}
                {{--<a href="javascript:void(0)">--}}
                {{--<i class="icon_search hidden"></i>--}}
                {{--</a>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{-- <div class="float-default chat">
                                    <div class="right-icon">
                                        <a href="javascript:void(0)" data-toggle="dropdown" data-open="true" data-animation="slideOutUp" aria-expanded="false">
                                            <i class="icon_chat_alt"></i>
                                            <span class="mail-no">8</span>
                                        </a>
                                        <ul class="dropdown-menu userChat" data-plugin="custom-scroll" data-height="310">
                                                                        <li>
                                                                            <a href="#">
                                                                                <div class="media">
                                                                                    <div class="media-left float-xs-left">
                                                                                        <img src="../../../assets/global/image/image1-profile.jpg" alt="message"/>
                                                                                    </div>
                                                                                    <div class="media-body">
                                                                                        <h5>Judy Fowler</h5>
                                                                                        <p>Dummy text of the printing...</p>
                                                                                        <div class="meta-tag text-nowrap">
                                                                                            <time datetime="2016-12-10T20:27:48+07:00" class="text-muted">5 mins
                                                                                            </time>
                                                                                        </div>
                                                                                        <div class="status online"></div>
                                                                                    </div>
                                                                                </div>
                                                                            </a>
                                                                        </li>
                                        </ul>
                                    </div>
                                </div>--}}
                <div class="float-default chat">
                    <div class="right-icon">
                        <a href="#" data-plugin="fullscreen">
                            <i class="arrow_expand"></i>
                        </a>
                    </div>
                </div>
                <div class="user-dropdown">
                    <div class="btn-group">
                        <a href="#" class="user-header dropdown-toggle" data-toggle="dropdown" data-animation="slideOutUp" aria-haspopup="true" aria-expanded="false">
                            <img src="{!! asset_url()  !!}/global/image/user4.png" alt="Profile image" />
                        </a>
                        <div class="dropdown-menu drop-profile">
                            <div class="userProfile">
                                <img src="{!! asset_url()  !!}/global/image/user4.png" alt="Profile image" />
                                <h5>{!! access()->user()->name !!}</h5>
                                <p>{!! access()->user()->email !!}</p>
                            </div>
                            <div class="dropdown-divider"></div>
                            @if (access()->user()->available)
                            <a class="btn btn-primary left-spacing" href="{{ route("backend.users.substitute", access()->id()) }}" role="button">My Handover</a>
                            @endif
                            {{--<a class="btn left-second-spacing link-btn" href="#" role="button">Link 2</a>  --}}
                            <a class="btn btn-primary float-xs-right right-spacing" href="{!! route('logout') !!}" role="button">Logout</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
