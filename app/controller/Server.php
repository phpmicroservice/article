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
        $user_id = $this->getData('user_id');
        $server_name = $this->connect->f;
        $Logic = new \app\logic\Article();
        $re = $Logic->correlation($user_id, $id, $type, $server_name);
        $this->send($re);
    }


    /**
     * 验证,是否存在可关联文章
     */
    public function validation()
    {
        $id = $this->getData('id');
        $type = $this->getData('type');
        $user_id = $this->getData('user_id');
        $server_name = $this->connect->f;
        $Logic = new \app\logic\Article();
        output([$user_id, $id, $type, $server_name], '37');
        $re = $Logic->validation($user_id, $id, $type, $server_name);
        $this->send($re);
    }

    public function info()
    {

    }


}