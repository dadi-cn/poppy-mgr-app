<?php

namespace Poppy\MgrApp\Classes\Filter\Query;

use Illuminate\Support\Arr;
use Poppy\MgrApp\Classes\Filter\Traits\AsDatetime;
use Poppy\MgrApp\Classes\Filter\Traits\AsSelect;
use Poppy\MgrApp\Classes\Filter\Traits\AsText;
use Poppy\MgrApp\Classes\Form\Traits\UseOptions;
use Poppy\MgrApp\Classes\Form\Traits\UsePlaceholder;

class Gte extends FilterItem
{

    use AsSelect, AsText, AsDatetime,
        UsePlaceholder,
        UseOptions;

    /**
     * Get condition of this filter.
     *
     * @param array $inputs
     *
     * @return array|mixed|void
     */
    public function condition(array $inputs)
    {
        $this->defaultValue($inputs);

        $value = (string) $this->value;
        if ($value === '') {
            return null;
        }

        $value = $this->value;

        switch ($this->type) {
            case 'datetime':
                // 获取格式化属性中的类型
                $type  = $this->attr['type'] ?? 'datetime';
                $start = $this->getStartFrom($value, $type);
                return $this->buildCondition([
                    [$this->name, '>=', trim($start)],
                ]);
            case 'text':
            default:
                return $this->buildCondition($this->name, '>=', $this->value);
        }


    }

    public function struct(): array
    {
        $struct            = parent::struct();
        $struct['options'] = array_merge(
            $struct['options'] ?? [], [
                'prepend' => '大于等于'
            ]
        );
        return $struct;
    }
}
