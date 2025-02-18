# To-Do List Web App

This is a simple To-Do List web application that allows users to manage their tasks. It is built using **Vue.js** for the frontend, **Laravel** for the backend, and **MySQL** for data storage.

## Features

- **Add Task:** Users can add tasks to their to-do list.
- **Update Task:** Users can edit the details of a task.
- **Delete Task:** Users can remove tasks from the list.
- **Input Validation:** Tasks must be between 10 and 50 characters.
- **Error Handling:** Error messages are displayed when required fields are empty or invalid.
- **User-friendly UI:** A clean and responsive interface built with Vue.js and Bootstrap.

## Tech Stack

- **Frontend:** Vue.js, Bootstrap
- **Backend:** Laravel (PHP)
- **Database:** MySQL

## Live Demo

You can try the live version of the application here:  
[https://todo.ips.ng/](https://todo.ips.ng/)

## Prerequisites

Before running this application locally, ensure you have the following installed:

- **PHP 8.x** or higher
- **Laravel 8.x** or higher
- **Node.js and NPM**
- **MySQL**
- **Composer** (for Laravel dependencies)

## Installation

### 1. Clone the Repository

```bash
git clone https://github.com/uyibis/todo.git
cd todo
```

### 2. Backend Setup (Laravel)

- **Install Laravel Dependencies:**

```bash
composer install
```

- **Set up the environment:**

Copy the `.env.example` file to `.env` and configure the database settings:

```bash
cp .env.example .env
```

Edit `.env` and set the `DB_HOST`, `DB_DATABASE`, `DB_USERNAME`, and `DB_PASSWORD` variables to match your MySQL configuration.

- **Generate the Application Key:**

```bash
php artisan key:generate
```

- **Run the Migrations:**

```bash
php artisan migrate
```

### 3. Frontend Setup (Vue.js)

- **Install Node Dependencies:**

```bash
npm install
```

- **Run the Development Server:**

```bash
npm run dev
```

### 4. Start the Application

- **Run the Laravel Server:**

```bash
php artisan serve
```

Now the application should be running at [http://localhost:8000](http://localhost:8000).

## Usage

- Open the application in your browser.
- Add tasks, update, or delete them as needed.
- The tasks will persist in the MySQL database.

## Future Improvements

- **Authentication:** Add user authentication for task personalization.
- **Task Categorization:** Implement tags or categories for better organization.
- **Task Priorities:** Allow setting priorities for tasks.

## License

This project is open-source and available under the MIT License.

## Contact

For any questions or inquiries, feel free to reach out to me on [GitHub](https://github.com/uyibis).

---

Enjoy managing your tasks! 😊
