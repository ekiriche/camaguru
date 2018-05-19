<?php
include('database.php');

try {
	$db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$sql = "CREATE DATABASE IF NOT EXISTS camagru";
	$db->query($sql);
	$sql = "use camagru";
	$db->query($sql);
	$sql = "CREATE TABLE IF NOT EXISTS `users` (
		`id` INT(11) AUTO_INCREMENT PRIMARY KEY NOT NULL,
		`login` TEXT NOT NULL,
		`email` TEXT NOT NULL,
		`password` TEXT NOT NULL,
		`is_authorised` tinyint(1) DEFAULT 0 NOT NULL,
		`notifications` tinyint(1) DEFAULT 1 NOT NULL,
		`reg_link` TEXT NOT NULL
	)";
	$db->query($sql);
	$sql = "CREATE TABLE IF NOT EXISTS `comments` (
		`id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		`user_id` int(11) NOT NULL,
		`login` text NOT NULL,
		`image_id` int(11) NOT NULL,
		`date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
		`comment` text NOT NULL
	)";
	$db->query($sql);
	$sql = "CREATE TABLE IF NOT EXISTS `images` (
		`id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		`user_id` int(11) NOT NULL,
		`image_path` text NOT NULL,
		`likes` int(11) NOT NULL DEFAULT '0',
		`date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
	)";
	$db->query($sql);
	$sql = "CREATE TABLE IF NOT EXISTS `likes` (
		`id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		`user_id` int(11) NOT NULL,
		`login` text NOT NULL,
		`image_id` int(11) NOT NULL
	)";
	$db->query($sql);
} catch (PDOException $e) {
	echo "Mission failed:" . $e->getMessage();
}
