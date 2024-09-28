# Library Management API

This is a simple RESTful API for managing authors and books, built with Laravel 11. It demonstrates clean code structure, design patterns, caching for performance optimization, and unit testing.

## Table of Contents

- [Features](#features)
- [Installation](#installation)
- [Usage](#usage)
- [Running Tests](#running-tests)
- [Design and Performance](#design-and-performance)
- [API Documentation](#api-documentation)

## Features

- **Authors CRUD**: Create, update, retrieve, and delete authors.
- **Books CRUD**: Create, update, retrieve, and delete books.
- **Author's Books**: Retrieve all books for a specific author.
- **Caching**: Frequently accessed data is cached to improve performance.

## Installation

1. Clone the repository:
   ```bash
   git clone https://github.com/agusgokasi/Library-API-Laravel.git

2. Navigate to the project directory:
   ```bash
   cd Library-API-Laravel

3. Install the dependencies:
   ```bash
   composer install

4. Copy the .env.example file to .env:
    ```bash
    cp .env.example .env

5. Configure your environment variables in the .env file:
    - Set your database connection.
    - For example:
    ```bash
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=library_db
    DB_USERNAME=root
    DB_PASSWORD=

6. Generate the application key:
    ```bash
    php artisan key:generate

7.  Run the database migrations:
    ```bash
    php artisan migrate

8. (Optional) Seed the database with dummy data:
    ```bash
    php artisan db:seed

## Usage

You can now access the API by running:

    php artisan serve
    
The API will be available at http://127.0.0.1:8000. You can access the following routes:
- GET /api/authors: List all authors.
- POST /api/authors: Create a new author.
- GET /api/authors/{id}: Retrieve an author by ID.
- PUT /api/authors/{id}: Update an author by ID.
- DELETE /api/authors/{id}: Delete an author by ID.
- GET /api/authors/{id}/books: Retrieve all books by a specific author.
- GET /api/books: List all books.
- POST /api/books: Create a new book.
- GET /api/books/{id}: Retrieve a book by ID.
- PUT /api/books/{id}: Update a book by ID.
- DELETE /api/books/{id}: Delete a book by ID.

## Running Tests

Unit tests are included in the repository to ensure the functionality of the API, including the service layer and caching logic.

To run the tests:

1. Run the tests using PHPUnit:
   ```bash
   php artisan test

This will execute the tests found in the tests/Unit directory, covering all CRUD operations for authors and books, as well as caching and performance optimizations.

## Design and Performance

For more details on how the application was structured and optimized, see the [Design and Performance Tuning Write-Up](./Design%20and%20Performance%20Tuning%20Write-Up.md).

## API Documentation

You can find the full API documentation, including request details and example responses, in the Postman documentation:

[Library Management API Documentation](https://documenter.getpostman.com/view/14855183/2sAXqy2yar)
