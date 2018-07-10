<?php

namespace app\task;

use app\model\tmdemo;
use pms\Task\Task;
use pms\Task\TaskInterface;

class DemoTx extends TxTask implements TaskInterface
{

    public function end()
    {

    }

    protected function b_dependenc()
    {

    }

    protected function logic(): bool
    {
        $data = $this->trueData;
        $md = new tmdemo();
        return $md->save([
            'name' => $data['data']['name'],
            'title' => $data['xid']
        ]);
    }

}