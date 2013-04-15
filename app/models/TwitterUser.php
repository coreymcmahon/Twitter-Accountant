<?php

class TwitterUser extends Eloquent {

    protected $table = 'twitter_users';

    private $twitterApi;

    public function getFollowers()
    {
        $this->initialiseApi();

        $this->twitterApi->request(
            'GET',
            $this->twitterApi->url('1/followers/ids'),
            $this->getIdentifierArray()
        );

        $code = $this->twitterApi->response['code'];
        if ($code == 200)
            return json_decode($this->twitterApi->response['response'], true)['ids'];

        throw new Exception('Request failed. Error code [' . $code . ']');
    }

    public function getFriends()
    {
        $this->initialiseApi();

        $this->twitterApi->request(
            'GET',
            $this->twitterApi->url('1/friends/ids'),
            $this->getIdentifierArray()
        );

        $code = $this->twitterApi->response['code'];
        if ($code == 200)
            return json_decode($this->twitterApi->response['response'], true)['ids'];

        throw new Exception('Request failed. Error code [' . $code . ']');
    }

    public static function findMe()
    {
        $results = self::where('twitter_id', '=', (int)Config::get('app.twitter_id'))->take(1)->get();

        if(!isset($results[0])) return false;

        return $results[0];
    }

    private function getIdentifierArray()
    {
        if ($this->twitter_id !== null) return array('user_id' => $this->twitter_id);
        if ($this->username !== null) return array('screen_name' => $this->username);
        return array();
    }

    private function initialiseApi()
    {
        if ($this->twitterApi === null)
            $this->twitterApi = new \tmhOAuth(Config::get('app.twitter_api'));
    }
}