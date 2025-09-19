-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 19, 2025 at 08:01 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bethepros`
--

-- --------------------------------------------------------

--
-- Table structure for table `career_path_recommendations`
--

CREATE TABLE `career_path_recommendations` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `path_name` varchar(150) NOT NULL,
  `path_description` text NOT NULL,
  `current_job_role` varchar(100) NOT NULL,
  `target_job_role` varchar(100) NOT NULL,
  `industry` varchar(100) NOT NULL,
  `estimated_duration` varchar(50) DEFAULT NULL,
  `required_skills` text DEFAULT NULL,
  `optional_skills` text DEFAULT NULL,
  `milestones` text DEFAULT NULL,
  `compatibility_score` decimal(3,2) DEFAULT 0.00,
  `status` enum('pending','following','completed','dismissed') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `career_path_recommendations`
--

INSERT INTO `career_path_recommendations` (`id`, `user_id`, `path_name`, `path_description`, `current_job_role`, `target_job_role`, `industry`, `estimated_duration`, `required_skills`, `optional_skills`, `milestones`, `compatibility_score`, `status`, `created_at`, `updated_at`) VALUES
(2, 7, 'Software Development Professional', 'Advance from junior to senior software developer with expertise in modern technologies.', 'Junior Developer', 'Senior Software Engineer', 'Technology', '18 months', '[\"Programming\",\"System Design\",\"Code Review\",\"Testing\"]', '[\"Cloud Computing\",\"DevOps\",\"Machine Learning\"]', '[\"3 months: Complete advanced programming course\",\"6 months: Build portfolio projects\",\"12 months: Lead a small project\",\"18 months: Senior developer interview preparation\"]', 5.00, 'pending', '2025-09-19 15:56:54', '2025-09-19 15:56:54'),
(3, 7, 'Project Management Leader', 'Transition into project management with leadership and organizational skills.', 'Team Member', 'Project Manager', 'Various', '12 months', '[\"Project Planning\",\"Team Leadership\",\"Communication\",\"Risk Management\"]', '[\"Agile Methodology\",\"Budget Management\",\"Stakeholder Management\"]', '[\"2 months: Complete project management fundamentals\",\"4 months: Obtain PMP certification\",\"8 months: Lead a pilot project\",\"12 months: Apply for PM positions\"]', 5.00, 'pending', '2025-09-19 15:56:54', '2025-09-19 15:56:54'),
(4, 7, 'Data Analytics Specialist', 'Build expertise in data analysis, visualization, and business intelligence.', 'Analyst', 'Senior Data Analyst', 'Technology/Finance', '15 months', '[\"Data Analysis\",\"SQL\",\"Python\\/R\",\"Data Visualization\"]', '[\"Machine Learning\",\"Big Data\",\"Statistical Analysis\"]', '[\"3 months: Master SQL and data fundamentals\",\"6 months: Complete Python for data analysis\",\"9 months: Build data visualization portfolio\",\"15 months: Advanced analytics certification\"]', 5.00, 'pending', '2025-09-19 15:56:54', '2025-09-19 15:56:54'),
(5, 7, 'Software Development Professional', 'Advance from junior to senior software developer with expertise in modern technologies.', 'Junior Developer', 'Senior Software Engineer', 'Technology', '18 months', '[\"Programming\",\"System Design\",\"Code Review\",\"Testing\"]', '[\"Cloud Computing\",\"DevOps\",\"Machine Learning\"]', '[\"3 months: Complete advanced programming course\",\"6 months: Build portfolio projects\",\"12 months: Lead a small project\",\"18 months: Senior developer interview preparation\"]', 5.00, 'pending', '2025-09-19 15:57:05', '2025-09-19 15:57:05'),
(6, 7, 'Project Management Leader', 'Transition into project management with leadership and organizational skills.', 'Team Member', 'Project Manager', 'Various', '12 months', '[\"Project Planning\",\"Team Leadership\",\"Communication\",\"Risk Management\"]', '[\"Agile Methodology\",\"Budget Management\",\"Stakeholder Management\"]', '[\"2 months: Complete project management fundamentals\",\"4 months: Obtain PMP certification\",\"8 months: Lead a pilot project\",\"12 months: Apply for PM positions\"]', 5.00, 'pending', '2025-09-19 15:57:05', '2025-09-19 15:57:05'),
(7, 7, 'Data Analytics Specialist', 'Build expertise in data analysis, visualization, and business intelligence.', 'Analyst', 'Senior Data Analyst', 'Technology/Finance', '15 months', '[\"Data Analysis\",\"SQL\",\"Python\\/R\",\"Data Visualization\"]', '[\"Machine Learning\",\"Big Data\",\"Statistical Analysis\"]', '[\"3 months: Master SQL and data fundamentals\",\"6 months: Complete Python for data analysis\",\"9 months: Build data visualization portfolio\",\"15 months: Advanced analytics certification\"]', 5.00, 'pending', '2025-09-19 15:57:05', '2025-09-19 15:57:05'),
(8, 7, 'Software Development Professional', 'Advance from junior to senior software developer with expertise in modern technologies.', 'Junior Developer', 'Senior Software Engineer', 'Technology', '18 months', '[\"Programming\",\"System Design\",\"Code Review\",\"Testing\"]', '[\"Cloud Computing\",\"DevOps\",\"Machine Learning\"]', '[\"3 months: Complete advanced programming course\",\"6 months: Build portfolio projects\",\"12 months: Lead a small project\",\"18 months: Senior developer interview preparation\"]', 5.00, 'pending', '2025-09-19 15:57:10', '2025-09-19 15:57:10'),
(9, 7, 'Project Management Leader', 'Transition into project management with leadership and organizational skills.', 'Team Member', 'Project Manager', 'Various', '12 months', '[\"Project Planning\",\"Team Leadership\",\"Communication\",\"Risk Management\"]', '[\"Agile Methodology\",\"Budget Management\",\"Stakeholder Management\"]', '[\"2 months: Complete project management fundamentals\",\"4 months: Obtain PMP certification\",\"8 months: Lead a pilot project\",\"12 months: Apply for PM positions\"]', 5.00, 'pending', '2025-09-19 15:57:10', '2025-09-19 15:57:10'),
(10, 7, 'Data Analytics Specialist', 'Build expertise in data analysis, visualization, and business intelligence.', 'Analyst', 'Senior Data Analyst', 'Technology/Finance', '15 months', '[\"Data Analysis\",\"SQL\",\"Python\\/R\",\"Data Visualization\"]', '[\"Machine Learning\",\"Big Data\",\"Statistical Analysis\"]', '[\"3 months: Master SQL and data fundamentals\",\"6 months: Complete Python for data analysis\",\"9 months: Build data visualization portfolio\",\"15 months: Advanced analytics certification\"]', 5.00, 'pending', '2025-09-19 15:57:10', '2025-09-19 15:57:10'),
(11, 8, 'Professional Development Path', 'Comprehensive career advancement plan tailored to your goals and current skills.', 'Current Professional', 'Senior Professional / Team Lead', 'Professional Services', '12-18 months', '[\"Leadership Skills\", \"Project Management\", \"Strategic Thinking\", \"Team Building\"]', '[\"Digital Marketing\", \"Data Analysis\", \"Public Speaking\"]', '[\"Complete leadership training\", \"Lead a project team\", \"Obtain professional certification\", \"Mentorship program participation\"]', 0.88, 'pending', '2025-09-19 16:03:29', '2025-09-19 16:03:29'),
(12, 7, 'Software Development Professional', 'Advance from junior to senior software developer with expertise in modern technologies.', 'Junior Developer', 'Senior Software Engineer', 'Technology', '18 months', '[\"Programming\",\"System Design\",\"Code Review\",\"Testing\"]', '[\"Cloud Computing\",\"DevOps\",\"Machine Learning\"]', '[\"3 months: Complete advanced programming course\",\"6 months: Build portfolio projects\",\"12 months: Lead a small project\",\"18 months: Senior developer interview preparation\"]', 5.00, 'pending', '2025-09-19 16:07:42', '2025-09-19 16:07:42'),
(13, 7, 'Project Management Leader', 'Transition into project management with leadership and organizational skills.', 'Team Member', 'Project Manager', 'Various', '12 months', '[\"Project Planning\",\"Team Leadership\",\"Communication\",\"Risk Management\"]', '[\"Agile Methodology\",\"Budget Management\",\"Stakeholder Management\"]', '[\"2 months: Complete project management fundamentals\",\"4 months: Obtain PMP certification\",\"8 months: Lead a pilot project\",\"12 months: Apply for PM positions\"]', 5.00, 'pending', '2025-09-19 16:07:42', '2025-09-19 16:07:42'),
(14, 7, 'Data Analytics Specialist', 'Build expertise in data analysis, visualization, and business intelligence.', 'Analyst', 'Senior Data Analyst', 'Technology/Finance', '15 months', '[\"Data Analysis\",\"SQL\",\"Python\\/R\",\"Data Visualization\"]', '[\"Machine Learning\",\"Big Data\",\"Statistical Analysis\"]', '[\"3 months: Master SQL and data fundamentals\",\"6 months: Complete Python for data analysis\",\"9 months: Build data visualization portfolio\",\"15 months: Advanced analytics certification\"]', 5.00, 'pending', '2025-09-19 16:07:42', '2025-09-19 16:07:42'),
(15, 7, 'Software Development Professional', 'Advance from junior to senior software developer with expertise in modern technologies.', 'Junior Developer', 'Senior Software Engineer', 'Technology', '18 months', '[\"Programming\",\"System Design\",\"Code Review\",\"Testing\"]', '[\"Cloud Computing\",\"DevOps\",\"Machine Learning\"]', '[\"3 months: Complete advanced programming course\",\"6 months: Build portfolio projects\",\"12 months: Lead a small project\",\"18 months: Senior developer interview preparation\"]', 5.00, 'pending', '2025-09-19 16:18:29', '2025-09-19 16:18:29'),
(16, 7, 'Project Management Leader', 'Transition into project management with leadership and organizational skills.', 'Team Member', 'Project Manager', 'Various', '12 months', '[\"Project Planning\",\"Team Leadership\",\"Communication\",\"Risk Management\"]', '[\"Agile Methodology\",\"Budget Management\",\"Stakeholder Management\"]', '[\"2 months: Complete project management fundamentals\",\"4 months: Obtain PMP certification\",\"8 months: Lead a pilot project\",\"12 months: Apply for PM positions\"]', 5.00, 'pending', '2025-09-19 16:18:29', '2025-09-19 16:18:29'),
(17, 7, 'Data Analytics Specialist', 'Build expertise in data analysis, visualization, and business intelligence.', 'Analyst', 'Senior Data Analyst', 'Technology/Finance', '15 months', '[\"Data Analysis\",\"SQL\",\"Python\\/R\",\"Data Visualization\"]', '[\"Machine Learning\",\"Big Data\",\"Statistical Analysis\"]', '[\"3 months: Master SQL and data fundamentals\",\"6 months: Complete Python for data analysis\",\"9 months: Build data visualization portfolio\",\"15 months: Advanced analytics certification\"]', 5.00, 'pending', '2025-09-19 16:18:29', '2025-09-19 16:18:29'),
(18, 7, 'Software Development Professional', 'Advance from junior to senior software developer with expertise in modern technologies.', 'Junior Developer', 'Senior Software Engineer', 'Technology', '18 months', '[\"Programming\",\"System Design\",\"Code Review\",\"Testing\"]', '[\"Cloud Computing\",\"DevOps\",\"Machine Learning\"]', '[\"3 months: Complete advanced programming course\",\"6 months: Build portfolio projects\",\"12 months: Lead a small project\",\"18 months: Senior developer interview preparation\"]', 5.00, 'pending', '2025-09-19 16:19:01', '2025-09-19 16:19:01'),
(19, 7, 'Project Management Leader', 'Transition into project management with leadership and organizational skills.', 'Team Member', 'Project Manager', 'Various', '12 months', '[\"Project Planning\",\"Team Leadership\",\"Communication\",\"Risk Management\"]', '[\"Agile Methodology\",\"Budget Management\",\"Stakeholder Management\"]', '[\"2 months: Complete project management fundamentals\",\"4 months: Obtain PMP certification\",\"8 months: Lead a pilot project\",\"12 months: Apply for PM positions\"]', 5.00, 'pending', '2025-09-19 16:19:01', '2025-09-19 16:19:01'),
(20, 7, 'Data Analytics Specialist', 'Build expertise in data analysis, visualization, and business intelligence.', 'Analyst', 'Senior Data Analyst', 'Technology/Finance', '15 months', '[\"Data Analysis\",\"SQL\",\"Python\\/R\",\"Data Visualization\"]', '[\"Machine Learning\",\"Big Data\",\"Statistical Analysis\"]', '[\"3 months: Master SQL and data fundamentals\",\"6 months: Complete Python for data analysis\",\"9 months: Build data visualization portfolio\",\"15 months: Advanced analytics certification\"]', 5.00, 'pending', '2025-09-19 16:19:01', '2025-09-19 16:19:01'),
(21, 7, 'Software Development Professional', 'Advance from junior to senior software developer with expertise in modern technologies.', 'Junior Developer', 'Senior Software Engineer', 'Technology', '18 months', '[\"Programming\",\"System Design\",\"Code Review\",\"Testing\"]', '[\"Cloud Computing\",\"DevOps\",\"Machine Learning\"]', '[\"3 months: Complete advanced programming course\",\"6 months: Build portfolio projects\",\"12 months: Lead a small project\",\"18 months: Senior developer interview preparation\"]', 5.00, 'pending', '2025-09-19 17:54:27', '2025-09-19 17:54:27'),
(22, 7, 'Project Management Leader', 'Transition into project management with leadership and organizational skills.', 'Team Member', 'Project Manager', 'Various', '12 months', '[\"Project Planning\",\"Team Leadership\",\"Communication\",\"Risk Management\"]', '[\"Agile Methodology\",\"Budget Management\",\"Stakeholder Management\"]', '[\"2 months: Complete project management fundamentals\",\"4 months: Obtain PMP certification\",\"8 months: Lead a pilot project\",\"12 months: Apply for PM positions\"]', 5.00, 'pending', '2025-09-19 17:54:27', '2025-09-19 17:54:27'),
(23, 7, 'Data Analytics Specialist', 'Build expertise in data analysis, visualization, and business intelligence.', 'Analyst', 'Senior Data Analyst', 'Technology/Finance', '15 months', '[\"Data Analysis\",\"SQL\",\"Python\\/R\",\"Data Visualization\"]', '[\"Machine Learning\",\"Big Data\",\"Statistical Analysis\"]', '[\"3 months: Master SQL and data fundamentals\",\"6 months: Complete Python for data analysis\",\"9 months: Build data visualization portfolio\",\"15 months: Advanced analytics certification\"]', 5.00, 'pending', '2025-09-19 17:54:27', '2025-09-19 17:54:27'),
(24, 7, 'Software Development Professional', 'Advance from junior to senior software developer with expertise in modern technologies.', 'Junior Developer', 'Senior Software Engineer', 'Technology', '18 months', '[\"Programming\",\"System Design\",\"Code Review\",\"Testing\"]', '[\"Cloud Computing\",\"DevOps\",\"Machine Learning\"]', '[\"3 months: Complete advanced programming course\",\"6 months: Build portfolio projects\",\"12 months: Lead a small project\",\"18 months: Senior developer interview preparation\"]', 5.00, 'pending', '2025-09-19 17:58:58', '2025-09-19 17:58:58'),
(25, 7, 'Project Management Leader', 'Transition into project management with leadership and organizational skills.', 'Team Member', 'Project Manager', 'Various', '12 months', '[\"Project Planning\",\"Team Leadership\",\"Communication\",\"Risk Management\"]', '[\"Agile Methodology\",\"Budget Management\",\"Stakeholder Management\"]', '[\"2 months: Complete project management fundamentals\",\"4 months: Obtain PMP certification\",\"8 months: Lead a pilot project\",\"12 months: Apply for PM positions\"]', 5.00, 'pending', '2025-09-19 17:58:58', '2025-09-19 17:58:58'),
(26, 7, 'Data Analytics Specialist', 'Build expertise in data analysis, visualization, and business intelligence.', 'Analyst', 'Senior Data Analyst', 'Technology/Finance', '15 months', '[\"Data Analysis\",\"SQL\",\"Python\\/R\",\"Data Visualization\"]', '[\"Machine Learning\",\"Big Data\",\"Statistical Analysis\"]', '[\"3 months: Master SQL and data fundamentals\",\"6 months: Complete Python for data analysis\",\"9 months: Build data visualization portfolio\",\"15 months: Advanced analytics certification\"]', 5.00, 'pending', '2025-09-19 17:58:58', '2025-09-19 17:58:58'),
(27, 7, 'Software Development Professional', 'Advance from junior to senior software developer with expertise in modern technologies.', 'Junior Developer', 'Senior Software Engineer', 'Technology', '18 months', '[\"Programming\",\"System Design\",\"Code Review\",\"Testing\"]', '[\"Cloud Computing\",\"DevOps\",\"Machine Learning\"]', '[\"3 months: Complete advanced programming course\",\"6 months: Build portfolio projects\",\"12 months: Lead a small project\",\"18 months: Senior developer interview preparation\"]', 5.00, 'pending', '2025-09-19 18:00:18', '2025-09-19 18:00:18'),
(28, 7, 'Project Management Leader', 'Transition into project management with leadership and organizational skills.', 'Team Member', 'Project Manager', 'Various', '12 months', '[\"Project Planning\",\"Team Leadership\",\"Communication\",\"Risk Management\"]', '[\"Agile Methodology\",\"Budget Management\",\"Stakeholder Management\"]', '[\"2 months: Complete project management fundamentals\",\"4 months: Obtain PMP certification\",\"8 months: Lead a pilot project\",\"12 months: Apply for PM positions\"]', 5.00, 'pending', '2025-09-19 18:00:18', '2025-09-19 18:00:18'),
(29, 7, 'Data Analytics Specialist', 'Build expertise in data analysis, visualization, and business intelligence.', 'Analyst', 'Senior Data Analyst', 'Technology/Finance', '15 months', '[\"Data Analysis\",\"SQL\",\"Python\\/R\",\"Data Visualization\"]', '[\"Machine Learning\",\"Big Data\",\"Statistical Analysis\"]', '[\"3 months: Master SQL and data fundamentals\",\"6 months: Complete Python for data analysis\",\"9 months: Build data visualization portfolio\",\"15 months: Advanced analytics certification\"]', 5.00, 'pending', '2025-09-19 18:00:18', '2025-09-19 18:00:18'),
(30, 7, 'Software Development Professional', 'Advance from junior to senior software developer with expertise in modern technologies.', 'Junior Developer', 'Senior Software Engineer', 'Technology', '18 months', '[\"Programming\",\"System Design\",\"Code Review\",\"Testing\"]', '[\"Cloud Computing\",\"DevOps\",\"Machine Learning\"]', '[\"3 months: Complete advanced programming course\",\"6 months: Build portfolio projects\",\"12 months: Lead a small project\",\"18 months: Senior developer interview preparation\"]', 5.00, 'pending', '2025-09-19 18:00:47', '2025-09-19 18:00:47'),
(31, 7, 'Project Management Leader', 'Transition into project management with leadership and organizational skills.', 'Team Member', 'Project Manager', 'Various', '12 months', '[\"Project Planning\",\"Team Leadership\",\"Communication\",\"Risk Management\"]', '[\"Agile Methodology\",\"Budget Management\",\"Stakeholder Management\"]', '[\"2 months: Complete project management fundamentals\",\"4 months: Obtain PMP certification\",\"8 months: Lead a pilot project\",\"12 months: Apply for PM positions\"]', 5.00, 'pending', '2025-09-19 18:00:47', '2025-09-19 18:00:47'),
(32, 7, 'Data Analytics Specialist', 'Build expertise in data analysis, visualization, and business intelligence.', 'Analyst', 'Senior Data Analyst', 'Technology/Finance', '15 months', '[\"Data Analysis\",\"SQL\",\"Python\\/R\",\"Data Visualization\"]', '[\"Machine Learning\",\"Big Data\",\"Statistical Analysis\"]', '[\"3 months: Master SQL and data fundamentals\",\"6 months: Complete Python for data analysis\",\"9 months: Build data visualization portfolio\",\"15 months: Advanced analytics certification\"]', 5.00, 'pending', '2025-09-19 18:00:47', '2025-09-19 18:00:47');

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `status` enum('unread','read') DEFAULT 'unread',
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_messages`
--

