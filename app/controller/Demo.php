<?php

namespace app\controller;
/**
 * 测试
 * Class Demo
 * @package app\controller
 */
class Demo extends \pms\Controller
{


    /**
     * @param $data
     */
    public function index($data)
    {
        $this->connect->send_succee([
            $data,
            "我是".SERVICE_NAME."分组",
            mt_rand(1,99999)
        ]);
    }

    public function index2()
    {

        $task_data = [
            'name' => 'ArticleCorrelationTx',
            'data' => [
                'server_name' => 'cms',
                'id' => '5',
                'type' => 'cms',
                'user_id' => '1',
            ],
            'tx_name' => 'ArticleCorrelation'
        ];
        $connect = $this->connect;
        $this->swoole_server->task($task_data, -1, function ($ser, $wid, $re) use ($connect) {
            var_dump($re);
            $connect->send_succee($re);
        });
    }


}