# 🧁 Sarah’s Short Cakes – Order Management System

A complete web-based **Cupcake Order Management System** built for bakeries and small businesses to manage orders, customers, inventory, and staff roles — all in one place. This project supports **self-service ordering**, **role-based logins**, and **beautiful UI with Tailwind CSS**.

---

## 🌐 Live Preview

https://zebo.et/SAD/index.php
---

## 🎯 Features

### 👩‍🍳 Customer Side
- 🍰 Self-order cupcakes easily
- 🧾 View order confirmation and summary

### 🔐 Admin & Staff Panel (Secure Login)
- 🔑 Role-based access: Admin, Employee, Delivery Staff
- 📊 Dashboard with key stats and announcements

### 🧑‍💼 Employee
- 📋 Add and manage new orders
- 👥 View customer list

### 🧑‍💼 Manager
- 🗂️ Inventory Management
- 📅 Daily reports
- 🛠 Role and access control

### 🚚 Delivery Staff
- 🚦 View delivery orders
- ✅ Mark orders as delivered

### 📦 Inventory Features
- 📈 Stock levels auto-deducted on order
- 🕓 Stock change logs/history


---

## 🛠️ Tech Stack

- ✅ **PHP** – Backend logic
- ✅ **MySQL** – Database
- ✅ **HTML/CSS/JavaScript** – Frontend
- ✅ **Tailwind CSS** – Modern, responsive UI
- ✅ **VS Code** – Development environment

---

## ⚙️ Setup Instructions

1. **Clone the repo**

   ```bash
   git clone https://github.com/your-username/sarahs-cupcake-system.git
2. Import the SQL database

Use phpMyAdmin or any MySQL client

Import cupcake_system.sql

3. Configure Database

Open includes/db.php and update your DB credentials

4. Run on Localhost

Place project in htdocs (XAMPP/Laragon/etc.)

Visit http://localhost/sarahs-cupcake-system/

💡 Use Case
Perfect for:

. Small bakeries

. Home-based cupcake businesses

. Students building capstone or web dev projects


👨‍💻 Author
Natnael22sds
GitHub: https://github.com/Natnael22sds

📸 Screenshots
![Capturer1](https://github.com/user-attachments/assets/6c6be521-a34f-40ad-8366-edd63183c794)
![Capturer2](https://github.com/user-attachments/assets/591abcec-dccf-48c3-ae20-b25d31cf6470)
![Capturer4](https://github.com/user-attachments/assets/ff9b9a25-486d-4cef-815d-4b3d7625066d)
![Capturer5](https://github.com/user-attachments/assets/3c2ca5db-548f-49b7-9189-fef3e37d799a)
![Capturer6](https://github.com/user-attachments/assets/84947978-4638-4886-bc7f-395793a58696)


## 📁 Project Structure

```bash
sarahs-cupcake-system/
├── index.php                     # Landing or login redirect
├── login.php                     # Secure login page
├── dashboard/
│   ├── employee_dashboard.php    # Dashboard for employees
│   ├── manager_dashboard.php     # Dashboard for managers
│   ├── delivery_dashboard.php    # Dashboard for delivery staff
│   └── common/
│       ├── sidebar.php           # Common sidebar for all dashboards
│       ├── header.php            # Page header and navigation
│       └── footer.php            # Footer layout
├── orders/
│   ├── new_order.php             # Order entry form
│   ├── order_list.php            # List of all orders
│   └── order_details.php         # Detailed order view
├── customers/
│   └── manage_customers.php      # View and manage customer info
├── inventory/
│   ├── stock_list.php            # Current stock items
│   ├── add_stock.php             # Add new stock items
│   └── stock_log.php             # Stock change history
├── reports/
│   └── daily_report.php          # Daily business reports
├── includes/
│   └── db.php                    # Database connection config
├── assets/
│   ├── css/                      # Tailwind CSS and custom styles
│   ├── js/                       # JavaScript files
│   └── images/                   # Product and UI images
└── README.md                     # Project documentation