INSERT INTO `contact_messages` (`id`, `user_id`, `name`, `email`, `phone`, `subject`, `message`, `status`, `created_at`, `updated_at`) VALUES
(1, NULL, 'John Doe', 'john@example.com', '123-456-7890', 'Course Inquiry', 'I am interested in your web development course.', 'read', '2025-08-11 06:29:08', '2025-08-11 06:30:58'),
(2, NULL, 'Jane Smith', 'jane@example.com', '098-765-4321', 'Technical Support', 'I am having trouble accessing my account.', 'read', '2025-08-11 06:29:08', '2025-08-11 06:30:58'),
(3, NULL, 'Mike Johnson', 'mike@example.com', '555-123-4567', 'General Question', 'What are your course timings?', 'read', '2025-08-11 06:29:08', '2025-08-11 06:29:08'),
(4, NULL, 'Sameer', 'sameerbasit@gmail.com', '3122287470', 'error', 'bbbbbbbbb', 'unread', '2025-08-11 06:31:50', '2025-08-11 06:31:50'),
(5, NULL, 'Sarah Johnson', 'sarah.johnson@email.com', '+1-555-0123', 'Web Development Course Inquiry', 'Hello! I am interested in your web development course. Could you please provide more details about the curriculum, duration, and pricing? I have some basic HTML knowledge but want to learn more advanced topics like JavaScript and PHP. Thank you!', 'unread', '2025-08-11 06:37:22', '2025-08-11 06:37:22'),
(6, NULL, 'Michael Chen', 'michael.chen@gmail.com', '+1-555-0456', 'Schedule and Timing Questions', 'Hi there! I work full-time and am wondering if you offer evening or weekend classes? Also, do you provide any online learning options? I am very interested in joining your programming courses but need flexible timing.', 'unread', '2025-08-11 06:37:22', '2025-08-11 06:37:22'),
(7, NULL, 'Emily Rodriguez', 'emily.r@outlook.com', '+1-555-0789', 'Course Certificate and Job Placement', 'Good morning! I wanted to ask about the certification provided after course completion and if you have any job placement assistance. I am looking to transition into tech and would appreciate any guidance you can provide.', 'unread', '2025-08-11 06:37:22', '2025-08-11 06:37:22'),
(8, NULL, 'David Wilson', 'david.wilson@yahoo.com', '+1-555-0321', 'Technical Support Needed', 'I am having trouble accessing the course materials on your website. Could someone please help me? I have tried resetting my password but still cannot log in. My username is dwilson123.', 'unread', '2025-08-11 06:37:22', '2025-08-11 06:37:22'),
(9, NULL, 'Lisa Thompson', 'lisa.thompson@email.com', '+1-555-0654', 'Group Discount Inquiry', 'Hello! I represent a small company and we are interested in enrolling 5-6 employees in your programming courses. Do you offer any group discounts or corporate training packages? Please let me know the details.', 'unread', '2025-08-11 06:37:22', '2025-08-11 06:37:22'),
(10, NULL, 'Sameer', 'sameer123@gmail.com', '3122287470', 'error', 'llll', 'unread', '2025-08-11 06:44:10', '2025-08-11 06:44:10'),
(12, NULL, 'Sameer', 'sameer123@gmail.com', '3122287470', 'i dont bla', 'dhdjdj', 'unread', '2025-08-18 03:21:59', '2025-08-18 03:21:59'),
(13, NULL, 'Sameer', 'sameerbasit@gmail.com', '3122287470', 'error', 'hdjad', 'unread', '2025-08-18 04:27:29', '2025-08-18 04:27:29'),
(15, 7, 'sameer', 'sameer@gmail.com', '1111111111', 'fshf', 'aslkcasc', 'unread', '2025-09-19 09:17:03', '2025-09-19 09:17:03');

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` int(11) NOT NULL,
  `title` varchar(200) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `duration` varchar(50) NOT NULL,
  `level` enum('Beginner','Intermediate','Advanced') DEFAULT 'Beginner',
  `features` text DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `status` enum('Active','Inactive') DEFAULT 'Active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `title`, `description`, `price`, `duration`, `level`, `features`, `image_url`, `status`, `created_at`, `updated_at`) VALUES
(2, 'Mid-Career Advancement', 'Strategic approaches for professionals looking to advance their careers and land leadership positions.', 149.00, '6 weeks', 'Intermediate', 'Leadership Skills,Strategic Thinking,Negotiation,Career Planning', 'img/course2.jpg', 'Active', '2025-08-09 09:07:39', '2025-08-09 09:07:39'),
(3, 'Executive Interview Prep', 'Master executive-level interviews and presentations with advanced strategies and insider knowledge.', 199.00, '8 weeks', 'Advanced', 'Executive Presence,Board Presentations,Strategic Vision,C-Suite Communication', 'img/course3.jpg', 'Active', '2025-08-09 09:07:39', '2025-08-09 09:07:39'),
(4, 'Tech Interview Fundamentals', 'Comprehensive preparation for technical interviews in software development and IT roles.', 129.00, '5 weeks', 'Intermediate', 'Coding Challenges,System Design,Technical Communication,Problem Solving', 'img/course4.jpg', 'Active', '2025-08-09 09:07:39', '2025-08-09 09:07:39'),
(5, 'Sales Interview Excellence', 'Master sales interviews with proven techniques, objection handling, and relationship building skills.', 119.00, '4 weeks', 'Beginner', 'Sales Techniques,Objection Handling,Client Relations,Performance Metrics', 'img/course5.jpg', 'Active', '2025-08-09 09:07:39', '2025-08-09 09:07:39'),
(6, 'Remote Work Interview Skills', 'Navigate remote work interviews and showcase your ability to excel in distributed teams.', 89.00, '3 weeks', 'Beginner', 'Remote Communication,Virtual Presence,Time Management,Digital Tools', 'img/course6.jpg', 'Active', '2025-08-09 09:07:39', '2025-08-09 09:07:39'),
(7, 'Call centers', 'For Call Centers stratregic aproch abcadefg', 99.00, '2', 'Beginner', 'comma', NULL, 'Active', '2025-08-09 09:28:07', '2025-08-09 09:49:42'),
(9, 'travel agencies', 'abcdefg', 10.00, '2', 'Intermediate', 'Resume building', NULL, 'Active', '2025-08-09 09:50:47', '2025-08-09 09:50:47'),
(10, 'Travel Agency', 'zz', 2.00, '2', 'Beginner', 'Career Guidance', NULL, 'Active', '2025-08-18 08:48:37', '2025-08-18 08:48:37');

-- --------------------------------------------------------

--
-- Table structure for table `course_recommendations`
--

CREATE TABLE `course_recommendations` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `course_id` int(11) DEFAULT NULL,
  `course_title` varchar(255) NOT NULL,
  `recommendation_reason` text NOT NULL,
  `relevance_score` decimal(3,2) DEFAULT 0.00 CHECK (`relevance_score` >= 0 and `relevance_score` <= 10),
  `difficulty_match` enum('perfect','challenging','easy') DEFAULT 'perfect',
  `estimated_completion_days` int(11) DEFAULT 30,
  `prerequisites_met` tinyint(1) DEFAULT 1,
  `career_impact_score` decimal(3,2) DEFAULT 0.00,
  `status` enum('pending','viewed','enrolled','dismissed') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `expires_at` timestamp NOT NULL DEFAULT (current_timestamp() + interval 30 day)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `course_recommendations`
--

INSERT INTO `course_recommendations` (`id`, `user_id`, `course_id`, `course_title`, `recommendation_reason`, `relevance_score`, `difficulty_match`, `estimated_completion_days`, `prerequisites_met`, `career_impact_score`, `status`, `created_at`, `expires_at`) VALUES
(71, 21, 2, 'Mid-Career Advancement', 'Recommended based on your interests and current skill level.', 7.50, 'perfect', 30, 1, 0.00, 'pending', '2025-09-15 13:39:38', '2025-10-15 13:39:38'),
(72, 21, 3, 'Executive Interview Prep', 'Recommended based on your interests and current skill level.', 7.50, 'perfect', 30, 1, 0.00, 'pending', '2025-09-15 13:39:38', '2025-10-15 13:39:38'),
(73, 21, 4, 'Tech Interview Fundamentals', 'Recommended based on your interests and current skill level.', 7.50, 'perfect', 30, 1, 0.00, 'pending', '2025-09-15 13:39:38', '2025-10-15 13:39:38'),
(74, 21, 5, 'Sales Interview Excellence', 'Recommended based on your interests and current skill level.', 7.50, 'perfect', 30, 1, 0.00, 'pending', '2025-09-15 13:39:38', '2025-10-15 13:39:38'),
(75, 21, 6, 'Remote Work Interview Skills', 'Recommended based on your interests and current skill level.', 7.50, 'perfect', 30, 1, 0.00, 'pending', '2025-09-15 13:39:38', '2025-10-15 13:39:38'),
(78, 8, 2, 'Mid-Career Advancement', 'Based on your current professional level, this course will help you advance to leadership positions.', 0.85, '', 42, 1, 0.80, 'pending', '2025-09-19 15:37:18', '2025-10-19 15:37:18'),
(79, 8, 3, 'Executive Interview Prep', 'Perfect for preparing for senior-level positions. High success rate for executive placements.', 0.92, '', 56, 1, 0.90, 'pending', '2025-09-19 15:37:18', '2025-10-19 15:37:18'),
(80, 8, 4, 'Tech Interview Fundamentals', 'Your technical background makes you ideal for tech roles. Master the most in-demand interview skills.', 0.78, '', 35, 1, 0.85, 'pending', '2025-09-19 15:37:18', '2025-10-19 15:37:18'),
(115, 7, 2, 'Mid-Career Advancement', 'Recommended based on your interests and current skill level.', 7.50, 'perfect', 30, 1, 0.00, 'pending', '2025-09-19 15:49:06', '2025-10-19 15:49:06'),
(116, 7, 3, 'Executive Interview Prep', 'Recommended based on your interests and current skill level.', 7.50, 'perfect', 30, 1, 0.00, 'pending', '2025-09-19 15:49:06', '2025-10-19 15:49:06'),
(117, 7, 4, 'Tech Interview Fundamentals', 'Recommended based on your interests and current skill level.', 7.50, 'perfect', 30, 1, 0.00, 'pending', '2025-09-19 15:49:06', '2025-10-19 15:49:06'),
(118, 7, 5, 'Sales Interview Excellence', 'Recommended based on your interests and current skill level.', 7.50, 'perfect', 30, 1, 0.00, 'pending', '2025-09-19 15:49:06', '2025-10-19 15:49:06'),
(119, 7, 6, 'Remote Work Interview Skills', 'Recommended based on your interests and current skill level.', 7.50, 'perfect', 30, 1, 0.00, 'pending', '2025-09-19 15:49:06', '2025-10-19 15:49:06'),
(120, 7, 4, 'Tech Interview Fundamentals', 'Matches your intermediate skill level. Helps with interview preparation. Enhances technical expertise', 9.00, 'perfect', 35, 1, 5.00, 'pending', '2025-09-19 15:49:22', '2025-10-19 15:49:22'),
(121, 7, 2, 'Mid-Career Advancement', 'Matches your intermediate skill level. Develops leadership capabilities', 7.50, 'perfect', 42, 1, 5.00, 'pending', '2025-09-19 15:49:22', '2025-10-19 15:49:22'),
(122, 7, 5, 'Sales Interview Excellence', 'Perfect for your current skill level. Helps with interview preparation', 7.50, 'perfect', 28, 1, 5.00, 'pending', '2025-09-19 15:49:22', '2025-10-19 15:49:22'),
(123, 7, 6, 'Remote Work Interview Skills', 'Perfect for your current skill level. Helps with interview preparation', 7.50, 'perfect', 21, 1, 5.00, 'pending', '2025-09-19 15:49:22', '2025-10-19 15:49:22'),
(124, 7, 9, 'travel agencies', 'Matches your intermediate skill level', 6.50, 'perfect', 30, 1, 5.00, 'pending', '2025-09-19 15:49:22', '2025-10-19 15:49:22'),
(125, 7, 3, 'Executive Interview Prep', 'Helps with interview preparation', 6.50, 'perfect', 56, 1, 5.00, 'pending', '2025-09-19 15:49:22', '2025-10-19 15:49:22'),
(126, 7, 10, 'Travel Agency', 'Perfect for your current skill level', 6.00, 'perfect', 30, 1, 5.00, 'pending', '2025-09-19 15:49:22', '2025-10-19 15:49:22'),
(127, 7, 7, 'Call centers', 'Perfect for your current skill level', 6.00, 'perfect', 30, 1, 5.00, 'pending', '2025-09-19 15:49:22', '2025-10-19 15:49:22'),
(128, 7, 4, 'Tech Interview Fundamentals', 'Matches your intermediate skill level. Helps with interview preparation. Enhances technical expertise', 9.00, 'perfect', 35, 1, 5.00, 'pending', '2025-09-19 15:56:54', '2025-10-19 15:56:54'),
(129, 7, 2, 'Mid-Career Advancement', 'Matches your intermediate skill level. Develops leadership capabilities', 7.50, 'perfect', 42, 1, 5.00, 'pending', '2025-09-19 15:56:54', '2025-10-19 15:56:54'),
(130, 7, 5, 'Sales Interview Excellence', 'Perfect for your current skill level. Helps with interview preparation', 7.50, 'perfect', 28, 1, 5.00, 'pending', '2025-09-19 15:56:54', '2025-10-19 15:56:54'),
(131, 7, 6, 'Remote Work Interview Skills', 'Perfect for your current skill level. Helps with interview preparation', 7.50, 'perfect', 21, 1, 5.00, 'pending', '2025-09-19 15:56:54', '2025-10-19 15:56:54'),
(132, 7, 9, 'travel agencies', 'Matches your intermediate skill level', 6.50, 'perfect', 30, 1, 5.00, 'pending', '2025-09-19 15:56:54', '2025-10-19 15:56:54'),
(133, 7, 3, 'Executive Interview Prep', 'Helps with interview preparation', 6.50, 'perfect', 56, 1, 5.00, 'pending', '2025-09-19 15:56:54', '2025-10-19 15:56:54'),
(134, 7, 10, 'Travel Agency', 'Perfect for your current skill level', 6.00, 'perfect', 30, 1, 5.00, 'pending', '2025-09-19 15:56:54', '2025-10-19 15:56:54'),
(135, 7, 7, 'Call centers', 'Perfect for your current skill level', 6.00, 'perfect', 30, 1, 5.00, 'pending', '2025-09-19 15:56:54', '2025-10-19 15:56:54'),
(136, 7, 4, 'Tech Interview Fundamentals', 'Matches your intermediate skill level. Helps with interview preparation. Enhances technical expertise', 9.00, 'perfect', 35, 1, 5.00, 'pending', '2025-09-19 15:57:05', '2025-10-19 15:57:05'),
(137, 7, 2, 'Mid-Career Advancement', 'Matches your intermediate skill level. Develops leadership capabilities', 7.50, 'perfect', 42, 1, 5.00, 'pending', '2025-09-19 15:57:05', '2025-10-19 15:57:05'),
(138, 7, 5, 'Sales Interview Excellence', 'Perfect for your current skill level. Helps with interview preparation', 7.50, 'perfect', 28, 1, 5.00, 'pending', '2025-09-19 15:57:05', '2025-10-19 15:57:05'),
(139, 7, 6, 'Remote Work Interview Skills', 'Perfect for your current skill level. Helps with interview preparation', 7.50, 'perfect', 21, 1, 5.00, 'pending', '2025-09-19 15:57:05', '2025-10-19 15:57:05'),
(140, 7, 9, 'travel agencies', 'Matches your intermediate skill level', 6.50, 'perfect', 30, 1, 5.00, 'pending', '2025-09-19 15:57:05', '2025-10-19 15:57:05'),
(141, 7, 3, 'Executive Interview Prep', 'Helps with interview preparation', 6.50, 'perfect', 56, 1, 5.00, 'pending', '2025-09-19 15:57:05', '2025-10-19 15:57:05'),
(142, 7, 10, 'Travel Agency', 'Perfect for your current skill level', 6.00, 'perfect', 30, 1, 5.00, 'pending', '2025-09-19 15:57:05', '2025-10-19 15:57:05'),
(143, 7, 7, 'Call centers', 'Perfect for your current skill level', 6.00, 'perfect', 30, 1, 5.00, 'pending', '2025-09-19 15:57:05', '2025-10-19 15:57:05'),
(144, 7, 4, 'Tech Interview Fundamentals', 'Matches your intermediate skill level. Helps with interview preparation. Enhances technical expertise', 9.00, 'perfect', 35, 1, 5.00, 'pending', '2025-09-19 15:57:10', '2025-10-19 15:57:10'),
(145, 7, 2, 'Mid-Career Advancement', 'Matches your intermediate skill level. Develops leadership capabilities', 7.50, 'perfect', 42, 1, 5.00, 'pending', '2025-09-19 15:57:10', '2025-10-19 15:57:10'),
(146, 7, 5, 'Sales Interview Excellence', 'Perfect for your current skill level. Helps with interview preparation', 7.50, 'perfect', 28, 1, 5.00, 'pending', '2025-09-19 15:57:10', '2025-10-19 15:57:10'),
(147, 7, 6, 'Remote Work Interview Skills', 'Perfect for your current skill level. Helps with interview preparation', 7.50, 'perfect', 21, 1, 5.00, 'pending', '2025-09-19 15:57:10', '2025-10-19 15:57:10'),
(148, 7, 9, 'travel agencies', 'Matches your intermediate skill level', 6.50, 'perfect', 30, 1, 5.00, 'pending', '2025-09-19 15:57:10', '2025-10-19 15:57:10'),
(149, 7, 3, 'Executive Interview Prep', 'Helps with interview preparation', 6.50, 'perfect', 56, 1, 5.00, 'pending', '2025-09-19 15:57:10', '2025-10-19 15:57:10'),
(150, 7, 10, 'Travel Agency', 'Perfect for your current skill level', 6.00, 'perfect', 30, 1, 5.00, 'pending', '2025-09-19 15:57:10', '2025-10-19 15:57:10'),
(151, 7, 7, 'Call centers', 'Perfect for your current skill level', 6.00, 'perfect', 30, 1, 5.00, 'pending', '2025-09-19 15:57:10', '2025-10-19 15:57:10'),
(152, 7, 4, 'Tech Interview Fundamentals', 'Matches your intermediate skill level. Helps with interview preparation. Enhances technical expertise', 9.00, 'perfect', 35, 1, 5.00, 'pending', '2025-09-19 16:07:42', '2025-10-19 16:07:42'),
(153, 7, 2, 'Mid-Career Advancement', 'Matches your intermediate skill level. Develops leadership capabilities', 7.50, 'perfect', 42, 1, 5.00, 'pending', '2025-09-19 16:07:42', '2025-10-19 16:07:42'),
(154, 7, 5, 'Sales Interview Excellence', 'Perfect for your current skill level. Helps with interview preparation', 7.50, 'perfect', 28, 1, 5.00, 'pending', '2025-09-19 16:07:42', '2025-10-19 16:07:42'),
(155, 7, 6, 'Remote Work Interview Skills', 'Perfect for your current skill level. Helps with interview preparation', 7.50, 'perfect', 21, 1, 5.00, 'pending', '2025-09-19 16:07:42', '2025-10-19 16:07:42'),
(156, 7, 9, 'travel agencies', 'Matches your intermediate skill level', 6.50, 'perfect', 30, 1, 5.00, 'pending', '2025-09-19 16:07:42', '2025-10-19 16:07:42'),
(157, 7, 3, 'Executive Interview Prep', 'Helps with interview preparation', 6.50, 'perfect', 56, 1, 5.00, 'pending', '2025-09-19 16:07:42', '2025-10-19 16:07:42'),
(158, 7, 10, 'Travel Agency', 'Perfect for your current skill level', 6.00, 'perfect', 30, 1, 5.00, 'pending', '2025-09-19 16:07:42', '2025-10-19 16:07:42'),
(159, 7, 7, 'Call centers', 'Perfect for your current skill level', 6.00, 'perfect', 30, 1, 5.00, 'pending', '2025-09-19 16:07:42', '2025-10-19 16:07:42'),
(160, 7, 4, 'Tech Interview Fundamentals', 'Matches your intermediate skill level. Helps with interview preparation. Enhances technical expertise', 9.00, 'perfect', 35, 1, 5.00, 'pending', '2025-09-19 16:18:29', '2025-10-19 16:18:29'),
(161, 7, 2, 'Mid-Career Advancement', 'Matches your intermediate skill level. Develops leadership capabilities', 7.50, 'perfect', 42, 1, 5.00, 'pending', '2025-09-19 16:18:29', '2025-10-19 16:18:29'),
(162, 7, 5, 'Sales Interview Excellence', 'Perfect for your current skill level. Helps with interview preparation', 7.50, 'perfect', 28, 1, 5.00, 'pending', '2025-09-19 16:18:29', '2025-10-19 16:18:29'),
(163, 7, 6, 'Remote Work Interview Skills', 'Perfect for your current skill level. Helps with interview preparation', 7.50, 'perfect', 21, 1, 5.00, 'pending', '2025-09-19 16:18:29', '2025-10-19 16:18:29'),
(164, 7, 9, 'travel agencies', 'Matches your intermediate skill level', 6.50, 'perfect', 30, 1, 5.00, 'pending', '2025-09-19 16:18:29', '2025-10-19 16:18:29'),
(165, 7, 3, 'Executive Interview Prep', 'Helps with interview preparation', 6.50, 'perfect', 56, 1, 5.00, 'pending', '2025-09-19 16:18:29', '2025-10-19 16:18:29'),
(166, 7, 10, 'Travel Agency', 'Perfect for your current skill level', 6.00, 'perfect', 30, 1, 5.00, 'pending', '2025-09-19 16:18:29', '2025-10-19 16:18:29'),
(167, 7, 7, 'Call centers', 'Perfect for your current skill level', 6.00, 'perfect', 30, 1, 5.00, 'pending', '2025-09-19 16:18:29', '2025-10-19 16:18:29'),
(168, 7, 4, 'Tech Interview Fundamentals', 'Matches your intermediate skill level. Helps with interview preparation. Enhances technical expertise', 9.00, 'perfect', 35, 1, 5.00, 'pending', '2025-09-19 16:19:01', '2025-10-19 16:19:01'),
(169, 7, 2, 'Mid-Career Advancement', 'Matches your intermediate skill level. Develops leadership capabilities', 7.50, 'perfect', 42, 1, 5.00, 'pending', '2025-09-19 16:19:01', '2025-10-19 16:19:01'),
(170, 7, 5, 'Sales Interview Excellence', 'Perfect for your current skill level. Helps with interview preparation', 7.50, 'perfect', 28, 1, 5.00, 'pending', '2025-09-19 16:19:01', '2025-10-19 16:19:01'),
(171, 7, 6, 'Remote Work Interview Skills', 'Perfect for your current skill level. Helps with interview preparation', 7.50, 'perfect', 21, 1, 5.00, 'pending', '2025-09-19 16:19:01', '2025-10-19 16:19:01'),
(172, 7, 9, 'travel agencies', 'Matches your intermediate skill level', 6.50, 'perfect', 30, 1, 5.00, 'pending', '2025-09-19 16:19:01', '2025-10-19 16:19:01'),
(173, 7, 3, 'Executive Interview Prep', 'Helps with interview preparation', 6.50, 'perfect', 56, 1, 5.00, 'pending', '2025-09-19 16:19:01', '2025-10-19 16:19:01'),
(174, 7, 10, 'Travel Agency', 'Perfect for your current skill level', 6.00, 'perfect', 30, 1, 5.00, 'pending', '2025-09-19 16:19:01', '2025-10-19 16:19:01'),
(175, 7, 7, 'Call centers', 'Perfect for your current skill level', 6.00, 'perfect', 30, 1, 5.00, 'pending', '2025-09-19 16:19:01', '2025-10-19 16:19:01'),
(176, 7, 4, 'Tech Interview Fundamentals', 'Matches your intermediate skill level. Helps with interview preparation. Enhances technical expertise', 9.00, 'perfect', 35, 1, 5.00, 'pending', '2025-09-19 17:54:27', '2025-10-19 17:54:27'),
(177, 7, 2, 'Mid-Career Advancement', 'Matches your intermediate skill level. Develops leadership capabilities', 7.50, 'perfect', 42, 1, 5.00, 'pending', '2025-09-19 17:54:27', '2025-10-19 17:54:27'),
(178, 7, 5, 'Sales Interview Excellence', 'Perfect for your current skill level. Helps with interview preparation', 7.50, 'perfect', 28, 1, 5.00, 'pending', '2025-09-19 17:54:27', '2025-10-19 17:54:27'),
(179, 7, 6, 'Remote Work Interview Skills', 'Perfect for your current skill level. Helps with interview preparation', 7.50, 'perfect', 21, 1, 5.00, 'pending', '2025-09-19 17:54:27', '2025-10-19 17:54:27'),
(180, 7, 9, 'travel agencies', 'Matches your intermediate skill level', 6.50, 'perfect', 30, 1, 5.00, 'pending', '2025-09-19 17:54:27', '2025-10-19 17:54:27'),
(181, 7, 3, 'Executive Interview Prep', 'Helps with interview preparation', 6.50, 'perfect', 56, 1, 5.00, 'pending', '2025-09-19 17:54:27', '2025-10-19 17:54:27'),
(182, 7, 10, 'Travel Agency', 'Perfect for your current skill level', 6.00, 'perfect', 30, 1, 5.00, 'pending', '2025-09-19 17:54:27', '2025-10-19 17:54:27'),
(183, 7, 7, 'Call centers', 'Perfect for your current skill level', 6.00, 'perfect', 30, 1, 5.00, 'pending', '2025-09-19 17:54:27', '2025-10-19 17:54:27'),
(184, 7, 4, 'Tech Interview Fundamentals', 'Matches your intermediate skill level. Helps with interview preparation. Enhances technical expertise', 9.00, 'perfect', 35, 1, 5.00, 'pending', '2025-09-19 17:58:58', '2025-10-19 17:58:58'),
(185, 7, 2, 'Mid-Career Advancement', 'Matches your intermediate skill level. Develops leadership capabilities', 7.50, 'perfect', 42, 1, 5.00, 'pending', '2025-09-19 17:58:58', '2025-10-19 17:58:58'),
(186, 7, 5, 'Sales Interview Excellence', 'Perfect for your current skill level. Helps with interview preparation', 7.50, 'perfect', 28, 1, 5.00, 'pending', '2025-09-19 17:58:58', '2025-10-19 17:58:58'),
(187, 7, 6, 'Remote Work Interview Skills', 'Perfect for your current skill level. Helps with interview preparation', 7.50, 'perfect', 21, 1, 5.00, 'pending', '2025-09-19 17:58:58', '2025-10-19 17:58:58'),
(188, 7, 9, 'travel agencies', 'Matches your intermediate skill level', 6.50, 'perfect', 30, 1, 5.00, 'pending', '2025-09-19 17:58:58', '2025-10-19 17:58:58'),
(189, 7, 3, 'Executive Interview Prep', 'Helps with interview preparation', 6.50, 'perfect', 56, 1, 5.00, 'pending', '2025-09-19 17:58:58', '2025-10-19 17:58:58'),
(190, 7, 10, 'Travel Agency', 'Perfect for your current skill level', 6.00, 'perfect', 30, 1, 5.00, 'pending', '2025-09-19 17:58:58', '2025-10-19 17:58:58'),
(191, 7, 7, 'Call centers', 'Perfect for your current skill level', 6.00, 'perfect', 30, 1, 5.00, 'pending', '2025-09-19 17:58:58', '2025-10-19 17:58:58'),
(192, 7, 4, 'Tech Interview Fundamentals', 'Matches your intermediate skill level. Helps with interview preparation. Enhances technical expertise', 9.00, 'perfect', 35, 1, 5.00, 'pending', '2025-09-19 18:00:18', '2025-10-19 18:00:18'),
(193, 7, 2, 'Mid-Career Advancement', 'Matches your intermediate skill level. Develops leadership capabilities', 7.50, 'perfect', 42, 1, 5.00, 'pending', '2025-09-19 18:00:18', '2025-10-19 18:00:18'),
(194, 7, 5, 'Sales Interview Excellence', 'Perfect for your current skill level. Helps with interview preparation', 7.50, 'perfect', 28, 1, 5.00, 'pending', '2025-09-19 18:00:18', '2025-10-19 18:00:18'),
(195, 7, 6, 'Remote Work Interview Skills', 'Perfect for your current skill level. Helps with interview preparation', 7.50, 'perfect', 21, 1, 5.00, 'pending', '2025-09-19 18:00:18', '2025-10-19 18:00:18'),
(196, 7, 9, 'travel agencies', 'Matches your intermediate skill level', 6.50, 'perfect', 30, 1, 5.00, 'pending', '2025-09-19 18:00:18', '2025-10-19 18:00:18'),
(197, 7, 3, 'Executive Interview Prep', 'Helps with interview preparation', 6.50, 'perfect', 56, 1, 5.00, 'pending', '2025-09-19 18:00:18', '2025-10-19 18:00:18'),
(198, 7, 10, 'Travel Agency', 'Perfect for your current skill level', 6.00, 'perfect', 30, 1, 5.00, 'pending', '2025-09-19 18:00:18', '2025-10-19 18:00:18'),
(199, 7, 7, 'Call centers', 'Perfect for your current skill level', 6.00, 'perfect', 30, 1, 5.00, 'pending', '2025-09-19 18:00:18', '2025-10-19 18:00:18'),
(200, 7, 4, 'Tech Interview Fundamentals', 'Matches your intermediate skill level. Helps with interview preparation. Enhances technical expertise', 9.00, 'perfect', 35, 1, 5.00, 'pending', '2025-09-19 18:00:47', '2025-10-19 18:00:47'),
(201, 7, 2, 'Mid-Career Advancement', 'Matches your intermediate skill level. Develops leadership capabilities', 7.50, 'perfect', 42, 1, 5.00, 'pending', '2025-09-19 18:00:47', '2025-10-19 18:00:47'),
(202, 7, 5, 'Sales Interview Excellence', 'Perfect for your current skill level. Helps with interview preparation', 7.50, 'perfect', 28, 1, 5.00, 'pending', '2025-09-19 18:00:47', '2025-10-19 18:00:47'),
(203, 7, 6, 'Remote Work Interview Skills', 'Perfect for your current skill level. Helps with interview preparation', 7.50, 'perfect', 21, 1, 5.00, 'pending', '2025-09-19 18:00:47', '2025-10-19 18:00:47'),
(204, 7, 9, 'travel agencies', 'Matches your intermediate skill level', 6.50, 'perfect', 30, 1, 5.00, 'pending', '2025-09-19 18:00:47', '2025-10-19 18:00:47'),
(205, 7, 3, 'Executive Interview Prep', 'Helps with interview preparation', 6.50, 'perfect', 56, 1, 5.00, 'pending', '2025-09-19 18:00:47', '2025-10-19 18:00:47'),
(206, 7, 10, 'Travel Agency', 'Perfect for your current skill level', 6.00, 'perfect', 30, 1, 5.00, 'pending', '2025-09-19 18:00:47', '2025-10-19 18:00:47'),
(207, 7, 7, 'Call centers', 'Perfect for your current skill level', 6.00, 'perfect', 30, 1, 5.00, 'pending', '2025-09-19 18:00:47', '2025-10-19 18:00:47');

-- --------------------------------------------------------

--
-- Table structure for table `enrollments`
--

CREATE TABLE `enrollments` (
  `id` int(11) NOT NULL,
  `enrollment_id` varchar(20) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `country` varchar(100) NOT NULL,
  `course_name` varchar(255) DEFAULT NULL,
  `course_price` decimal(10,2) DEFAULT NULL,
  `experience_level` varchar(50) DEFAULT NULL,
  `schedule_preference` varchar(100) DEFAULT NULL,
  `career_goals` text DEFAULT NULL,
  `payment_method` varchar(50) NOT NULL,
  `additional_services` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`additional_services`)),
  `newsletter_subscription` tinyint(1) DEFAULT 0,
  `enrollment_date` datetime DEFAULT current_timestamp(),
  `status` enum('pending','confirmed','active','completed','cancelled') DEFAULT 'pending',
  `admin_viewed` tinyint(1) DEFAULT 0,
  `payment_status` enum('pending','completed','failed','refunded') DEFAULT 'pending',
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `enrollments`
--

INSERT INTO `enrollments` (`id`, `enrollment_id`, `user_id`, `first_name`, `last_name`, `email`, `phone`, `country`, `course_name`, `course_price`, `experience_level`, `schedule_preference`, `career_goals`, `payment_method`, `additional_services`, `newsletter_subscription`, `enrollment_date`, `status`, `admin_viewed`, `payment_status`, `created_at`, `updated_at`) VALUES
(1, 'ENR202508117533', NULL, 'Test', 'Student', 'test@example.com', '+1234567890', 'US', NULL, NULL, 'fresh-graduate', 'weekdays', 'Get a better job', 'card', '[]', 1, '2025-08-11 05:42:54', 'pending', 0, 'pending', '2025-08-11 05:42:54', '2025-08-11 05:42:54'),
(2, 'ENR202508117426', NULL, 'Test', 'User', 'test@example.com', '123456789', 'US', NULL, NULL, 'fresh-graduate', 'weekdays', '', 'card', '[]', 0, '2025-08-11 06:16:24', 'pending', 0, 'pending', '2025-08-11 06:16:24', '2025-08-11 06:16:24'),
(3, 'ENR202508118142', NULL, 'sameer', 'abdul basit', 'sameer123@gmail.com', '3122287470', 'IN', NULL, NULL, 'fresh-graduate', 'weekdays', '', 'card', '[]', 1, '2025-08-11 06:19:54', 'pending', 0, 'pending', '2025-08-11 06:19:54', '2025-08-11 06:19:54'),
(4, 'ENR202508115818', NULL, 'sameer', 'abdul basit', 'sam@gmail.com', '3122287470', 'CA', NULL, NULL, 'fresh-graduate', 'weekdays', '', 'card', '[]', 1, '2025-08-11 06:23:50', 'pending', 0, 'pending', '2025-08-11 06:23:50', '2025-08-11 06:23:50'),
(5, 'ENR202508117434', NULL, 'sameer', 'abdul basit', 'sam@gmail.com', '0322222222', 'US', NULL, NULL, 'fresh-graduate', 'weekdays', '', 'card', '[]', 1, '2025-08-11 06:45:22', 'pending', 0, 'pending', '2025-08-11 06:45:22', '2025-08-11 06:45:22'),
(6, 'ENR202508114223', NULL, 'sameer', 'abdul basit', 'sameerkong42@gamil.com', '3122287470', 'DE', NULL, NULL, 'fresh-graduate', 'weekdays', '', 'card', '[]', 1, '2025-08-11 06:49:11', 'pending', 0, 'pending', '2025-08-11 06:49:11', '2025-08-11 06:49:11'),
(7, 'ENR202508112880', NULL, 'sameer', 'abdul basit', 'sameer123@gmail.com', '3122287470', 'IN', NULL, NULL, 'fresh-graduate', 'weekdays', '', 'card', '[]', 1, '2025-08-11 10:24:32', 'pending', 0, 'pending', '2025-08-11 10:24:32', '2025-08-11 10:24:32'),
(8, 'ENR202508188630', NULL, 'sameer', 'abdul basit', 'sameer123@gmail.com', '3122287470', 'PK', NULL, NULL, '0-2-years', 'weekends', '', 'card', '[]', 1, '2025-08-18 04:26:48', 'pending', 0, 'pending', '2025-08-18 04:26:48', '2025-08-18 04:26:48'),
(9, 'ENR202509153073', NULL, 'sameer', 'abdul basit', 'sam@gmail.com', '3122287470', 'PK', NULL, NULL, '0-2-years', 'weekends', '', 'card', '[]', 1, '2025-09-15 04:22:43', 'pending', 0, 'pending', '2025-09-15 04:22:43', '2025-09-15 04:22:43');

-- --------------------------------------------------------

--
-- Table structure for table `quiz_recommendations`
--

CREATE TABLE `quiz_recommendations` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `quiz_category` varchar(100) NOT NULL,
  `quiz_title` varchar(255) NOT NULL,
  `quiz_description` text NOT NULL,
  `difficulty_level` enum('beginner','intermediate','advanced','expert') NOT NULL,
  `estimated_duration_minutes` int(11) DEFAULT 15,
  `skills_assessed` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`skills_assessed`)),
  `recommendation_reason` text NOT NULL,
  `priority_score` decimal(3,2) DEFAULT 5.00,
  `status` enum('pending','viewed','started','completed','dismissed') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `expires_at` timestamp NOT NULL DEFAULT (current_timestamp() + interval 14 day)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `quiz_recommendations`
--

INSERT INTO `quiz_recommendations` (`id`, `user_id`, `quiz_category`, `quiz_title`, `quiz_description`, `difficulty_level`, `estimated_duration_minutes`, `skills_assessed`, `recommendation_reason`, `priority_score`, `status`, `created_at`, `expires_at`) VALUES
(10, 7, 'Interview Preparation', 'Technical Interview Assessment', 'Evaluate your readiness for technical interviews with coding challenges and system design questions.', 'beginner', 30, '[\"problem_solving\",\"coding\",\"system_design\"]', 'Based on your technical background and career goals', 5.00, 'pending', '2025-09-19 15:49:22', '2025-10-03 15:49:22'),
(11, 7, 'Communication Skills', 'Professional Communication Assessment', 'Assess your communication skills including presentation, writing, and interpersonal abilities.', 'beginner', 20, '[\"verbal_communication\",\"written_communication\",\"presentation\"]', 'Essential for career advancement in any field', 5.00, 'pending', '2025-09-19 15:49:22', '2025-10-03 15:49:22'),
(12, 7, 'Leadership Potential', 'Leadership Readiness Assessment', 'Discover your leadership potential and areas for development in management roles.', 'beginner', 25, '[\"leadership\",\"team_management\",\"decision_making\"]', 'Perfect for aspiring leaders and managers', 5.00, 'pending', '2025-09-19 15:49:22', '2025-10-03 15:49:22'),
(13, 7, 'Interview Preparation', 'Technical Interview Assessment', 'Evaluate your readiness for technical interviews with coding challenges and system design questions.', 'beginner', 30, '[\"problem_solving\",\"coding\",\"system_design\"]', 'Based on your technical background and career goals', 5.00, 'pending', '2025-09-19 15:56:54', '2025-10-03 15:56:54'),
(14, 7, 'Communication Skills', 'Professional Communication Assessment', 'Assess your communication skills including presentation, writing, and interpersonal abilities.', 'beginner', 20, '[\"verbal_communication\",\"written_communication\",\"presentation\"]', 'Essential for career advancement in any field', 5.00, 'pending', '2025-09-19 15:56:54', '2025-10-03 15:56:54'),
(15, 7, 'Leadership Potential', 'Leadership Readiness Assessment', 'Discover your leadership potential and areas for development in management roles.', 'beginner', 25, '[\"leadership\",\"team_management\",\"decision_making\"]', 'Perfect for aspiring leaders and managers', 5.00, 'pending', '2025-09-19 15:56:54', '2025-10-03 15:56:54'),
(16, 7, 'Interview Preparation', 'Technical Interview Assessment', 'Evaluate your readiness for technical interviews with coding challenges and system design questions.', 'beginner', 30, '[\"problem_solving\",\"coding\",\"system_design\"]', 'Based on your technical background and career goals', 5.00, 'pending', '2025-09-19 15:57:05', '2025-10-03 15:57:05'),
(17, 7, 'Communication Skills', 'Professional Communication Assessment', 'Assess your communication skills including presentation, writing, and interpersonal abilities.', 'beginner', 20, '[\"verbal_communication\",\"written_communication\",\"presentation\"]', 'Essential for career advancement in any field', 5.00, 'pending', '2025-09-19 15:57:05', '2025-10-03 15:57:05'),
(18, 7, 'Leadership Potential', 'Leadership Readiness Assessment', 'Discover your leadership potential and areas for development in management roles.', 'beginner', 25, '[\"leadership\",\"team_management\",\"decision_making\"]', 'Perfect for aspiring leaders and managers', 5.00, 'pending', '2025-09-19 15:57:05', '2025-10-03 15:57:05'),
(19, 7, 'Interview Preparation', 'Technical Interview Assessment', 'Evaluate your readiness for technical interviews with coding challenges and system design questions.', 'beginner', 30, '[\"problem_solving\",\"coding\",\"system_design\"]', 'Based on your technical background and career goals', 5.00, 'pending', '2025-09-19 15:57:10', '2025-10-03 15:57:10'),
(20, 7, 'Communication Skills', 'Professional Communication Assessment', 'Assess your communication skills including presentation, writing, and interpersonal abilities.', 'beginner', 20, '[\"verbal_communication\",\"written_communication\",\"presentation\"]', 'Essential for career advancement in any field', 5.00, 'pending', '2025-09-19 15:57:10', '2025-10-03 15:57:10'),
(21, 7, 'Leadership Potential', 'Leadership Readiness Assessment', 'Discover your leadership potential and areas for development in management roles.', 'beginner', 25, '[\"leadership\",\"team_management\",\"decision_making\"]', 'Perfect for aspiring leaders and managers', 5.00, 'pending', '2025-09-19 15:57:10', '2025-10-03 15:57:10'),
(22, 8, 'professional-skills', 'Communication & Leadership Assessment', 'Test your communication and leadership skills with real-world scenarios.', 'intermediate', 25, '[\"Communication\", \"Leadership\", \"Team Management\"]', 'Based on your career goals, this quiz will help identify areas for improvement.', 0.80, 'pending', '2025-09-19 16:03:29', '2025-10-03 16:03:29'),
(23, 7, 'Interview Preparation', 'Technical Interview Assessment', 'Evaluate your readiness for technical interviews with coding challenges and system design questions.', 'beginner', 30, '[\"problem_solving\",\"coding\",\"system_design\"]', 'Based on your technical background and career goals', 5.00, 'pending', '2025-09-19 16:07:42', '2025-10-03 16:07:42'),
(24, 7, 'Communication Skills', 'Professional Communication Assessment', 'Assess your communication skills including presentation, writing, and interpersonal abilities.', 'beginner', 20, '[\"verbal_communication\",\"written_communication\",\"presentation\"]', 'Essential for career advancement in any field', 5.00, 'pending', '2025-09-19 16:07:42', '2025-10-03 16:07:42'),
(25, 7, 'Leadership Potential', 'Leadership Readiness Assessment', 'Discover your leadership potential and areas for development in management roles.', 'beginner', 25, '[\"leadership\",\"team_management\",\"decision_making\"]', 'Perfect for aspiring leaders and managers', 5.00, 'pending', '2025-09-19 16:07:42', '2025-10-03 16:07:42'),
(26, 7, 'Interview Preparation', 'Technical Interview Assessment', 'Evaluate your readiness for technical interviews with coding challenges and system design questions.', 'beginner', 30, '[\"problem_solving\",\"coding\",\"system_design\"]', 'Based on your technical background and career goals', 5.00, 'pending', '2025-09-19 16:18:29', '2025-10-03 16:18:29'),
(27, 7, 'Communication Skills', 'Professional Communication Assessment', 'Assess your communication skills including presentation, writing, and interpersonal abilities.', 'beginner', 20, '[\"verbal_communication\",\"written_communication\",\"presentation\"]', 'Essential for career advancement in any field', 5.00, 'pending', '2025-09-19 16:18:29', '2025-10-03 16:18:29'),
(28, 7, 'Leadership Potential', 'Leadership Readiness Assessment', 'Discover your leadership potential and areas for development in management roles.', 'beginner', 25, '[\"leadership\",\"team_management\",\"decision_making\"]', 'Perfect for aspiring leaders and managers', 5.00, 'pending', '2025-09-19 16:18:29', '2025-10-03 16:18:29'),
(29, 7, 'Interview Preparation', 'Technical Interview Assessment', 'Evaluate your readiness for technical interviews with coding challenges and system design questions.', 'beginner', 30, '[\"problem_solving\",\"coding\",\"system_design\"]', 'Based on your technical background and career goals', 5.00, 'pending', '2025-09-19 16:19:01', '2025-10-03 16:19:01'),
(30, 7, 'Communication Skills', 'Professional Communication Assessment', 'Assess your communication skills including presentation, writing, and interpersonal abilities.', 'beginner', 20, '[\"verbal_communication\",\"written_communication\",\"presentation\"]', 'Essential for career advancement in any field', 5.00, 'pending', '2025-09-19 16:19:01', '2025-10-03 16:19:01'),
(31, 7, 'Leadership Potential', 'Leadership Readiness Assessment', 'Discover your leadership potential and areas for development in management roles.', 'beginner', 25, '[\"leadership\",\"team_management\",\"decision_making\"]', 'Perfect for aspiring leaders and managers', 5.00, 'pending', '2025-09-19 16:19:01', '2025-10-03 16:19:01'),
(32, 7, 'Interview Preparation', 'Technical Interview Assessment', 'Evaluate your readiness for technical interviews with coding challenges and system design questions.', 'beginner', 30, '[\"problem_solving\",\"coding\",\"system_design\"]', 'Based on your technical background and career goals', 5.00, 'pending', '2025-09-19 17:54:27', '2025-10-03 17:54:27'),
(33, 7, 'Communication Skills', 'Professional Communication Assessment', 'Assess your communication skills including presentation, writing, and interpersonal abilities.', 'beginner', 20, '[\"verbal_communication\",\"written_communication\",\"presentation\"]', 'Essential for career advancement in any field', 5.00, 'pending', '2025-09-19 17:54:27', '2025-10-03 17:54:27'),
(34, 7, 'Leadership Potential', 'Leadership Readiness Assessment', 'Discover your leadership potential and areas for development in management roles.', 'beginner', 25, '[\"leadership\",\"team_management\",\"decision_making\"]', 'Perfect for aspiring leaders and managers', 5.00, 'pending', '2025-09-19 17:54:27', '2025-10-03 17:54:27'),
(35, 7, 'Interview Preparation', 'Technical Interview Assessment', 'Evaluate your readiness for technical interviews with coding challenges and system design questions.', 'beginner', 30, '[\"problem_solving\",\"coding\",\"system_design\"]', 'Based on your technical background and career goals', 5.00, 'pending', '2025-09-19 17:58:58', '2025-10-03 17:58:58'),
(36, 7, 'Communication Skills', 'Professional Communication Assessment', 'Assess your communication skills including presentation, writing, and interpersonal abilities.', 'beginner', 20, '[\"verbal_communication\",\"written_communication\",\"presentation\"]', 'Essential for career advancement in any field', 5.00, 'pending', '2025-09-19 17:58:58', '2025-10-03 17:58:58'),
(37, 7, 'Leadership Potential', 'Leadership Readiness Assessment', 'Discover your leadership potential and areas for development in management roles.', 'beginner', 25, '[\"leadership\",\"team_management\",\"decision_making\"]', 'Perfect for aspiring leaders and managers', 5.00, 'pending', '2025-09-19 17:58:58', '2025-10-03 17:58:58'),
(38, 7, 'Interview Preparation', 'Technical Interview Assessment', 'Evaluate your readiness for technical interviews with coding challenges and system design questions.', 'beginner', 30, '[\"problem_solving\",\"coding\",\"system_design\"]', 'Based on your technical background and career goals', 5.00, 'pending', '2025-09-19 18:00:18', '2025-10-03 18:00:18'),
(39, 7, 'Communication Skills', 'Professional Communication Assessment', 'Assess your communication skills including presentation, writing, and interpersonal abilities.', 'beginner', 20, '[\"verbal_communication\",\"written_communication\",\"presentation\"]', 'Essential for career advancement in any field', 5.00, 'pending', '2025-09-19 18:00:18', '2025-10-03 18:00:18'),
(40, 7, 'Leadership Potential', 'Leadership Readiness Assessment', 'Discover your leadership potential and areas for development in management roles.', 'beginner', 25, '[\"leadership\",\"team_management\",\"decision_making\"]', 'Perfect for aspiring leaders and managers', 5.00, 'pending', '2025-09-19 18:00:18', '2025-10-03 18:00:18'),
(41, 7, 'Interview Preparation', 'Technical Interview Assessment', 'Evaluate your readiness for technical interviews with coding challenges and system design questions.', 'beginner', 30, '[\"problem_solving\",\"coding\",\"system_design\"]', 'Based on your technical background and career goals', 5.00, 'pending', '2025-09-19 18:00:47', '2025-10-03 18:00:47'),
(42, 7, 'Communication Skills', 'Professional Communication Assessment', 'Assess your communication skills including presentation, writing, and interpersonal abilities.', 'beginner', 20, '[\"verbal_communication\",\"written_communication\",\"presentation\"]', 'Essential for career advancement in any field', 5.00, 'pending', '2025-09-19 18:00:47', '2025-10-03 18:00:47'),
(43, 7, 'Leadership Potential', 'Leadership Readiness Assessment', 'Discover your leadership potential and areas for development in management roles.', 'beginner', 25, '[\"leadership\",\"team_management\",\"decision_making\"]', 'Perfect for aspiring leaders and managers', 5.00, 'pending', '2025-09-19 18:00:47', '2025-10-03 18:00:47');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `profile_picture` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('Student','Admin','Instructor') DEFAULT 'Student',
  `status` enum('Active','Inactive') DEFAULT 'Active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fullname`, `email`, `profile_picture`, `password`, `role`, `status`, `created_at`, `updated_at`) VALUES
