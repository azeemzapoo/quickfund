QuickFund is a Laravel application for student micro-crowdfunding and collaboration. Users can publish ideas, browse public ideas, support or invest in projects, and join teams as contributors.

## Stack

- PHP 8.2+
- Laravel 12
- Laravel Breeze
- Blade
- MySQL
- Tailwind CSS
- Alpine.js
- Vite

## Features

- Public home page.
- Public idea listing and idea detail pages.
- Authentication with register, login, logout, and profile management.
- Idea CRUD with owner-only edit/delete access.
- Pledges/supports for ideas.
- Investments for ideas.
- Contributor applications with roles.
- User dashboard with activity summary.
- Validation for funding limits and form input.

## Access Rules

Public:

- `GET /`
- `GET /ideas`
- `GET /ideas/{id}`

Authenticated:

- `GET /dashboard`
- `GET /profile`
- `GET /ideas/create`
- `POST /ideas`
- `GET /ideas/{id}/edit`
- `PUT /ideas/{id}`
- `DELETE /ideas/{id}`
- `POST /pledges`
- `POST /investments`
- `POST /contributions`

## Data Model

Main models:

- `User`
- `Idea`
- `Pledge`
- `Investment`
- `Contribution`

Relationships:

- `User hasMany Idea`
- `Idea belongsTo User`
- `Idea hasMany Pledge`
- `Idea hasMany Investment`
- `Idea hasMany Contribution`
- `Pledge belongsTo User` and `Idea`
- `Investment belongsTo User` and `Idea`
- `Contribution belongsTo User` and `Idea`

## Setup

Install dependencies:

```bash
composer install
npm install
```

Create environment file:


Configure database in `.env`:


Run migrations and seeders:

```bash
php artisan migrate
php artisan db:seed
```

Start the app:

```bash
php artisan serve
npm run dev
```

App URL:

```text
http://127.0.0.1:8000
```

