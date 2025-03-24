## customer-care-api 

# Client Query Management API

## 🌍 Project Overview

This project aims to create an advanced and well-documented API for businesses to manage and centralize customer queries effectively. The API is designed using Laravel, with additional features such as API documentation via Swagger, secure authentication via Laravel Sanctum, and frontend consumption using a JavaScript framework of your choice.

## 📚 Project Goals

- Build an advanced API using Laravel.
- Document the API with Swagger.
- Implement unit and functional tests with PHPUnit.
- Organize code using the Service Layer Design Pattern.
- Manage API requests effectively with pagination, filters, and sorting.
- Secure authentication and authorization using Laravel Sanctum.
- Frontend API consumption with a JS framework (your choice).

## 🛠️ Requirements

Before installing the project, ensure that the following software is installed:

- [PHP](https://www.php.net/) (Version 8.2 or above)
- [Composer](https://getcomposer.org/) (PHP Dependency Manager)
- [Laravel](https://laravel.com/) (Version 11 or above)
- [Node.js](https://nodejs.org/) (For frontend, if needed)
- [PostgreSQL](https://www.mysql.com/) or any supported database
- [Postman](https://www.postman.com/) for API testing (optional but recommended)

## ⚡ Installation Steps

Follow these steps to install and run the project locally:

### 1. Clone the repository

```bash
git clone https://github.com/Youcode-Classe-E-2024-2025/ahmed_taoudi-CustomerCareAPI.git

cd ahmed_taoudi-CustomerCareAPI
```

### 2. Install PHP Dependencies

Run the following command to install Laravel dependencies using Composer:

```bash
composer install
```

### 3. Set Up Environment Configuration

Copy the `.env.example` file to `.env` and configure the database and other environment variables:

```bash
cp .env.example .env
```

Make sure to configure the following in the `.env` file:

- `DB_CONNECTION=pgsql`
- `DB_HOST=127.0.0.1`
- `DB_PORT=5432`
- `DB_DATABASE=your_database_name`
- `DB_USERNAME=your_database_user`
- `DB_PASSWORD=your_database_password`

### 4. Generate Application Key

Run the following command to generate the application key:

```bash
php artisan key:generate
```

### 5. Run Database Migrations

Run the database migrations to set up the necessary tables:

```bash
php artisan migrate
```

### 6. Install Node.js Dependencies (If Applicable)

If you are using a JavaScript framework for the frontend, install Node.js dependencies:

```bash
npm install
```

### 7. Serve the Application

Run the Laravel development server:

```bash
php artisan serve
```

You should now be able to access the API at `http://127.0.0.1:8000`.

## 🔄 API Documentation

The API is documented with [Swagger](https://swagger.io/tools/swagger-ui/). To view the documentation, visit:

```text
http://127.0.0.1:8000/api/documentation
```

## 🔒 Authentication

This API uses [Laravel Sanctum](https://laravel.com/docs/8.x/sanctum) for authentication. To authenticate, follow these steps:

1. Create a new user via the `POST /api/register` endpoint.
2. Login using the `POST /api/login` endpoint to receive a token.
3. Use the token in the Authorization header for subsequent requests.

## 🧪 Testing

Run the unit and functional tests using PHPUnit:

```bash
php artisan test
```

## 🧑‍💻 Frontend Integration

If you wish to integrate this API with a frontend, you can use any JavaScript framework (e.g., React, Vue, Angular). Use the appropriate API endpoints for your frontend to consume the API.

## 📦 Project Structure

Here is an overview of the project structure:

```
/app
  /Http
    /Controllers - Contains controllers for API logic
  /Models - Contains Eloquent models for User, Ticket, and Response
  /Services - Service Layer for business logic
/database
  /migrations - Database migrations
/routes
  api.php - Defines API routes
/public
  /swagger - Swagger documentation
```

## 🚀 Next Steps

1. Enhance API functionality (e.g., add more endpoints, advanced filtering).
2. Expand API documentation in Swagger.
3. Develop frontend using your preferred JavaScript framework.

## 📜 License

This project is open source and available under the [MIT License](LICENSE).

---

**Contributors:**
- Ahmed Taoudi

For any issues or questions, please feel free to open an issue on GitHub or contact the project maintainers.
