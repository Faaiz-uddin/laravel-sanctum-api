# 🔐 Laravel 12 Sanctum API

A secure and modular RESTful API built with **Laravel 12** using **Laravel Sanctum** for token-based authentication. This API is ideal for powering SPAs, mobile apps, or any frontend clients needing authentication and protected data access.

---

## 🚀 Features

- ✅ Built with Laravel 12
- 🔐 API authentication using Laravel Sanctum
- 📝 User registration and login
- 🔄 Issue & revoke tokens
- 🔒 Protected API routes using middleware
- 📁 CRUD operations for `Post` model
- 🧼 Clean and scalable code structure

---

## 🛠️ Tech Stack

- Laravel 12
- Sanctum
- MySQL (or SQLite)
- PHP 8.2+
- Postman (for testing)

---

## ⚙️ Installation

Follow these steps to set up the project locally:

```bash
# 1. Clone the repository
git clone https://github.com/your-username/laravel-12-sanctum-api.git
cd laravel-12-sanctum-api

# 2. Install dependencies
composer install

# 3. Create environment file
cp .env.example .env

# 4. Generate application key
php artisan key:generate

# 5. Configure your database in the .env file

# 6. Run database migrations
php artisan migrate

# 7. Serve the application
php artisan serve
