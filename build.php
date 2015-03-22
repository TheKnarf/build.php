<?php

	require 'vendor/autoload.php';
	
	$build = new TheKnarf\Buildphp\Build();

	$build->task('default', ['clean', 'doc'], function() {});

	$build->task('doc', function() {
		$this->exec("./vendor/bin/phpdoc -d ./src -t ./docs");
	});

	$build->task('clean', function() {
		$this->exec("rm -rf docs/");
	});

	$build();