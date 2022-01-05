CREATE DATABASE IF NOT EXISTS user DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE user;

CREATE TABLE tbl_position (
  id int(11) NOT NULL COMMENT 'position_id',
  position varchar(255) DEFAULT NULL COMMENT 'position_text'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO tbl_position (id, position) VALUES
(1, 'Manager'),
(2, 'User'),
(3, 'Admin');

CREATE TABLE account (
  id varchar(15) NOT NULL,
  username varchar(64) NOT NULL,
  pass varchar(255) NOT NULL,
  sex varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  firstname varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  lastname varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  positionid int(2) NOT NULL,
  department_name varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  email varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  phone_number varchar(15) NOT NULL,
  day_off int(3),
  avatar varchar(255) COLLATE utf8_unicode_ci NOT NULL
);

CREATE TABLE department (
  id varchar(15) NOT NULL,
  department_name varchar(64) NOT NULL,
  manager_name varchar(64) COLLATE utf8_unicode_ci,
  department_description varchar(255) NOT NULL,
  room_number varchar(64) NOT NULL
);

CREATE TABLE task (
  id varchar(15) NOT NULL,
  task_title varchar(64) NOT NULL COLLATE utf8_unicode_ci,
  task_description varchar(64) NOT NULL COLLATE utf8_unicode_ci,
  start_time datetime COLLATE utf8_unicode_ci NOT NULL,
  deadline datetime NOT NULL,
  staff_assign varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  task_status varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  task_deliver varchar(64) COLLATE utf8_unicode_ci NOT NULL
);

CREATE TABLE taskfile (
  id varchar(15) NOT NULL,
  name_task_file varchar(64) NOT NULL COLLATE utf8_unicode_ci
);

CREATE TABLE leaveform (
  username varchar(64) NOT NULL,
  leavetype varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  leavereson varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  star_date date NOT NULL,
  end_date date NOT NULL,
  date_applied date NOT NULL,
  leave_status varchar(30) NOT NULL DEFAULT 'Đang đợi', 
  day_left int(2) NOT NULL,
  day_use int(2) NOT NULL,
  uploadd_file varchar(255) COLLATE utf8_unicode_ci
);

INSERT INTO account (id, username, pass, sex, firstname, lastname, positionid, department_name, email,`phone_number`, day_off, avatar) VALUES
('51900147', 'admin', '$2a$12$8CtP3.iNTmGI.j7J/gipzuo.GByjjRX7dhaGasw/dME80d71tuQN6', 'Nam', 'Mai', 'Văn Ngọc', 3, 'Marketing', 'mvngoc@gmail.com', '0337375401', null, ''),
('51900145', 'hungnghia', '$2a$12$jJDsE0y3FCZDBfQHUUJBVuikkJ.DQtMBlaRoH9kj2dhETTeBUssD.', 'Nam', 'Phạm', 'Hùng Nghĩa', 1, 'Marketing', 'hungnghia@gmail.com', '0337375402', 15, ''),
('51900200', 'thanhson', '$2a$12$B1IIlvosaj6uXvSDAQypGepQKbaSCRHgtw5bYT1I3z/FbYmKvVWyS', 'Nam', 'Nguyễn', 'Thanh Sơn', 2, 'Marketing', 'thanhson@gmail.com', '0337375403', 12, '');

INSERT INTO department (id, department_name, manager_name, department_description, room_number) VALUES
('19050202', 'Marketing', '', 'Có làm thì mới có ăn', 'I402');

ALTER TABLE tbl_position
  ADD PRIMARY KEY (id);

ALTER TABLE tbl_position
  MODIFY id int(11) NOT NULL AUTO_INCREMENT COMMENT 'position_id', AUTO_INCREMENT=4;

ALTER TABLE account
  ADD PRIMARY KEY (id),
  ADD UNIQUE KEY email (email);

ALTER TABLE account
  MODIFY id int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

ALTER TABLE department
  ADD PRIMARY KEY (id),
  ADD UNIQUE KEY department_name (department_name);

ALTER TABLE department
  MODIFY id int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

ALTER TABLE task
  ADD PRIMARY KEY (id);

ALTER TABLE task
  MODIFY id int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

ALTER TABLE taskfile
  ADD PRIMARY KEY (id);

ALTER TABLE taskfile
  MODIFY id int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

ALTER TABLE leaveform
  ADD PRIMARY KEY (username);
COMMIT;