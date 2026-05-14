# មេរៀនជំហានបន្ទាប់បន្តៗ — ការប្រើប្រាស់ Student Profile Management System

> ឯកសារនេះបង្ហាញជំហានបន្ទាប់បន្តៗ ចាប់ពីការដំឡើង រហូតដល់អាចប្រើប្រាស់ប្រព័ន្ធបានពេញលក្ខណៈ។

---

## ជំហានទី ០ — ការដំឡើង (Installation)

**មុនពេលចាប់ផ្ដើមប្រើប្រាស់ ត្រូវធ្វើការដំឡើងដូចខាងក្រោម៖**

```bash
# 1. ចូលទៅ folder project
cd c:\laragon\www\student-profile-management

# 2. Install PHP packages
composer install

# 3. Install JS packages
npm install

# 4. Build frontend
npm run build

# 5. បង្កើត .env file
copy .env.example .env

# 6. Generate app key
php artisan key:generate

# 7. បង្កើត database
touch database\database.sqlite          # (សម្រាប់ SQLite)

# 8. Migrate + Seed ទិន្នន័យទាំងអស់
php artisan migrate
php artisan db:seed

# 9. Storage link (សម្រាប់ upload រូបភាព)
php artisan storage:link

# 10. ចាប់ផ្ដើម server
php artisan serve
```

**ចូប្រព័ន្ធ៖** `http://localhost:8000`

> **Login ដំបូង៖** `admin@sits.edu.kh` / `password`

---

## ជំហានទី ១ — បង្កើតសាខា (Branch) [ធ្វើមុនគេ]

**ហេតុផល៖** សាខាគឺជាមូលដ្ឋានគ្រឹះរបស់ប្រព័ន្ធ។ រាល់ទិន្នន័យទាំងអស់ (សិស្ស ថ្នាក់ វិក្កយបត្រ) ត្រូវបានដាក់ក្នុងសាខា។

```
ផ្លូវទៅ៖ Admin → Branches → Create New Branch
```

**បំពេញព័ត៌មាន៖**
- **Code**: MAIN (សម្រាប់សាខាដំបូង)
- **Name (Khmer)**: សាខាចំណុះកណ្ដាល
- **Name (English)**: Main Branch
- **Address**: អាសយដ្ឋានសាខា
- **Phone**: 023-XXX-XXXX
- **Email**: info@sits.edu.kh
- **Logo**: អាប់ឡូដឡូហ្គូសាលា
- **Is Main**: ✅ បើក (សាខាសំខាន់)

> ចំណាំ៖ បើមានតែ ១ សាខា ត្រូវដាក់ **Is Main = true**

---

## ជំហានទី ២ — កំណត់ Branch Settings (សាខាដែលបានបង្កើត)

**ហេតុផល៖** កំណត់ឈ្មោះសាលា ឡូហ្គូ ហត្ថលេខា ដែលនឹងបង្ហាញលើកាត វិញ្ញាបនបត្រ សញ្ញាបត្រ។

```
ផ្លូវទៅ៖ Branches → [សាខា] → Settings
```

**បំពេញព័ត៌មាន៖**
- **School Name (Khmer)**: សាលាបច្ចេកវិទ្យាព័ត៌មាន អេស អាយ ធី អេស
- **School Name (English)**: SITS INFORMATION TECHNOLOGY SCHOOL
- **Logo Path**: `/images/logo.png` (ឬ upload រូបភាព)
- **Stamp Path**: `/images/stamp.png`
- **Signature Path**: `/images/signature.png`
- **Address**: #123, Street 456, Phnom Penh
- **Phone**: 023-XXX-XXXX
- **Email**: info@sits.edu.kh
- **Website**: www.sits.edu.kh

> ចំណាំ៖ បើមិនមាន `.env` កំណត់ `APP_NAME_KH` ទេ ប្រព័ន្ធនឹងប្រើតម្លៃនៅ Branch Settings។

---

## ជំហានទី ៣ — បង្កើត Roles & Users (បុគ្គលិកដំណើរការប្រព័ន្ធ)

### ៣.១ ពិនិត្យ Roles ដែលមានស្រាប់
```
ផ្លូវទៅ៖ Admin → Roles
```

