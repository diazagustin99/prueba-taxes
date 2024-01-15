<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# TEST-TAXES


## Prerequisites

Make sure you have the following prerequisites installed on your local machine:

- [Docker](https://www.docker.com/get-started)
- [Docker Compose](https://docs.docker.com/compose/install/)
- [Git](https://git-scm.com/book/en/v2/Getting-Started-Installing-Git)

## Usage Instructions

```bash
# Clone the Repository
git clone https://github.com/diazagustin99/prueba-taxes.git
```
```bash
# Navigate to the Project Directory
cd your-project
```
```bash
# Copy the Environment File
cp .env.example .env
```

> [!CAUTION]
> It is recommended to run in Linux or macOS environments; if used on Windows, it should be done through WSL (Windows Subsystem for Linux).

```bash
# Start Containers with Laravel Sail
./vendor/bin/sail up
```
```bash
# Install Composer Dependencies
./vendor/bin/sail composer install
```
```bash
# Generate JWT Keys
./vendor/bin/sail artisan jwt:secret
```
```bash
# Generate Application Key
./vendor/bin/sail artisan key:generate
```
```bash
# Run Migrations and Seeders
./vendor/bin/sail artisan migrate --seed
```
```bash
# Access the API: http://localhost
```
```bash
# Stop Containers
./vendor/bin/sail down
```

# API Documentation 

## Users

### Login
- **Method:** `POST`
- **Endpoint:** `/users/login`
- **Description:** Logs in a user and returns an access token.
- **Parameters:**
  - `email` (string, required): User's email address.
  - `password` (string, required): User's password.
- **Response:**
  - `access_token` (string): JWT access token.
  - `token_type` (string): Token type (bearer).

### Register
- **Method:** `POST`
- **Endpoint:** `/users/register`
- **Description:** Registers a new user and returns user details along with an access token.
- **Parameters:**
  - `name` (string, required): User's name.
  - `email` (string, required, unique): User's email address.
  - `password` (string, required, min:6): User's password.
- **Response:**
  - `message` (string): Success message.
  - `user` (object): User details.
  - `token` (string): JWT access token.

### Me
- **Method:** `GET`
- **Endpoint:** `/users/me`
- **Description:** Retrieves the details of the authenticated user.
- **Authentication:** Requires a valid JWT token.
- **Response:**
  - User details.

## Books

### Get All Books
- **Method:** `GET`
- **Endpoint:** `/books/all`
- **Description:** Retrieves all books.
- **Response:**
  - List of books.

### Search Books
- **Method:** `GET`
- **Endpoint:** `/books/search`
- **Description:** Searches for books based on title, author, and publication date.
- **Parameters:**
  - `title` (string): Book title.
  - `author` (string): Book author.
  - `publication_date` (string): Book publication date (format: 'YYYY-MM-DD').
- **Response:**
  - List of matching books.

### Register Book
- **Method:** `POST`
- **Endpoint:** `/books/register`
- **Description:** Registers a new book.
- **Authentication:** Requires a valid JWT token.
- **Parameters:**
  - `title` (string, required, unique): Book title.
  - `publication_date` (string, required, format: 'YYYY-MM-DD'): Book publication date.
- **Response:**
  - Newly created book details.

### Update Book
- **Method:** `PUT`
- **Endpoint:** `/books/update`
- **Description:** Updates an existing book.
- **Authentication:** Requires a valid JWT token.
- **Parameters:**
  - `id` (integer, required): Book ID.
  - `title` (string): New book title.
  - `publication_date` (string, format: 'YYYY-MM-DD'): New book publication date.
- **Response:**
  - Updated book details.

### Delete Book
- **Method:** `DELETE`
- **Endpoint:** `/books/delete`
- **Description:** Deletes an existing book.
- **Authentication:** Requires a valid JWT token.
- **Parameters:**
  - `id` (integer, required): Book ID.
- **Response:**
  - Success message.

## Reviews

### Get All Reviews for a Book
- **Method:** `GET`
- **Endpoint:** `/reviews/all`
- **Description:** Retrieves all reviews for a specific book.
- **Parameters:**
  - `id_book` (integer, required): ID of the book.
- **Response:**
  - List of reviews for the specified book.

### Get Review Details
- **Method:** `GET`
- **Endpoint:** `/reviews/show`
- **Description:** Retrieves details of a specific review.
- **Authentication:** Requires a valid JWT token.
- **Parameters:**
  - `id` (integer, required): ID of the review.
- **Response:**
  - Details of the specified review.

### Register Review
- **Method:** `POST`
- **Endpoint:** `/reviews/register`
- **Description:** Registers a new review for a book.
- **Authentication:** Requires a valid JWT token.
- **Parameters:**
  - `book_id` (integer, required): ID of the book.
  - `review_text` (string, required): Text of the review.
  - `rating` (integer, required, between: 1-5): Rating of the review.
- **Response:**
  - Newly created review details.

### Update Review
- **Method:** `PUT`
- **Endpoint:** `/reviews/update`
- **Description:** Updates an existing review.
- **Authentication:** Requires a valid JWT token.
- **Parameters:**
  - `id` (integer, required): ID of the review.
  - `review_text` (string): New text of the review.
  - `rating` (integer, between: 1-5): New rating of the review.
- **Response:**
  - Updated review details.

### Delete Review
- **Method:** `DELETE`
- **Endpoint:** `/reviews/delete`
- **Description:** Deletes an existing review.
- **Authentication:** Requires a valid JWT token.
- **Parameters:**
  - `id` (integer, required): review ID.
- **Response:**
  - Success message.
