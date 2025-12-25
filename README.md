<!-- == Commands == -->


<!-- make module -->
php artisan make:module Module_Name
composer dump-autoload


<!-- modules migrate  -->
php artisan migrate:modules --force


<!-- # یا فقط انتشار config -->
php artisan module:publish-assets {Product} --to=public
php artisan module:publish-assets {Product} --to=config


<!-- module seed -->
php artisan module:seed User
php artisan module:seed User --class=CustomUserSeeder


<!-- database backup -->
php artisan db:backup
php artisan db:backup --compress

<!-- clear cache -->
<!-- php artisan app:clear-cache -->


