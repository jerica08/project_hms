<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class LaboratoryController extends Controller
{
    protected $labModel;
    protected $patientModel;
    
    public function __construct()
    {
        $this->labModel = new \App\Models\LaboratoryModel();
        $this->patientModel = new \App\Models\PatientModel();
    }

    public function index()
    {
        $data['pending_tests'] = $this->labModel->getPendingTests();
        $data['completed_tests'] = $this->labModel->getCompletedTests();
        $data['test_categories'] = $this->labModel->getTestCategories();
        
        return view('laboratory/index', $data);
    }

    public function testRequests()
    {
        $data['test_requests'] = $this->labModel->getAllTestRequests();
        return view('laboratory/test_requests', $data);
    }

    public function enterResults($testId)
    {
        if ($this->request->getMethod() === 'POST') {
            $resultData = [
                'test_id' => $testId,
                'result_value' => $this->request->getPost('result_value'),
                'normal_range' => $this->request->getPost('normal_range'),
                'status' => 'completed',
                'technician_id' => session('user_id'),
                'completed_at' => date('Y-m-d H:i:s'),
                'notes' => $this->request->getPost('notes')
            ];

            if ($this->labModel->enterTestResult($resultData)) {
                return redirect()->to('/laboratory')->with('success', 'Test results entered successfully');
            }
        }

        $data['test'] = $this->labModel->getTestById($testId);
        return view('laboratory/enter_results', $data);
    }

    public function generateReport($patientId)
    {
        $data['patient'] = $this->patientModel->getPatientById($patientId);
        $data['lab_results'] = $this->labModel->getPatientLabResults($patientId);
        
        return view('laboratory/patient_report', $data);
    }
}