(7, 'affan', 'affan@gmail.com', 'uploads/profiles/profile_7_1758298032.jpg', '$2y$10$ZVnIZcCSCfp1PvzUzqnTke7ammg0vthPs8qF1e0TjskKKk3tieBo.', 'Student', 'Active', '2025-08-05 00:58:40', '2025-09-19 16:07:12'),
(8, 'muhammad sameer', 'sam@gmail.com', NULL, '$2y$10$Skdd0vRW6P8hh0e/nRBtI.otPUCQ1j18omj31q7N4wzAKfsNTDfXe', 'Student', 'Active', '2025-08-05 00:58:40', '2025-08-05 00:58:40'),
(9, 'sam', 'sameer123@gmail.com', NULL, '$2y$10$2F/1wtiJTeAmmFDsnW0y.eMssfru3g8rbk0OxFgkbW/XMdPQ8DxpG', 'Student', 'Active', '2025-08-05 00:58:40', '2025-08-05 00:58:40'),
(14, 'muhammad sameer', 'sameerbasit@gmail.com', NULL, '$2y$10$yM3ICnklaY.NJ.lJKcfhcel5mN31Bh3aFc7ZuXRvYq35KKjLnlv/y', 'Student', 'Active', '2025-08-06 18:25:23', '2025-08-06 18:25:23'),
(15, 'muhammad sameer', 'sameerkong42@gamil.com', NULL, '$2y$10$d4qLbVosAlQ9R6NWzzTIcu1G3j9MZp12l5J97z3DpLoeooMedPGdO', 'Student', 'Active', '2025-08-06 18:30:20', '2025-08-06 18:30:20'),
(16, 'sam', 'sameer1234@gmail.com', NULL, '$2y$10$lBCRNwA86ZiyNeo7e63nVOKHJVh9/0zKZYZE9fbdG9YyQTo6LFjg.', 'Student', 'Active', '2025-08-11 13:43:17', '2025-08-11 13:43:17'),
(17, 'admin', 'admin@gmail.com', NULL, '$2y$10$3VO/.yDYpcQCirYIwJRexOoT5wZ3jVL7kPXiB7h.BLdK483fjrAiW', 'Student', 'Active', '2025-08-18 10:55:08', '2025-08-18 10:55:08'),
(18, 'student', 'student@gmail.com', NULL, '$2y$10$cK2.bt9.AWS3wLxwoDbrZ.TlizKmaRR/EiB90krvfex.aVAwEL8de', 'Student', 'Active', '2025-08-18 11:25:05', '2025-08-18 11:25:05'),
(19, 'Student1', 'student123@gmail.com', NULL, '$2y$10$a2dmwwcRpFxM/2C9h2SciuSX8r3s/qHIFI2DruDVs6ntKBv9wDyyq', 'Student', 'Active', '2025-08-21 17:21:18', '2025-08-21 17:21:18'),
(20, 'student12', 'student12@gmail.com', NULL, '$2y$10$N.q2cFByP9pTnmUkeScYZOlC02xGR6358fScVCQEgriIsQ5b7QoQy', 'Student', 'Active', '2025-08-25 17:23:10', '2025-08-25 17:23:10'),
(21, 'affan1234', 'affan1234@gmail.com', 'uploads/profile_pictures/profile_68c7ea6d7512f8.81622401.jpg', '$2y$10$SZbtiMsb0IkoM65PmivqOOw2PDoB55g2CllwOrjJ5P5PJc6wl0cn2', 'Student', 'Active', '2025-09-15 10:29:01', '2025-09-15 11:55:34');

