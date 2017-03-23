CREATE database IF NOT EXISTS cogjob CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE cogjob;

GRANT ALL PRIVILEGES ON cogjob.* TO 'cogjob_user'@'localhost' IDENTIFIED BY 'secret';
