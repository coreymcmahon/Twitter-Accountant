<?php

class HomeController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	public function showWelcome()
	{
        $twitterUsers = TwitterUser::all();
        return View::make('TwitterUsers.index', array('twitter_users' => $twitterUsers));
	}

    public function showUpdate()
    {
        $now = new \DateTime();
        $now = $now->getTimestamp();


        $me = TwitterUser::findMe();

        if (!$me) {
            $me = new TwitterUser();
            $me->username = Config::get('app.twitter_username');
            $me->twitter_id = Config::get('app.twitter_id');
            $me->last_update = $now;
            $me->save();
        }

        $followers = $me->getFollowers();
        foreach ($followers as $followerId) {
            $follower = TwitterUser::where('twitter_id', (int)$followerId)->first();
            if (!$follower) {
                $follower = new TwitterUser();
                $follower->twitter_id = $followerId;
                $follower->is_following_you = true;
                $follower->is_followed_by_you = false;
                $follower->last_update = $now;
            } else {
                $follower->is_following_you = true;
                $follower->last_update = $now;
            }
            $follower->save();
        }
        // where is_following_me AND id NOT IN ($followers), update, log it!

        $friends = $me->getFriends();
        foreach ($friends as $friendId) {
            $friend = TwitterUser::where('twitter_id', (int)$friendId)->first();
            if (!$friend) {
                $friend = new TwitterUser();
                $friend->twitter_id = $friendId;
                $friend->is_following_you = false;
                $friend->is_followed_by_you = true;
                $friend->last_update = $now;
            } else {
                $friend->is_followed_by_you = true;
                $friend->last_update = $now;
            }
            $friend->save();
        }
        // where is_followed_by_me AND id NOT IN ($friends), update, log it!
    }

}