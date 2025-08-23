// HMS Demo Data and Navigation Helper
// This file provides sample data and navigation utilities for the HMS dashboard system

const HMS_DEMO_DATA = {
    // Sample patient data
    patients: [
        {
            id: 'P001',
            name: 'John Martinez',
            age: 45,
            gender: 'Male',
            condition: 'Post-Op Cardiac',
            room: 'ICU-101',
            doctor: 'Dr. Johnson',
            status: 'Critical',
            vitals: { bp: '180/110', hr: '120', temp: '98.6°F', o2: '95%' },
            lastVisit: '2025-08-21'
        },
        {
            id: 'P002',
            name: 'Sarah Wilson',
            age: 32,
            gender: 'Female',
            condition: 'Respiratory Distress',
            room: 'ICU-103',
            doctor: 'Dr. Smith',
            status: 'Stable',
            vitals: { bp: '120/80', hr: '85', temp: '99.1°F', o2: '88%' },
            lastVisit: '2025-08-20'
        },
        {
            id: 'P003',
            name: 'Robert Chen',
            age: 58,
            gender: 'Male',
            condition: 'Sepsis',
            room: 'ICU-105',
            doctor: 'Dr. Brown',
            status: 'Critical',
            vitals: { bp: '90/60', hr: '135', temp: '102.5°F', o2: '92%' },
            lastVisit: '2025-08-21'
        },
        {
            id: 'P004',
            name: 'Maria Garcia',
            age: 28,
            gender: 'Female',
            condition: 'Chest Pain',
            room: '201',
            doctor: 'Dr. Wilson',
            status: 'Stable',
            vitals: { bp: '110/70', hr: '78', temp: '98.4°F', o2: '98%' },
            lastVisit: '2025-08-21'
        },
        {
            id: 'P005',
            name: 'David Lee',
            age: 41,
            gender: 'Male',
            condition: 'Diabetes',
            room: '203',
            doctor: 'Dr. Martinez',
            status: 'Stable',
            vitals: { bp: '130/85', hr: '72', temp: '98.2°F', o2: '97%' },
            lastVisit: '2025-08-19'
        }
    ],

    // Sample appointments
    appointments: [
        {
            id: 'APT001',
            time: '09:00 AM',
            patient: 'John Smith',
            doctor: 'Dr. Johnson',
            type: 'Follow-up',
            status: 'Completed',
            room: 'Room 101'
        },
        {
            id: 'APT002',
            time: '09:30 AM',
            patient: 'Maria Garcia',
            doctor: 'Dr. Wilson',
            type: 'Consultation',
            status: 'In Progress',
            room: 'Room 102'
        },
        {
            id: 'APT003',
            time: '10:00 AM',
            patient: 'Robert Johnson',
            doctor: 'Dr. Brown',
            type: 'Check-up',
            status: 'Scheduled',
            room: 'Room 103'
        }
    ],

    // Sample medications
    medications: [
        {
            id: 'MED001',
            name: 'Lisinopril',
            dosage: '10mg',
            patient: 'Maria Garcia',
            time: '09:00 AM',
            status: 'Due',
            route: 'PO'
        },
        {
            id: 'MED002',
            name: 'Metformin',
            dosage: '500mg',
            patient: 'David Lee',
            time: '09:15 AM',
            status: 'Administered',
            route: 'PO'
        },
        {
            id: 'MED003',
            name: 'Insulin',
            dosage: '10 units',
            patient: 'David Wilson',
            time: '09:15 AM',
            status: 'Due',
            route: 'SC'
        }
    ],

    // Sample lab tests
    labTests: [
        {
            id: 'LAB001',
            sampleId: 'LAB-2025-001',
            patient: 'John Martinez',
            test: 'Cardiac Enzymes',
            priority: 'STAT',
            status: 'Processing',
            orderedBy: 'Dr. Johnson',
            received: '08:45 AM'
        },
        {
            id: 'LAB002',
            sampleId: 'LAB-2025-002',
            patient: 'Sarah Wilson',
            test: 'Blood Gas Analysis',
            priority: 'Urgent',
            status: 'Pending',
            orderedBy: 'Dr. Smith',
            received: '08:50 AM'
        }
    ],

    // Sample financial data
    financial: {
        dailyRevenue: 47235,
        collected: 32180,
        pending: 15055,
        totalAR: 234000,
        invoicesGenerated: 156,
        invoicesPending: 23,
        invoicesDisputed: 8
    },

    // Sample user roles and permissions
    roles: {
        admin: {
            name: 'Hospital Administrator',
            permissions: ['all'],
            dashboard: 'admin-dashboard.html'
        },
        doctor: {
            name: 'Doctor',
            permissions: ['patients', 'prescriptions', 'ehr', 'appointments'],
            dashboard: 'doctor-dashboard.html'
        },
        nurse: {
            name: 'Nurse',
            permissions: ['patients', 'medications', 'vitals', 'treatments'],
            dashboard: 'nurse-dashboard.html'
        },
        receptionist: {
            name: 'Receptionist',
            permissions: ['appointments', 'registration', 'insurance'],
            dashboard: 'receptionist-dashboard.html'
        },
        lab: {
            name: 'Laboratory Staff',
            permissions: ['tests', 'samples', 'results'],
            dashboard: 'lab-dashboard.html'
        },
        pharmacist: {
            name: 'Pharmacist',
            permissions: ['prescriptions', 'inventory', 'dispensing'],
            dashboard: 'pharmacist-dashboard.html'
        },
        accountant: {
            name: 'Accountant',
            permissions: ['billing', 'payments', 'financial'],
            dashboard: 'accountant-dashboard.html'
        },
        it: {
            name: 'IT Staff',
            permissions: ['system', 'security', 'maintenance'],
            dashboard: 'it-dashboard.html'
        }
    }
};

