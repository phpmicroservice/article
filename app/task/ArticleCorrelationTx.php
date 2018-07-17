<?php
/**
 * Created by PhpStorm.
 * User: toplink_php1
 * Date: 2018/7/11
 * Time: 14:27
 */

namespace app\task;

/**
 * 文章关联事务
 * Class ArticleCorrelationTx
 * @package app\task
 */
class ArticleCorrelationTx extends \pms\Task\TxTask
{

    public function end()
    {

    }

    protected function b_dependenc()
    {

    }

    /**
     *  事务逻辑
     */
    protected function logic(): bool
    {
        $data = $this->getData();
        $model = \app\model\article::findFirst([
            "id =:id: and type =:type: and server_name =:server_name: and user_id=:user_id: ",
            'bind' => [
                'id' => $data['id'],
                'type' => $data['type'],
                'server_name' => $data['server_name'],
                'user_id' => $data['user_id']
            ]
        ]);
        if ($model instanceof \app\model\article) {
            # 正确的
        } else {
            return false;
        }
        if ($model->status == 1) {
            return false;
        }
        $model->status = 1;
        if (!$model->save()) {
            return false;
        }
        return true;
    }

}