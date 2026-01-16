<?php

namespace App\Http\Controllers;

use App\Models\JobApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

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

        // Step 1: Profile Photo
        if ($step === 1) {
            if ($request->hasFile('profile_photo') && $request->file('profile_photo')->isValid()) {
                $file = $request->file('profile_photo');
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('tmp/profile_photos', $filename, 'public');
                $validated['profile_photo'] = $path;
            } elseif (isset($formData['step_1']['profile_photo'])) {
                $validated['profile_photo'] = $formData['step_1']['profile_photo'];
            }
        }

        // Step 3: Education Certificates
        if ($step === 3) {
            $educations = $validated['educations'] ?? [];

            foreach ($educations as $index => &$education) {
                if (isset($education['certificate']) && $education['certificate'] instanceof \Illuminate\Http\UploadedFile) {
                    unset($education['certificate']);
                }
            }
            unset($education);

            $uploadedFiles = $request->file('educations');
            if (!empty($uploadedFiles)) {
                foreach ($uploadedFiles as $index => $files) {
                    if (isset($files['certificate']) && $files['certificate'] && $files['certificate']->isValid()) {
                        $file = $files['certificate'];
                        $filename = time() . '_' . $index . '_' . $file->getClientOriginalName();
                        $path = $file->storeAs('tmp/education_certificates', $filename, 'public');
                        $educations[$index]['certificate'] = $path;
                    } elseif (isset($formData['step_3']['educations'][$index]['certificate'])) {
                        $educations[$index]['certificate'] = $formData['step_3']['educations'][$index]['certificate'];
                    }
                }
            }

            $validated['educations'] = $educations;
        }

        // Step 4: Registration Certificate
        if ($step === 4) {
            if (isset($validated['registration_certificate']) && $validated['registration_certificate'] instanceof \Illuminate\Http\UploadedFile) {
                unset($validated['registration_certificate']);
            }

            if ($request->hasFile('registration_certificate') && $request->file('registration_certificate')->isValid()) {
                $file = $request->file('registration_certificate');
                $filename = time() . '_reg_' . $file->getClientOriginalName();
                $path = $file->storeAs('tmp/registration_certificates', $filename, 'public');
                $validated['registration_certificate_path'] = $path;
            } elseif (isset($formData['step_4']['registration_certificate_path'])) {
                $validated['registration_certificate_path'] = $formData['step_4']['registration_certificate_path'];
            }
        }

        // Step 5: Right to Work Proof Upload
        if ($step === 5) {
            // Remove injected UploadedFile object
            if (isset($validated['right_to_work_proof']) && $validated['right_to_work_proof'] instanceof \Illuminate\Http\UploadedFile) {
                unset($validated['right_to_work_proof']);
            }

            // Handle new upload
            if ($request->hasFile('right_to_work_proof') && $request->file('right_to_work_proof')->isValid()) {
                $file = $request->file('right_to_work_proof');
                $filename = time() . '_rtw_' . $file->getClientOriginalName();
                $path = $file->storeAs('tmp/right_to_work', $filename, 'public');
                $validated['right_to_work_proof_path'] = $path;
            } elseif (isset($formData['step_5']['right_to_work_proof_path'])) {
                $validated['right_to_work_proof_path'] = $formData['step_5']['right_to_work_proof_path'];
            }
        }

        // Save to session
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
            return redirect()->route('job-application.step', 1)
                ->with('error', 'Session expired. Please start again.');
        }

        DB::transaction(function () use ($formData) {
            $step1 = $formData['step_1'] ?? [];
            $step2 = $formData['step_2'] ?? [];
            $step3 = $formData['step_3'] ?? [];
            $step4 = $formData['step_4'] ?? [];
            $step5 = $formData['step_5'] ?? [];
            $step6 = $formData['step_6'] ?? [];

            // Handle Profile Photo (Step 1)
            $profilePhotoPath = null;
            if (!empty($step1['profile_photo'])) {
                $tmpFullPath = storage_path('app/public/' . $step1['profile_photo']);
                if (file_exists($tmpFullPath)) {
                    $finalPath = 'profile_photos/' . basename($step1['profile_photo']);
                    Storage::disk('public')->move($step1['profile_photo'], $finalPath);
                    $profilePhotoPath = $finalPath;
                }
            }

            // Handle Registration Certificate (Step 4)
            $registrationCertPath = null;
            if (!empty($step4['registration_certificate_path'])) {
                $tmpFullPath = storage_path('app/public/' . $step4['registration_certificate_path']);
                if (file_exists($tmpFullPath)) {
                    $finalPath = 'registration_certificates/' . basename($step4['registration_certificate_path']);
                    Storage::disk('public')->move($step4['registration_certificate_path'], $finalPath);
                    $registrationCertPath = $finalPath;
                }
            }

            // Handle Right to Work Proof (Step 5)
            $rtwProofPath = null;
            if (!empty($step5['right_to_work_proof_path'])) {
                $tmpFullPath = storage_path('app/public/' . $step5['right_to_work_proof_path']);
                if (file_exists($tmpFullPath)) {
                    $finalPath = 'right_to_work_proofs/' . basename($step5['right_to_work_proof_path']);
                    Storage::disk('public')->move($step5['right_to_work_proof_path'], $finalPath);
                    $rtwProofPath = $finalPath;
                }
            }

            // Create main application record
            $application = JobApplication::create([
                // Step 1: Personal Details
                'profile_photo' => $profilePhotoPath,
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
                'current_job_title'     => $step2['current_job_title'] ?? null,
                'current_pay_amount'    => $step2['current_pay_amount'] ?? null,
                'current_pay_frequency' => $step2['current_pay_frequency'] ?? null,
                'current_duties'        => $step2['current_duties'] ?? null,
                'current_place_of_work' => $step2['current_place_of_work'] ?? null,
                'current_shift_type'    => $step2['current_shift_type'] ?? null,
                'current_from_date'     => $step2['current_from_date'] ?? null,
                'current_to_date'       => $step2['current_to_date'] ?? null,
                
                // Step 4: Professional & Payment + Registration Certificate
                'professional_body'           => $step4['professional_body'] ?? null,
                'pin'                         => $step4['pin'] ?? null,
                'renewal_date'                => $step4['renewal_date'] ?? null,
                'pvg_clear'                   => $step4['pvg_clear'] ?? null,
                'pvg_issue_date'              => $step4['pvg_issue_date'] ?? null,
                'pvg_number'                  => $step4['pvg_number'] ?? null,
                'pvg_updated_service'         => $step4['pvg_updated_service'] ?? null,
                'registration_certificate_path' => $registrationCertPath,
                'bank_name'                   => $step4['bank_name'] ?? null,
                'account_name'                => $step4['account_name'] ?? null,
                'account_type'                => $step4['account_type'] ?? null,
                'bank_branch_address'         => $step4['bank_branch_address'] ?? null,
                'bank_postcode'               => $step4['bank_postcode'] ?? null,
                'account_number'              => $step4['account_number'] ?? null,
                'sort_code'                   => $step4['sort_code'] ?? null,
                'has_uk_license'              => $step4['has_uk_license'] ?? null,
                'has_car'                     => $step4['has_car'] ?? null,
                
                // Step 5: Declarations + Right to Work Fields
                'health_declaration'         => $step5['health_declaration'] ?? null,
                'disability_declaration'     => $step5['disability_declaration'] ?? null,
                'confidentiality_declaration' => $step5['confidentiality_declaration'] ?? null,
                'photo_consent'              => $step5['photo_consent'] ?? null,
                'personal_declaration'       => $step5['personal_declaration'] ?? null,
                'working_time_declaration'   => $step5['working_time_declaration'] ?? null,
                'other_declaration'          => $step5['other_declaration'] ?? null,
                'health_safety_declaration'  => $step5['health_safety_declaration'] ?? null,
                'right_to_work_status'       => $step5['right_to_work_status'] ?? null,
                'right_to_work_share_code'   => $step5['right_to_work_share_code'] ?? null,        // ← NEW
                'right_to_work_proof_path'   => $rtwProofPath,                                      // ← NEW
                'has_convictions'            => $step5['has_convictions'] ?? null,
                'convictions_details'        => $step5['convictions_details'] ?? null,
                'has_disciplinary'           => $step5['has_disciplinary'] ?? null,
                'disciplinary_details'       => $step5['disciplinary_details'] ?? null,
                'has_criminal_charges'       => $step5['has_criminal_charges'] ?? null,
                'criminal_charges_details'   => $step5['criminal_charges_details'] ?? null,
                'consents_police_check'      => $step5['consents_police_check'] ?? null,
                'police_checked_recently'    => $step5['police_checked_recently'] ?? null,
                'police_check_details'       => $step5['police_check_details'] ?? null,
                
                // Step 6: Availability + Character Reference Certificate
                'work_preferences'              => $step6['work_preferences'] ?? null,
                'availability_other'            => $step6['availability_other'] ?? null,
                'start_date'                    => $step6['start_date'] ?? null,
                'interview_availability'        => $step6['interview_availability'] ?? null,
                'has_holidays_booked'           => $step6['has_holidays_booked'] ?? null,
                'holidays_dates'                => $step6['holidays_dates'] ?? null,
                'character_reference_certificate' => $step6['character_reference_certificate'] ?? null,
                
                'status' => 'pending',
            ]);

            // Step 2: Work Histories
            if (!empty($step2['work_histories'])) {
                foreach ($step2['work_histories'] as $index => $history) {
                    if (!empty(array_filter($history))) {
                        $application->workHistories()->create([
                            'from_date'             => $history['from_date'] ?? null,
                            'to_date'               => $history['to_date'] ?? null,
                            'employer_name'         => $history['employer_name'] ?? null,
                            'job_title'             => $history['job_title'] ?? null,
                            'main_responsibilities' => $history['main_responsibilities'] ?? null,
                            'employer_address'      => $history['employer_address'] ?? null,
                            'reason_for_leaving'    => $history['reason_for_leaving'] ?? null,
                            'display_order'         => $index + 1,
                        ]);
                    }
                }
            }

            // Step 3: Educations + Certificate Handling
            if (!empty($step3['educations'])) {
                foreach ($step3['educations'] as $index => $educationData) {
                    if (empty(array_filter($educationData, fn($v) => $v !== null && $v !== ''))) {
                        continue;
                    }

                    $education = $application->educations()->create([
                        'establishment'   => $educationData['establishment'] ?? null,
                        'from_date'       => $educationData['from_date'] ?? null,
                        'to_date'         => $educationData['to_date'] ?? null,
                        'qualification'   => $educationData['qualification'] ?? null,
                        'grade'           => $educationData['grade'] ?? null,
                        'display_order'   => $index + 1,
                        'certificate_path' => null,
                    ]);

                    if (!empty($educationData['certificate'])) {
                        $tmpFullPath = storage_path('app/public/' . $educationData['certificate']);
                        if (file_exists($tmpFullPath)) {
                            $finalPath = 'education_certificates/' . basename($educationData['certificate']);
                            Storage::disk('public')->move($educationData['certificate'], $finalPath);
                            $education->update(['certificate_path' => $finalPath]);
                        }
                    }
                }
            }

            // Step 3: Training
            if (!empty($step3['mandatory_training']) || !empty($step3['other_training'])) {
                $application->training()->create([
                    'mandatory_training' => $step3['mandatory_training'] ?? [],
                    'other_training'     => $step3['other_training'] ?? null,
                ]);
            }

            // Step 4: Immunisations
            if (!empty($step4['immunisations'])) {
                $imm = $step4['immunisations'];
                $application->immunisation()->create([
                    'hep_b'         => $imm['hep_b'] ?? null,
                    'tb'            => $imm['tb'] ?? null,
                    'varicella'     => $imm['varicella'] ?? null,
                    'measles'       => $imm['measles'] ?? null,
                    'rubella'       => $imm['rubella'] ?? null,
                    'hep_b_antigen' => $imm['hep_b_antigen'] ?? null,
                    'hep_c'         => $imm['hep_c'] ?? null,
                    'hiv'           => $imm['hiv'] ?? null,
                ]);
            }

            // Step 6: References
            if (!empty($step6['references'])) {
                foreach ($step6['references'] as $index => $reference) {
                    if (!empty(array_filter($reference))) {
                        $application->references()->create([
                            'name'             => $reference['name'] ?? null,
                            'position'         => $reference['position'] ?? null,
                            'company_address'  => $reference['company_address'] ?? null,
                            'telephone'        => $reference['telephone'] ?? null,
                            'email'            => $reference['email'] ?? null,
                            'may_contact_now'  => $reference['may_contact_now'] ?? null,
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
                            'name'            => $referral['name'] ?? null,
                            'telephone'       => $referral['telephone'] ?? null,
                            'referral_number' => $index + 1,
                        ]);
                    }
                }
            }
        });

        // Cleanup temporary files
        if (isset($formData['step_1']['profile_photo'])) {
            Storage::disk('public')->delete($formData['step_1']['profile_photo']);
        }

        // Cleanup temporary education certificates
        if (!empty($formData['step_3']['educations'])) {
            foreach ($formData['step_3']['educations'] as $educationData) {
                if (!empty($educationData['certificate'])) {
                    Storage::disk('public')->delete($educationData['certificate']);
                }
            }
        }

        // Cleanup temporary registration certificate
        if (isset($formData['step_4']['registration_certificate_path'])) {
            Storage::disk('public')->delete($formData['step_4']['registration_certificate_path']);
        }

        // Cleanup temporary right to work proof
        if (isset($formData['step_5']['right_to_work_proof_path'])) {
            Storage::disk('public')->delete($formData['step_5']['right_to_work_proof_path']);
        }

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
                    'profile_photo' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048', // 2MB max
                    'title' => 'nullable|in:Mr,Mrs,Miss,Ms,Dr,Other',
                    'date_of_birth' => 'required|date|before_or_equal:today',
                    'forename' => 'required|string|max:255',
                    'surname' => 'required|string|max:255',
                    'previous_name' => 'nullable|string|max:255',
                    'gender' => 'nullable|in:Male,Female,Other,Prefer not to say',
                    'marital_status' => 'nullable|in:Single,Married,Divorced,Widowed,Civil Partnership,Other',
                    'ni_number' => 'required|string',
                    'address' => 'required|string|max:1000',
                    'postcode' => 'required|string|max:10',
                    'mobile_number' => 'required|string|max:20|regex:/^[\d\s\-\+()]+$/',
                    'landline' => 'nullable|string|max:20|regex:/^[\d\s\-\+()]+$/',
                    'email' => 'required|email|max:255|unique:job_applications,email', // Optional: prevent duplicate apps
                    'next_of_kin_name' => 'nullable|string|max:255',
                    'next_of_kin_relationship' => 'nullable|string|max:100',
                    'next_of_kin_phone' => 'nullable|string|max:20|regex:/^[\d\s\-\+()]+$/',
                    'next_of_kin_address' => 'nullable|string|max:1000',
                    'next_of_kin_postcode' => 'nullable|string|max:10',
                    'next_of_kin_email' => 'nullable|email|max:255',
                ]);

            case 2:
                return $request->validate([
                    'current_job_title' => 'required|string',
                    'current_pay_amount' => 'required|numeric',
                    'current_pay_frequency' => 'required|in:hour,week,month',
                    'current_from_date' => 'required|date|before_or_equal:today',
                    'current_to_date' => 'nullable|date|after_or_equal:current_from_date',
                    'current_duties' => 'required|string',
                    'current_place_of_work' => 'required|string',
                    'current_shift_type' => 'nullable|in:Day,Night,Both',
                    'work_histories' => 'nullable|array',
                    'work_histories.*.from_date' => 'required_with:work_histories|date',
                    'work_histories.*.to_date' => 'required_with:work_histories|date|after:work_histories.*.from_date',
                    'work_histories.*.employer_name' => 'required_with:work_histories|string',
                    'work_histories.*.job_title' => 'required_with:work_histories|string',
                    'work_histories.*.main_responsibilities' => 'required_with:work_histories|string',
                    'work_histories.*.employer_address' => 'nullable|string',
                    'work_histories.*.reason_for_leaving' => 'nullable|string',
                ]);

            case 3:
                return $request->validate([
                    'educations' => 'nullable|array',
                    'educations.*.establishment' => 'required_with:educations|string|max:255',
                    'educations.*.from_date' => 'required_with:educations|string|size:4|regex:/^\d{4}$/',
                    'educations.*.to_date' => 'required_with:educations|string|size:4|regex:/^\d{4}$/',
                    'educations.*.qualification' => 'required_with:educations|string|max:255',
                    'educations.*.grade' => 'nullable|string|max:50',
                    'educations.*.certificate' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120', // 5MB
                    'mandatory_training' => 'nullable|array',
                    'mandatory_training.*' => 'in:moving_handling,basic_life_support,intermediate_life_support,advance_life_support,complaints_handling,handling_violence,fire_safety,coshh,riddor,caldicott_protocols,data_protection,infection_control,lone_worker,food_hygiene,personal_safety,covid_19',
                    'other_training' => 'nullable|string|max:2000',
                ]);

            case 4:
                return $request->validate([
                    'registration_certificate' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
                    'professional_body' => 'nullable|string|max:255',
                    'pin' => 'nullable|string|max:50',
                    'renewal_date' => 'nullable|date|after_or_equal:today',
                    'pvg_clear' => 'nullable|boolean',
                    'pvg_issue_date' => 'nullable|date',
                    'pvg_number' => 'nullable|string|max:50',
                    'pvg_updated_service' => 'nullable|boolean',
                    'bank_name' => 'required_if:account_number,!=,null|string|max:255',
                    'account_name' => 'required_if:account_number,!=,null|string|max:255',
                    'account_type' => 'nullable',
                    'bank_branch_address' => 'nullable|string|max:500',
                    'bank_postcode' => 'nullable|string|max:10',
                    'account_number' => 'nullable|string|size:8|regex:/^\d{8}$/',
                    'sort_code' => 'nullable|string|size:6|regex:/^\d{6}$/',
                    'has_uk_license' => 'nullable|boolean',
                    'has_car' => 'nullable|boolean',
                ]);

            case 5:
                
                return $request->validate([
                    'health_declaration' => 'nullable',
                    'disability_declaration' => 'nullable',
                    'confidentiality_declaration' => 'nullable',
                    'photo_consent' => 'nullable',
                    'personal_declaration' => 'nullable',
                    'working_time_declaration' => 'nullable',
                    'other_declaration' => 'nullable',
                    'health_safety_declaration' => 'nullable|boolean',
                    'right_to_work_status' => 'nullable',
                    'right_to_work_share_code' => 'nullable|string|max:50',
                    'right_to_work_proof' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
                    'has_convictions' => 'nullable|boolean',
                    'convictions_details' => 'nullable',
                    'has_disciplinary' => 'nullable|boolean',
                    'disciplinary_details' => 'nullable',
                    'has_criminal_charges' => 'nullable|boolean',
                    'criminal_charges_details' => 'nullable',
                    'consents_police_check' => 'nullable|boolean',
                    'police_checked_recently' => 'nullable|boolean',
                    'police_check_details' => 'nullable|string|max:1000',
                ]);

            case 6:
                return $request->validate([
                    'character_reference_certificate' => 'required|in:yes,no',
                    'work_preferences' => 'nullable|array',
                    'work_preferences.*' => 'nullable',
                    'availability_other' => 'nullable|string|max:500',
                    'start_date' => 'required|date|after_or_equal:today',
                    'interview_availability' => 'nullable|string|max:500',
                    'has_holidays_booked' => 'nullable|boolean',
                    'holidays_dates' => 'required_if:has_holidays_booked,true|string|max:500',
                    'references' => 'nullable|array|min:2|max:3', // Require at least 2 references
                    'references.*.name' => 'required_with:references|string|max:255',
                    'references.*.position' => 'required_with:references|string|max:255',
                    'references.*.company_address' => 'nullable|string|max:500',
                    'references.*.telephone' => 'required_with:references|string|max:20',
                    'references.*.email' => 'required_with:references|email|max:255',
                    'references.*.may_contact_now' => 'nullable|boolean',
                    'referrals' => 'nullable|array',
                    'referrals.*.name' => 'required_with:referrals|string|max:255',
                    'referrals.*.telephone' => 'required_with:referrals|string|max:20',
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
