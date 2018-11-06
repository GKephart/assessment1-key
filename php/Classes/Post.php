<?php

namespace Captains\Interview;


/**
 * Straight foreword php Class. The class instantiates and is error free but my need some modifications.
 *
 **/

class Post {
	use ValidateDate;

	/**
	 * author for the quote.
	 * @var string $postAuthor
	 **/
	private $postAuthor;

	/**
	 * Content for the quote.
	 * @var string $postContent
	 */
	private $postContent;

	/**
	 * Date for the quote.
	 * @var \DateTime $postDate
	 **/
	private $postDate;

	/**
	 * title for the quote
	 * @var string $postTitle
	 */
	private $postTitle;


	/**
	 * Post constructor.
	 *
	 * @param string $newPostAuthor unsanitized value passed to the setPostAuthor() method.
	 * @param string $newPostContent unsanitized value passed to the setPostContent() method.
	 * @param \DateTime $newPostDate unsanitized value passed to the setPostDate() method.
	 * @param string $newPostTitle unsanitized value passed to the setPostTitle() method.
	 *
	 **/
	public function __construct( string $newPostAuthor, string $newPostContent, \DateTime $newPostDate, string $newPostTitle ) {

		try{
			$this->setPostAuthor($newPostAuthor);
			$this->setPostContent($newPostContent);
			$this->setPostDate($newPostDate);
			$this->setPostTitle($newPostTitle);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
	}

	/**
	 * accessor method for $postAuthor
	 * @return string value of postAuthor.
	 */
	public function getPostAuthor(): string {
		return $this->postAuthor;
	}

	/**
	 * mutator method for postAuthor
	 * @param string $newPostAuthor new value for postAuthor.
	 * @throws \InvalidArgumentException if the post author is empty or insecure.
	 * @throws \RangeException if the postAuthor is longer than 24 characters.
	 */
	public function setPostAuthor(string $newPostAuthor): void {

		if(empty($newPostAuthor) === true) {
			throw(new \InvalidArgumentException("tweet content is empty or insecure"));
		}

		if(strlen($newPostAuthor) > 24) {
			throw(new \RangeException("tweet content too large"));
		}


		$this->postAuthor = $newPostAuthor;
	}

	/**
	 * accessor method for postContent.
	 *
	 * @return string value of postContent
	 */
	public function getPostContent(): string {
		return $this->postContent;
	}

	/**
	 * mutator method for post content.
	 * @param string $newPostContent new value for postContent.
	 * @throws \InvalidArgumentException if the post content is empty or insecure.
	 * @throws \RangeException if the post content is longer than 1024 characters.
	 */
	public function setPostContent(string $newPostContent): void {

		if(empty($newPostContent) === true) {
			throw(new \InvalidArgumentException("tweet content is empty or insecure"));
		}

		if(strlen($newPostContent) > 1024) {
			throw(new \RangeException("tweet content too large"));
		}

		$this->postContent = $newPostContent;
	}

	/**
	 * accessor method for post date.
	 * @return \DateTime value of postDate
	 **/
	public function getPostDate(): \DateTime {
		return $this->postDate;
	}

	/**
	 * mutator method for post date
	 * @param \DateTime $newPostDate new value for postDate
	 * @throws \InvalidArgumentException if newPostDate is not a valid object
	 * @throws \RangeException if newPostDate is not a valid datetime
	 *
	 */
	public function setPostDate(\DateTime $newPostDate): void {

		// store the like date using the ValidateDate trait
		try {
			$newPostDate = self::ValidateDate($newPostDate);
		} catch(\InvalidArgumentException | \RangeException $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}

		$this->postDate = $newPostDate;
	}

	/**
	 *accessor method for postTitle
	 * @return string value of postTitle
	 */
	public function getPostTitle(): string {
		return $this->postTitle;
	}

	/**
	 * @param string $newPostTitle new value for post title.
	 * @throws \InvalidArgumentException if the postTitle is empty or insecure.
	 * @throws \RangeException if the postTitle is longer than 24 characters.
	 *
	 */
	public function setPostTitle(string $newPostTitle): void {
		if(empty($newPostTitle) === true) {
			throw(new \InvalidArgumentException("tweet content is empty or insecure"));
		}

		if(strlen($newPostTitle) > 24) {
			throw(new \RangeException("tweet content too large"));
		}
		$this->postTitle = $newPostTitle;
	}


}
