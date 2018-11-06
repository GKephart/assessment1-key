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
	private $quoteDate;

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
			$this->setQuoteDate($newPostDate);
			$this->setPostTitle($newPostTitle);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
	}

	/**
	 * accessor method for $postAuthor
	 * @return string value of post author.
	 */
	public function getPostAuthor(): string {
		return $this->postAuthor;
	}

	/**
	 * mutator method for postAuthor
	 * @param string $newPostAuthor mutator method for the new value of postAuthor.
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
	 * @return string value of post content
	 */
	public function getPostContent(): string {
		return $this->postContent;
	}

	/**
	 * mutator method for post content.
	 * @param string $newPostContent mutator method for the new value of postContent.
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
	 * @return \DateTime
	 */
	public function getQuoteDate(): \DateTime {
		return $this->quoteDate;
	}

	/**
	 * @param \DateTime $quoteDate
	 */
	public function setQuoteDate(\DateTime $quoteDate): void {
		$this->quoteDate = $quoteDate;
	}

	/**
	 * @return string
	 */
	public function getPostTitle(): string {
		return $this->postTitle;
	}

	/**
	 * @param string $postTitle
	 */
	public function setPostTitle(string $postTitle): void {
		$this->postTitle = $postTitle;
	}


}
