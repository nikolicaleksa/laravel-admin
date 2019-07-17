@extends('layouts.authenticated')

@section('content')
<div class="row tile_count">
    <div class="col-lg-2 col-md-4 col-sm-4 col-xs-6 tile_stats_count">
        <span class="count_top"><i class="fa fa-fw fa-archive"></i> @lang('content.dashboard.posts-count')</span>
        <div class="count green">{{ $postsCount }}</div>
    </div>
    <div class="col-lg-2 col-md-4 col-sm-4 col-xs-6 tile_stats_count">
        <span class="count_top"><i class="fa fa-fw fa-comments"></i> @lang('content.dashboard.comments-count')</span>
        <div class="count">{{ $commentsCount }}</div>
    </div>
    <div class="col-lg-2 col-md-4 col-sm-4 col-xs-6 tile_stats_count">
        <span class="count_top"><i class="fa fa-fw fa-eye"></i> @lang('content.dashboard.visitors-online')</span>
        <div class="count green">{{ $visitorsOnline }}</div>
    </div>
    <div class="col-lg-2 col-md-4 col-sm-4 col-xs-6 tile_stats_count">
        <span class="count_top"><i class="fa fa-line-chart"></i> @lang('content.dashboard.max-visitors-online')</span>
        <div class="count">{{ $maxVisitorsOnline }}</div>
    </div>
    <div class="col-lg-2 col-md-4 col-sm-4 col-xs-6 tile_stats_count">
        <span class="count_top"><i class="fa fa-users"></i> @lang('content.dashboard.visitors-total')</span>
        <div class="count green">{{ $visitorsTotal }}</div>
    </div>
</div>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="dashboard_graphs">
            <div class="row x_title">
                <div class="col-md-12">
                    <ul id="statistics-list" class="list-inline nav nav-tabs" role="tablist">
                        <li role="presentation" class="active">
                            <a href="#visitor-statistics" aria-controls="visitor-statistics" role="tab" data-toggle="tab">
                                <h3>@lang('content.dashboard.visitors-statistics') <span id="month-name"></span></h3>
                            </a>
                        </li>
                        <li role="presentation">
                            <a href="#visitor-countries" aria-controls="visitor-countries" role="tab" data-toggle="tab">
                                <h3>@lang('content.dashboard.visitors-countries')</h3>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active fade in" id="visitor-statistics">
                    <div class="demo-placeholder" id="visitors-statistics-graph"></div>
                </div>
                <div role="tabpanel" class="tab-pane fade" id="visitor-countries">
                    <div class="demo-placeholder" id="visitors-countries-graph"></div>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
</div><br>
<div class="row">
    <div class="bottom-panel col-lg-4 col-md-6 col-sm-6 col-xs-6 col-xxs-12">
        <div class="x_panel tile">
            <div class="x_title">
                <h2>@lang('content.dashboard.statistics')</h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                    <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <ul id="server-information">
                    <li>
                        <i class="fa fa-fw fa-eye"></i> @lang('content.dashboard.post-views-total'): {{ $postViews }}
                    </li>
                    <li>
                        <i class="fa fa-fw fa-rocket"></i> @lang('content.dashboard.most-popular-post'):

                        <a href="#" data-toggle="tooltip" data-placement="top" target="_blank" title="@lang("content.dashboard.views-count"): {{ $mostPopularPost->views }}">
                            {{ $mostPopularPost->title }}
                        </a>
                    </li>
                    <li>
                        <i class="fa fa-fw fa-commenting"></i> @lang('content.dashboard.most-commented-post'):

                        <a href="#" data-toggle="tooltip" data-placement="top" target="_blank" title="@lang("content.dashboard.comments-count"): {{ $mostCommentedPost->comment_count }}">
                            {{ $mostCommentedPost->title }}
                        </a>
                    </li>
                    <li>
                        <i class="fa fa-fw fa-check"></i> @lang('content.dashboard.approved-comments'): {{ $approvedComments }}
                    </li>
                    <li>
                        <i class="fa fa-fw fa-ban"></i> @lang('content.dashboard.unapproved-comments'): {{ $unapprovedComments }}
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="bottom-panel col-lg-4 col-md-6 col-sm-6 col-xs-6 col-xxs-12">
        <div class="x_panel tile">
            <div class="x_title">
                <h2>@lang('content.dashboard.free-space')</h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                    <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div id="free-space-chart" class="x_content">
                <div class="alert alert-warning alert-dismissible text-center" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="{{ trans("close.inputs") }}">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <strong>@lang('content.dashboard.error')!</strong> @lang('content.dashboard.free-space-failed')
                </div>
            </div>
        </div>
    </div>
    <div class="bottom-panel col-lg-4 col-md-6 col-sm-6 col-xs-6 col-xxs-12">
        <div class="x_panel tile">
            <div class="x_title">
                <h2>@lang('content.dashboard.server-information')</h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                    <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <ul id="server-information">
                    <li><i class="fa fa-fw fa-server"></i>@lang('content.dashboard.server-name'): {{ $serverName }}</li>
                    <li><i class="fa fa-fw fa-linux"></i>@lang('content.dashboard.operating-system'): {{ $operatingSystem }}</li>
                    <li><i class="fa fa-fw fa-hdd-o"></i>@lang('content.dashboard.free-space'): {{ $freeSpace }}</li>
                    <li><i class="fa fa-fw fa-user-secret"></i>@lang('content.dashboard.server-admin'): {{ $serverAdmin }}</li>
                    <li><i class="fa fa-fw fa-code"></i>@lang('content.dashboard.php-version'): {{ $phpVersion }}</li>
                    <li><i class="fa fa-fw fa-database"></i>@lang('content.dashboard.mysql-version'): {{ $mysqlVersion }}</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
    @if($freeSpacePercentage)
        <script>
            const months = {!! json_encode(trans('content.dashboard.months'), true) !!};
            const visitors_statistics_for = "{{ trans('content.dashboard.visitors-statistics-for') }}";
            const visitor_countries_title = "{{ trans('content.dashboard.visitors-countries-title') }}";
            const visits_count = '{{ trans('content.dashboard.visits-count') }}';
            const visits = '{{ trans('content.dashboard.visits') }}';
            const unique_visits = '{{ trans('content.dashboard.visits-unique') }}';

            $(function() {
                showVisitorsStatistics("{{ route('visitorstatistics.total_statistics', ['year' => 'year', 'month' => 'month']) }}", {{ date('Y') }}, {{ date('n') }});
                showVisitorsCountries("{{ route('visitorstatistics.countries') }}");
                showFreeSpaceChart({{ $freeSpacePercentage }});
            });
        </script>
    @endif
@endpush