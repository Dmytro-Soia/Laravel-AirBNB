# NFAirBNB — Apartment Rental Platform

Platform for short-and-long-term homestays, in various countries and regions. Users can create, edit and delete their 
accounts, apartment listings and bookings. Admins have additional privileges to manage user's accounts and apartments.

## Features
- User authentication (_registration, login, logout_)
- Apartment listings management (_update title, description and all detailed info, change images and change location_)
- User profile management (_update username, email, and profile picture_)
- Admin panel for managing admins roles
- Flash messages for user feedback

## Technology used


- Framework
  - Laravel: for creating PHP web-application with MVC-structure


- Languages:
  - PHP: backend logic and database interaction
  - Blade(Laravel) : for template creation
  - HTML/CSS: frontend structure and styling
  - JavaScript: client-side interactions
  

- Database
    - PostgreSQL: Database for storing users, user's apartment listings and bookings.


- APIs & Libraries:
  - Google Maps JavaScript API: map rendering and user interaction
  - Geocoding API: address-to coordinate and coordinate-to-address conversion
  - Flowbite: tailwind-based UI component library
  - Flatpickr: lightweight date/time picker

## Setup
1) Install [PHP](https://www.php.net/downloads.php), [Docker](https://docs.docker.com/desktop/) and [Composer](https://getcomposer.org/download/) on your system 
2) Clone the Repository:
   ```bash
   git clone git@github.com:Dmytro-Soia/Laravel-AirBNB.git
   cd Laravel-AirBNB
   ```
3) Install dependencies:
    ```bash
   composer install
   ```
4) Install Laravel Sail:
   ```bash
   php artisan sail:install
   ```
5) Run Docker-container with the application:
   ```bash
   ./vendor/bin/sail up
   ```
6) Install JavaScript dependencies:
   ```bash
   npm install
   npm run dev
   ```
7) Run database migrations:
   ```bash
   ./vendor/bin/sail artisan migrate
   ```
8) Open web-application in a browser:
   http://localhost/
