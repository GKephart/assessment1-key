<?php

namespace Captains\Interview;


/**
 * Straight foreword php Class. The class instantiates and is ebut my need some modifications.
 * The goal of the challenge is to json encode the object.
 **/

class Quote {
	use ValidateDate;

	/**
	 * author for the quote.
	 * @var string $quoteAuthor
	 **/
	private $quoteAuthor;

	/**
	 * Content for the quote.
	 * @var string $quoteContent
	 */
	private $quoteContent;

	/**
	 * Date for the quote.
	 * @var \DateTime $quoteDate
	 **/
	private $quoteDate;

	/**
	 * title for the quote
	 * @var string $quoteTitle
	 */
	private $quoteTitle;


}
