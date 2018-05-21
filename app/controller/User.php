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
        $sn = $this->getData('sn');
        $server = new \app\logic\User();

        $info = $server->manuscript($this->user_id, $type, $sn);
        if (is_array($info)) {
            $this->connect->send_succee($info);
        } else {
            $this->connect->send_error($info);
        }
    }


}