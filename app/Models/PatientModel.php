<?php

namespace App\Models;

use CodeIgniter\Model;

class PatientModel extends Model
{
    protected $table = 'patients';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'patient_id', 'first_name', 'last_name', 'date_of_birth', 'gender',
        'phone', 'email', 'address', 'emergency_contact_name', 'emergency_contact_phone',
        'insurance_provider', 'insurance_policy_number', 'medical_history',
        'allergies', 'current_medications', 'registration_date', 'status'
    ];

    public function getAllPatients()
    {
        return $this->where('status', 'active')->findAll();
    }

    public function getPatientById($patientId)
    {
        return $this->where('patient_id', $patientId)->first();
    }

    public function createPatient($data)
    {
        return $this->insert($data);
    }

    public function updatePatient($patientId, $data)
    {
        return $this->where('patient_id', $patientId)->set($data)->update();
    }

    public function searchPatients($searchTerm, $searchType = 'name')
    {
        switch ($searchType) {
            case 'id':
                return $this->like('patient_id', $searchTerm)->findAll();
            case 'phone':
                return $this->like('phone', $searchTerm)->findAll();
            case 'email':
                return $this->like('email', $searchTerm)->findAll();
            default:
                return $this->groupStart()
                    ->like('first_name', $searchTerm)
                    ->orLike('last_name', $searchTerm)
                    ->groupEnd()
                    ->findAll();
        }
    }

    public function getMedicalRecords($patientId)
    {
        return $this->db->table('medical_records')
            ->select('medical_records.*, users.first_name as doctor_first_name, users.last_name as doctor_last_name')
            ->join('users', 'users.id = medical_records.doctor_id')
            ->where('medical_records.patient_id', $patientId)
            ->orderBy('medical_records.visit_date', 'DESC')
            ->get()
            ->getResultArray();
    }

    public function addMedicalRecord($data)
    {
        return $this->db->table('medical_records')->insert($data);
    }

    public function getAppointments($patientId)
    {
        return $this->db->table('appointments')
            ->select('appointments.*, users.first_name as doctor_first_name, users.last_name as doctor_last_name')
            ->join('users', 'users.id = appointments.doctor_id')
            ->where('appointments.patient_id', $patientId)
            ->orderBy('appointments.appointment_date', 'DESC')
            ->get()
            ->getResultArray();
    }

    public function getPrescriptions($patientId)
    {
        return $this->db->table('prescriptions')
            ->select('prescriptions.*, users.first_name as doctor_first_name, users.last_name as doctor_last_name')
            ->join('users', 'users.id = prescriptions.doctor_id')
            ->where('prescriptions.patient_id', $patientId)
            ->orderBy('prescriptions.created_at', 'DESC')
            ->get()
            ->getResultArray();
    }

    public function getLabResults($patientId)
    {
        return $this->db->table('lab_results')
            ->select('lab_results.*, lab_tests.test_name, users.first_name as technician_first_name, users.last_name as technician_last_name')
            ->join('lab_tests', 'lab_tests.id = lab_results.test_id')
            ->join('users', 'users.id = lab_results.technician_id')
            ->where('lab_results.patient_id', $patientId)
            ->orderBy('lab_results.test_date', 'DESC')
            ->get()
            ->getResultArray();
    }

    public function getLastPatientId()
    {
        $result = $this->select('patient_id')
            ->orderBy('id', 'DESC')
            ->first();
        
        return $result ? $result['patient_id'] : null;
    }
}
