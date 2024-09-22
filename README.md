## Local Setup

### Prerequisites
You need to have the following installed on your computer:
<ul>
  <li>PHP</li>
  <li>Laravel</li>
  <li>Composer</li>
  <li>MySQL (default database management in use)</li>
  <li>Node</li>
</ul>

To set up the project locally:
<ol>
  <li>Clone the repository</li>
</ol>
If all prerequisite packages are installed, run the following commands:

`composer install` to install backend dependencies

Then `php artisan serve` to start the backend server.

`php artisan migrate` to run the migrations after configuring your database with a `.env` file

`npm install` to install frontend dependencies

`npm run dev` to run the frontend server

`php artisan websocket:serve` to run the websocket server

`php artisan queue:work` to run any queues you may have

The site will be available in `http://localhost:8000`
