CREATE USER 'docker_php_batch_user'@'%' IDENTIFIED BY 'docker_php_batch_pass';
GRANT ALL PRIVILEGES ON docker_php_batch_db.* TO 'docker_php_batch_user'@'%' WITH GRANT OPTION;
FLUSH PRIVILEGES;
