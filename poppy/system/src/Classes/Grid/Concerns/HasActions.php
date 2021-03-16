<?php

namespace Poppy\System\Classes\Grid\Concerns;

use Closure;
use Illuminate\Config\Repository;
use Poppy\System\Classes\Grid;

trait HasActions
{
    /**
     * Callback for grid actions.
     *
     * @var Closure
     */
    protected $actionsCallback;

    /**
     * Actions column display class.
     *
     * @var string
     */
    protected $actionsClass;

    /**
     * Set grid action callback.
     *
     * @param Closure|string $actions
     *
     * @return $this
     */
    public function actions($actions)
    {
        if ($actions instanceof Closure) {
            $this->actionsCallback = $actions;
        }

        return $this;
    }

    /**
     * Get action display class.
     *
     * @return Repository|mixed|string
     */
    public function getActionClass()
    {
        if ($this->actionsClass) {
            return $this->actionsClass;
        }

        if ($class = config('admin.grid_action_class')) {
            return $class;
        }

        return Grid\Displayer\Actions::class;
    }

    /**
     * @param string $actionClass
     *
     * @return $this
     */
    public function setActionClass(string $actionClass)
    {
        if (is_subclass_of($actionClass, Grid\Displayer\Actions::class)) {
            $this->actionsClass = $actionClass;
        }

        return $this;
    }

    /**
     * Set grid batch-action callback.
     *
     * @param Closure $closure
     *
     * @return $this
     */
    public function batchActions(Closure $closure)
    {
        $this->tools(function (Grid\Tools $tools) use ($closure) {
            $tools->batch($closure);
        });

        return $this;
    }

    /**
     * @param bool $disable
     *
     * @return Grid|mixed
     */
    public function disableBatchActions(bool $disable = true)
    {
        $this->tools->disableBatchActions($disable);

        return $this->option('show_row_selector', !$disable);
    }
}
