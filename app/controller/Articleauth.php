<?php

namespace app\controller;

use app\Controller;

/**
 * 临时鉴权的文章操作
 * Class Articleauth
 * @package app\controller
 */
class Articleauth extends Controller
{
    
    /**
     * 保存草稿，文章
     */
    public function save_article()
    {
        $id = $this->getData('id');
        $content = $this->getData('content');
        $auth = $this->getData('auth');
        $server = new \app\logic\User();
        $re = $server->save_article_auth($this->user_id, $id, $content,$auth);
        $this->send($re);
    }



    /**
     * 文章信息
     */
    public function info_article()
    {
        $id = $this->getData('id');
        $type = $this->getData('type');
        $server = new \app\logic\Article();
        $re = $server->info_article($id, $type);
        $this->connect->send_succee($re);
    }

}