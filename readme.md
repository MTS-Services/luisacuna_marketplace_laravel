# Laravel 12 + Livewire 3 User CRUD - Setup Guide

## Prerequisites
- PHP 8.2 or higher
- Composer
- MySQL/PostgreSQL
- Node.js & NPM

## Installation Steps

### 1. Clone and Install Dependencies
```bash
composer install
npm install && npm run build
```

### 2. Environment Setup
```bash
cp .env.example .env
php artisan key:generate
```

### 3. Configure Database
Edit `.env` file:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### 4. Run Migrations and Seeders
```bash
php artisan migrate
php artisan db:seed
```

### 5. Storage Link
```bash
php artisan storage:link
```

### 6. Register Service Providers
Ensure `bootstrap/providers.php` contains:
```php
return [
    App\Providers\AppServiceProvider::class,
    App\Providers\EventServiceProvider::class,
    App\Providers\RepositoryServiceProvider::class,
];
```

### 7. Start Development Server
```bash
php artisan serve
```

## Default Login Credentials
- **Email:** admin@example.com
- **Password:** password

## Routes

### Web Routes
- `GET /users` - User List
- `GET /users/create` - Create User
- `GET /users/{user}/edit` - Edit User

### API Routes (Requires Authentication)
- `GET /api/users` - List users
- `POST /api/users` - Create user
- `GET /api/users/{id}` - Get user
- `PUT /api/users/{id}` - Update user
- `DELETE /api/users/{id}` - Soft delete user
- `POST /api/users/{id}/restore` - Restore user
- `DELETE /api/users/{id}/force` - Force delete user
- `POST /api/users/bulk-delete` - Bulk delete users

## Testing

### Run All Tests
```bash
php artisan test
```

### Run Specific Test
```bash
php artisan test --filter UserListTest
php artisan test --filter UserServiceTest
```

## Features Implemented

### 1. Complete CRUD Operations
- ✅ Create User
- ✅ Read/List Users
- ✅ Update User
- ✅ Delete User (Soft Delete)
- ✅ Force Delete
- ✅ Restore User

### 2. Advanced Features
- ✅ Search & Filtering
- ✅ Sorting (All Columns)
- ✅ Pagination
- ✅ Bulk Operations (Delete, Status Update)
- ✅ Avatar Upload & Management
- ✅ Status Management (Active, Inactive, Suspended, Pending)
- ✅ Real-time Validation
- ✅ Soft Deletes

### 3. Architecture Components
- ✅ DTOs (Data Transfer Objects)
- ✅ Actions
- ✅ Services
- ✅ Repositories (Interface & Implementation)
- ✅ Events & Listeners
- ✅ Enums
- ✅ Traits
- ✅ Form Objects (Livewire Forms)
- ✅ API Controller
- ✅ Comprehensive Tests

### 4. Livewire Features
- ✅ Wire Navigation
- ✅ File Uploads
- ✅ Real-time Search
- ✅ Loading States
- ✅ Notifications
- ✅ Modal Dialogs

## Queue Configuration (Optional)

For async email sending:

1. Update `.env`:
```
QUEUE_CONNECTION=database
```

2. Create queue table:
```bash
php artisan queue:table
php artisan migrate
```

3. Run queue worker:
```bash
php artisan queue:work
```

## File Structure
```
app/
├── Actions/User/          # Business actions
├── DTOs/User/             # Data Transfer Objects
├── Enums/                 # Enumerations
├── Events/User/           # Event classes
├── Http/
│   ├── Controllers/Api/   # API Controllers
│   └── Livewire/User/     # Livewire Components
├── Listeners/User/        # Event Listeners
├── Models/                # Eloquent Models
├── Repositories/          # Repository Pattern
├── Services/User/         # Service Layer
└── Traits/Livewire/       # Reusable Traits

database/
├── factories/             # Model Factories
└── migrations/            # Database Migrations

resources/views/livewire/  # Blade Views

tests/
├── Feature/Livewire/      # Feature Tests
└── Unit/Services/         # Unit Tests
```

## Architecture Benefits

1. **Separation of Concerns**: Each layer has a specific responsibility
2. **Testability**: Easy to write unit and feature tests
3. **Maintainability**: Clear structure makes code easy to maintain
4. **Scalability**: Easy to add new features
5. **Reusability**: Components can be reused across the application
6. **Type Safety**: DTOs and Enums provide type safety

## Troubleshooting

### Issue: Livewire not working
```bash
php artisan livewire:publish --config
php artisan livewire:publish --assets
```

### Issue: Avatar upload not working
```bash
php artisan storage:link
chmod -R 775 storage
chmod -R 775 bootstrap/cache
```

### Issue: Events not firing
```bash
php artisan event:clear
php artisan cache:clear
```

## Production Deployment

1. Optimize application:
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache
```

2. Set environment:
```
APP_ENV=production
APP_DEBUG=false
```

3. Run migrations:
```bash
php artisan migrate --force
```

## Additional Commands

```bash
# Clear all caches
php artisan optimize:clear

# Run tests with coverage
php artisan test --coverage

# Generate IDE helper (optional)
composer require --dev barryvdh/laravel-ide-helper
php artisan ide-helper:generate
php artisan ide-helper:models
```

## Support
For issues or questions, please check the documentation or create an issue in the repository.