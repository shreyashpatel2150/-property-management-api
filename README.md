# property-management-api
Basic Laravel API application for manage property detail like crate, edit, delete and list properties.

### Language & Framework Used:
1. PHP-8.2.2
1. Laravel-10

### Architecture Used:
1. Laravel 10.x
2. Interface-Repository Pattern
3. Model Based Eloquent ORM

### API List:
##### Property Module
1. [x] Create Property
2. [x] Property List
3. [x] Edit Property
4. [x] View Property
5. [x] Delete Property


### Project setup

```bash
git clone https://github.com/shreyashpatel2150/-property-management-api.git
cd property-management-api
```

Create file `.env` && Copy `.env.example` to `.env`
Create a database called - `property_management`
Update creditionals in `.env` file

# Install composer packages
```bash
composer install
```

# migrate database
```bash
php artisan migrate
```

# Run server
```bash
php artisan serve
```