ប្រព័ន្ធមាន Role ស្រាប់ (តាម `RolesPermissionsSeeder`):
- **Admin** — សិទ្ធិពេញ
- **Manager** — គ្រប់គ្រងទូទៅ
- **Receptionist** — ទទួលសិស្ស ចុះឈ្មោះ
- **Teacher** — គ្រូបង្រៀន
- **Accountant** — គណនេយ្យ
- **Viewer** — មើលប៉ុណ្ណោះ

### ៣.២ បង្កើត User ថ្មី
```
ផ្លូវទៅ៖ Admin → Users → Create New
```

**បំពេញព័ត៌មាន៖**
- **Name**: ឈ្មោះបុគ្គលិក
- **Email**: user@email.com
- **Phone**: 012-XXX-XXXX
- **Password**: password (ប្ដូរក្រោយ)
- **Branch**: ជ្រើសរើសសាខាដែលបានបង្កើត
- **Role**: ជ្រើស Role (ឧ. Receptionist)
- **Status**: Active

> ចំណាំ៖ អ្នកប្រើអាចមាន Role ច្រើន និងសាខាច្រើន។

---

## ជំហានទី ៤ — ការកំណត់វិទ្យាស្ថាន (Academic Setup)

**ហេតុផល៖** មុនបង្កើតថ្នាក់ ត្រូវមាន Courses, Levels, Academic Years, និង Shifts ជាមុនសិន។

### ៤.១ បង្កើត Course (វគ្គសិក្សា)
```
ផ្លូវទៅ៖ Admin → Courses → Create New
```

**ឧទាហរណ៍៖**
| ឈ្មោះ | Description |
|---|---|
| Information Technology | វគ្គបច្ចេកវិទ្យាព័ត៌មាន |
| English | វគ្គភាសាអង់គ្លេស |
| Graphic Design | វគ្គរចនាក្រាហ្វិក |

### ៤.២ បង្កើត Level (ថ្នាក់) ក្នុង Course
```
ផ្លូវទៅ៖ Courses → [Course] → Manage Levels → Add Level
```

**ឧទាហរណ៍ (ក្នុង Course "IT")៖**
| Level | Sort Order |
|---|---|
| Level 1 | 1 |
| Level 2 | 2 |
| Level 3 | 3 |

### ៤.៣ បង្កើត Academic Year (ឆ្នាំសិក្សា)
```
ផ្លូវទៅ៖ Admin → Academic Years → Create New
```

**ឧទាហរណ៍៖**
- **Name**: 2025-2026
- **Start Date**: 2025-10-01
- **End Date**: 2026-08-31
- **Is Current**: ✅ បើក (សម្រាប់ឆ្នាំកំពុងប្រើ)
- **Status**: Active

### ៤.៤ បង្កើត Shift (វេន)
```
ផ្លូវទៅ៖ Admin → Shifts → Create New
```

**ឧទាហរណ៍៖**
| Shift | Start Time | End Time |
|---|---|---|
| Morning | 08:00 | 11:00 |
| Afternoon | 13:00 | 16:00 |
| Evening | 17:00 | 20:00 |

---

## ជំហានទី ៥ — បង្កើត Staff (បុគ្គលិក និងគ្រូបង្រៀន)

**ហេតុផល៖** ថ្នាក់រៀនត្រូវមានគ្រូបង្រៀន (Teacher) ពី Staff។

```
ផ្លូវទៅ៖ Admin → Staff → Create New
```

**បំពេញព័ត៌មាន៖**
- **Staff Code**: STF001, STF002, ...
- **Name (Khmer)**: ឈ្មោះខ្មែរ
- **Name (English)**: ឈ្មោះអង់គ្លេស
- **Gender**: ជ្រើសភេទ
- **Phone**: លេខទូរសព្ទ
- **Email**: email@school.com
- **Position**: Teacher / Manager / Accountant / Receptionist
- **Branch**: សាខាដែលបានបង្កើត
- **User**: ភ្ជាប់ទៅ User Account (អាចទុកទទេបាន)

> ចំណាំ៖ Staff ដែល Position = "Teacher" នឹងបង្ហាញក្នុង dropdown នៅពេលបង្កើត Class។

---

## ជំហានទី ៦ — បង្កើត Buildings & Rooms (អគារ និងបន្ទប់)

