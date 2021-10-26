## 這是啥？

練習用專案

-----

### 系統需求

- PHP 建議使用 8.0.11 以上

-----

### 使用方式

以下 `FOLDER_NAME` 自行替換成想要的資料夾名稱

- 執行 `git clone https://github.com/t301000-laravel/ntpc_scratch_example.git FOLDER_NAME`
- `cd FOLDER_NAME`
- 將 `.env.example` 複製為 `.env` 並修改資料庫或其他設定
- 執行 `composer install`
- 執行 `php artisan key:generate`
- 執行 `php artisan migrate --seed`
- 執行 `php artisan storage:link`