-- --------------------------------------------------------

--
-- Table structure for table `user_capabilities`
--

CREATE TABLE `user_capabilities` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `skill_category` varchar(100) NOT NULL,
  `skill_name` varchar(100) NOT NULL,
  `proficiency_level` enum('beginner','intermediate','advanced','expert') DEFAULT 'beginner',
  `years_experience` decimal(3,1) DEFAULT 0.0,
  `self_rating` int(11) DEFAULT 0 CHECK (`self_rating` >= 0 and `self_rating` <= 10),
  `verified_rating` int(11) DEFAULT 0 CHECK (`verified_rating` >= 0 and `verified_rating` <= 10),
  `last_assessed` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_capabilities`
--

INSERT INTO `user_capabilities` (`id`, `user_id`, `skill_category`, `skill_name`, `proficiency_level`, `years_experience`, `self_rating`, `verified_rating`, `last_assessed`, `created_at`, `updated_at`) VALUES
(10, 21, 'DevOps', 'Git', 'beginner', 0.0, 3, 0, NULL, '2025-09-15 13:39:17', '2025-09-15 13:39:17'),
(23, 7, 'Programming', 'Python', 'intermediate', 2.0, 7, 0, NULL, '2025-09-19 15:57:05', '2025-09-19 15:57:05'),
(24, 7, 'Programming', 'JavaScript', 'beginner', 0.5, 4, 0, NULL, '2025-09-19 15:57:05', '2025-09-19 15:57:05');

-- --------------------------------------------------------

--
-- Table structure for table `user_career_goals`
--

CREATE TABLE `user_career_goals` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `target_role` varchar(150) NOT NULL,
  `target_industry` varchar(100) NOT NULL,
  `target_salary_range` varchar(50) DEFAULT NULL,
  `timeline_months` int(11) DEFAULT 12,
  `priority_level` enum('high','medium','low') DEFAULT 'medium',
  `current_progress` int(11) DEFAULT 0 CHECK (`current_progress` >= 0 and `current_progress` <= 100),
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_career_goals`
--

