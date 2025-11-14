<?php

namespace App\Http\Controllers;

use App\Models\JobApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Barryvdh\DomPDF\Facade\Pdf;

class JobApplicationController extends Controller
{
    private array $steps = [
        1 => 'Personal Details',
        2 => 'Work History',
        3 => 'Education & Training',
        4 => 'Professional & Payment Details',
        5 => 'Health & Safety Declarations',
        6 => 'References & Availability',
    ];

    // Public form methods
    public function showStep(Request $request, int $step = 1)
    {
        if ($step < 1 || $step > 6) {
            return redirect()->route('job-application.step', 1);
        }

        $formData = Session::get('job_application_form', []);
        
        return view('job-application.step-' . $step, [
            'step' => $step,
            'steps' => $this->steps,
            'formData' => $formData,
        ]);
    }

    public function storeStep(Request $request, int $step)
    {
        $validated = $this->validateStep($request, $step);
        
        $formData = Session::get('job_application_form', []);
        $formData['step_' . $step] = $validated;
        Session::put('job_application_form', $formData);

        if ($step < 6) {
            return redirect()->route('job-application.step', $step + 1);
        }

        return redirect()->route('job-application.review');
    }

    public function review()
    {
        $formData = Session::get('job_application_form', []);
        
        if (empty($formData)) {
            return redirect()->route('job-application.step', 1);
        }

        return view('job-application.review', [
            'formData' => $formData,
            'steps' => $this->steps,
        ]);
    }

