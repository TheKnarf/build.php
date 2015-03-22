<?php

	require 'vendor/autoload.php';
	
	$build = new TheKnarf\Buildphp\Build();

	$build->task("doc", function() {
		echo "Building php api documentation\n";
		exec("./vendor/bin/phpdoc -d ./src -t ./docs");
	});

	$build->task("clear", function() {
		echo "Clearing\n";
		exec("rm -rf docs/");
	});

	$build->run();