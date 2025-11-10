<?php
// app/Services/PdfFormGenerator.php

namespace App\Services;

use TCPDF;

class PdfFormGenerator extends TCPDF
{
    protected $logoPath = null;

    public function __construct($logoPath = null)
    {
        parent::__construct('P', 'mm', 'A4', true, 'UTF-8', false);
        $this->SetMargins(15, 25, 15);
        $this->SetAutoPageBreak(true, 45);
        $this->setPrintHeader(true);
        $this->setPrintFooter(true);
        $this->logoPath = $logoPath;
    }

    // === HEADER (ALL PAGES) ===
    public function Header()
    {
        $this->SetY(10);
        $this->SetFont('helvetica', '', 9);
        $this->Cell(0, 5, '358 Brandon Street Motherwell', 0, 1);
        $this->Cell(0, 5, 'North Lanarkshire ML1 1XA', 0, 1);
        $this->Cell(0, 5, 'T: 01698 701199', 0, 1);
        $this->Cell(0, 5, 'E: info@ztl.care W: www.ztl.care', 0, 1);

        // Logo
        if ($this->logoPath && file_exists($this->logoPath)) {
            $this->Image($this->logoPath, 150, 10, 40);
        }

        $this->SetFont('helvetica', 'B', 14);
        $this->SetY(35);
        $this->Cell(0, 10, 'Reference Request Form', 0, 1, 'C');
        $this->SetFont('helvetica', 'B', 12);
        $this->Cell(0, 8, 'ZAN Traders Ltd.', 0, 1, 'C');
        $this->Ln(5);
    }

    // === FOOTER (ALL PAGES) ===
    public function Footer()
    {
        $this->SetY(-35);
        $this->SetFillColor(217, 237, 247);
        $this->Rect(0, $this->GetY(), 210, 15, 'F');
        $this->SetFont('helvetica', 'B', 9);
        $this->Cell(0, 10, 'ZAN Traders Ltd - Company Registration Number: SC675141', 0, 1, 'C');
    }

    public function generateReferenceRequest($data = [])
    {
        $this->AddPage();

        // === PAGE 1 ===
        $this->addBlueHeader('DETAILS OF APPLICANT:');
        $this->addTextField('Surname:', $data['surname'] ?? '', 80);
        $this->addTextField('Forename:', $data['forename'] ?? '', 80);
        $this->addTextField('Position:', $data['position'] ?? '', 80);
        $this->addTextArea('Home Address:', $data['home_address'] ?? '', 4);

        $this->addBlueHeader('EMPLOYMENT HISTORY:');
        $this->addTwoColumn('Start Date:', $data['start_date'] ?? '', 'Leaving Date:', $data['leaving_date'] ?? '');
        $this->addTwoColumn('Job Title:', $data['job_title'] ?? '', 'In what capacity do you know the applicant?', $data['capacity'] ?? '');
        $this->addTwoColumn('Reason for leaving:', $data['reason_leaving'] ?? '', 'Gross annual salary on leaving:', $data['gross_salary'] ?? '');
        $this->addTextArea('Brief description of duties:', $data['duties'] ?? '', 3);

        $this->addTextArea('Referring to the job description, please describe the applicant’s ability to undertake their role:', $data['ability_role'] ?? '', 3);
        $this->addTextArea('Describe applicant’s time management skills:', $data['time_management'] ?? '', 3);
        $this->addTextArea('Describe the applicant’s reliability:', $data['reliability'] ?? '', 3);
        $this->addTextArea('Please inform us of any disciplinary actions that might have been taken against the applicant:', $data['disciplinary'] ?? '', 3);

        $this->SetFont('helvetica', 'B', 10);
        $this->Cell(0, 8, 'Would you re-employ the applicant? YES/NO', 0, 1);
        $this->SetFont('helvetica', '', 10);
        $this->Cell(0, 8, 'If NO, please indicate why:', 0, 1);
        $this->addTextArea('', $data['reemploy'] ?? '', 3);

        // === PAGE 2 ===
        $this->AddPage();
        $this->addBlueHeader('CRIMINAL & OTHER INFO');
        $this->addTextArea('To your knowledge, has the applicant ever been convicted of a criminal offence (subject to Rehabilitation of Offenders Act 1974 Provisions)? If yes please give details:', $data['criminal'] ?? '', 4);
        $this->addTextArea('Do you have any other information regarding this application, which you believe, should be known to us as prospective employers?', $data['other_info'] ?? '', 4);

        $this->addRatingTable();

        // === PAGE 3 ===
        $this->AddPage();
        $this->addBlueHeader('DETAILS OF REFEREE:');
        $this->addTwoColumn('Position:', $data['ref_position'] ?? '', 'Date:', $data['ref_date'] ?? '');
        $this->addTwoColumn('Signed:', '', 'Printed Name:', $data['ref_name'] ?? '');
        $this->addTextArea('Company details including email address and phone number:', $data['ref_company'] ?? '', 2);
        $this->Rect(15, $this->GetY(), 180, 40); // Stamp

        $this->addBlueHeader('FOR OFFICE USE ONLY');
        $this->addTextField('Reference checked and verified by:', $data['office_verified'] ?? '', 100);
        $this->addTextField('Signed:', '', 100);
        $this->addTextField('Printed name:', $data['office_name'] ?? '', 100);
        $this->addTextField('Position:', $data['office_position'] ?? '', 100);
        $this->addTextField('Date:', $data['office_date'] ?? '', 100);
        $this->addTextArea('Comments:', $data['office_comments'] ?? '', 4);

        return $this->Output('S');
    }

