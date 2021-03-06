<?php 
	namespace TheKnarf\Buildphp;

	use Colors\Color;

	class Build
	{
		private $tasks;

		private function runTaskDependencies($name) {
			$deps = $this->tasks->getTask($name)->getDependencies();

			foreach($deps as $dep) {
				$this->runDependingTasksAndThenTask($dep);
			}
		}

		private function runDependingTasksAndThenTask($name) {
			$this->runTaskDependencies($name);

			// Run task with name: $name
			$c = new Color();
			echo $c('Running task: ' . $name)->green()->bold() . PHP_EOL;
			$task = $this->tasks->getTask($name);
			$task(); 
		}

		public function __construct() {
			$this->tasks = new Tasklist();
		}

		public function task($name, $depsOrFunc, $func=null) {
			// If you only have 2 arguments, then the second argument is the function
			if($func == null) {
				$task = new Task($depsOrFunc);
			}
			else {
				$task = new Task($func, $depsOrFunc);
			}

			// Add the task to the task list
			$this->tasks->addTask($name, $task);
		}

		public function runTask($name = "default") {
			// List all tasks for autocompletion
			if($name == "--cmplt") {
				$taskNames = $this->tasks->allTaskNames();
				echo implode("\n", $taskNames) . "\n";

				return;
			}

			if($this->tasks->taskExists($name)) {
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

		public function __invoke() {
			$this->run();
		}
	}