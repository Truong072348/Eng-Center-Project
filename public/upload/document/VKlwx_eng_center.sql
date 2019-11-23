-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th5 13, 2019 lúc 05:32 PM
-- Phiên bản máy phục vụ: 10.1.38-MariaDB
-- Phiên bản PHP: 7.1.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `eng_center`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `category`
--

INSERT INTO `category` (`id`, `name`) VALUES
(1, 'Toeic'),
(2, 'Ielts'),
(3, 'English Basic');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `category_type`
--

CREATE TABLE `category_type` (
  `id` int(11) NOT NULL,
  `level` varchar(50) NOT NULL,
  `id_category` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `category_type`
--

INSERT INTO `category_type` (`id`, `level`, `id_category`) VALUES
(1, '150', 1),
(2, '300', 1),
(3, '400', 1),
(4, '525', 1),
(5, '750', 1),
(6, '750+', 1),
(7, '2.0', 2),
(8, '3.0', 2),
(9, '4.0', 2),
(10, 'For Kids', 3),
(11, 'For Beginners', 3),
(12, 'University', 3);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `comment`
--

CREATE TABLE `comment` (
  `id` varchar(11) NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `id_user` varchar(11) NOT NULL,
  `id_course` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `course`
--

CREATE TABLE `course` (
  `id` varchar(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `price` int(11) NOT NULL,
  `date_start` date NOT NULL,
  `date_finish` date NOT NULL,
  `description` text NOT NULL,
  `id_ctype` int(11) NOT NULL,
  `id_teacher` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `course`
--

INSERT INTO `course` (`id`, `name`, `price`, `date_start`, `date_finish`, `description`, `id_ctype`, `id_teacher`) VALUES
('4460', 'Toeic Grammar For Beginners', 600000, '2019-05-14', '2019-08-14', 'You won\'t score well on the TOEIC test if your English grammar skills are weak. Below we have links to our practical and simple grammar guide. The areas covered are all the main ones covered in the TOEIC test', 1, '002412'),
('4462', 'Toeic Special 1 (300+)', 600000, '2019-05-14', '2019-07-15', 'preparation series for the new toeic test introductory course 400+', 3, '002412'),
('4464', 'Toeic Special 2 (450+)', 800000, '2019-05-31', '2019-08-31', 'preparation series for the new toeic test introductory course 450+', 3, '002414'),
('4466', 'Toeic Special 3 (550+)', 1000000, '2019-05-18', '2019-09-02', 'preparation series for the new toeic test introductory course 550+', 4, '002412'),
('4468', 'Toeic Special 4 (750+)', 1200000, '2019-05-18', '2019-09-02', 'preparation series for the new toeic test introductory course 750+', 5, '002414');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `course_lesson`
--

CREATE TABLE `course_lesson` (
  `id` varchar(11) NOT NULL,
  `lesson` varchar(255) NOT NULL,
  `links_video` varchar(100) NOT NULL,
  `links_document` varchar(100) NOT NULL,
  `id_course` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `course_register`
--

CREATE TABLE `course_register` (
  `id` varchar(11) NOT NULL,
  `date_res` date NOT NULL,
  `price` int(11) NOT NULL,
  `id_student` varchar(11) NOT NULL,
  `id_course` varchar(11) NOT NULL,
  `id_discount` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `course_test`
--

CREATE TABLE `course_test` (
  `id` varchar(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `status` bit(1) NOT NULL,
  `id_test` varchar(11) NOT NULL,
  `id_course` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `discount`
--

CREATE TABLE `discount` (
  `id` varchar(11) NOT NULL,
  `reduce` int(11) NOT NULL,
  `number` int(11) DEFAULT NULL,
  `date_start` date NOT NULL,
  `date_finish` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `feedback`
--

CREATE TABLE `feedback` (
  `id` varchar(11) NOT NULL,
  `answer` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `id_comment` varchar(11) NOT NULL,
  `id_users` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `question`
--

CREATE TABLE `question` (
  `id` varchar(11) NOT NULL,
  `content` text,
  `question` text NOT NULL,
  `correctAnswer` varchar(100) NOT NULL,
  `answer1` varchar(100) NOT NULL,
  `answer2` varchar(100) NOT NULL,
  `answer3` varchar(100) NOT NULL,
  `id_qtype` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `question_type`
--

CREATE TABLE `question_type` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `question_type`
--

INSERT INTO `question_type` (`id`, `name`) VALUES
(1, 'Paragraph'),
(2, 'Audio'),
(3, 'Basic');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `student`
--

CREATE TABLE `student` (
  `id` varchar(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `phone` varchar(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `birthday` date NOT NULL,
  `gender` varchar(3) DEFAULT NULL,
  `address` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `study`
--

CREATE TABLE `study` (
  `id` varchar(11) NOT NULL,
  `score` int(11) NOT NULL,
  `date_work` date NOT NULL,
  `id_test` varchar(11) NOT NULL,
  `id_student` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `teacher`
--

CREATE TABLE `teacher` (
  `id` varchar(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `phone` varchar(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `introduction` text NOT NULL,
  `slogan` varchar(255) NOT NULL,
  `degree` varchar(50) NOT NULL,
  `avatar` varchar(100) NOT NULL,
  `gender` varchar(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `teacher`
--

INSERT INTO `teacher` (`id`, `name`, `phone`, `email`, `introduction`, `slogan`, `degree`, `avatar`, `gender`) VALUES
('002412', 'Nguyễn Minh Hà', '01245421231', 'nguyenha1245@gmail.com', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.', 'Mọi thành tựu, dù lớn hay nhỏ, đều bắt đầu từ trong tâm trí bạn.', 'Toeic 600+', 'avatar-1.jpg', 'Nam'),
('002414', 'Trần Ngọc Linh', '0865412013', 'lingngoc0154@gmail.com', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.', 'You only live once, but if you do it right, once is enough', 'Ielts 7.5', 'avatar-2.jpg', 'Nữ');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `test`
--

CREATE TABLE `test` (
  `id` varchar(11) CHARACTER SET utf8 NOT NULL,
  `name` varchar(100) CHARACTER SET utf8 NOT NULL,
  `time` time NOT NULL,
  `id_ctype` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_esperanto_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `test_detail`
--

CREATE TABLE `test_detail` (
  `id` varchar(11) NOT NULL,
  `id_test` varchar(11) NOT NULL,
  `id_question` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id_user` varchar(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `account_balance` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `id_utype` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id_user`, `username`, `password`, `account_balance`, `created_at`, `updated_at`, `id_utype`) VALUES
('000000', 'admin', 'admin', 100000, '2019-05-12 11:17:56', NULL, '1');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users_type`
--

CREATE TABLE `users_type` (
  `id` varchar(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `users_type`
--

INSERT INTO `users_type` (`id`, `name`) VALUES
('1', 'admin'),
('2', 'teacher'),
('3', 'student');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `category_type`
--
ALTER TABLE `category_type`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_category` (`id_category`);

--
-- Chỉ mục cho bảng `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_course` (`id_course`);

--
-- Chỉ mục cho bảng `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_ctype` (`id_ctype`),
  ADD KEY `id_teacher` (`id_teacher`);

--
-- Chỉ mục cho bảng `course_lesson`
--
ALTER TABLE `course_lesson`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_course` (`id_course`);

--
-- Chỉ mục cho bảng `course_register`
--
ALTER TABLE `course_register`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_course` (`id_course`),
  ADD KEY `id_discount` (`id_discount`),
  ADD KEY `id_student` (`id_student`);

--
-- Chỉ mục cho bảng `course_test`
--
ALTER TABLE `course_test`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_test` (`id_test`),
  ADD KEY `id_course` (`id_course`);

--
-- Chỉ mục cho bảng `discount`
--
ALTER TABLE `discount`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_comment` (`id_comment`),
  ADD KEY `id_users` (`id_users`);

--
-- Chỉ mục cho bảng `question`
--
ALTER TABLE `question`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_qtype` (`id_qtype`);

--
-- Chỉ mục cho bảng `question_type`
--
ALTER TABLE `question_type`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `study`
--
ALTER TABLE `study`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_student` (`id_student`),
  ADD KEY `id_test` (`id_test`);

--
-- Chỉ mục cho bảng `teacher`
--
ALTER TABLE `teacher`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `test`
--
ALTER TABLE `test`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_ctype` (`id_ctype`);

--
-- Chỉ mục cho bảng `test_detail`
--
ALTER TABLE `test_detail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_test` (`id_test`),
  ADD KEY `id_question` (`id_question`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD KEY `id_utype` (`id_utype`);

--
-- Chỉ mục cho bảng `users_type`
--
ALTER TABLE `users_type`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `category_type`
--
ALTER TABLE `category_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT cho bảng `question_type`
--
ALTER TABLE `question_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `category_type`
--
ALTER TABLE `category_type`
  ADD CONSTRAINT `category_type_ibfk_1` FOREIGN KEY (`id_category`) REFERENCES `category` (`id`);

--
-- Các ràng buộc cho bảng `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`),
  ADD CONSTRAINT `comment_ibfk_2` FOREIGN KEY (`id_course`) REFERENCES `course` (`id`);

--
-- Các ràng buộc cho bảng `course`
--
ALTER TABLE `course`
  ADD CONSTRAINT `course_ibfk_1` FOREIGN KEY (`id_ctype`) REFERENCES `category_type` (`id`),
  ADD CONSTRAINT `course_ibfk_2` FOREIGN KEY (`id_teacher`) REFERENCES `teacher` (`id`);

--
-- Các ràng buộc cho bảng `course_lesson`
--
ALTER TABLE `course_lesson`
  ADD CONSTRAINT `course_lesson_ibfk_1` FOREIGN KEY (`id_course`) REFERENCES `course` (`id`);

--
-- Các ràng buộc cho bảng `course_register`
--
ALTER TABLE `course_register`
  ADD CONSTRAINT `course_register_ibfk_1` FOREIGN KEY (`id_course`) REFERENCES `course` (`id`),
  ADD CONSTRAINT `course_register_ibfk_2` FOREIGN KEY (`id_discount`) REFERENCES `discount` (`id`),
  ADD CONSTRAINT `course_register_ibfk_3` FOREIGN KEY (`id_student`) REFERENCES `student` (`id`);

--
-- Các ràng buộc cho bảng `course_test`
--
ALTER TABLE `course_test`
  ADD CONSTRAINT `course_test_ibfk_1` FOREIGN KEY (`id_test`) REFERENCES `test` (`id`),
  ADD CONSTRAINT `course_test_ibfk_2` FOREIGN KEY (`id_course`) REFERENCES `course` (`id`);

--
-- Các ràng buộc cho bảng `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `feedback_ibfk_1` FOREIGN KEY (`id_comment`) REFERENCES `comment` (`id`),
  ADD CONSTRAINT `feedback_ibfk_2` FOREIGN KEY (`id_users`) REFERENCES `users` (`id_user`);

--
-- Các ràng buộc cho bảng `question`
--
ALTER TABLE `question`
  ADD CONSTRAINT `question_ibfk_1` FOREIGN KEY (`id_qtype`) REFERENCES `question_type` (`id`);

--
-- Các ràng buộc cho bảng `study`
--
ALTER TABLE `study`
  ADD CONSTRAINT `study_ibfk_2` FOREIGN KEY (`id_student`) REFERENCES `student` (`id`),
  ADD CONSTRAINT `study_ibfk_3` FOREIGN KEY (`id_test`) REFERENCES `course_test` (`id`);

--
-- Các ràng buộc cho bảng `test`
--
ALTER TABLE `test`
  ADD CONSTRAINT `test_ibfk_1` FOREIGN KEY (`id_ctype`) REFERENCES `category_type` (`id`);

--
-- Các ràng buộc cho bảng `test_detail`
--
ALTER TABLE `test_detail`
  ADD CONSTRAINT `test_detail_ibfk_1` FOREIGN KEY (`id_test`) REFERENCES `test` (`id`),
  ADD CONSTRAINT `test_detail_ibfk_2` FOREIGN KEY (`id_question`) REFERENCES `question` (`id`);

--
-- Các ràng buộc cho bảng `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`id_utype`) REFERENCES `users_type` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