    // === HELPER METHODS ===
    private function addBlueHeader($text)
    {
        $this->SetFillColor(217, 237, 247);
        $this->SetFont('helvetica', 'B', 10);
        $this->Cell(0, 8, $text, 0, 1, 'L', true);
        $this->Ln(2);
    }

    private function addTextField($label, $value, $width)
    {
        $this->SetFont('helvetica', '', 10);
        $this->Cell(50, 8, $label, 0);
        $this->TextField('field_' . uniqid(), $width, 8, ['value' => $value]);
        $this->Ln(8);
    }

    private function addTwoColumn($l1, $v1, $l2, $v2)
    {
        $this->SetFont('helvetica', '', 10);
        $this->Cell(25, 8, $l1, 0);
        $this->TextField('field_' . uniqid(), 65, 8, ['value' => $v1]);
        $this->SetX(115);
        $this->Cell(25, 8, $l2, 0);
        $this->TextField('field_' . uniqid(), 65, 8, ['value' => $v2]);
        $this->Ln(8);
    }

    private function addTextArea($label, $value, $lines)
    {
        if ($label) {
            $this->SetFont('helvetica', '', 10);
            $this->MultiCell(0, 6, $label, 0);
        }
        $this->TextField('field_' . uniqid(), 180, $lines * 8, ['value' => $value, 'multiline' => true]);
        $this->Ln($lines * 8 + 4);
    }

    private function addRatingTable()
    {
        $this->SetFillColor(217, 237, 247);
        $this->SetFont('helvetica', 'B', 10);
        $this->Cell(80, 8, 'How does the applicant rate in the following areas?', 0, 0, 'L', true);
        $this->Cell(20, 8, 'Poor', 1, 0, 'C', true);
        $this->Cell(20, 8, 'Average', 1, 0, 'C', true);
        $this->Cell(20, 8, 'Good', 1, 0, 'C', true);
        $this->Cell(20, 8, 'Excellent', 1, 1, 'C', true);

        $categories = ['Ability', 'Character', 'Attendance', 'Punctuality', 'Honesty'];
        foreach ($categories as $cat) {
            $this->SetFont('helvetica', '', 10);
            $this->Cell(80, 10, $cat, 1);
            for ($i = 0; $i < 4; $i++) {
                $this->CheckBox('rating_' . strtolower($cat) . '_' . $i, 6, false, []);
                $this->Cell(20, 10, '', 1);
            }
            $this->Ln();
        }
    }
}