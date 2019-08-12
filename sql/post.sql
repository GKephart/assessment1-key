DROP TABLE IF EXISTS todo;
-- the CREATE TABLE function is a function that takes tons of arguments to layout the table's schema


CREATE TABLE todo (
	todoId BINARY(16) NOT NULL,
	todoAuthor VARCHAR(32),
	todoDate  DATETIME(6),
	todoTask varchar(256),
	primary key(todoId)
	);