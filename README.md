# 🎉 OrganizeNow - Event Management System

![PHP](https://img.shields.io/badge/PHP-8.x-777BB4?style=for-the-badge&logo=php)
![MySQL](https://img.shields.io/badge/MySQL-Database-4479A1?style=for-the-badge&logo=mysql)
![HTML5](https://img.shields.io/badge/HTML5-E34F26?style=for-the-badge&logo=html5&logoColor=white)
![CSS3](https://img.shields.io/badge/CSS3-1572B6?style=for-the-badge&logo=css3&logoColor=white)
![JavaScript](https://img.shields.io/badge/JavaScript-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black)
![License](https://img.shields.io/badge/License-Educational-green?style=for-the-badge)

A complete **Event Management System** developed using **PHP, MySQL, HTML, CSS, and JavaScript**. OrganizeNow connects customers with event service providers through a complete event booking platform featuring secure authentication, booking management, Razorpay payment integration, PDF invoice generation, email notifications, and dedicated dashboards for Customers, Merchants, and Administrators.

---

## 📌 Features

### 👤 Customer Module

- Customer Registration & Login
- Browse Events & Services
- View Event Details
- Book Events with Preferred Date
- Track Booking Status (Pending, Accepted, Rejected)
- Secure Online Payment using Razorpay
- View Booking History
- Download PDF Invoice
- Receive Email Notifications
- Submit Reviews & Ratings

---

### 🏢 Merchant Module

- Merchant Registration & Login
- Dashboard Overview
- Create Full Event Packages
- Create Individual Services
- Edit/Delete Events & Services
- Accept or Reject Booking Requests
- View Customer Information
- Track Payment Status
- Manage Bookings
- View Customer Reviews & Ratings

---

### 👨‍💼 Admin Module

- Secure Admin Login
- Manage Customers
- Manage Merchants
- Manage Events
- Manage Services
- Manage Bookings
- Monitor Payments
- Full System Administration

---

## 🎊 Event Categories

- Wedding Event
- Birthday Event
- Engagement Event
- Anniversary Event

---

## 🛠️ Service Categories

- Catering
- Venue
- Decoration
- Photography
- Entertainment

---

## 💳 Payment Features

- Razorpay Payment Gateway Integration
- Secure Online Payment
- Payment Verification
- Payment Status Tracking
- PDF Invoice Generation

---

## 📧 Email Notification Features

- Registration Confirmation
- Booking Request Notification
- Booking Accepted Notification
- Booking Rejected Notification
- Payment Confirmation Email

---

# 💻 Technology Stack

## Frontend

- HTML5
- CSS3
- JavaScript

## Backend

- PHP

## Database

- MySQL

## Libraries & APIs

- Razorpay PHP SDK
- PHPMailer
- TCPDF

---

# 📂 Project Structure

```text
OrganizeNow/
│
├── Admin/
├── Customer/
├── Merchant/
├── razorpay-php/
├── .gitattributes
├── .gitignore
├── connection.php
├── index.php
├── merchant_login.php
├── merchant_signup.php
├── user_signup.php
├── AboutUs.php
├── DB_Structure.sql
└── README.md
```

---

# 🔄 Customer Workflow

```text
Register/Login
      │
      ▼
Browse Events
      │
      ▼
Book Event
      │
      ▼
Merchant Receives Request
      │
      ▼
Accept / Reject
      │
      ▼
Online Payment
      │
      ▼
Booking Confirmed
      │
      ▼
Download Invoice
      │
      ▼
Review & Rating
```

---

# 🔄 Merchant Workflow

```text
Merchant Login
       │
       ▼
Create Event / Service
       │
       ▼
Receive Booking Request
       │
       ▼
Accept / Reject Booking
       │
       ▼
Payment Received
       │
       ▼
Manage Customers
```

---

# 🚀 Installation Guide

### 1. Clone the Repository

```bash
git clone https://github.com/nadeemm26/OrganizeNow.git
```

### 2. Move the Project

Copy the project folder into your XAMPP `htdocs` directory.

```text
C:\xampp\htdocs\OrganizeNow
```

### 3. Create Database

Create a database named:

```text
organizenow
```

### 4. Import Database

Import the following SQL file:

```text
DB_Structure.sql
```

### 5. Configure Database

Open `connection.php` and update your database credentials.

```php
$host = "localhost";
$user = "root";
$password = "";
$db = "organizenow";
```

### 6. Start XAMPP

- Apache
- MySQL

### 7. Open Project

```text
http://localhost/OrganizeNow
```

---

# 🔐 User Roles

| Role | Responsibilities |
|------|------------------|
| Customer | Browse, Book Events, Make Payments, Review Services |
| Merchant | Manage Events, Services, Bookings & Payments |
| Admin | Manage Entire System |

---

# 📚 Learning Outcomes

This project demonstrates practical implementation of:

- Authentication & Authorization
- Role-Based Access Control
- CRUD Operations
- Session Management
- Booking Management System
- Payment Gateway Integration
- Email Notification System
- PDF Invoice Generation
- MySQL Database Design
- Responsive User Interface

---

# 👨‍💻 Developer

## Nadeem Makwana

**MCA Student | Aspiring PHP & Python Developer**

### Technical Skills

- PHP
- MySQL
- HTML5
- CSS3
- JavaScript

### GitHub

https://github.com/nadeemm26

### LinkedIn

https://linkedin.com/in/nadeem-makwana

---

# ⭐ Support

If you found this project helpful, don't forget to ⭐ Star this repository.

---

# 📄 License

This project is developed for **educational and learning purposes only**.

---

### ❤️ Thank you for visiting OrganizeNow!