    public function submit(Request $request)
    {
        $formData = Session::get('job_application_form', []);
        
        if (empty($formData)) {
            return redirect()->route('job-application.step', 1)->with('error', 'Session expired. Please start again.');
        }

        DB::transaction(function () use ($formData) {
            $step1 = $formData['step_1'] ?? [];
            $step2 = $formData['step_2'] ?? [];
            $step3 = $formData['step_3'] ?? [];
            $step4 = $formData['step_4'] ?? [];
            $step5 = $formData['step_5'] ?? [];
            $step6 = $formData['step_6'] ?? [];

            // Create main application
            $application = JobApplication::create([
                // Step 1: Personal Details
                'title' => $step1['title'] ?? null,
                'date_of_birth' => $step1['date_of_birth'] ?? null,
                'forename' => $step1['forename'] ?? null,
                'surname' => $step1['surname'] ?? null,
                'previous_name' => $step1['previous_name'] ?? null,
                'gender' => $step1['gender'] ?? null,
                'marital_status' => $step1['marital_status'] ?? null,
                'ni_number' => $step1['ni_number'] ?? null,
                'address' => $step1['address'] ?? null,
                'postcode' => $step1['postcode'] ?? null,
                'mobile_number' => $step1['mobile_number'] ?? null,
                'landline' => $step1['landline'] ?? null,
                'email' => $step1['email'] ?? null,
                'next_of_kin_name' => $step1['next_of_kin_name'] ?? null,
                'next_of_kin_relationship' => $step1['next_of_kin_relationship'] ?? null,
                'next_of_kin_phone' => $step1['next_of_kin_phone'] ?? null,
                'next_of_kin_address' => $step1['next_of_kin_address'] ?? null,
                'next_of_kin_postcode' => $step1['next_of_kin_postcode'] ?? null,
                'next_of_kin_email' => $step1['next_of_kin_email'] ?? null,
                
                // Step 2: Current Job
                'current_job_title' => $step2['current_job_title'] ?? null,
                'current_pay' => $step2['current_pay'] ?? null,
                'current_duties' => $step2['current_duties'] ?? null,
                'current_place_of_work' => $step2['current_place_of_work'] ?? null,
                'current_shift_type' => $step2['current_shift_type'] ?? null,
                
                // Step 4: Professional & Payment
                'professional_body' => $step4['professional_body'] ?? null,
                'pin' => $step4['pin'] ?? null,
                'renewal_date' => $step4['renewal_date'] ?? null,
                'pvg_clear' => $step4['pvg_clear'] ?? null,
                'pvg_issue_date' => $step4['pvg_issue_date'] ?? null,
                'pvg_number' => $step4['pvg_number'] ?? null,
                'pvg_updated_service' => $step4['pvg_updated_service'] ?? null,
                'bank_name' => $step4['bank_name'] ?? null,
                'account_name' => $step4['account_name'] ?? null,
                'account_type' => $step4['account_type'] ?? null,
                'bank_branch_address' => $step4['bank_branch_address'] ?? null,
                'bank_postcode' => $step4['bank_postcode'] ?? null,
                'account_number' => $step4['account_number'] ?? null,
                'sort_code' => $step4['sort_code'] ?? null,
                'has_uk_license' => $step4['has_uk_license'] ?? null,
                'has_car' => $step4['has_car'] ?? null,
                
                // Step 5: Declarations
                'health_declaration' => $step5['health_declaration'] ?? null,
                'disability_declaration' => $step5['disability_declaration'] ?? null,
                'confidentiality_declaration' => $step5['confidentiality_declaration'] ?? null,
                'photo_consent' => $step5['photo_consent'] ?? null,
                'personal_declaration' => $step5['personal_declaration'] ?? null,
                'working_time_declaration' => $step5['working_time_declaration'] ?? null,
                'other_declaration' => $step5['other_declaration'] ?? null,
                'health_safety_declaration' => $step5['health_safety_declaration'] ?? null,
                'right_to_work_status' => $step5['right_to_work_status'] ?? null,
                'has_convictions' => $step5['has_convictions'] ?? null,
                'convictions_details' => $step5['convictions_details'] ?? null,
                'has_disciplinary' => $step5['has_disciplinary'] ?? null,
                'disciplinary_details' => $step5['disciplinary_details'] ?? null,
                'has_criminal_charges' => $step5['has_criminal_charges'] ?? null,
                'criminal_charges_details' => $step5['criminal_charges_details'] ?? null,
                'consents_police_check' => $step5['consents_police_check'] ?? null,
                'police_checked_recently' => $step5['police_checked_recently'] ?? null,
                'police_check_details' => $step5['police_check_details'] ?? null,
                
                // Step 6: Availability
                'work_preferences' => $step6['work_preferences'] ?? null,
                'availability_other' => $step6['availability_other'] ?? null,
                'start_date' => $step6['start_date'] ?? null,
                'interview_availability' => $step6['interview_availability'] ?? null,
                'has_holidays_booked' => $step6['has_holidays_booked'] ?? null,
                'holidays_dates' => $step6['holidays_dates'] ?? null,
                
                'status' => 'pending',
            ]);

            // Step 2: Work Histories
            if (!empty($step2['work_histories'])) {
                foreach ($step2['work_histories'] as $index => $history) {
                    if (!empty(array_filter($history))) {
                        $application->workHistories()->create([
                            'from_date' => $history['from_date'] ?? null,
                            'to_date' => $history['to_date'] ?? null,
                            'employer_name' => $history['employer_name'] ?? null,
                            'job_title' => $history['job_title'] ?? null,
                            'main_responsibilities' => $history['main_responsibilities'] ?? null,
                            'employer_address' => $history['employer_address'] ?? null,
                            'reason_for_leaving' => $history['reason_for_leaving'] ?? null,
                            'display_order' => $index + 1,
                        ]);
                    }
                }
            }

            // Step 3: Educations
            if (!empty($step3['educations'])) {
                foreach ($step3['educations'] as $index => $education) {
                    if (!empty(array_filter($education))) {
                        $application->educations()->create([
                            'establishment' => $education['establishment'] ?? null,
                            'from_date' => $education['from_date'] ?? null,
                            'to_date' => $education['to_date'] ?? null,
                            'qualification' => $education['qualification'] ?? null,
                            'grade' => $education['grade'] ?? null,
                            'display_order' => $index + 1,
                        ]);
                    }
                }
            }

            // Step 3: Training
            if (!empty($step3['mandatory_training']) || !empty($step3['other_training'])) {
                $application->training()->create([
                    'mandatory_training' => $step3['mandatory_training'] ?? [],
                    'other_training' => $step3['other_training'] ?? null,
                ]);
            }

            // Step 4: Immunisations
            if (!empty($step4['immunisations'])) {
                $imm = $step4['immunisations'];
                $application->immunisation()->create([
                    'hep_b' => $imm['hep_b'] ?? null,
                    'tb' => $imm['tb'] ?? null,
                    'varicella' => $imm['varicella'] ?? null,
                    'measles' => $imm['measles'] ?? null,
                    'rubella' => $imm['rubella'] ?? null,
                    'hep_b_antigen' => $imm['hep_b_antigen'] ?? null,
                    'hep_c' => $imm['hep_c'] ?? null,
                    'hiv' => $imm['hiv'] ?? null,
                ]);
            }

            // Step 6: References
            if (!empty($step6['references'])) {
                foreach ($step6['references'] as $index => $reference) {
                    if (!empty(array_filter($reference))) {
                        $application->references()->create([
                            'name' => $reference['name'] ?? null,
                            'position' => $reference['position'] ?? null,
                            'company_address' => $reference['company_address'] ?? null,
                            'telephone' => $reference['telephone'] ?? null,
                            'email' => $reference['email'] ?? null,
                            'may_contact_now' => $reference['may_contact_now'] ?? null,
                            'reference_number' => $index + 1,
                        ]);
                    }
                }
            }

            // Step 6: Referrals
            if (!empty($step6['referrals'])) {
                foreach ($step6['referrals'] as $index => $referral) {
                    if (!empty(array_filter($referral))) {
                        $application->referrals()->create([
                            'name' => $referral['name'] ?? null,
                            'telephone' => $referral['telephone'] ?? null,
                            'referral_number' => $index + 1,
                        ]);
                    }
                }
            }
        });

        Session::forget('job_application_form');

        return redirect()->route('job-application.success');
    }

