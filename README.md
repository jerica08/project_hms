# Hospital Management System (HMS) - Dashboard Frontend

A comprehensive, role-based Hospital Management System with modern, responsive dashboard interfaces for all hospital staff roles.

## 🏥 System Overview

This HMS provides specialized dashboards for 8 different hospital roles, each with tailored functionality and access levels:

- **Hospital Administrator** - Full system control, user management, branch integration
- **Doctor** - Patient records, prescriptions, EHR access, appointments
- **Nurse** - Patient monitoring, medication administration, treatment updates
- **Receptionist** - Patient registration, appointment booking, insurance verification
- **Laboratory Staff** - Test management, sample tracking, equipment monitoring
- **Pharmacist** - Inventory management, prescription dispensing, drug interactions
- **Accountant** - Billing, payments, insurance claims, financial reports
- **IT Staff** - System maintenance, security, backups, user support

## 🚀 Quick Start

1. **Access the System**
   ```
   http://localhost/project%20hms/public/
   ```

2. **Login Credentials (Demo)**
   - Username: `demo`
   - Password: `demo123`
   - Role: Select any role from dropdown

3. **Direct Dashboard Access**
   - Main Portal: `public/index.html`
   - Login Page: `public/login.html`
   - Individual Dashboards: `public/dashboards/[role]-dashboard.html`

## 📁 Project Structure

```
project hms/
├── public/
│   ├── assets/css/
│   │   └── dashboard-common.css     # Shared styling framework
│   ├── dashboards/
│   │   ├── admin-dashboard.html     # Hospital Administrator
│   │   ├── doctor-dashboard.html    # Doctor Portal
│   │   ├── nurse-dashboard.html     # Nurse Station
│   │   ├── receptionist-dashboard.html # Reception Desk
│   │   ├── lab-dashboard.html       # Laboratory
│   │   ├── pharmacist-dashboard.html # Pharmacy
│   │   ├── accountant-dashboard.html # Accounting
│   │   └── it-dashboard.html        # IT Operations
│   ├── index.html                   # Main portal with role selection
│   └── login.html                   # Authentication page
├── app/                            # CodeIgniter 4 backend (optional)
└── README.md
```

## 🎨 Features

### **Role-Based Access Control**
- Secure authentication system
- Role-specific dashboards and permissions
- Session management

### **Modern UI/UX**
- Responsive design for all devices
- Professional healthcare-focused styling
- Interactive elements and animations
- Consistent design language across all roles

### **Real-Time Monitoring**
- Live system status indicators
- Critical alerts and notifications
- Performance metrics and analytics
- Equipment and network monitoring

### **Comprehensive Functionality**
- Patient management and EHR
- Medication tracking and dispensing
- Laboratory test management
- Financial and billing operations
- System administration tools

## 🛠️ Technical Stack

- **Frontend**: HTML5, CSS3, JavaScript (ES6+)
- **Icons**: Font Awesome 6.0
- **Styling**: Custom CSS framework with CSS Grid and Flexbox
- **Backend Ready**: Built on CodeIgniter 4 framework
- **Database**: MySQL compatible (ready for integration)

## 📱 Responsive Design

All dashboards are fully responsive and optimized for:
- Desktop computers (1920px+)
- Tablets (768px - 1024px)
- Mobile phones (320px - 767px)

## 🔧 Server Requirements

- **Web Server**: Apache/Nginx
- **PHP**: Version 8.1 or higher
- **Extensions**: 
  - intl
  - mbstring
  - json
  - mysqlnd (for MySQL)
  - libcurl

## 🚀 Installation

1. **Clone or download** the project to your web server directory
2. **Configure web server** to point to the `public/` folder
3. **Access the system** via your web browser
4. **Use demo credentials** to explore different roles

## 📊 Dashboard Features by Role

### Hospital Administrator
- User management (247 users, 8 roles)
- Branch integration (5 branches, 98% uptime)
- System analytics and reporting
- Security monitoring and audit logs

### Doctor
- Patient appointments (12 today)
- Electronic Health Records (247 patients)
- Prescription management (156 this week)
- Lab results review (8 new results)

### Nurse
- Patient monitoring (8 assigned patients)
- Medication administration (24 due today)
- Vital signs tracking (6 due)
- Treatment plan updates

### Receptionist
- Appointment scheduling (47 today)
- Patient registration (8 new today)
- Insurance verification
- Waiting room management (12 waiting)

### Laboratory Staff
- Test requests (23 pending, 8 urgent)
- Sample management (45 received)
- Equipment monitoring (12 online)
- Quality control procedures

### Pharmacist
- Prescription processing (34 pending)
- Inventory management (847 items)
- Drug interaction screening (7 alerts)
- Controlled substance tracking

### Accountant
- Revenue tracking ($47,235 daily)
- Billing management (156 invoices)
- Insurance claims (89 submitted)
- Accounts receivable ($234K total)

### IT Staff
- System monitoring (98.7% uptime)
- Security management (247 active users)
- Data backups (100% success rate)
- Support tickets (12 open, 3 critical)

## 🔒 Security Features

- Role-based access control
- Session management
- Secure authentication
- Data validation and sanitization
- Audit logging capabilities

## 🎯 Future Enhancements

- Database integration
- Real-time notifications
- Advanced reporting
- Mobile app development
- API development
- Multi-language support

## 📞 Support

For technical support or questions about the HMS system, please contact the IT department or system administrator.

---

**Built with ❤️ for healthcare professionals**