**ហេតុផល៖** ថ្នាក់រៀនត្រូវមាន Room។ ក៏អាចប្រើសម្រាប់ Dormitory (ស្នាក់នៅ) ផងដែរ។

### ៦.១ បង្កើត Building
```
ផ្លូវទៅ៖ Admin → Rooms → Create Building
```

**ឧទាហរណ៍៖**
- **Name**: Building A
- **Address**: Street 123, Phnom Penh
- **Branch**: សាខាដែលបានបង្កើត

### ៦.២ បង្កើត Room
```
ផ្លូវទៅ៖ Rooms → Create Room
```

**ឧទាហរណ៍៖**
| Room No | Type | Capacity | Status |
|---|---|---|---|
| 101 | classroom | 30 | available |
| 102 | classroom | 25 | available |
| A01 | double | 2 | available |
| B01 | single | 1 | available |

---

## ជំហានទី ៧ — បង្កើត Class (ថ្នាក់រៀន)

**ហេតុផល៖** មុនបង្កើតសិស្ស និង Enrollment ត្រូវមាន Class ជាមុន។

```
ផ្លូវទៅ៖ Admin → Classes → Create New
```

**បំពេញព័ត៌មាន៖**
- **Class Code**: IT-L1-MOR-2026
- **Course**: Information Technology
- **Level**: Level 1
- **Academic Year**: 2025-2026
- **Shift**: Morning
- **Teacher**: ជ្រើសគ្រូបង្រៀន (ពី Staff)
- **Room**: Room 101
- **Start Date**: 2025-10-01
- **End Date**: 2026-08-31
- **Status**: Active

### ៧.១ បង្កើត Class Schedule (កាលវិភាគ)
```
ផ្លូវទៅ៖ Classes → [Class] → Schedules → Add Schedule
```

**ឧទាហរណ៍៖**
| Day | Start Time | End Time |
|---|---|---|
| Monday | 08:00 | 10:00 |
| Wednesday | 08:00 | 10:00 |
| Friday | 08:00 | 10:00 |

---

## ជំហានទី ៨ — បង្កើត Fee Types (ប្រភេទថ្លៃ)

**ហេតុផល៖** មុនបង្កើត Invoice ត្រូវមានប្រភេទថ្លៃសិក្សា។

```
ផ្លូវទៅ៖ Admin → Fees → Fee Types → Create New
```

**ឧទាហរណ៍៖**
| Fee Type | Amount |
|---|---|
| ថ្លៃសិក្សា | 300.00 |
| ថ្លៃសៀវភៅ | 50.00 |
| ថ្លៃប្រឡង | 25.00 |
| ថ្លៃសម្លៀកបំពាក់ | 40.00 |

---

## ជំហានទី ៩ — បង្កើត Student (សិស្ស)

**ហេតុផល៖** នេះជាប្រព័ន្ធសម្រាប់គ្រប់គ្រងសិស្ស — សិស្សត្រូវបានបង្កើតបន្ទាប់ពីវិទ្យាស្ថានត្រូវបានរៀបចំរួច។

```
ផ្លូវទៅ៖ Admin → Students → Create New
```

**ផ្នែកទី ១ — ព័ត៌មានផ្ទាល់ខ្លួន៖**
- **Student Code**: STU001 (unique)
- **Khmer Name**: ឈ្មោះខ្មែរ
- **Latin Name**: ឈ្មោះឡាតាំង
- **Gender**: ជ្រើសភេទ
- **Date of Birth**: ថ្ងៃខែឆ្នាំកំណើត
- **Birth Place**: ខេត្ត → ស្រុក → ឃុំ → ភូមិ (dropdown មានស្រាប់)
- **Current Address**: អាសយដ្ឋានបច្ចុប្បន្ន
- **Phone**: 012-XXX-XXXX
- **Email**: (optional)

**ផ្នែកទី ២ — រូបថត៖**
- Upload រូបថតសិស្ស (3x4 ឬ 4x6)
- រក្សាទុក

> ចំណាំ៖ Student Code ត្រូវតែ unique ក្នុងប្រព័ន្ធ។

---

## ជំហានទី ១០ — ភ្ជាប់ Guardian (ឪពុកម្ដាយ/អាណាព្យាបាល)

