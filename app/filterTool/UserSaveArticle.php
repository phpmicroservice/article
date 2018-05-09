<?php

namespace app\filterTool;

use app\filter\Content;

class UserSaveArticle extends \pms\FilterTool\FilterTool
{
    protected function initialize()
    {
        $this->_Filter->add('content', new Content());
        $this->_Rules = [
            ['content' => 'content']
        ];
    }

}