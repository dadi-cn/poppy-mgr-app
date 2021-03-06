<?php

namespace Poppy\MgrApp\Classes\Form;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Fluent;
use Illuminate\Support\MessageBag;
use Illuminate\Validation\Validator;
use Poppy\Framework\Classes\Traits\PoppyTrait;
use Poppy\Framework\Exceptions\ApplicationException;
use Poppy\Framework\Helper\ArrayHelper;
use Poppy\MgrApp\Classes\Form\Field\Actions;
use Poppy\MgrApp\Classes\Form\Field\Cascader;
use Poppy\MgrApp\Classes\Form\Field\Checkbox;
use Poppy\MgrApp\Classes\Form\Field\Code;
use Poppy\MgrApp\Classes\Form\Field\Color;
use Poppy\MgrApp\Classes\Form\Field\Currency;
use Poppy\MgrApp\Classes\Form\Field\Date;
use Poppy\MgrApp\Classes\Form\Field\DateRange;
use Poppy\MgrApp\Classes\Form\Field\Datetime;
use Poppy\MgrApp\Classes\Form\Field\DatetimeRange;
use Poppy\MgrApp\Classes\Form\Field\Decimal;
use Poppy\MgrApp\Classes\Form\Field\Divider;
use Poppy\MgrApp\Classes\Form\Field\Dynamic;
use Poppy\MgrApp\Classes\Form\Field\Editor;
use Poppy\MgrApp\Classes\Form\Field\Email;
use Poppy\MgrApp\Classes\Form\Field\EzTable;
use Poppy\MgrApp\Classes\Form\Field\File;
use Poppy\MgrApp\Classes\Form\Field\Image;
use Poppy\MgrApp\Classes\Form\Field\Ip;
use Poppy\MgrApp\Classes\Form\Field\Mobile;
use Poppy\MgrApp\Classes\Form\Field\Month;
use Poppy\MgrApp\Classes\Form\Field\MonthRange;
use Poppy\MgrApp\Classes\Form\Field\MultiFile;
use Poppy\MgrApp\Classes\Form\Field\MultiImage;
use Poppy\MgrApp\Classes\Form\Field\MultiSelect;
use Poppy\MgrApp\Classes\Form\Field\Number;
use Poppy\MgrApp\Classes\Form\Field\OnOff;
use Poppy\MgrApp\Classes\Form\Field\Password;
use Poppy\MgrApp\Classes\Form\Field\Radio;
use Poppy\MgrApp\Classes\Form\Field\Select;
use Poppy\MgrApp\Classes\Form\Field\Table;
use Poppy\MgrApp\Classes\Form\Field\Tags;
use Poppy\MgrApp\Classes\Form\Field\Text;
use Poppy\MgrApp\Classes\Form\Field\Textarea;
use Poppy\MgrApp\Classes\Form\Field\Time;
use Poppy\MgrApp\Classes\Form\Field\TimeRange;
use Poppy\MgrApp\Classes\Form\Field\Url;
use Poppy\MgrApp\Classes\Form\Field\Year;
use Poppy\MgrApp\Classes\Table\Column\Column;
use Poppy\MgrApp\Classes\Traits\UseQuery;
use function tap;

/**
 * Form Widget
 * @url https://element-plus.gitee.io/zh-CN/component/form.html#form-attributes
 * @method Table table($name, $label = '')
 * @method EzTable ezTable($name, $label = '')
 * @method Text text($name, $label = '')
 * @method Textarea textarea($name, $label = '')
 * @method Url url($name, $label = '')
 * @method Password password($name, $label = '')
 * @method Mobile mobile($name, $label = '')
 * @method Ip ip($name, $label = '')
 * @method Decimal decimal($name, $label = '')
 * @method Cascader cascader($name, $label = '')
 * @method Currency currency($name, $label = '')
 * @method Email email($name, $label = '')
 * @method Number number($name, $label = '')
 * @method Radio radio($name, $label = '')
 * @method Checkbox checkbox($name, $label = '')
 * @method Select select($name, $label = '')
 * @method MultiSelect multiSelect($name, $label = '')
 * @method Tags tags($name, $label = '')
 * @method Color color($name, $label = '')
 * @method Year year($name, $label = '')
 * @method Month month($name, $label = '')
 * @method Date date($name, $label = '')
 * @method Datetime datetime($name, $label = '')
 * @method Time time($name, $label = '')
 * @method DateRange dateRange($name, $label = '')
 * @method MonthRange monthRange($name, $label = '')
 * @method DatetimeRange datetimeRange($name, $label = '')
 * @method TimeRange timeRange($name, $label = '')
 * @method OnOff onOff($name, $label = '')
 * @method Image image($name, $label = '')
 * @method File file($name, $label = '')
 * @method MultiImage multiImage($name, $label = '')
 * @method MultiFile multiFile($name, $label = '')
 * @method Editor editor($name, $label = '')
 * @method Dynamic dynamic($name, $label = '')
 * @method Divider divider($label)
 * @method Code code($name, $label = '')
 * @method Actions actions($name, $label = '')
 */
class FormPlugin
{
    use PoppyTrait;
    use UseQuery;

    /**
     * ????????????
     * @var string
     */
    protected string $title = '';

    /**
     * ??????????????????????????????
     * @var Collection
     */
    protected Collection $items;

    /**
     * ????????????
     * @var array
     */
    protected array $model = [];

    /**
     * ????????????
     * @var Fluent
     */
    protected Fluent $attrs;