**ហេតុផល៖** Guardian ដែលបានកំណត់ **is_primary = true** នឹងបង្ហាញលើ Student Card។

### ១០.១ បង្កើត Guardian (បើមិនទាន់មាន)
```
ផ្លូវទៅ៖ Admin → Guardians → Create New
```

**បំពេញព័ត៌មាន៖**
- **Name (Khmer)**: ឈ្មោះខ្មែរ
- **Name (English)**: ឈ្មោះអង់គ្លេស
- **Phone**: 012-XXX-XXXX (នឹងបង្ហាញលើកាត)
- **Occupation**: មុខរបរ
- **Address**: អាសយដ្ឋាន

### ១០.២ ភ្ជាប់ Guardian ទៅនឹងសិស្ស
```
ផ្លូវទៅ៖ Students → [សិស្ស] → Edit → Guardians Tab
```

ឬ

```
Guardians → [Guardian] → Link to Student
```

**បំពេញព័ត៌មាន៖**
- **Student**: ជ្រើសរើសសិស្ស
- **Guardian**: ជ្រើសរើសអាណាព្យាបាល
- **Relationship**: father / mother / guardian / brother / sister / other
- **Is Primary**: ✅ បើក (បើជាអាណាព្យាបាលសំខាន់ — បង្ហាញលើកាត)

> ចំណាំ៖ សិស្សមួយអាចមាន Guardian ច្រើននាក់ ប៉ុន្តែតែម្នាក់ទេអាចជា Primary។

---

## ជំហានទី ១១ — ចុះឈ្មោះ Enrollment

**ហេតុផល៖** សិស្សត្រូវបានចុះឈ្មោះចូលថ្នាក់ ទើបគណនាបានថ្លៃសិក្សា និងបោះពុម្ពកាត។

```
ផ្លូវទៅ៖ Admin → Enrollments → Create New
```

**បំពេញព័ត៌មាន៖**
- **Student**: ជ្រើសរើសសិស្ស (search បាន)
- **Class**: ជ្រើសរើសថ្នាក់ (IT-L1-MOR-2026)
- **Academic Year**: 2025-2026
- **Shift**: Morning
- **Enroll Date**: ថ្ងៃចុះឈ្មោះ
- **Study Time Label**: (optional) សម្គាល់ពេលវេលា
- **Status**: studying

---

## ជំហានទី ១២ — បង្កើត Invoice (វិក្កយបត្រ)

**ហេតុផល៖** កត់ត្រាថ្លៃសិក្សាដែលសិស្សត្រូវបង់។

```
ផ្លូវទៅ៖ Admin → Fees → Invoices → Create New
```

**ផ្នែកទី ១ — ព័ត៌មានវិក្កយបត្រ៖**
- **Invoice No**: INV-2026-0001 (unique)
- **Student**: ជ្រើសរើសសិស្ស
- **Invoice Date**: ថ្ងៃចេញវិក្កយបត្រ
- **Due Date**: ថ្ងៃកំណត់បង់

**ផ្នែកទី ២ — ធាតុ (Items) — បន្ថែមតាមតម្រូវការ៖**
| Fee Type | Qty | Unit Price | Total |
|---|---|---|---|
| ថ្លៃសិក្សា | 1 | 300.00 | 300.00 |
| ថ្លៃសៀវភៅ | 1 | 50.00 | 50.00 |

- **Discount**: (optional)
- **Total Amount**: គណនាដោយស្វ័យប្រវត្តិ
- **Status**: unpaid

> ចំណាំ៖ Invoice មិនទាន់បង់ (unpaid) នឹងបង្ហាញក្នុង Dashboard ជា "Unpaid Invoices"។

---

## ជំហានទី ១៣ — ទូទាត់ Payment (បង់លុយ)

**ហេតុផល៖** ទទួលការបង់ថ្លៃពីសិស្ស និង update តុល្យភាពវិក្កយបត្រ។

```
ផ្លូវទៅ៖ Admin → Fees → Payments → Create New
```

