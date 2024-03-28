# Welcome to My Backend-API Project

🎉 This Laravel project is designed to demonstrate a simple API CRUD.

## Requirements

-   PHP 8.2 (This project uses Laravel 11)

## Getting Started

Follow these steps to get started with the project:

1. **Clone the repository:**

    ```bash
    git clone https://github.com/mas7/fullstack-project.git
    ```

2. **Navigate to the project directory:**

    ```bash
    cd backend
    ```

3. **Install dependencies:**

    ```bash
    composer install
    ```

4. **Copy the example environment file and configure your environment variables:**

    ```bash
    cp .env.example .env
    ```

    Update the `.env` file with your database credentials and other configuration settings.

5. **Generate an application key:**

    ```bash
    php artisan key:generate
    ```

6. **Run database migrations and seeders (if applicable):**

    ```bash
    php artisan migrate --seed
    ```

7. **Run tests:**

    ```bash
    php artisan test
    ```

8. **Start the development server:**

    ```bash
    php artisan serve
    ```

    This will start a development server at `http://localhost:8000`.
