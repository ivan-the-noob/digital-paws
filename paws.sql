-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 26, 2024 at 03:59 PM
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
-- Database: `paws`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointment`
--

CREATE TABLE `appointment` (
  `id` int(11) NOT NULL,
  `owner_name` varchar(255) NOT NULL,
  `contact_num` varchar(20) NOT NULL,
  `email` varchar(255) NOT NULL,
  `barangay` varchar(255) DEFAULT NULL,
  `pet_type` varchar(50) NOT NULL,
  `breed` varchar(100) DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `service_category` varchar(50) NOT NULL,
  `service` varchar(255) NOT NULL,
  `payment` decimal(10,2) NOT NULL,
  `appointment_time` time NOT NULL,
  `appointment_date` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `latitude` decimal(10,8) DEFAULT NULL,
  `longitude` decimal(11,8) DEFAULT NULL,
  `add_info` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointment`
--

INSERT INTO `appointment` (`id`, `owner_name`, `contact_num`, `email`, `barangay`, `pet_type`, `breed`, `age`, `service_category`, `service`, `payment`, `appointment_time`, `appointment_date`, `created_at`, `latitude`, `longitude`, `add_info`) VALUES
(48, 'Ivan', '32131', 'ejivancablanida@gmail.com', 'San Agustin', 'Dog', 'dasdas', 12, '', 'Pharmacy', 300.00, '11:21:00', '2024-10-19', '2024-10-19 01:19:42', 14.27849630, 120.86687720, 'Saluysoy Rd.');

-- --------------------------------------------------------

--
-- Table structure for table `approved_req`
--

