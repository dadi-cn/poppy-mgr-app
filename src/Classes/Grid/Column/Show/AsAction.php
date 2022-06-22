<?php

namespace Poppy\MgrApp\Classes\Grid\Column\Show;

use Closure;
use Poppy\MgrApp\Classes\Grid\Column\Render\ActionsRender;

trait AsAction
{
    /**
     * 调用 Actions 预览定义的操作
     */
    public function asAction(Closure $cb): self
    {
        $name       = $this->name;
        $this->type = 'actions';
        return $this->display(function ($value) use ($cb, $name) {
            $render = new ActionsRender($value, $this, $name);
            return $render->render($cb);
        });
    }
}
