# CREATE TABLE `user` (
#     `id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
#     `username` VARCHAR(32) NOT NULL UNIQUE KEY,
#     `password` VARCHAR(255) NOT NULL,
#     `role` VARCHAR(16) NOT NULL DEFAULT 'guest'
# ) ENGINE=InnoDB CHARSET=utf8;
#
# INSERT INTO `user` (`id`, `username`, `password`, `role`) VALUES
# (1, 'test', 'test', 'admin');
