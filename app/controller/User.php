<?php

namespace app\controller;

use app\Controller;
use app\logic\Article;

/**
 * 用户相关
 * Class User
 * @package app\controller
 */
class User extends Controller
{
    /**
     * 草稿
     */
    public function manuscript()
    {
        $type = $this->getData('type');
        $server = new \app\logic\User();
        $info = $server->manuscript($this->user_id, $type);
        if (is_array($info)) {
            $this->connect->send_succee($info);
        } else {
            $this->connect->send_error($info);
        }
    }

    /**
     * 保存草稿，文章
     */
    public function save_article()
    {
        $id = $this->getData('id');
        $content = $this->getData('content');
        $server = new Article();
        $re = $server->save_article($this->user_id, $id, $content);
        $this->connect->send_succee($re);
    }

}