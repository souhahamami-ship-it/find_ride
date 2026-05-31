
# 🚗 RideShare Web App

A full-stack ride-sharing web application built with **HTML, CSS, JavaScript, PHP, and MySQL**.
Users can publish rides, book seats, and chat in real-time with drivers or passengers.

---

## 📌 Features

### 👤 User System

* Register & Login
* Profile management
* View personal stats

### 🚘 Rides

* Offer a ride
* Search available rides
* View ride details
* Prevent users from booking their own rides

### 📖 Bookings

* Book a ride
* Cancel booking
* View all bookings (Pending / Confirmed / Cancelled)

### 💬 Chat System

* Real-time messaging between users
* Conversations grouped per ride
* Auto-refresh messages
* Message history stored in database

---

## 🛠️ Technologies Used

* **Frontend:** HTML, CSS, JavaScript
* **Backend:** PHP (MySQLi)
* **Database:** MySQL
* **Server:** XAMPP (Apache + MySQL)

---

## 📂 Project Structure

```
find_ride/
│
├── frontend/
│   ├── profile.html
│   ├── find_ride.html
│   ├── login.html
│   └── ...
│
├── backend/
│   ├── connect.php
│   ├── send_message.php
│   ├── get_messages.php
│   ├── get_user_conversations.php
│   ├── book_ride.php
│   ├── cancel_booking.php
│   └── ...
│
└── database/
    └── SQL schema
```

---

## ⚙️ Installation & Setup

### 1️⃣ Clone or Download Project

Place the project inside:

```
C:\xampp\htdocs\find_ride
```

---

### 2️⃣ Start Server

* Open XAMPP
* Start **Apache**
* Start **MySQL**

---

### 3️⃣ Create Database

Open phpMyAdmin and run:

```sql
CREATE DATABASE find_ride;
```

Import your tables (`users`, `rides`, `bookings`, `messages`).

---

### 4️⃣ Configure Database Connection

Edit:

```
backend/connect.php
```

```php
$conn = new mysqli("localhost", "root", "", "find_ride");
```

---

### 5️⃣ Run the App

Open browser:

```
http://localhost/find_ride/frontend/profile.html
```

---

## 💬 API Endpoints (Examples)

| Endpoint                     | Description        |
| ---------------------------- | ------------------ |
| `send_message.php`           | Send a message     |
| `get_messages.php`           | Load chat messages |
| `get_user_conversations.php` | List conversations |
| `book_ride.php`              | Book a ride        |
| `cancel_booking.php`         | Cancel booking     |

---

## 🧠 Key Logic

### Chat System

* Messages stored in `messages` table
* Supports both sender → receiver directions
* Uses polling (auto-refresh every 2 seconds)

### Booking System

* Unique constraint prevents duplicate bookings
* Users cannot book their own ride

---

## 🚀 Future Improvements

* Real-time chat using WebSockets
* Notifications system
* Payment integration
* Mobile responsive UI
* Rating system for drivers

---

## 👨‍💻 Author

Developed as a full-stack web project.

---

## 📄 License

This project is for educational purposes.
