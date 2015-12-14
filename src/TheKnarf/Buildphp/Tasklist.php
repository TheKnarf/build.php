<?php 
	namespace TheKnarf\Buildphp;

	class Tasklist
	{
		private $tasks = array();

		private function processTaskName($name) {
			return strtolower($name);
		}

		public function addTask($name, Task $task) {
			$name = $this->processTaskName($name);
			$this->tasks[$name] = $task;
		}

		public function getTask($name) {
			$name = $this->processTaskName($name);
			return $this->tasks[$name];
		}

		public function taskExists($name) {
			$name = $this->processTaskName($name);
			return isset($this->tasks[$name]);
		}

		public function allTaskNames() {
			return array_keys($this->tasks);
		}
	}