<?php


namespace app\controller;


use app\Controller;

class Server extends Controller
{

    /**
     * 对文章进行服务关联
     */
    public function correlation()
    {
        $id = $this->getData('id');
        $type = $this->getData('type');
        $server_name = $this->connect->f;
        $Logic = new \app\logic\Article();
        $re = $Logic->correlation($id, $type, $server_name);
        $this->send($re);
    }


}