<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class PharmacyController extends Controller
{
    protected $pharmacyModel;
    protected $inventoryModel;
    
    public function __construct()
    {
        $this->pharmacyModel = new \App\Models\PharmacyModel();
        $this->inventoryModel = new \App\Models\InventoryModel();
    }

    public function index()
    {
        $data['prescriptions'] = $this->pharmacyModel->getPendingPrescriptions();
        $data['inventory_alerts'] = $this->inventoryModel->getLowStockItems();
        $data['expiring_medications'] = $this->inventoryModel->getExpiringMedications();
        
        return view('pharmacy/index', $data);
    }

    public function dispenseMedication($prescriptionId)
    {
        if ($this->request->getMethod() === 'POST') {
            $dispensingData = [
                'prescription_id' => $prescriptionId,
                'quantity_dispensed' => $this->request->getPost('quantity_dispensed'),
                'batch_number' => $this->request->getPost('batch_number'),
                'dispensed_by' => session('user_id'),
                'dispensed_at' => date('Y-m-d H:i:s'),
                'patient_counseled' => $this->request->getPost('patient_counseled') ? 1 : 0,
                'notes' => $this->request->getPost('notes')
            ];

            if ($this->pharmacyModel->dispenseMedication($dispensingData)) {
                // Update inventory
                $this->inventoryModel->updateStock($this->request->getPost('medication_id'), 
                    -$this->request->getPost('quantity_dispensed'));
                
                return redirect()->to('/pharmacy')->with('success', 'Medication dispensed successfully');
            }
        }

        $data['prescription'] = $this->pharmacyModel->getPrescriptionById($prescriptionId);
        return view('pharmacy/dispense_medication', $data);
    }

    public function inventoryManagement()
    {
        $data['inventory'] = $this->inventoryModel->getAllMedications();
        $data['low_stock'] = $this->inventoryModel->getLowStockItems();
        $data['expired'] = $this->inventoryModel->getExpiredMedications();
        
        return view('pharmacy/inventory', $data);
    }

    public function drugInteractionCheck()
    {
        if ($this->request->getMethod() === 'POST') {
            $medications = $this->request->getPost('medications');
            $interactions = $this->pharmacyModel->checkDrugInteractions($medications);
            
            return $this->response->setJSON($interactions);
        }

        return view('pharmacy/drug_interaction_check');
    }
}
