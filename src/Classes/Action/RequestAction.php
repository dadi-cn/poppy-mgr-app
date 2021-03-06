<?php

namespace Poppy\MgrApp\Classes\Action;

/**
 * 请求操作
 */
final class RequestAction extends Action
{

    /**
     * Action  渲染
     * @return array
     */
    public function struct(): array
    {
        return array_merge(parent::struct(), [
            'method' => 'request'
        ]);
    }
}
