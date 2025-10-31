# E-Commerce

## About
An e-commerce website built with Laravel 11 and AdminLTE for the admin dashboard.

## Features
- **Admin Dashboard**
  - Manage products
  - Manage brands
  - Manage orders
  - Manage users
- **User**
  - View products
  - Add to cart
  - Checkout
  - View order history
  - Authentication
  - Etc.

## Built With
- [Laravel](https://laravel.com/)
- [AdminLTE](https://adminlte.io/)
- [Bootstrap](https://getbootstrap.com/)
- [JQuery](https://jquery.com/)

## Getting Started
To get a local copy up and running follow these simple example steps.

### Installation
1. Clone the repo
   ```sh
   git clone https://github.com/your_username/your_project.git
   ```
2. Install composer packages
   ```sh
   composer install
   ```
3. Install npm packages
   ```sh
   npm install
   ```
4. Create a copy of your .env file
   ```sh
   cp .env.example .env
   ```
5. Generate an app encryption key
   ```sh
   php artisan key:generate
   ```
6. In your .env file, add database information to allow the application to connect to the database
7. Migrate the database
   ```sh
   php artisan migrate
   ```
8. Seed the database
   ```sh
   php artisan db:seed
   ```
9. Run the app
   ```sh
   php artisan serve
   ```


