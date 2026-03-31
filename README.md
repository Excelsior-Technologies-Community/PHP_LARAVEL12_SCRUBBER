# 🚀 PHP Laravel 12 Scrubber Service

This project demonstrates how to implement a **Service Layer Architecture in Laravel 12** to process and sanitize user input.

The application allows users to:

* Clean HTML content by removing tags
* Mask email addresses for privacy
* Store both original and cleaned data in the database
* Process multiple lines of input at once

The project follows a **clean architecture approach** where the business logic is handled inside a **Service Class**.

---

# ✨ Features

* ✅ HTML Content Scrubbing
* ✅ Email Masking for Privacy
* ✅ Service Layer Implementation
* ✅ Data Processing in Bulk
* ✅ Laravel MVC Architecture
* ✅ Database Storage for Audit History
* ✅ Simple UI using Blade
* ✅ Laravel 12 Compatible

---

# 🛠 Tech Stack

| Technology   | Description           |
| ------------ | --------------------- |
| Framework    | Laravel 12            |
| Language     | PHP 8.2+              |
| Database     | MySQL / SQLite        |
| Frontend     | Blade                 |
| Architecture | Service Layer Pattern |

---

# 📦 Installation Guide

Follow these steps to set up the project locally.

---

# 1️⃣ Create Laravel Project

Run the following command in your terminal:

```bash
composer create-project laravel/laravel PHP_Laravel12_Scrubber
cd PHP_Laravel12_Scrubber
```

---

# 2️⃣ Generate Required Files

Run the following Artisan commands:

```bash
php artisan make:model ScrubbedData -m
php artisan make:controller ScrubberController
```

Create the **Services directory**:

```bash
mkdir app/Services
```

Create the service file:

```bash
touch app/Services/ScrubberService.php
```

---

# 3️⃣ Configure Database

Open the `.env` file and update your database settings:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel_scrubber
DB_USERNAME=root
DB_PASSWORD=
```

---

# 4️⃣ Run Database Migration

```bash
php artisan migrate
```

This will create the **scrubbed_data table**.

---

# 📂 Project Structure

```
app
 ├── Models
 │    └── ScrubbedData.php
 │
 ├── Services
 │    └── ScrubberService.php
 │
 ├── Http
 │    └── Controllers
 │         └── ScrubberController.php

database
 └── migrations
      └── create_scrubbed_data_table.php

resources
 └── views
      └── scrubber
           └── index.blade.php

routes
 └── web.php
```

---

# 🧠 Core Components

## 1️⃣ Migration

File:

```
database/migrations/create_scrubbed_data_table.php
```

Creates the table used to store original and cleaned content.

```php
Schema::create('scrubbed_data', function (Blueprint $table) {
    $table->id();
    $table->text('original_content');
    $table->text('cleaned_content');
    $table->string('type');
    $table->timestamps();
});
```

---

# 2️⃣ Model

File:

```
app/Models/ScrubbedData.php
```

```php
class ScrubbedData extends Model
{
    protected $table = 'scrubbed_data';

    protected $fillable = [
        'original_content',
        'cleaned_content',
        'type'
    ];
}
```

This model allows **mass assignment** for saving processed records.

---

# 3️⃣ Service Layer

File:

```
app/Services/ScrubberService.php
```

The service handles all **data cleaning logic**.

```php
class ScrubberService
{
    public function cleanHtml($data)
    {
        return strip_tags($data);
    }

    public function maskEmail($email)
    {
        return preg_replace('/(?<=.).(?=.*@)/u', '*', $email);
    }
}
```

### Functions

| Function    | Purpose                |
| ----------- | ---------------------- |
| cleanHtml() | Removes HTML tags      |
| maskEmail() | Masks email characters |

---

# 4️⃣ Controller

File:

```
app/Http/Controllers/ScrubberController.php
```

The controller handles:

* Receiving user input
* Processing multiple lines
* Calling the service layer
* Storing results in the database

---

# 5️⃣ Routes

File:

```
routes/web.php
```

```php
Route::get('/', [ScrubberController::class, 'index']);
Route::post('/process', [ScrubberController::class, 'process']);
```

---

# 🖥 Application Workflow

1️⃣ User enters multiple lines of content.

2️⃣ User selects processing type:

* HTML Clean
* Email Mask

3️⃣ Controller sends the data to **ScrubberService**.

4️⃣ Service processes each line.

5️⃣ Results are saved in the **database**.

6️⃣ Cleaned output is displayed on the page.

---

# 📊 Example

### Input

```
<b>Hello World</b>
useremail@gmail.com
```

### Output

```
Hello World
u********@gmail.com
```

---

# 🔥 Why Use a Service Layer?

Benefits of using a **Service Class**:

* Cleaner Controllers
* Reusable Business Logic
* Easier Testing
* Better Code Organization

Instead of writing logic inside controllers, it is placed inside **ScrubberService**.

---

# 🚀 Future Improvements

Possible features to add:

* Export cleaned data to CSV
* Add API endpoints
* Support phone number masking
* Add validation rules
* Pagination for history records
* Admin dashboard

---

# 👨‍💻 Author

Developed with ❤️ by **Manav Sanchela**

#output
<img width="906" height="502" alt="image" src="https://github.com/user-attachments/assets/aff099bc-e67f-40a3-9246-fdba92a313f3" />