CREATE TABLE `approved_req` (
  `id` int(11) NOT NULL,
  `owner_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `service` varchar(100) NOT NULL,
  `contact_num` varchar(15) NOT NULL,
  `barangay` varchar(100) NOT NULL,
  `pet_type` varchar(50) NOT NULL,
  `breed` varchar(50) NOT NULL,
  `age` int(11) NOT NULL,
  `payment` decimal(10,2) NOT NULL,
  `appointment_time` time NOT NULL,
  `appointment_date` date NOT NULL,
  `latitude` decimal(10,8) NOT NULL,
  `longitude` decimal(11,8) NOT NULL,
  `add_info` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `approved_req`
--

INSERT INTO `approved_req` (`id`, `owner_name`, `email`, `service`, `contact_num`, `barangay`, `pet_type`, `breed`, `age`, `payment`, `appointment_time`, `appointment_date`, `latitude`, `longitude`, `add_info`, `created_at`) VALUES
(1, '', '', '', '', '', '', '', 0, 0.00, '00:00:00', '0000-00-00', 14.29766962, 120.86687720, '', '2024-10-16 06:41:23'),
(2, '', '', '', '', '', '', '', 0, 0.00, '00:00:00', '0000-00-00', 0.00000000, 0.00000000, '', '2024-10-16 15:52:29'),
(3, '', '', '', '', '', '', '', 0, 0.00, '00:00:00', '0000-00-00', 0.00000000, 0.00000000, '', '2024-10-16 15:52:44'),
(4, '', '', '', '', '', '', '', 0, 0.00, '00:00:00', '0000-00-00', 14.29766962, 0.00000000, '', '2024-10-16 15:53:43'),
(5, 'Ivan Ablanida', 'ejivancablanida@gmail.com', 'Surgical Services', '091234567889', 'Osorio', 'Cat', '12', 12, 2500.00, '09:41:00', '2024-10-16', 14.29766962, 0.00000000, 'das', '2024-10-16 15:55:59'),
(6, 'Ivan Ablanida', 'ejivancablanida@gmail.com', 'Pharmacy', '091234567889', '', 'Cat', '12', 12, 300.00, '10:57:00', '2024-10-16', 14.28383250, 120.86687720, 'das', '2024-10-16 15:57:23'),
(7, 'Ivan Ablanida', 'ejivancablanida@gmail.com', 'Surgical Services', '091234567889', 'Osorio', 'Cat', '12', 12, 2500.00, '09:41:00', '2024-10-16', 14.29766962, 0.00000000, 'das', '2024-10-16 15:58:08'),
(8, 'Ivan Ablanida', 'ejivancablanida@gmail.com', 'Surgical Services', '091234567889', 'Osorio', 'Cat', '12', 12, 2500.00, '09:41:00', '2024-10-16', 14.29766962, 0.00000000, 'das', '2024-10-16 16:00:55'),
(9, 'Ivan Ablanida', 'ejivancablanida@gmail.com', 'Pharmacy', '091234567889', '', 'Cat', '12', 12, 300.00, '10:57:00', '2024-10-16', 14.28383250, 120.86687720, 'das', '2024-10-16 16:04:08'),
(10, 'Ivan Ablanida', 'ejivancablanida@gmail.com', 'Surgical Services', '091234567889', 'Osorio', 'Cat', '12', 12, 2500.00, '09:41:00', '2024-10-16', 14.29766962, 0.00000000, 'das', '2024-10-16 17:38:19'),
(11, 'Ivan Ablanida', 'ejivancablanida@gmail.com', 'Surgical Services', '091234567889', 'Osorio', 'Cat', '12', 12, 2500.00, '09:41:00', '2024-10-16', 14.29766962, 0.00000000, 'das', '2024-10-16 17:49:31'),
(12, 'Ivan Ablanida', 'ejivancablanida@gmail.com', 'Internal Medicine Consults', '091234567889', 'Cabuco', 'Cat', '12', 12, 1500.00, '10:49:00', '2024-10-16', 14.27935990, 0.00000000, 'das', '2024-10-16 17:50:49'),
(13, 'Ivan Ablanida', 'ejivancablanida@gmail.com', 'Internal Medicine Consults', '091234567889', 'Cabuco', 'Cat', '12', 12, 1500.00, '10:49:00', '2024-10-16', 14.27935990, 0.00000000, 'das', '2024-10-16 17:50:58'),
(14, 'Ivan Ablanida', 'ejivancablanida@gmail.com', 'Internal Medicine Consults', '091234567889', 'Cabuco', 'Cat', '12', 12, 1500.00, '10:49:00', '2024-10-16', 14.27935990, 0.00000000, 'das', '2024-10-16 17:51:04'),
(40, 'Ivan Ablanida', 'ejivancablanida@gmail.com', 'Surgical Services', '091234567889', 'Osorio', 'Cat', '12', 12, 2500.00, '09:41:00', '2024-10-16', 14.29766962, 0.00000000, 'das', '2024-10-16 17:52:26'),
(46, 'Ivan Ablanida', 'ejivancablanida@gmail.com', 'Internal Medicine Consults', '091234567889', 'Cabuco', 'Cat', '12', 12, 1500.00, '10:49:00', '2024-10-16', 14.27935990, 0.00000000, 'das', '2024-10-16 17:52:29'),
(47, 'Ivan Ablanida', 'ejivancablanida@gmail.com', 'Grooming', '091234567889', 'Cabuco', 'Cat', '12', 12, 999.00, '16:14:00', '2024-10-16', 14.27931831, 120.84477679, 'das', '2024-10-16 21:13:06');

-- --------------------------------------------------------

--
-- Table structure for table `check_up`
--

CREATE TABLE `check_up` (
  `id` int(11) NOT NULL,
  `owner_name` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `address` varchar(255) NOT NULL,
  `active_number` varchar(20) NOT NULL,
  `pet_name` varchar(255) NOT NULL,
  `species` enum('Canine','Feline') NOT NULL,
  `color` varchar(50) NOT NULL,
  `pet_birthdate` date NOT NULL,
  `gender` enum('male','female') NOT NULL,
  `breed` varchar(255) NOT NULL,
  `diet` varchar(255) NOT NULL,
  `bcs` enum('1','2','3','4','5') NOT NULL,
  `stool` enum('firm','watery_wet') NOT NULL,
  `chief_complaint` text DEFAULT NULL,
  `treatment` text DEFAULT NULL,
  `vomiting` enum('yes','no') NOT NULL,
  `ticks_fleas` enum('present','none') NOT NULL,
  `lepto` enum('+','-') NOT NULL,
  `chw` enum('+','-') NOT NULL,
  `cpv` enum('+','-') NOT NULL,
  `cdv` enum('+','-') NOT NULL,
  `cbc` enum('+','-') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `check_up`
--

INSERT INTO `check_up` (`id`, `owner_name`, `date`, `address`, `active_number`, `pet_name`, `species`, `color`, `pet_birthdate`, `gender`, `breed`, `diet`, `bcs`, `stool`, `chief_complaint`, `treatment`, `vomiting`, `ticks_fleas`, `lepto`, `chw`, `cpv`, `cdv`, `cbc`) VALUES
(18, 'Ivan', '2024-10-10', 'Trece Martires City Cavite', '123', 'Neoma', 'Canine', 'Black', '2024-10-25', 'male', 'Husky', 'dsadsa', '3', 'firm', 'das', 'dasda', 'yes', 'present', '+', '+', '-', '+', '-'),
(19, 'Test', '2024-10-03', 'Trece Martires', '123', 'Neoma', 'Canine', 'BVlack', '2024-10-03', 'female', 'Husky', 'a', '4', 'firm', 'dasd', 'dsadas', 'no', 'present', '+', '+', '-', '-', '-'),
(20, 'Test', '2024-10-26', 'dasdas', '123', 'Neoma', 'Canine', 'BVlack', '2024-10-31', 'female', 'dasdasda', 'dasdasdadasdasdasdas', '4', 'firm', 'ba', 'ba', 'no', 'present', '+', '+', '+', '+', '-'),
(21, 'Test', '2024-10-03', 'dasdsa', '123', 'Neoma', 'Canine', 'BVlack', '2024-10-02', 'female', 'dsadsa', 'dsadas', '5', 'firm', 'dasd', 'asdasdasdsa', 'no', 'present', '+', '+', '+', '+', '+'),
(22, 'Ivan Ablanida', '2024-10-08', 'Trece Martires City Cavite', '123', 'Neoma', 'Feline', 'Black', '2024-10-23', 'male', 'dsadsa', 'dasdsadas', '3', 'firm', 'das', 'dasdasda', 'yes', 'present', '+', '-', '+', '-', '-'),
(23, 'Test', '2024-10-03', 'dasdsa', '123', 'Neoma', 'Canine', 'BVlack', '2024-10-02', 'female', 'dsadsa', 'dsadas', '5', 'firm', 'dasd', 'asdasdasdsa', 'no', 'present', '+', '+', '+', '+', '+'),
(24, 'Ivan', '2024-10-10', 'Trece Martires City Cavite', '123', 'Neoma', 'Canine', 'Black', '2024-10-25', 'male', 'Husky', 'dsadsa', '3', 'firm', 'das', 'dasda', 'yes', 'present', '+', '+', '-', '+', '-'),
(25, 'Test', '2024-10-03', 'dasdsa', '123', 'Neoma', 'Canine', 'BVlack', '2024-10-02', 'female', 'dsadsa', 'dsadas', '5', 'firm', 'dasd', 'asdasdasdsa', 'no', 'present', '+', '+', '+', '+', '+'),
(26, 'Test', '2024-10-03', 'dasdsa', '123', 'Neoma', 'Canine', 'BVlack', '2024-10-02', 'female', 'dsadsa', 'dsadas', '5', 'firm', 'dasd', 'asdasdasdsa', 'no', 'present', '+', '+', '+', '+', '+'),
(27, 'dsadsa', '2024-10-09', 'dasdas', '2321', 'dasdas', 'Canine', 'd321321', '2024-10-04', 'female', 'adsdas', 'dasdsa', '3', 'watery_wet', 'dasdsa', 'dasdsa', 'no', 'present', '+', '+', '-', '+', '-');

-- --------------------------------------------------------

--
-- Table structure for table `prescriptions`
--

CREATE TABLE `prescriptions` (
  `id` int(11) NOT NULL,
  `owner_name` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `pet_name` varchar(255) NOT NULL,
  `age` int(11) NOT NULL,
  `drug_name` varchar(255) NOT NULL,
  `prescription` varchar(255) NOT NULL,
  `frequency` varchar(255) NOT NULL,
  `special_instructions` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `time` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `prescriptions`
--

INSERT INTO `prescriptions` (`id`, `owner_name`, `date`, `pet_name`, `age`, `drug_name`, `prescription`, `frequency`, `special_instructions`, `created_at`, `time`) VALUES
(56, 'dsadsa', '2024-10-08', 'dasdasdsa', 2112, 'Hello,do not drink this,,', 'GAMOT TO,do not drink this,,', '12,12,,', 'do not drink this,do not drink this,,', '2024-10-23 04:45:20', '00:00:21'),
(57, 'Ivan', '2024-10-09', 'dasdasdsa', 12, 'Hello', 'GAMOT TO', '21', '123', '2024-10-23 04:47:34', '00:00:23'),
(58, 'Ivan', '2024-10-10', 'dasdasdsa', 12, 'do not drink this,Hello,,', 'do not drink this,dasdsa,,', '12,21321,,', '312312,dasdsa,,', '2024-10-23 04:52:13', '12'),
(59, 'Ivan', '2024-10-01', 'dasdsa', 1, 'dsadsa,Hello,,', 'GAMOT TO,GAMOT TO,,', '21,321,,', 'dsadsa,312,,', '2024-10-23 04:53:38', '12'),
(60, 'Ivan', '2024-10-09', 'dasdas', 1, 'Hello,Hello,,', 'GAMOT TO,GAMOT TO,,', '21,21,,', 'do not drink this,do not drink this,,', '2024-10-23 04:54:46', '12: 30,12: 30,,');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `product_img` varchar(255) NOT NULL,
  `product_name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `cost` decimal(10,2) NOT NULL,
  `type` enum('petfood','pettoys','supplements') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `product_img`, `product_name`, `description`, `cost`, `type`) VALUES
