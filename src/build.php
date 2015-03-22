<?php 
	namespace theknarf\build_php;

	class Build
	{
		private $tasks = array();

		private function processTaskName($name) {
			return strtolower($name);
		}

		private function addTask($name, $dep, $func) {
			$name = $this->processTaskName($name);

			$this->tasks[$name] = array(
				"func" => $func,
				"dep" => $dep
			);
		}

		private function getTaskFunction($name) {
			$name = $this->processTaskName($name);
			return $this->tasks[$name]['func'];
		}

		private function getTaskDep($name) {
			$name = $this->processTaskName($name);
			return $this->tasks[$name]['dep'];
		}

		private function runTaskWithName($name) {
			$task = $this->getTaskFunction($name);
			$task(); 
		}

		private function runTaskDependencies($name) {
			$deps = $this->getTaskDep($name);

			foreach($deps as $dep) {
				$this->runDependingTasksAndThenTask($dep);
			}
		}

		private function runDependingTasksAndThenTask($name) {
			$name = $this->processTaskName($name);

			$this->runTaskDependencies($name);
			$this->runTaskWithName($name);
		}

		public function task($name, $depOrFunc, $func=null) {
			// If you only have 2 arguments, then the second argument is the function
			if($func == null) {
				// Add the task to the task list
				$this->addTask($name, array(), $depOrFunc);
			}
			else {
				// Add the task to the task list
				$this->addTask($name, $depOrFunc, $func);
			}
		}

		public function runTask($name = "default") {
			if(isset($this->tasks[$name])) {
				return $this->runDependingTasksAndThenTask($name);
			} else {
				echo "No task with name ($name) found\n";
			}
		}

		public function run() {
			global $argv;

			if(isset($argv[1])) {
				$this->runTask($argv[1]);
			}
			else
			{
				$this->runTask();		
			}
		}
	}