INSERT INTO `user_career_goals` (`id`, `user_id`, `target_role`, `target_industry`, `target_salary_range`, `timeline_months`, `priority_level`, `current_progress`, `is_active`, `created_at`, `updated_at`) VALUES
(3, 21, 'Web dev', 'Technology', NULL, 6, 'high', 0, 1, '2025-09-15 13:39:17', '2025-09-15 13:39:17'),
(9, 7, 'Senior Python Developer', 'Technology', NULL, 18, 'high', 0, 1, '2025-09-19 15:57:05', '2025-09-19 15:57:05');

-- --------------------------------------------------------

--
-- Table structure for table `user_learning_analytics`
--

CREATE TABLE `user_learning_analytics` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `learning_style` varchar(20) DEFAULT 'mixed',
  `preferred_difficulty` varchar(20) DEFAULT 'mixed',
  `average_session_duration_minutes` int(11) DEFAULT 45,
  `completion_rate` decimal(3,2) DEFAULT 0.00,
  `areas_of_interest` text DEFAULT NULL,
  `weakness_areas` text DEFAULT NULL,
  `strength_areas` text DEFAULT NULL,
  `learning_pace` varchar(20) DEFAULT 'average',
  `last_activity_date` date DEFAULT NULL,
  `total_courses_completed` int(11) DEFAULT 0,
  `total_quizzes_taken` int(11) DEFAULT 0,
  `average_quiz_score` decimal(3,2) DEFAULT 0.00,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_learning_analytics`
--

INSERT INTO `user_learning_analytics` (`id`, `user_id`, `learning_style`, `preferred_difficulty`, `average_session_duration_minutes`, `completion_rate`, `areas_of_interest`, `weakness_areas`, `strength_areas`, `learning_pace`, `last_activity_date`, `total_courses_completed`, `total_quizzes_taken`, `average_quiz_score`, `created_at`, `updated_at`) VALUES
(1, 7, 'visual', 'challenging', 45, 0.75, NULL, NULL, NULL, 'average', NULL, 2, 0, 0.00, '2025-09-15 12:10:37', '2025-09-15 12:10:37'),
(2, 21, 'mixed', 'mixed', 45, 0.00, NULL, NULL, NULL, 'average', '2025-09-15', 0, 0, 0.00, '2025-09-15 12:47:11', '2025-09-15 12:47:11'),
(3, 21, 'mixed', 'mixed', 45, 0.00, NULL, NULL, NULL, 'average', '2025-09-15', 0, 0, 0.00, '2025-09-15 13:39:17', '2025-09-15 13:39:17'),
(4, 7, 'visual', 'challenging', 45, 0.00, NULL, NULL, NULL, 'average', '2025-09-19', 0, 0, 0.00, '2025-09-19 15:40:48', '2025-09-19 15:40:48'),
(5, 7, 'visual', 'challenging', 45, 0.00, NULL, NULL, NULL, 'average', '2025-09-19', 0, 0, 0.00, '2025-09-19 15:41:33', '2025-09-19 15:41:33'),
(6, 7, 'visual', 'challenging', 45, 0.00, NULL, NULL, NULL, 'average', '2025-09-19', 0, 0, 0.00, '2025-09-19 15:48:38', '2025-09-19 15:48:38'),
(7, 7, 'visual', 'challenging', 45, 0.00, NULL, NULL, NULL, 'average', '2025-09-19', 0, 0, 0.00, '2025-09-19 15:49:22', '2025-09-19 15:49:22'),
(8, 7, 'visual', 'challenging', 45, 0.00, NULL, NULL, NULL, 'average', '2025-09-19', 0, 0, 0.00, '2025-09-19 15:56:54', '2025-09-19 15:56:54'),
(9, 7, 'visual', 'challenging', 45, 0.00, NULL, NULL, NULL, 'average', '2025-09-19', 0, 0, 0.00, '2025-09-19 15:57:05', '2025-09-19 15:57:05');

-- --------------------------------------------------------

--
-- Table structure for table `user_notifications`
--

CREATE TABLE `user_notifications` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `notification_type` varchar(50) NOT NULL,
  `title` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `action_url` varchar(500) DEFAULT NULL,
  `action_text` varchar(100) DEFAULT NULL,
  `priority` enum('low','medium','high','urgent') DEFAULT 'medium',
  `is_read` tinyint(1) DEFAULT 0,
  `is_dismissed` tinyint(1) DEFAULT 0,
  `metadata` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `read_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_notifications`
--

INSERT INTO `user_notifications` (`id`, `user_id`, `notification_type`, `title`, `message`, `action_url`, `action_text`, `priority`, `is_read`, `is_dismissed`, `metadata`, `created_at`, `read_at`, `expires_at`) VALUES
(1, 21, 'skill_assessment', 'Skills Assessment Needed', 'Complete your skills assessment to unlock personalized course recommendations and career guidance tailored specifically for you.', 'skill-assessment.php', 'Take Assessment', 'medium', 0, 0, '{\"generated_at\":\"2025-09-15 14:07:21\",\"source\":\"NotificationSystem\"}', '2025-09-15 12:07:21', NULL, NULL),
(2, 7, 'course_recommendation', 'Perfect Course Matches Found!', 'We found 4 highly recommended courses that match your skills and career goals perfectly (up to 90% match).', 'recommendations.php#courses', 'View Recommendations', 'high', 0, 0, '{\"generated_at\":\"2025-09-19 17:57:10\",\"source\":\"NotificationSystem\"}', '2025-09-19 15:57:10', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `career_path_recommendations`
--
ALTER TABLE `career_path_recommendations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_contact_messages_user_email` (`user_id`,`email`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `course_recommendations`
--
ALTER TABLE `course_recommendations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_id` (`course_id`),
  ADD KEY `idx_user_status` (`user_id`,`status`),
  ADD KEY `idx_relevance` (`relevance_score`),
  ADD KEY `idx_expires` (`expires_at`);

--
-- Indexes for table `enrollments`
--
ALTER TABLE `enrollments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `enrollment_id` (`enrollment_id`),
  ADD KEY `idx_enrollments_user_email` (`user_id`,`email`);

