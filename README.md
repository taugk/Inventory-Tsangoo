# Inventory-Tsangoo

## Getting Started

### Clone the Repository
Clone this repository to your local machine:
```bash
git clone https://github.com/yourusername/Inventory-Tsangoo.git
cd Inventory-Tsangoo
```

### Install Dependencies
Install the required dependencies:
```bash
composer install
npm install
```

### Set Up the Environment
1. Copy the example environment file:
   ```bash
   cp .env.example .env
   ```
2. Generate an application key:
   ```bash
   php artisan key:generate
   ```
3. Configure the `.env` file with your database credentials (PostgreSQL):
   ```env
   DB_CONNECTION=pgsql
   DB_HOST=127.0.0.1
   DB_PORT=5432
   DB_DATABASE=laravel_test
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```

### Run Database Migrations
Run the migrations to set up the database:
```bash
php artisan migrate
```

### Serve the Application
Start the development server:
```bash
php artisan serve
```

## Running Tests
To run the tests for this application:
```bash
php artisan test
```

## Contributing
Contributions are welcome! Please follow these steps:
1. Fork this repository.
2. Create a new branch for your feature or bugfix.
3. Submit a pull request with a clear description of your changes.

## License
This project is licensed under the MIT License. See the [LICENSE](LICENSE) file for details.
