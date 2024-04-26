-- Create the event database with utf8mb4 character set and general collation
CREATE DATABASE `event_db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

-- Create the user table
CREATE TABLE `user` (
    `id` int(10) NOT NULL AUTO_INCREMENT, -- User ID, auto-incremented primary key
    `fullname` varchar(255) NOT NULL, -- User's full name
    `email` varchar(255) NOT NULL, -- User's email address
    `password` varchar(255) NOT NULL, -- User's password
    PRIMARY KEY (`id`) -- Define primary key constraint on 'id'
) ENGINE=InnoDB; -- Use InnoDB engine for transaction support

-- Create the event table
CREATE TABLE `event` (
    `id` int(10) NOT NULL AUTO_INCREMENT, -- Event ID, auto-incremented primary key
    `name` varchar(255) NOT NULL DEFAULT '', -- Event name
    `datetime` bigint, -- Event date and time (timestamp)
    `location` varchar(255), -- Event location
    `maxguests` int(3), -- Maximum number of guests for the event
    `type` varchar(255), -- Event type
    `createdby` int(10), -- ID of the user who created the event
    PRIMARY KEY (`id`) -- Define primary key constraint on 'id'
) ENGINE=InnoDB; -- Use InnoDB engine for transaction support

-- Create the RSVP table
CREATE TABLE `rsvp` (
    `id` int(10) NOT NULL AUTO_INCREMENT, -- RSVP ID, auto-incremented primary key
    `user_id` int(10) NOT NULL, -- ID of the user RSVPing
    `event_id` int(10) NOT NULL, -- ID of the event being RSVP'd to
    PRIMARY KEY (`id`), -- Define primary key constraint on 'id'
    FOREIGN KEY (`user_id`) REFERENCES `user`(`id`) ON DELETE CASCADE, -- Foreign key constraint referencing user table
    FOREIGN KEY (`event_id`) REFERENCES `event`(`id`) ON DELETE CASCADE -- Foreign key constraint referencing event table
) ENGINE=InnoDB; -- Use InnoDB engine for transaction support
