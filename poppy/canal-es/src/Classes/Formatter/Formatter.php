<?php

declare(strict_types = 1);

namespace Poppy\CanalEs\Classes\Formatter;

abstract class Formatter implements FormatInterface
{
    /**
     * @var mixed $item
     */
    protected $item;

    /**
     * @param $values
     * @return $this
     */
    public function setValues($values): self
    {
        $this->item = $values;

        return $this;
    }
}