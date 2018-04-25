<?php


use App\Http\Models\Category;
use App\Http\Models\Notification;
use App\Http\Models\Page;
use App\Http\Models\Event;

// used to recreate missing slugs
Route::get("/create-slug", function(){
    $events = Event::all();
    foreach ($events as $key => $value) {
        $value->sluggify();
        $value->save();
    }

    return Redirect::to("/");
});

Route::get('/', 'HomeController@home');
Route::get("/category/{id}", "HomeController@category");

// social login
Route::get("login/{provider}", "SocialLoginController@social");

// finish registration
Route::post("/finish-registration/{id}", "SocialLoginController@finishRegistration");

Route::get("/hashtag/{hashtag}", "PostsController@byHashtag");

// users
Route::get("/login", "UsersController@login");
Route::post("/login", "UsersController@postLogin");
Route::get("/signup", "UsersController@signup");
Route::post("/signup", "UsersController@postSignup");
Route::post("/clearLogin", "UsersController@clearLogin");
Route::post("/updatePosition", "UsersController@updatePosition");

Route::post("/allusers", "UsersController@allUsers");

Route::get("/validate", ["as" => "validate", "uses" => "UsersController@getValidate"]);

Route::get("/logout", "UsersController@logout");
Route::get("/users/{username}", "UsersController@show");
Route::group(["middleware" => "auth"], function(){
    Route::post("/users/upload/background", "UsersController@uploadBackground");
    Route::post("/users/upload/avatar", "UsersController@uploadAvatar");
});
Route::resource("users", "UsersController");

// events
Route::get("/events/{event}/going/{answer}", "EventsController@isGoing");
Route::post("/events/loadInviteModal", "EventsController@loadInviteModal");
Route::post("/events/selectedUsers", "EventsController@selectedUsers");
Route::post("events/invite/{event}", "EventsController@invite");
Route::post("/events/user/search", "EventsController@search");
Route::post("/post/uploadImage", "EventsController@uploadImage");
Route::get("/planner", "EventsController@upcoming");
Route::get("/planner/past", "EventsController@past");
Route::get("/planner/time", "EventsController@timeFilter");
Route::get("/planner/category/{category}", "EventsController@byCategory");
Route::post("/events/massmessage/{id}", "EventsController@massMessage");
Route::resource("events", "EventsController");
Route::get("events/{id}/{slug?}", "EventsController@show");

// images
Route::get("event/images/{id}", "ImagesController@index");
Route::get("image/{id}", "ImagesController@show");

Route::group(["middleware" => "auth"], function(){

    // posts
    Route::get("/post/{id}/delete", "PostsController@delete");
    Route::post("/post/image", "PostsController@uploadImage");
    Route::resource("posts", "PostsController");

    // comments
    Route::post("/comments/delete/{id}", "CommentsController@delete");
    Route::resource("comments", "CommentsController");

    // circles
    Route::post("/circles/exit/{id}/{user}", "CirclesController@exitCircle");
    Route::get("/circles/find", "CirclesController@findpeople");
    Route::post("circles/add", "CirclesController@addUser");
    Route::get("/circles/{id}/delete", "CirclesController@delete");
    Route::resource("circles", "CirclesController");

    // settings
    Route::get("/settings", "SettingsController@index");
    Route::post("/settings/email", "SettingsController@email");
    Route::get("/settings/confirmEmail", ["as" => "confirmEmail", "uses" => "SettingsController@confirmEmail"]);
    Route::post("settings/password", "SettingsController@password");
    Route::post("settings/passwordCreate", "SettingsController@passwordCreate");

    Route::get("/notifications", "NotificationsController@index");
    Route::post("/notifications", "NotificationsController@seenNotification");

    // conversations - messages
    Route::get("/conversations/create/{username}", ["as" => "conversation-create", "uses" => "ConversationsController@create"]);
    Route::post("/conversations/message", "ConversationsController@storeMessage");
    Route::resource("conversations", "ConversationsController");

    // my events
    Route::get("/myevents", "EventsController@myevents");

    // invites
    Route::get("/invites", "InvitesController@index");
    Route::post("/invites", "InvitesController@invite");
});

