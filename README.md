# obat-digital

## 🧾 Tech Stack
- Laravel 11
- Tailwind
- Javascript AJAX


## 🚀 Cara Menjalankan Project Ini

### 1. **Clone Repository**
```
git clone https://github.com/username/nama-repo.git
cd nama-repo
```
### 2. **Install Dependencies**
```
composer install
npm install
```
### 3. **Copy File .env**
```
cp .env.example .env
```
### 4. **Generate Key & Set Up**
```
php artisan key:generate
```
```
edit .env sesuai konfigurasi database
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nama_database
DB_USERNAME=root
DB_PASSWORD=
```
### 5. **Migrasi**
```
php artisan migrate
```
### 6. **Run**
```
npm run dev
php artisan serve
```
