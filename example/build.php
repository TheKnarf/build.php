<?php

	require 'vendor/autoload.php';
	//require 'src/build.php';

	

	$build = new TheKnarf\Buildphp\Build();

	$build->task("default", array("test"), function() {
		echo "Default\n";
	});

	$build->task("test", function() {
		echo "Hello\n";
	});

	$build->run();