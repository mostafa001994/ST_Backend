<!-- == Commands == -->


<!-- make module with migration-->
php artisan make:module Module_Name
composer dump-autoload


<!-- module make migration -->
module:make-migration {module} create_users_table


<!-- modules migrate  -->
php artisan migrate:modules --force


<!-- # یا فقط انتشار config -->
php artisan module:publish-assets {User} --to=public
php artisan module:publish-assets {User} --to=config


<!-- module seed -->
php artisan module:seed {User}
php artisan module:seed {User} --class=CustomUserSeeder


<!-- database backup -->
php artisan db:backup
php artisan db:backup --compress

<!-- clear cache -->
<!-- php artisan app:clear-cache -->





# ساخت مایگریشن ایجاد جدول users در ماژول User
php artisan module:make-migration create_users_table User --create=users

# ساخت مایگریشن تغییر جدول products در ماژول Product
php artisan module:make-migration add_price_to_products_table Product --table=products
