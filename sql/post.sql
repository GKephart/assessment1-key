DROP TABLE IF EXISTS post;
-- the CREATE TABLE function is a function that takes tons of arguments to layout the table's schema
CREATE TABLE post (
	-- this creates the attribute for the primary key
	-- not null means the attribute is required!
	postId BINARY(16) NOT NULL,
	postAuthor VARCHAR(32),
	postContent VARCHAR(1024) NOT NULL,
	postDate  DATETIME(6),
	-- this officiates the primary key for the entity
	postTitle varchar(32)
	primary key(postId)
);
