<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/**
	* Public organization
*/
Route::get('/organization/{id}', 'OrganizationController@index')->where('id', '[0-9]+');

// Get languages of organization's subscribers
Route::get('/organization_subscription/languages', 'Organization\SubscriptionController@languages');

// Update user's social media data
Route::post('/user/social', 'User\UserController@updateSocialProfile');

// Update organization's affiliate settings
Route::put('/organization/affiliate', 'Organization\OrganizationController@updateAffiliate');

// Get unverified organization users
Route::get('/organization_members/unverified', 'Organization\OrganizationUserController@unverifiedUsers');

// Get visible organization users
Route::get('/organization_members/visible/{id}', 'Organization\OrganizationUserController@visibleUsers')->where('id', '[0-9]+');

// Update member's role
Route::post('/organization_members/updateRole', 'Organization\OrganizationUserController@updateRole');

// Update member's visibility
Route::put('/organization_members/promoteMember/{id}', 'Organization\OrganizationUserController@promoteMember')->where('id', '[0-9]+');
Route::put('/organization_members/demoteMember/{id}', 'Organization\OrganizationUserController@demoteMember')->where('id', '[0-9]+');

// Get languages of the members in the organization
Route::get('/organization_members/languages', 'Organization\OrganizationUserController@languages');

// Get cities of the members in the organization
Route::get('/organization_members/cities', 'Organization\OrganizationUserController@cities');

// Test, Save and Test newsletter
Route::post('/newsletter/test_newsletter', 'Organization\NewsletterController@testNewsletter');
Route::post('/newsletter/save_test_newsletter', 'Organization\NewsletterController@saveAndTestNewsletter');
Route::put('/newsletter/update_test_newsletter/{id}', 'Organization\NewsletterController@updateAndTestNewsletter')->where('id', '[0-9]+');
Route::post('/newsletter/dispatch_newsletter/{id}', 'Organization\NewsletterController@dispatchNewsletter')->where('id', '[0-9]+');

// Blog post
Route::put('/blog/post/verify/{id}', 'Blog\PostController@alterVerification')->where('id', '[0-9]+');
Route::put('/blog/post/status/{id}', 'Blog\PostController@alterVisibility')->where('id', '[0-9]+');

// Get organization's posts
Route::get('/organization/blog/posts/{id}', 'Blog\PostController@allPosts')->where('id', '[0-9]+');

// Get organization's post comments
Route::get('/organization/blog/comments/{id}', 'Blog\CommentController@allComments')->where('id', '[0-9]+');

Route::apiResources([
	'country' => 'General\CountryController',
	'region' => 'General\RegionController',
	'city' => 'General\CityController',
	'language' => 'General\LanguageController',

	'blog/post' => 'Blog\PostController',
	'blog/comment' => 'Blog\CommentController',

	'organization_subscription' => 'Organization\SubscriptionController',
	'organization_contact_message' => 'Organization\ContactMessageController',

	'register' => 'User\RegisterController',
	'user' => 'User\UserController',
	'organization' => 'Organization\OrganizationController',
	'organization_members' => 'Organization\OrganizationUserController',
	'newsletter' => 'Organization\NewsletterController'
]);

// Counters
Route::prefix('counter')->group(function () {
	Route::prefix('organization')->group(function () {
		Route::get('/members', 'General\CounterController@members');
		Route::get('/articles', 'General\CounterController@articles');
		Route::get('/subscribers', 'General\CounterController@subscribers');
		Route::get('/messages', 'General\CounterController@messages');
		Route::get('/requests', 'General\CounterController@requests');
		Route::get('/posts/published', 'General\CounterController@published');
		Route::get('/posts/draft', 'General\CounterController@draft');
	});
});

Route::get('/region/country/{id}', 'General\RegionController@showCountryRegions')->where('id', '[0-9]+');
Route::get('/city/region/{id}', 'General\CityController@showRegionCities')->where('id', '[0-9]+');
Route::get('/city/country/{id}', 'General\CityController@showCountryCities')->where('id', '[0-9]+');
Route::get('/cities/{name}', 'General\CityController@cities');