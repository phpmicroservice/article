<?php

namespace app\model;

/**
 * 文章模型
 * Class article
 * @package app\model
 */
class article extends \pms\Mvc\Model
{
    protected $_append_field = ['content_source'];
    public function afterFetch()
    {
       #content
        $this->content_source=base64_decode($this->content);
    }

}