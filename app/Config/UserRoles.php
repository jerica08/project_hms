<?php

namespace Config;

class UserRoles
{
    /**
     * User Access Levels and Permissions
     * Based on HMS Role-Based Access Control System
     */
    
    public static $roles = [
        'hospital_administrator' => [
            'id' => 1,
            'name' => 'Hospital Administrator',
            'permissions' => [
                'full_control',
                'user_management',
                'system_reports',
                'branch_integration',
                'system_settings',
                'audit_logs',
                'financial_overview',
                'staff_management',
                'department_management'
            ],
            'dashboard' => 'admin-dashboard.html'
        ],
        
        'doctor' => [
            'id' => 2,
            'name' => 'Doctor',
            'permissions' => [
                'patient_records_full',
                'create_prescriptions',
                'request_tests',
                'view_lab_results',
                'patient_scheduling',
                'medical_history',
                'diagnosis_management',
                'treatment_plans'
            ],
            'dashboard' => 'doctor-dashboard.html'
        ],
        
        'nurse' => [
            'id' => 3,
            'name' => 'Nurse',
            'permissions' => [
                'patient_monitoring',
                'treatment_updates',
                'medication_administration',
                'vital_signs',
                'patient_care_notes',
                'shift_reports',
                'patient_scheduling_view'
            ],
            'dashboard' => 'nurse-dashboard.html'
        ],
        
        'receptionist' => [
            'id' => 4,
            'name' => 'Receptionist',
            'permissions' => [
                'patient_registration',
                'appointment_booking',
                'patient_check_in',
                'basic_patient_info',
                'appointment_scheduling',
                'visitor_management',
                'phone_directory'
            ],
            'dashboard' => 'receptionist-dashboard.html'
        ],
        
        'laboratory_staff' => [
            'id' => 5,
            'name' => 'Laboratory Staff',
            'permissions' => [
                'test_requests_management',
                'lab_results_entry',
                'specimen_tracking',
                'equipment_management',
                'quality_control',
                'lab_reports',
                'test_scheduling'
            ],
            'dashboard' => 'lab-dashboard.html'
        ],
        
        'pharmacist' => [
            'id' => 6,
            'name' => 'Pharmacist',
            'permissions' => [
                'medication_dispensing',
                'inventory_management',
                'prescription_verification',
                'drug_interaction_checks',
                'pharmacy_reports',
                'supplier_management',
                'expiry_tracking'
            ],
            'dashboard' => 'pharmacy-dashboard.html'
        ],
        
        'accountant' => [
            'id' => 7,
            'name' => 'Accountant',
            'permissions' => [
                'billing_management',
                'payment_processing',
                'insurance_claims',
                'financial_reports',
                'accounts_receivable',
                'collections',
                'revenue_tracking',
                'expense_management'
            ],
            'dashboard' => 'accountant-dashboard.html'
        ],
        
        'it_staff' => [
            'id' => 8,
            'name' => 'IT Staff',
            'permissions' => [
                'system_maintenance',
                'security_management',
                'user_support',
                'data_backups',
                'network_monitoring',
                'system_updates',
                'technical_support',
                'database_management'
            ],
            'dashboard' => 'it-dashboard.html'
        ]
    ];

    /**
     * System Features and Modules
     */
    public static $systemFeatures = [
        'patient_registration_ehr' => [
            'name' => 'Patient Registration & Electronic Health Records (EHR)',
            'description' => 'Complete patient management system with electronic health records',
            'modules' => [
                'patient_registration',
                'medical_history',
                'treatment_records',
                'document_management',
                'patient_search'
            ]
        ],
        
        'doctor_nurse_scheduling' => [
            'name' => 'Doctor/Nurse Scheduling',
            'description' => 'Staff scheduling and appointment management system',
            'modules' => [
                'staff_schedules',
                'appointment_booking',
                'shift_management',
                'availability_tracking',
                'schedule_conflicts'
            ]
        ],
        
        'billing_payment_processing' => [
            'name' => 'Billing & Payment Processing',
            'description' => 'Complete financial management for patient billing',
            'modules' => [
                'invoice_generation',
                'payment_processing',
                'insurance_billing',
                'payment_tracking',
                'financial_reports'
            ]
        ],
        
        'laboratory_diagnostic_management' => [
            'name' => 'Laboratory & Diagnostic Management',
            'description' => 'Lab test management and diagnostic reporting',
            'modules' => [
                'test_ordering',
                'sample_tracking',
                'result_entry',
                'report_generation',
                'equipment_management'
            ]
        ],
        
        'pharmacy_inventory_control' => [
            'name' => 'Pharmacy & Inventory Control',
            'description' => 'Medication management and inventory tracking',
            'modules' => [
                'prescription_management',
                'inventory_tracking',
                'supplier_management',
                'expiry_monitoring',
                'drug_interaction_checks'
            ]
        ],
        
        'centralized_database_branch_integration' => [
            'name' => 'Centralized Database with Branch Integration',
            'description' => 'Multi-branch data synchronization and management',
            'modules' => [
                'data_synchronization',
                'branch_management',
                'real_time_updates',
                'data_consistency',
                'backup_systems'
            ]
        ],
        
        'reports_analytics_dashboard' => [
            'name' => 'Reports & Analytics Dashboard',
            'description' => 'Comprehensive reporting and analytics system',
            'modules' => [
                'financial_reports',
                'operational_reports',
                'performance_analytics',
                'custom_reports',
                'data_visualization'
            ]
        ],
        
        'role_based_access_data_security' => [
            'name' => 'Role-Based User Access & Data Security',
            'description' => 'Security and access control management',
            'modules' => [
                'user_authentication',
                'role_management',
                'permission_control',
                'audit_logging',
                'data_encryption'
            ]
        ]
    ];

    /**
     * Get user role by ID
     */
    public static function getRoleById($roleId)
    {
        foreach (self::$roles as $key => $role) {
            if ($role['id'] == $roleId) {
                return $role;
            }
        }
        return null;
    }

    /**
     * Check if user has permission
     */
    public static function hasPermission($userRole, $permission)
    {
        if (!isset(self::$roles[$userRole])) {
            return false;
        }
        
        $rolePermissions = self::$roles[$userRole]['permissions'];
        return in_array($permission, $rolePermissions) || in_array('full_control', $rolePermissions);
    }

    /**
     * Get dashboard for user role
     */
    public static function getDashboard($userRole)
    {
        return self::$roles[$userRole]['dashboard'] ?? 'default-dashboard.html';
    }
}
