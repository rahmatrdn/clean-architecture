# Example Laravel - Clean Architecture (REST API Service)

This project demonstrates how to implement **Clean Architecture** principles in a **Laravel 12** application.

The goal of this repository is to show a clear separation of concerns, making the application more maintainable, testable, and scalable by decoupling business logic from the framework's HTTP layer.

## 🏗️ Project Structure

The application follows a modular structure inspired by Clean Architecture:

```
app/
├── Http/
│   └── Controllers/   # Entry points (Thin controllers)
├── Models/            # Eloquent Models (Data structure)
├── Repositories/      # Data Access Layer (Repository Pattern)
└── UseCases/          # Business Logic (Application specific use cases)
```

### Key Concepts

-   **Use Cases**: Contain the core business logic. They are framework-agnostic where possible and orchestrate the flow of data.
-   **Repositories**: Handle data persistence and retrieval, abstracting the database layer from the business logic.
-   **Controllers**: Responsible only for handling HTTP requests, validating input, calling the appropriate Use Case, and returning a response.

## 🚀 Getting Started

### Prerequisites

-   PHP 8.2+
-   Composer
-   SQLite (default) or MySQL

### Installation

1.  **Clone the repository**
    ```bash
    git clone https://github.com/rahmatrdn/clean-architecture.git
    cd example-laravel
    ```

2.  **Automated Setup**
    We have a convenient composer script to set up everything for you:
    ```bash
    composer run setup
    ```
    *This command will install dependencies, setup the `.env` file, generate the app key, run migrations, and build frontend assets.*

    **OR Manual Setup**
    ```bash
    composer install
    cp .env.example .env
    php artisan key:generate
    php artisan migrate
    ```

3.  **Start the Server**
    ```bash
    composer run dev
    ```
    Or manually:
    ```bash
    php artisan serve
    ```

## 🧪 Testing

This project uses **Pest PHP** for testing.

```bash
# Run all tests
php artisan test

# Run specific test
php artisan test --filter=TaskTest
```

## 📚 API Documentation

API documentation and collection are available in the `bruno-api-docs` directory. You can use [Bruno](https://www.usebruno.com/) to open and test the API endpoints.

## 🛠️ Tech Stack

-   **Framework**: Laravel 12
-   **Architecture**: Clean Architecture
-   **Testing**: Pest PHP
-   **API Docs**: Bruno
-   **Code Style**: Laravel Pint

## 📝 License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
