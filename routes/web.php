<?php

#regular users controller
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\CollectionController;


#Admin user controller
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\PostsController;
use App\Http\Controllers\Admin\CategoriesController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

#We have to protect our routes. -- we will use the class called ['middleware' => 'auth']
Route::group(['middleware' => 'auth'], function(){
    #Route for homepage
    Route::get('/', [HomeController::class, 'index'])->name('index');
    Route::get('/people', [HomeController::class, 'search'])->name('search');
    Route::get('/allsuggestedusers', [HomeController::class, 'allSuggestedUsers'])->name('allSuggestedUsers');

    #open create post form
    Route::get('/post/create',[PostController::class, 'create'])->name('post.create');

    #Save/insert post details to database tables
    Route::post('/post/store',[PostController::class, 'store'])->name('post.store');

    #Open show post page
    Route::get('/post/{id}/show', [PostController::class, 'show'])->name('post.show');

    #Open edit page
    Route::get('/post/{id}/edit', [PostController::class, 'edit'])->name('post.edit');

    #Update the post record
    Route::patch('post/{id}/update',[PostController::class, 'update'])->name('post.update');

    #Route for deleting the post
    Route::delete('post/{id}/destroy',[PostController::class, 'destroy'])->name('post.destroy');

    #Comments
    Route::post('/comment/{post_id}/store', [CommentController::class, 'store'])->name('comment.store');

    #Show comments
    Route::get('/comment/{post_id}/show', [CommentController::class, 'show'])->name('comment.show');

    #Delete comments
    Route::delete('/comment/{id}/destroy',[CommentController::class, 'destroy'])->name('comment.destroy');

    #Softdelete comment
    Route::delete('/comment/{id}/hide',[CommentController::class, 'hide'])->name('comment.hide');
    Route::patch('comment/{id}/unhide', [CommentController::class, 'unhide'])->name('comment.unhide');

    ### PROFILE SECTION ###
    Route::get('/profile/{id}/show', [ProfileController::class, 'show'])->name('profile.show');

    # Edit profile
    Route::get('/profile/{id}/edit', [ProfileController::class, 'edit'])->name('profile.edit');

    # Update Profile
    Route::patch('/profile/{id}/update',[ProfileController::class, 'update'])->name('profile.update');

    #Update password
    Route::patch('/profile/{id}/update', [ProfileController::class, 'updatePassword'])->name('profile.password.update');

    #Followers
    Route::get('/profile/{id}/followers', [ProfileController::class, 'followers'])->name('profile.followers');
    Route::get('/profile/{id}/following', [ProfileController::class, 'following'])->name('profile.following');

    #like
    Route::post('/like/{post_id}/store', [LikeController::class, 'store'])->name('like.store');
    Route::delete('/like/{post_id}/destroy', [LikeController::class, 'destroy'])->name('like.destroy');


    ##Collection
    Route::post('/collection/{post_id}/store', [CollectionController::class, 'store'])->name('collection.store');
    Route::delete('collection/{post_id}/destroy', [CollectionController::class, 'destroy'])->name('collection.destroy');

    #Show collection
    Route::get('/collection/{user_id}/show', [ProfileController::class, 'showCollection'])->name('collection.show');


    ### Follow/ Unfollow
    Route::post('/follow/{user_id}/store', [FollowController::class, 'store'])->name('follow.store');
    Route::delete('/follow/{user_id}/destroy', [FollowController::class, 'destroy'])->name('follow.destroy');

    ### Admin section ###
    Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' =>'admin'],function(){
        // USER
        Route::get('/users', [UsersController::class, 'index'])->name('users');
        Route::delete('/users/{id}/deactivate', [UsersController::class, 'deactivate'])->name('users.deactivate'); //admin.users.deactivate
        Route::patch('/users/{id}/activate', [UsersController::class, 'activate'])->name('users.activate');

        Route::get('/posts', [PostsController::class, 'index'])->name('posts');  //admin.posts
        Route::delete('/posts/{id}/hide', [PostsController::class, 'hide'])->name('posts.hide');  //admin.posts.hide
        Route::patch('/posts/{id}/unhide', [PostsController::class, 'unhide'])->name('posts.unhide');

        Route::get('/categories', [CategoriesController::class, 'index'])->name('categories');  //admin.categories
        Route::post('/categories/store', [CategoriesController::class, 'store'])->name('categories.store');
        Route::patch('/categories/{category_id}/update', [CategoriesController::class, 'update'])->name('categories.update');
        Route::delete('/categories/{category_id}/destroy', [CategoriesController::class, 'destroy'])->name('categories.destroy');

    });


});