// Navigation utilities
const HMS_NAVIGATION = {
    // Get current user from session
    getCurrentUser: function() {
        const userStr = sessionStorage.getItem('hms_user');
        return userStr ? JSON.parse(userStr) : null;
    },

    // Navigate to specific dashboard
    navigateTo: function(role) {
        if (HMS_DEMO_DATA.roles[role]) {
            window.location.href = `dashboards/${HMS_DEMO_DATA.roles[role].dashboard}`;
        }
    },

    // Check if user has permission
    hasPermission: function(permission) {
        const user = this.getCurrentUser();
        if (!user) return false;
        
        const roleData = HMS_DEMO_DATA.roles[user.role];
        return roleData && (roleData.permissions.includes('all') || roleData.permissions.includes(permission));
    },

    // Logout function
    logout: function() {
        sessionStorage.removeItem('hms_user');
        window.location.href = '../login.html';
    },

    // Update page title based on role
    updatePageTitle: function() {
        const user = this.getCurrentUser();
        if (user && HMS_DEMO_DATA.roles[user.role]) {
            document.title = `${HMS_DEMO_DATA.roles[user.role].name} - HMS`;
        }
    }
};

// Data formatting utilities
const HMS_UTILS = {
    // Format currency
    formatCurrency: function(amount) {
        return new Intl.NumberFormat('en-US', {
            style: 'currency',
            currency: 'USD'
        }).format(amount);
    },

    // Format date
    formatDate: function(date) {
        return new Date(date).toLocaleDateString('en-US', {
            year: 'numeric',
            month: 'short',
            day: 'numeric'
        });
    },

    // Format time
    formatTime: function(time) {
        return new Date(time).toLocaleTimeString('en-US', {
            hour: '2-digit',
            minute: '2-digit'
        });
    },

    // Get status badge class
    getStatusBadge: function(status) {
        const statusMap = {
            'critical': 'badge-danger',
            'urgent': 'badge-warning',
            'stable': 'badge-success',
            'completed': 'badge-success',
            'pending': 'badge-warning',
            'scheduled': 'badge-info',
            'overdue': 'badge-danger',
            'processing': 'badge-warning',
            'approved': 'badge-success',
            'denied': 'badge-danger'
        };
        return statusMap[status.toLowerCase()] || 'badge-secondary';
    },

    // Generate random ID
    generateId: function(prefix = 'ID') {
        return `${prefix}-${Date.now()}-${Math.random().toString(36).substr(2, 9)}`;
    }
};

// Real-time updates simulation
const HMS_REALTIME = {
    // Simulate real-time updates
    startUpdates: function() {
        setInterval(() => {
            this.updateStats();
            this.updateAlerts();
        }, 30000); // Update every 30 seconds
    },

    // Update statistics
    updateStats: function() {
        const statNumbers = document.querySelectorAll('.stat-number');
        statNumbers.forEach(stat => {
            if (stat.textContent.includes('$')) {
                // Update financial numbers
                const current = parseFloat(stat.textContent.replace(/[$,]/g, ''));
                const change = Math.floor(Math.random() * 1000) - 500;
                stat.textContent = HMS_UTILS.formatCurrency(current + change);
            } else if (!isNaN(stat.textContent)) {
                // Update numeric stats
                const current = parseInt(stat.textContent);
                const change = Math.floor(Math.random() * 5) - 2;
                stat.textContent = Math.max(0, current + change);
            }
        });
    },

    // Update alerts
    updateAlerts: function() {
        // Simulate new alerts occasionally
        if (Math.random() < 0.1) { // 10% chance
            this.showNotification('New alert: Patient vitals require attention', 'warning');
        }
    },

    // Show notification
    showNotification: function(message, type = 'info') {
        const notification = document.createElement('div');
        notification.className = `notification notification-${type}`;
        notification.innerHTML = `
            <i class="fas fa-bell"></i>
            <span>${message}</span>
            <button onclick="this.parentElement.remove()">×</button>
        `;
        
        // Add to page
        document.body.appendChild(notification);
        
        // Auto remove after 5 seconds
        setTimeout(() => {
            if (notification.parentElement) {
                notification.remove();
            }
        }, 5000);
    }
};

// Initialize HMS system when page loads
document.addEventListener('DOMContentLoaded', function() {
    // Update page title
    HMS_NAVIGATION.updatePageTitle();
    
    // Start real-time updates
    HMS_REALTIME.startUpdates();
    
    // Add logout functionality to all logout buttons
    document.querySelectorAll('.logout-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            if (confirm('Are you sure you want to logout?')) {
                HMS_NAVIGATION.logout();
            }
        });
    });
});

// Export for use in other scripts
if (typeof module !== 'undefined' && module.exports) {
    module.exports = { HMS_DEMO_DATA, HMS_NAVIGATION, HMS_UTILS, HMS_REALTIME };
}
