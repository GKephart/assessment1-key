DROP TABLE IF EXISTS post;
-- the CREATE TABLE function is a function that takes tons of arguments to layout the table's schema
CREATE TABLE post (
	-- this creates the attribute for the primary key
	-- auto_increment tells mySQL to number them {1, 2, 3, ...}
	-- not null means the attribute is required!
	postId BINARY(16) NOT NULL,
	postAuthor VARCHAR(32),
	postContent VARCHAR(1024) NOT NULL,
	postDate  DATETIME(6),
	-- to make sure duplicate data cannot exist, create a unique index
	profileEmail VARCHAR(128) NOT NULL,
	-- to make something optional, exclude the not null
	profileHash CHAR(97) NOT NULL,
	profilePhone VARCHAR(32),
	UNIQUE(profileEmail),
	UNIQUE(profileAtHandle),
	-- this officiates the primary key for the entity
primary key(postId);