// search
Route::get("/search", "SearchController@search");

// pages
Route::get("/page/{id}", "PagesController@show");

Route::group(["middleware" => "admin", "namespace" => "Admin", "prefix" => "admin"], function(){

    // admin home page
    Route::get("/getStats", "AdminController@getStats");
    Route::get("/fetchData", "AdminController@fetchData");
    Route::get("/", "AdminController@index");

    // users
    Route::get("/users/trash", "UsersController@trash");
    Route::get("/users/trash/{id}/restore", "UsersController@restore");
    Route::get("/users/{id}/ban", "UsersController@ban");
    Route::get("/users/{id}/unban", "UsersController@unban");
    Route::resource("users", "UsersController");

    // posts
    Route::get("/posts/trash", "PostsController@trash");
    Route::get("/posts/{id}/restore", "PostsController@restore");
    Route::resource("posts", "PostsController");

    // events
    Route::get("/events/trash", "EventsController@trash");
    Route::get("/events/{id}/restore", "EventsController@restore");
    Route::resource("events", "EventsController");

    // settings
    Route::post("/settings", "SettingsController@store");
    Route::post("/settings/email", "SettingsController@storeEmail");
    Route::post("/settings/predefined", "SettingsController@storePredefinedEmail");
    Route::get("/settings/ads", "SettingsController@getAds");
    Route::get("/settings/email", "SettingsController@getEmailSettings");
    Route::get("/settings/predefined", "SettingsController@getPredefinedEmail");
    Route::get("/settings/services", "SettingsController@getServices");
    Route::post("/settings/services", "SettingsController@storeServices");
    Route::get("/settings", "SettingsController@index");

    // translation
    Route::get("/translation/front", "TranslationController@front");
    Route::post("/translation/front", "TranslationController@storeFront");
    Route::get("/translation/admin", "TranslationController@admin");
    Route::post("/translation/admin", "TranslationController@storeAdmin");
    Route::get("/translation/validation", "TranslationController@validation");
    Route::post("/translation/validation", "TranslationController@storeValidation");

    // pages
    Route::get("/pages/trash", "PagesController@trash");
    Route::get("/pages/trash/{id}", "PagesController@restore");
    Route::resource("pages", "PagesController");

    // comments
    Route::get("/comments/trash", "CommentsController@trash");
    Route::get("/comments/{id}/restore", "CommentsController@restore");
    Route::resource("comments", "CommentsController");

    // categories
    Route::resource("categories", "CategoriesController");
});

// contact
Route::get("/contact", "ContactController@getContact");
Route::post("/contact", "ContactController@contact");

View::composer("layouts.partials.categories", function($view){
    $categories = Category::all();
    return $view->with("categories", $categories);
});

View::composer("circles.main", function($view){
    $circles = Auth::user()->circles;
    return $view->with("circles", $circles);
});

View::composer("layouts.main", function($view){
    $data = DB::table("event_guests")->groupBy("event_id")->orderBy(DB::raw("count(event_id)"), "desc")->lists("event_id");

    $events = Event::where("type", "=", "public")->whereIn("id", $data)->orderBy("date", "desc")->take(5)->get();
    return $view->with("events", $events);
});

View::composer("layouts.partials.footer", function($view){
    $pages = Page::all();

    return $view->with("pages", $pages);
});

View::composer("layouts.partials.top", function($view){
    if(Auth::user()) {
        $notifications = Notification::where("target_id", "=", Auth::user()->id)->where("seen", "=", 0)->get();
        $unreadNotif = count(Notification::where("target_id", "=", Auth::user()->id)->where("seen", "=", 0)->get());

        $conversations = Auth::user()->conversations;


        return $view
            ->with("notifications", $notifications)
            ->with("unreadNotif", $unreadNotif)
            ->with("conversations", $conversations);
    }
});