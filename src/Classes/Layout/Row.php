<?php namespace Poppy\System\Classes\Layout;

use Illuminate\Contracts\Support\Renderable;

class Row implements Buildable, Renderable
{
	/**
	 * @var Column[]
	 */
	protected $columns = [];

	/**
	 * row classes.
	 *
	 * @var array
	 */
	protected $class = [];

	/**
	 * Row constructor.
	 *
	 * @param string $content
	 */
	public function __construct($content = '')
	{
		if (!empty($content)) {
			$this->column(12, $content);
		}
	}

	/**
	 * Add a column.
	 *
	 * @param int $width
	 * @param     $content
	 */
	public function column($width, $content)
	{
		$width = $width < 1 ? round(12 * $width) : $width;

		$column = new Column($content, $width);

		$this->addColumn($column);
	}

	/**
	 * Add class in row.
	 *
	 * @param array|string $class
	 */
	public function class($class)
	{
		if (is_string($class)) {
			$class = [$class];
		}

		$this->class = $class;

		return $this;
	}

	/**
	 * Build row column.
	 */
	public function build()
	{
		$this->startRow();

		foreach ($this->columns as $column) {
			$column->build();
		}

		$this->endRow();
	}

	/**
	 * Render row.
	 *
	 * @return string
	 */
	public function render()
	{
		ob_start();

		$this->build();

		$contents = ob_get_contents();

		ob_end_clean();

		return $contents;
	}

	/**
	 * @param Column $column
	 */
	protected function addColumn(Column $column)
	{
		$this->columns[] = $column;
	}

	/**
	 * Start row.
	 */
	protected function startRow()
	{
		$class   = $this->class;
		$class[] = 'layui-row';
		echo '<div class="' . implode(' ', $class) . '">';
	}

	/**
	 * End column.
	 */
	protected function endRow()
	{
		echo '</div>';
	}
}
