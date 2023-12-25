CREATE DATABASE IF NOT EXISTS `moonshine_blog`;
CREATE DATABASE IF NOT EXISTS `moonshine_blog_test`;

CREATE USER IF NOT EXISTS 'moonshine_blog'@'%' IDENTIFIED BY '12345';

GRANT ALL PRIVILEGES ON `moonshine_blog`.* TO 'moonshine_blog'@'%';
GRANT ALL PRIVILEGES ON `moonshine_blog_test`.* TO 'moonshine_blog'@'%';

GRANT SELECT  ON `information\_schema`.* TO 'moonshine_blog'@'%';
FLUSH PRIVILEGES;

SET GLOBAL time_zone = 'Europe/Moscow';
