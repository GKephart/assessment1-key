<?php

namespace Fullstack\Assessment\Test;

use Fullstack\Assessment\Todo;

// grab the class under scrutiny
require_once(dirname(__DIR__) . "/autoload.php");
require_once ("AssessmentTest.php");

// grab the uuid generator
require_once(dirname(__DIR__, 2) . "/lib/uuid.php");
require_once(dirname(__DIR__, 3) . "/vendor/autoload.php");



/**
 * Full PHPUnit test for the Todo class
 *
 * This is a complete PHPUnit test of the Todo class. It is complete because *ALL* mySQL/PDO enabled methods
 * are tested for both invalid and valid inputs.
 *
 * @see \GKephart\Assessment\Todo
 * @author Dylan McDonald <dmcdonald21@cnm.edu>
 **/
class TodoTest extends AssessmentTest {

	/**
	 * valid todo author to create the todo  object
	 * @var string $VALID_TODO
	 */
	private $VALID_TODO_AUTHOR = "GKephart";

	/**
	 * valid todo content to create the todo  object
	 * @var string $VALID_TODO_CONTENT
	 */
	private $VALID_TODO_CONTENT = "Nice Things";

	/**
	 * valid todo date to create the todo  object
	 * @var \DateTime $VALID_TODO_DATE
	 */
	private $VALID_TODO_DATE;

	/**
	 * valid todo to create the todo  object
	 * @var $VALID_TODO_TASK
	 */
	private $VALID_TODO_TASK = "Cant have";

	public final function setUp()  : void {
		// run the default setUp() method first
		parent::setUp();
		$this->VALID_TODO_DATE = new \DateTime();
	}

	public function testInsertValidTodo() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("todo");

		$todo = new Todo(generateUuidV4(), $this->VALID_TODO_AUTHOR, $this->VALID_TODO_DATE, $this->VALID_TODO_TASK);
		var_dump($todo);
		$todo->insert($this->getPDO());

		$pdoTodo = Todo::getTodoByTodoId($this->getPDO(), $todo->getTodoId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("todo"));
		$this->assertEquals($pdoTodo->getTodoId(), $todo->getTodoId());
		$this->assertEquals($pdoTodo->getTodoAuthor(), $this->VALID_TODO_AUTHOR);
		$this->assertEquals($pdoTodo->getTodoDate(), $this->VALID_TODO_DATE);
		$this->assertEquals($pdoTodo->getTodoTask(), $this->VALID_TODO_TASK);
	}

	public function testGetValidTodoByTodoAuthor() {

		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("todo");

		$todo = new Todo(generateUuidV4(), $this->VALID_TODO_AUTHOR, $this->VALID_TODO_DATE, $this->VALID_TODO_TASK);
		$todo->insert($this->getPDO());

		$results = Todo::getTodosByTodoAuthor($this->getPDO(), $todo->getTodoAuthor());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("todo"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("GKephart\\Assessment\\Todo", $results);

		$pdoTodo = $results[0];
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("todo"));
		$this->assertEquals($pdoTodo->getTodoId(), $todo->getTodoId());
		$this->assertEquals($pdoTodo->getTodoAuthor(), $this->VALID_TODO_AUTHOR);
		$this->assertEquals($pdoTodo->getTodoDate(), $this->VALID_TODO_DATE);
		$this->assertEquals($pdoTodo->getTodoTask(), $this->VALID_TODO_TASK);
	}
}