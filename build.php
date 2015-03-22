<?php

	require 'vendor/autoload.php';
	
	$build = new TheKnarf\Buildphp\Build();

	$build->task('default', ['clean', 'doc'], function() {});

	$build->task('doc', function() {
		echo "Building php api documentation\n";
		$this->exec("./vendor/bin/phpdoc -d ./src -t ./docs");
	});

	$build->task('clean', function() {
		echo "Cleaning\n";
		$this->exec("rm -rf docs/");
	});

	$build();