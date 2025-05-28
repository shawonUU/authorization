# Custom Role & Permission System

A custom-built Role and Permission management system in Laravel 12.15.0 using native features like Eloquent, Middleware, Services, and Policies. And without **Third-party packages**.


## Features

- Role-based and permission-based access control
- Assign/revoke Roles and Permissions to users
- Post Management System
- User Management
- Basic CRUD for Role, Permission, User and Post

## Architecture Overview
- Create laravel project with version **12.15.0** and PHP version **8.2.0**
- Use **Service** for **(RoleService, PermissionService and UserService**).
- Use **Policy** for model-level permissions to **Post Management**
- Custom Blade directive: **@perm('permission-name') @endperm**
- Make **Migration** for database Schema **(users, permissions, roles, permission_role, role_user and post)**
- Make **Model** for **(Role, Permission, User and Post)**
- Create **Seeder** for **(users, permissions, roles, permission_role and role_user)**
- Create **Custome-Middleware** for **role and permission**
- Create **Unit Test** for  **(ModelRelationshipTest, PermissionMiddlewareTest, PostPolicyTest, PostTest, RolePermissionTest)**
- Make Helper methods to model for checking user access
- Modular service layer for business logic


## Installation & Setup

### Prerequisites
- PHP >= 8.2
- Composer
- MySQL/PostgreSQL Database

### From Git
- git clone https://github.com/shawonUU/authorization.git
- cd authorization
- composer install
- cp .env.example .env
- php artisan key:generate
Configure DB credentials in .env
- php artisan migrate --seed
- php artisan serve

### From The Zip
Extract the Zip
- cd authorization
- cp .env.example .env
Configure DB credentials in .env
- php artisan migrate --seed
- php artisan serve

## Unite test
- php artisan test


## Database Schema
---------------------------------------------------------------------
| Table             | Columns                                       |
|-------------------|-----------------------------------------------|
| `users`           | `id`, `name`, `email`, `password`, `timestamp`|
| `roles`           | `id`, `name`, `timestamp`                     |
| `permissions`     | `id`, `name`, `timestamp`                     |
| `role_user`       | `user_id`, `role_id`                          |
| `permission_role` | `permission_id`, `role_id`                    |
| `posts`           | `id`, `user_id`, `title`, `body`, `timestamp` |
---------------------------------------------------------------------

## Model Relationships

### User.php

public function roles()
{
    return $this->belongsToMany(Role::class);
}

public function permissions()
{
    return $this->belongsToMany(Permission::class);
}

### Role.php

public function users() {
    return $this->belongsToMany(User::class);
}
public function permissions()
{
    return $this->belongsToMany(Permission::class, 'permission_role', 'role_id', 'permission_id');
}

### Permission.php
public function roles()
{
    return $this->belongsToMany(Role::class, 'permission_role', 'permission_id', 'role_id');
}

### Permission.php
public function user()
{
    return $this->belongsTo(User::class);
}


## Middleware

#### Role Middleware
'role' => \App\Http\Middleware\RoleMiddleware::class,

#### Permission Middleware
'permission' => \App\Http\Middleware\PermissionMiddleware::class,

## Helper Methods (User Model)
public function permissions() {
    return $this->roles()->with('permissions')->get()->flatMap(fn($role) => $role->permissions)->unique('id');
}

public function hasRole($role) {
    return $this->roles->contains('name', $role);
}

public function hasPermission($permission) {
    return $this->permissions()->contains('name', $permission);
}

## Folder Structure

app/
├── Http/
│   └── Middleware/
│       ├── PermissionMiddleware.php
│       └── RoleMiddleware.php
├── Models/
│   ├── Role.php
│   ├── Permission.php
│   ├── User.php
│   └── Post.php
├── Services/
│   ├── RoleService.php
│   ├── PermissionService.php
│   └── UserService.php
├── tests/
│   └── Unit/
│       ├── ModelRelationshipTest.php
│       ├── PostPolicyTest.php
│       ├── RolePermissionTest.php
│       └── PermissionMiddlewareTest.php

## License
This project is open-source and available

## Questions?
Feel free to open an issue or reach out at shawonmahmodul12@gmail.com