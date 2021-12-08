<?php

namespace Poppy\MgrApp\Form\Field;

class Image extends File
{
    public function __construct(string $name, string $label)
    {
        parent::__construct($name, $label);
        $this->image();
    }
}
