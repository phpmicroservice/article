<?php


namespace app\controller;


use app\Controller;

class Article extends Controller
{
    
    /**
     * 保存草稿，文章
     */
    public function save_article()
    {
        $id = $this->getData('id');
        $content = $this->getData('content');
        $server = new \app\logic\User();
        $re = $server->save_article($this->user_id, $id, $content);
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