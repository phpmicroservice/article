<?php

namespace app\logic;

use app\Base;
use app\model\article;
use app\validation\UserSaveArticle;
use app\validator\Savearticleauth;
use pms\Output;
use pms\Validation;

class User extends Base
{

    /**
     * 临时鉴权的文章修改
     * @param $user_id
     * @param $id
     * @param $content
     */
    public function save_article_auth($user_id, $id, $content,$auth)
    {
        $data=[
            'user_id'=>$user_id,
            'id'=>$id,
            'content'=>$content,
            'auth'=>$auth
        ];
        $va=new Validation();
        $va->add_Validator('user_id',[
            'name'=>Savearticleauth::class,
            'message'=>'Savearticleauth'
        ]);
        if(!$va->validate($data)){
            return $va->getErrorMessages();
        }
        $model = article::findFirst($data['id']);
        $model->content = $data['content'];
        if (!$model->save()) {
            \pms\output($model->getMessages(), '113');
            return 'save_error';
        }
        return true;

    }

    /**
     * 获取草稿
     * @param $user_id
     * @param $type
     */
    public function manuscript($user_id, $type, $sn)
    {
        $type=strtolower($type);
        $sn=strtolower($sn);
        $model = article::findFirst([
            'user_id = :user_id: and status =0 and type =:type: and server_name =:server_name:',
            'bind' => [
                'user_id' => $user_id,
                'type' => $type,
                'server_name' => $sn
            ]
        ]);
        if ($model instanceof article) {
            # 存在为使用的草稿
        } else {
            # 创建新的草稿,
            # 创建一个集合
            $data = [
                'user_id' => $user_id,
                'remark' => '备注',
                'only' => 0
            ];
            $re = $this->proxyCS->request_return('file', '/server/create_array', $data);
            if (is_array($re) && !$re['e'] && is_int($re['d'])) {
                # 符合返回结果
                $model = new article();
                $model->setData([
                        'content' => base64_encode(' '),
                        'create_time' => time(),
                        'update_time' => time(),
                        'status' => 0,
                        'attachment' => $re['d'],
                        'is_del' => 0,
                        'type' => $type,
                        'user_id' => $user_id,
                        'server_name' => $sn
                    ]
                );

                # 保存信息
                if (!$model->save()) {
                    Output::debug($model->getMessage());
                    return 'save-error';
                }
                $re = $this->set_attachment($re['d']);
                if (!$re) {
                    Output::debug(['76', $re]);
                    return 'set_attachment';
                }
            } else {
                \pms\output($re, 55);
                return 'request_error';
            }
        }
        return $model->toArray();
    }

    /**
     * 设置附件使用状态
     */
    private function set_attachment($index)
    {
        $re = $this->proxyCS->request_return('file', '/server/array_status01', [
            'index' => $index
        ]);
        if (is_array($re) && !$re['e']) {
            return $re['d'];
        }
        return false;

    }

    /**
     * 保存文章草稿信息
     * @param $user_id
     * @param $id
     * @param $content
     */
    public function save_article($user_id, $id, $content)
    {

        $data = [
            'user_id' => $user_id,
            'id' => $id,
            'content' => $content
        ];


        $ft = new \app\filterTool\UserSaveArticle();
        $ft->filter($data);
        \pms\output($data, 22);
        $va = new UserSaveArticle();
        if (!$va->validate($data)) {
            return $va->getMessages();
        }
        $model = article::findFirst([
            'id=:id: and user_id = :user_id:',
            'bind' => [
                'user_id' => $data['user_id'],
                'id' => $data['id']
            ]
        ]);
        $model->content = $data['content'];
        if (!$model->save()) {
            \output($model->getMessages(), '113');
            return 'save_error';
        }
        return true;
    }

}