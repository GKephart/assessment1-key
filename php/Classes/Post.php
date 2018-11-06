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
	 * @return string value of the post author.
	 */
	public function getPostAuthor(): string {
		return $this->postAuthor;
	}

	/**
	 * mutator method for postAuthor
	 * @param string $postAuthor mutator method for the new value of postAuthor.
	 */
	public function setPostAuthor(string $postAuthor): void {
		$this->postAuthor = $postAuthor;
	}

	/**
	 *
	 * @return string
	 */
	public function getPostContent(): string {
		return $this->postContent;
	}

	/**
	 * @param string $postContent
	 */
	public function setPostContent(string $postContent): void {
		$this->postContent = $postContent;
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
