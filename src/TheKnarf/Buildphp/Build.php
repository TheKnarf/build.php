<?php 
	namespace TheKnarf\Buildphp;

	class Build
	{
		private $tasks = array();

		private function processTaskName($name) {
			return strtolower($name);
		}

		private function addTask($name, Buildtask $task) {
			$name = $this->processTaskName($name);
			$this->tasks[$name] = $task;
		}

		private function getTask($name) {
			$name = $this->processTaskName($name);
			return $this->tasks[$name];
		}

		private function runTaskWithName($name) {
			$task = $this->getTask($name);
			$task(); 
		}

		private function runTaskDependencies($name) {
			$deps = $this->getTask($name)->getDependencies();

			foreach($deps as $dep) {
				$this->runDependingTasksAndThenTask($dep);
			}
		}

		private function runDependingTasksAndThenTask($name) {
			$this->runTaskDependencies($name);
			$this->runTaskWithName($name);
		}

		public function task($name, $depsOrFunc, $func=null) {
			// If you only have 2 arguments, then the second argument is the function
			if($func == null) {
				$task = new Buildtask($depsOrFunc);
			}
			else {
				$task = new Buildtask($func, $depsOrFunc);
			}

			// Add the task to the task list
			$this->addTask($name, $task);
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