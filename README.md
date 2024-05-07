# eventplannerwebsite
An interactive website for special events

## Overview

The Event Planner Website is a web application designed to provide an intuitive platform for users to manage a Future Events. This repository contains the code and resources for setting up the system, which features user registration and login, event management, and CRUD (Create, Read, Update, Delete) operations on event entries.

## Features

- User Authentication: Secure signup and login process.
- Event Management: Add, view, update, and delete events.
- Categorization: Organize events by location or type.
- Search Functionality: Dynamic searching and filtering of event entries.

## Technology Stack

- Front-End: HTML, CSS, JavaScript
- Back-End: PHP for server-side logic
- Database: MySQL for data storage

### Welcome Page
Here users can choose to sign up or log in if they have an account.

### Sign Up Page
New users can create an account using a registration form.

### Events Page
The main page where users can browse, create, RSVP and edit Events. This page only available to users that are logged in as a user.
A user is not allowed to edit or delete an Event that if they are not the owner but can RSVP to any event.

### Contact Page
This page is for users or potential users to contact us with any questions, concerns or suggestions.

### Edit Details
Users can view edit the Event details here. (max number of guests, location, date etc...)

### Responsive Search Feature
Quickly find events with our responsive search bar, optimized to search by event type or location.

### Database Interface (XAMPP)
This is the database view where all events are listed with their details.

## Installation

1. Clone the repository to your local machine.
2. Set up a web server like Apache and point the document root to the cloned directory.
3. Import the provided SQL script into your MySQL database to create the required tables and seed some initial data.
4. Configure your database connection by editing the relevant PHP files with your MySQL credentials.

## Configuration

Edit the **`conn.php`** file to set up your database connection:



## Usage

Navigate to the home page and sign up for an account. Once logged in, you will be able to manage events and perform operations.

## License

This project is open-sourced under the MIT License.
