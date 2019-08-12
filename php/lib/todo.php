<?php

require_once(dirname(__DIR__) . "/Classes/autoload.php");
require_once("/etc/apache2/capstone-mysql/Secrets.php");

use Fullstack\Assessment\Todo;

$secrets =  new \Secrets("/etc/apache2/capstone-mysql/assessment.ini");
$pdo = $secrets->getPdoObject();

try {

	//create the todo object
	$object = new Todo("9bfacccd-75fe-413e-9886-2bf4e0d7f89e","George",  new DateTime(), "is a dumb dumb");

	//insert the todo object into the database
	$object->insert($pdo);

	//grab the object out of the database
	var_dump(Todo::getTodoByTodoId($pdo, $object->getTodoId()));

} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
	echo $exception->getMessage() . PHP_EOL;
	echo $exception->getLine() .PHP_EOL;
}

