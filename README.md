# Laravel Books Library Api

A simple Movies Library Api with Laravel 10.
Admin can add ,update,show and delete books ,users.
User can borrow return and rating book .
##

## Installation

Clone the repository-

```
git clone https://github.com/noorhaan-almohammed/book_library.git
```

Then cd into the folder with this command-

```
cd book-library
```

Then do a composer install

```
composer install
```

Then do a npm install

```
npm install
```

Then create a environment file using this command-

```
cp .env.example .env
```

Then edit `.env` file with appropriate credential for your database server. Just edit these two parameter(`DB_CONNECTION`,`DB_DATABASE`,`DB_USERNAME`, `DB_PASSWORD`).

Then create a database named `books_library` and then do a database migration using this command-

```
php artisan migrate
php artisan db:seed   
```

## Run server

Run server using this command-

```
php artisan serve
```

Then go to `http://localhost:8000` from your browser and see the app.

