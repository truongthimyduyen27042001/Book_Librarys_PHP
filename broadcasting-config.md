# Cấu hình Broadcasting cho Laravel

## 1. Cấu hình .env

Thêm các dòng sau vào file `.env`:

```env
# Broadcasting Configuration
BROADCAST_DRIVER=redis
BROADCAST_CONNECTION=redis

# Redis Configuration
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379
REDIS_DB=0

# Queue Configuration (optional)
QUEUE_CONNECTION=redis
```

## 2. Cài đặt dependencies

```bash
composer require predis/predis
# hoặc
composer require phpredis/phpredis
```

## 3. Cấu hình config/broadcasting.php

Đảm bảo Redis connection được cấu hình đúng:

```php
'redis' => [
    'driver' => 'redis',
    'connection' => 'default',
],
```

## 4. Cấu hình config/database.php

Kiểm tra Redis connection trong `config/database.php`:

```php
'redis' => [
    'client' => env('REDIS_CLIENT', 'phpredis'),
    'default' => [
        'host' => env('REDIS_HOST', '127.0.0.1'),
        'password' => env('REDIS_PASSWORD', null),
        'port' => env('REDIS_PORT', 6379),
        'database' => env('REDIS_DB', 0),
    ],
],
```

## 5. Cài đặt Laravel Echo Server

```bash
npm install -g laravel-echo-server
```

## 6. Khởi tạo Echo Server

```bash
laravel-echo-server init
```

Chọn các options:
- Driver: redis
- Host: 127.0.0.1
- Port: 6379
- Database: 0

## 7. Chạy Echo Server

```bash
laravel-echo-server start
```

## 8. Test Broadcasting

1. Truy cập `/test-broadcast.html`
2. Click "Test /api/debug-broadcast"
3. Kiểm tra Echo Server logs
4. Kiểm tra browser console

## 9. Debug Steps

### Kiểm tra Redis:
```bash
redis-cli
> SUBSCRIBE laravel-database-chat-room.debug-room
```

### Kiểm tra Laravel logs:
```bash
tail -f storage/logs/laravel.log
```

### Kiểm tra Echo Server logs:
```bash
laravel-echo-server start --dev
```

## 10. Troubleshooting

### Vấn đề: Echo Server không nhận được data
- Kiểm tra `BROADCAST_DRIVER` trong .env
- Đảm bảo Redis service đang chạy
- Kiểm tra channel name trong Echo Server

### Vấn đề: Data không được truyền
- Kiểm tra `broadcastWith()` method trong Event
- Đảm bảo Event implements `ShouldBroadcastNow`
- Kiểm tra Laravel logs

### Vấn đề: Channel không được tạo
- Kiểm tra `broadcastOn()` method
- Đảm bảo channel name đúng format
- Kiểm tra Echo Server configuration