    /**
     * ???????????????
     * @var array
     */
    protected array $buttons = ['reset', 'submit'];


    /**
     * Form constructor.
     */
    public function __construct()
    {
        $this->attrs = new Fluent();
        $this->items = new Collection();

        // ????????????????????????, ????????????
        $this->attrs->offsetSet('label-width', 'auto');
    }


    /**
     * ????????????????????????????????? '50px'??? ?????? Form ?????????????????? form-item ?????????????????? ?????? auto
     * @param string $width
     */
    public function labelWidth(string $width)
    {
        $this->attrs->offsetSet('label-width', $width);
    }

    /**
     * Disable reset button.
     * @return $this
     */
    public function disableReset(): self
    {
        $this->buttons = ArrayHelper::delete($this->buttons, 'reset');
        return $this;
    }

    /**
     * Disable submit button.
     *
     * @return $this
     */
    public function disableSubmit(): self
    {
        $this->buttons = ArrayHelper::delete($this->buttons, 'submit');
        return $this;
    }


    /**
     * ??????????????????, ??????????????????, ?????????????????????
     * @return $this
     */
    public function inline(): self
    {
        $this->attrs->offsetSet('inline', true);
        $this->attrs->offsetSet('label-width', '');
        return $this;
    }


    /**
     * ?????????????????????????????????????????? ???????????? true??????????????????????????? disabled ??????????????????
     * @param bool $value
     * @return $this
     */
    public function disabled(bool $value): self
    {
        $this->attrs->offsetSet('disabled', $value);
        return $this;
    }

    /**
     * ????????????????????????
     * @param FormItem $item
     * @return $this
     */
    public function addItem(FormItem $item): self
    {
        $this->items->push($item);
        return $this;
    }

    /**
     * ???????????????????????????
     * @return FormItem[]|Collection
     */
    public function items($type = ''): Collection
    {
        if ($type === 'model') {
            return $this->items->filter(function (FormItem $item) {
                return $item->getToModel();
            });
        }
        return $this->items;
    }

    /**
     * Generate items and append to form list
     * @param string $method ??????
     * @param array $arguments ???????????????
     *
     * @return FormItem|$this
     * @throws ApplicationException
     */
    public function __call(string $method, array $arguments = [])
    {
        $name  = (string) Arr::get($arguments, 0);
        $label = (string) Arr::get($arguments, 1);
        $field = FieldDef::create($method, $name, $label);
        if (is_null($field)) {
            throw new ApplicationException("Field `${method}` not exists");
        }
        return tap($field, function ($field) {
            $this->addItem($field);
        });
    }

    /**
     * ?????????????????????
     * @param string $value
     * @return self
     */
    public function title(string $value): self
    {
        $this->title = $value;
        return $this;
    }


    /**
     * Validate this form fields.
     * @param array $input ?????????????????????
     * @return bool|MessageBag
     */
    public function validate(array $input = [])
    {
        $failed = [];

        foreach ($this->items() as $field) {
            if (!$validator = $field->getValidator($input)) {
                continue;
            }

            if (($validator instanceof Validator) && !$validator->passes()) {
                $failed[] = $validator;
            }
        }

        $messageBag = new MessageBag();
        foreach ($failed as $valid) {
            $messageBag = $messageBag->merge($valid->messages());
        }
        return $messageBag->any() ? $messageBag : false;
    }


    /**
     * ??????????????????????????????
     * @param $query
     * @return array
     */
    public function struct($query): array
    {
        $struct = [];
        if ($this->queryHas($query, 'depend')) {
            $use    = $this->queryAfter($query, 'depend');
            $name   = input('name', '');
            $params = (string) input('params');
            $values = (array) input('values');
            if ($use === 'attr') {
                $struct = FieldDef::fetchDependAttr($name, $params);
            }
            else {
                $struct = FieldDef::fetchDependField($name, $params, $values);
            }
        }
        if ($this->queryHas($query, 'frame')) {
            $struct = array_merge($struct, $this->frame());
        }
        if ($this->queryHas($query, 'data')) {
            $struct = array_merge($struct, [
                'model' => (object) $this->model(),
            ]);
        }
        return $struct;
    }

    /**
     * ????????????????????????
     * @return array
     */
    public function frame(): array
    {
        $items = new Collection();
        $this->items->each(function (FormItem $item) use ($items) {

            // ?????????????????????, ????????? Table ??????, ??????????????????
            if ($item instanceof Table) {
                $tableValues = data_get($this->model(), $item->name);
                $rows        = collect($tableValues)->map(function ($row) use ($item) {
                    $newRow = collect();
                    $item->getTable()->visibleCols()->each(function (Column $column) use ($row, $newRow) {
                        $newRow->put(
                            $column->name,
                            $column->fillVal($row)
                        );
                    });
                    return $newRow->toArray();
                });
                data_set($this->model, $item->name, $rows);
            }
            $struct = $item->struct();
            $items->push($struct);
        });
        return [
            'type'    => 'form',
            'title'   => $this->title,
            'buttons' => collect($this->buttons)->values(),
            'attr'    => (object) $this->attrs->toArray(),
            'items'   => $items->toArray(),
        ];
    }


    /**
     * ??????????????????
     * @return array
     */
    public function model(): array
    {
        return $this->model;
    }


    /**
     * Fill data to form fields.
     *
     * @param array $data
     * @return $this
     */
    public function fill(array $data = []): self
    {
        if (!empty($data)) {
            $this->model = $data;
        }

        return $this;
    }
}
