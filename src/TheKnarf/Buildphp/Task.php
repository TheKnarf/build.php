<?php 
	namespace TheKnarf\Buildphp;

	use Colors\Color;

	class Task
	{
		private $dependencies = array();

		private $function;

		public function __construct(\Closure $func, $deps=array()) {
			$this->dependencies = $deps;
			$this->function = $func->bindTo($this, $this);
		}

		public function __invoke() {
			return call_user_func_array(
				$this->function,
				func_get_args()
			);
		}

		public function getDependencies() {
			return $this->dependencies;
		}

		private function exec($command) {
			$c = new Color();
			echo $c('Executing: ' . $command)->black()->highlight("white") . PHP_EOL;

			exec($command);
		}
	}