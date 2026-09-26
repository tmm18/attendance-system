勤怠管理システム
Dockerビルド
1. git@github.com:tmm18/attendance-system.git
2. docker-compose up -d -build

環境構築
1. docker-compose exec php bash
2. composer install
3. .env.exampleファイルから.env作成し、環境変数変更
4. php artisan key:generate
5. php artisan migrate

使用技術
・php:8.1-fpm
・Laravel 8.83.29
・MySQL 8.0.26

URL
・開発環境 http://localhost/
・phpMyAdmin http://localhost:8080/


