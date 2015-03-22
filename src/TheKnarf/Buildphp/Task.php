<?php 
	namespace TheKnarf\Buildphp;

	class Task
	{
		private $dependencies = array();

		private $function;

		public function __construct($func, $deps=array()) {
			$this->dependencies = $deps;
			$this->function = $func;
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
	}