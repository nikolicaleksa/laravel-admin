<div class="col-md-3 left_col">
    <div class="left_col scroll-view">
        <div class="navbar nav_title">
            <a class="site_title" href="{{ route('showDashboard') }}">
                <span>{{ $settings['title_short'] }}</span>
            </a>
        </div>
        <div class="clearfix"></div>
        <div class="profile clearfix">
            <div class="profile_info">
                <span>@lang('content.navigation.welcome', ['name' => Auth::user()->getFullName()])</span>
            </div>
        </div>
        <div class="main_menu_side hidden-print main_menu" id="sidebar-menu">
            <div class="menu_section">
                <h3>@lang('content.navigation.navigation-title')</h3>
                <ul class="nav side-menu">
                    <li @if(Route::current()->named('showDashboard')) class="active" @endif>
                        <a href="{{ route('showDashboard') }}">
                            <i class="fa fa-home"></i> @lang('content.navigation.navigation-elements.home')
                        </a>
                    </li>
                    <li @if(Request::is('admin/posts*') || Request::is('admin/comments*') || Request::is('admin/categories*')) class="active" @endif>
                        <a>
                            <i class="fa fa-archive"></i> @lang('content.navigation.navigation-elements.blog') <span class="fa fa-chevron-down"></span>
                        </a>
                        <ul class="nav child_menu">
                            <li @if(Request::is('admin/posts*')) class="active" @endif>
                                <a href="{{ route('showAllPostsList') }}">
                                    @lang('content.navigation.navigation-elements.posts')
                                </a>
                            </li>
                            <li @if(Request::is('admin/comments*')) class="active" @endif>
                                <a href="{{ route('showUnapprovedCommentsList') }}">
                                    @lang('content.navigation.navigation-elements.comments')
                                </a>
                            </li>
                            <li @if(Request::is('admin/categories*')) class="active" @endif>
                                <a href="{{ route('showCategoriesList') }}">
                                    @lang('content.navigation.navigation-elements.categories')
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li @if(Request::is('admin/users*')) class="active" @endif>
                        <a href="{{ route('showUsersList') }}">
                            <i class="fa fa-users"></i> @lang('content.navigation.navigation-elements.users')
                        </a>
                    </li>
                    <li @if(Request::is('admin/settings*')) class="active" @endif>
                        <a>
                            <i class="fa fa-sliders"></i> @lang('content.navigation.navigation-elements.settings') <span class="fa fa-chevron-down"></span>
                        </a>
                        <ul class="nav child_menu">
                            <li @if(Route::current()->named('showGeneralSettingsForm')) class="active" @endif>
                                <a href="{{ route('showGeneralSettingsForm') }}">
                                    @lang('content.navigation.navigation-elements.general')
                                </a>
                            </li>
                            <li @if(Route::current()->named('showSeoSettingsForm')) class="active" @endif>
                                <a href="{{ route('showSeoSettingsForm') }}">
                                    @lang('content.navigation.navigation-elements.seo')
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>