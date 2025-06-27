<?php

namespace Modules\Users\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Modules\Users\Models\Admin;
use Modules\Users\Models\User;

class UsersDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->createSuperAdminRule();

        User::factory()
            ->admin()
            ->male()
            ->create([
                "name" => "Ahmed Adel",
                "email" => "ahmdadl.dev@gmail.com",
                "password" => Hash::make("123123123"),
            ]);

        $admin = User::factory()
            ->admin()
            ->male()
            ->create([
                "name" => "Ahmed Admin",
                "email" => "admin@gmail.com",
                "password" => Hash::make("123123123"),
            ]);

        User::factory()
            ->customer()
            ->male()
            ->create([
                "name" => "Ahmed Customer",
                "email" => "ahmdadl@gmail.com",
                "password" => Hash::make("123123123"),
            ]);

        DB::table("model_has_roles")->insert([
            "role_id" => DB::table("roles")
                ->where("name", "super_admin")
                ->first()->id,
            "model_type" => Admin::class,
            "model_id" => $admin->id,
        ]);
    }

    private function createSuperAdminRule()
    {
        DB::unprepared("-- Adminer 4.8.4 MySQL 11.4.3-MariaDB dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `permissions`;
CREATE TABLE `permissions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1,	'view_admin',	'admin',	'2025-06-27 17:04:35',	'2025-06-27 17:04:35'),
(2,	'create_admin',	'admin',	'2025-06-27 17:04:35',	'2025-06-27 17:04:35'),
(3,	'update_admin',	'admin',	'2025-06-27 17:04:35',	'2025-06-27 17:04:35'),
(4,	'delete_admin',	'admin',	'2025-06-27 17:04:35',	'2025-06-27 17:04:35'),
(5,	'view_banner',	'admin',	'2025-06-27 17:04:35',	'2025-06-27 17:04:35'),
(6,	'create_banner',	'admin',	'2025-06-27 17:04:35',	'2025-06-27 17:04:35'),
(7,	'update_banner',	'admin',	'2025-06-27 17:04:35',	'2025-06-27 17:04:35'),
(8,	'delete_banner',	'admin',	'2025-06-27 17:04:35',	'2025-06-27 17:04:35'),
(9,	'restore_banner',	'admin',	'2025-06-27 17:04:35',	'2025-06-27 17:04:35'),
(10,	'replicate_banner',	'admin',	'2025-06-27 17:04:35',	'2025-06-27 17:04:35'),
(11,	'view_brand',	'admin',	'2025-06-27 17:04:35',	'2025-06-27 17:04:35'),
(12,	'create_brand',	'admin',	'2025-06-27 17:04:35',	'2025-06-27 17:04:35'),
(13,	'update_brand',	'admin',	'2025-06-27 17:04:35',	'2025-06-27 17:04:35'),
(14,	'delete_brand',	'admin',	'2025-06-27 17:04:35',	'2025-06-27 17:04:35'),
(15,	'restore_brand',	'admin',	'2025-06-27 17:04:35',	'2025-06-27 17:04:35'),
(16,	'replicate_brand',	'admin',	'2025-06-27 17:04:35',	'2025-06-27 17:04:35'),
(17,	'view_category',	'admin',	'2025-06-27 17:04:35',	'2025-06-27 17:04:35'),
(18,	'create_category',	'admin',	'2025-06-27 17:04:35',	'2025-06-27 17:04:35'),
(19,	'update_category',	'admin',	'2025-06-27 17:04:35',	'2025-06-27 17:04:35'),
(20,	'delete_category',	'admin',	'2025-06-27 17:04:35',	'2025-06-27 17:04:35'),
(21,	'restore_category',	'admin',	'2025-06-27 17:04:35',	'2025-06-27 17:04:35'),
(22,	'replicate_category',	'admin',	'2025-06-27 17:04:35',	'2025-06-27 17:04:35'),
(23,	'view_city',	'admin',	'2025-06-27 17:04:35',	'2025-06-27 17:04:35'),
(24,	'create_city',	'admin',	'2025-06-27 17:04:35',	'2025-06-27 17:04:35'),
(25,	'update_city',	'admin',	'2025-06-27 17:04:35',	'2025-06-27 17:04:35'),
(26,	'delete_city',	'admin',	'2025-06-27 17:04:35',	'2025-06-27 17:04:35'),
(27,	'restore_city',	'admin',	'2025-06-27 17:04:35',	'2025-06-27 17:04:35'),
(28,	'replicate_city',	'admin',	'2025-06-27 17:04:35',	'2025-06-27 17:04:35'),
(29,	'view_contact::us::message',	'admin',	'2025-06-27 17:04:35',	'2025-06-27 17:04:35'),
(30,	'reply_contact::us::message',	'admin',	'2025-06-27 17:04:35',	'2025-06-27 17:04:35'),
(31,	'delete_contact::us::message',	'admin',	'2025-06-27 17:04:35',	'2025-06-27 17:04:35'),
(32,	'restore_contact::us::message',	'admin',	'2025-06-27 17:04:35',	'2025-06-27 17:04:35'),
(33,	'view_coupon',	'admin',	'2025-06-27 17:04:35',	'2025-06-27 17:04:35'),
(34,	'create_coupon',	'admin',	'2025-06-27 17:04:35',	'2025-06-27 17:04:35'),
(35,	'update_coupon',	'admin',	'2025-06-27 17:04:35',	'2025-06-27 17:04:35'),
(36,	'delete_coupon',	'admin',	'2025-06-27 17:04:35',	'2025-06-27 17:04:35'),
(37,	'restore_coupon',	'admin',	'2025-06-27 17:04:35',	'2025-06-27 17:04:35'),
(38,	'replicate_coupon',	'admin',	'2025-06-27 17:04:35',	'2025-06-27 17:04:35'),
(39,	'view_customer',	'admin',	'2025-06-27 17:04:35',	'2025-06-27 17:04:35'),
(40,	'create_customer',	'admin',	'2025-06-27 17:04:35',	'2025-06-27 17:04:35'),
(41,	'update_customer',	'admin',	'2025-06-27 17:04:35',	'2025-06-27 17:04:35'),
(42,	'delete_customer',	'admin',	'2025-06-27 17:04:35',	'2025-06-27 17:04:35'),
(43,	'view_faq',	'admin',	'2025-06-27 17:04:35',	'2025-06-27 17:04:35'),
(44,	'create_faq',	'admin',	'2025-06-27 17:04:35',	'2025-06-27 17:04:35'),
(45,	'update_faq',	'admin',	'2025-06-27 17:04:35',	'2025-06-27 17:04:35'),
(46,	'delete_faq',	'admin',	'2025-06-27 17:04:35',	'2025-06-27 17:04:35'),
(47,	'restore_faq',	'admin',	'2025-06-27 17:04:35',	'2025-06-27 17:04:35'),
(48,	'reorder_faq',	'admin',	'2025-06-27 17:04:35',	'2025-06-27 17:04:35'),
(49,	'view_faq::category',	'admin',	'2025-06-27 17:04:35',	'2025-06-27 17:04:35'),
(50,	'create_faq::category',	'admin',	'2025-06-27 17:04:35',	'2025-06-27 17:04:35'),
(51,	'update_faq::category',	'admin',	'2025-06-27 17:04:35',	'2025-06-27 17:04:35'),
(52,	'delete_faq::category',	'admin',	'2025-06-27 17:04:35',	'2025-06-27 17:04:35'),
(53,	'restore_faq::category',	'admin',	'2025-06-27 17:04:35',	'2025-06-27 17:04:35'),
(54,	'reorder_faq::category',	'admin',	'2025-06-27 17:04:35',	'2025-06-27 17:04:35'),
(55,	'view_government',	'admin',	'2025-06-27 17:04:35',	'2025-06-27 17:04:35'),
(56,	'create_government',	'admin',	'2025-06-27 17:04:35',	'2025-06-27 17:04:35'),
(57,	'update_government',	'admin',	'2025-06-27 17:04:35',	'2025-06-27 17:04:35'),
(58,	'delete_government',	'admin',	'2025-06-27 17:04:35',	'2025-06-27 17:04:35'),
(59,	'restore_government',	'admin',	'2025-06-27 17:04:35',	'2025-06-27 17:04:35'),
(60,	'replicate_government',	'admin',	'2025-06-27 17:04:35',	'2025-06-27 17:04:35'),
(61,	'view_order',	'admin',	'2025-06-27 17:04:35',	'2025-06-27 17:04:35'),
(62,	'change-status_order',	'admin',	'2025-06-27 17:04:35',	'2025-06-27 17:04:35'),
(63,	'create_page::meta',	'admin',	'2025-06-27 17:04:35',	'2025-06-27 17:04:35'),
(64,	'update_page::meta',	'admin',	'2025-06-27 17:04:35',	'2025-06-27 17:04:35'),
(65,	'delete_page::meta',	'admin',	'2025-06-27 17:04:35',	'2025-06-27 17:04:35'),
(66,	'replicate_page::meta',	'admin',	'2025-06-27 17:04:35',	'2025-06-27 17:04:35'),
(67,	'view_privacy::policy',	'admin',	'2025-06-27 17:04:35',	'2025-06-27 17:04:35'),
(68,	'create_privacy::policy',	'admin',	'2025-06-27 17:04:35',	'2025-06-27 17:04:35'),
(69,	'update_privacy::policy',	'admin',	'2025-06-27 17:04:35',	'2025-06-27 17:04:35'),
(70,	'delete_privacy::policy',	'admin',	'2025-06-27 17:04:35',	'2025-06-27 17:04:35'),
(71,	'replicate_privacy::policy',	'admin',	'2025-06-27 17:04:35',	'2025-06-27 17:04:35'),
(72,	'view_product',	'admin',	'2025-06-27 17:04:35',	'2025-06-27 17:04:35'),
(73,	'create_product',	'admin',	'2025-06-27 17:04:35',	'2025-06-27 17:04:35'),
(74,	'update_product',	'admin',	'2025-06-27 17:04:35',	'2025-06-27 17:04:35'),
(75,	'delete_product',	'admin',	'2025-06-27 17:04:35',	'2025-06-27 17:04:35'),
(76,	'restore_product',	'admin',	'2025-06-27 17:04:35',	'2025-06-27 17:04:35'),
(77,	'replicate_product',	'admin',	'2025-06-27 17:04:35',	'2025-06-27 17:04:35'),
(78,	'view_role',	'admin',	'2025-06-27 17:04:35',	'2025-06-27 17:04:35'),
(79,	'view_any_role',	'admin',	'2025-06-27 17:04:35',	'2025-06-27 17:04:35'),
(80,	'create_role',	'admin',	'2025-06-27 17:04:35',	'2025-06-27 17:04:35'),
(81,	'update_role',	'admin',	'2025-06-27 17:04:35',	'2025-06-27 17:04:35'),
(82,	'delete_role',	'admin',	'2025-06-27 17:04:35',	'2025-06-27 17:04:35'),
(83,	'delete_any_role',	'admin',	'2025-06-27 17:04:35',	'2025-06-27 17:04:35'),
(84,	'view_setting',	'admin',	'2025-06-27 17:04:35',	'2025-06-27 17:04:35'),
(85,	'create_setting',	'admin',	'2025-06-27 17:04:35',	'2025-06-27 17:04:35'),
(86,	'update_setting',	'admin',	'2025-06-27 17:04:35',	'2025-06-27 17:04:35'),
(87,	'delete_setting',	'admin',	'2025-06-27 17:04:35',	'2025-06-27 17:04:35'),
(88,	'view_tag',	'admin',	'2025-06-27 17:04:35',	'2025-06-27 17:04:35'),
(89,	'create_tag',	'admin',	'2025-06-27 17:04:35',	'2025-06-27 17:04:35'),
(90,	'update_tag',	'admin',	'2025-06-27 17:04:35',	'2025-06-27 17:04:35'),
(91,	'delete_tag',	'admin',	'2025-06-27 17:04:35',	'2025-06-27 17:04:35'),
(92,	'restore_tag',	'admin',	'2025-06-27 17:04:35',	'2025-06-27 17:04:35'),
(93,	'replicate_tag',	'admin',	'2025-06-27 17:04:35',	'2025-06-27 17:04:35'),
(94,	'create_term',	'admin',	'2025-06-27 17:04:35',	'2025-06-27 17:04:35'),
(95,	'update_term',	'admin',	'2025-06-27 17:04:35',	'2025-06-27 17:04:35'),
(96,	'delete_term',	'admin',	'2025-06-27 17:04:35',	'2025-06-27 17:04:35'),
(97,	'replicate_term',	'admin',	'2025-06-27 17:04:35',	'2025-06-27 17:04:35'),
(98,	'reorder_term',	'admin',	'2025-06-27 17:04:35',	'2025-06-27 17:04:35'),
(99,	'view_user',	'admin',	'2025-06-27 17:04:35',	'2025-06-27 17:04:35'),
(100,	'create_user',	'admin',	'2025-06-27 17:04:35',	'2025-06-27 17:04:35'),
(101,	'update_user',	'admin',	'2025-06-27 17:04:35',	'2025-06-27 17:04:35'),
(102,	'delete_user',	'admin',	'2025-06-27 17:04:35',	'2025-06-27 17:04:35'),
(103,	'create_wallet',	'admin',	'2025-06-27 17:04:35',	'2025-06-27 17:04:35'),
(104,	'update_wallet',	'admin',	'2025-06-27 17:04:35',	'2025-06-27 17:04:35'),
(105,	'credit_wallet',	'admin',	'2025-06-27 17:04:35',	'2025-06-27 17:04:35'),
(106,	'debit_wallet',	'admin',	'2025-06-27 17:04:35',	'2025-06-27 17:04:35'),
(107,	'change_wallet_transaction_status_wallet::transaction',	'admin',	'2025-06-27 17:04:35',	'2025-06-27 17:04:35'),
(108,	'view_payment_attempts_wallet::transaction',	'admin',	'2025-06-27 17:04:35',	'2025-06-27 17:04:35'),
(109,	'widget_RevenueStatsWidget',	'admin',	'2025-06-27 17:04:35',	'2025-06-27 17:04:35'),
(110,	'widget_OrdersStatsWidget',	'admin',	'2025-06-27 17:04:35',	'2025-06-27 17:04:35'),
(111,	'widget_CustomersStatsWidget',	'admin',	'2025-06-27 17:04:35',	'2025-06-27 17:04:35'),
(112,	'widget_CatalogViewsStatsWidget',	'admin',	'2025-06-27 17:04:35',	'2025-06-27 17:04:35');

DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1,	'super_admin',	'admin',	'2025-06-27 17:04:35',	'2025-06-27 17:04:35');

DROP TABLE IF EXISTS `role_has_permissions`;
CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) unsigned NOT NULL,
  `role_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1,	1),
(2,	1),
(3,	1),
(4,	1),
(5,	1),
(6,	1),
(7,	1),
(8,	1),
(9,	1),
(10,	1),
(11,	1),
(12,	1),
(13,	1),
(14,	1),
(15,	1),
(16,	1),
(17,	1),
(18,	1),
(19,	1),
(20,	1),
(21,	1),
(22,	1),
(23,	1),
(24,	1),
(25,	1),
(26,	1),
(27,	1),
(28,	1),
(29,	1),
(30,	1),
(31,	1),
(32,	1),
(33,	1),
(34,	1),
(35,	1),
(36,	1),
(37,	1),
(38,	1),
(39,	1),
(40,	1),
(41,	1),
(42,	1),
(43,	1),
(44,	1),
(45,	1),
(46,	1),
(47,	1),
(48,	1),
(49,	1),
(50,	1),
(51,	1),
(52,	1),
(53,	1),
(54,	1),
(55,	1),
(56,	1),
(57,	1),
(58,	1),
(59,	1),
(60,	1),
(61,	1),
(62,	1),
(63,	1),
(64,	1),
(65,	1),
(66,	1),
(67,	1),
(68,	1),
(69,	1),
(70,	1),
(71,	1),
(72,	1),
(73,	1),
(74,	1),
(75,	1),
(76,	1),
(77,	1),
(78,	1),
(79,	1),
(80,	1),
(81,	1),
(82,	1),
(83,	1),
(84,	1),
(85,	1),
(86,	1),
(87,	1),
(88,	1),
(89,	1),
(90,	1),
(91,	1),
(92,	1),
(93,	1),
(94,	1),
(95,	1),
(96,	1),
(97,	1),
(98,	1),
(99,	1),
(100,	1),
(101,	1),
(102,	1),
(103,	1),
(104,	1),
(105,	1),
(106,	1),
(107,	1),
(108,	1),
(109,	1),
(110,	1),
(111,	1),
(112,	1);

-- 2025-06-27 20:05:11");
    }
}
