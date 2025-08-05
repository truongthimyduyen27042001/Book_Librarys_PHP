# Laravel Books API - Documentation

## Tổng quan dự án

Đây là một dự án Laravel mới được tạo với Laravel 12, sử dụng PHP 8.2+ và các công nghệ hiện đại như Vite, Tailwind CSS v4. Dự án hiện tại chỉ có cấu trúc cơ bản của Laravel với trang welcome mặc định.

## Cấu trúc thư mục chi tiết

### 📁 Root Directory
```
books-api/
├── app/                    # Thư mục chính chứa logic ứng dụng
├── bootstrap/              # Khởi tạo framework
├── config/                 # Cấu hình ứng dụng
├── database/               # Database migrations, seeders, factories
├── public/                 # Thư mục public, entry point
├── resources/              # Views, CSS, JS, assets
├── routes/                 # Định nghĩa routes
├── storage/                # Logs, cache, uploads
├── tests/                  # Unit và Feature tests
├── vendor/                 # Composer dependencies
├── artisan                 # Laravel command line tool
├── composer.json           # PHP dependencies
├── package.json            # Node.js dependencies
├── vite.config.js          # Vite configuration
└── README.md              # Laravel default README
```

### 📁 app/ - Logic ứng dụng chính
```
app/
├── Http/
│   └── Controllers/
│       └── Controller.php          # Base controller class
├── Models/
│   └── User.php                    # User model với authentication
└── Providers/
    └── AppServiceProvider.php      # Service provider chính
```

**Chi tiết:**
- **Controller.php**: Class controller cơ bản, abstract class để các controller khác kế thừa
- **User.php**: Model User với các tính năng authentication, sử dụng HasFactory và Notifiable traits
- **AppServiceProvider.php**: Service provider chính để đăng ký các services

### 📁 bootstrap/ - Khởi tạo framework
```
bootstrap/
├── app.php                         # Bootstrap ứng dụng
├── cache/                          # Cache files
└── providers.php                   # Service providers
```

