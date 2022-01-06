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
  start_time datetime NOT NULL,
  deadline datetime NOT NULL,
  staff_assign varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  task_status varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  message_task varchar(255) COLLATE utf8_unicode_ci,
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
  uploadd_file varchar(255) COLLATE utf8_unicode_ci,
  date_num int(2) NOT NULL
);

CREATE TABLE leaverequest(
  username varchar(64) NOT NULL,
  day_left int(2) NOT NULL,
  day_use int(2) NOT NULL
);

-- Password Admin account : 123456789
INSERT INTO account (id, username, pass, sex, firstname, lastname, positionid, department_name, email,`phone_number`, day_off, avatar) VALUES
('51900147', 'admin', '$2a$12$8CtP3.iNTmGI.j7J/gipzuo.GByjjRX7dhaGasw/dME80d71tuQN6', 'Nam', 'Mai', 'Văn Ngọc', 3, 'Tổng giám đốc', 'mvngoc@gmail.com', '0337375401', null, ''),
('51900145', 'hungnghia', '$2a$12$jJDsE0y3FCZDBfQHUUJBVuikkJ.DQtMBlaRoH9kj2dhETTeBUssD.', 'Nam', 'Phạm', 'Hùng Nghĩa', 2, 'Marketing', 'hungnghia@gmail.com', '0337375402', 12, ''),
('51900200', 'thanhson', '$2a$12$B1IIlvosaj6uXvSDAQypGepQKbaSCRHgtw5bYT1I3z/FbYmKvVWyS', 'Nam', 'Nguyễn', 'Thanh Sơn', 2, 'Marketing', 'thanhson@gmail.com', '0337375403', 12, ''),
('51902145', 'huyentrang', '$2a$12$HzII9PIk6U3xzWcfAbPB3uLe5egMkwHUFPqYJn.tA2i9VsV9XfsYu', 'Nữ', 'Lê', 'Huyền Trang', 1, 'Marketing', 'huyentrang@gmail.com', '0979805412', 15, ''),
('51482300', 'trunghau', '$2a$12$zxB2X0HPGdax6CGC/7xdj.5oFzKXIgUiW9BEsaEL0L..A9dLdbp0q', 'Nam', 'Nguyễn', 'Trung Hậu', 2, 'Marketing', 'trunghau@gmail.com', '0255478964', 12, ''),
('21685200', 'tankhai', '$2a$12$mtTRRQHsA3wgFeT1oR0Q3.Q.fa2Evd3rsNKAjAGqbFe5x/sf0C40u', 'Nam', 'Tô', 'Tấn Khải', 2, 'Marketing', 'tankhai@gmail.com', '0456823149', 12, ''),
('20681365', 'chanhdai', '$2a$12$LSENdqWZwvDr/aOstYhG2eliP8BYx.d/T8I0Av2gXQ74r7HP0MVcK', 'Nam', 'Nguyễn', 'Chánh Đại', 1, 'SEO', 'chanhdai@gmail.com', '475962145', 15, ''),
('46340523', 'bichngoc', '$2a$12$A/rppViMiI5wmNfsn5yDGOHR/Ir/.4B7/dCy0H/DmH/38HIFKLaAC', 'Nữ', 'Vũ', 'Thị Bích Ngọc', 2, 'SEO', 'bichngoc@gmail.com', '0352847361', 12, ''),
('50850778', 'sylong', '$2a$12$x3jGDmHsHtjOfxvC7bh.POQQXiZN7XkdcYQ7wYOplPtW4fId9bx0.', 'Nam', 'Huỳnh', 'Sỹ Long', 2, 'SEO', 'sylong@gmail.com', '0758614236', 12, ''),
('26770319', 'vantan', '$2a$12$/RYEaUAsB3G1B8WpHCeaUuE6ctUUL.tdwaJP5qXo0W.If8OOTtWcu', 'Nam', 'Lê', 'Văn Tân', 2, 'SEO', 'vantan@gmail.com', '0921436558', 12, ''),
('46188667', 'hovi', '$2a$12$RESHUUwH77dNLUzA2R9Dse6faUTTOg0zvU6w0lHaPWHTXRHkkmRhy', 'Nam', 'Đoàn', 'Hồ Vĩ', 2, 'SEO', 'hovi@gmail.com', '0123256741', 12, ''),
('46604788', 'trungnhat', '$2a$12$cc5SLbLq5bMABXUmJ8STweNEYO2yIMVmWJeDLeD1snXTTDbuP4KEu', 'Nam', 'Nguyễn', 'Trung Nhật', 1, 'Kế Toán', 'trungnhat@gmail.com', '0336521963', 15, ''),
('39947499', 'phamhanh', '$2a$12$qdrd/lLcUGfYpO.HabSBS.1kQoMrwk.8pu8Ddn0uBCck73gYHMgXe', 'Nữ', 'Phạm', 'Thị Hạnh', 2, 'Kế Toán', 'phamhanh@gmail.com', '0996215332', 12, ''),
('31397038', 'maihong', '$2a$12$1QQkETn7Xt9MIqo2uE7H9u1iL0tGLrSaZIxdzMmVEhLbKP4OOe5GS', 'Nữ', 'Mai', 'Hồng', 2, 'Kế Toán', 'maihong@gmail.com', '0667425933', 12, ''),
('18894782', 'maihuong', '$2a$12$j6q.xcM7VVOxx6NCtlfNe.u3TmZjYNh9M6TlwToTsZcyzH7jcZzui', 'Nữ', 'Mai', 'Hương', 2, 'Kế Toán', 'maihuong@gmail.com', '0115236853', 12, ''),
('55316414', 'hoangquan', '$2a$12$ovWRPYQnL0U8smR/bc547O8v7Zyo7d9lHe8kvvEOc86Z.wiMAsNAS', 'Nam', 'Đỗ', 'Ngọc Hoàng Quân', 2, 'Kế Toán', 'hoangquan@gmail.com', '0885422369', 12, ''),
('50148043', 'maitrung', '$2a$12$hrQmYgoXro038tZt6a0GB.Wjdrwt5y5fJ0aZUuqDqlnJk6d.oBt1S', 'Nam', 'Mai', 'Trung', 1, 'Hành Chính', 'maitrung@gmail.com', '01664317736', 15, ''),
('10529809', 'tramy', '$2a$12$FfBb5S8s/ZRdx7mscDwADeZ1QCzWh9o4Xq5EqkR6SzGdM/C8dhsj6', 'Nữ', 'Mai', 'Thị Trà My', 2, 'Hành Chính', 'tramy@gmail.com', '099421446', 12, ''),
('28554081', 'huybao', '$2a$12$R5u92vLdKY8.hTgQhudkzOTKBbrxpmPE7BMVnPmlsA6F1uU7Ipo9C', 'Nam', 'Mai', 'Huy Bảo', 2, 'Hành Chính', 'huybao@gmail.com', '0745233146', 12, ''),
('50238445', 'vanquy', '$2a$12$G74Jo4CDKtj9P0HJIAP5jeksz1WPDnxLipFHmTdfhZoa.n9x/qB8i', 'Nam', 'Mai', 'Văn Quý', 2, 'Hành Chính', 'vanquy@gmail.com', '0975336222', 12, ''),
('68852608', 'batung', '$2a$12$j74vB56WV3n/H7I3ogTZsel1xw.62uBGEwCVzI/0KTlOA7LdNXRqu', 'Nam', 'Nguyễn', 'Bá Tùng', 2, 'Quản trị nhân lực', 'batung@gmail.com', '0311425678', 12, ''),
('13031330', 'hoangloc', '$2a$12$uRn2U.XlNbdU9ed/eA4C1uM4u7zO0ZqaG8DCZ9.svmrekGwr5MnOW', 'Nam', 'Phạm', 'Hoàng Lộc', 1, 'Quản trị nhân lực', 'hoangloc@gmail.com', '0122443333', 15, ''),
('25042967', 'congtuan', '$2a$12$1SsYXeMzudZPem9Zt8ckp.MliWnIJXfZTGVG6096Zk0AR0a25aNpS', 'Nam', 'Lê', 'Công Tuấn', 2, 'Quản trị nhân lực', 'congtuan@gmail.com', '0663215999', 12, ''),
('19258757', 'tranhau', '$2a$12$KYPRCg1ez6lsALhqGr3Cbu1wG64dyLqbMAFns9oOsd8rxUSdnctqC', 'Nam', 'Nguyễn', ' Trần Trung Hậu', 2, 'Quản trị nhân lực', 'tranhau@gmail.com', '0445236775', 12, '');

