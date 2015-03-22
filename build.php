<?php

	require 'vendor/autoload.php';
	
	$build = new TheKnarf\Buildphp\Build();

	$build->task("doc", function() {
		echo "Building php api documentation\n";
		exec("./vendor/bin/phpdoc -d ./src -t ./docs");
	});

	$build->task("clean", function() {
		echo "Cleaning\n";
		exec("rm -rf docs/");
	});

	$build();