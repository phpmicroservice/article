<?php
namespace app\validator;

use pms\Validation\Validator;
use app\model\article;
/**
 * 保存文章的临时鉴权验证
 */
class Savearticleauth extends Validator
{
    public function validate(\Phalcon\Validation $validation, $attribute)
    {
        $id=$validation->getValue('id');
        $auth=$validation->getValue('auth');
        $user_id=$validation->getValue('user_id');
        $model=article::findFirst($id);
        $proxyCS= \Phalcon\Di::getDefault()->get('proxyCS');
        if($model instanceof article){
            $data=[
                'auth'=>$auth,
                'user_id'=>$user_id,
                'type'=>$model->type,
                'id'=>$model->id
            ];
            $re =$proxyCS->request_return($model->server_name,
                '/verify/article_edit',$data);
            if(!is_array($re)){
                # 出错
                $this->type= 'request-error';
                return  $this->appendMessage($validation,$attribute);
            }
            if($re['e']){
                $this->type= $re['m'];
                return  $this->appendMessage($validation,$attribute);
            }
            return true;
        }else{
            $this->type= 'empty-info';
            return  $this->appendMessage($validation,$attribute);
        }
    }

}