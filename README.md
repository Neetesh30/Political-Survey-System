# Political Survey Management System

A Laravel-based survey management platform designed for large-scale political data collection and analysis.

## Features

- Survey creation and management
- Dynamic questionnaire builder
- Booth-wise voter segmentation
- Survey response collection
- Dashboard and analytics
- Role-based access control
- Excel/CSV import and export
- Reporting module
- REST APIs

## Tech Stack

- Laravel 11
- PHP 8.3
- MySQL
- Bootstrap
- jQuery

## Database Design

- Users
- Surveys
- Questions
- Responses
- Constituencies

## Installation

```bash
git clone ...
composer install
cp .env.example .env
php artisan migrate
php artisan serve