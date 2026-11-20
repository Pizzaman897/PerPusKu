### PL-GROUP-5
# PerPusKu

A platform designed to help users borrow books and help librarians manage reservations.

## The Main Feature
PerPusKu is a website that helps users reserve books and helps librarians manage those reservations. It includes:

- user login
- a dashboard for users that includes a selection of books.
- book description.
- user book reservation status.
- user reservation history.
- an admin dashboard that shows book and user counts, reserved books, and recent reservations.
- a page for admins to manage user reservations.
- a page to add admins, users, and books.

## Technology
Below are the list off technology that we use for this project:
- Figma
- Canva
- Laravel
- MySQL
- Laragon
- PHP
- HTML
- CSS
- JS
- VSC
- Tailwind
- GitHub
- Blade
- Photoshop

In short: it’s a tool for users to reserve books and for librarians to manage reservations.

## How to Run

Run the following commands in the Laragon terminal:

```
cd C:\laragon\www
git clone https://github.com/Pizzaman897/PerPusKu.git
cd PerPusKu
composer install
npm install
copy .env.example .env
php artisan key:generate
```

Create an empty database named `perpusku_database`, then configure the database connection in `.env`:

```dotenv
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=perpusku_database
DB_USERNAME=root
DB_PASSWORD=
```

Then continue:

```
php artisan migrate
composer run dev
```

Open http://localhost:8000.

## Group Member
- Edward H.R. ; Pizzaguy897 | https://github.com/Pizzaman897 (Group 5 Leader, Lead Back End Developer)
- Daniel Federico Theodoric ; DanielPNK | https://github.com/DanielPNK (Lead Designer UI/UX, Front End Helper)
- Neville Owen ; Neville-Owen | https://github.com/Neville-Owen (Front End Developer, Designer UI/UX Helper)
- Jose Marvin ; josemarvinlau2009-rgb | https://github.com/josemarvinlau2009-rgb (Lead Front End Developer, Designer UI/UX Helper)

## Seeder Account (username, e-mail, password)
User acc : User1, user@gmail.com, 23456789
Admin acc : Admin1, admin@gmail.com, 12345678