**បំពេញព័ត៌មាន៖**
- **Payment No**: PAY-2026-0001 (unique)
- **Invoice**: ជ្រើសរើសវិក្កយបត្រដែលមិនទាន់បង់ (optional)
- **Student**: ជ្រើសរើសសិស្ស
- **Payment Date**: ថ្ងៃបង់លុយ
- **Amount**: ចំនួនទឹកប្រាក់
- **Payment Method**: cash / bank / ABA / Wing / other
- **Received By**: អ្នកទទួលលុយ
- **Note**: (optional)

> ចំណាំ៖ ប្រសិនបើ Payment ភ្ជាប់ទៅ Invoice តុល្យភាព (Balance) នឹង update ដោយស្វ័យប្រវត្តិ។

---

## ជំហានទី ១៤ — បង្កើត Student Card (កាតសិស្ស)

**ហេតុផល៖** ប្រព័ន្ធមានប្រព័ន្ធបោះពុម្ពកាតដែលប្រើ Print Template។

### ១៤.១ ពិនិត្យ Print Templates (ពុម្ពកាត)
```
ផ្លូវទៅ៖ Admin → Print Templates
```

ប្រព័ន្ធមាន template ស្រាប់ "Default Student Card"។ អាចកែប្រែ HTML/CSS បើចង់។

### ១៤.២ បង្កើត Student Card
```
ផ្លូវទៅ៖ Students → [សិស្ស] → Cards → Create New
```

**បំពេញព័ត៌មាន៖**
- **Card No**: CARD-2026-0001 (unique)
- **Template**: Default Student Card
- **Issue Date**: ថ្ងៃចេញកាត
- **Expire Date**: ថ្ងៃផុតកំណត់
- **Status**: active

### ១៤.៣ បោះពុម្ពកាត (Print)

**Single Print (កាតតែមួយ)៖**
```
Cards → [Card] → Print
```
- បង្ហាញកាតទំហំពេញ
- ប៊ូតុង Print កណ្ដាល
- ប៊ូតុង Back ត្រលប់

**Bulk Print (បោះពុម្ពច្រើនកាត)៖**
```
ផ្លូវទៅ៖ Admin → Student Cards → ជ្រើសរើសច្រើនកាត → Bulk Print
```
- ជ្រើសរើសកាតដែលចង់ Print (checkbox)
- ចុច "Bulk Print"
- បង្ហាញ 4 កាតក្នុង ១ ទំព័រ A4 (2x2 grid)
- ចុច Print

> **កាតបច្ចុប្បន្នមានរចនា៖** Header ពណ៌ខៀវ `#0000ff` + ឈ្មោះសាលា រាងកោងក្រហមតាមរយៈ SVG រូបថតសិស្ស ព័ត៌មានលំអិត (Student Code, Name, Gender, DOB, Course, Phone, Guardian Phone) និង Footer ក្រហម។

---

## ជំហានទី ១៥ — បង្កើត Certificate (វិញ្ញាបនបត្រ)

```
ផ្លូវទៅ៖ Students → [សិស្ស] → Certificates → Create New
```

**បំពេញព័ត៌មាន៖**
- **Certificate No**: CERT-2026-0001 (unique)
- **Type**: appreciation / achievement / participation / completion / excellent_student / other
- **Title**: ចំណងជើង
- **Description**: ការពិពណ៌នា
- **Issue Date**: ថ្ងៃចេញ
- **Status**: draft

**Workflow៖**
1. Create → Status: **draft**
2. Edit / Review
3. **Approve** → Status: approved (ត្រូវការសិទ្ធ `certificates.approve`)
4. **Print** → Status: printed

---

## ជំហានទី ១៦ — បង្កើត Diploma (សញ្ញាបត្រ)

```
ផ្លូវទៅ៖ Students → [សិស្ស] → Diplomas → Create New
```

**បំពេញព័ត៌មាន៖**
- **Diploma No**: DIP-2026-0001 (unique)
- **Course**: វគ្គសិក្សា
- **Level**: ថ្នាក់
- **Class**: ថ្នាក់រៀន
- **Graduation Date**: ថ្ងៃបញ្ចប់ការសិក្សា
- **Issue Date**: ថ្ងៃចេញ
- **Grade**: A / B / C / D
- **GPA**: 3.50
- **Status**: draft

**Workflow ដូច Certificate៖** Draft → Approved → Printed

---

