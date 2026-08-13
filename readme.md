# Open Terminal and type
composer install

## add this in google_callback.php and google_login.php
$client->setClientId($_ENV['GOOGLE_CLIENT_ID']);
$client->setClientSecret($_ENV['GOOGLE_CLIENT_SECRET']);
