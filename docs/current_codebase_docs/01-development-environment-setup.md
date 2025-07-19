# Development Environment Setup Guide (Ubuntu 24.04.1 LTS, PHP 8.4, PostgreSQL)

This guide will help you set up a local development environment for this project on a fresh Ubuntu 24.04.1 LTS system using PHP 8.4 and PostgreSQL.

---

## 1. System Update

```sh
sudo apt update && sudo apt upgrade -y
```

---

## 2. Install Core Tools

```sh
sudo apt install -y git curl wget unzip software-properties-common build-essential
```

---

## 3. Install PHP 8.4 and Extensions

> If PHP 8.4 is not in the default repos, add the Ondřej Surý PPA:

```sh
sudo add-apt-repository ppa:ondrej/php
sudo apt update
sudo apt install -y php8.4 php8.4-cli php8.4-fpm php8.4-pgsql php8.4-mbstring php8.4-xml php8.4-curl php8.4-bcmath php8.4-ctype php8.4-fileinfo php8.4-json php8.4-tokenizer php8.4-zip php8.4-pear php8.4-dev php8.4-gd php8.4-pcov php8.4-pcntl
```

---

## 4. Install Swoole (for Octane)

```sh
sudo apt install -y php-pear php8.4-dev
sudo pecl install swoole
# Enable Swoole extension
echo "extension=swoole" | sudo tee /etc/php/8.4/cli/conf.d/20-swoole.ini
```

---

## 5. Install Composer

```sh
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php composer-setup.php --install-dir=/usr/local/bin --filename=composer
rm composer-setup.php
```

---

## 6. Install Node.js (LTS) and npm

```sh
curl -fsSL https://deb.nodesource.com/setup_18.x | sudo -E bash -
sudo apt install -y nodejs
```

---

## 7. Install PostgreSQL

```sh
sudo apt install -y postgresql postgresql-contrib
```

- Start and enable PostgreSQL:
  ```sh
  sudo systemctl enable postgresql
  sudo systemctl start postgresql
  ```

- Create a database and user:
  ```sh
  sudo -u postgres psql
  # In the psql shell:
  CREATE DATABASE flylive;
  CREATE USER flyuser WITH PASSWORD 'flypassword';
  ALTER ROLE flyuser SET client_encoding TO 'utf8';
  ALTER ROLE flyuser SET default_transaction_isolation TO 'read committed';
  ALTER ROLE flyuser SET timezone TO 'UTC';
  GRANT ALL PRIVILEGES ON DATABASE flylive TO flyuser;
  \q
  ```

---

## 8. Clone the Project

```sh
git clone <repo-url>
cd backend
```

---

## 9. Install Project Dependencies

```sh
composer install
npm install
```

---

## 10. Configure Environment

```sh
cp .env.example .env
nano .env
# Set the following for PostgreSQL:
# DB_CONNECTION=pgsql
# DB_HOST=127.0.0.1
# DB_PORT=5432
# DB_DATABASE=flylive
# DB_USERNAME=flyuser
# DB_PASSWORD=flypassword
```

- Generate Laravel app key:
  ```sh
  php artisan key:generate
  ```

---

## 11. Run Migrations

```sh
php artisan migrate
```

---

## 12. Build Frontend Assets

```sh
npm run dev
# or for production:
npm run build
```

---

## 13. Start Octane Server

```sh
php artisan octane:start --server=swoole --host=127.0.0.1 --port=8000
```

---

## 14. (Optional) Start Background Jobs

```sh
php artisan queue:listen --tries=1
```

---

## 15. Run Tests and Linting

```sh
npm run lint
npm run format
./vendor/bin/pest
```

---

## 16. Troubleshooting & Tips

- **Swoole not found?**
  - Run `php -m | grep swoole`. If missing, repeat the PECL install and check your `php.ini`.
- **Database connection errors?**
  - Double-check `.env` DB settings and PostgreSQL user/database.
- **Permission errors?**
  - Use `sudo` as needed or fix file permissions.
- **Node/npm issues?**
  - Delete `node_modules` and `package-lock.json`, then run `npm install` again.
- **.env not loaded?**
  - Double-check file name and location. Run `php artisan config:clear`.

---

## 17. Recommended Tools

- **IDE:** VS Code, PhpStorm, etc.
- **DB Client:** DBeaver, TablePlus, or `psql`
- **API Client:** Postman, Insomnia, Hoppscotch

---

## 18. Docker (Optional)

If you prefer Docker for PostgreSQL:

```yaml
version: '3.8'
services:
  db:
    image: postgres:16
    environment:
      POSTGRES_DB: flylive
      POSTGRES_USER: flyuser
      POSTGRES_PASSWORD: flypassword
    ports:
      - "5432:5432"
    volumes:
      - db_data:/var/lib/postgresql/data
volumes:
  db_data:
```

---

**You are now ready to develop, test, and contribute to the project on Ubuntu 24.04.1 LTS with PHP 8.4 and PostgreSQL!** 