    public function success()
    {
        return view('job-application.success');
    }

    private function validateStep(Request $request, int $step): array
    {
        switch ($step) {
            case 1:
                return $request->validate([
                    'title' => 'nullable|string',
                    'date_of_birth' => 'nullable|date',
                    'forename' => 'required|string|max:255',
                    'surname' => 'required|string|max:255',
                    'previous_name' => 'nullable|string|max:255',
                    'gender' => 'nullable|string',
                    'marital_status' => 'nullable|string',
                    'ni_number' => 'nullable|string|max:20',
                    'address' => 'nullable|string',
                    'postcode' => 'nullable|string|max:20',
                    'mobile_number' => 'required|string|max:20',
                    'landline' => 'nullable|string|max:20',
                    'email' => 'required|email|max:255',
                    'next_of_kin_name' => 'nullable|string|max:255',
                    'next_of_kin_relationship' => 'nullable|string|max:255',
                    'next_of_kin_phone' => 'nullable|string|max:20',
                    'next_of_kin_address' => 'nullable|string',
                    'next_of_kin_postcode' => 'nullable|string|max:20',
                    'next_of_kin_email' => 'nullable|email|max:255',
                ]);
            
            case 2:
                return $request->validate([
                    'current_job_title' => 'nullable|string|max:255',
                    'current_pay' => 'nullable|numeric',
                    'current_duties' => 'nullable|string',
                    'current_place_of_work' => 'nullable|string|max:255',
                    'current_shift_type' => 'nullable|string',
                    'work_histories' => 'nullable|array',
                    'work_histories.*.from_date' => 'nullable|date',
                    'work_histories.*.to_date' => 'nullable|date',
                    'work_histories.*.employer_name' => 'nullable|string|max:255',
                    'work_histories.*.job_title' => 'nullable|string|max:255',
                    'work_histories.*.main_responsibilities' => 'nullable|string',
                    'work_histories.*.employer_address' => 'nullable|string',
                    'work_histories.*.reason_for_leaving' => 'nullable|string',
                ]);
            
            case 3:
                return $request->validate([
                    'educations' => 'nullable|array',
                    'educations.*.establishment' => 'nullable|string|max:255',
                    'educations.*.from_date' => 'nullable|string',
                    'educations.*.to_date' => 'nullable|string',
                    'educations.*.qualification' => 'nullable|string|max:255',
                    'educations.*.grade' => 'nullable|string|max:50',
                    'mandatory_training' => 'nullable|array',
                    'other_training' => 'nullable|string',
                ]);
            
            case 4:
                return $request->validate([
                    'professional_body' => 'nullable|string|max:255',
                    'pin' => 'nullable|string|max:50',
                    'renewal_date' => 'nullable|date',
                    'pvg_clear' => 'nullable|boolean',
                    'pvg_issue_date' => 'nullable|date',
                    'pvg_number' => 'nullable|string|max:50',
                    'pvg_updated_service' => 'nullable|boolean',
                    'bank_name' => 'nullable|string|max:255',
                    'account_name' => 'nullable|string|max:255',
                    'account_type' => 'nullable|string',
                    'bank_branch_address' => 'nullable|string',
                    'bank_postcode' => 'nullable|string|max:20',
                    'account_number' => 'nullable|string|max:20',
                    'sort_code' => 'nullable|string|max:20',
                    'has_uk_license' => 'nullable|boolean',
                    'has_car' => 'nullable|boolean',
                    'immunisations' => 'nullable|array',
                ]);
            
            case 5:
                return $request->validate([
                    'health_declaration' => 'nullable|array',
                    'disability_declaration' => 'nullable|array',
                    'confidentiality_declaration' => 'nullable|array',
                    'photo_consent' => 'nullable|array',
                    'personal_declaration' => 'nullable|array',
                    'working_time_declaration' => 'nullable|array',
                    'other_declaration' => 'nullable|array',
                    'health_safety_declaration' => 'nullable|array',
                    'right_to_work_status' => 'nullable|string',
                    'has_convictions' => 'nullable|boolean',
                    'convictions_details' => 'nullable|string',
                    'has_disciplinary' => 'nullable|boolean',
                    'disciplinary_details' => 'nullable|string',
                    'has_criminal_charges' => 'nullable|boolean',
                    'criminal_charges_details' => 'nullable|string',
                    'consents_police_check' => 'nullable|boolean',
                    'police_checked_recently' => 'nullable|boolean',
                    'police_check_details' => 'nullable|string',
                ]);
            
            case 6:
                return $request->validate([
                    'work_preferences' => 'nullable|array',
                    'availability_other' => 'nullable|string',
                    'start_date' => 'nullable|date',
                    'interview_availability' => 'nullable|date',
                    'has_holidays_booked' => 'nullable|boolean',
                    'holidays_dates' => 'nullable|string',
                    'references' => 'nullable|array',
                    'references.*.name' => 'nullable|string|max:255',
                    'references.*.position' => 'nullable|string|max:255',
                    'references.*.company_address' => 'nullable|string',
                    'references.*.telephone' => 'nullable|string|max:20',
                    'references.*.email' => 'nullable|email|max:255',
                    'references.*.may_contact_now' => 'nullable|boolean',
                    'referrals' => 'nullable|array',
                    'referrals.*.name' => 'nullable|string|max:255',
                    'referrals.*.telephone' => 'nullable|string|max:20',
                ]);
            
            default:
                return [];
        }
    }