(2, 'Screenshot 2024-10-20 173327.png', 'test', 'test', 69.00, 'supplements'),
(4, 'Screenshot 2024-10-20 212839.png', 'dasdasdsadsadasdasdas', 'dsadasdasdas', 123.00, 'petfood'),
(5, 'Screenshot 2024-10-20 212839.png', 'dasdasdsadsadasdasdas', 'dsadasdasdas', 123.00, 'petfood'),
(6, 'Screenshot 2024-10-20 212839.png', 'dasdasdsadsadasdasdas', 'dsadasdasdas', 123.00, 'petfood'),
(7, 'Screenshot 2024-10-20 212839.png', 'dasdasdsadsadasdasdas', 'dsadasdasdas', 123.00, 'petfood'),
(8, 'Screenshot 2024-10-20 173327.png', 'HEHE', 'HEHE', 12321.00, 'petfood'),
(9, 'Screenshot 2024-10-20 173327.png', 'DASDAS', 'DASDAS', 12.00, 'pettoys'),
(10, 'Screenshot 2024-10-19 125332.png', '312321', 'DASDAS', 312312.00, 'petfood'),
(11, 'Screenshot 2024-10-19 125332.png', '312321', 'DASDAS', 312312.00, 'pettoys'),
(12, 'Screenshot 2024-10-18 221241.png', 'dasdas', 'dasdas', 12.00, 'supplements'),
(13, 'Screenshot 2024-10-20 203749.png', '12321', 'DASDASDAS', 12.00, 'supplements');

