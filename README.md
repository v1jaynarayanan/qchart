# Feedback 360
Use Feedback 360 to create fast and easy online surveys to gather host of information and analyse results by generating spider graph


#To run in dev mode
1. Web server must be running
2. MySQL database must be running
3. Run from command prompt -
   php artisan migrate:refresh
4. Run from command prompt -
   php artisan db:seed
5. Check mail.php if driver is set to smtp and not log and youremail@id is correct
	'driver' => env('MAIL_DRIVER', 'smtp'),

	'from' => ['address' => 'youremail@id.com', 'name' => 'Feedback 360'],
6. Set the following in the .env file
   MAIL_USERNAME=yourmail@id.com
   MAIL_PASSWORD=yourpwd
7. Check if the database is pointing to localhost with the correct name and pwd

        'mysql' => [
            'driver' => 'mysql',
            'host' => env('DB_HOST', 'localhost'),
            'port' => env('DB_PORT', '3306'),
            'database' => env('DB_DATABASE', 'homestead'),
            'username' => env('DB_USERNAME', 'root'),
            'password' => env('DB_PASSWORD', ''),
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
            'strict' => false,
            'engine' => null,
        ],

#To run in unit tests
1. Check mail.php if driver is set to log and not smtp
	 'driver' => 'log', 
2. Run command
   vendor/bin/phpunit 