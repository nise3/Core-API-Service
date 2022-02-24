# NISE3 Core API Service

## The project deployment Notice 

## Run lumen
```shell
php -S localhost:8000 -t public
```
## Artisan command for Reverse Seed
```shell
php artisan iseed my_table
php artisan iseed my_table,another_table
```
## In order to release a version to the cluster through CI/CD pipeline
```shell
RELEASE = 'php artisan list'
```
