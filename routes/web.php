<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Route::prefix('/admin')->group(function () {
    // Auth routes
    Route::get('/sign-in', 'AuthController@showSignInForm')->name('showSignInForm');
    Route::post('/sign-in', 'AuthController@signIn')->name('signIn');
    Route::get('/sign-out', 'AuthController@signOut')->name('signOut');

    // Dashboard
    Route::get('/', 'DashboardController@showDashboard')->name('showDashboard');

    // Posts
    Route::get('/posts/{page?}', 'PostController@showAllPostsList')->name('showAllPostsList');
    Route::get('/posts/published/{page?}', 'PostController@showPublishedPostsList')->name('showPublishedPostsList');
    Route::get('/posts/scheduled/{page?}', 'PostController@showScheduledPostsList')->name('showScheduledPostsList');
    Route::get('/posts/drafted/{page?}', 'PostController@showDraftedPostsList')->name('showDraftedPostsList');
    Route::get('/posts/trashed/{page?}', 'PostController@showTrashedPostsList')->name('showTrashedPostsList');
    Route::get('/posts/add', 'PostController@showAddPostForm')->name('showAddPostForm');
    Route::get('/posts/edit/{post}', 'PostController@showEditPostForm')->name('showEditPostForm');
    Route::get('/posts/delete/{post}', 'PostController@deletePost')->name('deletePost');
    Route::get('/posts/restore/{post}', 'PostController@restorePost')->name('restorePost');
    Route::post('/posts/add', 'PostController@addPost')->name('addPost');
    Route::post('/posts/edit/{post}', 'PostController@updatePost')->name('updatePost');

    // Comments
    Route::get('/comments/{page?}', 'CommentController@showUnapprovedCommentsList')->name('showUnapprovedCommentsList');
    Route::get('/comments/approved', 'CommentController@showApprovedCommentsList')->name('showApprovedCommentsList');
    Route::get('/comments/approve/{comment}', 'CommentController@approveComment')->name('approveComment');
    Route::get('/comments/unapprove/{comment}', 'CommentController@unapproveComment')->name('unapproveComment');
    Route::get('/comments/delete/{comment}', 'CommentController@deleteComment')->name('deleteComment');

    // Categories
    Route::get('/categories/{page?}', 'CategoryController@showCategoriesList')->name('showCategoriesList');
    Route::get('/categories/add', 'CategoryController@showAddCategoryForm')->name('showAddCategoryForm');
    Route::get('/categories/edit/{category}', 'CategoryController@showEditCategoryForm')->name('showEditCategoryForm');
    Route::get('/categories/delete/{category}', 'CategoryController@deleteCategory')->name('deleteCategory');
    Route::post('/categories/add', 'CategoryController@addCategory')->name('addCategory');
    Route::post('/categories/edit/{category}', 'CategoryController@updateCategory')->name('updateCategory');

    // Users
    Route::get('/users/{page?}', 'UserController@showUsersList')->name('showUsersList');
    Route::get('/users/add', 'UserController@showAddUserForm')->name('showAddUserForm');
    Route::get('/users/edit/{user}', 'UserController@showEditUserForm')->name('showEditUserForm');
    Route::get('/users/delete/{user}', 'UserController@deleteUser')->name('deleteUser');
    Route::post('/users/add', 'UserController@addUser')->name('addUser');
    Route::post('/users/edit/{user}', 'UserController@updateUser')->name('updateUser');

    // Settings
    Route::get('/settings/general', 'SettingController@showGeneralSettingsForm')->name('showGeneralSettingsForm');
    Route::get('/settings/seo', 'SettingController@showSeoSettingsForm')->name('showSeoSettingsForm');
    Route::post('/settings', 'SettingController@updateSettings')->name('updateSettings');
});