--
-- Indexes for table `quiz_recommendations`
--
ALTER TABLE `quiz_recommendations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_user_priority` (`user_id`,`priority_score`),
  ADD KEY `idx_difficulty` (`difficulty_level`),
  ADD KEY `idx_expires` (`expires_at`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `user_capabilities`
--
ALTER TABLE `user_capabilities`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_user_skill` (`user_id`,`skill_category`,`skill_name`);

--
-- Indexes for table `user_career_goals`
--
ALTER TABLE `user_career_goals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `user_learning_analytics`
--
ALTER TABLE `user_learning_analytics`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_notifications`
--
ALTER TABLE `user_notifications`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `career_path_recommendations`
--
ALTER TABLE `career_path_recommendations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `course_recommendations`
--
ALTER TABLE `course_recommendations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=208;

--
-- AUTO_INCREMENT for table `enrollments`
--
ALTER TABLE `enrollments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `quiz_recommendations`
--
ALTER TABLE `quiz_recommendations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `user_capabilities`
--
ALTER TABLE `user_capabilities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `user_career_goals`
--
ALTER TABLE `user_career_goals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `user_learning_analytics`
--
ALTER TABLE `user_learning_analytics`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `user_notifications`
--
ALTER TABLE `user_notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD CONSTRAINT `contact_messages_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `course_recommendations`
--
ALTER TABLE `course_recommendations`
  ADD CONSTRAINT `course_recommendations_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `course_recommendations_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `enrollments`
--
ALTER TABLE `enrollments`
  ADD CONSTRAINT `enrollments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `quiz_recommendations`
--
ALTER TABLE `quiz_recommendations`
  ADD CONSTRAINT `quiz_recommendations_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_capabilities`
--
ALTER TABLE `user_capabilities`
  ADD CONSTRAINT `user_capabilities_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_career_goals`
--
ALTER TABLE `user_career_goals`
  ADD CONSTRAINT `user_career_goals_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
