<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class BillingController extends Controller
{
    protected $billingModel;
    protected $patientModel;
    
    public function __construct()
    {
        $this->billingModel = new \App\Models\BillingModel();
        $this->patientModel = new \App\Models\PatientModel();
    }

    public function index()
    {
        $data['invoices'] = $this->billingModel->getAllInvoices();
        $data['pending_payments'] = $this->billingModel->getPendingPayments();
        $data['overdue_accounts'] = $this->billingModel->getOverdueAccounts();
        
        return view('billing/index', $data);
    }

    public function generateInvoice()
    {
        if ($this->request->getMethod() === 'POST') {
            $invoiceData = [
                'invoice_id' => $this->generateInvoiceId(),
                'patient_id' => $this->request->getPost('patient_id'),
                'services' => json_encode($this->request->getPost('services')),
                'total_amount' => $this->request->getPost('total_amount'),
                'balance_amount' => $this->request->getPost('total_amount'),
                'due_date' => $this->request->getPost('due_date'),
                'payment_status' => 'pending',
                'created_at' => date('Y-m-d H:i:s')
            ];

            if ($this->billingModel->createInvoice($invoiceData)) {
                return redirect()->to('/billing')->with('success', 'Invoice generated successfully');
            }
        }

        $data['patients'] = $this->patientModel->getAllPatients();
        return view('billing/generate_invoice', $data);
    }

    public function processPayment()
    {
        if ($this->request->getMethod() === 'POST') {
            $paymentData = [
                'invoice_id' => $this->request->getPost('invoice_id'),
                'amount' => $this->request->getPost('amount'),
                'payment_method' => $this->request->getPost('payment_method'),
                'transaction_id' => $this->request->getPost('transaction_id'),
                'processed_by' => session('user_id'),
                'processed_at' => date('Y-m-d H:i:s')
            ];

            if ($this->billingModel->processPayment($paymentData)) {
                return redirect()->to('/billing')->with('success', 'Payment processed successfully');
            }
        }

        return view('billing/process_payment');
    }

    public function insuranceClaims()
    {
        $data['claims'] = $this->billingModel->getInsuranceClaims();
        return view('billing/insurance_claims', $data);
    }

    private function generateInvoiceId()
    {
        $prefix = 'INV';
        $year = date('Y');
        $lastInvoice = $this->billingModel->getLastInvoiceId();
        $sequence = $lastInvoice ? (int)substr($lastInvoice, -4) + 1 : 1;
        
        return $prefix . '-' . $year . '-' . str_pad($sequence, 4, '0', STR_PAD_LEFT);
    }
}