## ជំហានទី ១៧ — បំពេញវត្តមាន (Attendance)

```
ផ្លូវទៅ៖ Admin → Attendances
```

**Single Entry (បំពេញម្នាក់)៖**
- ជ្រើស Student ឬ Staff
- ជ្រើស Class
- ជ្រើស Date
- Status: present / absent / late / excused
- Check-in / Check-out Time

**Bulk Entry (បំពេញច្រើននាក់)៖**
```
Attendances → Bulk Entry → ជ្រើសថ្នាក់ → ជ្រើសថ្ងៃ → បំពេញស្ថានភាពទាំងអស់ → Save
```

---

## ជំហានទី ១៨ — ចាត់បន្ទប់ស្នាក់នៅ (Room Assignment)

```
ផ្លូវទៅ៖ Students → [សិស្ស] → Room Assignments → Create New
```

**បំពេញព័ត៌មាន៖**
- **Room**: ជ្រើសបន្ទប់ទំនេរ
- **Check-in Date**: ថ្ងៃចូននៅ
- **Status**: active

> ចំណាំ៖ Room status នឹង update ដោយស្វ័យប្រវត្តិ (available → full បើចំណុះពេញ)។

---

## ជំហានទី ១៩ — Upload ឯកសារ (Student Files)

```
ផ្លូវទៅ៖ Students → [សិស្ស] → Files → Upload New
```

**ប្រភេទឯកសារដែលអាច upload៖**
- photo (រូបថត)
- birth_certificate (សំបុត្រកំណើត)
- id_card (អត្តសញ្ញាណប័ណ្ណ)
- certificate (វិញ្ញាបនបត្រ)
- diploma (សញ្ញាបត្រ)
- document (ឯកសារទូទៅ)
- other

**បំពេញព័ត៌មាន៖**
- **File Type**: ជ្រើសប្រភេទ
- **File**: ជ្រើស file ពីកុំព្យូទ័រ
- **Is Primary**: បើជាឯកសារសំខាន់

---

## ជំហានទី ២០ — ប្រើប្រាស់ Reports (របាយការណ៍)

```
ផ្លូវទៅ៖ Admin → Reports
```

**ប្រភេទរបាយការណ៍ដែលមាន៖**
1. **Student Report** — ច្រោះតាម branch, course, class, status
2. **New Admissions** — សិស្សចុះឈ្មោះថ្មីតាមខែ
3. **Class Roster** — បញ្ជីសិស្សតាមថ្នាក់
4. **Monthly Attendance** — វត្តមានប្រចាំខែ (student/staff)
5. **Daily Cash Receipts** — លុយដែលបានទទួលប្រចាំថ្ងៃ
6. **AR Aging** — វិក្កយបត្រដែលនៅជំពាក់ (0-30, 31-60, 61-90, 90+ ថ្ងៃ)
7. **Revenue Report** — ចំណូលសរុបតាមរយៈពេល
8. **Fee Statement** — របាយការណ៍ថ្លៃសិក្សាសរុប

**Export៖**
- ជ្រើស Filter → ចុច Export → ជ្រើស Format (PDF / Excel / CSV / Print / View)

---

## ជំហានទី ២១ — ការប្រើប្រាស់ប្រចាំថ្ងៃ (Daily Workflow)

### ព្រឹក៖ បំពេញវត្តមាន
```
Attendances → Bulk Entry → ថ្នាក់ដំបូង → ថ្ងៃថ្ងៃនេះ → បំពេញ → Save
```

### ពេលមានសិស្សថ្មីមកចុះឈ្មោះ៖
```
Students → Create New → បំពេញព័ត៌មាន → Save
  → Guardians → Link Guardian → Save
  → Enrollments → Enroll to Class → Save
  → Fees → Invoices → Create Invoice → Save
  → Fees → Payments → Receive Payment → Save
  → Cards → Create Card → Print
```

### ពេលបោះពុម្ពកាតច្រើននាក់៖
```
Student Cards → ជ្រើសរើសច្រើន → Bulk Print → Print
```

### ពេលចង់មើលរបាយការណ៍ថ្លៃសិក្សា៖
```
Reports → Fee Statement → ជ្រើសខែ → Export → PDF
```

---

