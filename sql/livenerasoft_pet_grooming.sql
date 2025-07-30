-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 29, 2025 at 06:46 PM
-- Server version: 8.0.43
-- PHP Version: 8.3.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `livenerasoft_pet_grooming`
--

-- --------------------------------------------------------

--
-- Table structure for table `add_package_service`
--

CREATE TABLE `add_package_service` (
  `id` int NOT NULL,
  `package_id` int NOT NULL COMMENT 'packages.id',
  `service_id` int NOT NULL COMMENT 'services.id',
  `status` int NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `add_package_service`
--

INSERT INTO `add_package_service` (`id`, `package_id`, `service_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 3, 1, 1, '2024-11-19 09:51:44', '2024-11-19 09:51:44'),
(2, 3, 2, 1, '2024-11-19 09:51:45', '2024-11-19 09:51:45'),
(3, 3, 4, 1, '2024-11-19 09:51:45', '2024-11-19 09:51:45'),
(4, 4, 1, 1, '2024-11-19 09:51:47', '2024-11-19 09:51:47'),
(5, 4, 2, 1, '2024-11-19 09:51:47', '2024-11-19 09:51:47'),
(6, 6, 1, 1, '2024-11-19 09:51:49', '2024-11-19 09:51:49'),
(7, 3, 5, 1, '2024-11-30 10:46:20', '2024-11-30 10:46:20'),
(8, 3, 6, 1, '2024-11-30 10:46:21', '2024-11-30 10:46:21'),
(9, 3, 7, 1, '2024-11-30 10:46:24', '2024-11-30 10:46:24'),
(10, 3, 8, 1, '2024-11-30 10:46:25', '2024-11-30 10:46:25'),
(11, 3, 9, 1, '2024-11-30 10:46:25', '2024-11-30 10:46:25'),
(12, 3, 10, 1, '2025-02-05 12:46:30', '2025-02-05 12:46:30'),
(13, 3, 11, 1, '2025-02-05 12:46:30', '2025-02-05 12:46:30'),
(14, 6, 2, 1, '2025-02-05 12:47:11', '2025-02-05 12:47:11'),
(15, 1, 1, 1, '2025-02-07 09:26:16', '2025-02-07 09:26:16'),
(16, 2, 1, 1, '2025-02-07 09:38:48', '2025-02-07 09:38:48'),
(17, 2, 2, 1, '2025-02-07 09:38:48', '2025-02-07 09:38:48'),
(18, 2, 4, 1, '2025-02-07 09:38:49', '2025-02-07 09:38:49'),
(19, 2, 5, 1, '2025-02-07 09:38:49', '2025-02-07 09:38:49'),
(20, 2, 6, 1, '2025-02-07 09:38:50', '2025-02-07 09:38:50'),
(21, 1, 2, 1, '2025-02-07 09:38:53', '2025-02-07 09:38:53'),
(22, 1, 4, 1, '2025-02-07 09:38:53', '2025-02-07 09:38:53'),
(23, 1, 5, 1, '2025-02-07 09:38:54', '2025-02-07 09:38:54'),
(24, 1, 6, 1, '2025-02-07 09:38:56', '2025-02-07 09:38:56'),
(25, 1, 7, 1, '2025-02-07 09:38:58', '2025-02-07 09:38:58');

-- --------------------------------------------------------

--
-- Table structure for table `assignroutes`
--

CREATE TABLE `assignroutes` (
  `id` bigint UNSIGNED NOT NULL,
  `route_id` int NOT NULL,
  `user_id` int NOT NULL,
  `status` tinyint NOT NULL DEFAULT '1' COMMENT '1-Active,2-Inactive,3-Deleted,4-Permanent Delete',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `assignroutes`
--

INSERT INTO `assignroutes` (`id`, `route_id`, `user_id`, `status`, `created_at`, `updated_at`) VALUES
(6, 1, 2, 1, '2024-10-29 09:35:02', '2024-10-29 09:35:02');

-- --------------------------------------------------------

--
-- Table structure for table `banks`
--

CREATE TABLE `banks` (
  `id` bigint UNSIGNED NOT NULL,
  `account_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `account_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ifsc_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bank_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `used_for` tinyint NOT NULL DEFAULT '1' COMMENT '1-Collection, 2-Disbursement',
  `type` tinyint NOT NULL DEFAULT '1' COMMENT '1-Account, 2-UPI',
  `status` tinyint NOT NULL DEFAULT '1' COMMENT '1-Active,2-Deactive,3-delete,4-Permanent Deleted',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `banks`
--

INSERT INTO `banks` (`id`, `account_name`, `account_no`, `ifsc_code`, `bank_name`, `used_for`, `type`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Amit Kumar', '158222817455', 'INDB0000053', 'Indusland', 2, 2, 1, '2024-10-15 09:55:11', '2024-10-15 10:00:06');

-- --------------------------------------------------------

--
-- Table structure for table `cms_settings`
--

CREATE TABLE `cms_settings` (
  `id` int NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `logo` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `favicon` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `address` text COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `mobile` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `facebook` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `twitter` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `instagram` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `linkedin` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` tinyint NOT NULL DEFAULT '1' COMMENT '1-Active,2-Inactive'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cms_settings`
--

INSERT INTO `cms_settings` (`id`, `name`, `logo`, `favicon`, `address`, `email`, `mobile`, `facebook`, `twitter`, `instagram`, `linkedin`, `created_at`, `updated_at`, `status`) VALUES
(1, 'abc', 'logos/LfJZedpZcEdk6Tz5hH0kCTwNdpGFfYnFEFuDyKwJ.png', 'favicons/2fXyTNDWevDWk8aiAf9QCc8oUWgjJ0gOkOviVx0U.png', 'Noida', 'fazlu.developer@gmail.com', '999999000', 'https://www.facebook.com/', 'https://www.facebook.com/', 'https://www.facebook.com/', 'https://www.facebook.com/', '2024-10-16 10:32:37', '2024-11-08 13:07:08', 1);

-- --------------------------------------------------------

--
-- Table structure for table `dynamic_url`
--

CREATE TABLE `dynamic_url` (
  `id` int NOT NULL,
  `url` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` tinyint NOT NULL DEFAULT '1' COMMENT '1-Active,2-Inactive,3-Deleted,4-Permanent Delete'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dynamic_url`
--

INSERT INTO `dynamic_url` (`id`, `url`, `name`, `created_at`, `updated_at`, `status`) VALUES
(1, 'lead.create', 'Add Lead', '2024-10-11 12:00:11', '2024-10-11 12:00:11', 1);

-- --------------------------------------------------------

--
-- Table structure for table `emi_collections`
--

CREATE TABLE `emi_collections` (
  `id` bigint UNSIGNED NOT NULL,
  `loan_id` int NOT NULL COMMENT 'loans.id',
  `agent_id` int NOT NULL COMMENT 'users.id',
  `emi_amount` int NOT NULL,
  `payment_mode` int NOT NULL COMMENT 'payment modes.id',
  `reference_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emi_status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT '1-Pending,2-Paid',
  `status` tinyint NOT NULL DEFAULT '1' COMMENT '1-Active,2-Deactive,3-delete,4-Permanent Deleted',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kycdatas`
--

CREATE TABLE `kycdatas` (
  `id` int NOT NULL,
  `type` varchar(250) DEFAULT NULL,
  `number` varchar(20) DEFAULT NULL,
  `name` varchar(250) DEFAULT NULL,
  `mobile` varchar(250) DEFAULT NULL,
  `state` varchar(250) DEFAULT NULL,
  `response` longtext,
  `user_id` int DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `kycdatas`
--

INSERT INTO `kycdatas` (`id`, `type`, `number`, `name`, `mobile`, `state`, `response`, `user_id`, `created_at`) VALUES
(2, 'aadhar', 'XXXXXXXX9435', 'Amit Kumar', NULL, '234jsdfomsdf11', '{\"client_id\":\"aadhaar_v2_cUjjpmesnZgnrIiMxXGq\",\"full_name\":\"Amit Kumar\",\"aadhaar_number\":\"XXXXXXXX9435\",\"dob\":\"1997-06-27\",\"gender\":\"M\",\"address\":{\"country\":\"India\",\"dist\":\"Jhajjar\",\"state\":\"Haryana\",\"po\":\"Baghpur\",\"loc\":\"\",\"vtc\":\"Baghpur(129)\",\"subdist\":\"Beri\",\"street\":\"\",\"house\":\"\",\"landmark\":\"\"},\"face_status\":false,\"face_score\":-1,\"zip\":\"124201\",\"profile_image\":\"\\/9j\\/4AAQSkZJRgABAgAAAQABAAD\\/2wBDAAgGBgcGBQgHBwcJCQgKDBQNDAsLDBkSEw8UHRofHh0aHBwgJC4nICIsIxwcKDcpLDAxNDQ0Hyc5PTgyPC4zNDL\\/2wBDAQkJCQwLDBgNDRgyIRwhMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjL\\/wAARCADIAKADASIAAhEBAxEB\\/8QAHwAAAQUBAQEBAQEAAAAAAAAAAAECAwQFBgcICQoL\\/8QAtRAAAgEDAwIEAwUFBAQAAAF9AQIDAAQRBRIhMUEGE1FhByJxFDKBkaEII0KxwRVS0fAkM2JyggkKFhcYGRolJicoKSo0NTY3ODk6Q0RFRkdISUpTVFVWV1hZWmNkZWZnaGlqc3R1dnd4eXqDhIWGh4iJipKTlJWWl5iZmqKjpKWmp6ipqrKztLW2t7i5usLDxMXGx8jJytLT1NXW19jZ2uHi4+Tl5ufo6erx8vP09fb3+Pn6\\/8QAHwEAAwEBAQEBAQEBAQAAAAAAAAECAwQFBgcICQoL\\/8QAtREAAgECBAQDBAcFBAQAAQJ3AAECAxEEBSExBhJBUQdhcRMiMoEIFEKRobHBCSMzUvAVYnLRChYkNOEl8RcYGRomJygpKjU2Nzg5OkNERUZHSElKU1RVVldYWVpjZGVmZ2hpanN0dXZ3eHl6goOEhYaHiImKkpOUlZaXmJmaoqOkpaanqKmqsrO0tba3uLm6wsPExcbHyMnK0tPU1dbX2Nna4uPk5ebn6Onq8vP09fb3+Pn6\\/9oADAMBAAIRAxEAPwDpwKCvFPxSkcVRI0LSbeakxSAUrgMIo2mpMZ600igBmKa2CcUrMqoTuHy9c9qwNV8TW9g7xgb5APunii4G8oyM0rEAc1iHxHa2tik1zIv7z7uzndxn\\/PasO88cKS4t4gFHIMxwT9AB\\/WncDs1IJqQjivPE8YXDgv5gVv7ojGP1zWlaeMvlCTxYI6vu4pXCx1hHNKBWZpuu2upvsi3bv904\\/OtcDimIgcVHtqdl5pAnFAEJGBmmd6nkX5aYEyaAK7qN9JipJF+akZKpCNgCl2mpAmBS4qCyPbRtqbyzSbcUgIgtUNT1G20y1ae4cKoOAO5PoK0mU4ry3x1qMk+oG2DfJCSuPU9z\\/n0oAqax4lubiZjC5WMnIHf9KwLi9muJS0+9j3JFV1kZchhvDcUiPLE4O7BB6EVNx2HfamHHJ9OajluXcg4+laMbJcRN5sA8zPDdMfhSyabG65jzwO3NLmQ7GYLllG0n34qwlwWRV4GOuasxaHLO3AKp\\/eNNm0OaL5o\\/mFL2kb2HyM6zwrLEZkZGVJFJDID9\\/pg+3U\\/X8K7yKcOMcbhXi1leT6bcbmQjjpkgV1mk+KEjkUyAjceSxyv59a0TIaO+bk9KcoyM1XtpxdKpRlIK53A5B+lXCAvA6VRJXk6GkU8CpHXIpmMCgCJhl6GGKk2800iqQmbm2gKM08ClwakobQVqQD2oIyOlAGXrGoxaTpst3LyFHC92J6CvHLn7RquoTzyg+ZK24nsM11\\/j6\\/abUI7GNjthG4j\\/AGj3\\/AfzNY9pAIoR\\/ePUmsak+VFwjdkdjp8duoO0bvpWjHYwynLQoT7rSxLk1ft0HTjNcM5ts64RRXXS7c4\\/cR8dPkFTCxRV+WNQPpWvBDGQMmpjbp1FZ3ZpZHPNbdtv6VVktsjFdLJAoz\\/Ws64iweBTWgNXOVvbFGUqyg5rGgYaTd\\/voRPbOMMp9Pb0NdZdoCOhNYt5b+YjKRXVSqPqc84Gzol\\/JplwoRzNZOAwPUrk9R+JAP8Avd8V3yncoIIIPIIrzTwqWmeW1aIyupX5M\\/eTIz\\/Q\\/hXpkETrCnmH59o3Y6ZxzXWtTlYhFMIqZl5qJxTsAzFNan5prVSYjdDZ96fxjkVGg4GakHSpKF4pCaWkOKBHl\\/jC3MfiQyN0kAI\\/lUEa8AHpW748jButOcdSWH6r\\/jWFM\\/kpkDJPSuaubUiwuFq7bjcRisiEXU+CIwPrV\\/7FqwjykcbDr8hzj865eTzOhTaOgt7V2TcCDT5LWePkA1i2N3qUGd+zGMYrp7O+EkYDgbj61EopGkZXM3ypnHQ1TuIGUYati61MISqqAa5jUby+kfCRjb\\/s96Iq4SlYrXCMpPpWXOoJJqxNLflDm2fnv0rLN4wl2TIyn3GK3hCxhKVzZ8HRBfE8hC\\/8sGPX3FejVwXhIY12RscG3I\\/8eWu7z713Q+E5ZbgwGajfGKeSO5qNzxVEkGcEimmntjNRmkhnQCnAj1puPeo2i3SK24jHYHrSYycU0kUtZ2tPLHpU7QyFJMABh16j+lDdlcLXOe8YoJ5rADqrsePw\\/wAKxJbfgSEZxTzNM22OcuWQnq2R9RU+DJHtA61w1ql9UddOnbRmSt7Kk6xRplz0FSf8JNqVpO9sYUDK\\/lmMk7s+ucdOP5VfXT3LjA\\/StWDR18smWOIseckDNZwlHqXKMuhVlluoLsQ30PlzHjAOQfp+dWILpYpzkZI4xUE9usGfLVc54OOBUEEYV+TkmonZ7FwTW5I03mXexskntUF3qv2O1NzFYtLErbfMYgLn\\/Io1BcAMOtSWttFdQlQFAYYZCMg04WvdkzvsjGHiGS988iyIWIZdkbIAzjNUXnivQQV57Gt+fSWtkdIVVI3+8qcA\\/UVlx2S28hITArS8ehnaVtTU8LKIriQk\\/NsA\\/DNdmpyK89Ny9sWaJmUldvydT7V1+hPcyaapumBcEgc5OPf3rrozurHNUjbU0jUbdac7YpjVsZjGFMNPOaaTQM36OlJS4J70hi1n6yVXTZGbOBjp9av7f0rM15DJpEw9NrfkwP8ASlJXTHHRnFXYMTQZx8ybqtWWOCaxr6RkvIAc7dpUfpWraHKL9K86a91HbB+8bcGzsOauR20kvVsL7VnWuAea37V02EHAOK5+p0X0MPVYBbRbifoPU1S061aZ9zjrVzWzM7o0IVimflNZEU+pwTBt0E0J5KxqVdfw5z+daJaaENpPU19S05Ejx14rO0uBmd488qc4qO81a9uFPkwZ6AtIdoH9aj0ma7TUYzK8Zxku0YKjp0568\\/yp8rsJyTehpyh0O1+R71RnEe05Fat3gsWzwR0rCu2IJFJBIzScXahe2Tj6c12ejhVsPMG7MjFjn16f0rg5G\\/0+FRyST\\/Ku\\/siBp9uB3jU\\/mK76K1ucVV6WJydzUrEfjQi4OaRvvfjXQYCHAFMp7dKZQB0Bx6UopgJzS55pFAzVQ1I7rOVOPmUjP4VebpkVRvxmE9uKAPNtcTY0EuW3I+CMcfnV6xlDqMGk1iIywSqBlhyPwrP06YlVIPI7VyVado6HRCep1du+MZ61Zm1AW0RJbnHQVlwT8DmlnjFwvJ5HSuNLU629NCN7xrlgFBy2eBTY0dH3CSMP6Fv8iqGy73FQVVeny9SKuW9pGV3STEEdt1apGS1JNQSSWPaxCA+rAGsqO5ktJFEinHqTWhPaR7SVnbPsc1lutx9zCunQZ4xTsJ6am8L8TRKQwPH5Vn3bZqOCDyOS3UdAeKjupcKfWo5ddB811qZ6Lv1RABnANeg2SbbSJCc7UC59cCuF0eMy3jSc9cV39qm2EZ9K9GnGyOKo7knQ03rT+Caa3ArQgY3OaYc07HHNMIoA3+tOxRzmlB4pFCVTvhmA1bbPaq9yhaIigDh7wfvmrnJydOu9x\\/1chJHtXWahbssrHFctq2Ln93HhthIJB79x+FZzStqXFmha3SuuQfpVkzE9G5rkba9ksm2ODgGti31COTBLD8a4pQs7o6Yz0sbUSl87TUkmnSygAHbmq1rcKD2xWkdUjhiyBuI7VC3NHaxmR6fNEx3uNw7Cop18ur7aqlwSxULnnArPu5VIJ3cU5Eq1iBp9q8mqE91ltq8sxwBVW6vkDlVOQO9Q6dFPqGrRBXEYHOWIAPtW1OGt2YSmdRo0flyKuc+prtIR+6Fczp9m0UwOcg9\\/fuD711CDCCu1HPIUjFMOKUk005JpiGmmGnMKYaQHQjFLxUggPqv50vkN6r+dMoipjYOc06eSK2AMsiqT0UcsfoByfwrKvtQkxJFBb3PQ7pUjLFAOrYHHTJ5PbHGRSbQFfUkV5FghGbiRsLngKO7Z9B6\\/X+6RXH67BFa6hHDHIJG+YswyQegHJ9l\\/nXU+HI4r2a5nuJ5XQLt8iRiHCZ6kNnaoPUg54z3rI8deZDqlrEoVIljOVjGATubGfUgHr71hOXQqO5zk9hFdIdww3ZhWJcWFxavwCV9RXSQt0qd4w68gGuZTcWdPKmccmoXUBwrnHcGpH1q6I6Ct6XSoJSTtGaqP4fiJ6sPxq1OLIcWjJXV7gDBAHPU019UnlQoTgH0rQfQEB4dqlg0eGNgx+Yj1p88RcrMy0sZrhgzAhPX1rt\\/C1jaxuJtpEiTxRs45wrEnpz3T0NZDqEXCjAFafhy6eKcoNxV5EZlzgEg\\/L78c\\/nQpNsmUbI6LxIv9lavDdqpSG6TqSgXzfTnGSR7jk5p8WrW7Qq75XIyQFJx+Qz+OMV0V5ajX9Ga0uUIaeNWhiMb7kfoGLDoPwGBXN6fZMbkK8uyQ5b50ywfJDY5ABG09jxyfStoTaWpk0W0nhnGYpUcf7LA04mpZINL+VZ4xbSbsFlyFAHckdB9T\\/jUcmmXMccb2lxHcQMud7njHruHb04xwckVopoViM0w1TXUSgU3dtLbKxwjuMq3GSc1dTbKgZGVgeRg1VwOja4jWTyly8uM+WnLfj6D3OB705IZLqPcz+XGxwBGecHHVjxyD\\/D3H3qx3J0\\/7Iib4led1cjjaitg\\/1OTz3JJp013ZQsbe7m\\/eI7lDPK0hKlsgEZbbwB+XfOKycn0KLc1nHbuZIlMUu7DPHw0gHAzknPPr145FUjYG6e1tUXEk5EhLsH8qPrkHHGcZ7ZAXjJNUpNXsWJkuL8OgLbYvljAA46uOcnjHJ2k9DkV0HhQz3U9zd3I3TXB3eYVZP3fUYDAnBIwCTyF46VDYDNSsY9yi3keCW0CiCRhlo\\/TcTnch555289RuC8J4mmN9PbOYhG0cZjkRRgI4dsjHbHH4Yr1XWI0FvgBmnIYQgDJ7ZBz1TpnPHQ8EKR5hrPmT6k3mspZQ5lHzZQqUTknqeVHvgHvWbd0VHRnPxZQ7T2q7G2RTZIMEHFKFZMEdK53qdUR7IKaUYZwxxU6gEcimsvoaVyrFV4znk0xlCirZjyailQ9hSuKxTMe881raBYTNdoI5jAZXwsgTfgKV39PZhzx1qskO1dzcVuWTTWGoaSJleGN3eMEJ98SAYz\\/wIJ+Xsa2p3uY1NEdhpnh2wms0uJLZjIg+VmmcMT0ySpx69Aaxtbu10nWVlDiP7SRJsjztEhHP8IDbgAc8fxDqa723VI7ZVBwiKM47AYrh\\/G7zWtr9ntFlmWO3j\\/dxysv8WAcDOSDj889q0g23qYMe9xaapAX8jeDxt2+ZnjuFzxWZYRKiLZRQtE3mKjvbnaFUuOSOhPL81ztprUAERurWW3m\\/5aSFSqqw6bcHOfyAH0FdHEJbiPzop5ZYiQhZGMmRgjlgMcbunPP141QHQ\\/2bZouxY2j6BimBvGAMNgcg45z6\\/TFC90mAGNbVSjBWJaMhSxHQYxt6Z5xnjqKmk1y3EUcnnxs74zFGPMbPdeDgHPHJqG61QeSZksr+Py\\/mLtbjCjuevpnmkmwMLVtVury9RJMbbeEszpeRgk45wcEc8cCl0mytpJebBZvLjVGBvUG5hnLcdcjB4\\/8A1XhpVjNqGpXGyRI0mSEjznx8zhS3X2JroLDTxYWsj29xIjGVlYKq4cqdgJyCeig9e5ptiOZvdFtLnzmWyKRC2lkUKwcgrt4BbqOeo\\/M1P4TvbbQrBoLeAxXM5LsbhxsI5C5I6dDj15yRwR0V7b7LSRhgBbOcf+g\\/4VyPmQ\\/Z4bW+VVjmBe0uSMCJgxDbvXpxnOM9D2l6oZ1MmrW6Q\\/abm5aSFkzuGFeVADkn+4nJ9\\/QD5i3Gaaya9r9zfz2qshUJCijasYGApwOevOAc+lLLZveSvpks6tiTzLm6iJfz2PKIvqPc9T2+UZ6PStM87T02KuzIPGdqkA8Z6sRyM9ugO4MaSVinZGHrWjS2IW6GGtJnIjOckfX1B5IPcdhWYIty4r1WW0i1PSntJV25XaQP4SOhGPoDXnU1q9ncvBKuGRsEVz1FZ3N6MrqzM5YipwaesBParmUYkcHFP2gVkzdFZbbjmmSWwzn0q2WROTURlDrx09qAGWVrvud8jMsUQ8x2UAkAHsD1OcDvyeeM101toIu7GddQhb\\/SEw27OUHVNmeSR1Izzk56AGl4c03+07l3mGLWBwWBBw7DnHpwD+vvXS3hk1KKbG+OCMkGUYDAjjCdgQcgk9OR6kdNNcqOOpK8tDm7DU7ZLaW0voLR7y2Xysi33tKpGBJncCOoB6nntnFRWCLNrF5tintVd4otjQLGjNkE\\/Lk5+4c4bpk8Vj6tfwwX5msLh3vrYl0liZ3U7Tzkv1z97jI575zW1pWpSaxeHUZ5Y4YkkjeGHcDyz7XY9+m76frWqM5WN6LS2W88yXyWLLtbyotgcf7WScn8ax9f0mKBGu7V3glilR5fLRUwjfKQCoBPQdTXTvOomwrFtpAIUbiCfUDpVPW0iurY27hxJKrImVITONwJOMfw1KbAw9O0+4aPYRJGxVZXklVQx3EkElcFvmV8g+taE\\/h+1kiMqRIJNpyqrhGJ77f\\/AK9RadcLcRxToikSuyMyuTukZRJ+SgEfjWs91CkQQTJvzt27hnPpVN6gYelXsct5JdPv8trlnZGXK+WAQTx6GUH8K0W1KG3trKGUSxYiUsgXDg454Pv+f8uUsrG5t9LhEb3cSPbFW2sCD5rNjoR\\/dUdK6+0tLqOFpEimZpDlmLgluwO4MpPHqKpoCS\\/1WOXTZ\\/Lsr0g2snSLkDHXHftXKRXMM+kpFLFfSMtvct5bwp8p3DBxjI65zXVXtpdHSrvzVI3W8pI+1SKRx9WH9PasawtJv7CTZGQDZ3Ryb2Q8ZXPbHXtSENm0RJUkFo0WmMScNPKdzLyCCCelLouvXGk3X9maxNDLagqkV9E4ZIyeAr46A46np345XqrG2nikkzO0TseRGQ35lgcn34\\/GsLxJpizx37SzGRoooiokjVgCzsCcACk7bDOiLNE7yZ27R82emB61zHimJPPju49u+YHeM9APunp14\\/p2pthqc2k2VvYXcfnsYYhaSKPkO7ICsP7wxx68dOpdc2UmZUuJGa6kQLsRuFPBAPvx27DripcbocXZ3OWkzjIB9hUKzE5yT16ippkYj5csSQBg5\\/Kq5iHmj\\/aHT\\/P+etc1jsUiwRuUHOfeoY23ShAVHIHJx\\/nr1prSmNGULu559varmkQb52uChMcJDMBjqTxnIPHueMCnGOopysjr7ea2g0FYkmVMKvmnIV16EnnAHQnJ4BJ5wCKy1Fz4rzbRpcJpEAX5Iysbz4xt+8RhRjjr789Mxx\\/wkN3NFE7IkUTmeSM4WdhgbVA92x1Iwe+SW7+z0+y8hCkQeJkAVZCXAXHQbs4roascZx02lixzbQ3LQNOHgWMqrsAysRkKxJzgDOPeqFlLqcumQxrdxtiGaILJCy5dmUD+Drhs\\/nXc3lnbQEMkGz50AERKAZYAn5SOxrmbLSrZYLq3hiLNDesq7zuGWDIvX\\/ax1zVJ3Qi5ave6hHE0moSszDzDFCqxtj1DHbkfnU19bSNYyss2uIY\\/m3PIpAA5PUjPA9avaZp1utoIniWQRM8SiT5wArFeAc46dquHS7AjH2G2\\/wC\\/S\\/4Urq4WPPLaeeyF5bC1WZrUsynztg2owblQcEtuA78L6its3N7PYPJ9rjEfBEccJaPHH8YBA\\/Oq+p6UltrFoF8kLcIqHaPkMiHaxI44AJPGK19PsIzpz2\\/mSuVygOSgOANpIHByu05PrVO24EdvaWiva20toiyyJAgdVGQ8YMh5\\/ED8a6wYUADt2oookCM7WWIWVRnmwuTgf8ArK01g2gxq33hZXXH\\/AANf8KKKOgHRxj\\/ST2+YVna7Zmaz1FlOD5KE\\/RWLf40UVK3GZVylpf6MYZEEiNZRHnuY1lY\\/quKbLDPaXAs7icEjLWsrLgzc5ZXP94cc985OTRRQwMHUsLfyMOjHeD9ef5\\/496oIpbLg7mIOGHQfhmiisZLU6YO6GSwmMkhRyvOD19\\/5Vc0+3kljg0+EMst2\\/wAr\\/wAIUKct+Azgep68YJRThuRUehseFLCKC0gJfZGtyyHI6AIsmT+MQ\\/Out0oj+y7MAjBgjYf98iiitWjEfqMnkwM67TKilkRjjcQOB+eK5lJRBf6qsaq2Cl2ST12MHI\\/HJoooitANWwnt7WS4tZbuHekuMFwCSVUk9e7Fq0JJ4osM0qKPUsBRRSA5XxLcWT6UVhkhZre73Elx0YFj36EsBWhps6XVyzeasgmiVwUGF3D5Wx+Hl\\/nRRT6Af\\/\\/Z\",\"has_image\":true,\"email_hash\":\"\",\"mobile_hash\":\"1d018ca79ef0e8d7883493a91f416c67b0274fa697e0bda6cc117c8e7f46d3e2\",\"raw_xml\":\"https:\\/\\/aadhaar-kyc-docs.s3.amazonaws.com\\/nerasoft\\/aadhaar_xml\\/943520250226182804859\\/943520250226182804859-2025-02-26-125805044601.xml?X-Amz-Algorithm=AWS4-HMAC-SHA256&X-Amz-Credential=AKIAY5K3QRM5FYWPQJEB%2F20250226%2Fap-south-1%2Fs3%2Faws4_request&X-Amz-Date=20250226T125805Z&X-Amz-Expires=432000&X-Amz-SignedHeaders=host&X-Amz-Signature=f468bae8503606ef515edf5cde8769fb79f9d45d6c4314053ed8bc59bd3401a5\",\"zip_data\":\"https:\\/\\/aadhaar-kyc-docs.s3.amazonaws.com\\/nerasoft\\/aadhaar_xml\\/943520250226182804859\\/943520250226182804859-2025-02-26-125804978891.zip?X-Amz-Algorithm=AWS4-HMAC-SHA256&X-Amz-Credential=AKIAY5K3QRM5FYWPQJEB%2F20250226%2Fap-south-1%2Fs3%2Faws4_request&X-Amz-Date=20250226T125805Z&X-Amz-Expires=432000&X-Amz-SignedHeaders=host&X-Amz-Signature=71f2a411d5a06b28e4d0967c9dffd23365a8df431ae297353b188af8e8ca317c\",\"care_of\":\"S\\/O: Ajit Singh\",\"share_code\":\"1297\",\"mobile_verified\":false,\"reference_id\":\"943520250226182804859\",\"aadhaar_pdf\":null,\"status\":\"success_aadhaar\",\"uniqueness_id\":\"ee58f364088d59d449330c7d622e51faf1ea83f3a7f98083de87d19613295f5c\"}', NULL, '2025-02-26 14:05:48'),
(3, 'aadhar', 'XXXXXXXX9175', 'Rajbir Singh', NULL, '6783597812', '{\"client_id\":\"aadhaar_v2_yroDkhCAOkRCbAxjbcjr\",\"full_name\":\"Rajbir Singh\",\"aadhaar_number\":\"XXXXXXXX9175\",\"dob\":\"2002-11-18\",\"gender\":\"M\",\"address\":{\"country\":\"India\",\"dist\":\"Amritsar\",\"state\":\"Punjab\",\"po\":\"Amritsar G.P.O\",\"loc\":\"Block -E, Pyramid City\",\"vtc\":\"Amritsar -I\",\"subdist\":\"Amritsar\",\"street\":\"Sultanwind Link Road\",\"house\":\"2\",\"landmark\":\"Near Golden Gate\"},\"face_status\":false,\"face_score\":-1,\"zip\":\"143001\",\"profile_image\":\"\\/9j\\/4AAQSkZJRgABAgAAAQABAAD\\/2wBDAAgGBgcGBQgHBwcJCQgKDBQNDAsLDBkSEw8UHRofHh0aHBwgJC4nICIsIxwcKDcpLDAxNDQ0Hyc5PTgyPC4zNDL\\/2wBDAQkJCQwLDBgNDRgyIRwhMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjL\\/wAARCADIAKADASIAAhEBAxEB\\/8QAHwAAAQUBAQEBAQEAAAAAAAAAAAECAwQFBgcICQoL\\/8QAtRAAAgEDAwIEAwUFBAQAAAF9AQIDAAQRBRIhMUEGE1FhByJxFDKBkaEII0KxwRVS0fAkM2JyggkKFhcYGRolJicoKSo0NTY3ODk6Q0RFRkdISUpTVFVWV1hZWmNkZWZnaGlqc3R1dnd4eXqDhIWGh4iJipKTlJWWl5iZmqKjpKWmp6ipqrKztLW2t7i5usLDxMXGx8jJytLT1NXW19jZ2uHi4+Tl5ufo6erx8vP09fb3+Pn6\\/8QAHwEAAwEBAQEBAQEBAQAAAAAAAAECAwQFBgcICQoL\\/8QAtREAAgECBAQDBAcFBAQAAQJ3AAECAxEEBSExBhJBUQdhcRMiMoEIFEKRobHBCSMzUvAVYnLRChYkNOEl8RcYGRomJygpKjU2Nzg5OkNERUZHSElKU1RVVldYWVpjZGVmZ2hpanN0dXZ3eHl6goOEhYaHiImKkpOUlZaXmJmaoqOkpaanqKmqsrO0tba3uLm6wsPExcbHyMnK0tPU1dbX2Nna4uPk5ebn6Onq8vP09fb3+Pn6\\/9oADAMBAAIRAxEAPwD3uikoxVGItFJiikAtFJiloAMUmB6UtJQAbV9BSbF\\/uj8qWii4rITYv90UbF9KXFFO4WQmwf5NGxff86dijFAcq7Ddg9\\/zo2D1NOoouLlQzZ\\/tGjZ\\/tGn0UXDlQzYf7xpdp\\/vfpTqTFFx8qFopMUtIYUtJRQO4UUUUAFMaVFOM5PoKpXt6I2MS5ZuhUf1rNa6foz\\/8ASs51OU1jTubhuUHUqPq2KYbxOzoPzrEErEcIB7k0okfjlawddmqpI2ftRz99D+dKLr1UH6GshZHz1P4GpVkbpnP1qVXYeyRrLcRscZwfepuKyUYmrEcrJwD+FbRrJ7mcqdti9RTEcOOKdWydzLVC0UmKMUw1FopMUtACUUlGKCRaKSigBagu5hDATu257+lTVgapch33OTsBwid2PsP8\\/UVM3ZFwV2VJpw2Qvyr+pqLzVRgGIUnoM4z+HU1A\\/mS9cr6BTj9f8P1qMbFzluh52jgfWuCpM74RLizKemc+y4\\/nUgmyOjfpWeLhSAyEkHuoLfqoIqbzwpGWkzxjkD+dYORpylwTR5wWYH1KkD86mRyRlJAw9jmqQnbdgq+MdSCf5CnLJHKdy4PH3l6kfhzS5hOJeF2Iz+8G0evT\\/61XYp0kX1H6isxGY9CJFzgjPI\\/p6cUghePMlq2COsZ6fl2+o\\/WtITM5RRuRvtIOcg9DVsHIzWPaXImXoVcfeU\\/5\\/WtOA5XFd1KV9DlqKxNRRRWxmFFFFADc0UUVRncM0ZpKKBXIrqTy7dj+FcpdzKJGZzlj8ox1PsPQf8A6zzW5rMwitwM4JrjJ33kljgnIHOBgdh7Due\\/5Y560raHVh431JpbwvkZG30Hf\\/H\\/AOv0NRLM28AjcU9edvH5D\\/x2qxXC8swBBz1BOefqPXA+pNAnVWAVeR0AAO0+uOnqCOD6Zri5ZSdoo77xgrsuB\\/MSMY3dw5Xdj8cMP1qfz5ECoVkYf3yo\\/of6VXjTcF3opAOdrMXIPseOKm2SEfNPIR7qnH\\/jtbLBVJGLxlNCRuVd5clU6lmUx4x6naP51OJmK7nGUJ6nkY+oJ\\/XFQJbESCTzSxHQMigf+OgU\\/bMmGBDnOe\\/5ev6n6VM8FViOOKpyZZjmwy5JDHkbj179fT9PrV2G8GcSEoy9GPB+vuOn9cVkxurHauEkPQE4Dnv9D7jBGeRUoYqgypwpHB+8pPTp\\/Tr29Dzq6dmatJm0xyTKgAmTqB0Yf4H+dadnOsgVh0YVg2kwLohwR\\/yzYdPp9D\\/ntnUtFMVxgfdLBh+P\\/wBeuyi9TjqqyNeikpcV2HMFFJRQFxuaM0lIaoyuLmkzRSU7EORzniabbJGmfl25J9Pr\\/ntXKtPhSzBixOFXP5D8M\\/mTXReK4szxyEHBjwP9rBJI\\/LNcpK7ZyWOc7R2O45yfrw5z64rlrRu7HoYeSULkjuVJB5Y9T\\/h7fz6mnQnnNYWo300LeVbpkgfMRwBWS+palnALKPwrvo4dQiclSu5yuekW5UjGauKAV6CvM7TWtRSRSZCQDzxziuv07U3uYwWGWrbksZcxv7VZccGmMqgdOlZN7qv2VORg1h3HjCSJ8LFuUGlyNi5jqZIlcMAv3uuOPxz2PvT7aUyYgkIMmCFZv416EN+gP1B78crb+MtzDdCV55BFbtvqFtqarLCCkqH50P8AEOnH1BI\\/H2rjxWEvHnW504fE2lyPYuoTBKYudrnK888n+ec59+e9dDaz\\/aBA2QSxGSOmQea5u+J+zmRhuIw2cdTwD9AflNbnh9XeVt5LGPJJxgAnGB+R\\/SuSgr6nXWelzoqWkorqOO4uaKSigLkW6mlqSkrSxyOTF3UhakpDVWM3JmJ4pj36asgBJifPHpj\\/APVXExDdI2cNsGMkck8c\\/mp\\/OvQtWiM2mXCDrsz+XNcHZRb4Gc43EkfqankvNHXSqfuWjC1GVEPzMEGeTWe2p21mVzaOyv8AddhjP510N7pYnJOAT7is\\/wDsMugR9hUHIDDOPwrsVupCvbQpQzw3LRusTRebnZkYDY9K6Pw+wMhUoTg9qp\\/2cIogCc7RgcYxW5oVt5OcLwaT8iku4zWI1dwqoMkd65Ga9tYJsyJuQNjIXPNeh6jZido2IxxXMX\\/hvcphVV8vOdpGBn2xTj5kvyILW+sLqPZbuhl7LIm0n6YA\\/rWzpex2yV2uOKyovD7tEluYdsanOAOc+uetdNpmlG2VdxLY7t1ola2hFxly+2wlfgqYWbn\\/AHSB+iiun8NQhNN83BzKQefYAVzdxal4bi3Ax8hUAdAMMBXa2Nv9lsYYSMFEAOPXvXmwjypo9CrO8UWc0ZpMUVZzi5ozRSUDK+aTNFJWpwthmgtSGmmmRcbJhlII4IxXn2BaXk9v2QnH\\/fTV6A1cZ4itPJ1ZbkH5ZY9uPQj\\/APXWtNXZcJ20K\\/mgjpTCgJyBiq6sc8ZqdDn\\/AOvVtHQiCY7pBGCABya19MkhDj5xwOfeua1dpYkMkJOTwaytOu7+IN5krSHscYIp2uimeqO1vPBsMiiQfdqkwD\\/KwGRXHRXGqzXMTROhj7gjkV11sH8kM5yx60mrEXJoFWPtVsTLt4GKpeZt9\\/ahXyaViZF3SIlu72aZxlUYYB9QTiujBrI0OExaerMMNIdxrWFcslqzVTuOzRmkpagsM0ZoooArZpCaQ0hrY89sC1NLUEUhBpk3Gs1cx4pk2xw9Mbua6crWJrtiLu0fB+cDitqVrivY5ASgVQvtUltThI92f0p7uUYoTyDiq1wizHrirkrM7Iu6ImvXnhzO4QE5xmrVrd6f5ZSVWyejDFZraZErbgu9epBPSrUdppjAbolBH+2Rn9aLm0YJrU00u7MFBCTEQRjcetXE8S\\/Z5hbzKSOgZayk0yzuQFiiAz\\/FuJx+tXI9FhgClZC5H985odupnOKT0N9LjzRuHKmrEDeZKqHjccVnq4RABxgVo6PF9pvQedq\\/MTSXcxm7I6xMBQB0FSBqjAxThXIwi2iUNS5pgpwqGdCbHZpM0UUiiqTTSaKStzzrhSE4oNNNAhGaqdzhlIq2elVZhnNawEzzbxUV0\\/UVdBhHGW+tZ8E8dwMqwqz47cS3gRQR5YwSe9cZb3stnJ8pJTPNay1OqltqdotpvGGcYNMGhRtOGM547GufXWyed\\/Xpg1Zj8SFU5bJHAJqUmjVs7K00uNIwY5Ax9c1YeHy8M7cL0riIfE8glBBAX2NLe+JpZoPKjOWPU0+Vsls6G81ZFnEERDSHgDNdv4fjKW0R4JKgsQfWvJNER5LvfISTjg1694elt5rT9zIpZPldAclSOOac7KDOeomzdBpwNMFPArjY4tjwaeDUYp4FQzoi2LmjNFFIu7KeaaXpuaax5roSPOFL00vTGYDvxVJ9TtFuBB5ymVhkKvNWogk2XTJVS8n8m3kk4yBxmql5qqW0W9iiDOMue9YlzfT3MMgd9yvGSAMAAA88f561pGPUuMGzlfE80lzLHcMAYWGzpyO4yffmuQmgyxIziu4udstpLC0YfzflUn+E+tcpLFJBK0Mq4ZTg+9Jtnba2iMCWJgTzwOlM2SEdeP51sNArnkU9bTAHFK4GbFDJuweua1LezkGMIeTxV6104M29xnPat63tUEYXHAo5yGO0u1S3i8x1BwPTmofC\\/iR7HXLgrysspLDPVcnj9asXc4gtn28cVxNm5jumYHo+a0h710yHtc+kIJ0niSRGBVhkEVODWJ4dure40uIW5XagAwK2xXJNWdjNXTHg07NMFPrNm0Wxc0ZpKXFIvU5+fVbeGQxlw0gGdo7Vg6r4olt4IjDGoaZsLznj1qKwtUDspy78kkHnpRqdnbR6hZxyABUhZsucDPAruSijn9nFNIoya5NdELICTns2Afwp8rsoMkWI2iYAPnJJNT2mlRSXRkUnYuWyvIpNRittO0\\/fcS4YgykMepPTikjaTjeyOSv7yWaGVi7M01yNufRQf8RWxdySaamm3TIwt9vly\\/Ru\\/wCYzWa19YmOwQOc5aQgR8jJx6f7Na\\/iG986xjgFk7IUX5mbB4B7fjW0rpERd9EjN1Yst7uh\\/wCPZBwR0JNZRtRqCgAf6YxzuJ4x2H\\/16v2tyLq0GnFgsh+4x7r6U7To1tJ5JvvFGIUN1OO5rNrqaXuuV9Dnbi1ntLhoZ4milQ4KsMEVNC6jAwK6u7D+JrVpoxDLJb\\/KWJxIR6Y9PT\\/9dcvLD5TgEEEGoaEn3L8LYGBV3zdie9ZkLgMB61emBVBSAz9RuWaNue1c7E2Jz6k1s6iMAD+9WYsQWYNxWlJ6ky2PXfAyzJo6THiNzge3bNdYbw24JmGUH8S1xvhC7u49IOSGgQKPLBB2+9dDqDB7Jpod3yjcVH8Q7is5xvLUnmurm5BPHcRLJG25W6Gpc1zFpr1j5Ue3ciADbt5H41fTVCCDuVkPTNZODuUk7GxupQ1VYbuKbvtPoas1m1YE2eRaPbAtNJE8kZCHlTU2sM512zS4labMTABu3P8A9arOh3GnfZJW3uCVA7d6o69dWo8S2pikMmyL7vvk8V1LmsVJxdQ07a0K285gkli34QBGwDk1m+I1WONwCztlUDMcmt+zvoDFB5lrIjMTIMDrgVy+vapLIiBLTbukyCw5pRT0TE2nJtIhFuzazDEqH93FGoAH+yP6k1ua9DKZlURtgEjp7CsezvdRufEshBRcTBcH2OP6Va8RSakZxmdR87dCfQD+lXJLuOm5XRjz2T29yt1sKgdSeBVi4lS6jSK0fJRR5so4BPUgetMsZdRS6C+cj+oboa1LiJxqUkckCW\\/mAFSB8pfHr71F9NDSXxK5DDbKpF3HNNC+fLJgUE8juO4p97bm7toxLboJYwQZUGBIM8H69f8AIqaK2eC5iklJjhIOVOQCfTNTXdwjOI4tpXGTt6D2oTajZmUkpTujl44GN8sYB4Nak0Dbs44FTW9sEuDK3U+9WJ57eCMtK6KPc1JRyWpgtJu6Bayg+6QVv69CI4YmUOpc854FZVrarlXc\\/LnjP8R9K3paK5E+x6L4a1HTU0\\/7E0qpdeWvXglvSur0wGSNo3wCV6djXiLQyC4aUMwYtnI9c16V4Z1qZ4IQziSYYQqR973qJ+Q+VqNyO90+XTrye2Iyg+eMgfwntVzRHme2dZIzIifOoPb1xS6xq1uuqATO0L\\/Zh8hGRnJ6VHpOs2UcgBMwDAjOOKl81wU7wH6he3ukM7QEFR8yq4yCKu2fiO4U28kyFoZkzlR36EYqDUNW0+40uJmnBYAody8\\/yrDstZtF0xkdpFMEwwWXIwQf\\/iauEeZNNGVSWiZU0m8tDYKHUAvIMgr2HNY15dQy+JppIlDbAFQAd8f\\/AK6KKOW0TTmvUOuivL6Pb\\/oZ\\/dW+fu+v\\/wCquWvp725vbOFrbG6QdQRnkUUU0lzLQzU5WYzR5byXXmk3RJulLHLrx1PrVnW5byS4GbqD+I\\/fX+8aKKuSRUJPmRmW73sd4m2WJyTjh1NdJr11dtpN4Z7ZkKY2uARg0UVEUrjrTkmhNMY3+kwXLTMUV1YrjJGeCKoeJZx4dm32yhlkb+P3Gf8AGiism3sbRiuc5O58U3k2cTBB6IMfrUuh3K3V8bm6ZpNv+rDnI3difpRRTN3a2hoah51xN5107BRnLEfoKfa\\/2fJfxxMXVUCjr3xz+uaKK0j8Jyz+I3Z9KspIkME4yc9T7mtPw9YTRXkZABCkdDmiioktwUmokvidtmrWLnGHQrz7f\\/rp8BWN4+MDOKKKynujSnrEiugj2GzaNyTsOnbmsW5byrS\\/UfwvG3T1z\\/jRRVx0kQ\\/hP\\/\\/Z\",\"has_image\":true,\"email_hash\":\"\",\"mobile_hash\":\"4affeb96c4cf60640088712d3f3b7d64dcfccf8dbb06b425098cce2735b2fafe\",\"raw_xml\":\"https:\\/\\/aadhaar-kyc-docs.s3.amazonaws.com\\/nerasoft\\/aadhaar_xml\\/917520250227182422214\\/917520250227182422214-2025-02-27-125422440640.xml?X-Amz-Algorithm=AWS4-HMAC-SHA256&X-Amz-Credential=AKIAY5K3QRM5FYWPQJEB%2F20250227%2Fap-south-1%2Fs3%2Faws4_request&X-Amz-Date=20250227T125422Z&X-Amz-Expires=432000&X-Amz-SignedHeaders=host&X-Amz-Signature=0fd24fbdabf9d6e80c34d57fe2738be0d2625b028d35be9a5b9ec989a64c3ab2\",\"zip_data\":\"https:\\/\\/aadhaar-kyc-docs.s3.amazonaws.com\\/nerasoft\\/aadhaar_xml\\/917520250227182422214\\/917520250227182422214-2025-02-27-125422354598.zip?X-Amz-Algorithm=AWS4-HMAC-SHA256&X-Amz-Credential=AKIAY5K3QRM5FYWPQJEB%2F20250227%2Fap-south-1%2Fs3%2Faws4_request&X-Amz-Date=20250227T125422Z&X-Amz-Expires=432000&X-Amz-SignedHeaders=host&X-Amz-Signature=d7249f834ab4e83a37753034960571ab83509359b541fd67757a19af8df6313a\",\"care_of\":\"C\\/O: Surinder Singh\",\"share_code\":\"5491\",\"mobile_verified\":false,\"reference_id\":\"917520250227182422214\",\"aadhaar_pdf\":null,\"status\":\"success_aadhaar\",\"uniqueness_id\":\"06d6559db4ddd65ae8d23842f4603ffb574ab3bf8a7cc94cc891b975a75f5044\"}', NULL, '2025-02-27 12:54:23');

-- --------------------------------------------------------

--
-- Table structure for table `kycs`
--

CREATE TABLE `kycs` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` int NOT NULL COMMENT 'users.id',
  `loan_request_id` int NOT NULL COMMENT 'loan_request.id',
  `aadhar_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pan_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kyc_status` tinyint NOT NULL DEFAULT '1' COMMENT '1-Pending,2-InProgress,3-Completed,4-Approved,5-Rejected',
  `status` tinyint NOT NULL DEFAULT '1' COMMENT '1-Active,2-Deactive,3-delete,4-Permanent Deleted',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kyc_leads`
--

CREATE TABLE `kyc_leads` (
  `id` bigint UNSIGNED NOT NULL,
  `loan_request_id` int NOT NULL COMMENT 'loan_requests.id',
  `user_id` int DEFAULT NULL COMMENT 'user.id',
  `route_id` int DEFAULT NULL COMMENT 'routes.id',
  `agent_id` int DEFAULT NULL COMMENT 'users.id',
  `file_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `customer_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `son_of` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type_of_work` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shop_address` text COLLATE utf8mb4_unicode_ci,
  `shop_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `home_address` text COLLATE utf8mb4_unicode_ci,
  `home_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `material_status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sms_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reference_1_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reference_1_mobile` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reference_1_relation` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reference_2_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reference_2_mobile` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reference_2_relation` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `loan_amount` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `processing_fees` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emi` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cheque` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `aadhar_docs` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pan_docs` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `aadhar_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pan_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `elec_bill` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `business_pic` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gurn_docs` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `side_verify` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rc_vehicle` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remark` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kyc_status` tinyint NOT NULL DEFAULT '1' COMMENT '1-pending,2-submitd,3-approved,4-rejected',
  `status` tinyint NOT NULL DEFAULT '1' COMMENT '1-Active,2-InActive,3-Deleted,4-Permanent deleted',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kyc_leads`
--

INSERT INTO `kyc_leads` (`id`, `loan_request_id`, `user_id`, `route_id`, `agent_id`, `file_no`, `customer_name`, `son_of`, `type_of_work`, `shop_address`, `shop_type`, `home_address`, `home_type`, `material_status`, `mobile_no`, `sms_no`, `reference_1_name`, `reference_1_mobile`, `reference_1_relation`, `reference_2_name`, `reference_2_mobile`, `reference_2_relation`, `loan_amount`, `processing_fees`, `emi`, `cheque`, `aadhar_docs`, `pan_docs`, `aadhar_no`, `pan_no`, `elec_bill`, `photo`, `business_pic`, `gurn_docs`, `side_verify`, `rc_vehicle`, `remark`, `kyc_status`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, 1, '2024-10-29 07:57:42', '2024-10-29 07:57:42');

-- --------------------------------------------------------

--
-- Table structure for table `kyc_leads_guarantor`
--

CREATE TABLE `kyc_leads_guarantor` (
  `id` int NOT NULL,
  `kyc_id` int NOT NULL COMMENT 'kyc_leads.id',
  `name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `son_of` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `type_of_work` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `shop_address` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `shop_type` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `mobile_no_1` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `mobile_no_2` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `home_address` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `land_load` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` tinyint NOT NULL DEFAULT '1' COMMENT '1-Active,2-Inactive,3-Deleted,4-Permanent Delete'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kyc_processes`
--

CREATE TABLE `kyc_processes` (
  `id` int UNSIGNED NOT NULL,
  `user_id` int NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_of_birth` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_personal_verified` tinyint NOT NULL DEFAULT '2' COMMENT '1-Verified,2-Not Verified',
  `aadhar_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `aadhar_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `aadhar_father_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `aadhar_dob` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `aadhar_zipcode` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `aadhar_country` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `aadhar_state` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `aadhar_city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `aadhar_address` text COLLATE utf8mb4_unicode_ci,
  `aadhar_profile_photo` text COLLATE utf8mb4_unicode_ci,
  `aadhar_mobile_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_aadhar_verified` tinyint NOT NULL DEFAULT '2' COMMENT '	1-Verified,2-Non verified',
  `pan_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pan_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_pan_verified` tinyint NOT NULL DEFAULT '2' COMMENT 'is_pan_verified',
  `ifsc_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `account_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `account_holder_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_bank_verified` tinyint NOT NULL DEFAULT '2' COMMENT '1-Verified,2-Non verified	',
  `normalized_city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `continent` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country_code` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `county` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `postcode` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `road` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `road_type` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state_code` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state_district` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `suburb` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_current_location_verified` tinyint NOT NULL DEFAULT '2' COMMENT '1-Verified,2-Not Verified',
  `equipment_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `trimer` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `blower` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scissor` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_equipment_verified` tinyint NOT NULL DEFAULT '2' COMMENT '1-Verified,2-Not Verified',
  `live_photo` varchar(555) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_live_photo_verified` tinyint NOT NULL DEFAULT '2' COMMENT '1-Verified,2-Non Verified',
  `live_video` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_live_video_verified` int NOT NULL DEFAULT '2' COMMENT '1-Verified,2-Not Verified',
  `kyc_status` tinyint NOT NULL DEFAULT '1' COMMENT '1-pending,2-submitted,3-approved,4-rejected',
  `step` tinyint NOT NULL DEFAULT '1' COMMENT '1-personal detail,2-id proof,3-bank detail,4-current address,5-equipment capture,6-live photo,7-live video',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kyc_processes`
--

INSERT INTO `kyc_processes` (`id`, `user_id`, `name`, `mobile_no`, `email`, `date_of_birth`, `gender`, `is_personal_verified`, `aadhar_no`, `aadhar_name`, `aadhar_father_name`, `aadhar_dob`, `aadhar_zipcode`, `aadhar_country`, `aadhar_state`, `aadhar_city`, `aadhar_address`, `aadhar_profile_photo`, `aadhar_mobile_no`, `is_aadhar_verified`, `pan_no`, `pan_name`, `is_pan_verified`, `ifsc_code`, `account_no`, `bank_name`, `account_holder_name`, `is_bank_verified`, `normalized_city`, `category`, `type`, `continent`, `country`, `country_code`, `county`, `postcode`, `road`, `road_type`, `state`, `state_code`, `state_district`, `suburb`, `is_current_location_verified`, `equipment_image`, `trimer`, `blower`, `scissor`, `is_equipment_verified`, `live_photo`, `is_live_photo_verified`, `live_video`, `is_live_video_verified`, `kyc_status`, `step`, `created_at`, `updated_at`) VALUES
(1, 106, 'sarthak', '8835634657', 'vdshbj@gmail.com', '2025-05-01', 'Male', 1, '495483265833', 'dhjfbjhd', 'dsfdsdf', '2025-05-29', '234214', NULL, NULL, NULL, 'rb urfb uuru jwf', 'kyc/HTmBpS8tqysPtvmNTcWVj1VY6PTYShmsBt6EnjjY.jpg', NULL, 1, 'FGHII3846S', NULL, 1, 'ICIC0000226', '123456789876', 'UBVUR', 'VCHS', 1, 'Mountain View', 'building', 'building', 'North America', 'United States', 'us', 'Santa Clara County', '94043', 'Amphitheatre Parkway', 'residential', 'California', 'CA', NULL, NULL, 1, NULL, 'kyc/NjW2FTI9VswI8r1ouy9tV0bhIBlAErTGhJMI9Oev.jpg', 'kyc/l93RHsiLyXF44O5awfvMyC4bKhfCKxLwvZrug9l7.jpg', 'kyc/8oDlEie4FHTu8robdFhsn9ddUjOM8yotCNPX085x.jpg', 1, 'kyc/zIO9W9nJdKrce361Sdn5haiwSTW694Yuf1HZTvvH.jpg', 1, NULL, 1, 2, 1, '2025-05-30 07:44:47', '2025-05-30 10:08:47'),
(2, 108, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, 1, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, 1, 2, 2, '2025-05-31 13:49:19', NULL),
(3, 109, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, 1, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, 1, 2, 1, '2025-05-31 13:52:16', NULL),
(4, 110, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, 1, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, 1, 2, 1, '2025-05-31 14:00:42', NULL),
(5, 111, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, 1, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, 1, 2, 1, '2025-05-31 14:06:36', NULL),
(6, 112, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, 1, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, 1, 2, 1, '2025-05-31 14:08:44', NULL),
(7, 113, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, 1, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, 1, 2, 1, '2025-05-31 14:09:34', NULL),
(8, 115, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, 2, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, 2, NULL, 2, NULL, 2, 3, 1, '2025-06-02 05:23:49', NULL),
(9, 116, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, 2, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, 2, NULL, 2, NULL, 2, 3, 1, '2025-06-02 05:42:59', NULL),
(10, 117, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, 2, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, 2, NULL, 2, NULL, 2, 3, 1, '2025-06-02 05:54:27', NULL),
(11, 118, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, 2, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, 2, NULL, 2, NULL, 2, 3, 1, '2025-06-02 06:00:05', NULL),
(12, 119, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, 2, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, 2, NULL, 2, NULL, 2, 3, 1, '2025-06-02 06:07:03', NULL),
(13, 120, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, 2, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, 2, NULL, 2, NULL, 2, 3, 1, '2025-06-02 06:09:54', NULL),
(14, 121, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, 2, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, 2, NULL, 2, NULL, 2, 3, 1, '2025-06-02 06:19:36', NULL),
(15, 122, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, 2, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, 2, NULL, 2, NULL, 2, 3, 1, '2025-06-02 06:21:23', NULL),
(16, 123, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, 2, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, 2, NULL, 2, NULL, 2, 2, 1, '2025-06-02 10:55:54', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `kyc_reject_reasons`
--

CREATE TABLE `kyc_reject_reasons` (
  `id` int NOT NULL,
  `kyc_id` int NOT NULL COMMENT 'kyc_leads.id',
  `reason` text COLLATE utf8mb4_general_ci,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `loans`
--

CREATE TABLE `loans` (
  `id` bigint UNSIGNED NOT NULL,
  `kyc_id` int NOT NULL COMMENT 'kyc_leads.id',
  `user_id` int DEFAULT NULL COMMENT 'users.id',
  `route_id` int DEFAULT NULL COMMENT 'route.id',
  `loan_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rate_of_interest` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `frequency` tinyint NOT NULL DEFAULT '3' COMMENT '1-Day,2-Weekly,3-Monthly,4-Yearly',
  `tenure` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `process_charge` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_charge` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `other_charges_1` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `other_charges_2` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `other_charges_3` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `other_charges_4` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `other_charges_5` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `disbrused_amount` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emi_amount` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `loan_start_date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pending_amount` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `loan_status` tinyint NOT NULL DEFAULT '1' COMMENT '1-Pending,2-Approvad but not disbursed,3-Disbursed,4-Reject,5-Closed',
  `status` tinyint NOT NULL DEFAULT '1' COMMENT '1-Active,2-InActive,3-Deleted,4-Permanent Deleted',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `loans`
--

INSERT INTO `loans` (`id`, `kyc_id`, `user_id`, `route_id`, `loan_number`, `amount`, `rate_of_interest`, `frequency`, `tenure`, `process_charge`, `file_charge`, `other_charges_1`, `other_charges_2`, `other_charges_3`, `other_charges_4`, `other_charges_5`, `disbrused_amount`, `emi_amount`, `loan_start_date`, `pending_amount`, `loan_status`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 1, '264784850942', '50000', '10', 1, '10', '10', '10', '10', '10', '10', '10', '10', '49940', '5,007.54', '2024-10-14', '50,075.40', 3, 1, '2024-10-14 05:17:35', '2024-10-14 05:17:35'),
(2, 1, 4, 1, '26771052699', '150000', '10', 2, '15', '5000', '1500', '2500', '3500', '1000', '500', '1500', '139500', '10,154.54', '2024-10-18', '152,318.10', 3, 1, '2024-10-15 12:12:07', '2024-10-15 12:12:07'),
(3, 7, 4, 7, '834722863097', '150000', '12', 3, '12', '1000', '100', '100', '100', '100', '100', '100', '149400', '13,327.32', '2024-09-01', '159,927.84', 3, 1, '2024-10-21 10:24:05', '2024-10-21 10:24:05'),
(4, 11, 4, 7, '7139577873', '150000', '12', 3, '12', '200', '200', '200', '200', '200', '200', '200', '148800', '13,327.32', '2024-11-01', '159,927.84', 3, 1, '2024-10-22 06:22:01', '2024-10-22 06:22:01'),
(5, 12, 4, 7, '290078504746', '150000', '12', 3, '12', '200', '200', '200', '200', '200', '200', '200', '148800', '13,327.32', '2024-10-22', '159,927.84', 2, 1, '2024-10-22 06:44:24', '2024-10-22 06:44:24'),
(6, 17, 2, 7, '552379870866', '100000', '12', 3, '12', '100', '100', '100', '100', '100', '100', '100', '99400', '8,884.88', '2024-11-01', '106,618.56', 2, 1, '2024-10-23 11:29:50', '2024-10-23 11:29:50'),
(7, 13, 4, 7, '899065274580', '150000', '12', 3, '12', '100', '100', '100', '100', '100', '100', '100', '149400', '13,327.32', '2024-11-01', '159,927.84', 2, 1, '2024-10-23 13:21:46', '2024-10-23 13:21:46');

-- --------------------------------------------------------

--
-- Table structure for table `loan_disbursements`
--

CREATE TABLE `loan_disbursements` (
  `id` bigint UNSIGNED NOT NULL,
  `loan_id` int NOT NULL,
  `disbursement_amount` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `disbursement_mode` int NOT NULL COMMENT 'payment_modes.id',
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `disbursement_date` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remark` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `loan_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `reference_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `disbrused_status` tinyint NOT NULL DEFAULT '1' COMMENT '1-Pending,2-Success'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `loan_disbursements`
--

INSERT INTO `loan_disbursements` (`id`, `loan_id`, `disbursement_amount`, `disbursement_mode`, `image`, `disbursement_date`, `remark`, `loan_number`, `reference_no`, `created_at`, `updated_at`, `disbrused_status`) VALUES
(2, 1, '139500', 1, '1728999785_1727348006_offline.jpg', '2024-10-15', 'business loan', '26771052699', NULL, '2024-10-15 13:11:46', '2024-10-15 14:00:01', 2),
(3, 2, '139500', 1, '1729056413_1727348006_offline.jpg', '2024-10-15', 'business loan', '26771052699', NULL, '2024-10-16 05:17:00', '2024-10-16 05:26:53', 2),
(4, 3, '149400', 1, '1729507105_12lDIFbQTiiEFj_KlUvRNg.jpeg', '2024-10-21', 'business loan', '834722863097', NULL, '2024-10-21 10:33:24', '2024-10-21 10:38:29', 2),
(5, 4, '149400', 1, '1729578346_app.jpg', '2024-10-22', 'business loan', '834722863097', NULL, '2024-10-22 06:24:47', '2024-10-22 06:31:54', 2);

-- --------------------------------------------------------

--
-- Table structure for table `loan_requests`
--

CREATE TABLE `loan_requests` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` int DEFAULT NULL COMMENT 'user.id',
  `service_no` int DEFAULT NULL COMMENT 'providers.route	',
  `lead_create_date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `work` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `work_address` text COLLATE utf8mb4_unicode_ci,
  `cheque` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shop_thiya` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `home_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `home_address` text COLLATE utf8mb4_unicode_ci,
  `file_hai` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `loan_amount` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tut` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `balance` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `plus_day` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `old_loan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `loan_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ser_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rn_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `accountant_sign` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `guarantor` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `guarantor_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `zip_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reason_of_loan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `referal_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `referal_mobile` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `token` text COLLATE utf8mb4_unicode_ci,
  `remark` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `loan_status` tinyint NOT NULL DEFAULT '1' COMMENT '1-pending,2-viewed,3-Under Discussion,4-pending for kyc,5-qualified,6-rejected',
  `status` tinyint NOT NULL DEFAULT '1' COMMENT '1-Active,2-InActive,3-Deleted,4-Permanent deleted',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `loan_requests`
--

INSERT INTO `loan_requests` (`id`, `user_id`, `service_no`, `lead_create_date`, `name`, `work`, `mobile`, `work_address`, `cheque`, `shop_thiya`, `home_type`, `home_address`, `file_hai`, `loan_amount`, `tut`, `balance`, `plus_day`, `old_loan`, `loan_type`, `file_no`, `ser_no`, `rn_no`, `amount`, `accountant_sign`, `guarantor`, `guarantor_name`, `address`, `zip_code`, `reason_of_loan`, `referal_name`, `referal_mobile`, `token`, `remark`, `loan_status`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 6, '2024-10-29', 'Ayush Gupta', 'test', '7428059960', '9/10 Shyam Nagar  Ambala Cantt', 'Y', 'RENTED', 'OWN', 'Mohali Punjab', 'Y', '50000', '1200', '1400', '120', '500', 'New', '120', '121', '122', '5410', '123456789', 'N', 'Amit', NULL, NULL, NULL, NULL, NULL, NULL, 'first lead', 3, 1, '2024-10-28 06:06:21', '2024-10-28 06:06:21');

-- --------------------------------------------------------

--
-- Table structure for table `location_data`
--

CREATE TABLE `location_data` (
  `id` int NOT NULL,
  `first_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `normalized_city` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `continent` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country_code` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `county` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `postcode` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `road` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `road_type` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state_code` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state_district` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `suburb` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` bigint UNSIGNED NOT NULL,
  `sender_id` bigint UNSIGNED NOT NULL,
  `receiver_id` bigint UNSIGNED NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` tinyint NOT NULL DEFAULT '1' COMMENT '1-Active,2-Inactive,3-Deleted'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `sender_id`, `receiver_id`, `message`, `is_read`, `created_at`, `updated_at`, `status`) VALUES
(1, 99, 100, 'Guyyuy', 0, '2025-05-29 09:38:20', '2025-05-29 09:38:20', 1),
(2, 100, 99, 'Sua', 0, '2025-05-29 09:38:34', '2025-05-29 09:38:34', 1),
(3, 100, 99, 'Sua', 0, '2025-05-29 09:38:35', '2025-05-29 09:38:35', 1),
(4, 100, 99, 'G t', 0, '2025-05-29 09:38:48', '2025-05-29 09:38:48', 1),
(5, 99, 100, 'Higdth', 0, '2025-05-29 09:38:55', '2025-05-29 09:38:55', 1),
(6, 99, 100, 'Bm cy', 0, '2025-05-29 09:39:00', '2025-05-29 09:39:00', 1),
(7, 99, 100, 'Vbbvb', 0, '2025-05-29 09:39:08', '2025-05-29 09:39:08', 1),
(8, 100, 99, 'jhn byy', 0, '2025-05-29 09:46:56', '2025-05-29 09:46:56', 1),
(9, 100, 99, 'ha bol fazlu', 0, '2025-05-29 09:47:55', '2025-05-29 09:47:55', 1),
(10, 106, 105, 'Hyyy', 0, '2025-05-30 06:35:04', '2025-05-30 06:35:04', 1),
(11, 106, 105, 'Hyyy', 0, '2025-05-30 06:35:04', '2025-05-30 06:35:04', 1),
(12, 105, 106, 'Hi', 0, '2025-05-30 06:36:07', '2025-05-30 06:36:07', 1),
(13, 105, 106, 'Hi', 0, '2025-05-30 06:36:08', '2025-05-30 06:36:08', 1),
(14, 105, 106, 'Ff', 0, '2025-05-30 06:37:52', '2025-05-30 06:37:52', 1),
(15, 106, 105, 'Vhcucci', 0, '2025-05-30 06:38:45', '2025-05-30 06:38:45', 1),
(16, 106, 105, 'Guh', 0, '2025-05-30 06:39:01', '2025-05-30 06:39:01', 1),
(17, 105, 106, 'Hkj', 0, '2025-05-30 06:41:35', '2025-05-30 06:41:35', 1),
(18, 105, 106, 'Xgxhhcxh', 0, '2025-05-30 06:41:50', '2025-05-30 06:41:50', 1),
(19, 105, 106, 'Xgxhhcxh', 0, '2025-05-30 06:41:51', '2025-05-30 06:41:51', 1),
(20, 105, 106, 'Gjjhc', 0, '2025-05-30 06:48:35', '2025-05-30 06:48:35', 1);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2014_10_12_100000_create_password_resets_table', 1),
(4, '2019_08_19_000000_create_failed_jobs_table', 1),
(5, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(6, '2024_10_01_093153_create_role_models_table', 1),
(7, '2024_10_01_093231_create_roles_table', 1),
(8, '2024_10_03_174248_create_loan_requests_table', 2),
(9, '2024_10_07_170956_create_loans_table', 3),
(10, '2024_10_15_133013_create_payment_modes_table', 4),
(11, '2024_10_15_145619_create_banks_table', 5),
(12, '2024_11_13_134153_create_refers_table', 6),
(13, '2024_11_25_110246_create_messages_table', 7);

-- --------------------------------------------------------

--
-- Table structure for table `notes`
--

CREATE TABLE `notes` (
  `id` int NOT NULL,
  `loan_request_id` int NOT NULL COMMENT 'loan_requests.id',
  `user_id` int NOT NULL COMMENT 'users.id\r\n',
  `loan_status` tinyint NOT NULL DEFAULT '1' COMMENT '	1-pending,2-viewed,3-Under Discussion,4-pending for kyc,5-qualified,6-rejected',
  `title` text COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` tinyint NOT NULL DEFAULT '1' COMMENT '1-Active,2-Inactive,3-Deleted,4-Permanent Delete'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notes`
--

INSERT INTO `notes` (`id`, `loan_request_id`, `user_id`, `loan_status`, `title`, `created_at`, `updated_at`, `status`) VALUES
(1, 1, 1, 1, 'Create Lead', '2024-10-14 05:14:48', '2024-10-14 05:14:48', 1),
(2, 1, 1, 2, 'View Lead', '2024-10-14 05:15:03', '2024-10-14 05:15:03', 1),
(3, 1, 1, 3, 'Under Disscussion', '2024-10-14 05:15:14', '2024-10-14 05:15:14', 1),
(4, 1, 1, 5, 'this lead qualified', '2024-10-14 05:15:30', '2024-10-14 05:15:30', 1),
(5, 2, 1, 1, 'Create Lead', '2024-10-15 07:05:40', '2024-10-15 07:05:40', 1),
(6, 2, 1, 2, 'View Lead', '2024-10-15 07:05:43', '2024-10-15 07:05:43', 1),
(7, 3, 2, 1, 'Create Lead', '2024-10-15 10:41:02', '2024-10-15 10:41:02', 1),
(8, 3, 1, 2, 'View Lead', '2024-10-15 10:41:11', '2024-10-15 10:41:11', 1),
(9, 3, 1, 3, 'Under Disscussion', '2024-10-15 10:41:17', '2024-10-15 10:41:17', 1),
(10, 3, 1, 5, 'Lead Qualfied', '2024-10-15 10:41:50', '2024-10-15 10:41:50', 1),
(11, 1, 2, 1, 'Create Lead', '2024-10-15 10:47:09', '2024-10-15 10:47:09', 1),
(12, 1, 1, 5, 'Lead Qualified', '2024-10-15 11:02:45', '2024-10-15 11:02:45', 1),
(13, 2, 2, 1, 'Create Lead', '2024-10-15 11:04:47', '2024-10-15 11:04:47', 1),
(14, 23, 1, 2, 'View Lead', '2024-10-18 07:42:00', '2024-10-18 07:42:00', 1),
(15, 23, 1, 3, 'Under Disscussion', '2024-10-18 07:42:03', '2024-10-18 07:42:03', 1),
(16, 35, 1, 2, 'View Lead', '2024-10-21 07:14:11', '2024-10-21 07:14:11', 1),
(17, 35, 1, 3, 'Under Disscussion', '2024-10-21 07:14:16', '2024-10-21 07:14:16', 1),
(18, 35, 1, 5, 'Done', '2024-10-21 07:14:25', '2024-10-21 07:14:25', 1),
(19, 34, 1, 2, 'View Lead', '2024-10-21 07:14:41', '2024-10-21 07:14:41', 1),
(20, 34, 1, 3, 'Under Disscussion', '2024-10-21 07:26:49', '2024-10-21 07:26:49', 1),
(21, 34, 1, 6, 'Wrong details', '2024-10-21 07:27:09', '2024-10-21 07:27:09', 1),
(22, 36, 1, 2, 'View Lead', '2024-10-21 07:51:48', '2024-10-21 07:51:48', 1),
(23, 36, 1, 3, 'Under Disscussion', '2024-10-21 07:52:16', '2024-10-21 07:52:16', 1),
(24, 36, 1, 5, 'Done', '2024-10-21 07:52:29', '2024-10-21 07:52:29', 1),
(25, 34, 1, 5, 'Check', '2024-10-21 09:42:51', '2024-10-21 09:42:51', 1),
(26, 37, 1, 2, 'View Lead', '2024-10-21 10:05:13', '2024-10-21 10:05:13', 1),
(27, 37, 1, 3, 'Under Disscussion', '2024-10-21 10:05:15', '2024-10-21 10:05:15', 1),
(28, 37, 1, 5, 'Done', '2024-10-21 10:05:23', '2024-10-21 10:05:23', 1),
(29, 38, 1, 2, 'View Lead', '2024-10-21 11:09:40', '2024-10-21 11:09:40', 1),
(30, 38, 1, 3, 'Under Disscussion', '2024-10-21 11:10:11', '2024-10-21 11:10:11', 1),
(31, 38, 1, 5, 'jjj', '2024-10-21 11:10:38', '2024-10-21 11:10:38', 1),
(32, 33, 1, 2, 'View Lead', '2024-10-21 12:00:36', '2024-10-21 12:00:36', 1),
(33, 33, 1, 3, 'Under Disscussion', '2024-10-21 12:00:45', '2024-10-21 12:00:45', 1),
(34, 33, 1, 3, 'Document Pending', '2024-10-21 12:01:06', '2024-10-21 12:01:06', 1),
(35, 33, 1, 5, 'Loan approved', '2024-10-21 12:01:53', '2024-10-21 12:01:53', 1),
(36, 39, 1, 2, 'View Lead', '2024-10-21 12:26:57', '2024-10-21 12:26:57', 1),
(37, 39, 1, 3, 'Under Disscussion', '2024-10-21 12:26:59', '2024-10-21 12:26:59', 1),
(38, 39, 1, 5, 'Done', '2024-10-21 12:27:05', '2024-10-21 12:27:05', 1),
(39, 41, 1, 2, 'View Lead', '2024-10-22 06:16:06', '2024-10-22 06:16:06', 1),
(40, 41, 1, 3, 'Under Disscussion', '2024-10-22 06:16:09', '2024-10-22 06:16:09', 1),
(41, 41, 1, 5, 'Done', '2024-10-22 06:16:16', '2024-10-22 06:16:16', 1),
(42, 42, 1, 2, 'View Lead', '2024-10-22 06:34:49', '2024-10-22 06:34:49', 1),
(43, 42, 1, 3, 'Under Disscussion', '2024-10-22 06:34:50', '2024-10-22 06:34:50', 1),
(44, 42, 1, 5, 'Done', '2024-10-22 06:34:56', '2024-10-22 06:34:56', 1),
(45, 44, 1, 2, 'View Lead', '2024-10-22 06:52:11', '2024-10-22 06:52:11', 1),
(46, 44, 1, 3, 'Under Disscussion', '2024-10-22 06:52:13', '2024-10-22 06:52:13', 1),
(47, 44, 1, 5, 'Done', '2024-10-22 06:52:18', '2024-10-22 06:52:18', 1),
(48, 45, 1, 2, 'View Lead', '2024-10-22 10:28:37', '2024-10-22 10:28:37', 1),
(49, 45, 1, 3, 'Under Disscussion', '2024-10-22 10:28:38', '2024-10-22 10:28:38', 1),
(50, 45, 1, 5, 'Done', '2024-10-22 10:28:44', '2024-10-22 10:28:44', 1),
(51, 46, 1, 2, 'View Lead', '2024-10-22 10:50:10', '2024-10-22 10:50:10', 1),
(52, 46, 1, 3, 'Under Disscussion', '2024-10-22 10:50:12', '2024-10-22 10:50:12', 1),
(53, 46, 1, 5, 'Done', '2024-10-22 10:50:17', '2024-10-22 10:50:17', 1),
(54, 47, 1, 2, 'View Lead', '2024-10-22 11:01:55', '2024-10-22 11:01:55', 1),
(55, 47, 1, 3, 'Under Disscussion', '2024-10-22 11:01:57', '2024-10-22 11:01:57', 1),
(56, 47, 1, 5, 'Done', '2024-10-22 11:02:03', '2024-10-22 11:02:03', 1),
(57, 48, 1, 2, 'View Lead', '2024-10-23 11:26:31', '2024-10-23 11:26:31', 1),
(58, 48, 1, 3, 'Under Disscussion', '2024-10-23 11:26:33', '2024-10-23 11:26:33', 1),
(59, 48, 1, 5, 'Done', '2024-10-23 11:26:38', '2024-10-23 11:26:38', 1),
(60, 49, 1, 2, 'View Lead', '2024-10-23 12:08:10', '2024-10-23 12:08:10', 1),
(61, 49, 1, 3, 'Under Disscussion', '2024-10-23 12:08:12', '2024-10-23 12:08:12', 1),
(62, 49, 1, 5, 'Done', '2024-10-23 12:08:20', '2024-10-23 12:08:20', 1),
(63, 1, 1, 1, 'Create Lead', '2024-10-28 06:06:21', '2024-10-28 06:06:21', 1),
(64, 1, 1, 5, '1', '2024-10-28 06:56:55', '2024-10-28 06:56:55', 1),
(65, 1, 1, 5, 'lead qualified', '2024-10-28 12:17:09', '2024-10-28 12:17:09', 1),
(66, 1, 1, 5, 'qualified', '2024-10-29 07:57:42', '2024-10-29 07:57:42', 1);

-- --------------------------------------------------------

--
-- Table structure for table `packages`
--

CREATE TABLE `packages` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `small_charge` int NOT NULL,
  `large_charge` int NOT NULL,
  `gaint_charge` int NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tax` int NOT NULL DEFAULT '0' COMMENT 'In percentage',
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `status` tinyint NOT NULL DEFAULT '1' COMMENT '1-Active,2-Inactive,3-Deleted,4-Permanent Deleted',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `packages`
--

INSERT INTO `packages` (`id`, `title`, `small_charge`, `large_charge`, `gaint_charge`, `image`, `tax`, `description`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Hic laborum Laborum', 100, 200, 200, 'hotel_images/26kiNofkdVxFZY84pPcKZ3BGJAUdjioamn0fvWoI.jpg', 10, '<p>Ducimus in iusto ni</p>', 1, '2025-02-07 09:36:33', '2025-02-28 12:39:54'),
(2, 'Velit possimus ame', 300, 600, 600, 'hotel_images/UHEmhxp4HtVn6BqyO5zbJu1Efj9PEQ4P1rHcsV7E.png', 20, '<p>Pet grooming is an essential practice for maintaining a pet&rsquo;s health and hygiene. It involves brushing, washing, and trimming fur to prevent mats, tangles, and skin issues. Regular grooming helps to remove dirt, dead hair, and parasites, contributing to a shiny coat and healthier skin. It also includes nail trimming, ear cleaning, and dental care to ensure overall well-being.</p>', 1, '2025-02-07 09:37:00', '2025-02-28 13:14:46'),
(3, 'test', 10, 10, 10, 'hotel_images/KTHVF81BJKkUdV3GED4PEImctHzT630A1pANexdq.png', 30, '<p>sdfsdfsdf</p>', 1, '2025-02-07 12:54:56', '2025-02-28 13:14:50');

-- --------------------------------------------------------

--
-- Table structure for table `packages_image`
--

CREATE TABLE `packages_image` (
  `id` int NOT NULL,
  `package_id` int NOT NULL COMMENT 'package.id',
  `image` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` tinyint NOT NULL DEFAULT '1' COMMENT '1-Active,2-Inactive,3-Deleted'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `packages_image`
--

INSERT INTO `packages_image` (`id`, `package_id`, `image`, `created_at`, `updated_at`, `status`) VALUES
(1, 1, 'hotel_images/q9d5OTucl6mghbyClsHtauwSEV7ZkQjRaFqHidfV.png', '2025-02-07 09:36:33', '2025-02-07 09:36:33', 1),
(2, 1, 'hotel_images/3Y7ML9tB32MyRFePEv43P7k9QQpxw7oePPUhhQC2.jpg', '2025-02-07 09:36:33', '2025-02-07 09:36:33', 1),
(3, 1, 'hotel_images/josVr2fg0uh6Et7MuA3PepdeIE3j0d1tkPNe9IwG.png', '2025-02-07 09:36:33', '2025-02-07 09:36:33', 1),
(4, 1, 'hotel_images/tafAZP034G1vrEXsFrmjFdFuKNOgbqReDCoodRcF.jpg', '2025-02-07 09:36:33', '2025-02-07 09:36:33', 3),
(5, 2, 'hotel_images/WTton2cuUveTkxLtGFHoTGXJIovrNHmGryWvlDHK.png', '2025-02-07 09:37:00', '2025-02-07 09:37:00', 3),
(6, 2, 'hotel_images/W06tnhDWv1P2grcsoGjuTt0xLLAL1dm9n2V4zO3G.jpg', '2025-02-07 09:37:00', '2025-02-07 09:37:00', 3),
(7, 2, 'hotel_images/lRmPJI7HE25HfC1waF2NhfKsCgzRts4b2ns6K1Xp.png', '2025-02-07 09:37:00', '2025-02-07 09:37:00', 3),
(8, 2, 'hotel_images/6OXv1WiuL8jSyAif0aFEIfLK1ItF7cPZYLeo25gD.jpg', '2025-02-07 09:37:00', '2025-02-07 09:37:00', 3),
(9, 2, 'hotel_images/xmuDY0ij3BKeCCuFvHfyQYPwjCnHxpPw6SsNoBL0.jpg', '2025-02-07 12:38:57', '2025-02-07 12:38:57', 3),
(10, 2, 'hotel_images/sseL7kfakAocxhJo1cyYfR4bJ6wK05QQOqf3eo0f.jpg', '2025-02-07 12:40:57', '2025-02-07 12:40:57', 1),
(11, 2, 'hotel_images/dUZluDrzkzA2xQfygNkSk3BiOSuPJwHt2PHLRRey.jpg', '2025-02-07 12:50:27', '2025-02-07 12:50:27', 1),
(12, 3, 'hotel_images/3WjXRHqOwrhu44z1zfSOdBIe1kDIlIFpbMV4EBdw.png', '2025-02-07 12:55:09', '2025-02-07 12:55:09', 1),
(13, 3, 'hotel_images/slN7e6Lomw1zkbnxbXZbsaHnVIKdVa72AizyYBC7.jpg', '2025-02-07 12:55:09', '2025-02-07 12:55:09', 1);

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` bigint UNSIGNED NOT NULL,
  `page_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `paragraph` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `page_name`, `title`, `paragraph`, `image`, `created_at`, `updated_at`) VALUES
(1, 'term_and_condition', 'Term & Conditions', '<p>Welcome to Royals Pets! By using our website or booking our services, you agree to the following terms and conditions. Please read them carefully.<br />\r\n<br />\r\n<strong>1. Services Offered</strong><br />\r\nRoyals Pets provides professional pet grooming services, including but not limited to bathing, haircutting, nail trimming, ear cleaning, and de-shedding treatments. Services are available at our premises or via mobile grooming (where available).<br />\r\n<br />\r\n<strong>2. Appointment and Cancellation Policy</strong><br />\r\n- Appointments must be scheduled in advance via our website, phone, or authorized partner apps.<br />\r\n- Cancellations must be made at least 24 hours in advance. Failure to cancel within this period may result in a cancellation fee.<br />\r\n- Late arrivals exceeding 15 minutes may result in appointment rescheduling.<br />\r\n<br />\r\n<strong>3. Health and Safety</strong><br />\r\n- Owners must disclose any known medical or behavioral conditions of their pet before services begin.<br />\r\n- Royals Pets reserves the right to refuse service to aggressive or severely ill pets.<br />\r\n- Vaccinations must be up to date. Proof of vaccination may be required prior to appointment.<br />\r\n<br />\r\n<strong>4. Grooming Risks</strong><br />\r\n- While we take utmost care, grooming may expose hidden medical conditions or cause minor nicks or irritation, especially in matted pets.<br />\r\n- The client agrees not to hold Royals Pets liable for any conditions or reactions arising during or after grooming.<br />\r\n<br />\r\n<strong>5. Pricing</strong><br />\r\n- All prices are subject to change and may vary depending on the size, breed, and condition of your pet.<br />\r\n- Additional charges may apply for de-matting, flea treatment, or special handling requirements.<br />\r\n<br />\r\n<strong>6. Payments</strong><br />\r\n- Payment is due at the time of service.<br />\r\n- We accept cash, UPI, debit/credit cards, and other payment methods listed on our website.<br />\r\n<br />\r\n<strong>7. Photography</strong><br />\r\n- With client consent, Royals Pets may photograph pets before and after grooming for promotional purposes on social media and our website.<br />\r\n<br />\r\n<strong>8. Liability</strong><br />\r\n- While our groomers are trained professionals, Royals Pets is not liable for any injury, loss, or death that may occur due to unforeseeable circumstances or pre-existing conditions.<br />\r\n<br />\r\n<strong>9. User Conduct on Website</strong><br />\r\n- You agree not to misuse the website by attempting unauthorized access, spreading malware, or submitting false information.<br />\r\n<br />\r\n<strong>10. Changes to Terms</strong><br />\r\n- Royals Pets reserves the right to modify these Terms and Conditions at any time. Changes will be posted on our website.<br />\r\n<br />\r\n<strong>11. Contact Us</strong><br />\r\nIf you have any questions regarding these Terms and Conditions, please contact us at: &nbsp;<br />\r\nEmail:&nbsp;<a href=\"mailto:royalspetsgroomer@gmail.com\" target=\"_blank\">royalspetsgroomer@gmail.com</a>&nbsp;&nbsp;<br />\r\nPhone: 7827787725 &nbsp;<br />\r\nWebsite:&nbsp;<a href=\"https://www.royalspets.in/\" target=\"_blank\">https://www.royalspets.in</a></p>', 'pages/cNY3IZLLHkyHZhy1WTwGEhmC5lpLxXTFilG4rHwk.png', '2024-12-02 08:24:31', '2025-04-17 14:12:39'),
(2, 'privacy_policy', 'Privacy Policy', '<p>At Royals Pets, accessible from&nbsp;<a href=\"http://royalspets.in/\" target=\"_blank\">royalspets</a>.in, we prioritize the privacy of our visitors. This Privacy Policy document outlines the types of personal information that is collected and recorded by Royals Pets and how we use it.<br />\r\n<br />\r\n<strong>1. Information We Collect</strong><br />\r\nWe may collect the following types of personal information when you visit or use our services on royalspets.in:<br />\r\n<br />\r\nPersonal Identification Information: This may include your name, email address, phone number, and other information you provide when booking our pet grooming services or contacting us.<br />\r\nUsage Data: We may collect information about how you interact with our website, such as IP address, browser type, device information, and the pages you visit.<br />\r\n<strong>2. How We Use Your Information</strong><br />\r\nThe information we collect is used to:<br />\r\n<br />\r\nProvide, operate, and maintain our pet grooming services.<br />\r\nImprove, personalize, and expand our website and services.<br />\r\nCommunicate with you, including responding to inquiries, sending promotional offers, and providing updates regarding services.<br />\r\nMonitor and analyze usage trends to improve user experience.<br />\r\n<strong>3. How We Protect Your Information</strong><br />\r\nWe take reasonable measures to protect your personal information from unauthorized access, alteration, or disclosure. We use industry-standard security protocols and encryption methods to safeguard your data.<br />\r\n<br />\r\n<strong>4. Sharing Your Information</strong><br />\r\nWe do not sell, trade, or rent your personal information to third parties. However, we may share your information with trusted service providers who assist us in operating our website or providing services to you, provided that they agree to keep your information confidential.<br />\r\n<br />\r\n<strong>5. Cookies and Tracking Technologies</strong><br />\r\nOur website uses cookies to enhance user experience. Cookies help us analyze web traffic, remember user preferences, and personalize content. You can control the use of cookies through your browser settings.<br />\r\n<br />\r\n<strong>6. Third-Party Links</strong><br />\r\nOur website may contain links to third-party websites. We are not responsible for the privacy practices or content of such websites. We encourage you to review the privacy policies of those third parties.<br />\r\n<br />\r\n<strong>7. Your Rights and Choices</strong><br />\r\nYou have the right to:<br />\r\n<br />\r\nAccess and update your personal information.<br />\r\nRequest the deletion of your personal data.<br />\r\nOpt-out of receiving marketing communications from us.<br />\r\nTo exercise these rights, please contact us at [Insert contact email].<br />\r\n<br />\r\n<strong>8. Changes to This Privacy Policy</strong><br />\r\nWe may update this Privacy Policy from time to time. Any changes will be posted on this page, and the updated date will be indicated at the top of the policy. We encourage you to review this policy periodically for any updates.<br />\r\n<br />\r\n<strong>9. Contact Us</strong><br />\r\nIf you have any questions about this Privacy Policy or need further information, feel free to contact us at:<br />\r\n<br />\r\nEmail:&nbsp;<a href=\"mailto:royalspetsgroomer@gmail.com\" target=\"_blank\">royalspetsgroomer@gmail.com</a><br />\r\nPhone:&nbsp;<a href=\"tel:+917827787725\">7827787725</a><br />\r\nWebsite:&nbsp;<a href=\"http://royalspets.in/\" target=\"_blank\">royalspets.in</a></p>', 'pages/pdBQ1gffHzXYERyWua4lWEGUjxaTtjN1LlwxDf5F.png', '2024-12-02 08:24:41', '2025-04-17 14:22:13'),
(3, 'about_us', 'About Us', '<p>Welcome to Royal&#39;s Pets, your trusted partner in premium pet grooming services. At Royal&#39;s Pets, we believe every pet deserves royal treatment &mdash; and that&rsquo;s exactly what we deliver.<br />\r\n<br />\r\nOur mission is to provide top-quality grooming in a stress-free, loving environment. Whether it&rsquo;s a refreshing bath, a stylish haircut, or a full grooming package, we ensure your furry friend looks and feels their absolute best.<br />\r\n<br />\r\nWhy Choose Us?<br />\r\n- Experienced and compassionate groomers<br />\r\n- Safe and hygienic grooming tools<br />\r\n- Personalized care for each pet<br />\r\n- Convenient and affordable services<br />\r\n<br />\r\nWe treat your pets like royalty &mdash; because they deserve nothing less.<br />\r\n<br />\r\nContact Us: &nbsp;<br />\r\nPhone: 7827787725 &nbsp;<br />\r\nWebsite:&nbsp;<a href=\"http://www.royalspets.in/\" target=\"_blank\">www.royalspets.in</a></p>', 'pages/pdBQ1gffHzXYERyWua4lWEGUjxaTtjN1LlwxDf5F.png', '2024-12-02 08:24:41', '2025-04-21 06:17:31'),
(4, 'return_and_refund', 'Return & Refund', '<p><strong>Refund and Cancellation Policy</strong></p>\r\n\r\n<p>At&nbsp;<strong>Royals Pets</strong>, we strive to provide the highest quality pet grooming services and ensure customer satisfaction. We understand that sometimes plans change, and we aim to accommodate your needs as best as possible. Please read our Refund and Cancellation Policy carefully.</p>\r\n\r\n<p><strong>1. Appointment Cancellation</strong></p>\r\n\r\n<ul>\r\n	<li><strong>Customer-Initiated Cancellations</strong></li>\r\n	<li>You may cancel or reschedule your grooming appointment up to&nbsp;<strong>24 hours in advance</strong>&nbsp;at no extra charge.</li>\r\n	<li>Cancellations made&nbsp;<strong>less than 24 hours before the appointment</strong>&nbsp;will be subject to a&nbsp;<strong>cancellation fee of 30%</strong>&nbsp;of the service amount.</li>\r\n	<li><strong>No-Shows</strong></li>\r\n	<li>If you miss your appointment without prior notice, you will be charged&nbsp;<strong>50% of the total service cost</strong>.</li>\r\n</ul>\r\n\r\n<h3><strong>2. Company-Initiated Cancellations</strong></h3>\r\n\r\n<p>In rare cases where&nbsp;<strong>Royals Pets</strong>&nbsp;needs to cancel or reschedule an appointment due to unforeseen circumstances (e.g., staff unavailability, emergencies), you will be notified as soon as possible, and a full refund will be provided if a new appointment cannot be arranged.</p>\r\n\r\n<h3><strong>3. Refund Policy</strong></h3>\r\n\r\n<ul>\r\n	<li><strong>Unsatisfactory Service</strong><br />\r\n	If you are not satisfied with our service, please contact us within&nbsp;<strong>24 hours</strong>&nbsp;of your appointment. We will evaluate the situation and may offer a&nbsp;<strong>partial or full refund</strong>, a free follow-up session, or service credit based on the case.</li>\r\n	<li><strong>Prepaid Appointments</strong><br />\r\n	If you cancel an appointment with&nbsp;<strong>24 hours&rsquo; notice</strong>, a&nbsp;<strong>full refund</strong>&nbsp;will be issued to your original payment method.</li>\r\n	<li><strong>Packages and Subscriptions</strong><br />\r\n	Refunds for unused portions of grooming packages or subscriptions will be considered on a&nbsp;<strong>pro-rated basis</strong>, minus any discounts applied.</li>\r\n</ul>\r\n\r\n<h3><strong>Need Help?</strong><br />\r\nFor any questions regarding your booking or our policies, please contact us at:<br />\r\n<strong>Phone:</strong>&nbsp;+91 7827787725<br />\r\n<strong>Email:</strong>&nbsp;<a href=\"mailto:royalspetsgroomer@gmail.com\" target=\"_blank\">royalspetsgroomer@gmail.com</a></h3>\r\n\r\n<p>&nbsp;</p>', 'pages/pdBQ1gffHzXYERyWua4lWEGUjxaTtjN1LlwxDf5F.png', '2024-12-02 08:24:41', '2025-04-21 06:38:30');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment_modes`
--

CREATE TABLE `payment_modes` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint NOT NULL DEFAULT '1' COMMENT '1-Active,2-Deactive,3-delete,4-Permanent Deleted',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payment_modes`
--

INSERT INTO `payment_modes` (`id`, `title`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Cash', 1, '2024-10-15 08:17:17', '2024-10-15 08:17:17'),
(2, 'UPI', 1, '2024-10-15 08:17:56', '2024-10-15 08:17:56'),
(3, 'Bank Transfer', 1, '2024-10-15 08:18:22', '2024-10-15 08:18:22'),
(4, 'Cheque', 1, '2024-10-15 08:18:31', '2024-10-15 12:55:21');

-- --------------------------------------------------------

--
-- Table structure for table `payment_out`
--

CREATE TABLE `payment_out` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` int NOT NULL,
  `booking_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `method` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL,
  `currency` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'INR',
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `response` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payment_out`
--

INSERT INTO `payment_out` (`id`, `user_id`, `booking_id`, `payment_id`, `order_id`, `method`, `amount`, `currency`, `status`, `response`, `created_at`, `updated_at`) VALUES
(1, 106, '1', 'pay_Qb2NOkcXiqaeOB', 'order_Qb2NFiFHMrKoME', 'netbanking', 200.00, 'INR', 'captured', '{}', '2025-05-30 06:13:31', '2025-05-30 06:13:31');

-- --------------------------------------------------------

--
-- Table structure for table `payment_transactions`
--

CREATE TABLE `payment_transactions` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `booking_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `method` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL,
  `currency` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'INR',
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `response` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payment_transactions`
--

INSERT INTO `payment_transactions` (`id`, `user_id`, `booking_id`, `payment_id`, `order_id`, `method`, `amount`, `currency`, `status`, `response`, `created_at`, `updated_at`) VALUES
(1, '105', NULL, 'pay_Qb2NOkcXiqaeOB', 'order_Qb2NFiFHMrKoME', 'netbanking', 220.00, 'INR', 'captured', '{}', '2025-05-30 06:13:31', '2025-05-30 06:13:31'),
(3, '107', NULL, 'pay_QbQJRpS7oGjLqw', 'order_QbQJHBLmenNTgU', 'upi', 720.00, 'INR', 'captured', '{}', '2025-05-31 05:38:44', '2025-05-31 05:38:44'),
(4, '107', NULL, 'pay_QbQRCzcAI2IXFp', 'order_QbQQuKQQ7PFoQv', 'upi', 110.00, 'INR', 'captured', '{}', '2025-05-31 05:45:57', '2025-05-31 05:45:57'),
(5, '107', NULL, 'pay_QbQW8up8VPAyr8', 'order_QbQW0OHORdDxhu', 'upi', 220.00, 'INR', 'captured', '{}', '2025-05-31 05:50:37', '2025-05-31 05:50:37'),
(6, '107', NULL, 'pay_QbQfdeHcyXU6FY', 'order_QbQfXDgU7n1hO2', 'upi', 110.00, 'INR', 'captured', '{}', '2025-05-31 05:59:36', '2025-05-31 05:59:36'),
(7, '105', NULL, 'pay_QbSG9KnbhtHqDf', 'order_QbSFtAWp0jOIIh', 'netbanking', 720.00, 'INR', 'captured', '{}', '2025-05-31 07:32:44', '2025-05-31 07:32:44');

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint NOT NULL DEFAULT '1' COMMENT '1-Active,2-Inactive,3-Deleted',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `title`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Create User', 1, '2024-10-03 10:26:18', '2024-10-03 10:26:21'),
(2, 'Edit User', 1, '2024-10-03 10:26:18', '2024-10-03 10:26:21'),
(3, 'Create Lead', 1, '2024-10-03 10:26:18', '2024-10-03 10:26:21'),
(4, 'Create Lead', 1, '2024-10-03 10:26:18', '2024-10-03 10:26:21'),
(5, 'Create Lead', 1, '2024-10-03 10:26:18', '2024-10-03 10:26:21'),
(6, 'Create Lead', 1, '2024-10-03 10:26:18', '2024-10-03 10:26:21'),
(7, 'Create Lead', 1, '2024-10-03 10:26:18', '2024-10-03 10:26:21'),
(8, 'Create Lead', 1, '2024-10-03 10:26:18', '2024-10-03 10:26:21'),
(9, 'Create Lead', 1, '2024-10-03 10:26:18', '2024-10-03 10:26:21'),
(10, 'Create Lead', 1, '2024-10-03 10:26:18', '2024-10-03 10:26:21'),
(11, 'Create Lead', 1, '2024-10-03 10:26:18', '2024-10-03 10:26:21'),
(12, 'Create Lead', 1, '2024-10-03 10:26:18', '2024-10-03 10:26:21'),
(13, 'Create Lead', 1, '2024-10-03 10:26:18', '2024-10-03 10:26:21'),
(14, 'Create Lead', 1, '2024-10-03 10:26:18', '2024-10-03 10:26:21'),
(15, 'Create Lead', 1, '2024-10-03 10:26:18', '2024-10-03 10:26:21'),
(16, 'Create Lead', 1, '2024-10-03 10:26:18', '2024-10-03 10:26:21'),
(17, 'Create Lead', 1, '2024-10-03 10:26:18', '2024-10-03 10:26:21'),
(18, 'Create Lead', 1, '2024-10-03 10:26:18', '2024-10-03 10:26:21'),
(19, 'Create Lead', 1, '2024-10-03 10:26:18', '2024-10-03 10:26:21'),
(20, 'Create Lead', 1, '2024-10-03 10:26:18', '2024-10-03 10:26:21'),
(21, 'Create Lead', 1, '2024-10-03 10:26:18', '2024-10-03 10:26:21'),
(22, 'Create Lead', 1, '2024-10-03 10:26:18', '2024-10-03 10:26:21'),
(23, 'Create Lead', 1, '2024-10-03 10:26:18', '2024-10-03 10:26:21');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pet_category`
--

CREATE TABLE `pet_category` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` int DEFAULT NULL COMMENT 'users.id',
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pet_size` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pet_bred` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint NOT NULL DEFAULT '1' COMMENT '1-Active,2-Inactive,3-Deleted,4-Permanent Deleted',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pet_category`
--

INSERT INTO `pet_category` (`id`, `user_id`, `title`, `image`, `pet_size`, `pet_bred`, `status`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Dogs', 'pet_category/z0mWcpbhoCMacGbHUN9G5v5gCxh6ZrZFSUe9mvss.jpg', NULL, NULL, 1, '2024-11-11 01:05:24', '2025-05-30 11:27:21'),
(2, NULL, 'Birds', 'pet_category/dOKkP6VYB81HUk5Dgl1xzwG8ORMsFLZzMXXEbZ5s.jpg', NULL, NULL, 1, '2024-11-11 01:11:31', '2024-11-11 01:11:31'),
(3, NULL, 'Rabbit', 'pet_category/S9bYjljKopPPHyokmGD4kxuTWOFEbeuXOTaFafTT.jpg', NULL, NULL, 1, '2024-11-11 01:12:08', '2024-11-11 01:12:08'),
(4, NULL, 'Cats', 'pet_category/XZwJH4VVef6tUNk9CQd7I80h0NOqKYWgd7f6JmVa.jpg', NULL, NULL, 3, '2024-11-11 01:13:49', '2024-11-21 00:58:35'),
(6, 1, 'Dogs', 'pet_category/wPjc2iMPzxo9G84DERbfyF7HmBGr35yqdsQhECec.jpg', 'XD', 'SMALL', 3, '2024-11-20 05:48:03', '2025-02-05 07:03:45'),
(8, 1, 'Dogss', 'pet_category/7MrSFpM8QJauabEIBncPVU4gv4SxJs8BE0sjl8lW.jpg', 'XD', 'SMALL', 3, '2024-11-21 00:46:31', '2025-02-05 07:03:38');

-- --------------------------------------------------------

--
-- Table structure for table `referral_code`
--

CREATE TABLE `referral_code` (
  `id` int NOT NULL,
  `user_id` int NOT NULL COMMENT 'users.id',
  `user_type` tinyint NOT NULL COMMENT '1-Groomer,2-Customer',
  `code` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `status` tinyint NOT NULL DEFAULT '1' COMMENT '1-Active,2-Inactive',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `referral_code`
--

INSERT INTO `referral_code` (`id`, `user_id`, `user_type`, `code`, `status`, `created_at`) VALUES
(1, 16, 2, '166734A27A163EE', 1, '2024-11-13 12:58:34'),
(2, 16, 2, '1667358F9C817F2', 1, '2024-11-14 05:50:20'),
(3, 19, 2, '196735E63A7D0BE', 1, '2024-11-14 11:59:54'),
(4, 44, 2, '4467B43D511195A', 1, '2025-02-18 07:57:05');

-- --------------------------------------------------------

--
-- Table structure for table `refers`
--

CREATE TABLE `refers` (
  `id` bigint UNSIGNED NOT NULL,
  `coupon_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code_type` tinyint NOT NULL DEFAULT '1' COMMENT '1-Flat,2-Percent',
  `value` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_coupon_reused` tinyint NOT NULL DEFAULT '2' COMMENT '1-Yes,3-No',
  `expiry_date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint NOT NULL DEFAULT '1' COMMENT '1-Active,2-InActive,3-Deleted',
  `is_used_coupon` tinyint NOT NULL DEFAULT '2' COMMENT '1-Used,2-Unused',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `refers`
--

INSERT INTO `refers` (`id`, `coupon_code`, `code_type`, `value`, `is_coupon_reused`, `expiry_date`, `status`, `is_used_coupon`, `created_at`, `updated_at`) VALUES
(1, '881662', 1, '100', 2, NULL, 1, 2, '2024-11-13 09:51:27', '2024-11-13 10:00:27'),
(2, '9106212746069058', 1, '100', 1, '2024-11-23', 1, 2, '2024-11-13 10:05:42', '2024-11-13 10:05:42'),
(3, '8888038184290259', 1, '100', 2, NULL, 1, 2, '2024-11-13 10:07:34', '2024-11-13 10:07:34'),
(4, '4454917451421989', 1, '100', 2, NULL, 1, 2, '2024-11-21 10:21:09', '2024-11-21 10:21:09');

-- --------------------------------------------------------

--
-- Table structure for table `refer_and_earn`
--

CREATE TABLE `refer_and_earn` (
  `id` int NOT NULL,
  `user_type` int NOT NULL COMMENT '1-Gromer Helper,2-Customer',
  `is_on` tinyint NOT NULL DEFAULT '2' COMMENT '1-Active,2-Inactive',
  `is_profit` tinyint NOT NULL DEFAULT '2' COMMENT '1-Active,2-Inactive',
  `billing_no` int DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `refer_and_earn`
--

INSERT INTO `refer_and_earn` (`id`, `user_type`, `is_on`, `is_profit`, `billing_no`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 10, '2024-11-13 10:28:54', NULL),
(2, 2, 1, 1, 50, '2024-11-13 10:28:54', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint NOT NULL DEFAULT '1' COMMENT '1-Active,2-Inactive,3-Deleted',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `title`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 1, '2024-10-11 13:49:34', '2024-10-11 13:49:34'),
(2, 'Employee', 1, '2024-10-11 13:49:34', '2024-11-08 13:27:56'),
(3, 'Groomer', 1, '2024-10-11 13:49:34', '2024-11-08 13:27:58'),
(4, 'Groomer-Helper', 1, '2024-10-11 13:49:34', '2024-11-08 13:27:57'),
(5, 'Customer', 1, '2024-11-13 05:42:08', '2024-11-13 05:42:08');

-- --------------------------------------------------------

--
-- Table structure for table `role_models`
--

CREATE TABLE `role_models` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `role_permission`
--

CREATE TABLE `role_permission` (
  `id` int NOT NULL,
  `role_id` int NOT NULL COMMENT 'roles.id',
  `permission_id` int DEFAULT NULL COMMENT 'permission.id',
  `permission_status` tinyint NOT NULL DEFAULT '2' COMMENT '1-True,2-False',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` tinyint NOT NULL DEFAULT '1' COMMENT '1-Active,2-Inactive,3-Deleted'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `role_permission`
--

INSERT INTO `role_permission` (`id`, `role_id`, `permission_id`, `permission_status`, `created_at`, `status`) VALUES
(1, 4, 1, 1, '2024-10-03 12:43:37', 1),
(2, 4, 2, 1, '2024-10-03 12:43:37', 1),
(3, 4, 3, 1, '2024-10-03 12:43:37', 1),
(4, 4, 4, 1, '2024-10-03 12:43:37', 1),
(5, 4, 5, 1, '2024-10-03 12:43:37', 1),
(6, 4, 6, 1, '2024-10-03 12:43:37', 1),
(7, 4, 7, 1, '2024-10-03 12:43:37', 1),
(8, 4, 8, 1, '2024-10-03 12:43:37', 1),
(9, 4, 9, 1, '2024-10-03 12:43:37', 1),
(10, 4, 10, 1, '2024-10-03 12:43:37', 1),
(11, 4, 11, 1, '2024-10-03 12:43:37', 1),
(12, 4, 12, 1, '2024-10-03 12:43:37', 1),
(13, 4, 13, 1, '2024-10-03 12:43:37', 1),
(14, 4, 14, 1, '2024-10-03 12:43:37', 1),
(15, 4, 15, 1, '2024-10-03 12:43:37', 1),
(16, 4, 16, 1, '2024-10-03 12:43:37', 1),
(17, 4, 17, 1, '2024-10-03 12:43:37', 1),
(18, 4, 18, 1, '2024-10-03 12:43:37', 1),
(19, 4, 19, 1, '2024-10-03 12:43:37', 1),
(20, 4, 20, 2, '2024-10-03 12:43:37', 1),
(21, 4, 21, 1, '2024-10-03 12:43:37', 1),
(22, 4, 22, 1, '2024-10-03 12:43:37', 1),
(23, 4, 23, 1, '2024-10-03 12:43:37', 1),
(24, 3, 1, 1, '2024-11-25 05:11:39', 1),
(25, 3, 2, 1, '2024-11-25 05:11:39', 1),
(26, 3, 3, 1, '2024-11-25 05:11:39', 1),
(27, 3, 4, 1, '2024-11-25 05:11:39', 1),
(28, 3, 5, 1, '2024-11-25 05:11:39', 1),
(29, 3, 6, 1, '2024-11-25 05:11:39', 1),
(30, 3, 7, 1, '2024-11-25 05:11:39', 1),
(31, 3, 8, 1, '2024-11-25 05:11:39', 1),
(32, 3, 9, 1, '2024-11-25 05:11:39', 1),
(33, 3, 10, 1, '2024-11-25 05:11:39', 1),
(34, 3, 11, 1, '2024-11-25 05:11:39', 1),
(35, 3, 12, 1, '2024-11-25 05:11:39', 1),
(36, 3, 13, 1, '2024-11-25 05:11:39', 1),
(37, 3, 14, 1, '2024-11-25 05:11:39', 1),
(38, 3, 15, 1, '2024-11-25 05:11:39', 1),
(39, 3, 16, 1, '2024-11-25 05:11:39', 1),
(40, 3, 17, 1, '2024-11-25 05:11:39', 1),
(41, 3, 18, 1, '2024-11-25 05:11:39', 1),
(42, 3, 19, 1, '2024-11-25 05:11:39', 1),
(43, 3, 20, 1, '2024-11-25 05:11:39', 1),
(44, 3, 21, 1, '2024-11-25 05:11:39', 1),
(45, 3, 22, 1, '2024-11-25 05:11:39', 1),
(46, 3, 23, 1, '2024-11-25 05:11:39', 1),
(47, 5, 1, 1, '2024-11-25 05:11:53', 1),
(48, 5, 2, 1, '2024-11-25 05:11:53', 1),
(49, 5, 3, 1, '2024-11-25 05:11:53', 1),
(50, 5, 4, 1, '2024-11-25 05:11:53', 1),
(51, 5, 5, 1, '2024-11-25 05:11:53', 1),
(52, 5, 6, 1, '2024-11-25 05:11:53', 1),
(53, 5, 7, 1, '2024-11-25 05:11:53', 1),
(54, 5, 8, 1, '2024-11-25 05:11:53', 1),
(55, 5, 9, 1, '2024-11-25 05:11:53', 1),
(56, 5, 10, 1, '2024-11-25 05:11:53', 1),
(57, 5, 11, 1, '2024-11-25 05:11:53', 1),
(58, 5, 12, 1, '2024-11-25 05:11:53', 1),
(59, 5, 13, 1, '2024-11-25 05:11:53', 1),
(60, 5, 14, 1, '2024-11-25 05:11:53', 1),
(61, 5, 15, 1, '2024-11-25 05:11:53', 1),
(62, 5, 16, 2, '2024-11-25 05:11:53', 1),
(63, 5, 17, 1, '2024-11-25 05:11:53', 1),
(64, 5, 18, 1, '2024-11-25 05:11:53', 1),
(65, 5, 19, 1, '2024-11-25 05:11:53', 1),
(66, 5, 20, 2, '2024-11-25 05:11:53', 1),
(67, 5, 21, 1, '2024-11-25 05:11:53', 1),
(68, 5, 22, 1, '2024-11-25 05:11:53', 1),
(69, 5, 23, 1, '2024-11-25 05:11:53', 1);

-- --------------------------------------------------------

--
-- Table structure for table `route_logs`
--

CREATE TABLE `route_logs` (
  `id` bigint UNSIGNED NOT NULL,
  `route_assign_id` int NOT NULL COMMENT 'assignroutes.id',
  `user_id` int NOT NULL COMMENT 'users.id',
  `route_id` int NOT NULL COMMENT 'routes.id',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint DEFAULT '1' COMMENT '1-Active,2-Inactive,3-Delete,4-Permanent Delete'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `route_logs`
--

INSERT INTO `route_logs` (`id`, `route_assign_id`, `user_id`, `route_id`, `created_at`, `updated_at`, `status`) VALUES
(1, 1, 2, 1, '2024-10-29 07:07:20', '2024-10-29 12:40:14', 1),
(2, 2, 6, 1, '2024-10-29 07:07:24', '2024-10-29 12:40:10', 1),
(3, 3, 9, 1, '2024-10-29 07:07:27', '2024-10-29 12:38:02', 1),
(4, 4, 9, 1, '2024-10-29 07:08:15', '2024-10-29 12:38:29', 1),
(5, 5, 2, 1, '2024-10-29 07:11:11', '2024-10-29 13:09:23', 1),
(6, 6, 2, 1, '2024-10-29 09:35:02', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `service_charge` int NOT NULL,
  `status` tinyint NOT NULL DEFAULT '1' COMMENT '1-Active,2-Inactive,3-Deleted,4-Permanent Deleted',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `title`, `service_charge`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Pat Service', 300, 1, '2024-11-11 07:26:12', '2024-11-11 07:26:12'),
(2, 'Dogs Service', 300, 1, '2024-11-11 07:26:12', '2024-11-13 06:59:04'),
(4, 'Pat Service', 300, 1, '2024-11-11 07:26:12', '2024-11-11 07:26:12'),
(5, 'Dogs Service', 300, 1, '2024-11-11 07:26:12', '2024-11-13 06:59:04'),
(6, 'Pat Service', 300, 1, '2024-11-11 07:26:12', '2024-11-11 07:26:12'),
(7, 'Dogs Service', 300, 1, '2024-11-11 07:26:12', '2024-11-13 06:59:04'),
(8, 'Pat Service', 300, 1, '2024-11-11 07:26:12', '2024-11-11 07:26:12'),
(9, 'Dogs Service', 300, 1, '2024-11-11 07:26:12', '2024-11-13 06:59:04'),
(10, 'Pat Service', 300, 1, '2024-11-11 07:26:12', '2024-11-11 07:26:12'),
(11, 'Dogs Service', 300, 1, '2024-11-11 07:26:12', '2024-11-13 06:59:04'),
(12, 'Pat Service', 300, 1, '2024-11-11 07:26:12', '2024-11-11 07:26:12'),
(13, 'Dogs Service', 300, 1, '2024-11-11 07:26:12', '2024-11-13 06:59:04'),
(14, 'Pat Service', 300, 1, '2024-11-11 07:26:12', '2024-11-11 07:26:12'),
(15, 'Dogs Service', 300, 1, '2024-11-11 07:26:12', '2024-11-13 06:59:04'),
(16, 'Pat Service', 300, 1, '2024-11-11 07:26:12', '2024-11-11 07:26:12'),
(17, 'Dogs Service', 300, 1, '2024-11-11 07:26:12', '2024-11-13 06:59:04'),
(18, 'Pat Service', 300, 1, '2024-11-11 07:26:12', '2024-11-11 07:26:12'),
(19, 'Dosgs Service', 5555, 1, '2024-11-11 07:26:12', '2024-11-19 08:16:42'),
(20, 'Pat Service', 300, 1, '2024-11-11 07:26:12', '2024-11-11 07:26:12'),
(21, 'Dogs Service', 300, 1, '2024-11-11 07:26:12', '2024-11-13 06:59:04');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_address`
--

CREATE TABLE `tbl_address` (
  `id` int NOT NULL,
  `user_id` int NOT NULL COMMENT 'users.id',
  `flat_house_no` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `area_sector_locality` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `city_district` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `state` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `pincode` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `complete_address` text COLLATE utf8mb4_general_ci NOT NULL,
  `email_address` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` tinyint NOT NULL DEFAULT '1' COMMENT '1-Active,2-Inactive,3-Deleted'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_address`
--

INSERT INTO `tbl_address` (`id`, `user_id`, `flat_house_no`, `area_sector_locality`, `city_district`, `state`, `pincode`, `complete_address`, `email_address`, `created_at`, `updated_at`, `status`) VALUES
(1, 105, 'House no.76', 'Dayalpur', 'Delhi', 'Delhi', '110096', 'Delhi', 'fajlurehman588@gmail.com', '2025-05-30 06:12:59', '2025-05-30 06:12:59', 1),
(2, 107, 'Erwftsfff', 'De2fy3ed', 'Noida', 'Up', '845451', 'Gautam Budh nagar', '19cs65l@lingayasvidyapeeth.edu.in', '2025-05-31 05:35:59', '2025-05-31 05:35:59', 1),
(3, 124, 'Guddu pg', 'Wajidpur', 'Noida', 'Uttar Pradesh', '201306', 'Noida', 'shivam520p@gmail.com', '2025-06-02 11:44:36', '2025-06-02 11:44:36', 1),
(4, 125, '251', 'Mahala maholla madanpur khader', 'Sarita Vihar', 'New Delhi', '110076', 'Delhi', 'mynameisvijay0@gmail.com', '2025-06-03 09:12:18', '2025-06-03 09:12:18', 1),
(5, 125, '251', 'Mahala maholla madanpur khader', 'Sarita Vihar', 'New Delhi', '110076', 'Delhi', 'mynameisvijay0@gmail.com', '2025-06-03 09:12:19', '2025-06-03 09:12:19', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_booking_log`
--

CREATE TABLE `tbl_booking_log` (
  `id` int NOT NULL,
  `user_id` int NOT NULL COMMENT 'users.id',
  `booking_id` int NOT NULL COMMENT 'tbl_pet_bookings.id',
  `type` int NOT NULL DEFAULT '0' COMMENT '1-Cancel,2-Process',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` tinyint NOT NULL DEFAULT '1' COMMENT '1-Active,2-Inactive,3-Deleted'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_booking_log`
--

INSERT INTO `tbl_booking_log` (`id`, `user_id`, `booking_id`, `type`, `created_at`, `status`) VALUES
(1, 106, 1, 2, '2025-05-30 06:30:26', 1),
(2, 106, 1, 2, '2025-05-30 06:30:28', 1),
(3, 106, 1, 2, '2025-05-30 06:31:21', 1),
(4, 106, 2, 2, '2025-05-31 05:42:32', 1),
(5, 106, 3, 2, '2025-05-31 05:46:46', 1),
(6, 106, 4, 2, '2025-05-31 05:51:43', 1),
(7, 106, 5, 2, '2025-05-31 06:00:04', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_cart`
--

CREATE TABLE `tbl_cart` (
  `id` int NOT NULL,
  `user_id` int NOT NULL COMMENT 'users.id',
  `service_id` int NOT NULL,
  `charge` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` tinyint NOT NULL DEFAULT '1' COMMENT '1-Active,2-Inactive,3-Deleted'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_cart`
--

INSERT INTO `tbl_cart` (`id`, `user_id`, `service_id`, `charge`, `created_at`, `updated_at`, `status`) VALUES
(10, 124, 3, 'gaint_charge', '2025-06-03 07:14:13', '2025-06-03 07:14:13', 3),
(15, 125, 2, 'gaint_charge', '2025-06-10 15:20:05', '2025-06-10 15:20:05', 3);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_helpers`
--

CREATE TABLE `tbl_helpers` (
  `id` int NOT NULL,
  `user_id` int NOT NULL COMMENT 'users.id',
  `name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `mobile` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `dob` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `gender` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `age` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_general_ci,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` tinyint NOT NULL DEFAULT '1' COMMENT '1-Active,2-Inactive,3-Deleted'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_logs`
--

CREATE TABLE `tbl_logs` (
  `id` int NOT NULL,
  `user_id` int DEFAULT NULL COMMENT 'users.id',
  `subject` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `data` text COLLATE utf8mb4_general_ci NOT NULL,
  `url` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `method` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `ip_address` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` int NOT NULL COMMENT '1-Active,2-DeActive,3-Deleted,4-Permanent Deleted'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_notification`
--

CREATE TABLE `tbl_notification` (
  `id` int NOT NULL,
  `booking_id` int NOT NULL COMMENT 'tbl_pet_bookings.id',
  `user_id` int NOT NULL COMMENT 'users.id',
  `type` int NOT NULL COMMENT '1-buy package,2-Accept booking , 3-cancel booking,4-complete booking,5-new notification groomer',
  `subject` text COLLATE utf8mb4_general_ci,
  `description` text COLLATE utf8mb4_general_ci,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` tinyint NOT NULL DEFAULT '1' COMMENT '1-Active,2-Inactive,3-Deleted'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_notification`
--

INSERT INTO `tbl_notification` (`id`, `booking_id`, `user_id`, `type`, `subject`, `description`, `created_at`, `updated_at`, `status`) VALUES
(1, 1, 105, 1, 'Hic laborum Laborum', 'New Booking Created', '2025-05-30 06:13:32', '2025-05-30 06:13:32', 1),
(2, 1, 106, 5, 'Hic laborum Laborum', 'New booking found for Hic laborum Laborum', '2025-05-30 06:13:32', '2025-05-30 06:13:32', 1),
(3, 1, 106, 2, 'Hic laborum Laborum', 'Booking accept booking', '2025-05-30 06:30:26', '2025-05-30 06:30:26', 1),
(4, 1, 106, 2, 'Hic laborum Laborum', 'Booking accept booking', '2025-05-30 06:30:28', '2025-05-30 06:30:28', 1),
(5, 1, 105, 5, 'Hic laborum Laborum', 'Your booking has been accept booking by Sarthak pathak', '2025-05-30 06:30:29', '2025-05-30 06:30:29', 1),
(6, 1, 106, 4, 'Hic laborum Laborum', 'Booking complete booking', '2025-05-30 06:31:21', '2025-05-30 06:31:21', 1),
(7, 1, 105, 5, 'Hic laborum Laborum', 'Your booking has been complete booking by Sarthak pathak', '2025-05-30 06:31:22', '2025-05-30 06:31:22', 1),
(8, 2, 107, 1, 'Velit possimus ame', 'New Booking Created', '2025-05-31 05:38:45', '2025-05-31 05:38:45', 1),
(9, 2, 106, 5, 'Velit possimus ame', 'New booking found for Velit possimus ame', '2025-05-31 05:38:45', '2025-05-31 05:38:45', 1),
(10, 2, 106, 2, 'Velit possimus ame', 'Booking accept booking', '2025-05-31 05:42:32', '2025-05-31 05:42:32', 1),
(11, 3, 107, 1, 'Hic laborum Laborum', 'New Booking Created', '2025-05-31 05:45:57', '2025-05-31 05:45:57', 1),
(12, 3, 106, 5, 'Hic laborum Laborum', 'New booking found for Hic laborum Laborum', '2025-05-31 05:45:58', '2025-05-31 05:45:58', 1),
(13, 3, 106, 2, 'Hic laborum Laborum', 'Booking accept booking', '2025-05-31 05:46:46', '2025-05-31 05:46:46', 1),
(14, 4, 107, 1, 'Hic laborum Laborum', 'New Booking Created', '2025-05-31 05:50:37', '2025-05-31 05:50:37', 1),
(15, 4, 106, 5, 'Hic laborum Laborum', 'New booking found for Hic laborum Laborum', '2025-05-31 05:50:38', '2025-05-31 05:50:38', 1),
(16, 4, 106, 2, 'Hic laborum Laborum', 'Booking accept booking', '2025-05-31 05:51:43', '2025-05-31 05:51:43', 1),
(17, 5, 107, 1, 'Hic laborum Laborum', 'New Booking Created', '2025-05-31 05:59:37', '2025-05-31 05:59:37', 1),
(18, 5, 106, 5, 'Hic laborum Laborum', 'New booking found for Hic laborum Laborum', '2025-05-31 05:59:37', '2025-05-31 05:59:37', 1),
(19, 5, 106, 2, 'Hic laborum Laborum', 'Booking accept booking', '2025-05-31 06:00:04', '2025-05-31 06:00:04', 1),
(20, 6, 105, 1, 'Velit possimus ame', 'New Booking Created', '2025-05-31 07:32:45', '2025-05-31 07:32:45', 1),
(21, 6, 106, 5, 'Velit possimus ame', 'New booking found for Velit possimus ame', '2025-05-31 07:32:45', '2025-05-31 07:32:45', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_otp`
--

CREATE TABLE `tbl_otp` (
  `id` int NOT NULL,
  `user_id` int NOT NULL COMMENT 'user.id',
  `otp` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `status` int NOT NULL DEFAULT '1' COMMENT '1-Active,2-Expired',
  `module_type` tinyint NOT NULL DEFAULT '1' COMMENT '1-Login,2-UpdateEmail or mobile of users,3-user location',
  `otp_type` tinyint NOT NULL DEFAULT '1' COMMENT '1-Mobile, 2-Email',
  `field_value` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_otp`
--

INSERT INTO `tbl_otp` (`id`, `user_id`, `otp`, `status`, `module_type`, `otp_type`, `field_value`, `created_at`, `updated_at`) VALUES
(1, 105, '7612', 2, 1, 1, NULL, '2025-05-30 06:03:27', '2025-05-30 06:03:27'),
(2, 106, '1357', 2, 1, 1, NULL, '2025-05-30 06:03:41', '2025-05-30 06:03:41'),
(3, 106, '5322', 2, 1, 1, NULL, '2025-05-30 06:10:54', '2025-05-30 06:10:54'),
(4, 106, '2762', 2, 1, 1, NULL, '2025-05-30 06:30:44', '2025-05-30 06:30:44'),
(5, 106, '8366', 2, 1, 1, NULL, '2025-05-30 06:50:02', '2025-05-30 06:50:02'),
(6, 106, '1769', 2, 1, 1, NULL, '2025-05-30 07:14:48', '2025-05-30 07:14:48'),
(7, 106, '1317', 2, 1, 1, NULL, '2025-05-30 07:44:32', '2025-05-30 07:44:32'),
(8, 106, '8642', 2, 1, 1, NULL, '2025-05-30 07:56:17', '2025-05-30 07:56:17'),
(9, 106, '2244', 2, 1, 1, NULL, '2025-05-30 08:26:05', '2025-05-30 08:26:05'),
(10, 106, '4088', 2, 1, 1, NULL, '2025-05-30 08:27:17', '2025-05-30 08:27:17'),
(11, 106, '4471', 2, 1, 1, NULL, '2025-05-30 08:30:16', '2025-05-30 08:30:16'),
(12, 106, '7369', 2, 1, 1, NULL, '2025-05-30 08:31:00', '2025-05-30 08:31:00'),
(13, 105, '5072', 2, 1, 1, NULL, '2025-05-30 09:32:33', '2025-05-30 09:32:33'),
(14, 105, '2202', 2, 1, 1, NULL, '2025-05-30 09:34:14', '2025-05-30 09:34:14'),
(15, 106, '3977', 2, 1, 1, NULL, '2025-05-30 10:03:53', '2025-05-30 10:03:53'),
(16, 106, '2810', 2, 1, 1, NULL, '2025-05-30 10:08:11', '2025-05-30 10:08:11'),
(17, 106, '8190', 2, 1, 1, NULL, '2025-05-30 10:10:48', '2025-05-30 10:10:48'),
(18, 107, '8144', 2, 1, 1, NULL, '2025-05-31 05:34:39', '2025-05-31 05:34:39'),
(19, 105, '5427', 2, 1, 1, NULL, '2025-05-31 07:30:36', '2025-05-31 07:30:36'),
(20, 105, '1234', 2, 1, 1, NULL, '2025-05-31 10:29:00', '2025-05-31 10:29:00'),
(21, 106, '1234', 2, 1, 1, NULL, '2025-05-31 13:06:06', '2025-05-31 13:06:06'),
(22, 108, '1234', 2, 1, 1, NULL, '2025-05-31 13:49:14', '2025-05-31 13:49:14'),
(23, 109, '1234', 2, 1, 1, NULL, '2025-05-31 13:52:12', '2025-05-31 13:52:12'),
(24, 110, '1234', 2, 1, 1, NULL, '2025-05-31 14:00:36', '2025-05-31 14:00:36'),
(25, 111, '1234', 2, 1, 1, NULL, '2025-05-31 14:06:31', '2025-05-31 14:06:31'),
(26, 112, '1234', 2, 1, 1, NULL, '2025-05-31 14:08:39', '2025-05-31 14:08:39'),
(27, 113, '1234', 2, 1, 1, NULL, '2025-05-31 14:09:30', '2025-05-31 14:09:30'),
(28, 113, '1234', 2, 1, 1, NULL, '2025-06-02 04:58:35', '2025-06-02 04:58:35'),
(29, 113, '1234', 2, 1, 1, NULL, '2025-06-02 05:20:52', '2025-06-02 05:20:52'),
(30, 115, '1234', 2, 1, 1, NULL, '2025-06-02 05:23:41', '2025-06-02 05:23:41'),
(31, 116, '1234', 2, 1, 1, NULL, '2025-06-02 05:42:53', '2025-06-02 05:42:53'),
(32, 117, '1234', 2, 1, 1, NULL, '2025-06-02 05:54:23', '2025-06-02 05:54:23'),
(33, 118, '1234', 2, 1, 1, NULL, '2025-06-02 06:00:01', '2025-06-02 06:00:01'),
(34, 119, '1234', 2, 1, 1, NULL, '2025-06-02 06:06:56', '2025-06-02 06:06:56'),
(35, 120, '1234', 2, 1, 1, NULL, '2025-06-02 06:09:51', '2025-06-02 06:09:51'),
(36, 121, '1234', 2, 1, 1, NULL, '2025-06-02 06:19:31', '2025-06-02 06:19:31'),
(37, 122, '1234', 2, 1, 1, NULL, '2025-06-02 06:21:16', '2025-06-02 06:21:16'),
(38, 123, '1234', 2, 1, 1, NULL, '2025-06-02 10:55:47', '2025-06-02 10:55:47'),
(39, 123, '1234', 2, 1, 1, NULL, '2025-06-02 10:59:05', '2025-06-02 10:59:05'),
(40, 124, '2784', 2, 1, 1, NULL, '2025-06-02 11:42:28', '2025-06-02 11:42:28'),
(41, 105, '1234', 2, 1, 1, NULL, '2025-06-02 17:10:09', '2025-06-02 17:10:09'),
(42, 105, '1234', 2, 1, 1, NULL, '2025-06-02 17:10:22', '2025-06-02 17:10:22'),
(43, 124, '6946', 2, 1, 1, NULL, '2025-06-03 07:13:16', '2025-06-03 07:13:16'),
(44, 125, '3891', 2, 1, 1, NULL, '2025-06-03 09:02:40', '2025-06-03 09:02:40'),
(45, 123, '1234', 2, 1, 1, NULL, '2025-06-03 09:10:46', '2025-06-03 09:10:46'),
(46, 124, '7862', 1, 1, 1, NULL, '2025-06-03 15:29:23', '2025-06-03 15:29:23'),
(47, 124, '4634', 1, 1, 1, NULL, '2025-06-03 15:29:31', '2025-06-03 15:29:31'),
(48, 124, '9576', 1, 1, 1, NULL, '2025-06-03 15:29:44', '2025-06-03 15:29:44'),
(49, 124, '6895', 1, 1, 1, NULL, '2025-06-03 15:30:57', '2025-06-03 15:30:57'),
(50, 124, '8981', 1, 1, 1, NULL, '2025-06-03 15:31:04', '2025-06-03 15:31:04'),
(51, 124, '9836', 1, 1, 1, NULL, '2025-06-03 15:31:11', '2025-06-03 15:31:11'),
(52, 124, '3466', 1, 1, 1, NULL, '2025-06-03 15:31:19', '2025-06-03 15:31:19'),
(53, 124, '6350', 1, 1, 1, NULL, '2025-06-03 15:31:26', '2025-06-03 15:31:26'),
(54, 124, '1512', 1, 1, 1, NULL, '2025-06-03 15:31:34', '2025-06-03 15:31:34'),
(55, 124, '9969', 1, 1, 1, NULL, '2025-06-03 15:31:42', '2025-06-03 15:31:42'),
(56, 124, '5453', 1, 1, 1, NULL, '2025-06-03 15:31:49', '2025-06-03 15:31:49'),
(57, 124, '8279', 1, 1, 1, NULL, '2025-06-03 15:31:58', '2025-06-03 15:31:58'),
(58, 124, '6061', 1, 1, 1, NULL, '2025-06-03 15:32:06', '2025-06-03 15:32:06'),
(59, 124, '1796', 1, 1, 1, NULL, '2025-06-03 15:32:13', '2025-06-03 15:32:13'),
(60, 124, '5346', 1, 1, 1, NULL, '2025-06-03 15:32:20', '2025-06-03 15:32:20'),
(61, 124, '5544', 1, 1, 1, NULL, '2025-06-03 15:32:28', '2025-06-03 15:32:28'),
(62, 124, '6544', 1, 1, 1, NULL, '2025-06-03 15:32:36', '2025-06-03 15:32:36'),
(63, 124, '9901', 1, 1, 1, NULL, '2025-06-03 15:32:44', '2025-06-03 15:32:44'),
(64, 124, '2293', 1, 1, 1, NULL, '2025-06-03 15:32:51', '2025-06-03 15:32:51'),
(65, 124, '8751', 1, 1, 1, NULL, '2025-06-03 15:32:59', '2025-06-03 15:32:59'),
(66, 124, '2877', 1, 1, 1, NULL, '2025-06-03 15:33:07', '2025-06-03 15:33:07'),
(67, 124, '7887', 1, 1, 1, NULL, '2025-06-03 15:33:14', '2025-06-03 15:33:14'),
(68, 124, '8520', 1, 1, 1, NULL, '2025-06-03 15:33:22', '2025-06-03 15:33:22'),
(69, 124, '6281', 1, 1, 1, NULL, '2025-06-03 15:33:30', '2025-06-03 15:33:30'),
(70, 124, '4862', 1, 1, 1, NULL, '2025-06-03 15:33:37', '2025-06-03 15:33:37'),
(71, 124, '7078', 1, 1, 1, NULL, '2025-06-03 15:33:44', '2025-06-03 15:33:44'),
(72, 124, '6547', 1, 1, 1, NULL, '2025-06-03 15:33:52', '2025-06-03 15:33:52'),
(73, 125, '3561', 2, 1, 1, NULL, '2025-06-04 03:04:21', '2025-06-04 03:04:21'),
(74, 124, '7730', 1, 1, 1, NULL, '2025-06-07 10:09:47', '2025-06-07 10:09:47'),
(75, 124, '1816', 1, 1, 1, NULL, '2025-06-07 10:10:17', '2025-06-07 10:10:17'),
(76, 124, '3748', 1, 1, 1, NULL, '2025-06-07 10:10:29', '2025-06-07 10:10:29'),
(77, 124, '3968', 1, 1, 1, NULL, '2025-06-07 10:11:26', '2025-06-07 10:11:26'),
(78, 124, '3068', 1, 1, 1, NULL, '2025-06-08 10:22:19', '2025-06-08 10:22:19'),
(79, 124, '4648', 1, 1, 1, NULL, '2025-06-08 10:22:55', '2025-06-08 10:22:55'),
(80, 124, '2840', 1, 1, 1, NULL, '2025-06-08 10:23:16', '2025-06-08 10:23:16'),
(81, 125, '4843', 2, 1, 1, NULL, '2025-06-10 15:16:36', '2025-06-10 15:16:36'),
(82, 125, '6579', 2, 1, 1, NULL, '2025-06-10 15:17:12', '2025-06-10 15:17:12'),
(83, 124, '8276', 1, 1, 1, NULL, '2025-06-10 21:36:51', '2025-06-10 21:36:51'),
(84, 124, '6595', 1, 1, 1, NULL, '2025-06-10 21:37:10', '2025-06-10 21:37:10'),
(85, 124, '1434', 1, 1, 1, NULL, '2025-06-10 21:37:20', '2025-06-10 21:37:20'),
(86, 124, '9386', 1, 1, 1, NULL, '2025-06-10 21:38:24', '2025-06-10 21:38:24'),
(87, 124, '2021', 1, 1, 1, NULL, '2025-06-10 22:48:34', '2025-06-10 22:48:34'),
(88, 124, '4356', 1, 1, 1, NULL, '2025-06-10 22:48:59', '2025-06-10 22:48:59'),
(89, 124, '3567', 1, 1, 1, NULL, '2025-06-10 22:49:13', '2025-06-10 22:49:13'),
(90, 124, '2476', 1, 1, 1, NULL, '2025-06-10 22:50:55', '2025-06-10 22:50:55'),
(91, 124, '7490', 1, 1, 1, NULL, '2025-06-12 23:01:40', '2025-06-12 23:01:40'),
(92, 124, '7149', 1, 1, 1, NULL, '2025-06-12 23:02:02', '2025-06-12 23:02:02'),
(93, 124, '7134', 1, 1, 1, NULL, '2025-06-12 23:02:10', '2025-06-12 23:02:10'),
(94, 124, '5622', 1, 1, 1, NULL, '2025-06-12 23:03:31', '2025-06-12 23:03:31'),
(95, 126, '5240', 1, 1, 1, NULL, '2025-06-13 16:22:56', '2025-06-13 16:22:56'),
(96, 124, '7200', 1, 1, 1, NULL, '2025-06-15 06:41:19', '2025-06-15 06:41:19'),
(97, 124, '9921', 1, 1, 1, NULL, '2025-06-15 06:41:20', '2025-06-15 06:41:20'),
(98, 124, '2198', 1, 1, 1, NULL, '2025-06-15 06:41:45', '2025-06-15 06:41:45'),
(99, 124, '1978', 1, 1, 1, NULL, '2025-06-15 06:41:59', '2025-06-15 06:41:59'),
(100, 124, '5042', 1, 1, 1, NULL, '2025-06-15 06:42:13', '2025-06-15 06:42:13'),
(101, 124, '6474', 1, 1, 1, NULL, '2025-06-15 06:42:58', '2025-06-15 06:42:58'),
(102, 124, '8972', 1, 1, 1, NULL, '2025-06-15 06:43:13', '2025-06-15 06:43:13'),
(103, 124, '4710', 1, 1, 1, NULL, '2025-06-15 09:48:48', '2025-06-15 09:48:48'),
(104, 124, '8892', 1, 1, 1, NULL, '2025-06-15 09:49:34', '2025-06-15 09:49:34'),
(105, 124, '8524', 1, 1, 1, NULL, '2025-06-15 09:49:58', '2025-06-15 09:49:58'),
(106, 124, '8791', 1, 1, 1, NULL, '2025-06-15 09:50:29', '2025-06-15 09:50:29'),
(107, 124, '9147', 1, 1, 1, NULL, '2025-06-15 19:59:10', '2025-06-15 19:59:10'),
(108, 124, '8835', 1, 1, 1, NULL, '2025-06-15 19:59:31', '2025-06-15 19:59:31'),
(109, 124, '5179', 1, 1, 1, NULL, '2025-06-15 19:59:44', '2025-06-15 19:59:44'),
(110, 124, '9472', 1, 1, 1, NULL, '2025-06-15 20:00:31', '2025-06-15 20:00:31'),
(111, 124, '9972', 1, 1, 1, NULL, '2025-06-15 20:01:25', '2025-06-15 20:01:25'),
(112, 124, '2898', 1, 1, 1, NULL, '2025-06-16 03:04:01', '2025-06-16 03:04:01'),
(113, 124, '5597', 1, 1, 1, NULL, '2025-06-16 03:04:22', '2025-06-16 03:04:22'),
(114, 124, '2077', 1, 1, 1, NULL, '2025-06-16 03:04:43', '2025-06-16 03:04:43'),
(115, 124, '7042', 1, 1, 1, NULL, '2025-06-16 03:05:07', '2025-06-16 03:05:07'),
(116, 124, '7337', 1, 1, 1, NULL, '2025-06-17 18:08:53', '2025-06-17 18:08:53'),
(117, 124, '9249', 1, 1, 1, NULL, '2025-06-17 18:09:23', '2025-06-17 18:09:23'),
(118, 124, '6158', 1, 1, 1, NULL, '2025-06-17 18:09:37', '2025-06-17 18:09:37'),
(119, 124, '3514', 1, 1, 1, NULL, '2025-06-17 18:10:08', '2025-06-17 18:10:08'),
(120, 124, '5981', 1, 1, 1, NULL, '2025-06-24 13:59:36', '2025-06-24 13:59:36'),
(121, 124, '9550', 1, 1, 1, NULL, '2025-06-24 13:59:54', '2025-06-24 13:59:54'),
(122, 124, '6660', 1, 1, 1, NULL, '2025-06-24 14:00:02', '2025-06-24 14:00:02'),
(123, 124, '2385', 1, 1, 1, NULL, '2025-06-24 14:00:10', '2025-06-24 14:00:10'),
(124, 124, '5248', 1, 1, 1, NULL, '2025-06-24 14:01:27', '2025-06-24 14:01:27'),
(125, 124, '3233', 1, 1, 1, NULL, '2025-06-24 14:01:36', '2025-06-24 14:01:36'),
(126, 124, '8107', 1, 1, 1, NULL, '2025-06-24 14:02:21', '2025-06-24 14:02:21'),
(127, 124, '3107', 1, 1, 1, NULL, '2025-06-25 08:57:00', '2025-06-25 08:57:00'),
(128, 124, '6788', 1, 1, 1, NULL, '2025-06-25 08:57:28', '2025-06-25 08:57:28'),
(129, 124, '9316', 1, 1, 1, NULL, '2025-06-25 08:57:43', '2025-06-25 08:57:43'),
(130, 124, '1329', 1, 1, 1, NULL, '2025-06-25 08:58:31', '2025-06-25 08:58:31'),
(131, 124, '8580', 1, 1, 1, NULL, '2025-06-25 08:59:28', '2025-06-25 08:59:28'),
(132, 124, '5206', 1, 1, 1, NULL, '2025-06-25 22:00:53', '2025-06-25 22:00:53'),
(133, 124, '6328', 1, 1, 1, NULL, '2025-06-25 22:01:20', '2025-06-25 22:01:20'),
(134, 124, '9331', 1, 1, 1, NULL, '2025-06-25 22:01:37', '2025-06-25 22:01:37'),
(135, 124, '9060', 1, 1, 1, NULL, '2025-06-25 22:02:27', '2025-06-25 22:02:27'),
(136, 124, '7858', 1, 1, 1, NULL, '2025-06-26 20:59:11', '2025-06-26 20:59:11'),
(137, 124, '9826', 1, 1, 1, NULL, '2025-06-26 20:59:46', '2025-06-26 20:59:46'),
(138, 124, '2559', 1, 1, 1, NULL, '2025-06-26 21:00:15', '2025-06-26 21:00:15'),
(139, 124, '3814', 1, 1, 1, NULL, '2025-06-27 03:00:38', '2025-06-27 03:00:38'),
(140, 124, '2693', 1, 1, 1, NULL, '2025-06-27 03:01:02', '2025-06-27 03:01:02'),
(141, 124, '3002', 1, 1, 1, NULL, '2025-06-27 03:01:21', '2025-06-27 03:01:21'),
(142, 124, '1784', 1, 1, 1, NULL, '2025-06-27 03:02:36', '2025-06-27 03:02:36'),
(143, 124, '2227', 1, 1, 1, NULL, '2025-06-27 06:01:36', '2025-06-27 06:01:36'),
(144, 124, '4796', 1, 1, 1, NULL, '2025-06-27 06:01:56', '2025-06-27 06:01:56'),
(145, 124, '6950', 1, 1, 1, NULL, '2025-06-27 06:02:07', '2025-06-27 06:02:07'),
(146, 124, '1070', 1, 1, 1, NULL, '2025-06-27 06:03:33', '2025-06-27 06:03:33'),
(147, 124, '5151', 1, 1, 1, NULL, '2025-06-27 06:03:44', '2025-06-27 06:03:44'),
(148, 124, '2550', 1, 1, 1, NULL, '2025-06-28 01:00:23', '2025-06-28 01:00:23'),
(149, 124, '4136', 1, 1, 1, NULL, '2025-06-28 01:00:43', '2025-06-28 01:00:43'),
(150, 124, '9136', 1, 1, 1, NULL, '2025-06-28 01:00:52', '2025-06-28 01:00:52'),
(151, 124, '3757', 1, 1, 1, NULL, '2025-06-28 01:01:07', '2025-06-28 01:01:07'),
(152, 124, '3898', 1, 1, 1, NULL, '2025-06-28 01:02:22', '2025-06-28 01:02:22'),
(153, 124, '3334', 1, 1, 1, NULL, '2025-06-28 01:02:30', '2025-06-28 01:02:30'),
(154, 124, '1276', 1, 1, 1, NULL, '2025-06-28 14:01:20', '2025-06-28 14:01:20'),
(155, 124, '2422', 1, 1, 1, NULL, '2025-06-28 14:01:45', '2025-06-28 14:01:45'),
(156, 124, '3135', 1, 1, 1, NULL, '2025-06-28 14:01:58', '2025-06-28 14:01:58'),
(157, 124, '7913', 1, 1, 1, NULL, '2025-06-28 14:02:11', '2025-06-28 14:02:11'),
(158, 124, '6276', 1, 1, 1, NULL, '2025-06-28 14:03:43', '2025-06-28 14:03:43'),
(159, 124, '2545', 1, 1, 1, NULL, '2025-06-28 14:03:56', '2025-06-28 14:03:56'),
(160, 124, '6439', 1, 1, 1, NULL, '2025-06-30 23:03:35', '2025-06-30 23:03:35'),
(161, 124, '7917', 1, 1, 1, NULL, '2025-06-30 23:04:03', '2025-06-30 23:04:03'),
(162, 124, '8901', 1, 1, 1, NULL, '2025-06-30 23:04:19', '2025-06-30 23:04:19'),
(163, 124, '9105', 1, 1, 1, NULL, '2025-06-30 23:05:51', '2025-06-30 23:05:51'),
(164, 124, '7123', 1, 1, 1, NULL, '2025-06-30 23:06:02', '2025-06-30 23:06:02'),
(165, 124, '4646', 1, 1, 1, NULL, '2025-06-30 23:06:16', '2025-06-30 23:06:16'),
(166, 124, '9542', 1, 1, 1, NULL, '2025-07-01 14:02:34', '2025-07-01 14:02:34'),
(167, 124, '5195', 1, 1, 1, NULL, '2025-07-01 14:02:54', '2025-07-01 14:02:54'),
(168, 124, '4960', 1, 1, 1, NULL, '2025-07-01 14:03:04', '2025-07-01 14:03:04'),
(169, 124, '3459', 1, 1, 1, NULL, '2025-07-01 14:03:13', '2025-07-01 14:03:13'),
(170, 124, '5794', 1, 1, 1, NULL, '2025-07-01 14:04:44', '2025-07-01 14:04:44'),
(171, 124, '6158', 1, 1, 1, NULL, '2025-07-01 22:06:09', '2025-07-01 22:06:09'),
(172, 124, '9619', 1, 1, 1, NULL, '2025-07-01 22:06:44', '2025-07-01 22:06:44'),
(173, 124, '5675', 1, 1, 1, NULL, '2025-07-01 22:07:06', '2025-07-01 22:07:06'),
(174, 124, '1803', 1, 1, 1, NULL, '2025-07-01 22:07:23', '2025-07-01 22:07:23'),
(175, 124, '3051', 1, 1, 1, NULL, '2025-07-02 03:08:41', '2025-07-02 03:08:41'),
(176, 124, '6175', 1, 1, 1, NULL, '2025-07-02 03:09:16', '2025-07-02 03:09:16'),
(177, 124, '9349', 1, 1, 1, NULL, '2025-07-02 03:09:37', '2025-07-02 03:09:37'),
(178, 124, '6375', 1, 1, 1, NULL, '2025-07-02 03:10:20', '2025-07-02 03:10:20'),
(179, 124, '4731', 1, 1, 1, NULL, '2025-07-03 04:57:13', '2025-07-03 04:57:13'),
(180, 124, '1156', 1, 1, 1, NULL, '2025-07-03 04:57:37', '2025-07-03 04:57:37'),
(181, 124, '1984', 1, 1, 1, NULL, '2025-07-03 04:57:47', '2025-07-03 04:57:47'),
(182, 124, '8531', 1, 1, 1, NULL, '2025-07-03 04:58:27', '2025-07-03 04:58:27'),
(183, 124, '7844', 1, 1, 1, NULL, '2025-07-03 04:59:23', '2025-07-03 04:59:23'),
(184, 124, '8224', 1, 1, 1, NULL, '2025-07-03 10:59:38', '2025-07-03 10:59:38'),
(185, 124, '1332', 1, 1, 1, NULL, '2025-07-03 10:59:57', '2025-07-03 10:59:57'),
(186, 124, '2115', 1, 1, 1, NULL, '2025-07-03 11:00:07', '2025-07-03 11:00:07'),
(187, 124, '2961', 1, 1, 1, NULL, '2025-07-03 11:01:27', '2025-07-03 11:01:27'),
(188, 124, '4194', 1, 1, 1, NULL, '2025-07-03 11:01:36', '2025-07-03 11:01:36'),
(189, 124, '8492', 1, 1, 1, NULL, '2025-07-03 11:02:20', '2025-07-03 11:02:20'),
(190, 124, '7799', 1, 1, 1, NULL, '2025-07-04 06:58:42', '2025-07-04 06:58:42'),
(191, 124, '4495', 1, 1, 1, NULL, '2025-07-04 06:59:01', '2025-07-04 06:59:01'),
(192, 124, '9464', 1, 1, 1, NULL, '2025-07-04 06:59:09', '2025-07-04 06:59:09'),
(193, 124, '1250', 1, 1, 1, NULL, '2025-07-04 07:00:33', '2025-07-04 07:00:33'),
(194, 124, '1513', 1, 1, 1, NULL, '2025-07-04 07:00:43', '2025-07-04 07:00:43'),
(195, 124, '5936', 1, 1, 1, NULL, '2025-07-04 07:01:22', '2025-07-04 07:01:22'),
(196, 124, '1274', 1, 1, 1, NULL, '2025-07-04 07:01:31', '2025-07-04 07:01:31'),
(197, 124, '3836', 1, 1, 1, NULL, '2025-07-04 13:16:31', '2025-07-04 13:16:31'),
(198, 124, '1733', 1, 1, 1, NULL, '2025-07-04 13:16:56', '2025-07-04 13:16:56'),
(199, 124, '7008', 1, 1, 1, NULL, '2025-07-04 13:17:06', '2025-07-04 13:17:06'),
(200, 124, '5084', 1, 1, 1, NULL, '2025-07-04 13:18:34', '2025-07-04 13:18:34'),
(201, 124, '3543', 1, 1, 1, NULL, '2025-07-04 13:18:44', '2025-07-04 13:18:44'),
(202, 124, '5042', 1, 1, 1, NULL, '2025-07-04 13:19:06', '2025-07-04 13:19:06'),
(203, 105, '1234', 2, 1, 1, NULL, '2025-07-05 07:34:13', '2025-07-05 07:34:13'),
(204, 124, '8541', 1, 1, 1, NULL, '2025-07-05 10:47:24', '2025-07-05 10:47:24'),
(205, 124, '4363', 1, 1, 1, NULL, '2025-07-05 10:47:26', '2025-07-05 10:47:26'),
(206, 124, '3211', 1, 1, 1, NULL, '2025-07-05 10:47:43', '2025-07-05 10:47:43'),
(207, 124, '8853', 1, 1, 1, NULL, '2025-07-05 10:47:44', '2025-07-05 10:47:44'),
(208, 124, '1710', 1, 1, 1, NULL, '2025-07-05 10:47:50', '2025-07-05 10:47:50'),
(209, 124, '4876', 1, 1, 1, NULL, '2025-07-05 10:47:51', '2025-07-05 10:47:51'),
(210, 124, '9076', 1, 1, 1, NULL, '2025-07-05 10:48:04', '2025-07-05 10:48:04'),
(211, 124, '1025', 1, 1, 1, NULL, '2025-07-05 10:48:04', '2025-07-05 10:48:04'),
(212, 124, '9951', 1, 1, 1, NULL, '2025-07-05 10:48:31', '2025-07-05 10:48:31'),
(213, 124, '4759', 1, 1, 1, NULL, '2025-07-05 10:49:17', '2025-07-05 10:49:17'),
(214, 124, '3737', 1, 1, 1, NULL, '2025-07-05 10:49:19', '2025-07-05 10:49:19'),
(215, 124, '1231', 1, 1, 1, NULL, '2025-07-05 10:49:26', '2025-07-05 10:49:26'),
(216, 124, '3847', 1, 1, 1, NULL, '2025-07-05 10:49:29', '2025-07-05 10:49:29'),
(217, 124, '3682', 1, 1, 1, NULL, '2025-07-05 10:49:50', '2025-07-05 10:49:50'),
(218, 124, '3418', 1, 1, 1, NULL, '2025-07-05 10:50:14', '2025-07-05 10:50:14'),
(219, 124, '3061', 1, 1, 1, NULL, '2025-07-05 10:50:25', '2025-07-05 10:50:25'),
(220, 124, '6940', 1, 1, 1, NULL, '2025-07-06 01:56:19', '2025-07-06 01:56:19'),
(221, 124, '3265', 1, 1, 1, NULL, '2025-07-06 01:56:43', '2025-07-06 01:56:43'),
(222, 124, '1609', 1, 1, 1, NULL, '2025-07-06 01:56:53', '2025-07-06 01:56:53'),
(223, 124, '2998', 1, 1, 1, NULL, '2025-07-06 01:57:15', '2025-07-06 01:57:15'),
(224, 124, '6576', 1, 1, 1, NULL, '2025-07-06 01:58:45', '2025-07-06 01:58:45'),
(225, 124, '9232', 1, 1, 1, NULL, '2025-07-06 01:58:57', '2025-07-06 01:58:57'),
(226, 124, '6274', 1, 1, 1, NULL, '2025-07-06 01:59:15', '2025-07-06 01:59:15'),
(227, 124, '5695', 1, 1, 1, NULL, '2025-07-06 12:43:22', '2025-07-06 12:43:22'),
(228, 124, '3589', 1, 1, 1, NULL, '2025-07-06 12:43:45', '2025-07-06 12:43:45'),
(229, 124, '5050', 1, 1, 1, NULL, '2025-07-06 12:43:55', '2025-07-06 12:43:55'),
(230, 124, '1103', 1, 1, 1, NULL, '2025-07-06 12:44:09', '2025-07-06 12:44:09'),
(231, 124, '7592', 1, 1, 1, NULL, '2025-07-06 12:45:33', '2025-07-06 12:45:33'),
(232, 124, '5448', 1, 1, 1, NULL, '2025-07-07 04:59:53', '2025-07-07 04:59:53'),
(233, 124, '3247', 1, 1, 1, NULL, '2025-07-07 05:00:14', '2025-07-07 05:00:14'),
(234, 124, '5632', 1, 1, 1, NULL, '2025-07-07 05:00:23', '2025-07-07 05:00:23'),
(235, 124, '3030', 1, 1, 1, NULL, '2025-07-07 05:01:22', '2025-07-07 05:01:22'),
(236, 124, '6960', 1, 1, 1, NULL, '2025-07-07 05:01:32', '2025-07-07 05:01:32'),
(237, 124, '1841', 1, 1, 1, NULL, '2025-07-09 07:59:45', '2025-07-09 07:59:45'),
(238, 124, '2641', 1, 1, 1, NULL, '2025-07-09 08:00:07', '2025-07-09 08:00:07'),
(239, 124, '9016', 1, 1, 1, NULL, '2025-07-09 08:00:17', '2025-07-09 08:00:17'),
(240, 124, '6337', 1, 1, 1, NULL, '2025-07-09 08:01:35', '2025-07-09 08:01:35'),
(241, 124, '9506', 1, 1, 1, NULL, '2025-07-09 08:01:49', '2025-07-09 08:01:49'),
(242, 124, '4467', 1, 1, 1, NULL, '2025-07-09 08:02:15', '2025-07-09 08:02:15'),
(243, 124, '4589', 1, 1, 1, NULL, '2025-07-09 15:02:17', '2025-07-09 15:02:17'),
(244, 124, '7924', 1, 1, 1, NULL, '2025-07-09 15:02:40', '2025-07-09 15:02:40'),
(245, 124, '9353', 1, 1, 1, NULL, '2025-07-09 15:02:50', '2025-07-09 15:02:50'),
(246, 124, '2268', 1, 1, 1, NULL, '2025-07-09 15:03:04', '2025-07-09 15:03:04'),
(247, 124, '6340', 1, 1, 1, NULL, '2025-07-09 15:04:31', '2025-07-09 15:04:31'),
(248, 124, '1612', 1, 1, 1, NULL, '2025-07-09 15:04:45', '2025-07-09 15:04:45'),
(249, 124, '9058', 1, 1, 1, NULL, '2025-07-09 17:59:04', '2025-07-09 17:59:04'),
(250, 124, '9224', 1, 1, 1, NULL, '2025-07-09 17:59:27', '2025-07-09 17:59:27'),
(251, 124, '9900', 1, 1, 1, NULL, '2025-07-09 17:59:37', '2025-07-09 17:59:37'),
(252, 124, '1733', 1, 1, 1, NULL, '2025-07-09 18:00:28', '2025-07-09 18:00:28'),
(253, 124, '8188', 1, 1, 1, NULL, '2025-07-09 18:01:18', '2025-07-09 18:01:18'),
(254, 124, '6255', 1, 1, 1, NULL, '2025-07-09 19:06:21', '2025-07-09 19:06:21'),
(255, 124, '4461', 1, 1, 1, NULL, '2025-07-09 19:06:48', '2025-07-09 19:06:48'),
(256, 124, '9262', 1, 1, 1, NULL, '2025-07-09 19:06:56', '2025-07-09 19:06:56'),
(257, 124, '5327', 1, 1, 1, NULL, '2025-07-09 19:07:18', '2025-07-09 19:07:18'),
(258, 124, '6739', 1, 1, 1, NULL, '2025-07-09 19:08:06', '2025-07-09 19:08:06'),
(259, 124, '1124', 1, 1, 1, NULL, '2025-07-09 19:08:23', '2025-07-09 19:08:23'),
(260, 124, '5443', 1, 1, 1, NULL, '2025-07-09 19:09:21', '2025-07-09 19:09:21'),
(261, 124, '4315', 1, 1, 1, NULL, '2025-07-15 04:07:25', '2025-07-15 04:07:25'),
(262, 124, '1745', 1, 1, 1, NULL, '2025-07-15 04:08:06', '2025-07-15 04:08:06'),
(263, 124, '2556', 1, 1, 1, NULL, '2025-07-15 04:08:23', '2025-07-15 04:08:23'),
(264, 124, '7935', 1, 1, 1, NULL, '2025-07-15 14:27:50', '2025-07-15 14:27:50'),
(265, 124, '3247', 1, 1, 1, NULL, '2025-07-15 14:28:29', '2025-07-15 14:28:29'),
(266, 124, '3239', 1, 1, 1, NULL, '2025-07-15 14:28:50', '2025-07-15 14:28:50'),
(267, 124, '8231', 1, 1, 1, NULL, '2025-07-15 14:29:22', '2025-07-15 14:29:22'),
(268, 124, '6018', 1, 1, 1, NULL, '2025-07-16 00:59:24', '2025-07-16 00:59:24'),
(269, 124, '4553', 1, 1, 1, NULL, '2025-07-16 01:00:06', '2025-07-16 01:00:06'),
(270, 124, '7373', 1, 1, 1, NULL, '2025-07-16 01:00:28', '2025-07-16 01:00:28'),
(271, 124, '2784', 1, 1, 1, NULL, '2025-07-16 01:01:16', '2025-07-16 01:01:16'),
(272, 124, '8618', 1, 1, 1, NULL, '2025-07-16 02:01:52', '2025-07-16 02:01:52'),
(273, 124, '4877', 1, 1, 1, NULL, '2025-07-16 02:02:29', '2025-07-16 02:02:29'),
(274, 124, '5677', 1, 1, 1, NULL, '2025-07-16 02:02:52', '2025-07-16 02:02:52'),
(275, 124, '5438', 1, 1, 1, NULL, '2025-07-16 02:03:15', '2025-07-16 02:03:15'),
(276, 127, '8223', 1, 1, 1, NULL, '2025-07-19 06:00:01', '2025-07-19 06:00:01'),
(277, 123, '1234', 2, 1, 1, NULL, '2025-07-19 06:01:03', '2025-07-19 06:01:03'),
(278, 105, '1234', 2, 1, 1, NULL, '2025-07-19 06:02:08', '2025-07-19 06:02:08'),
(279, 127, '3676', 1, 1, 1, NULL, '2025-07-19 08:25:46', '2025-07-19 08:25:46'),
(280, 124, '9798', 1, 1, 1, NULL, '2025-07-20 14:02:39', '2025-07-20 14:02:39'),
(281, 124, '5247', 1, 1, 1, NULL, '2025-07-20 14:03:16', '2025-07-20 14:03:16'),
(282, 124, '4362', 1, 1, 1, NULL, '2025-07-20 14:03:33', '2025-07-20 14:03:33'),
(283, 124, '6248', 1, 1, 1, NULL, '2025-07-20 14:04:28', '2025-07-20 14:04:28'),
(284, 124, '5781', 1, 1, 1, NULL, '2025-07-20 23:03:42', '2025-07-20 23:03:42'),
(285, 124, '9250', 1, 1, 1, NULL, '2025-07-20 23:04:20', '2025-07-20 23:04:20'),
(286, 124, '1146', 1, 1, 1, NULL, '2025-07-20 23:04:37', '2025-07-20 23:04:37'),
(287, 124, '6232', 1, 1, 1, NULL, '2025-07-20 23:05:18', '2025-07-20 23:05:18'),
(288, 124, '2847', 1, 1, 1, NULL, '2025-07-21 17:02:00', '2025-07-21 17:02:00'),
(289, 124, '7590', 1, 1, 1, NULL, '2025-07-21 17:02:39', '2025-07-21 17:02:39'),
(290, 124, '9670', 1, 1, 1, NULL, '2025-07-21 17:02:56', '2025-07-21 17:02:56'),
(291, 124, '1870', 1, 1, 1, NULL, '2025-07-21 17:03:15', '2025-07-21 17:03:15'),
(292, 124, '3551', 1, 1, 1, NULL, '2025-07-23 14:40:51', '2025-07-23 14:40:51'),
(293, 124, '9811', 1, 1, 1, NULL, '2025-07-23 14:41:32', '2025-07-23 14:41:32'),
(294, 124, '5410', 1, 1, 1, NULL, '2025-07-23 14:41:51', '2025-07-23 14:41:51'),
(295, 124, '2528', 1, 1, 1, NULL, '2025-07-23 15:21:08', '2025-07-23 15:21:08'),
(296, 124, '6768', 1, 1, 1, NULL, '2025-07-23 15:21:46', '2025-07-23 15:21:46'),
(297, 124, '1309', 1, 1, 1, NULL, '2025-07-23 15:22:05', '2025-07-23 15:22:05'),
(298, 124, '9777', 1, 1, 1, NULL, '2025-07-23 15:22:23', '2025-07-23 15:22:23'),
(299, 124, '2329', 1, 1, 1, NULL, '2025-07-23 15:23:16', '2025-07-23 15:23:16'),
(300, 124, '2855', 1, 1, 1, NULL, '2025-07-24 17:12:07', '2025-07-24 17:12:07'),
(301, 124, '3039', 1, 1, 1, NULL, '2025-07-24 17:12:45', '2025-07-24 17:12:45'),
(302, 124, '8818', 1, 1, 1, NULL, '2025-07-24 17:13:02', '2025-07-24 17:13:02'),
(303, 124, '6181', 1, 1, 1, NULL, '2025-07-24 17:13:29', '2025-07-24 17:13:29'),
(304, 124, '3681', 1, 1, 1, NULL, '2025-07-26 19:56:39', '2025-07-26 19:56:39'),
(305, 124, '8664', 1, 1, 1, NULL, '2025-07-26 19:57:12', '2025-07-26 19:57:12'),
(306, 124, '2728', 1, 1, 1, NULL, '2025-07-26 19:57:29', '2025-07-26 19:57:29'),
(307, 124, '8670', 1, 1, 1, NULL, '2025-07-26 19:58:18', '2025-07-26 19:58:18');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pet`
--

CREATE TABLE `tbl_pet` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` int DEFAULT NULL COMMENT 'users.id',
  `pet_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pet_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `breed` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `weight` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `age` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `aggression` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vaccinated` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint NOT NULL DEFAULT '1' COMMENT '1-Active,2-Inactive,3-Deleted,4-Permanent Deleted',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_pet`
--

INSERT INTO `tbl_pet` (`id`, `user_id`, `pet_name`, `image`, `gender`, `pet_type`, `breed`, `weight`, `age`, `aggression`, `vaccinated`, `status`, `created_at`, `updated_at`) VALUES
(1, 90, 'Mapp', 'pet_category/MrQpDF6AxBa1C0tG5vG7L456PM4MUF9SGAqQTEgK.jpg', 'Female', 'Cat', 'white', '13', '4', 'Friendly', 'No', 1, '2025-05-22 12:01:03', '2025-05-22 12:01:03'),
(2, 90, 'hein', 'pet_category/lo9yffunUBJa7JDiZ9jjJ2AWHMpw0mria0S5EGqo.jpg', 'Female', 'Cat', 'whali', '14', '2', 'Friendly', 'No', 1, '2025-05-22 12:28:24', '2025-05-22 12:28:24'),
(3, 90, 'garre', 'pet_category/rCdkHPT1Ez254gDhu3hzzv9LrzBXQbJMUDyegPRt.jpg', 'Female', 'Cat', 'whatr', '18', '3', 'Friendly', 'No', 1, '2025-05-22 12:29:40', '2025-05-22 12:29:40'),
(4, 90, 'fvdvdv', 'pet_category/YNFvg79E85PVaVn4lFgFhHsNpPxwIao5e4R0CZEQ.jpg', 'Male', 'Cat', 'dwd', '5', '5', 'Friendly', 'No', 1, '2025-05-22 13:20:40', '2025-05-22 13:20:40'),
(5, 90, 'urejfdc', 'pet_category/SJPYTY6iJkJBXheQOGroiKlnpnlHm7cHFnVFeuAG.jpg', 'Female', 'Cat', 'cdscd', '5', '3', 'Friendly', 'No', 1, '2025-05-22 14:04:49', '2025-05-22 14:04:49'),
(6, 90, 'cdscs', 'pet_category/u6dG6Rr0PtsMS9z7iQQjUqAEBIxNIzlef2tbu9cU.jpg', 'Female', 'Cat', 'cddscs', '4', '3', 'Friendly', 'No', 1, '2025-05-22 14:22:44', '2025-05-22 14:22:44'),
(7, 94, 'Dogs', 'pet_category/6E27WkNTg6aHVTSc5lEkRfnIwezcDYx8tSUv2PHC.jpg', 'male', 'XD', 'SMALL', '20', '10.0', 'small breed', 'yes', 1, '2025-05-27 10:50:09', '2025-05-27 10:50:09'),
(8, 96, 'Dogs', 'pet_category/YQHNtFErGJMjFoTM47AgcJXgaCL0QiY1nAFbbuvi.jpg', 'male', 'XD', 'SMALL', '20', '10.0', 'small breed', 'yes', 1, '2025-05-28 04:49:08', '2025-05-28 04:49:08'),
(9, 98, 'ydycbhc', 'pet_category/RB4HIuaFVF2vimqNhbpJBSqLZndGlTnbTfHEO3P4.jpg', 'Male', 'Dog', 'sdsada', '43', '3', 'Friendly', 'No', 1, '2025-05-28 10:14:16', '2025-05-28 10:14:16'),
(10, 100, 'Dog', 'pet_category/zkr6wnJle4DNdJNZk9QAO7gySY6RfwyeUJTV1uyQ.jpg', 'Male', 'Cat', 'Small', '5', '1 year', 'High', 'No', 1, '2025-05-29 09:30:49', '2025-05-29 09:30:49'),
(11, 101, 'dog', 'pet_category/196GflwkdhR8pMy9bWuvZUnObn2WC36ryMvRIP1P.jpg', 'Female', 'Cat', 'white', '4', '4', 'Friendly', 'Yes', 1, '2025-05-29 10:22:21', '2025-05-29 10:22:21'),
(12, 103, 'Dogs', 'pet_category/HI9wGlVyDv7LSns8MM9mH5MjlVzKtk5jrKm07IlX.png', 'male', 'XD', 'SMALL', '20', '10.0', 'small breed', 'yes', 1, '2025-05-29 13:28:43', '2025-05-29 13:28:43'),
(13, 105, 'Dog', 'pet_category/vpJBSwDENAVeqSQGl0logWWdElJDD2nRcrJXkLcL.jpg', 'Female', 'Cat', 'Small', '5', '4 month', 'Friendly', 'No', 1, '2025-05-30 06:06:27', '2025-05-30 06:06:27'),
(14, 107, 'Hero', 'pet_category/z7rh2TYCe5SqKovZ2JjjTJXZWPvDgo2pkjgHRFv1.jpg', 'Male', 'Cat', 'Don', '30', '3', 'High', 'Yes', 1, '2025-05-31 05:38:03', '2025-05-31 05:38:03'),
(15, 124, 'Royal', 'pet_category/naJONzAs95kIp7xJQqb3GkoBKLu0gL1mZhueQikw.jpg', 'Male', 'Cat', 'Small', '10', '0.6', 'Friendly', 'Yes', 1, '2025-06-02 11:46:53', '2025-06-02 11:46:53'),
(16, 125, 'Fhj', 'pet_category/cEFqjtyzjFdTjWOoVZ1n8GwmFR3CGWhQjzU84ET2.png', 'Male', 'Dog', 'Labrador', '25', '6', 'Friendly', 'Yes', 1, '2025-06-03 09:06:01', '2025-06-03 09:06:01'),
(17, 125, 'Joy', 'pet_category/KW6PYBKqhofwqwJMx2JQGdzYexjYtPnl1nShUJi0.png', 'Male', 'Dog', 'Jarman safed', '25', '2', 'Normal', 'Yes', 1, '2025-06-10 15:18:34', '2025-06-10 15:18:34');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pet_bookings`
--

CREATE TABLE `tbl_pet_bookings` (
  `id` int NOT NULL,
  `customer_id` int NOT NULL,
  `accept_user_id` int DEFAULT NULL COMMENT 'users.id',
  `cart_id` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `package_id` int NOT NULL COMMENT 'packages.id',
  `payment_id` int DEFAULT NULL COMMENT 'payment_transaction.id',
  `pet_id` int DEFAULT NULL COMMENT 'tbl_pets.id',
  `pet_name` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `pet_image` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `pet_gender` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `pet_type` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `pet_breed` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `pet_weight` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `pet_age` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `pet_aggression` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `pet_vaccinated` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `package_name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `package_type` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `booking_date` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `booking_time` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `booking_amount` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tax_amount` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `total_amount` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_general_ci,
  `flat_house_no` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `area_sector_locality` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `city_district` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `state` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `pincode` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `complete_address` text COLLATE utf8mb4_general_ci NOT NULL,
  `email_address` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status` tinyint NOT NULL DEFAULT '1' COMMENT '1-Active,2-Inactive,3-Delted',
  `booking_status` tinyint NOT NULL DEFAULT '1' COMMENT '1-Pending,2-Confirmed,3-Cancelled,4-Complete',
  `otp` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `is_otp_verified` tinyint NOT NULL DEFAULT '2' COMMENT '1-Verify,2-Not Verify',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_pet_bookings`
--

INSERT INTO `tbl_pet_bookings` (`id`, `customer_id`, `accept_user_id`, `cart_id`, `package_id`, `payment_id`, `pet_id`, `pet_name`, `pet_image`, `pet_gender`, `pet_type`, `pet_breed`, `pet_weight`, `pet_age`, `pet_aggression`, `pet_vaccinated`, `package_name`, `package_type`, `booking_date`, `booking_time`, `booking_amount`, `tax_amount`, `total_amount`, `description`, `flat_house_no`, `area_sector_locality`, `city_district`, `state`, `pincode`, `complete_address`, `email_address`, `status`, `booking_status`, `otp`, `is_otp_verified`, `created_at`, `updated_at`) VALUES
(1, 105, 106, '1', 1, 1, 13, 'Dog', 'pet_category/vpJBSwDENAVeqSQGl0logWWdElJDD2nRcrJXkLcL.jpg', 'Female', 'Cat', 'Small', '5', '4 month', 'Friendly', 'No', 'Hic laborum Laborum', 'gaint_charge', '2025-05-16', '20:00 - 22:00', '200', '20', '220', NULL, 'House no.76', 'Dayalpur', 'Delhi', 'Delhi', '110096', 'Delhi', 'fajlurehman588@gmail.com', 1, 4, '9589', 1, '2025-05-30 06:13:32', '2025-05-30 06:13:32'),
(2, 107, 106, '2', 2, 3, 14, 'Hero', 'pet_category/z7rh2TYCe5SqKovZ2JjjTJXZWPvDgo2pkjgHRFv1.jpg', 'Male', 'Cat', 'Don', '30', '3', 'High', 'Yes', 'Velit possimus ame', 'gaint_charge', '2025-06-02', '14:00 - 15:00', '600', '120', '720', NULL, 'Erwftsfff', 'De2fy3ed', 'Noida', 'Up', '845451', 'Gautam Budh nagar', '19cs65l@lingayasvidyapeeth.edu.in', 1, 2, '1121', 2, '2025-05-31 05:38:45', '2025-05-31 05:38:45'),
(3, 107, 106, '3', 1, 4, 14, 'Hero', 'pet_category/z7rh2TYCe5SqKovZ2JjjTJXZWPvDgo2pkjgHRFv1.jpg', 'Male', 'Cat', 'Don', '30', '3', 'High', 'Yes', 'Hic laborum Laborum', 'small_charge', '2025-05-31', '20:00 - 22:00', '100', '10', '110', NULL, 'Erwftsfff', 'De2fy3ed', 'Noida', 'Up', '845451', 'Gautam Budh nagar', '19cs65l@lingayasvidyapeeth.edu.in', 1, 2, '9165', 2, '2025-05-31 05:45:57', '2025-05-31 05:45:57'),
(4, 107, 106, '4', 1, 5, 14, 'Hero', 'pet_category/z7rh2TYCe5SqKovZ2JjjTJXZWPvDgo2pkjgHRFv1.jpg', 'Male', 'Cat', 'Don', '30', '3', 'High', 'Yes', 'Hic laborum Laborum', 'large_charge', '2025-05-31', '20:00 - 22:00', '200', '20', '220', NULL, 'Erwftsfff', 'De2fy3ed', 'Noida', 'Up', '845451', 'Gautam Budh nagar', '19cs65l@lingayasvidyapeeth.edu.in', 1, 2, '2427', 2, '2025-05-31 05:50:37', '2025-05-31 05:50:37'),
(5, 107, 106, '5', 1, 6, 14, 'Hero', 'pet_category/z7rh2TYCe5SqKovZ2JjjTJXZWPvDgo2pkjgHRFv1.jpg', 'Male', 'Cat', 'Don', '30', '3', 'High', 'Yes', 'Hic laborum Laborum', 'small_charge', '2025-05-31', '12:00 - 13:00', '100', '10', '110', NULL, 'Erwftsfff', 'De2fy3ed', 'Noida', 'Up', '845451', 'Gautam Budh nagar', '19cs65l@lingayasvidyapeeth.edu.in', 1, 2, '2183', 2, '2025-05-31 05:59:37', '2025-05-31 05:59:37'),
(6, 105, NULL, '6', 2, 7, 13, 'Dog', 'pet_category/vpJBSwDENAVeqSQGl0logWWdElJDD2nRcrJXkLcL.jpg', 'Female', 'Cat', 'Small', '5', '4 month', 'Friendly', 'No', 'Velit possimus ame', 'gaint_charge', '2025-05-31', '18:00 - 19:00', '600', '120', '720', NULL, 'House no.76', 'Dayalpur', 'Delhi', 'Delhi', '110096', 'Delhi', 'fajlurehman588@gmail.com', 1, 1, '9171', 2, '2025-05-31 07:32:45', '2025-05-31 07:32:45');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_token`
--

CREATE TABLE `tbl_token` (
  `id` int NOT NULL,
  `user_id` int NOT NULL COMMENT 'users.id',
  `token` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `status` tinyint NOT NULL DEFAULT '1' COMMENT '1-Active,2-Expire',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_token`
--

INSERT INTO `tbl_token` (`id`, `user_id`, `token`, `status`, `created_at`, `updated_at`) VALUES
(1, 105, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJyb2xlIjoiQ3VzdG9tZXIiLCJzdWIiOjEwNSwiaWF0IjoxNzQ4NTg1MDIxLCJleHAiOjE3ODAxMjEwMjF9.vv0FggRZZjJHsjKpHsYc1-QX6W-obuyCpyKn_d1DnKA', 2, '2025-05-30 06:03:41', '2025-05-30 09:33:13'),
(2, 106, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJyb2xlIjoiR3Jvb21lciIsInN1YiI6MTA2LCJpYXQiOjE3NDg1ODUwMzQsImV4cCI6MTc4MDEyMTAzNH0.mLsM8ZDtkQ0hh9xuxphEUNydN7W8RjGU-ioKLd85cs4', 2, '2025-05-30 06:03:54', '2025-05-30 06:11:21'),
(3, 106, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJyb2xlIjoiR3Jvb21lciIsInN1YiI6MTA2LCJpYXQiOjE3NDg1ODU0ODEsImV4cCI6MTc4MDEyMTQ4MX0.dmLjsAOjlBBkeHaXXNXJogLOUcAwuiAFojVZbqbwerQ', 2, '2025-05-30 06:11:21', '2025-05-30 06:31:03'),
(4, 106, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJyb2xlIjoiR3Jvb21lciIsInN1YiI6MTA2LCJpYXQiOjE3NDg1ODY2NjMsImV4cCI6MTc4MDEyMjY2M30.oTchJuWkr0zNXLlm8GgNhPRrvOeJHyBRi-RBh9eRofU', 2, '2025-05-30 06:31:03', '2025-05-30 06:50:24'),
(5, 106, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJyb2xlIjoiR3Jvb21lciIsInN1YiI6MTA2LCJpYXQiOjE3NDg1ODc4MjQsImV4cCI6MTc4MDEyMzgyNH0.TQPgRA1Pio6u1FueY3hpu9ykJij5sMyYpYc8nc-hep8', 2, '2025-05-30 06:50:24', '2025-05-30 07:15:14'),
(6, 106, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJyb2xlIjoiR3Jvb21lciIsInN1YiI6MTA2LCJpYXQiOjE3NDg1ODkzMTQsImV4cCI6MTc4MDEyNTMxNH0.0u9WESNdJwcQsDVOk_l5GAlwJKE-tBH315XQcsCVg9o', 2, '2025-05-30 07:15:14', '2025-05-30 07:44:47'),
(7, 106, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJyb2xlIjoiR3Jvb21lciIsInN1YiI6MTA2LCJpYXQiOjE3NDg1OTEwODcsImV4cCI6MTc4MDEyNzA4N30.NSwN6Ggi3gMcioxaAnFR8IuoQusy3k6vi2q3JIRNzE8', 2, '2025-05-30 07:44:47', '2025-05-30 07:56:32'),
(8, 106, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJyb2xlIjoiR3Jvb21lciIsInN1YiI6MTA2LCJpYXQiOjE3NDg1OTE3OTIsImV4cCI6MTc4MDEyNzc5Mn0.k4cBdM7CspuSwQZ_N_vQHfpEkmTFLDagLe8eAayoXjE', 2, '2025-05-30 07:56:32', '2025-05-30 08:27:40'),
(9, 106, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJyb2xlIjoiR3Jvb21lciIsInN1YiI6MTA2LCJpYXQiOjE3NDg1OTM2NjAsImV4cCI6MTc4MDEyOTY2MH0.u_4_jRtqdfH5Qf-ofnyZx3IfyvLZdmiS8VtSRSpiaCU', 2, '2025-05-30 08:27:40', '2025-05-30 08:30:34'),
(10, 106, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJyb2xlIjoiR3Jvb21lciIsInN1YiI6MTA2LCJpYXQiOjE3NDg1OTM4MzQsImV4cCI6MTc4MDEyOTgzNH0.g1emLPgq-erQaJco95fiopwZQoKuD34RQG41LaeG9Jk', 2, '2025-05-30 08:30:34', '2025-05-30 08:31:17'),
(11, 106, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJyb2xlIjoiR3Jvb21lciIsInN1YiI6MTA2LCJpYXQiOjE3NDg1OTM4NzcsImV4cCI6MTc4MDEyOTg3N30.OihE8fSevZo4_DAVjFP7EwkXcYZJBTvSiSU4CAOVfvE', 2, '2025-05-30 08:31:17', '2025-05-30 10:04:10'),
(12, 105, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJyb2xlIjoiQ3VzdG9tZXIiLCJzdWIiOjEwNSwiaWF0IjoxNzQ4NTk3NTkzLCJleHAiOjE3ODAxMzM1OTN9.3AFFcwsww3e5E1oM1hvgMY2DNFOg-JWIqW7NeEK63wM', 2, '2025-05-30 09:33:13', '2025-05-30 09:34:31'),
(13, 105, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJyb2xlIjoiQ3VzdG9tZXIiLCJzdWIiOjEwNSwiaWF0IjoxNzQ4NTk3NjcxLCJleHAiOjE3ODAxMzM2NzF9.FeyULPvqr5mpKx-d_UWadPHv3HY0XusYnMbDEVxazKI', 2, '2025-05-30 09:34:31', '2025-05-31 07:31:27'),
(14, 106, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJyb2xlIjoiR3Jvb21lciIsInN1YiI6MTA2LCJpYXQiOjE3NDg1OTk0NTAsImV4cCI6MTc4MDEzNTQ1MH0.z9pXdWcLprAtzBoxn4FcLU4sgrRrO18UVMM1NLB7KWE', 2, '2025-05-30 10:04:10', '2025-05-30 10:08:17'),
(15, 106, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJyb2xlIjoiR3Jvb21lciIsInN1YiI6MTA2LCJpYXQiOjE3NDg1OTk2OTcsImV4cCI6MTc4MDEzNTY5N30.6GMzi-_lGGIhMaViV8XU-QoD0LXdI-J68puIbvVydFk', 2, '2025-05-30 10:08:17', '2025-05-30 10:11:07'),
(16, 106, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJyb2xlIjoiR3Jvb21lciIsInN1YiI6MTA2LCJpYXQiOjE3NDg1OTk4NjcsImV4cCI6MTc4MDEzNTg2N30.Q-hDaTvN3Fh_m5EapWJlOtKuSnXVft_w8BTprsQUs4o', 2, '2025-05-30 10:11:07', '2025-05-31 13:06:12'),
(17, 107, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJyb2xlIjoiQ3VzdG9tZXIiLCJzdWIiOjEwNywiaWF0IjoxNzQ4NjY5Njk5LCJleHAiOjE3ODAyMDU2OTl9.YZJhcRcEyT-e9QDeUjy1ezKrEuc8FX10FRVpWjCanMs', 1, '2025-05-31 05:34:59', '2025-05-31 05:34:59'),
(18, 105, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJyb2xlIjoiQ3VzdG9tZXIiLCJzdWIiOjEwNSwiaWF0IjoxNzQ4Njc2Njg3LCJleHAiOjE3ODAyMTI2ODd9.tkhDwnKkpKUVkMcM6TwE8TSg2FhfHfHSPZDIIAGgBa8', 2, '2025-05-31 07:31:27', '2025-05-31 10:29:05'),
(19, 105, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJyb2xlIjoiQ3VzdG9tZXIiLCJzdWIiOjEwNSwiaWF0IjoxNzQ4Njg3MzQ1LCJleHAiOjE3ODAyMjMzNDV9.YZYsEfo4xBw9GSr2bTWskQ80mFwepZUujjOh3-J1SxE', 2, '2025-05-31 10:29:05', '2025-06-02 17:10:24'),
(20, 106, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJyb2xlIjoiR3Jvb21lciIsInN1YiI6MTA2LCJpYXQiOjE3NDg2OTY3NzIsImV4cCI6MTc4MDIzMjc3Mn0._sMSCnGieEK_BA_TxZ6_F6rJWJffLzCpeygPJiOnwuY', 2, '2025-05-31 13:06:12', '2025-05-31 13:40:18'),
(21, 108, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJyb2xlIjoiR3Jvb21lciIsInN1YiI6MTA4LCJpYXQiOjE3NDg2OTkzNTksImV4cCI6MTc4MDIzNTM1OX0.3vOcebOXYFAw7CbQivCwP8_L2B_ksrHaMF8qcEc1Ido', 2, '2025-05-31 13:49:19', '2025-05-31 13:51:32'),
(22, 109, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJyb2xlIjoiR3Jvb21lciIsInN1YiI6MTA5LCJpYXQiOjE3NDg2OTk1MzYsImV4cCI6MTc4MDIzNTUzNn0.cTwiKZzKIPCNo3xbzlODzki2yCMEkoef9mSkeHyWrYw', 2, '2025-05-31 13:52:16', '2025-05-31 13:57:36'),
(23, 110, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJyb2xlIjoiR3Jvb21lciIsInN1YiI6MTEwLCJpYXQiOjE3NDg3MDAwNDIsImV4cCI6MTc4MDIzNjA0Mn0.X6h8Y4wT0j_wYRuKrkdul4j8XCryQ3iINk1H6VqePl4', 2, '2025-05-31 14:00:42', '2025-05-31 14:03:37'),
(24, 111, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJyb2xlIjoiR3Jvb21lciIsInN1YiI6MTExLCJpYXQiOjE3NDg3MDAzOTYsImV4cCI6MTc4MDIzNjM5Nn0.KGhMGfZwH7fLLx6Z_hozbrpge8NPxCO11qSbndFsK8Y', 2, '2025-05-31 14:06:36', '2025-05-31 14:07:02'),
(25, 112, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJyb2xlIjoiR3Jvb21lciIsInN1YiI6MTEyLCJpYXQiOjE3NDg3MDA1MjQsImV4cCI6MTc4MDIzNjUyNH0.lu_DvL3fK5a8cnJnERLpfIlO0QSgsSgAkHPYzonP1Qg', 2, '2025-05-31 14:08:44', '2025-05-31 14:09:06'),
(26, 113, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJyb2xlIjoiR3Jvb21lciIsInN1YiI6MTEzLCJpYXQiOjE3NDg3MDA1NzQsImV4cCI6MTc4MDIzNjU3NH0.EGKJiPGUsCiPEuRBJs7y-RoUF64WF5Kw7XypZjk7ksY', 2, '2025-05-31 14:09:34', '2025-06-02 04:58:41'),
(27, 113, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJyb2xlIjoiR3Jvb21lciIsInN1YiI6MTEzLCJpYXQiOjE3NDg4NDAzMjEsImV4cCI6MTc4MDM3NjMyMX0.gQGB-Gc54B2KfGJDopJ-q4RhFIBwIRJdEtfyRh1C5d4', 2, '2025-06-02 04:58:41', '2025-06-02 05:22:01'),
(28, 113, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJyb2xlIjoiR3Jvb21lciIsInN1YiI6MTEzLCJpYXQiOjE3NDg4NDE3MjEsImV4cCI6MTc4MDM3NzcyMX0.VpGT3dumQR1cIPHlirbnvxmTYNffdGDflsds_4bEfc0', 2, '2025-06-02 05:22:01', '2025-06-02 05:22:16'),
(29, 115, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJyb2xlIjoiR3Jvb21lciIsInN1YiI6MTE1LCJpYXQiOjE3NDg4NDE4MjksImV4cCI6MTc4MDM3NzgyOX0.Z2ZxaPBs78iNzlvYjuAJyZv_lJfAj9ji0llzzNAU_uY', 2, '2025-06-02 05:23:49', '2025-06-02 05:42:09'),
(30, 116, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJyb2xlIjoiR3Jvb21lciIsInN1YiI6MTE2LCJpYXQiOjE3NDg4NDI5NzksImV4cCI6MTc4MDM3ODk3OX0.xh--uPF5UYtEXtRTHy0pz41JgUWRXLC9hHTr80x4SvU', 2, '2025-06-02 05:42:59', '2025-06-02 05:53:43'),
(31, 117, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJyb2xlIjoiR3Jvb21lciIsInN1YiI6MTE3LCJpYXQiOjE3NDg4NDM2NjcsImV4cCI6MTc4MDM3OTY2N30.aGymfyhuTBtuYQ-sLSReNztEQO703jnPvy66dKv9bi0', 2, '2025-06-02 05:54:27', '2025-06-02 05:58:47'),
(32, 118, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJyb2xlIjoiR3Jvb21lciIsInN1YiI6MTE4LCJpYXQiOjE3NDg4NDQwMDUsImV4cCI6MTc4MDM4MDAwNX0.3H06vgymi1tJnhR4xqIr2lq4OCWp-uVdTzKfl9tjkss', 2, '2025-06-02 06:00:05', '2025-06-02 06:06:10'),
(33, 119, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJyb2xlIjoiR3Jvb21lciIsInN1YiI6MTE5LCJpYXQiOjE3NDg4NDQ0MjMsImV4cCI6MTc4MDM4MDQyM30.xThhP6PiNEcZ-gfsMKeXPBbDPj_vft5kcSoel7m_DTo', 2, '2025-06-02 06:07:03', '2025-06-02 06:09:08'),
(34, 120, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJyb2xlIjoiR3Jvb21lciIsInN1YiI6MTIwLCJpYXQiOjE3NDg4NDQ1OTQsImV4cCI6MTc4MDM4MDU5NH0.3V4cm5xaMmmjY_Jojhxn-PWhDyxZLrECuGY_JqlKPdQ', 2, '2025-06-02 06:09:54', '2025-06-02 06:14:25'),
(35, 121, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJyb2xlIjoiR3Jvb21lciIsInN1YiI6MTIxLCJpYXQiOjE3NDg4NDUxNzYsImV4cCI6MTc4MDM4MTE3Nn0.qN1c94PaZUiJlNAvgd5ohlijSQMv8lLr9HiOZCqRg_M', 1, '2025-06-02 06:19:36', '2025-06-02 06:19:36'),
(36, 122, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJyb2xlIjoiR3Jvb21lciIsInN1YiI6MTIyLCJpYXQiOjE3NDg4NDUyODMsImV4cCI6MTc4MDM4MTI4M30.8pMh8n0gr5-WP5F7p2KZxBkNoZ3VSnWDD5SHxaZVn-A', 1, '2025-06-02 06:21:23', '2025-06-02 06:21:23'),
(37, 123, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJyb2xlIjoiR3Jvb21lciIsInN1YiI6MTIzLCJpYXQiOjE3NDg4NjE3NTQsImV4cCI6MTc4MDM5Nzc1NH0.6vND37omtd0in_Tc2VCjCd7CTnZq5ipZHJ6YhZt4EqE', 2, '2025-06-02 10:55:54', '2025-06-02 10:59:10'),
(38, 123, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJyb2xlIjoiR3Jvb21lciIsInN1YiI6MTIzLCJpYXQiOjE3NDg4NjE5NTAsImV4cCI6MTc4MDM5Nzk1MH0.BVIhhu1mqhxtGJ4eEnL0Kyo7EIGo6nHYdwEqYXwrrv8', 2, '2025-06-02 10:59:10', '2025-06-03 09:10:50'),
(39, 124, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJyb2xlIjoiQ3VzdG9tZXIiLCJzdWIiOjEyNCwiaWF0IjoxNzQ4ODY0NTYzLCJleHAiOjE3ODA0MDA1NjN9.mTeua6eGtmJrLY_MWXKSLgMs8X3Jocpll_eSapmxnT4', 2, '2025-06-02 11:42:43', '2025-06-03 07:13:33'),
(40, 105, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJyb2xlIjoiQ3VzdG9tZXIiLCJzdWIiOjEwNSwiaWF0IjoxNzQ4ODg0MjI0LCJleHAiOjE3ODA0MjAyMjR9.T963BpD0IndOmj9OvlspH-JDreEo1H4gWLcSNhp3Wmk', 2, '2025-06-02 17:10:24', '2025-07-05 07:34:19'),
(41, 124, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJyb2xlIjoiQ3VzdG9tZXIiLCJzdWIiOjEyNCwiaWF0IjoxNzQ4OTM0ODEzLCJleHAiOjE3ODA0NzA4MTN9.fzUXRGKCcyYkqqKO_4l-oyqG6x5CpSL9MqbJX8zR3pI', 1, '2025-06-03 07:13:33', '2025-06-03 07:13:33'),
(42, 125, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJyb2xlIjoiQ3VzdG9tZXIiLCJzdWIiOjEyNSwiaWF0IjoxNzQ4OTQxMzgyLCJleHAiOjE3ODA0NzczODJ9.tm_ZSk7e_HbnzMIChsoUMitgraK-SWuMXblyR6oxM2U', 2, '2025-06-03 09:03:02', '2025-06-04 03:04:37'),
(43, 123, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJyb2xlIjoiR3Jvb21lciIsInN1YiI6MTIzLCJpYXQiOjE3NDg5NDE4NTAsImV4cCI6MTc4MDQ3Nzg1MH0.88Qn9O8A81QghvhfLb_XHqwPeRELZ7_OQO9fqi0RFRE', 2, '2025-06-03 09:10:50', '2025-07-19 06:01:17'),
(44, 125, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJyb2xlIjoiQ3VzdG9tZXIiLCJzdWIiOjEyNSwiaWF0IjoxNzQ5MDA2Mjc3LCJleHAiOjE3ODA1NDIyNzd9.rSs3xhIQ42VJvN-xhiBgaSMYY_bZF0cDP4vP62iR_Uo', 2, '2025-06-04 03:04:37', '2025-06-10 15:17:30'),
(45, 125, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJyb2xlIjoiQ3VzdG9tZXIiLCJzdWIiOjEyNSwiaWF0IjoxNzQ5NTY4NjUwLCJleHAiOjE3ODExMDQ2NTB9.oR8-jMQ-2GNH9HegS9vDTPCnslcuRAGYTriaY5mjRm8', 1, '2025-06-10 15:17:30', '2025-06-10 15:17:30'),
(46, 105, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJyb2xlIjoiQ3VzdG9tZXIiLCJzdWIiOjEwNSwiaWF0IjoxNzUxNzAwODU5LCJleHAiOjE3ODMyMzY4NTl9.4iAv3CKk0i7yybql7WBLx823mOOOGsfP-ym4otRtulQ', 2, '2025-07-05 07:34:19', '2025-07-19 06:02:13'),
(47, 123, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJyb2xlIjoiR3Jvb21lciIsInN1YiI6MTIzLCJpYXQiOjE3NTI5MDQ4NzcsImV4cCI6MTc4NDQ0MDg3N30.JzMVM-p9d9y5XXbyz3IBUI4W9bSsbD6m09LXArUULUQ', 1, '2025-07-19 06:01:17', '2025-07-19 06:01:17'),
(48, 105, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJyb2xlIjoiQ3VzdG9tZXIiLCJzdWIiOjEwNSwiaWF0IjoxNzUyOTA0OTMzLCJleHAiOjE3ODQ0NDA5MzN9.FC7-knAbWQ9VHMUN4m8XDUFSPpD0QVJIt3svm3y5uK8', 1, '2025-07-19 06:02:13', '2025-07-19 06:02:13');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_update_profile_request`
--

CREATE TABLE `tbl_update_profile_request` (
  `id` int NOT NULL,
  `user_id` int NOT NULL COMMENT 'users.id',
  `field_value` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `field_type` int NOT NULL COMMENT '1-Mobile,2-Email',
  `status` tinyint NOT NULL DEFAULT '1' COMMENT '1-Pending, 2-Approval,3-Reject',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_update_profile_request`
--

INSERT INTO `tbl_update_profile_request` (`id`, `user_id`, `field_value`, `field_type`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, '9756188580', 1, 2, '2024-10-07 10:50:49', NULL),
(2, 1, 'shadab.nerasoft@gmail.com', 2, 2, '2024-10-07 11:24:33', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `t_shirt`
--

CREATE TABLE `t_shirt` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `s` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `m` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `l` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `xl` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `xxl` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint NOT NULL DEFAULT '1' COMMENT '1-Active,2-Inactive,3-Deleted,4-Permanent Deleted',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `t_shirt`
--

INSERT INTO `t_shirt` (`id`, `title`, `image`, `description`, `s`, `m`, `l`, `xl`, `xxl`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Groomer T-shirt', 'pet_tshirt/5JKv67xmAlWrmLrNbwA1YHy0djlDeDjXjQfaagPm.png', 'Lorem Ipsum Dolor Sit', '10', '20', '30', '40', '50', 1, '2025-05-27 13:36:41', '2025-05-29 06:48:56'),
(2, 'Helper T-shirt', 'pet_tshirt/h24FOOdCZn8AN9tXp5MCVfYqZGKozeVQz2c8uk9o.png', 'Lorem Ipsum Dolor Sit', '50', '100', '150', '200', '250', 1, '2025-05-27 13:51:09', '2025-05-29 06:48:52');

-- --------------------------------------------------------

--
-- Table structure for table `t_shirt_transaction`
--

CREATE TABLE `t_shirt_transaction` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `method` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL,
  `currency` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'INR',
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `response` text COLLATE utf8mb4_unicode_ci,
  `t_shirt_size` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int UNSIGNED NOT NULL,
  `parent_id` int DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `aadhar_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `security_pin` varchar(55) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role_id` int NOT NULL COMMENT 'roles.id',
  `employe_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `_normalized_city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `_category` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `_type` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `continent` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country_code` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `county` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `postcode` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `road` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `road_type` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state_code` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state_district` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `suburb` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `t_shirt_size` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_loggedin` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `fcm_token` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` tinyint NOT NULL DEFAULT '1' COMMENT '1-Active,2-InActive,3-Deleted, 4- Permanent Deleted'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `parent_id`, `name`, `email`, `aadhar_no`, `mobile_no`, `image`, `email_verified_at`, `password`, `remember_token`, `security_pin`, `role_id`, `employe_type`, `_normalized_city`, `_category`, `_type`, `continent`, `country`, `country_code`, `county`, `postcode`, `road`, `road_type`, `state`, `state_code`, `state_district`, `suburb`, `t_shirt_size`, `is_loggedin`, `fcm_token`, `created_at`, `updated_at`, `status`) VALUES
(1, NULL, 'fazlu rehman', 'fazlu.developer1@gmail.com', NULL, '7428059961', 'uploads/profile_images/1738832801.png', NULL, '$2y$10$u0mJRa6qw3YGBFSW/Fdb0uKK/E08u5fiThDyQfk69Kl.L4MowfeYa', 'YxBQdHP9URBE6fPVj02orc0WD1buKMYET5yqzkWug4PEAYZv5tBuqm9UejLw', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', NULL, NULL, '2025-02-06 09:06:41', 1),
(105, NULL, 'Fazlu', 'fajlurehman588@gmail.com', NULL, '7428059960', 'uploads/profile_images/1748585063.jpg', NULL, NULL, NULL, NULL, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', NULL, '2025-05-30 06:03:20', '2025-05-30 06:04:23', 1),
(107, NULL, 'Ujjwal', '19cs65l@lingayasvidyapeeth.edu.in', NULL, '9504683618', NULL, NULL, NULL, NULL, NULL, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', 'dp-Av1n4ReCVYFTDUhON_o:APA91bGMBtkH_EUWcNBIg2rUaaxBLM2YRd8lflvQ7GjtqhW27xSEPQXx01olmZDU-VwN3KzhRFtsVzYUOzkZT95k25fwMG9T_qgjC9sCyajRjSAoZOtvo-U', '2025-05-31 05:34:28', '2025-05-31 05:34:28', 1),
(114, NULL, 'Betty parker', 'bettyparker473@gmail.com', NULL, '7062802973', NULL, NULL, NULL, NULL, NULL, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', NULL, '2025-06-02 04:01:53', '2025-06-02 04:01:53', 1),
(123, NULL, 'Sarthak', 'sarthakpathak59@gmail.com', NULL, '8700682075', NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', 'fBWSq4A3T2ya5haTyLvm3S:APA91bED_FS87Hd_C4U5JBxNFGeOQP5YPk9sw2LLneMnvBxY2OalagZEqC_V1WBFtPIxWznlwQi2QBUGDMYKr5oZmqCejh6iEMhKgqYiWnuxRDlYiImrA0U', '2025-06-02 10:55:44', '2025-06-02 10:55:44', 1),
(124, NULL, 'Shivam Pandey', 'shivam520p@gmail.com', NULL, '9555804662', 'uploads/profile_images/1748864588.jpg', NULL, NULL, NULL, NULL, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', 'f8ky3bxJQaGdOOyRzqp378:APA91bEgrlKDXQvRpV7OOsGJV3ZW-oXVGUwFyr2Q4bpZlqPkbIO_p7OYneVJw0TmoF6ecyKI2wG4SEkvSz0SRSRNTQjujS_VkgAni4D4kblZtjlqZMsZEYY', '2025-06-02 11:42:21', '2025-06-02 11:43:08', 1),
(125, NULL, 'Vijay Kumar', 'mynameisvijay0@gmail.com', NULL, '7827787725', NULL, NULL, NULL, NULL, NULL, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', 'eWiBi79kROiM52w4ej9X_q:APA91bHxeHSggjJ909UXpWfmKnc9WzHkPpObpn30tOYMsq1dZpq23waJScYAlweY2jlomC1z5Ew0RyIKtSAIXUWA5dna3kNKGprqXAkh0vDDYFt47uSw7Jw', '2025-06-03 09:02:32', '2025-06-03 09:02:32', 1),
(126, NULL, 'Kamila', 'perfect8540@gmail.com', NULL, '6613887328', NULL, NULL, NULL, NULL, NULL, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', NULL, '2025-06-13 16:22:44', '2025-06-13 16:22:44', 1),
(127, NULL, 'Ujala', 'ujalanera@gmail.com', NULL, '9650897905', NULL, NULL, NULL, NULL, NULL, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', NULL, '2025-07-19 05:59:16', '2025-07-19 05:59:16', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `add_package_service`
--
ALTER TABLE `add_package_service`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `assignroutes`
--
ALTER TABLE `assignroutes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `banks`
--
ALTER TABLE `banks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cms_settings`
--
ALTER TABLE `cms_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dynamic_url`
--
ALTER TABLE `dynamic_url`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `emi_collections`
--
ALTER TABLE `emi_collections`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `kycdatas`
--
ALTER TABLE `kycdatas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kycs`
--
ALTER TABLE `kycs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kyc_leads`
--
ALTER TABLE `kyc_leads`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kyc_leads_guarantor`
--
ALTER TABLE `kyc_leads_guarantor`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kyc_processes`
--
ALTER TABLE `kyc_processes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kyc_reject_reasons`
--
ALTER TABLE `kyc_reject_reasons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `loans`
--
ALTER TABLE `loans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `loan_disbursements`
--
ALTER TABLE `loan_disbursements`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `loan_requests`
--
ALTER TABLE `loan_requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `location_data`
--
ALTER TABLE `location_data`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notes`
--
ALTER TABLE `notes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `packages`
--
ALTER TABLE `packages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `packages_image`
--
ALTER TABLE `packages_image`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `payment_modes`
--
ALTER TABLE `payment_modes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment_out`
--
ALTER TABLE `payment_out`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment_transactions`
--
ALTER TABLE `payment_transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `pet_category`
--
ALTER TABLE `pet_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `referral_code`
--
ALTER TABLE `referral_code`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `refers`
--
ALTER TABLE `refers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `refer_and_earn`
--
ALTER TABLE `refer_and_earn`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role_models`
--
ALTER TABLE `role_models`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role_permission`
--
ALTER TABLE `role_permission`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `route_logs`
--
ALTER TABLE `route_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_address`
--
ALTER TABLE `tbl_address`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_booking_log`
--
ALTER TABLE `tbl_booking_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_cart`
--
ALTER TABLE `tbl_cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_helpers`
--
ALTER TABLE `tbl_helpers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_notification`
--
ALTER TABLE `tbl_notification`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_otp`
--
ALTER TABLE `tbl_otp`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_pet`
--
ALTER TABLE `tbl_pet`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_pet_bookings`
--
ALTER TABLE `tbl_pet_bookings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_token`
--
ALTER TABLE `tbl_token`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_update_profile_request`
--
ALTER TABLE `tbl_update_profile_request`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_shirt`
--
ALTER TABLE `t_shirt`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_shirt_transaction`
--
ALTER TABLE `t_shirt_transaction`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `add_package_service`
--
ALTER TABLE `add_package_service`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `assignroutes`
--
ALTER TABLE `assignroutes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `banks`
--
ALTER TABLE `banks`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cms_settings`
--
ALTER TABLE `cms_settings`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `dynamic_url`
--
ALTER TABLE `dynamic_url`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `emi_collections`
--
ALTER TABLE `emi_collections`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kycdatas`
--
ALTER TABLE `kycdatas`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `kycs`
--
ALTER TABLE `kycs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kyc_leads`
--
ALTER TABLE `kyc_leads`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `kyc_leads_guarantor`
--
ALTER TABLE `kyc_leads_guarantor`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kyc_processes`
--
ALTER TABLE `kyc_processes`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `kyc_reject_reasons`
--
ALTER TABLE `kyc_reject_reasons`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `loans`
--
ALTER TABLE `loans`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `loan_disbursements`
--
ALTER TABLE `loan_disbursements`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `loan_requests`
--
ALTER TABLE `loan_requests`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `location_data`
--
ALTER TABLE `location_data`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `notes`
--
ALTER TABLE `notes`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT for table `packages`
--
ALTER TABLE `packages`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `packages_image`
--
ALTER TABLE `packages_image`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `payment_modes`
--
ALTER TABLE `payment_modes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `payment_out`
--
ALTER TABLE `payment_out`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `payment_transactions`
--
ALTER TABLE `payment_transactions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pet_category`
--
ALTER TABLE `pet_category`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `referral_code`
--
ALTER TABLE `referral_code`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `refers`
--
ALTER TABLE `refers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `refer_and_earn`
--
ALTER TABLE `refer_and_earn`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `role_models`
--
ALTER TABLE `role_models`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `role_permission`
--
ALTER TABLE `role_permission`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT for table `route_logs`
--
ALTER TABLE `route_logs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `tbl_address`
--
ALTER TABLE `tbl_address`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_booking_log`
--
ALTER TABLE `tbl_booking_log`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbl_cart`
--
ALTER TABLE `tbl_cart`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `tbl_helpers`
--
ALTER TABLE `tbl_helpers`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_notification`
--
ALTER TABLE `tbl_notification`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `tbl_otp`
--
ALTER TABLE `tbl_otp`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=308;

--
-- AUTO_INCREMENT for table `tbl_pet`
--
ALTER TABLE `tbl_pet`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `tbl_pet_bookings`
--
ALTER TABLE `tbl_pet_bookings`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_token`
--
ALTER TABLE `tbl_token`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `tbl_update_profile_request`
--
ALTER TABLE `tbl_update_profile_request`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `t_shirt`
--
ALTER TABLE `t_shirt`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `t_shirt_transaction`
--
ALTER TABLE `t_shirt_transaction`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=128;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