INSERT INTO department (id, department_name, manager_name, department_description, room_number) VALUES
('19050202', 'Tổng giám đốc', 'Mai Văn Ngọc', 'Quản lý các hoạt động của công ty đồng thời giám sát các công ty con.', 'A001'),
('19050201', 'Marketing', 'Lê Huyền Trang', 'Nghiên cứu và tiếp cận thị trường, phát hiện ra các cơ hội kinh doanh và khai thác chúng một cách có hiệu quả.', 'C212'),
('19004213', 'SEO', 'Nguyễn Chánh Đại', 'Có nhiệm vụ tăng chất lượng và lưu lượng truy cập website, tăng khả năng hiển thị của website công ty trên các trình duyệt.', 'I301'),
('19523415', 'Kế Toán', 'Nguyễn Trung Nhật', 'Đo lường, xử lý và truyền đạt thông tin tài chính và phi tài chính của công ty.', 'B102'),
('19050432', 'Hành Chính', 'Mai Trung', 'Quản lý, lưu trữ công văn, giấy tờ, sổ sách hành chính và con dấu. Tổ chức các cuộc họp, các sự kiện diễn ra trong và ngoài nước.', 'B105'),
('19018425', 'Quản trị nhân lực', 'Phạm Hoàng Lộc', 'Tham mưu cho Hội đồng quản trị và Tổng giám đốc xây dựng chiến lược phát triển nguồn nhân lực đồng thời nghiên cứu đề xuất chính sách về nhân sự.', 'B103');

INSERT INTO leaverequest VALUES
('hungnghia',0,0),
('thanhson',0,0),
('huyentrang',0,0),
('trunghau',0,0),
('tankhai',0,0),
('chanhdai',0,0),
('bichngoc',0,0),
('sylong',0,0),
('vantan',0,0),
('hovi',0,0),
('trungnhat',0,0),
('phamhanh',0,0),
('maihong',0,0),
('maihuong',0,0),
('hoangquan',0,0),
('maitrung',0,0),
('tramy',0,0),
('huybao',0,0),
('vanquy',0,0),
('batung',0,0),
('hoangloc',0,0),
('congtuan',0,0),
('tranhau',0,0);

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

ALTER TABLE leaverequest
  ADD PRIMARY KEY (username);
COMMIT;