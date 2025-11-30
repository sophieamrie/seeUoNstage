# seeUoNstage E-Ticketing Event System

A Laravel-based event management and ticket booking platform built for academic purposes. The system supports multiple user roles (Admin, Organizer, Registered User, Guest) and provides end-to-end event and ticket management.

## Features

### User Roles
- **Admin**: Manage users, approve/reject organizers, manage all events, manage tickets, view reports.
- **Event Organizer**: Create and manage their own events, add ticket types, view bookings for their events.
- **Registered User**: Book tickets, cancel bookings (before allowed time), view booking history, view digital tickets, save favorite events.
- **Guest**: Browse events without booking.

### Core Modules
- **User Management (Admin)**: View all users, approve/reject organizer registration.
- **Event Management (Admin & Organizer)**: Create, edit, delete events; upload event images; add ticket types.
- **Ticket Management**: Approve or cancel bookings; booking list per event; admin reports for ticket sales.
- **Booking System (Users)**: Book tickets (quota decreases), cancel bookings (quota restored), booking history, booking details.
- **Favorite Events**: Save and unsave events.

## Pages
- Login / Register
- Homepage with newest events
- Event Catalog (filter by category, location, or date)
- Event Detail page with ticket options
- User Dashboard (profile, favorites, booking history)
- Organizer Dashboard (manage events + view bookings)
- Admin Dashboard (users, events, reports)
- Organizer Pending Page (awaiting approval)

## Requirements
- PHP 8+
- Composer
- Laravel 10+
- MySQL or equivalent
- Node.js + NPM

## Installation

1. Clone repository:
git clone https://github.com/your-username/your-repo.git
cd your-repo

2. Install dependencies:
composer install
npm install && npm run dev

3. Create environment file:
cp .env.example .env
php artisan key:generate

4. Configure database in .env:
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password

5. Run migrations:
php artisan migrate

6. Start local server:
php artisan serve

## Tech Stack
- Laravel 10+
- Blade Templates
- MySQL Database
- TailwindCSS / Bootstrap
- Laravel Breeze Authentication


## License
This project is built for academic and learning purposes.
