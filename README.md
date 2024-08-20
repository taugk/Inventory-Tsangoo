Inventory Management System
Overview
The Inventory Management System is a web-based application designed for small businesses to manage and track their inventory efficiently. Built using Laravel 11 and PostgreSQL, this system provides robust features including user authentication, role-based access control, inventory tracking, and more.

Features
User Authentication: Secure login and registration system.
Role-Based Access Control: Manage user permissions based on roles.
Inventory Management: CRUD operations for inventory items.
Inventory Tracking: Real-time stock monitoring with alerts.
Dynamic Filtering: AJAX-based search and filtering functionality.
Data Import/Export: Easily import and export inventory data in CSV and Excel formats.
Fixed Table Header: Enhanced data viewing with a fixed table header.
Process Logging: Log activities and processes within the system.
PDF Export: Generate PDF documents for sales bills with dynamic file names.
Stock Alerts: Notifications when stock levels are low or when quantities exceed available stock.
Future Enhancements
Quotation Management: Manage and generate quotations.
Sale Bill PDF Generation: Create and export sale bills in PDF format.
Purchase and Sale Editing: Edit purchase and sale records.
Technology Stack
Backend: Laravel 11, PostgreSQL
Frontend: Blade Templating Engine, JavaScript, jQuery, AJAX
Version Control: Git, GitHub
Environment: Windows, Composer, PSR-4, nWidart package for modular development
Installation
Clone the repository:

    git clone https://github.com/pushpaasabari/Inventory-Management-System.git
Navigate to the project directory:

    cd Inventory-Management-System
Install dependencies:

    composer install
    npm install
Set up the environment:

    cp .env.example .env
    php artisan key:generate

Configure the .env file with your database credentials (PostgreSQL):env

    DB_CONNECTION=pgsql
    DB_HOST=127.0.0.1
    DB_PORT=5432
    DB_DATABASE=laravel_test
    DB_USERNAME=your_username
    DB_PASSWORD=your_password

Run database migrations:

    php artisan migrate
Serve the application:

    php artisan serve
Running Tests
To run the tests for this application:

    php artisan test

Contributing
Contributions are welcome! Please fork this repository, create a new branch, and submit a pull request.

License
This project is licensed under the MIT License. See the LICENSE file for details.
