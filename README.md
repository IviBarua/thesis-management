# Thesis Management System

A web-based Thesis Management System built with Laravel and MySQL/MariaDB. The system allows teachers to create and manage thesis groups and allows administrators to manage teachers, groups, and thesis-related information.

## Features

### Teacher

* Teacher registration and login
* Teacher dashboard
* Create thesis groups
* Add multiple group members
* Assign thesis supervisors
* View created thesis groups
* Edit thesis groups
* Add or remove group members
* Delete thesis groups
* View thesis group information

### Administrator

* Admin dashboard
* View total teachers
* View total groups
* View total members
* View administrators
* View teacher information
* Edit teacher information
* Delete teachers
* View thesis groups
* Edit thesis groups
* Delete thesis groups

## Technologies Used

* **Backend:** Laravel / PHP
* **Frontend:** Blade, HTML, CSS, JavaScript
* **UI Framework:** Bootstrap 5
* **Database:** MySQL / MariaDB
* **Development Environment:** XAMPP
* **Version Control:** Git / GitHub

## Database Structure

The main database tables include:

### Users

Stores teacher and administrator information.

Important fields include:

* First name
* Last name
* Email
* Phone
* Department
* Degree
* Batch
* Session
* Teacher ID
* Role
* Password

### Groups

Stores thesis group information.

Important fields include:

* Group name
* Thesis title
* Supervisor

### Group Members

Stores individual students belonging to a thesis group.

Important fields include:

* Name
* Student ID
* Batch
* Session
* Department
* Role
* Group ID

## Project Structure

```text
thesis_management/
│
├── app/
│   ├── Http/
│   │   └── Controllers/
│   └── Models/
│
├── database/
│   ├── migrations/
│   └── seeders/
│
├── resources/
│   └── views/
│       ├── admin/
│       ├── teacher/
│       └── group.blade.php
│
├── routes/
│   └── web.php
│
├── public/
├── storage/
├── tests/
├── .env.example
├── .gitignore
├── artisan
├── composer.json
└── README.md
```

## Installation

### 1. Clone the repository

```bash
git clone https://github.com/YOUR-USERNAME/thesis-management.git
```

Then enter the project directory:

```bash
cd thesis-management
```

### 2. Install PHP dependencies

```bash
composer install
```

### 3. Create the environment file

Copy `.env.example` and create a new `.env` file.

```bash
cp .env.example .env
```

On Windows, you can also simply copy `.env.example` manually and rename the copy to:

```text
.env
```

### 4. Generate the application key

```bash
php artisan key:generate
```

### 5. Create the database

Create a MySQL/MariaDB database named:

```text
thesis_management
```

Then configure the database settings in `.env`.

Example:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=thesis_management
DB_USERNAME=root
DB_PASSWORD=
```

### 6. Run migrations

```bash
php artisan migrate
```

If seeders are available:

```bash
php artisan db:seed
```

### 7. Start the Laravel development server

```bash
php artisan serve
```

Open:

```text
http://127.0.0.1:8000
```

## User Roles

The system currently supports two roles:

### Admin

Administrators can manage teachers and thesis groups.

### Teacher

Teachers can create and manage their thesis groups and group members.


## Future Improvements

Possible future improvements include:

* Student login
* Thesis progress tracking
* Thesis document uploads
* Thesis submission management
* Progress percentage tracking
* Notifications
* Search and filtering
* Teacher-student communication
* Improved role-based authorization
* Automated testing

## Author

Ivi Barua

Computer Science and Engineering Graduate

GitHub: https://github.com/YOUR-USERNAME