**Chi tiết:**
- **app.php**: File khởi tạo Laravel application
- **cache/**: Thư mục chứa cache files
- **providers.php**: Danh sách service providers

### 📁 config/ - Cấu hình ứng dụng
```
config/
├── app.php                         # Cấu hình ứng dụng chính
├── auth.php                        # Cấu hình authentication
├── cache.php                       # Cấu hình cache
├── database.php                    # Cấu hình database
├── filesystems.php                 # Cấu hình file systems
├── logging.php                     # Cấu hình logging
├── mail.php                        # Cấu hình email
├── queue.php                       # Cấu hình queue
├── services.php                    # Cấu hình services
└── session.php                     # Cấu hình session
```

**Chi tiết:**
- **app.php**: Cấu hình tên app, environment, debug mode, timezone, locale
- **database.php**: Cấu hình kết nối database (SQLite mặc định)
- **auth.php**: Cấu hình authentication providers
- **cache.php**: Cấu hình cache drivers
- **filesystems.php**: Cấu hình disk storage
- **logging.php**: Cấu hình logging channels
- **mail.php**: Cấu hình email settings
- **queue.php**: Cấu hình queue connections
- **session.php**: Cấu hình session handling

### 📁 database/ - Database management
```
database/
├── factories/
│   └── UserFactory.php             # Factory cho User model
├── migrations/
│   ├── 0001_01_01_000000_create_users_table.php
│   ├── 0001_01_01_000001_create_cache_table.php
│   └── 0001_01_01_000002_create_jobs_table.php
└── seeders/
    └── DatabaseSeeder.php          # Database seeder chính
```

**Chi tiết:**
- **UserFactory.php**: Factory để tạo fake data cho User model
- **create_users_table.php**: Migration tạo bảng users với các trường: id, name, email, password, remember_token, timestamps
- **create_cache_table.php**: Migration tạo bảng cache
- **create_jobs_table.php**: Migration tạo bảng jobs cho queue
- **DatabaseSeeder.php**: Seeder chính để seed dữ liệu

### 📁 public/ - Thư mục public
```
public/
├── favicon.ico                     # Favicon
├── index.php                       # Entry point của ứng dụng
└── robots.txt                      # Robots file
```

**Chi tiết:**
- **index.php**: Entry point chính, load Laravel application
- **favicon.ico**: Icon cho website
- **robots.txt**: File cấu hình cho search engines

### 📁 resources/ - Frontend resources
```
resources/
├── css/
│   └── app.css                     # CSS chính với Tailwind CSS v4
├── js/
│   ├── app.js                      # JavaScript chính
│   └── bootstrap.js                # Bootstrap JavaScript
└── views/
    └── welcome.blade.php           # Welcome page
```

**Chi tiết:**
- **app.css**: CSS chính sử dụng Tailwind CSS v4 với custom theme
- **app.js**: JavaScript entry point
- **bootstrap.js**: Bootstrap JavaScript với axios configuration
- **welcome.blade.php**: Trang welcome mặc định của Laravel với design hiện đại

### 📁 routes/ - Route definitions
```
routes/
├── console.php                     # Console routes
└── web.php                         # Web routes
```

**Chi tiết:**
- **web.php**: Định nghĩa web routes, hiện tại chỉ có route '/' trả về welcome view
- **console.php**: Console/Artisan commands

### 📁 storage/ - Storage và logs
```
storage/
├── app/                            # Application storage
├── framework/
│   ├── cache/                      # Framework cache
│   ├── sessions/                   # Session files
│   ├── testing/                    # Testing files
│   └── views/                      # Compiled views
└── logs/                           # Log files
```

### 📁 tests/ - Testing
```
tests/
├── Feature/
│   └── ExampleTest.php             # Feature test example
├── TestCase.php                    # Base test case
└── Unit/
    └── ExampleTest.php             # Unit test example
```

## Cấu hình dự án

### Dependencies

#### PHP Dependencies (composer.json)
```json
{
    "require": {
        "php": "^8.2",
        "laravel/framework": "^12.0",
        "laravel/tinker": "^2.10.1"
    },
    "require-dev": {
        "fakerphp/faker": "^1.23",
        "laravel/pail": "^1.2.2",
        "laravel/pint": "^1.13",
        "laravel/sail": "^1.41",
        "mockery/mockery": "^1.6",
        "nunomaduro/collision": "^8.6",
        "phpunit/phpunit": "^11.5.3"
    }
}
```

#### Node.js Dependencies (package.json)
```json
{
    "devDependencies": {
        "@tailwindcss/vite": "^4.0.0",
        "axios": "^1.8.2",
        "concurrently": "^9.0.1",
        "laravel-vite-plugin": "^2.0.0",
        "tailwindcss": "^4.0.0",
        "vite": "^7.0.4"
    }
}
```

### Cấu hình Database
- **Default**: SQLite (database/database.sqlite)
- **Supported**: MySQL, MariaDB, PostgreSQL, SQL Server
- **Configuration**: `config/database.php`

### Cấu hình Frontend
- **Build Tool**: Vite
- **CSS Framework**: Tailwind CSS v4
- **JavaScript**: Axios cho HTTP requests
- **Theme**: Custom theme với Instrument Sans font

## Cách cài đặt và chạy dự án

### Yêu cầu hệ thống
- PHP >= 8.2
- Composer
- Node.js >= 18
- npm hoặc yarn

### Bước 1: Clone và cài đặt dependencies
```bash
# Clone dự án (nếu chưa có)
git clone <repository-url>
cd books-api

# Cài đặt PHP dependencies
composer install

# Cài đặt Node.js dependencies
npm install
```

### Bước 2: Cấu hình environment
```bash
# Copy file environment
cp .env.example .env

# Generate application key
php artisan key:generate
```

### Bước 3: Cấu hình database
```bash
# Tạo SQLite database (mặc định)
touch database/database.sqlite

# Hoặc cấu hình MySQL/PostgreSQL trong .env file
# DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=books_api
# DB_USERNAME=root
# DB_PASSWORD=

# Chạy migrations
php artisan migrate
```

### Bước 4: Build assets (development)
```bash
# Build assets cho development
npm run dev

# Hoặc build cho production
npm run build
```

### Bước 5: Chạy development server
```bash
# Chạy Laravel development server
php artisan serve

# Hoặc chạy tất cả services cùng lúc
composer run dev
```

### Bước 6: Truy cập ứng dụng
- **URL**: http://localhost:8000
- **Welcome Page**: Hiển thị trang welcome mặc định của Laravel

## Scripts có sẵn

### Composer Scripts
```bash
# Development với tất cả services
composer run dev

# Chạy tests
composer run test

# Post-install commands
composer run post-autoload-dump
composer run post-update-cmd
composer run post-create-project-cmd
```

### NPM Scripts
```bash
# Development build
npm run dev

# Production build
npm run build
```

## Cấu trúc database

### Bảng Users
```sql
CREATE TABLE users (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    email_verified_at TIMESTAMP NULL,
    password VARCHAR(255) NOT NULL,
    remember_token VARCHAR(100) NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);
```

### Bảng Password Reset Tokens
```sql
CREATE TABLE password_reset_tokens (
    email VARCHAR(255) PRIMARY KEY,
    token VARCHAR(255) NOT NULL,
    created_at TIMESTAMP NULL
);
```

### Bảng Sessions
```sql
CREATE TABLE sessions (
    id VARCHAR(255) PRIMARY KEY,
    user_id BIGINT UNSIGNED NULL,
    ip_address VARCHAR(45) NULL,
    user_agent TEXT NULL,
    payload LONGTEXT NOT NULL,
    last_activity INT NOT NULL,
    INDEX(user_id),
    INDEX(last_activity)
);
```

## Tính năng hiện tại

### ✅ Đã có sẵn
- Laravel 12 framework
- Authentication system (User model)
- Database migrations
- Tailwind CSS v4 styling
- Vite build system
- Axios HTTP client
- Testing framework (PHPUnit)
- Development tools (Laravel Pail, Laravel Pint)

### 🔄 Cần phát triển
- API endpoints cho books
- CRUD operations
- File upload functionality
- API authentication
- Validation rules
- Error handling
- API documentation

## Development Workflow

### 1. Tạo Controller mới
```bash
php artisan make:controller BookController --api
```

### 2. Tạo Model và Migration
```bash
php artisan make:model Book -m
```

### 3. Tạo API Routes
```bash
# Thêm vào routes/api.php
Route::apiResource('books', BookController::class);
```

### 4. Chạy Tests
```bash
php artisan test
```

### 5. Code Quality
```bash
# Laravel Pint (PHP CS Fixer)
./vendor/bin/pint

# Laravel Pail (Log viewer)
php artisan pail
```

## Troubleshooting

### Lỗi thường gặp

1. **Permission denied cho storage**
```bash
chmod -R 775 storage bootstrap/cache
```

2. **Composer dependencies không cài được**
```bash
composer install --ignore-platform-reqs
```

3. **Node modules không cài được**
```bash
npm cache clean --force
npm install
```

4. **Database connection failed**
```bash
# Kiểm tra .env file
# Đảm bảo database đã được tạo
php artisan config:clear
```

## Kết luận

Đây là một dự án Laravel mới với cấu trúc chuẩn, sẵn sàng để phát triển API cho books. Dự án sử dụng các công nghệ hiện đại và best practices của Laravel 12.

Để bắt đầu phát triển, hãy:
1. Cài đặt dependencies
2. Cấu hình database
3. Chạy migrations
4. Bắt đầu tạo API endpoints cho books

Dự án có cấu trúc rõ ràng và dễ mở rộng cho các tính năng mới. 