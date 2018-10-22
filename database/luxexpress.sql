-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 22, 2018 at 05:21 AM
-- Server version: 10.1.36-MariaDB
-- PHP Version: 7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `luxexpress`
--

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2018_09_28_082315_create_role_table', 1),
(2, '2018_09_28_082332_create_user_table', 1),
(3, '2018_09_28_082421_create_store_table', 1),
(4, '2018_09_28_082437_create_shipper_table', 1),
(5, '2018_09_28_090352_create_service_type_table', 1),
(6, '2018_09_28_090450_create_order_table', 1),
(7, '2018_09_28_090525_create_order_detail_table', 1),
(8, '2018_09_28_092557_create_order_status_table', 1),
(9, '2018_09_28_092631_create_order_tracking_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

CREATE TABLE `order` (
  `idOrder` int(10) UNSIGNED NOT NULL,
  `idUser` int(10) UNSIGNED NOT NULL,
  `idStore` int(10) UNSIGNED NOT NULL,
  `nameReceiver` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `addressReceiver` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `latitudeReceiver` decimal(8,2) DEFAULT NULL,
  `longitudeReceiver` decimal(8,2) DEFAULT NULL,
  `phoneReceiver` varchar(11) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emailReceiver` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descriptionOrder` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dateCreated` datetime NOT NULL,
  `COD` tinyint(4) NOT NULL DEFAULT '0',
  `timeDelivery` datetime NOT NULL,
  `distanceShipping` int(11) NOT NULL,
  `idServiceType` int(10) UNSIGNED NOT NULL,
  `totalWeight` tinyint(4) NOT NULL,
  `totalPriceProduct` double(8,2) NOT NULL,
  `priceService` double(8,2) NOT NULL,
  `totalMoney` double(8,2) NOT NULL,
  `idShipper` int(10) UNSIGNED NOT NULL,
  `currentOrderStatus` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orderstatus`
--

CREATE TABLE `orderstatus` (
  `idStatus` int(10) UNSIGNED NOT NULL,
  `statusName` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ordertracking`
--

CREATE TABLE `ordertracking` (
  `idOrder` int(10) UNSIGNED NOT NULL,
  `idOrderStatus` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_detail`
--

CREATE TABLE `order_detail` (
  `idOrderDetail` int(10) UNSIGNED NOT NULL,
  `idOrder` int(10) UNSIGNED NOT NULL,
  `nameProduct` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `priceProduct` double(8,2) NOT NULL,
  `quantityProduct` int(11) NOT NULL,
  `imgProduct` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amountMoney` double(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roleId` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `servicetype`
--

CREATE TABLE `servicetype` (
  `idService` int(10) UNSIGNED NOT NULL,
  `nameService` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `shipper`
--

CREATE TABLE `shipper` (
  `idShipper` int(10) UNSIGNED NOT NULL,
  `idUser` int(10) UNSIGNED NOT NULL,
  `licensePlates` varchar(11) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `store`
--

CREATE TABLE `store` (
  `idStore` int(10) UNSIGNED NOT NULL,
  `idUser` int(10) UNSIGNED NOT NULL,
  `nameStore` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `typeStore` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `addressStore` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `descriptionStore` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `latitudeStore` decimal(8,2) DEFAULT NULL,
  `longitudeStore` decimal(8,2) DEFAULT NULL,
  `startWorkingTime` time DEFAULT NULL,
  `endWorkingTime` time DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `token`
--

CREATE TABLE `token` (
  `id` int(11) NOT NULL,
  `token` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `user_token_id` int(11) UNSIGNED NOT NULL,
  `expired_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `idUser` int(10) UNSIGNED NOT NULL,
  `username` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fullName` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `idNumber` varchar(9) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phoneNumber` varchar(11) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `avatar` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dateOfBirth` date DEFAULT NULL,
  `gender` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `addressUser` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `activationCode` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `isActivated` tinyint(4) NOT NULL DEFAULT '0',
  `tokenPasswordRecovery` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenExpirationTime` datetime NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pinCode` int(11) NOT NULL,
  `roleId` int(10) UNSIGNED NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`idOrder`),
  ADD UNIQUE KEY `order_phonereceiver_unique` (`phoneReceiver`),
  ADD KEY `order_iduser_foreign` (`idUser`),
  ADD KEY `order_idstore_foreign` (`idStore`),
  ADD KEY `order_idservicetype_foreign` (`idServiceType`),
  ADD KEY `order_idshipper_foreign` (`idShipper`);

--
-- Indexes for table `orderstatus`
--
ALTER TABLE `orderstatus`
  ADD PRIMARY KEY (`idStatus`);

--
-- Indexes for table `ordertracking`
--
ALTER TABLE `ordertracking`
  ADD KEY `ordertracking_idorder_foreign` (`idOrder`),
  ADD KEY `ordertracking_idorderstatus_foreign` (`idOrderStatus`);

--
-- Indexes for table `order_detail`
--
ALTER TABLE `order_detail`
  ADD PRIMARY KEY (`idOrderDetail`),
  ADD KEY `order_detail_idorder_foreign` (`idOrder`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `role_name_unique` (`name`),
  ADD UNIQUE KEY `role_roleid_unique` (`roleId`);

--
-- Indexes for table `servicetype`
--
ALTER TABLE `servicetype`
  ADD PRIMARY KEY (`idService`);

--
-- Indexes for table `shipper`
--
ALTER TABLE `shipper`
  ADD PRIMARY KEY (`idShipper`),
  ADD KEY `shipper_iduser_foreign` (`idUser`);

--
-- Indexes for table `store`
--
ALTER TABLE `store`
  ADD PRIMARY KEY (`idStore`),
  ADD UNIQUE KEY `store_namestore_unique` (`nameStore`),
  ADD UNIQUE KEY `store_typestore_unique` (`typeStore`),
  ADD UNIQUE KEY `store_addressstore_unique` (`addressStore`),
  ADD UNIQUE KEY `store_descriptionstore_unique` (`descriptionStore`),
  ADD KEY `store_iduser_foreign` (`idUser`);

--
-- Indexes for table `token`
--
ALTER TABLE `token`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_token_id` (`user_token_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`idUser`),
  ADD UNIQUE KEY `users_username_unique` (`username`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_phonenumber_unique` (`phoneNumber`),
  ADD UNIQUE KEY `users_addressuser_unique` (`addressUser`),
  ADD KEY `users_roleid_foreign` (`roleId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `order`
--
ALTER TABLE `order`
  MODIFY `idOrder` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orderstatus`
--
ALTER TABLE `orderstatus`
  MODIFY `idStatus` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_detail`
--
ALTER TABLE `order_detail`
  MODIFY `idOrderDetail` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `servicetype`
--
ALTER TABLE `servicetype`
  MODIFY `idService` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `shipper`
--
ALTER TABLE `shipper`
  MODIFY `idShipper` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `store`
--
ALTER TABLE `store`
  MODIFY `idStore` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `token`
--
ALTER TABLE `token`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `idUser` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `order`
--
ALTER TABLE `order`
  ADD CONSTRAINT `order_idservicetype_foreign` FOREIGN KEY (`idServiceType`) REFERENCES `servicetype` (`idService`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `order_idshipper_foreign` FOREIGN KEY (`idShipper`) REFERENCES `shipper` (`idShipper`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `order_idstore_foreign` FOREIGN KEY (`idStore`) REFERENCES `store` (`idStore`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `order_iduser_foreign` FOREIGN KEY (`idUser`) REFERENCES `users` (`idUser`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ordertracking`
--
ALTER TABLE `ordertracking`
  ADD CONSTRAINT `ordertracking_idorder_foreign` FOREIGN KEY (`idOrder`) REFERENCES `order` (`idOrder`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ordertracking_idorderstatus_foreign` FOREIGN KEY (`idOrderStatus`) REFERENCES `orderstatus` (`idStatus`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `order_detail`
--
ALTER TABLE `order_detail`
  ADD CONSTRAINT `order_detail_idorder_foreign` FOREIGN KEY (`idOrder`) REFERENCES `order` (`idOrder`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `shipper`
--
ALTER TABLE `shipper`
  ADD CONSTRAINT `shipper_iduser_foreign` FOREIGN KEY (`idUser`) REFERENCES `users` (`idUser`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `store`
--
ALTER TABLE `store`
  ADD CONSTRAINT `store_iduser_foreign` FOREIGN KEY (`idUser`) REFERENCES `users` (`idUser`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `token`
--
ALTER TABLE `token`
  ADD CONSTRAINT `token_ibfk_1` FOREIGN KEY (`user_token_id`) REFERENCES `users` (`idUser`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_roleid_foreign` FOREIGN KEY (`roleId`) REFERENCES `role` (`roleId`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
