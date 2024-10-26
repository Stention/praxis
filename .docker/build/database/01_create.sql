CREATE TABLE `users` (
    `id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `username` VARCHAR(32) NOT NULL UNIQUE KEY,
    `password` VARCHAR(255) NOT NULL,
    `role` VARCHAR(16) NOT NULL DEFAULT 'guest'
) ENGINE=InnoDB CHARSET=utf8;

INSERT INTO `users` (`id`, `username`, `password`, `role`) VALUES
(1, 'eliska.kremlova@seznam.cz', '$2y$10$CdOICBJyRPB2.UaYo9sA7uKX7C79Eh7MOUl8hnWyHcy3uo940f38e', 'admin');

CREATE TABLE `products` (
    `id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `created` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `product_name` VARCHAR(32) NOT NULL UNIQUE KEY,
    `dentamed_url` VARCHAR(255) NOT NULL,
    `dentamed_product_code` VARCHAR(255) NOT NULL,
    `medplus_url` VARCHAR(255) NOT NULL,
    `medplus_product_code` VARCHAR(255) NOT NULL,
    `image` VARCHAR(255) NOT NULL
) ENGINE=InnoDB CHARSET=utf8;

-- CREATE TABLE `prices` (
--     `id` INT(11) AUTO_INCREMENT PRIMARY KEY,
--     `created` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
--     `product_id` INT(11) NOT NULL,
--     `partner` VARCHAR(255) NOT NULL,
--     `amount` DECIMAL(10, 2) NOT NULL,
--     FOREIGN KEY (product_id) REFERENCES products(id)
-- );