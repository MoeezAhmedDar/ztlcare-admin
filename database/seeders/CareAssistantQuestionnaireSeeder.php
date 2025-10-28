<?php

namespace Database\Seeders;

use App\Models\InterviewQuestion;
use App\Models\InterviewSection;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class CareAssistantQuestionnaireSeeder extends Seeder
{
    public function run(): void
    {
        $sections = [
            [
                'name' => 'A. Career history / Opening questions',
                'order' => 1,
                'questions' => [
                    [
                        'prompt' => 'Did you manage to read through the Staff Handbook?',
                        'input_type' => 'select',
                        'options' => ['Yes', 'No'],
                    ],
                    [
                        'prompt' => 'Tell me a bit about yourself?',
                        'input_type' => 'textarea',
                    ],
                    [
                        'prompt' => 'Are you currently employed?',
                        'input_type' => 'select',
                        'options' => ['Yes', 'No'],
                    ],
                    [
                        'prompt' => 'What is your current or most recent role?',
                        'input_type' => 'textarea',
                    ],
                    [
                        'prompt' => 'Why do you want to change from your current role?',
                        'input_type' => 'textarea',
                    ],
                    [
                        'prompt' => 'What had interested you about the role/why have you applied?',
                        'input_type' => 'textarea',
                    ],
                    [
                        'prompt' => 'Discuss CV (previous experience in the care sector, gaps in employment)',
                        'input_type' => 'textarea',
                    ],
                ],
            ],
            [
                'name' => 'B. Role based competency questions',
                'order' => 2,
                'questions' => [
                    [
                        'prompt' => 'What qualities/skills do you think makes a good care worker?',
                        'input_type' => 'textarea',
                        'has_score' => true,
                        'help_text' => 'Role skills/suitability: good listener, communication, patience, motivated, flexible, friendly, committed, empathy, caring, punctual.',
                    ],
                    [
                        'prompt' => 'What are your strengths and weaknesses?',
                        'input_type' => 'textarea',
                        'has_score' => true,
                        'help_text' => 'Role skills/suitability: good listener, communication, patience, motivated, flexible, friendly, committed, empathy, caring, punctual.',
                    ],
                    [
                        'prompt' => 'What do you think makes a good team player?',
                        'input_type' => 'textarea',
                        'has_score' => true,
                        'help_text' => 'Teamwork: utilise all communication channels, be supportive and open, listen and respect others’ views and opinions, encourage and motivate, be flexible, friendly, sharing.',
                    ],
                    [
                        'prompt' => 'Give an example of where you supported your team?',
                        'input_type' => 'textarea',
                        'has_score' => true,
                        'help_text' => 'Teamwork: utilise all communication channels, be supportive and open, listen and respect others’ views and opinions, encourage and motivate, be flexible, friendly, sharing.',
                    ],
                    [
                        'prompt' => 'Tell us about a situation you were required to use your initiative.',
                        'input_type' => 'textarea',
                        'has_score' => true,
                        'help_text' => 'Problem solving/initiative: think on feet, think outside of the box with creative ideas, be resilient – don’t give up, identify a range of options and solutions, use decision making skills, assess the degree of the problem.',
                    ],
                    [
                        'prompt' => 'You entered a Service User\'s room and found them unconscious/unresponsive. What would be the first action you would take?',
                        'input_type' => 'textarea',
                        'has_score' => true,
                        'help_text' => 'Emergency response: call the office immediately and obtain medical help.',
                    ],
                    [
                        'prompt' => 'If you were unable to gain access entering an allocated service, what would you do?',
                        'input_type' => 'textarea',
                        'has_score' => true,
                        'help_text' => 'Access protocol: contact the office straight away, follow agreed entry procedures, and escalate appropriately if access cannot be gained.',
                    ],
                    [
                        'prompt' => 'How would you deal with a Service User that was aggressive?',
                        'input_type' => 'textarea',
                        'has_score' => true,
                        'help_text' => 'De-escalation: try to calm the situation, give space and time, show empathy, listen, understand the situation, divert attention to positive activity, remove from the environment if required.',
                    ],
                    [
                        'prompt' => 'How would you support individuals with limited communication skills (unable to speak/hear/see)?',
                        'input_type' => 'textarea',
                        'has_score' => true,
                        'help_text' => 'Communication: listening, talking, Makaton, signing, touch, eye contact, objects and symbols, pictures and photos, PCs or electronic devices, showing a range of options, body language techniques.',
                    ],
                    [
                        'prompt' => 'How would you inform the team of any issues/problems/concerns about the service user?',
                        'input_type' => 'textarea',
                        'has_score' => true,
                        'help_text' => 'Information sharing: interact with colleagues, inform the office, make notes in the care plan, obtain medical assistance when required.',
                    ],
                    [
                        'prompt' => 'How would you promote the independence of a service user?',
                        'input_type' => 'textarea',
                        'has_score' => true,
                        'help_text' => 'Prompting independence: balance the right to make choices with duty of care, encourage informed choices, listen to and respect individuals, do activities with not for them, liaise with relevant people, provide mental support, support communication.',
                    ],
                    [
                        'prompt' => 'What would you do if you find faulty equipment in an allocated service?',
                        'input_type' => 'textarea',
                        'has_score' => true,
                        'help_text' => 'Assessing risk: report it to the office, assess for imminent danger, speak to maintenance for the service, inform the service manager.',
                    ],
                    [
                        'prompt' => 'What is your understanding about Dietitians and supplements? How would you support a service user who is at high risk of malnutrition?',
                        'input_type' => 'textarea',
                        'has_score' => true,
                        'help_text' => 'Nutrition and hydration: wear gloves and follow hygiene practices, focus on nutrition and hydration, promote a well-balanced diet that meets the service user’s needs.',
                    ],
                    [
                        'prompt' => 'Can you give me 3 types of abuse?',
                        'input_type' => 'textarea',
                        'has_score' => true,
                        'help_text' => 'Safeguarding: recognise abuse as a violation of human and civil rights; it can be a single or repeated act, including physical, sexual, verbal, psychological, emotional, financial, theft, or neglect.',
                    ],
                    [
                        'prompt' => 'What should you do if you suspected a Service User is being abused?',
                        'input_type' => 'textarea',
                        'has_score' => true,
                        'help_text' => 'Whistleblowing: act immediately, report concerns to the line manager, follow the whistleblowing policy.',
                    ],
                    [
                        'prompt' => 'You identify a resident with advanced dementia and challenging behavior being aggressive near others. How would you manage this situation?',
                        'input_type' => 'textarea',
                        'has_score' => true,
                        'help_text' => 'Mental health awareness: consider factors such as dementia, depression, anger, substance use, eating disorders, and panic attacks when planning your response.',
                    ],
                ],
            ],
            [
                'name' => 'C. Mandatory questions',
                'order' => 3,
                'questions' => [
                    [
                        'prompt' => 'Are you prepared to travel within this role?',
                        'input_type' => 'select',
                        'options' => ['Yes', 'No'],
                    ],
                    [
                        'prompt' => 'Are you prepared to support individuals in all needs required?',
                        'input_type' => 'select',
                        'options' => ['Yes', 'No'],
                    ],
                    [
                        'prompt' => 'Does the candidate have any holidays/annual leave planned for the next 12 months?',
                        'input_type' => 'text',
                    ],
                    [
                        'prompt' => 'Advise candidate of hourly rate & any enhancements (notes)',
                        'input_type' => 'textarea',
                    ],
                    [
                        'prompt' => 'Discuss any cautions/convictions/reprimands declared on application & details that would appear on Disclosure Scotland.',
                        'input_type' => 'textarea',
                    ],
                    [
                        'prompt' => 'Have you explained the 0-hr contract?',
                        'input_type' => 'select',
                        'options' => ['Yes', 'No'],
                    ],
                    [
                        'prompt' => 'What is your notice period to current job?',
                        'input_type' => 'text',
                    ],
                    [
                        'prompt' => 'Do you have any questions that you may want to ask?',
                        'input_type' => 'textarea',
                    ],
                    [
                        'prompt' => 'Uniform size',
                        'input_type' => 'text',
                    ],
                ],
            ],
        ];

        DB::transaction(function () use ($sections) {
            foreach ($sections as $sectionData) {
                $questions = Arr::pull($sectionData, 'questions');

                $section = InterviewSection::query()->updateOrCreate(
                    ['name' => $sectionData['name']],
                    ['display_order' => $sectionData['order']]
                );

                foreach ($questions as $index => $questionData) {
                    InterviewQuestion::query()->updateOrCreate(
                        [
                            'section_id' => $section->id,
                            'prompt' => $questionData['prompt'],
                        ],
                        [
                            'input_type' => $questionData['input_type'] ?? 'text',
                            'options' => $questionData['options'] ?? null,
                            'has_score' => $questionData['has_score'] ?? false,
                            'display_order' => $index + 1,
                            'help_text' => $questionData['help_text'] ?? null,
                        ]
                    );
                }
            }
        });
    }
}
