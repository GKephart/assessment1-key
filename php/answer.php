<?php

require_once("./Classes/autoload.php");

use Captains\Interview\Post;

try {
	$object = new Post("George", "is a", new DateTime(), "dumb dumb");
	echo(json_encode($object) . PHP_EOL);
} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
	echo $exception->getMessage() . PHP_EOL;
	echo $exception->getLine() .PHP_EOL;

}
