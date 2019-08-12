<?php

namespace Fullstack\Assessment;

use Ramsey\Uuid\Uuid;

require_once("autoload.php");

/**
 * Straight foreword php Class. The class instantiates and is error free .
 *
 **/
class Todo implements \JsonSerializable {
	use ValidateDate;
	use ValidateUuid;

	/**
	 * Primary key (uuid v4) for the quote.
	 * @var Uuid $todoId
	 */
	private $todoId;

	/**
	 * author for the quote.
	 * @var string $todoAuthor
	 **/
	private $todoAuthor;
	
	/**
	 * Date for the quote.
	 * @var \DateTime $todoDate
	 **/
	private $todoDate;

	/**
	 * title for the quote
	 * @var string $todoTask
	 */
	private $todoTask;


	/**
	 * todo constructor.
	 *
	 * @param string|Uuid $newTodoId unsanitized uuid v4  passed to the settodoId() method.
	 * @param string $newTodoAuthor unsanitized value passed to the settodoAuthor() method.
	 * @param \DateTime $newTodoDate unsanitized value passed to the settodoDate() method.
	 * @param string $newTodoTask unsanitized value passed to the settodoTask() method.
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds (e.g., strings too long, negative integers)
	 * @throws \TypeError if data types violate type hints
	 * @throws \Exception if some other exception occurs
	 * @Documentation https://php.net/manual/en/language.oop5.decon.php
	 **/
	public function __construct($newTodoId, string $newTodoAuthor, $newTodoDate, string $newTodoTask) {

		try {
			$this->setTodoId($newTodoId);
			$this->setTodoAuthor($newTodoAuthor);
			$this->setTodoDate($newTodoDate);
			$this->setTodoTask($newTodoTask);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
	}

	/**
	 * accessor method for todoId
	 * @return Uuid value of todoId
	 **/
	public function getTodoId(): Uuid {
		return $this->todoId;
	}

	/**
	 * @param $newTodoId string|Uuid new uuid v4 value of todoId
	 * @throws \RangeException if $newTweetId is not positive
	 * @throws \TypeError if $newTweetId is not a uuid or string
	 * @throws \TypeError if data types violate type hints
	 * @throws \Exception if some other exception occurs
	 */
	public function setTodoId($newTodoId): void {

		try {
			$uuid = self::validateUuid($newTodoId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}

		$this->todoId = $uuid;
	}

	/**
	 * accessor method for todoAuthor
	 * @return string value of todoAuthor.
	 */
	public function gettodoAuthor(): string {
		return $this->todoAuthor;
	}

	/**
	 * mutator method for todoAuthor
	 * @param string $newTodoAuthor new value for todoAuthor.
	 * @throws \InvalidArgumentException if the todoAuthor is empty or insecure.
	 * @throws \RangeException if the todoAuthor is longer than 24 characters.
	 *
	 */
	public function setTodoAuthor(string $newTodoAuthor): void {

		$newTodoAuthor = trim($newTodoAuthor);
		$newTodoAuthor = filter_var($newTodoAuthor, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newTodoAuthor) === true) {
			throw(new \InvalidArgumentException("todo author is empty or insecure"));
		}

		if(strlen($newTodoAuthor) > 24) {
			throw(new \RangeException("todo author is too large"));
		}


		$this->todoAuthor = $newTodoAuthor;
	}


	/**
	 * accessor method for todoDate.
	 * @return \DateTime value of todoDate
	 **/
	public function getTodoDate(): \DateTime {
		return $this->todoDate;
	}

	/**
	 * mutator method for todoDate
	 * @param \DateTime $newTodoDate new value for todoDate
	 * @throws \InvalidArgumentException if newTodoDate is not a valid object
	 * @throws \RangeException if newTodoDate is not a valid datetime
	 * @throws \TypeError if data types violate type hints
	 * @throws \Exception if some other exception occurs
	 *
	 */
	public function setTodoDate($newTodoDate): void {

		// store the like date using the ValidateDate trait
		try {
			$newTodoDate = self::ValidateDateTime($newTodoDate);
		} catch(\InvalidArgumentException | \RangeException $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}

		$this->todoDate = $newTodoDate;
	}

	/**
	 *accessor method for todoTask
	 * @return string value of todoTask
	 */
	public function getTodoTask(): string {
		return $this->todoTask;
	}

	/**
	 * @param string $newTodoTask new value for todoTask.
	 * @throws \InvalidArgumentException if the todoTask is empty or insecure.
	 * @throws \RangeException if the todoTask is longer than 24 characters.
	 *
	 */
	public function setTodoTask(string $newTodoTask): void {

		$newTodoTask = trim($newTodoTask);
		$newTodoTask = filter_var($newTodoTask, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

		if(empty($newTodoTask) === true) {
			throw(new \InvalidArgumentException("todo title is empty or insecure"));
		}

		if(strlen($newTodoTask) > 24) {
			throw(new \RangeException("todo title is too large"));
		}
		$this->todoTask = $newTodoTask;
	}

	/**
	 * inserts the todo into mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function insert(\PDO $pdo) {

		$query = "INSERT INTO todo	(todoId, todoAuthor, todoDate, todoTask)  VALUES (:todoId, :todoAuthor, :todoDate, :todoTask)";
		$statement = $pdo->prepare($query);

		$parameters = ["todoId" => $this->todoId->getBytes(), "todoAuthor" => $this->todoAuthor, "todoDate" => $this->todoDate->format("Y-m-d H:i:s.u"),"todoTask" => $this->todoTask];
		$statement->execute($parameters);
	}

	/**
	 * gets the todo by todoId
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param string|Uuid $todoId tweet id to search for
	 * @return todo|null Todo found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when a variable are not the correct data type
	 **/
	public static function getTodoByTodoId(\PDO $pdo, $todoId): ?todo {
		// sanitize the tweetId before searching
		try {
			$todoId = self::validateUuid($todoId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}

		// create query template
		$query = "SELECT todoId, todoAuthor, todoDate, todoTask  FROM todo WHERE todoId = :todoId";
		$statement = $pdo->prepare($query);

		// bind the tweet id to the place holder in the template
		$parameters = ["todoId" => $todoId->getBytes()];
		$statement->execute($parameters);

		// grab the tweet from mySQL
		try {
			$todo = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$todo = new todo($row["todoId"], $row["todoAuthor"], $row["todoDate"], $row["todoTask"]);
			}
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return ($todo);
	}

	/**
	 * gets the todo by todoAuthor
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param string $todoAuthor profile id to search by
	 * @return \SplFixedArray SplFixedArray of Tweets found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getTodosByTodoAuthor(\PDO $pdo, string $todoAuthor): \SPLFixedArray {

		$todoAuthor = trim($todoAuthor);
		$todoAuthor = filter_var($todoAuthor, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

		// escape any mySQL wild cards
		$todoAuthor = str_replace("_", "\\_", str_replace("%", "\\%", $todoAuthor));

		// create query template
		$query = "SELECT todoId, todoAuthor, todoDate, todoTask  FROM todo WHERE todoAuthor LIKE :todoAuthor";
		$statement = $pdo->prepare($query);

		// bind the tweet profile id to the place holder in the template
		$todoAuthor = "%$todoAuthor";
		$parameters = ["todoAuthor" => $todoAuthor];
		$statement->execute($parameters);
		// build an array of tweets
		$todos = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$todo = new todo($row["todoId"], $row["todoAuthor"],  $row["todoDate"], $row["todoTask"]);
				$todos[$todos->key()] = $todo;
				$todos->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($todos);
	}
	
	/**
	 * formats the state variables for JSON serialization
	 *
	 * @return array resulting state variables to serialize
	 **/
	public function jsonSerialize() {
		$fields = get_object_vars($this);
		$fields["todoDate"] = round(floatval($this->gettodoDate()->format("U.u") * 1000));
		return ($fields);
	}
}
