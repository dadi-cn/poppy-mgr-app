<?php

namespace Poppy\MgrApp\Grid\Tools;

use Illuminate\Contracts\Support\Renderable;
use Poppy\MgrApp\Widgets\GridWidget;

abstract class BatchAction implements Renderable
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $title;

    /**
     * @var string
     */
    protected $resource;

    /**
     * @var GridWidget
     */
    protected $grid;

    /**
     * @param $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * Set title for this action.
     *
     * @param string $title
     *
     * @return $this
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param GridWidget $grid
     */
    public function setGrid(GridWidget $grid)
    {
        $this->grid = $grid;

        $this->resource = $grid->resource();
    }

    /**
     * @return string
     */
    public function getToken()
    {
        return csrf_token();
    }

    /**
     * @param bool $dotPrefix
     *
     * @return string
     */
    public function getElementClass($dotPrefix = true)
    {
        return sprintf(
            '%s%s-%s',
            $dotPrefix ? '.' : '',
            $this->grid->getGridBatchName(),
            $this->id
        );
    }

    /**
     * @return string
     */
    public function render()
    {
        return $this->title;
    }

    /**
     * @return mixed
     */
    abstract public function script();
}
