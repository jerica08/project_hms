<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class PatientController extends Controller
{
    protected $patientModel;
    
    public function __construct()
    {
        $this->patientModel = new \App\Models\PatientModel();
    }

    /**
     * Patient Registration & EHR Management
     */
    public function index()
    {
        $data['patients'] = $this->patientModel->getAllPatients();
        return view('patients/index', $data);
    }

    public function register()
    {
        if ($this->request->getMethod() === 'POST') {
            $patientData = [
                'patient_id' => $this->generatePatientId(),
                'first_name' => $this->request->getPost('first_name'),
                'last_name' => $this->request->getPost('last_name'),
                'date_of_birth' => $this->request->getPost('date_of_birth'),
                'gender' => $this->request->getPost('gender'),
                'phone' => $this->request->getPost('phone'),
                'email' => $this->request->getPost('email'),
                'address' => $this->request->getPost('address'),
                'emergency_contact_name' => $this->request->getPost('emergency_contact_name'),
                'emergency_contact_phone' => $this->request->getPost('emergency_contact_phone'),
                'insurance_provider' => $this->request->getPost('insurance_provider'),
                'insurance_policy_number' => $this->request->getPost('insurance_policy_number'),
                'medical_history' => $this->request->getPost('medical_history'),
                'allergies' => $this->request->getPost('allergies'),
                'current_medications' => $this->request->getPost('current_medications'),
                'registration_date' => date('Y-m-d H:i:s'),
                'status' => 'active'
            ];

            if ($this->patientModel->createPatient($patientData)) {
                return redirect()->to('/patients')->with('success', 'Patient registered successfully');
            } else {
                return redirect()->back()->with('error', 'Failed to register patient');
            }
        }

        return view('patients/register');
    }

    public function view($patientId)
    {
        $data['patient'] = $this->patientModel->getPatientById($patientId);
        $data['medical_records'] = $this->patientModel->getMedicalRecords($patientId);
        $data['appointments'] = $this->patientModel->getAppointments($patientId);
        $data['prescriptions'] = $this->patientModel->getPrescriptions($patientId);
        $data['lab_results'] = $this->patientModel->getLabResults($patientId);

        return view('patients/view', $data);
    }

    public function edit($patientId)
    {
        if ($this->request->getMethod() === 'POST') {
            $updateData = [
                'first_name' => $this->request->getPost('first_name'),
                'last_name' => $this->request->getPost('last_name'),
                'phone' => $this->request->getPost('phone'),
                'email' => $this->request->getPost('email'),
                'address' => $this->request->getPost('address'),
                'emergency_contact_name' => $this->request->getPost('emergency_contact_name'),
                'emergency_contact_phone' => $this->request->getPost('emergency_contact_phone'),
                'insurance_provider' => $this->request->getPost('insurance_provider'),
                'insurance_policy_number' => $this->request->getPost('insurance_policy_number'),
                'updated_at' => date('Y-m-d H:i:s')
            ];

            if ($this->patientModel->updatePatient($patientId, $updateData)) {
                return redirect()->to("/patients/view/{$patientId}")->with('success', 'Patient updated successfully');
            }
        }

        $data['patient'] = $this->patientModel->getPatientById($patientId);
        return view('patients/edit', $data);
    }

    public function addMedicalRecord($patientId)
    {
        if ($this->request->getMethod() === 'POST') {
            $recordData = [
                'patient_id' => $patientId,
                'doctor_id' => session('user_id'),
                'visit_date' => $this->request->getPost('visit_date'),
                'chief_complaint' => $this->request->getPost('chief_complaint'),
                'diagnosis' => $this->request->getPost('diagnosis'),
                'treatment_plan' => $this->request->getPost('treatment_plan'),
                'vital_signs' => json_encode([
                    'blood_pressure' => $this->request->getPost('blood_pressure'),
                    'heart_rate' => $this->request->getPost('heart_rate'),
                    'temperature' => $this->request->getPost('temperature'),
                    'weight' => $this->request->getPost('weight'),
                    'height' => $this->request->getPost('height')
                ]),
                'notes' => $this->request->getPost('notes'),
                'created_at' => date('Y-m-d H:i:s')
            ];

            if ($this->patientModel->addMedicalRecord($recordData)) {
                return redirect()->to("/patients/view/{$patientId}")->with('success', 'Medical record added successfully');
            }
        }

        $data['patient'] = $this->patientModel->getPatientById($patientId);
        return view('patients/add_medical_record', $data);
    }

    public function search()
    {
        $searchTerm = $this->request->getGet('q');
        $searchType = $this->request->getGet('type') ?? 'name';

        $results = $this->patientModel->searchPatients($searchTerm, $searchType);
        
        return $this->response->setJSON($results);
    }

    private function generatePatientId()
    {
        $prefix = 'PAT';
        $year = date('Y');
        $lastPatient = $this->patientModel->getLastPatientId();
        $sequence = $lastPatient ? (int)substr($lastPatient, -4) + 1 : 1;
        
        return $prefix . $year . str_pad($sequence, 4, '0', STR_PAD_LEFT);
    }
}
