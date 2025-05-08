# City Bike

[![PHP](https://img.shields.io/badge/PHP-8.x-blue?logo=php)](https://www.php.net/)
[![Composer](https://img.shields.io/badge/Composer-latest-orange?logo=composer)](https://getcomposer.org/)
[![Node.js](https://img.shields.io/badge/Node.js-LTS-green?logo=node.js)](https://nodejs.org/)
[![MySQL](https://img.shields.io/badge/MySQL-8.x-blue?logo=mysql)](https://www.mysql.com/)

A full-stack web application for exploring city bike stations and trips in the Helsinki Capital area. Built with Vue.js (frontend), PHP (backend), and MySQL.

<p align="center">
  <a href="https://citybike.space" style="display:inline-block;padding:0.6em 1.2em;background-color:#007BFF;color:white;text-decoration:none;border-radius:5px;font-weight:bold;">
    <b style="filter: brightness(0) invert(1);">🚲</b> Visit Website
  </a>
</p>

<p align="center">
  <a href="#1-prerequisites">Prerequisites</a>
  ·
  <a href="#2-clone-the-repository">Clone</a>
  ·
  <a href="#3-setup-the-database">Database Setup</a>
  ·
  <a href="#4-install-backend-dependencies">Backend Setup</a>
  ·
  <a href="#5-install-frontend-dependencies">Frontend Setup</a>
  ·
  <a href="#6-start-the-application">Run App</a>
  ·
  <a href="#features">Features</a>
  ·
  <a href="#screenshots">Screenshots</a>
</p>

## Getting Started

### 1. Prerequisites

Make sure the following tools are installed:

- PHP 8.x
- Composer
- Node.js + npm
- MySQL

```bash
php --version
composer --version
node --version
npm --version
mysql --version
```

Start MySQL server (macOS example):

```bash
brew services start mysql
```

### 2. Clone the Repository

```bash
git clone <repository-url>
cd city-bike
```

### 3. Setup the Database

```bash
cd data
unzip citybike.zip
mysql -u root -p
```

Inside MySQL:

```sql
DROP DATABASE IF EXISTS citybike;
CREATE DATABASE citybike CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
exit;
```

Import SQL dump:

```bash
mysql -u root -p citybike < citybike.sql
```

(Optional) Verify:

```bash
mysql -u root -p
USE citybike;
SHOW TABLES;
SELECT COUNT(*) FROM stations;
SELECT COUNT(*) FROM trips;
exit;
```

### 4. Install Backend Dependencies

```bash
cd ../backend
composer install
```

### 5. Install Frontend Dependencies

```bash
cd ../frontend
npm install
```

### 6. Start the Application

Use two terminal windows:

- Frontend (Vite):

  ```bash
  cd frontend
  npm run dev
  ```

- Backend (PHP):

  ```bash
  php -S localhost:8080 frontend/public/api.php
  ```

App available at [http://localhost:5173](http://localhost:5173)

## Technologies Used

- **Vue.js 3** – Frontend framework
- **Leaflet** – Interactive map
- **Axios** – HTTP client
- **PHP 8.x** – Backend logic
- **MySQL 8.x** – Database
- **Composer** – PHP dependency manager

## Features

- Preloaded MySQL dump
- List, search, sort and paginate stations and trips
- Detailed station statistics
- Add new stations and trips
- Map view with Leaflet

## Screenshots

### Station List View

![Stations List View](media/stations.png)

### Trip List View

![Trip List View](media/trips.png)

### Single Station View

![Single Station View](media/station.png)

### New Trip Creation

![New Trip Creation](media/new-trip.png)

## Acknowledgments

Data provided by City Bike Finland and HSL:  
[https://www.avoindata.fi/data/en/dataset/hsl-n-kaupunkipyoraasemat/resource/a23eef3a-cc40-4608-8aa2-c730d17e8902](https://www.avoindata.fi/data/en/dataset/hsl-n-kaupunkipyoraasemat/resource/a23eef3a-cc40-4608-8aa2-c730d17e8902)
