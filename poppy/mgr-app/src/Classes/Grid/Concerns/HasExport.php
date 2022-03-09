<?php

namespace Poppy\MgrApp\Classes\Grid\Concerns;

use Poppy\MgrApp\Classes\Grid\Exporter;
use Poppy\MgrApp\Classes\Grid\Exporters\AbstractExporter;
use Poppy\MgrApp\Classes\Grid\Tools\ExportButton;
use function request;

trait HasExport
{

    /**
     * Export driver.
     *
     * @var string
     */
    protected $exporter;


    /**
     * 是否显示导出按钮
     */
    public function isShowExporter(): bool
    {
        return $this->option('show_exporter');
    }

    /**
     * Disable export.
     *
     * @param bool $disable
     * @return $this
     */
    public function disableExporter(bool $disable = true): self
    {
        return $this->option('show_exporter', !$disable);
    }

    /**
     * Render export button.
     *
     * @return string
     */
    public function renderExportButton(): string
    {
        return (new ExportButton($this))->render();
    }


    /**
     * Set exporter driver for Grid to export.
     *
     * @param $exporter
     *
     * @return $this
     */
    public function exporter($exporter): self
    {
        $this->exporter = $exporter;

        return $this;
    }

    /**
     * Get the export url.
     *
     * @param int  $scope
     * @param null $args
     *
     * @return string
     */
    public function getExportUrl($scope = 1, $args = null): string
    {
        $input = array_merge(request()->all(), Exporter::formatExportQuery($scope, $args));

        if ($constraints = $this->model()->getConstraints()) {
            $input = array_merge($input, $constraints);
        }

        return $this->resource() . '?' . http_build_query($input);
    }

    /**
     * Handle export request.
     *
     * @param bool $forceExport
     */
    protected function queryExport($forceExport = false)
    {
        if (!$scope = request(Exporter::QUERY_NAME)) {
            return;
        }

        // clear output buffer.
        if (ob_get_length()) {
            ob_end_clean();
        }

        $this->model()->usePaginate(false);

        if ($forceExport) {
            $this->getExporter($scope)->export();
        }
    }

    /**
     * @param string $scope
     *
     * @return AbstractExporter
     */
    protected function getExporter($scope)
    {
        return (new Exporter($this))->resolve($this->exporter)->withScope($scope);
    }
}