-- --------------------------------------------------------

--
-- Table structure for table `service_list`
--

CREATE TABLE `service_list` (
  `id` int(11) NOT NULL,
  `service_type` enum('medical','non-medical') NOT NULL,
  `service_name` varchar(255) NOT NULL,
  `cost` decimal(10,2) NOT NULL,
  `discount` decimal(5,2) DEFAULT 0.00,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `info` varchar(255) DEFAULT NULL,
  `is_read` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `service_list`
--

INSERT INTO `service_list` (`id`, `service_type`, `service_name`, `cost`, `discount`, `created_at`, `info`, `is_read`) VALUES
(6, 'medical', 'Surgical Servicesss', 2500.00, 1.00, '2024-09-11 10:11:31', 'Professional surgical services for your pets', 0),
(7, 'medical', 'Pharmacy', 300.00, 0.00, '2024-09-11 10:12:04', 'Wide range of medications available at our pharmacy.', 0),
(8, 'non-medical', 'Grooming', 999.00, 10.00, '2024-09-11 10:13:23', 'Professional grooming services to keep your pets looking their best', 0),
(9, 'non-medical', 'Boarding', 700.00, 0.00, '2024-09-11 10:13:43', 'Comfortable and safe boarding services for your pets', 0),
(10, 'non-medical', 'Pet Supplies', 300.00, 0.00, '2024-09-11 10:14:05', 'A wide range of pet supplies for your pet\'s needs', 0),
(17, 'medical', 'Preventive Health Caress', 123.00, 10.00, '2024-10-17 22:53:49', 'hehe', 1),
(19, 'medical', 'try lang', 123.00, 10.00, '2024-10-26 17:23:39', 'Basta try lang to pare koBasta try lang to pare koBasta try lang to pare koBasta try lang to pare ko', 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `role` enum('user','admin','staff') NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `created_at`, `role`) VALUES
(1, 'ej', 'ej@gmail.com', '$2y$10$0aciurOYLqF49zhYkRtOfesnIn56cODY9resdBwFYFmgkKIxEGEDG', '2024-08-21 07:19:09', 'user'),
(4, 'admin', 'admin@gmail.com', '$2y$10$B25A3lxkpj0t.XDzOg8Zz.fbqiofhTBTSPxZVWlH4oYRAc.CyOr12', '2024-08-21 23:18:15', 'admin'),
(5, 'Ej Ivan Ablanida', 'ejivancablanida@gmail.com', '$2y$10$aP1nlRV3aYsY5RBAIAyoJOCDLZqWDtsqBF37U8kja/xrs42LEFY9O', '2024-10-14 06:17:37', 'user'),
(7, 'Nami', 'nami@gmail.com', '$2y$10$y7MDJDeslWyhW2O7diiabOLLwGzBxxRj4EeNDSBYQ6AIbrB8TBIZu', '2024-10-26 12:22:15', 'admin'),
(8, 'Jann Ray Mostajo', 'jannray@gmail.com', '$2y$10$auksETljR91mCM8XaugXuOh7lwAkEBeteJipmdwKtWIpUT.OGYHCO', '2024-10-26 12:22:25', ''),
(9, 'Prince', 'prince@gmail.com', '$2y$10$CbXsyQItEsVCVg1Jt/gMXuQ6l512AVwQ1UUf8VYXCHGfBPRv.t5GK', '2024-10-26 12:25:14', 'staff'),
(10, 'jan', 'jan@gmail.com', '$2y$10$3ziKOAaDlRc4EB9qrqpzVuIR2MzAXTO.FqxN0YI1csRGruNXHxjFi', '2024-10-26 12:26:24', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `wellness`
--

CREATE TABLE `wellness` (
  `id` int(11) NOT NULL,
  `owner_name` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `address` varchar(255) NOT NULL,
  `active_number` varchar(50) NOT NULL,
  `pet_name` varchar(255) NOT NULL,
  `species` varchar(100) NOT NULL,
  `color` varchar(50) NOT NULL,
  `pet_birthdate` date NOT NULL,
  `gender` enum('Male','Female') NOT NULL,
  `breed` varchar(100) NOT NULL,
  `diet` text NOT NULL,
  `date_given_dwrm` varchar(255) DEFAULT NULL,
  `weight_dwrm` varchar(255) DEFAULT NULL,
  `treatment_dwrm` varchar(255) DEFAULT NULL,
  `observation_dwrm` varchar(255) DEFAULT NULL,
  `follow_up_dwrm` varchar(255) DEFAULT NULL,
  `date_given_vac` varchar(255) DEFAULT NULL,
  `weight_vac` varchar(255) DEFAULT NULL,
  `treatment_vac` varchar(255) DEFAULT NULL,
  `observation_vac` varchar(255) DEFAULT NULL,
  `follow_up_vac` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `wellness`
--

INSERT INTO `wellness` (`id`, `owner_name`, `date`, `address`, `active_number`, `pet_name`, `species`, `color`, `pet_birthdate`, `gender`, `breed`, `diet`, `date_given_dwrm`, `weight_dwrm`, `treatment_dwrm`, `observation_dwrm`, `follow_up_dwrm`, `date_given_vac`, `weight_vac`, `treatment_vac`, `observation_vac`, `follow_up_vac`) VALUES
(24, 'TEST TODAY', '2024-10-22', 'TEST TODAY', '312321', 'TEST TODAY', 'Feline', 'TEST TODAY', '2024-10-12', 'Female', 'dasdsa', 'dssadasds', 'dsadsad,DASDAS,,,', 'dasda,DSADS,,,', '12,,21,,', 'dsadsadas,DASDAS,SDSA,,', 'dsdsdsdasad,DAS,DASDAS,,', 'DASDASDAS,DASDSADAS,,,', 'DASDAS,DASDAS,,,', 'DASD,DASDAS,,,', 'DASDASDSA,DSADAS,,,', 'DASD,DSADSADAS,,,'),
(25, 'TEST TODAY', '2024-10-16', 'TEST TODAY', '312321', 'TEST TODAY', 'Canine', 'TEST TODAY', '2024-10-09', 'Female', 'dsadsa', 'dasasd', 'TANGINAMO,TANGINAMO,,,', 'TANGINAMO,TANGINAMO,,,', '21,1212,,,', 'TANGINAMO,TANGINAMO,,,', 'TANGINAMO,TANGINAMO,,,', 'TANGINAMO,TANGINAMO,,,', 'TANGINAMO,TANGINAMO,,,', 'TANGINAMO,TANGINAMO,,,', 'TANGINAMO,TANGINAMO,,,', 'TANGINAMO,VTANGINAMO,,,');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointment`
--
ALTER TABLE `appointment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `approved_req`
--
ALTER TABLE `approved_req`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `check_up`
--
ALTER TABLE `check_up`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prescriptions`
--
ALTER TABLE `prescriptions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `service_list`
--
ALTER TABLE `service_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `wellness`
--
ALTER TABLE `wellness`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointment`
--
ALTER TABLE `appointment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `approved_req`
--
ALTER TABLE `approved_req`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `check_up`
--
ALTER TABLE `check_up`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `prescriptions`
--
ALTER TABLE `prescriptions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `service_list`
--
ALTER TABLE `service_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `wellness`
--
ALTER TABLE `wellness`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