## ជំហានទី ២២ — ការថែទាំប្រព័ន្ធ (Maintenance)

### ពិនិត្យ Logs
```
Admin → Audit Logs — មើលសកម្មភាពអ្នកប្រើទាំងអស់
Admin → Print Logs — មើលការបោះពុម្ព
Admin → Export Logs — មើលការនាំចេញ
```

### Backup ទិន្នន័យ (SQLite)
```bash
# ចុចបិទ server មុន
# ចំនូល folder database
cd database

# Copy file SQLite
copy database.sqlite database_backup_2026-05-05.sqlite
```

### Clear Cache (បើមានបញ្ហា)
```bash
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

---

## តារាងជំហានសង្ខេប (Quick Reference)

| លេខ | ជំហាន | គោលបំណង | ទាមទារជាមុន |
|---|---|---|---|
| 0 | Installation | ដំឡើងប្រព័ន្ធ | គ្មាន |
| 1 | Branch | បង្កើតសាខា | គ្មាន |
| 2 | Branch Settings | កំណត់ឈ្មោះសាលា ឡូហ្គូ | Branch |
| 3 | Roles & Users | បង្កើតអ្នកប្រើ | Branch |
| 4 | Academic Setup | Courses, Levels, Years, Shifts | Branch |
| 5 | Staff | បុគ្គលិក គ្រូ | Branch, Genders |
| 6 | Buildings & Rooms | អគារ បន្ទប់ | Branch |
| 7 | Classes | ថ្នាក់រៀន + Schedule | Course, Level, Year, Shift, Staff, Room |
| 8 | Fee Types | ប្រភេទថ្លៃ | Branch |
| 9 | Students | បង្កើតសិស្ស | Branch, Genders |
| 10 | Guardians | ឪពុកម្ដាយ | គ្មាន |
| 11 | Enrollments | ចុះឈ្មោះសិស្ស | Student, Class |
| 12 | Invoices | វិក្កយបត្រ | Student, Fee Types |
| 13 | Payments | ទទួលលុយ | Student, Invoice (optional) |
| 14 | Student Cards | កាតសិស្ស | Student, Print Template |
| 15 | Certificates | វិញ្ញាបនបត្រ | Student, Class (optional) |
| 16 | Diplomas | សញ្ញាបត្រ | Student, Course, Level, Class |
| 17 | Attendance | វត្តមាន | Student/Staff, Class |
| 18 | Room Assignments | ចាត់បន្ទប់ | Student, Room |
| 19 | Files | ឯកសារ | Student |
| 20 | Reports | របាយការណ៍ | ទិន្នន័យទាំងអស់ |

---

## គោលការណ៍សំខាន់ (Golden Rules)

1. **សាខាជាមុនគេ** — គ្មានសាខា = មិនអាចប្រើបាន
2. **Academic Setup មុនបង្កើត Class** — ត្រូវមាន Course + Level + Year + Shift
3. **Staff មុនបង្កើត Class** — Class ត្រូវមាន Teacher
4. **Room មុនបង្កើត Class** — Class ត្រូវមាន Room
5. **Guardian Primary = បង្ហាញលើកាត** — ត្រូវកំណត់ is_primary = true បើចង់បង្ហាញលើកាត
6. **Enrollment មុន Invoice** — វិក្កយបត្រត្រូវបានភ្ជាប់ទៅសិស្ស ប៉ុន្តែ Enrollment ជាកំណត់ត្រាជាផ្លូវការ
7. **Invoice មុន Payment** — Payment អាចភ្ជាប់ទៅ Invoice ដើម្បី update balance
8. **Certificate/Diploma = Draft → Approve → Print** — workflow ដំបូងត្រូវតែ draft
9. **Branch Filter នៅខាងលើ** — រាល់ទិន្នន័យត្រូវបាន filter តាមសាខាដែលបានជ្រើស
10. **Audit Log កត់ត្រាអ្វីគ្រប់យ៉ាង** — មិនចាំបាច់វ worrying ពីការបាត់បង់ data

---

*ឯកសារនេះបង្កើតឡើងសម្រាប់បង្រៀន Customer ប្រើប្រាស់ Student Profile Management System — ពីចាប់ផ្តើមរហូតប្រើប្រាស់បានពេញលេញ*
