# laravel-news-crud

https://packagist.org/packages/sevenpluss/laravel-news-crud

I added into dependency the Debugbar immediately after installation can be tested

__Minimum requirements:__ Laravel 5.4+, php7+

#### Install steps:

#### 1  install package.

from console use command

```shell
composer require sevenpluss/laravel-news-crud
```

or find the package in dependency manager in your IDE and install

```shell
sevenpluss/laravel-news-crud
```

or use composer.json

```shell
"sevenpluss/laravel-news-crud": "^1.0"
```
then run the command 

```shell
composer update
```

#### 2 add service provider of package into file `config/app`

```php
'providers' => [
   ...
   Sevenpluss\NewsCrud\NewsCrudServiceProvider::class,
   ...
]
```

Let make sure that the model __App\User.php__ stored in the default location.
Ok, next files from the box is not touched.


#### 3 - add the files from the package such migration, configs, locale ...etc.

```shell
php artisan vendor:publish
```

#### 4 run the migration tables for database 

```shell
php artisan migrate 
```

next run command right is very, very necessary (or will generated an error that the class is not found)
```
composer dumpautoload
```

#### 5 fill database the test data

```shell
php artisan db:seed --class=CrudDatabaseSeeder
```

the tables should be seeding in the following order
```php
Seeding: CategoriesTableSeeder
Seeding: CrudUsersTableSeeder
Seeding: PostsTableSeeder
Seeding: CommentsTableSeeder
Seeding: TagsTableSeeder
```

It all, package ready for use.

(seeding test data, 1 from 20 can be broken (guilty __Faker__), just rollback migration and repeat __step 5__


#### Code description

Code written like composer package for Laravel 5.4

I use __PRS-2__ style for php

use patterns __Repository__, __Presenter__

php7, boostrap, jquery

__templates:__
server-side - __twig__, 
client-side - __underscore__

css layout is optimized for fast rendering browsers (as allowed by bootstrap)

Structural data: __NewsArticle__, __Comment__ by schema.org

Little bit ajax. 

Ajax used when add comments, delete news and categories.

Navigation by news had a simple and ajax versions.

Ajax navigation use pushState, from this support IE10+

######

Categories Create/Delete can anybody from url  
```
/category 
```
in header menu __CRUD for categories__

Add comments for new can anybody (logged user / guest)

News can create/delete __only logged users__ from anywhere page which have a news listing (except home page).

register/autorization - elementary (from box)

####

Relations for database:

When you delete category - you delete => news => comments

When you delete user - you delete all news and comments where his owner.

When you delete news - you delete all the children comments.

#####

REST / CRUD used for categories and news

The package was written and tested on laravel 5.4
