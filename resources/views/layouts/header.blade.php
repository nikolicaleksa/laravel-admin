<div class="top_nav">
    <div class="nav_menu">
        <nav>
            <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
            </div>
            <ul class="nav navbar-nav navbar-right">
                <li>
                    <a aria-expanded="false" class="user-profile dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-fw fa-user-circle"></i> {{ Auth::user()->getFullName() }} <span class=" fa fa-angle-down"></span>
                    </a>
                    <ul class="dropdown-menu dropdown-usermenu pull-right">
                        <li><a href="{{ route("signOut") }}">@lang('content.auth.sign-out-title')</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</div>