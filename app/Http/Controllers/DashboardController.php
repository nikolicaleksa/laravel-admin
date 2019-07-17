<?php

namespace App\Http\Controllers;

use Aleksa\LaravelVisitorsStatistics\Models\Statistic;
use App\Comment;
use App\Post;
use Aleksa\LaravelVisitorsStatistics\Models\Visitor;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * DashboardController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display dashboard.
     *
     * @return View
     */
    public function showDashboard(): View
    {
        return view('dashboard/dashboard', array_merge(
            $this->getEntriesCount(),
            $this->getStatistics(),
            $this->getMostPopularPosts(),
            $this->getFreeSpace(),
            $this->getServerInformation()
        ));
    }

    /**
     * Get entries count from database.
     *
     * @return array
     */
    private function getEntriesCount(): array
    {
        $approvedComments = Comment::where('is_approved', true)->count();
        $unapprovedComments = Comment::where('is_approved', false)->count();
        $comments = $approvedComments + $unapprovedComments;

        return [
            'postsCount' => Post::count(),
            'commentsCount' => $comments,
            'approvedComments' => $approvedComments,
            'unapprovedComments' => $unapprovedComments,
        ];
    }

    /**
     * Get visitor statistics.
     *
     * @return array
     */
    private function getStatistics(): array
    {
        return [
            'visitorsOnline' => Visitor::onlineCount(),
            'maxVisitorsOnline' => Statistic::maxVisitors(),
            'visitorsTotal' => Statistic::getTotalVisitors(),
            'postViews' => Post::sum('views'),
        ];
    }

    /**
     * Get most viewed and commented posts
     *
     * @return array
     */
    private function getMostPopularPosts(): array
    {
        $mostPopularPost = Post::select(['title', 'slug', 'views'])->orderBy('views', 'desc')->first();
        $mostCommentedPost = Comment::select(DB::raw('`title`, `slug`, COUNT(`post_id`) as `comment_count`'))
            ->groupBy('post_id')
            ->join('posts', 'post_id', 'posts.id')
            ->orderBy('comment_count', 'desc')
            ->first();

        return [
            'mostPopularPost' => $mostPopularPost,
            'mostCommentedPost' => $mostCommentedPost,
        ];
    }

    /**
     * Get information about remaining free space
     *
     * @return array
     */
    private function getFreeSpace(): array
    {
        $totalSpace = disk_total_space('/');
        $freeSpace = disk_free_space('/');

        if ($totalSpace && $freeSpace) {
            $freeSpacePercentage = floor((100 * $freeSpace) / $totalSpace);
            $freeSpace = $this->formatBytes($freeSpace);
        } else {
            $freeSpace = trans('content.dashboard.not-available');
            $freeSpacePercentage = false;
        }

        return [
            'freeSpace' => $freeSpace,
            'freeSpacePercentage' => $freeSpacePercentage,
        ];
    }

    /**
     * Get information about the server
     *
     * @return array
     */
    private function getServerInformation(): array
    {
        $mysqlVersion= DB::select(DB::raw("SELECT version() as 'version'"))[0]->version;

        return [
            'serverName' => $_SERVER['SERVER_NAME'],
            'serverAdmin' => $_SERVER['SERVER_ADMIN'] ?? trans('content.dashboard.unknown'),
            'operatingSystem' => php_uname('s'),
            'phpVersion' => phpversion(),
            'mysqlVersion' => $mysqlVersion,
        ];
    }

    /**
     * Convert bytes to human-readable size
     *
     * @param int $bytes
     * @param int $precision
     *
     * @return string Formatted size
     */
    public function formatBytes(int $bytes, int $precision = 2): string
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $bytes = max($bytes, 0);
        $pow = floor(log($bytes) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= (1 << (10 * $pow));

        return round($bytes, $precision) . ' ' . $units[$pow];
    }
}
