<?php

namespace app\logic;

use app\Base;

class Article extends Base
{
    /**
     * 验证是否可以关联
     * @param $user_id
     * @param $id
     * @param $type
     * @param $server_name
     * @return bool
     */
    public function validation($user_id, $id, $type, $server_name)
    {
        $model = \app\model\article::findFirst([
            "id =:id: and type =:type: and server_name =:server_name: and user_id=:user_id: ",
            'bind' => [
                'id' => $id,
                'type' => $type,
                'server_name' => $server_name,
                'user_id' => $user_id
            ]
        ]);
        if ($model instanceof \app\model\article) {
            # 正确的
            if ($model->status == 0) {
                return true;
            }
        }
        return false;

    }

    /**
     * 对文章进行关联
     * @param $id
     * @param $type
     * @param $server_name
     */
    public function correlation($user_id, $id, $type, $server_name)
    {
        $model = \app\model\article::findFirst([
            "id =:id: and type =:type: and server_name =:server_name: and user_id=:user_id: ",
            'bind' => [
                'id' => $id,
                'type' => $type,
                'server_name' => $server_name,
                'user_id' => $user_id
            ]
        ]);
        if ($model instanceof \app\model\article) {
            # 正确的
        } else {
            return false;
        }
        $model->status = 1;
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


    /**
     * 文章信息
     * @param $id
     * @param $type
     * @param $sever_name
     */
    public function infos($id, $server_name)
    {
        $model = \app\model\article::findFirst([
            'id = :id: and server_name =:server_name:',
            'bind' => [
                'id' => $id,
                'server_name' => $server_name
            ]
        ]);
        if ($model instanceof \app\model\article) {
            return $model->toArray();
        }
        return false;
    }


}