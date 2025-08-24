<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class SchedulingController extends Controller
{
    protected $appointmentModel;
    protected $userModel;
    
    public function __construct()
    {
        $this->appointmentModel = new \App\Models\AppointmentModel();
        $this->userModel = new \App\Models\UserModel();
    }

    /**
     * Doctor/Nurse Scheduling Dashboard
     */
    public function index()
    {
        $data['appointments'] = $this->appointmentModel->getTodaysAppointments();
        $data['doctors'] = $this->userModel->getUsersByRole(['doctor']);
        $data['nurses'] = $this->userModel->getUsersByRole(['nurse']);
        
        return view('scheduling/index', $data);
    }

    public function bookAppointment()
    {
        if ($this->request->getMethod() === 'POST') {
            $appointmentData = [
                'appointment_id' => $this->generateAppointmentId(),
                'patient_id' => $this->request->getPost('patient_id'),
                'doctor_id' => $this->request->getPost('doctor_id'),
                'appointment_date' => $this->request->getPost('appointment_date'),
                'appointment_time' => $this->request->getPost('appointment_time'),
                'appointment_type' => $this->request->getPost('appointment_type'),
                'duration' => $this->request->getPost('duration') ?? 30,
                'notes' => $this->request->getPost('notes'),
                'status' => 'scheduled',
                'created_by' => session('user_id'),
                'created_at' => date('Y-m-d H:i:s')
            ];

            if ($this->appointmentModel->createAppointment($appointmentData)) {
                return redirect()->to('/scheduling')->with('success', 'Appointment booked successfully');
            } else {
                return redirect()->back()->with('error', 'Failed to book appointment');
            }
        }

        $data['doctors'] = $this->userModel->getUsersByRole(['doctor']);
        $data['appointment_types'] = [
            'consultation' => 'General Consultation',
            'follow_up' => 'Follow-up Visit',
            'emergency' => 'Emergency',
            'surgery' => 'Surgery',
            'diagnostic' => 'Diagnostic Procedure'
        ];
        
        return view('scheduling/book_appointment', $data);
    }

    public function doctorSchedule($doctorId = null)
    {
        $doctorId = $doctorId ?? session('user_id');
        
        $data['doctor'] = $this->userModel->getUserById($doctorId);
        $data['appointments'] = $this->appointmentModel->getDoctorAppointments($doctorId);
        $data['schedule'] = $this->appointmentModel->getDoctorWeeklySchedule($doctorId);
        
        return view('scheduling/doctor_schedule', $data);
    }

    public function nurseSchedule($nurseId = null)
    {
        $nurseId = $nurseId ?? session('user_id');
        
        $data['nurse'] = $this->userModel->getUserById($nurseId);
        $data['assignments'] = $this->appointmentModel->getNurseAssignments($nurseId);
        $data['shifts'] = $this->appointmentModel->getNurseShifts($nurseId);
        
        return view('scheduling/nurse_schedule', $data);
    }

    public function updateAppointmentStatus()
    {
        $appointmentId = $this->request->getPost('appointment_id');
        $status = $this->request->getPost('status');
        $notes = $this->request->getPost('notes');

        $updateData = [
            'status' => $status,
            'notes' => $notes,
            'updated_at' => date('Y-m-d H:i:s')
        ];

        if ($this->appointmentModel->updateAppointment($appointmentId, $updateData)) {
            return $this->response->setJSON(['success' => true, 'message' => 'Appointment updated successfully']);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Failed to update appointment']);
        }
    }

    public function checkAvailability()
    {
        $doctorId = $this->request->getGet('doctor_id');
        $date = $this->request->getGet('date');
        
        $availability = $this->appointmentModel->getDoctorAvailability($doctorId, $date);
        
        return $this->response->setJSON($availability);
    }

    public function getCalendarEvents()
    {
        $start = $this->request->getGet('start');
        $end = $this->request->getGet('end');
        $userId = session('user_id');
        $userRole = session('user_role');

        if ($userRole === 'doctor') {
            $events = $this->appointmentModel->getDoctorCalendarEvents($userId, $start, $end);
        } elseif ($userRole === 'nurse') {
            $events = $this->appointmentModel->getNurseCalendarEvents($userId, $start, $end);
        } else {
            $events = $this->appointmentModel->getAllCalendarEvents($start, $end);
        }

        return $this->response->setJSON($events);
    }

    private function generateAppointmentId()
    {
        $prefix = 'APT';
        $year = date('Y');
        $lastAppointment = $this->appointmentModel->getLastAppointmentId();
        $sequence = $lastAppointment ? (int)substr($lastAppointment, -4) + 1 : 1;
        
        return $prefix . $year . str_pad($sequence, 4, '0', STR_PAD_LEFT);
    }
}