    // Admin methods
    public function index()
    {
        $applications = JobApplication::latest()->paginate(20);
        
        return view('admin.job-applications.index', compact('applications'));
    }

    public function show(JobApplication $jobApplication)
    {
        $jobApplication->load([
            'workHistories',
            'educations',
            'training',
            'immunisation',
            'references',
            'referrals',
        ]);
        
        return view('admin.job-applications.show', compact('jobApplication'));
    }

    public function updateStatus(Request $request, JobApplication $jobApplication)
    {
        $request->validate([
            'status' => 'required|in:pending,under_review,approved,rejected',
            'admin_notes' => 'nullable|string',
        ]);

        $jobApplication->update([
            'status' => $request->status,
            'admin_notes' => $request->admin_notes,
        ]);

        return redirect()->back()->with('status', 'Application status updated successfully.');
    }

    public function destroy(JobApplication $jobApplication)
    {
        $jobApplication->delete();
        
        return redirect()->route('admin.job-applications.index')->with('status', 'Application deleted.');
    }

    public function exportPdf(JobApplication $jobApplication)
    {
        $jobApplication->load([
            'workHistories',
            'educations',
            'training',
            'immunisation',
            'references',
            'referrals',
        ]);

        $pdf = Pdf::loadView('admin.job-applications.pdf-complete', [
            'jobApplication' => $jobApplication,
        ]);

        $filename = 'job-application-' . $jobApplication->forename . '-' . $jobApplication->surname . '-' . $jobApplication->id . '.pdf';
        $filename = preg_replace('/[^A-Za-z0-9\-_.]/', '-', $filename);

        return $pdf->download($filename);
    }
}
