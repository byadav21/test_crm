CREATE TABLE  `session_call` (
 `id` INT( 11 ) NOT NULL AUTO_INCREMENT ,
 `session_id` TEXT NOT NULL ,
 `call_start` DATETIME NOT NULL ,
 `lead_id` CHAR( 36 ) NOT NULL ,
PRIMARY KEY (  `id` )
);
