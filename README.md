## Auto-Engine example ##

### Configuration ###

* PHP >= 7.1.3
* OpenSSL PHP Extension
* PDO PHP Extension
* Mbstring PHP Extension
* Tokenizer PHP Extension
* XML PHP Extension
* Ctype PHP Extension
* JSON PHP Extension
* BCMath PHP Extension


### Installation ###

* `git clone https://github.com/bestmomo/laravel5-example.git projectname`
* `cd projectname`
* `composer install`
* `php artisan key:generate`
* Create a database and edit*.env*
* `php artisan migrate` to create and populate tables

For api
* `php artisan passport:client --password` to generate  Client ID and Client secret


### Features ###

* Dashboard
* Custom Error Page 404
* Authentication (registration, login, logout, password reset)
* Localisation
* Registration enable-disable setting.
* Role create and manage role
* Role create with multiple permission.
* You can create user with assigned role.
* You can change language with language translate.

If You create role with Only If Creator only show data which one user created.
If You create role with activity you can see in edit form.
