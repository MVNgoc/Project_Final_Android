CREATE DATABASE IF NOT EXISTS `user` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE `user`;

CREATE TABLE `tbl_position` (
  `id` int(11) NOT NULL COMMENT 'position_id',
  `position` varchar(255) DEFAULT NULL COMMENT 'position_text'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `tbl_position` (`id`, `position`) VALUES
(1, 'Admin'),
(2, 'Manager'),
(3, 'User');

CREATE TABLE `account` (
  `id` varchar(15) NOT NULL,
  `username` varchar(64) NOT NULL,
  `password` varchar(255) NOT NULL,
  `firstname` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `lastname` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `positionid` int(2) NOT NULL,
  `department_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `phone_number` varchar(15) NOT NULL,
  `day_off` int(3) NOT NULL
);


INSERT INTO `account` (`id`, `username`, `password`, `firstname`, `lastname`, `positionid`, `department_name`, `email`,`phone_number`, `day_off`) VALUES
('51900147', 'mvngoc288', '$2a$12$1WrrCnXcKA.XcP2iKp9PIuX748AAKID3m3HGT8QykuDJvP7HRExcW', 'Mai', 'Văn Ngọc', 1, 'Kế toán', 'mvngoc@gmail.com', '0337375401', 15);

ALTER TABLE `tbl_position`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `tbl_position`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'position_id', AUTO_INCREMENT=4;

ALTER TABLE `account`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

ALTER TABLE `account`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
COMMIT;
