Project using Laravel,Tailwind Css ,Javacript,Chart js, 
DB = MySql(Xampp)
Name:Inventory Management System
📋 Requirements
PHP 8.1+
Composer
MySQL 5.7+
Node.js (for asset compilation)

🗄️ Database Schema
Main Tables
users - System administrators

categories - Product categories

products - Product information and stock

customers - Customer details

orders - Customer orders

sales - Sales invoices

Key Relationships
Products belong to Categories

Orders and Sales belong to Customers and Products

Automatic stock deduction on order/sale creation

///processes
Product Management
Add Products: Auto-generated product codes (PRD-YYYYMMD-XXX)

Stock Tracking: Real-time stock updates

Categories: Organize products by category

Low Stock Alerts: Visual indicators for stock < 10 units

Order Processing
Create new orders with customer and product selection

Automatic stock deduction

Track order status (Pending/Delivered)

Filter orders by status

Sales & Invoices
Generate sales invoices

Track payment status

Download PDF invoices

Automatic invoice numbering (INV-YYYYMMD-XXX)
