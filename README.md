# 🍃 Robin Hood Army Management System (RHAMS)

A web-based platform designed to streamline and digitize the food donation operations of the **Robin Hood Army (NGO)** - connecting **Donors**, **Robins (Volunteers)**, and **Points of Contact (POCs)** to ensure surplus food reaches the needy efficiently and transparently.

---

## 📌 Overview

RHAMS replaces manual and unstructured communication with a **centralized management system** where:
- Donors can register and submit food donation requests
- Robins can view, manage, and fulfill donation pickups
- POCs can assign robins, track donations, and monitor performance analytics

The system enhances **coordination, accountability, and efficiency** in food redistribution.

---

## 🚀 Features
- Donor, Robin (volunteer), and POC login & role-based access  
- Donation request submission & real-time status tracking  
- Volunteer task assignment and activity dashboard  
- POC dashboard to monitor all donations & volunteers  
- Automated communication and workflow tracking 

---

## 🛠️ Tech Stack

| Layer | Technology |
|--------|-------------|
| **Frontend** | HTML, CSS, JavaScript |
| **Backend** | PHP |
| **Database** | MySQL |
| **Local Server** | XAMPP (Apache + MySQL) |
| **Tools Used** | phpMyAdmin, VS Code |

---

## 🚀 Installation & Setup (Localhost - XAMPP)

### ✅ Prerequisites
- Install **XAMPP** (Apache + MySQL enabled)
- Browser (Chrome / Edge / Firefox)
- Git installed (optional but recommended)

### 🔧 Steps to Run

1. Clone the repository
```
git clone https://github.com/swarali-17/Robin-Hood-Army-Management-System.git
```

2. Move project folder into XAMPP htdocs
```
C:/xampp/htdocs/Robin-Hood-Army-Management-System/
```

3. Start **Apache** & **MySQL** from XAMPP Control Panel

4. Open phpMyAdmin in browser:
```
http://localhost/phpmyadmin
```

5. Create a database (example name: robinhood)

6. Import the provided robinhood.sql file into this database

7. Open the project in browser:
```
http://localhost/Robin-Hood-Army-Management-System/
```

✅ The system should now be fully running on localhost.

---

## 🎥 Demo 
![Demo](demo.gif)


---

## 🔮 Future Enhancements
- Geotagged proof-of-delivery upload (volunteers)  
- Predictive container calculation based on food type & quantity  
- City-level expansion with multi-region support  
- Email / SMS based donor notifications  
- Analytics export (CSV / PDF)

---
