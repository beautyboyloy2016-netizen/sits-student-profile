<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PrintTemplatesSeeder extends Seeder
{
    public function run(): void
    {
        $adminId = DB::table('users')->where('email', 'superadmin@school.edu.kh')->value('id');

        $templates = [
            [
                'name'          => 'Default Student Card',
                'template_type' => 'student_card',
                'paper_size'    => 'CR80',
                'orientation'   => 'landscape',
                'is_default'    => true,
                'status'        => 'active',
                'settings'      => json_encode(['width' => '86mm', 'height' => '54mm']),
                'html_template' => <<<'HTML'
<div class="id-card">
  <div class="c-header">
    <div class="c-logo">
      <img src="{{ $school_logo }}" alt="logo">
    </div>
    <div class="c-school">
      <div class="c-school-kh">{{ $school_name_kh }}</div>
      <div class="c-school-en">{{ $school_name_en }}</div>
    </div>
  </div>

  <div class="c-title-bar">
    <div class="c-stripe c-stripe-left"></div>
    <div class="c-title-text">Student Identity Card</div>
    <div class="c-stripe c-stripe-right"></div>
  </div>

  <div class="c-body">
    <div class="c-photo">
      <img src="{{ $student_photo }}" alt="photo">
    </div>
    <div class="c-info">
      <div class="c-row"><span class="c-lbl">Student ID</span><span class="c-sep">:</span><span class="c-val">{{ $student_code }}</span></div>
      <div class="c-row"><span class="c-lbl">Name</span><span class="c-sep">:</span><span class="c-val">{{ $latin_name }}</span></div>
      <div class="c-row"><span class="c-lbl">Sex</span><span class="c-sep">:</span><span class="c-val">{{ $gender }}</span></div>
      <div class="c-row"><span class="c-lbl">Date of birth</span><span class="c-sep">:</span><span class="c-val">{{ $date_of_birth }}</span></div>
      <div class="c-row"><span class="c-lbl">Parent's phone</span><span class="c-sep">:</span><span class="c-val">{{ $parent_phone }}</span></div>
      <div class="c-row"><span class="c-lbl">Expiry date</span><span class="c-sep">:</span><span class="c-val">{{ $expire_date }}</span></div>
    </div>
  </div>

  <div class="c-footer"></div>
</div>
HTML,
                'css_template'  => <<<'CSS'
.id-card { width:86mm; height:54mm; box-sizing:border-box; border:0.4mm solid #bbb; border-radius:1.5mm; overflow:hidden; background:#fff; font-family:'Segoe UI', Arial, sans-serif; display:flex; flex-direction:column; }

/* Blue header */
.c-header { background:#003da5; padding:1.5mm 2.5mm; display:flex; align-items:center; gap:2mm; }
.c-logo { width:9mm; height:9mm; border-radius:50%; background:#fff; display:flex; align-items:center; justify-content:center; flex-shrink:0; border:0.3mm solid #ccd; overflow:hidden; }
.c-logo img { width:100%; height:100%; object-fit:contain; }
.c-school { flex:1; text-align:center; }
.c-school-kh { font-family:'Hanuman', Arial, sans-serif; color:#ffd700; font-size:7pt; font-weight:700; line-height:1.3; }
.c-school-en { color:#fff; font-size:5.5pt; font-weight:700; letter-spacing:0.3px; text-transform:uppercase; }

/* Title strip with diagonal red stripes */
.c-title-bar { background:#fff; border-top:0.6mm solid #003da5; display:flex; align-items:center; height:5.5mm; overflow:hidden; }
.c-stripe { flex-shrink:0; width:14mm; height:100%; background:#cc0000; }
.c-stripe-left  { -webkit-clip-path:polygon(0 0, 88% 0, 100% 100%, 0% 100%); clip-path:polygon(0 0, 88% 0, 100% 100%, 0% 100%); }
.c-stripe-right { -webkit-clip-path:polygon(0 0, 100% 0, 100% 100%, 12% 100%); clip-path:polygon(0 0, 100% 0, 100% 100%, 12% 100%); }
.c-title-text { flex:1; text-align:center; color:#003da5; font-weight:700; font-size:8pt; }

/* Body */
.c-body { padding:2mm 3mm 1.5mm; display:flex; gap:3mm; flex:1; }
.c-photo { width:18mm; height:23mm; border:0.4mm solid #003da5; display:flex; align-items:center; justify-content:center; overflow:hidden; flex-shrink:0; background:#f5f5f5; }
.c-photo img { width:100%; height:100%; object-fit:cover; }
.c-info { flex:1; }
.c-row { display:flex; align-items:baseline; margin-bottom:0.6mm; font-size:6.5pt; color:#111; }
.c-lbl { width:18mm; flex-shrink:0; }
.c-sep { margin:0 1mm 0 0; }
.c-val { flex:1; font-weight:500; word-break:break-word; }

/* Red footer */
.c-footer { height:2.5mm; background:#cc0000; border-top:1mm solid #003da5; flex-shrink:0; }
CSS,
            ],
            [
                'name'          => 'Default Certificate',
                'template_type' => 'certificate',
                'paper_size'    => 'A4',
                'orientation'   => 'landscape',
                'is_default'    => true,
                'status'        => 'active',
                'settings'      => json_encode([]),
                'html_template' => <<<'HTML'
<div class="certificate">
  <div class="border-outer">
    <div class="border-inner">
      <img src="{{ $school_logo }}" class="logo" alt="Logo">
      <h1>CERTIFICATE OF {{ strtoupper($certificate_type) }}</h1>
      <p class="presented">This certificate is proudly presented to</p>
      <h2 class="student-name">{{ $khmer_name }} ({{ $latin_name }})</h2>
      <p class="body">{{ $description }}</p>
      <p class="date">Issued on: {{ $issue_date }}</p>
      <div class="signatures">
        <div class="sig"><div class="sig-line"></div><p>Principal</p></div>
        <div class="seal"><img src="{{ $school_seal }}" alt="Seal"></div>
        <div class="sig"><div class="sig-line"></div><p>Instructor</p></div>
      </div>
    </div>
  </div>
</div>
HTML,
                'css_template'  => <<<'CSS'
.certificate { width:297mm; height:210mm; box-sizing:border-box; padding:8mm; font-family:Georgia, serif; background:#fff; }
.border-outer { border:4mm solid #b8860b; height:100%; padding:5mm; box-sizing:border-box; }
.border-inner { border:1mm solid #b8860b; height:100%; display:flex; flex-direction:column; align-items:center; justify-content:center; text-align:center; padding:5mm; box-sizing:border-box; }
.logo { height:25mm; margin-bottom:5mm; }
h1 { font-size:22pt; color:#b8860b; letter-spacing:3px; margin:0 0 4mm; }
.presented { font-style:italic; font-size:11pt; margin:0 0 3mm; }
.student-name { font-size:20pt; color:#333; border-bottom:1pt solid #999; padding-bottom:3mm; margin:0 0 5mm; }
.body { font-size:10pt; max-width:220mm; margin:0 auto 8mm; }
.date { font-size:9pt; margin-bottom:10mm; }
.signatures { display:flex; justify-content:space-around; width:100%; align-items:flex-end; }
.sig { text-align:center; }
.sig-line { border-top:1pt solid #333; width:50mm; margin-bottom:2mm; }
.sig p { font-size:9pt; margin:0; }
.seal img { height:25mm; }
CSS,
            ],
            [
                'name'          => 'Default Diploma',
                'template_type' => 'diploma',
                'paper_size'    => 'A4',
                'orientation'   => 'landscape',
                'is_default'    => true,
                'status'        => 'active',
                'settings'      => json_encode([]),
                'html_template' => <<<'HTML'
<div class="diploma">
  <div class="border-outer">
    <div class="border-inner">
      <img src="{{ $school_logo }}" class="logo" alt="Logo">
      <h1>DIPLOMA</h1>
      <p class="awarded">This diploma is awarded to</p>
      <h2 class="student-name">{{ $khmer_name }} ({{ $latin_name }})</h2>
      <p class="course">Having successfully completed the <strong>{{ $course }}</strong> – <strong>{{ $level }}</strong> program</p>
      <p class="grade">Grade: <strong>{{ $grade }}</strong>  |  GPA: <strong>{{ $gpa }}</strong></p>
      <p class="date">Graduated on: {{ $graduation_date }}  |  Issued: {{ $issue_date }}</p>
      <div class="signatures">
        <div class="sig"><div class="sig-line"></div><p>Principal</p></div>
        <div class="seal"><img src="{{ $school_seal }}" alt="Seal"></div>
        <div class="sig"><div class="sig-line"></div><p>Academic Director</p></div>
      </div>
    </div>
  </div>
</div>
HTML,
                'css_template'  => <<<'CSS'
.diploma { width:297mm; height:210mm; box-sizing:border-box; padding:8mm; font-family:Georgia, serif; background:#fff; }
.border-outer { border:4mm double #1a3a6b; height:100%; padding:5mm; box-sizing:border-box; }
.border-inner { border:1mm solid #1a3a6b; height:100%; display:flex; flex-direction:column; align-items:center; justify-content:center; text-align:center; padding:5mm; box-sizing:border-box; }
.logo { height:25mm; margin-bottom:5mm; }
h1 { font-size:26pt; color:#1a3a6b; letter-spacing:4px; margin:0 0 4mm; }
.awarded { font-style:italic; font-size:11pt; margin:0 0 3mm; }
.student-name { font-size:20pt; color:#333; border-bottom:1pt solid #999; padding-bottom:3mm; margin:0 0 5mm; }
.course, .grade, .date { font-size:10pt; margin:0 0 3mm; }
.signatures { display:flex; justify-content:space-around; width:100%; align-items:flex-end; margin-top:8mm; }
.sig { text-align:center; }
.sig-line { border-top:1pt solid #333; width:50mm; margin-bottom:2mm; }
.sig p { font-size:9pt; margin:0; }
.seal img { height:25mm; }
CSS,
            ],
        ];

        foreach ($templates as $template) {
            DB::table('print_templates')->updateOrInsert(
                [
                    'name'          => $template['name'],
                    'template_type' => $template['template_type'],
                ],
                $template + [
                    'created_by' => $adminId,
                    'updated_by' => $adminId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}
