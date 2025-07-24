# 📚 Laravel Book Rating App

A simple Laravel application to manage books, authors, and user-submitted ratings. Built with DataTables, Select2, and Laravel Blade. Ratings range from 1 to 10 and are associated with specific books and authors.

---

## ✨ Features

-   List all books with average rating and total voters
-   Top 10 authors with the most votes (ratings > 5)
-   Input new rating with dynamic author-book relationship
-   Realtime server-side table using DataTables
-   Select2 integration with AJAX search for authors and books
-   Toast notification for successful rating submission

---

## 📦 Tech Stack

-   Laravel 12 with PHP 8.2
-   MySQL / MariaDB
-   jQuery + DataTables
-   Select2
-   TailwindCSS
-   Blade templates

---

## 🚀 Setup Instructions

```bash
git clone https://github.com/chaidarsaad/bookrate.git
cd bookrate
composer install
cp .env.example .env
php artisan key:generate

setup .env
DB_DATABASE=your_db
DB_USERNAME=your_user
DB_PASSWORD=your_password

php artisan migrate --seed

php artisan serve
```

🌐 Live Demo
This project is deployed online.
👉 Try it here: https://bookrate.genzproject.my.id
