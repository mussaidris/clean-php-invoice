-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 22, 2023 at 06:49 AM
-- Server version: 5.7.23-23
-- PHP Version: 8.1.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `invoicing_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `accountchart`
--

CREATE TABLE `accountchart` (
  `id` int(11) NOT NULL,
  `code` int(11) NOT NULL,
  `parent_account` varchar(100) NOT NULL,
  `account_name` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `detail_type` varchar(255) NOT NULL,
  `decription` text NOT NULL,
  `balance` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `attributes`
--

CREATE TABLE `attributes` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `active` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `attribute_value`
--

CREATE TABLE `attribute_value` (
  `id` int(11) NOT NULL,
  `value` varchar(255) NOT NULL,
  `attribute_parent_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `active` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `active` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `company`
--

CREATE TABLE `company` (
  `id` int(11) NOT NULL,
  `company_name` varchar(100) NOT NULL,
  `arabic_name` varchar(100) DEFAULT NULL,
  `cr_no` varchar(20) DEFAULT NULL,
  `vat_number` varchar(15) DEFAULT NULL,
  `address` varchar(255) NOT NULL,
  `arabic_address` text,
  `phone` varchar(20) NOT NULL,
  `mobile` varchar(20) DEFAULT NULL,
  `fax` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `website` varchar(100) DEFAULT NULL,
  `pobox` varchar(50) DEFAULT NULL,
  `zipcode` varchar(50) DEFAULT NULL,
  `message` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `cust_name` varchar(100) NOT NULL,
  `cust_address` text NOT NULL,
  `cust_tel` varchar(20) DEFAULT NULL,
  `cust_email` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `delivery_item`
--

CREATE TABLE `delivery_item` (
  `id` int(11) NOT NULL,
  `delivery_id` int(11) NOT NULL,
  `item_name` varchar(250) NOT NULL,
  `order_item_quantity` decimal(10,2) NOT NULL,
  `remarks` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `delivery_note`
--

CREATE TABLE `delivery_note` (
  `id` int(11) NOT NULL,
  `reference` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `delivery_reference` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `delivery_date` date DEFAULT NULL,
  `cust_name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cust_address` text COLLATE utf8_unicode_ci,
  `cust_email` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cust_tel` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `prepared_by` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `updated_by` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `updated_on` datetime DEFAULT NULL,
  `supervisor_name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `signed_date` date DEFAULT NULL,
  `receiver_name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `receiver_contact` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` int(11) NOT NULL,
  `remarks` text COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` int(11) NOT NULL,
  `dept_name` varchar(100) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `diypackages`
--

CREATE TABLE `diypackages` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `productsincluded` text NOT NULL,
  `servicesincluded` text NOT NULL,
  `description` text,
  `code` varchar(50) NOT NULL,
  `createdDate` date NOT NULL,
  `updatedDate` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `diyschedule`
--

CREATE TABLE `diyschedule` (
  `id` int(11) NOT NULL,
  `workshop_id` int(11) NOT NULL,
  `workshop_start_day` int(11) NOT NULL,
  `workshop_end_day` int(11) NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `diyworkshops`
--

CREATE TABLE `diyworkshops` (
  `id` int(11) NOT NULL,
  `code` varchar(50) NOT NULL,
  `name` varchar(255) NOT NULL,
  `workshop_type` int(11) NOT NULL,
  `period` varchar(50) NOT NULL,
  `products_used` text NOT NULL,
  `createdDate` date NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `employeelogs`
--

CREATE TABLE `employeelogs` (
  `id` int(11) NOT NULL,
  `activity` varchar(255) NOT NULL,
  `empl_id` int(11) NOT NULL,
  `f_name` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `act_date_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` int(11) NOT NULL,
  `fname` varchar(100) NOT NULL,
  `lname` varchar(100) NOT NULL,
  `id_no` varchar(50) DEFAULT NULL,
  `company` int(11) NOT NULL,
  `section` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(32) NOT NULL,
  `jobtitle` varchar(255) NOT NULL,
  `role_id` int(11) NOT NULL,
  `permission` text,
  `contact_no` varchar(20) DEFAULT NULL,
  `address` text,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE `expenses` (
  `id` int(11) NOT NULL,
  `expensedate` date NOT NULL,
  `reference` varchar(100) DEFAULT NULL,
  `category` int(11) NOT NULL,
  `description` text NOT NULL,
  `paymentmethod` int(11) NOT NULL,
  `paidby` varchar(255) DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL,
  `memo` text,
  `attachement` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `expenses_details`
--

CREATE TABLE `expenses_details` (
  `id` int(11) NOT NULL,
  `exp_id` int(11) NOT NULL,
  `category` int(11) NOT NULL,
  `description` text NOT NULL,
  `amount` decimal(12,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `expense_category`
--

CREATE TABLE `expense_category` (
  `id` int(11) NOT NULL,
  `code` int(11) NOT NULL,
  `category` varchar(255) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `feedbacks`
--

CREATE TABLE `feedbacks` (
  `id` int(11) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `remarks` text NOT NULL,
  `submitDate` datetime NOT NULL,
  `employee` int(11) NOT NULL,
  `reply` text NOT NULL,
  `replyDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `job_order`
--

CREATE TABLE `job_order` (
  `id` int(11) NOT NULL,
  `project_id` varchar(50) NOT NULL,
  `order_no` varchar(50) NOT NULL,
  `order_type` text NOT NULL,
  `branch` varchar(50) NOT NULL,
  `assigned_to` text NOT NULL,
  `prepared_by` varchar(100) DEFAULT NULL,
  `empemail` varchar(50) DEFAULT NULL,
  `updated_by` varchar(100) DEFAULT NULL,
  `update_email` varchar(50) DEFAULT NULL,
  `updated_on` datetime DEFAULT NULL,
  `description` text NOT NULL,
  `attachment` text,
  `priority` int(11) NOT NULL,
  `job_amount` decimal(10,2) NOT NULL,
  `job_cost` decimal(10,2) NOT NULL,
  `commission` varchar(20) DEFAULT NULL,
  `order_date` date NOT NULL,
  `status` int(11) NOT NULL,
  `remarks` text,
  `completed_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `sku` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `cost` decimal(10,2) NOT NULL,
  `qty` varchar(255) NOT NULL,
  `image` text NOT NULL,
  `description` text,
  `attribute_value_id` text,
  `category_id` int(11) NOT NULL,
  `store_id` int(11) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `id` int(11) NOT NULL,
  `proj_reference` varchar(50) DEFAULT NULL,
  `project_name` varchar(255) NOT NULL,
  `priority` int(11) NOT NULL,
  `completion_period` varchar(50) NOT NULL,
  `assigned_to` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `remark` text,
  `started_on` date NOT NULL,
  `completed_on` date NOT NULL,
  `created_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_request`
--

CREATE TABLE `purchase_request` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `description` text NOT NULL,
  `qty` int(11) NOT NULL,
  `request_date` date NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `receipt_voucher`
--

CREATE TABLE `receipt_voucher` (
  `id` int(11) NOT NULL,
  `received_from` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `amount_in_word` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `payment_method` int(11) NOT NULL,
  `payment_details` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `purpose` text COLLATE utf8_unicode_ci NOT NULL,
  `receipt_date` date NOT NULL,
  `date_time` datetime NOT NULL,
  `prepared_by` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `updated_by` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `updated_on` date DEFAULT NULL,
  `remarks` text COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stores`
--

CREATE TABLE `stores` (
  `id` int(11) NOT NULL,
  `code` varchar(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `active` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `id` int(11) NOT NULL,
  `sup_name` varchar(255) NOT NULL,
  `sup_address` text NOT NULL,
  `sup_tel` int(11) DEFAULT NULL,
  `sup_mob` int(11) DEFAULT NULL,
  `sup_email` varchar(100) NOT NULL,
  `sup_website` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `id` int(11) NOT NULL,
  `task_reference` varchar(50) DEFAULT NULL,
  `created_date` date DEFAULT NULL,
  `prepared_by` varchar(100) DEFAULT NULL,
  `empemail` varchar(50) DEFAULT NULL,
  `task_title` varchar(255) NOT NULL,
  `priority` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `percentage_complete` decimal(10,2) NOT NULL,
  `assigned_to` int(11) NOT NULL,
  `description` text NOT NULL,
  `start_date` date NOT NULL,
  `due_date` date NOT NULL,
  `updated_on` datetime DEFAULT NULL,
  `updated_by` varchar(100) DEFAULT NULL,
  `update_email` varchar(50) DEFAULT NULL,
  `completed_date` date NOT NULL,
  `requirement` text,
  `team_members` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_order`
--

CREATE TABLE `tbl_order` (
  `order_id` int(11) NOT NULL,
  `inv_reference` varchar(50) NOT NULL,
  `order_date` date NOT NULL,
  `updated_on` datetime DEFAULT NULL,
  `prepared_by` varchar(100) DEFAULT NULL,
  `empemail` varchar(100) DEFAULT NULL,
  `updated_by` varchar(100) DEFAULT NULL,
  `update_email` varchar(100) DEFAULT NULL,
  `order_receiver_name` varchar(250) NOT NULL,
  `receiver_email` varchar(50) DEFAULT NULL,
  `receiver_tel` varchar(20) DEFAULT NULL,
  `order_receiver_address` text NOT NULL,
  `order_total_before_tax` decimal(10,2) NOT NULL,
  `discount` decimal(10,2) NOT NULL,
  `order_total_tax` decimal(10,2) NOT NULL,
  `order_total_after_tax` decimal(10,2) NOT NULL,
  `paid_amt` decimal(10,2) NOT NULL,
  `due_amt` decimal(10,2) NOT NULL,
  `payment_method` int(11) NOT NULL,
  `order_status` int(11) NOT NULL,
  `total_inwords` text NOT NULL,
  `order_datetime` datetime NOT NULL,
  `remarks` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_order_item`
--

CREATE TABLE `tbl_order_item` (
  `order_item_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `inv_reference` varchar(50) NOT NULL,
  `item_name` varchar(250) NOT NULL,
  `order_item_quantity` decimal(10,2) NOT NULL,
  `order_item_price` decimal(10,2) NOT NULL,
  `order_item_final_amount` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_quotation`
--

CREATE TABLE `tbl_quotation` (
  `order_id` int(11) NOT NULL,
  `quo_reference` varchar(50) NOT NULL,
  `order_date` date NOT NULL,
  `updated_on` datetime DEFAULT NULL,
  `prepared_by` varchar(100) DEFAULT NULL,
  `empemail` varchar(100) DEFAULT NULL,
  `updated_by` varchar(100) DEFAULT NULL,
  `update_email` varchar(100) DEFAULT NULL,
  `order_receiver_name` varchar(250) NOT NULL,
  `receiver_email` varchar(50) DEFAULT NULL,
  `receiver_tel` varchar(20) DEFAULT NULL,
  `order_receiver_address` text NOT NULL,
  `order_total_before_tax` decimal(10,2) NOT NULL,
  `order_status` int(11) NOT NULL,
  `total_inwords` text,
  `delivery_terms` varchar(255) DEFAULT NULL,
  `quote_validity` varchar(255) DEFAULT NULL,
  `payment_terms` varchar(255) DEFAULT NULL,
  `additional_terms` text,
  `order_datetime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_quotation_item`
--

CREATE TABLE `tbl_quotation_item` (
  `order_item_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `quo_reference` varchar(50) NOT NULL,
  `item_name` varchar(250) NOT NULL,
  `order_item_quantity` decimal(10,2) NOT NULL,
  `order_item_price` decimal(10,2) NOT NULL,
  `order_item_final_amount` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `vat_tbl`
--

CREATE TABLE `vat_tbl` (
  `id` int(11) NOT NULL,
  `total_sale` decimal(10,2) NOT NULL,
  `total_purchase` decimal(10,2) NOT NULL,
  `vat_quarter` int(11) NOT NULL,
  `vat_year` int(11) NOT NULL,
  `paid_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accountchart`
--
ALTER TABLE `accountchart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `attributes`
--
ALTER TABLE `attributes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `attribute_value`
--
ALTER TABLE `attribute_value`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `company`
--
ALTER TABLE `company`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `delivery_item`
--
ALTER TABLE `delivery_item`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `delivery_note`
--
ALTER TABLE `delivery_note`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `diypackages`
--
ALTER TABLE `diypackages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `diyschedule`
--
ALTER TABLE `diyschedule`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `diyworkshops`
--
ALTER TABLE `diyworkshops`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employeelogs`
--
ALTER TABLE `employeelogs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `empl_id` (`empl_id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `expenses_details`
--
ALTER TABLE `expenses_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `expense_category`
--
ALTER TABLE `expense_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `feedbacks`
--
ALTER TABLE `feedbacks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `job_order`
--
ALTER TABLE `job_order`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchase_request`
--
ALTER TABLE `purchase_request`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `receipt_voucher`
--
ALTER TABLE `receipt_voucher`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stores`
--
ALTER TABLE `stores`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_order`
--
ALTER TABLE `tbl_order`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `tbl_order_item`
--
ALTER TABLE `tbl_order_item`
  ADD PRIMARY KEY (`order_item_id`);

--
-- Indexes for table `tbl_quotation`
--
ALTER TABLE `tbl_quotation`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `tbl_quotation_item`
--
ALTER TABLE `tbl_quotation_item`
  ADD PRIMARY KEY (`order_item_id`);

--
-- Indexes for table `vat_tbl`
--
ALTER TABLE `vat_tbl`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accountchart`
--
ALTER TABLE `accountchart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `attributes`
--
ALTER TABLE `attributes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `attribute_value`
--
ALTER TABLE `attribute_value`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `company`
--
ALTER TABLE `company`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `delivery_item`
--
ALTER TABLE `delivery_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `delivery_note`
--
ALTER TABLE `delivery_note`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `diypackages`
--
ALTER TABLE `diypackages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `diyschedule`
--
ALTER TABLE `diyschedule`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `diyworkshops`
--
ALTER TABLE `diyworkshops`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employeelogs`
--
ALTER TABLE `employeelogs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `expenses_details`
--
ALTER TABLE `expenses_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `expense_category`
--
ALTER TABLE `expense_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `feedbacks`
--
ALTER TABLE `feedbacks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `job_order`
--
ALTER TABLE `job_order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchase_request`
--
ALTER TABLE `purchase_request`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `receipt_voucher`
--
ALTER TABLE `receipt_voucher`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `stores`
--
ALTER TABLE `stores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_order`
--
ALTER TABLE `tbl_order`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_order_item`
--
ALTER TABLE `tbl_order_item`
  MODIFY `order_item_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_quotation`
--
ALTER TABLE `tbl_quotation`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_quotation_item`
--
ALTER TABLE `tbl_quotation_item`
  MODIFY `order_item_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vat_tbl`
--
ALTER TABLE `vat_tbl`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
