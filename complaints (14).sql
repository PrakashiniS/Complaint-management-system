-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 13, 2024 at 10:53 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `complaints`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `problem_id` int(11) NOT NULL,
  `reason` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `problem_id`, `reason`) VALUES
(74, 76, 'mkbkjb'),
(75, 76, 'gw'),
(76, 72, 'hhj'),
(77, 72, 'gfu'),
(78, 76, 'need approval');

-- --------------------------------------------------------

--
-- Table structure for table `complaints_detail`
--

CREATE TABLE `complaints_detail` (
  `id` int(11) NOT NULL,
  `faculty_id` int(10) NOT NULL,
  `faculty_name` varchar(100) NOT NULL,
  `department` varchar(10) NOT NULL,
  `faculty_contact` varchar(20) NOT NULL,
  `faculty_mail` varchar(50) NOT NULL,
  `block_venue` varchar(15) NOT NULL,
  `venue_name` varchar(30) NOT NULL,
  `type_of_problem` varchar(50) NOT NULL,
  `problem_description` varchar(400) NOT NULL,
  `images` varchar(255) NOT NULL,
  `date_of_reg` date NOT NULL,
  `days_to_complete` varchar(100) NOT NULL,
  `status` varchar(200) NOT NULL,
  `feedback` varchar(250) NOT NULL,
  `reason` varchar(255) NOT NULL,
  `task_completion` varchar(250) NOT NULL,
  `date_of_completion` date NOT NULL,
  `reassign_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `complaints_detail`
--

INSERT INTO `complaints_detail` (`id`, `faculty_id`, `faculty_name`, `department`, `faculty_contact`, `faculty_mail`, `block_venue`, `venue_name`, `type_of_problem`, `problem_description`, `images`, `date_of_reg`, `days_to_complete`, `status`, `feedback`, `reason`, `task_completion`, `date_of_completion`, `reassign_date`) VALUES
(72, 11111111, 'Ragul', 'IT', '9629613708', 'ragul@mkce.ac.in', 'APJ-106', 'class', 'IT Infra Work', '6 CPU Fault', '0000000020.jpg', '2024-10-01', '2024-10-18', '15', 'jhiu', '', 'Fully Completed', '2024-10-01', '2024-10-13'),
(75, 11111111, 'Ragul', 'IT', '9629613708', 'ragul@mkce.ac.in', 'APJ-106', 'class', 'Plumbing Work', 'broken table', '0000000023.png', '2024-10-01', '2024-10-27', '16', 'no need', '', 'Fully Completed', '2024-10-01', '2024-10-13'),
(76, 11111111, 'Ragul', 'IT', '9629613708', 'ragul@mkce.ac.in', 'RK-124', 'department', 'IT Infra Work', 'fan not working', '0000000024.png', '2024-10-01', '2024-10-18', '14', 'jhvjh', '', '', '0000-00-00', NULL),
(77, 11111111, 'Ragul', 'IT', '9629613708', 'ragul@mkce.ac.in', 'APJ-106', 'class', 'IT Infra Work', '6 CPU Fault', '0000000025.png', '2024-10-01', '2024-10-25', '15', 'ydty', '', '', '0000-00-00', '2024-10-13');

-- --------------------------------------------------------

--
-- Table structure for table `faculty`
--

CREATE TABLE `faculty` (
  `id` int(20) NOT NULL,
  `faculty_id` varchar(15) NOT NULL,
  `password` varchar(15) NOT NULL,
  `faculty_name` varchar(100) NOT NULL,
  `department` varchar(20) NOT NULL,
  `faculty_contact` varchar(20) NOT NULL,
  `faculty_mail` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `faculty`
--

INSERT INTO `faculty` (`id`, `faculty_id`, `password`, `faculty_name`, `department`, `faculty_contact`, `faculty_mail`) VALUES
(1, '11111111', '1234', 'Ragul', 'IT', '9629613708', 'ragul@mkce.ac.in'),
(2, '22222222', '1234', 'Nalin', 'EEE', '9663852741', 'nalin@mkce.ac.in'),
(3, '33333333', '1234', 'Srihari', 'CSE', '963741852', 'sri@mkce.ac.in');

-- --------------------------------------------------------

--
-- Table structure for table `manager`
--

CREATE TABLE `manager` (
  `task_id` int(11) NOT NULL,
  `problem_id` int(11) NOT NULL,
  `worker_id` varchar(25) NOT NULL,
  `priority` varchar(25) NOT NULL,
  `comment_query` varchar(250) NOT NULL,
  `comment_reply` varchar(250) NOT NULL,
  `query_date` date DEFAULT NULL,
  `reply_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `manager`
--

INSERT INTO `manager` (`task_id`, `problem_id`, `worker_id`, `priority`, `comment_query`, `comment_reply`, `query_date`, `reply_date`) VALUES
(95, 75, 'CIV01', 'low', 'HII', '', '0000-00-00', NULL),
(96, 76, 'ELE01', 'medium', 'helo', 'ok sir', '0000-00-00', '2024-10-09'),
(97, 77, 'PUM02', 'high', '', '', '0000-00-00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `workers`
--

CREATE TABLE `workers` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `dept` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `workers`
--

INSERT INTO `workers` (`id`, `name`, `dept`, `phone`) VALUES
(1, 'ELE01', 'ELECTRICAL', ''),
(2, 'ELE02', 'ELECTRICAL', ''),
(3, 'CIV01', 'CIVIL', ''),
(4, 'CIV02', 'CIVIL', ''),
(5, 'PLU01', 'PLUMBING', ''),
(6, 'PLU02', 'PLUMBING', ''),
(7, 'PAR01', 'PARTITION', ''),
(8, 'PAR02', 'PARTITION', ''),
(9, 'INF01', 'IT INFRA', ''),
(10, 'INF02', 'IT INFRA', ''),
(11, 'CAR01', 'CARPENTER', ''),
(12, 'CAR02', 'CARPENTER', '');

-- --------------------------------------------------------

--
-- Table structure for table `worker_details`
--

CREATE TABLE `worker_details` (
  `id` int(11) NOT NULL,
  `worker_id` varchar(100) NOT NULL,
  `password` varchar(50) NOT NULL,
  `worker_first_name` varchar(100) NOT NULL,
  `worker_last_name` varchar(100) NOT NULL,
  `worker_gender` varchar(100) NOT NULL,
  `worker_dept` varchar(100) NOT NULL,
  `worker_mobile` varchar(10) NOT NULL,
  `worker_mail` varchar(100) NOT NULL,
  `worker_emp_type` varchar(100) NOT NULL,
  `worker_photo` varchar(50) NOT NULL,
  `usertype` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `worker_details`
--

INSERT INTO `worker_details` (`id`, `worker_id`, `password`, `worker_first_name`, `worker_last_name`, `worker_gender`, `worker_dept`, `worker_mobile`, `worker_mail`, `worker_emp_type`, `worker_photo`, `usertype`) VALUES
(32, 'head', '123', 'Dhandapani', 'K', 'Female', 'ELECTRICAL', '9952625820', 'nivethak.vlsi@mkce.ac.in', ' Full-time', '', 'user'),
(33, 'CAR01', '123', 'Sundar', '', 'Male', 'CARPENTRY', '9940911511', 'mukeshp.civil@mkce.ac.in', 'Full-time', '', 'user'),
(34, 'CIVIL01', '123', 'Ravi', '', 'Male', 'CIVIL', '9159594640', 'karthickr.mech@mkce.ac.in ', 'Full-time', '', 'user'),
(35, 'PAR01', '123', 'Kumar', '', 'Male', 'PARTITION', '9159594640', 'manirajp.eee@mkce.ac.in', 'Full-time', '', 'user'),
(36, 'PLU01', '123', 'Praveen', '', 'Male', 'PLUMBING', '8220638519', 'ranganathanr.maths@mkce.ac.in', 'Full-time', '', 'user'),
(37, 'INFRA01', '123', 'Gopal', '', 'Female', 'IT INFRA', '6380153269', 'sathiyanathans.it@mkce.ac.in', 'Part-time', '', 'user'),
(38, 'ELE01', '', 'Ramesh', 'K', 'male', 'ELECTRICAL', '951753486', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `worker_taskdet`
--

CREATE TABLE `worker_taskdet` (
  `id` int(255) NOT NULL,
  `task_id` int(11) NOT NULL,
  `after_photo` varchar(255) NOT NULL,
  `task_completion` varchar(100) NOT NULL,
  `work_completion_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `worker_taskdet`
--

INSERT INTO `worker_taskdet` (`id`, `task_id`, `after_photo`, `task_completion`, `work_completion_date`) VALUES
(38, 81, '5_6120435620658544983.jpg', 'Fully Completed', '2024-10-01'),
(39, 82, 'Screenshot 2024-05-10 071700.png', 'Fully Completed', '2024-10-01');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `problem_id` (`problem_id`);

--
-- Indexes for table `complaints_detail`
--
ALTER TABLE `complaints_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `faculty`
--
ALTER TABLE `faculty`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `manager`
--
ALTER TABLE `manager`
  ADD PRIMARY KEY (`task_id`),
  ADD KEY `problem_id` (`problem_id`),
  ADD KEY `problem_id_2` (`problem_id`);

--
-- Indexes for table `workers`
--
ALTER TABLE `workers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `worker_details`
--
ALTER TABLE `worker_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `worker_taskdet`
--
ALTER TABLE `worker_taskdet`
  ADD PRIMARY KEY (`id`),
  ADD KEY `task_id` (`task_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT for table `complaints_detail`
--
ALTER TABLE `complaints_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- AUTO_INCREMENT for table `faculty`
--
ALTER TABLE `faculty`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `manager`
--
ALTER TABLE `manager`
  MODIFY `task_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=98;

--
-- AUTO_INCREMENT for table `workers`
--
ALTER TABLE `workers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `worker_details`
--
ALTER TABLE `worker_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `worker_taskdet`
--
ALTER TABLE `worker_taskdet`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
