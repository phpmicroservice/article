<?php


namespace app\logic;


use app\Base;

class Article extends Base
{
    /**
     * 对文章进行关联
     * @param $id
     * @param $type
     * @param $server_name
     */
    public function correlation($id, $type, $server_name)
    {
        $model = \app\model\article::findFirst([
            "id =:id: and type =:type: and server_name =:server_name: ",
            'bind' => [
                'id' => $id,
                'type' => $type,
                'server_name' => 'null'
            ]
        ]);
        if ($model instanceof \app\model\article) {
            # 正确的
        } else {
            return false;
        }
        $model->server_name = $server_name;
        if (!$model->save()) {
            return false;
        }
        return true;
    }


    /**
     * 文章信息
     * @param $id
     * @param $type
     * @param $sever_name
     */
    public function info_article($id, $type)
    {
        $model = \app\model\article::findFirst([
            'id = :id: and type =:type:',
            'bind' => [
                'id' => $id,
                'type' => $type
            ]
        ]);
        if ($model instanceof \app\model\article) {
            return $model->toArray();
        }
        return false;
    }

}