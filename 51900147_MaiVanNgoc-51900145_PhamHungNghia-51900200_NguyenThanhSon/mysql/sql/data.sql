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
  task_title varchar(225) NOT NULL COLLATE utf8_unicode_ci,
  task_description varchar(600) NOT NULL COLLATE utf8_unicode_ci,
  start_time datetime NOT NULL,
  deadline datetime NOT NULL,
  staff_assign varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  task_status varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  message_task varchar(255) COLLATE utf8_unicode_ci,
  time_submit datetime,
  file_submit varchar(64) COLLATE utf8_unicode_ci,
  completion_level varchar(64) COLLATE utf8_unicode_ci,
  completion_schedule varchar(64) COLLATE utf8_unicode_ci,
  task_deliver varchar(64) COLLATE utf8_unicode_ci NOT NULL
);

CREATE TABLE leaveform (
  id varchar(15) NOT NULL ,
  username varchar(64) NOT NULL,
  leavetype varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  leavereson varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  star_date date NOT NULL,
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
('hungnghia',12,0),
('thanhson',12,0),
('huyentrang',15,0),
('trunghau',12,0),
('tankhai',12,0),
('chanhdai',15,0),
('bichngoc',12,0),
('sylong',12,0),
('vantan',12,0),
('hovi',12,0),
('trungnhat',15,0),
('phamhanh',12,0),
('maihong',12,0),
('maihuong',12,0),
('hoangquan',12,0),
('maitrung',15,0),
('tramy',12,0),
('huybao',12,0),
('vanquy',12,0),
('batung',12,0),
('hoangloc',15,0),
('congtuan',12,0),
('tranhau',12,0);

INSERT INTO `task` (`id`, `task_title`, `task_description`, `start_time`, `deadline`, `staff_assign`, `task_status`, `message_task`, `time_submit`, `file_submit`, `completion_level`, `completion_schedule`, `task_deliver`) VALUES 
('1', 'Nghiên cứu dự báo thị trường trong tháng 1', 'Thu thập thông tin thị trường để xác định nhu cầu thị trường, thị trường mục tiêu, thị trường mới. Xác định phạm vi thị trường cho những sản phẩm hiện tại và dự báo nhu cầu của sản phẩm hàng hóa mới,
 hướng tiêu thụ sản phẩm, bán hàng', '2022-01-16 07:21:00', '2022-01-20 07:22:00', 'Tô Tấn Khải', 'New', '', NULL, 'Bang tra.pdf', '', '', 'huyentrang'),
('2', 'Tổ chức triển khai chương trình phát triển sản phẩm mới', 'Xác định thị trường mục tiêu: Khách hàng là ai? Đặc điểm của họ như thế nào? (vị trí địa lý, tuổi tác, giới tính, nghề nghiệp, thu nhập, tính cách, lối sống…)', '2022-01-17 07:23:00', '2022-01-21 07:23:00',
 'Nguyễn Trung Hậu', 'Rejected', 'Cần hoàn thiện thiêm về phần nội dung', '2022-01-20 07:30:00', 'De01.docx', '', '', 'huyentrang'),
('3', 'Phát triển sản phẩm mới của công ty', 'Phát triển sản phẩm mới để đáp ứng nhu cầu không ngừng thay đổi của người tiêu dùng, bắt kịp với công nghệ, kỹ thuật mới, phù hợp với sự cạnh tranh khốc liệt trên thị trường.', '2022-01-18 07:32:00', '2022-01-25 07:32:00',
'Phạm Hùng Nghĩa', 'Completed', 'Đúng hạn deadline', '2022-01-23 07:33:00', 'files_upload.rar', 'Good', '', 'huyentrang'),
('4', 'Xây dựng và thực hiện kế hoạch chiến lược Marketing', 'Tìm ra các định hướng để định hướng các hoạt động để hoàn thành các mục tiêu của doanh nghiệp trong tháng 2', '2022-01-17 07:36:00', '2022-01-20 07:36:00', 'Nguyễn Thanh Sơn', 'Waiting', 'Nhóm đã tìm ra một số định hướng để định hướng các hoạt động',
'2022-01-19 07:42:00', 'final_report.zip', '', '', 'huyentrang'),
('5', 'Xây dựng và thực hiện kế hoạch chiến lược Marketing', 'Tìm ra các định hướng để định hướng các hoạt động để hoàn thành các mục tiêu của doanh nghiệp trong tháng 2', '2022-01-17 07:37:00', '2022-01-20 07:37:00', 'Phạm Hùng Nghĩa', 'Waiting', 'Nhóm đã tìm ra một số định hướng để định hướng các hoạt động',
'2022-01-19 07:43:00', 'final_report.zip', '', '', 'huyentrang'),
('6', 'Thiết lập mối quan hệ tốt với giới truyền thông', 'Để đảm bảo hình ảnh của doanh nghiệp được thể hiện một cách tốt nhất trước công chúng', '2022-01-20 07:38:00', '2022-01-25 07:38:00', 'Tô Tấn Khải', 'Canceled', '', NULL, 'files_upload.rar', '', '', 'huyentrang'),
('7', 'Xây dựng và phát triển hình ảnh thương hiệu', 'Tìm ra những giải pháp để giúp doanh nghiệp đạt được thành công và tạo được vị thế cạnh tranh trên thị trường', '2022-01-21 07:48:00', '2022-01-25 07:49:00', 'Nguyễn Thanh Sơn', 'In progress', '', NULL, 'Soluocvande.pdf',
 '8', '', 'huyentrang'),
('9', 'Thu thập, xử lý thông tin, số liệu của thu chi của công ty', 'Dựa theo tài liệu đã được đính kèm để tính toán thu chi của công ty trong tháng 1', '2022-01-18 08:02:00', '2022-01-20 08:02:00', 'Mai Hương', 'In progress', '', NULL, 'CNPM_CK.docx', '', '', 'trungnhat'),
('10', 'Phân tích thông tin, số liệu kế toán, đề xuất các giải pháp', 'Phân tích thông tin, số liệu kế toán; tham mưu, đề xuất các giải pháp phục vụ yêu cầu quản trị và quyết định kinh tế Phân tích thông tin, số liệu kế toán; tham mưu, đề xuất các giải pháp phục vụ yêu cầu quản trị và quyết định kinh tế trong tháng 2', '2022-01-18 08:04:00',
'2022-01-20 08:04:00', 'Mai Hồng', 'Waiting', 'Đã phân tích thông tin, số liệu kế toán cần thiết', '2022-01-20 07:07:00', 'final_report.zip', '', '', 'trungnhat'),
('11', 'Ghi chép, tính toán, phản ánh số hiện có của công ty', 'Ghi chép, tính toán, phản ánh số hiện có, tình hình luân chuyển và sử dụng tài sản, vật tư, tiền vốn; quá trình và kết quả hoạt động sản xuất kinh doanh (SXKD) và tình hình sử dụng kinh phí (nếu có) của công ty', '2022-01-19 08:09:00', '2022-01-25 08:09:00', 'Phạm Thị Hạnh', 'Rejected',
'Vẫn chưa phản ánh đầy đủ những thông tin cần thiết', '2022-01-24 08:13:00', 'files_upload.rar', '', '', 'trungnhat'),
('12', 'Cung cấp các số liệu, tài liệu cho việc điều hành hoạt động SXKD', 'Cung cấp các số liệu, tài liệu cho việc điều hành hoạt động SXKD, kiểm tra và phân tích hoạt động kinh tế, tài chính phục vụ công tác lập và theo dõi thực hiện kế hoạch phục vụ công tác thống kê và thông tin kinh tế.', '2022-01-18 08:18:00', '2022-01-21 08:18:00',
'Đỗ Ngọc Hoàng Quân', 'Completed', 'Trễ hạn deadline', '2022-01-21 08:20:00', 'files_upload.rar', 'OK', '', 'trungnhat'),
('13', 'Kế hoạch bảo hộ lao động', 'Đưa ra kế hoạch để Đảm bảo an toàn lao động, cháy nổ, vệ sinh trong toàn công ty Kiểm tra và lên kế hoạch tập huấn về việc bảo hộ lao động Tổ chức khám, kiểm tra sức khỏe thường xuyên cho người lao động.', '2022-01-16 08:31:00', '2022-01-20 08:31:00', 'Mai Thị Trà My', 'Completed', 'Đúng hạn deadline', '2022-01-19 08:00:00',
'Bang tra.pdf', 'Good', '', 'maitrung'),
('14', 'Giải pháp bảo vệ an ninh, trật tự', 'Đề ra giải pháp Bảo vệ an ninh trật tự, tài sản của công ty và CBCNV Là lực lượng chính trong lực lượng xung kích phòng chống thiên tai, hỏa hoạn. Quản lý nhân lực thực hiện theo luật nghĩa vụ quân sự.', '2022-01-18 08:33:00', '2022-01-21 08:33:00', 'Mai Huy Bảo', 'In progress', '', NULL, '', '', '', 'maitrung'),
('15', 'Công tác hành chính, tổng hợp', 'Xây dựng chương trình, lập kế hoạch công tác của cơ quan theo từng giai đoạn: tháng, quý, năm. Thực hiện công tác hành chính, tổng hợp văn thư, lưu trữ, quản lý và sử dụng con dấu. Soạn thảo, ban hành văn bản thuộc các lĩnh vực tổ chức, nhân sự, hành chính, văn thư, lưu trữ. Chỉ đạo nghiệp vụ hành chính, văn thư lưu trữ đối với cán bộ làm công tác văn thư,
văn phòng các đơn vị trực thuộc.', '2022-01-16 08:34:00', '2022-01-20 08:34:00', 'Mai Văn Quý', 'New', '', NULL, '', '', '', 'maitrung'),
('16', 'Công tác tổ chức, chế độ chính sách', 'Tổng hợp theo dõi công tác thi đua khen thưởng, kỷ luật của công ty. Lưu giữ và bổ sung hồ sơ CBCNV kịp thời, chính xác, Là thành viên thường trực trong hội đồng thi đua khen thưởng, kỷ luật, HĐ lương, khoa học kỹ thuật', '2022-01-21 08:38:00', '2022-01-24 08:38:00', 'Mai Thị Trà My', 'Waiting', 'Đã tổng hợp các nội dung cần thiết', '2022-01-24 07:30:00', 'CNPM_CK.docx', '', '', 'maitrung'),
('17', 'Hoạch định và dự báo nhu cầu nhân sự', 'Hoạch định và dự báo nhu cầu nhân sự của công ty hiện tại', '2022-01-16 08:45:00', '2022-01-18 08:45:00', 'Nguyễn Bá Tùng', 'In progress', '', NULL, '', '', '', 'hoangloc'),
('18', 'Thu hút, tuyển mộ nhân viên', 'Đề ra các giải pháp để thu hút, tuyển mộ nhân viên cho công ty trong thời gian tới', '2022-01-16 08:46:00', '2022-01-20 08:46:00', 'Nguyễn Trần Trung Hậu', 'Waiting', 'Nhóm đã tìm ra được một số giải pháp phù hợp', '2022-01-19 08:00:00', 'final_report.zip', '', '', 'hoangloc'),
('19', 'Thu hút, tuyển mộ nhân viên', 'Đề ra các giải pháp để thu hút, tuyển mộ nhân viên cho công ty trong thời gian tới', '2022-01-16 08:46:00', '2022-01-20 08:46:00', 'Lê Công Tuấn', 'Waiting', 'Nhóm đã tìm ra được một số giải pháp phù hợp', '2022-01-19 08:00:00', 'final_report.zip', '', '', 'hoangloc'),
('20', 'Huấn luyện , đào tạo , phát triển nguồn nhân lực', 'Đưa ta giải pháp huấn luyện , đào tạo , phát triển nguồn nhân lực mới của công ty', '2022-01-21 08:50:00', '2022-01-24 08:50:00', 'Nguyễn Trần Trung Hậu', 'In progress', '', NULL, '', '', '', 'hoangloc'),
('21', 'Trả công lao động', 'Đưa ra bảng trả công lao động trong tháng 1', '2022-01-21 08:51:00', '2022-01-23 08:52:00', 'Lê Công Tuấn', 'Completed', 'Đúng hạn deadline', '2022-01-22 07:30:00', 'Bang tra.pdf', 'Good', '', 'hoangloc'),
('22', 'Đánh giá năng lực thực hiện công việc của nhân viên', 'Đánh giá năng lực thực hiện công việc của nhân viên hiện tại', '2022-01-19 08:53:00', '2022-01-21 08:53:00', 'Nguyễn Bá Tùng', 'Canceled', '', NULL, '', '', '', 'hoangloc'),
('23', 'Thực hiện kiểm tra, thu thập, phân tích dữ liệu và kết quả', 'Thực hiện kiểm tra, thu thập, phân tích dữ liệu và kết quả, xác định xu hướng và thông tin chi tiết để đạt được ROI tối đa trong các chiến dịch tìm kiếm phải trả tiền.', '2022-01-16 09:00:00', '2022-01-18 09:00:00', 'Lê Văn Tân', 'In progress', '', NULL, '', '', '', 'chanhdai'),
('24', 'Theo dõi, báo cáo và phân tích trang web công ty', 'Theo dõi, báo cáo và phân tích trang web, đưa ra các sáng kiến, chuẩn bị cho chiến dịch PPC.', '2022-01-17 09:01:00', '2022-01-20 09:02:00', 'Đoàn Hồ Vĩ', 'New', '', NULL, '', '', '', 'chanhdai'),
('25', 'Quản lý chi phí chiến dịch dựa trên ngân sách công ty', 'Báo cáo về quản lý chi phí chiến dịch dựa trên ngân sách, ước tính chi phí hàng tháng và đối chiếu chênh lệch trong tháng 1', '2022-01-17 09:03:00', '2022-01-19 09:03:00', 'Vũ Thị Bích Ngọc', 'In progress', '', NULL, 'Course key elab SEMESTER 2 2020-2021.xlsx', '', '', 'chanhdai'),
('26', 'Thực hiện khám phá, mở rộng và tối ưu hóa từ khóa liên tục.', 'Đưa ra các sáng kiến thực hiện khám phá, mở rộng và tối ưu hóa từ khóa liên tục.', '2022-01-16 09:05:00', '2022-01-22 09:05:00', 'Huỳnh Sỹ Long', 'Rejected', 'Cần đưa ra thêm một số ý kiến khác', '2022-01-18 09:00:00', 'files_upload.rar', '', '', 'chanhdai'),
('27', 'Đề xuất thay đổi kiến trúc trang web', 'Đưa ra các đề xuất thay đổi kiến trúc trang web, nội dung, liên kết và các yếu tố khác để cải thiện vị trí SEO cho các từ khóa mục tiêu.', '2022-01-16 09:08:00', '2022-01-18 09:08:00', 'Huỳnh Sỹ Long', 'Completed', 'Đúng hạn deadline', '2022-01-17 12:00:00', 'CNPM_CK.docx', 'Good', '', 'chanhdai');

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
  MODIFY id int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

ALTER TABLE leaverequest
  ADD PRIMARY KEY (username);

ALTER TABLE leaveform
  ADD PRIMARY KEY (id);

ALTER TABLE leaveform
  MODIFY id int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
COMMIT;