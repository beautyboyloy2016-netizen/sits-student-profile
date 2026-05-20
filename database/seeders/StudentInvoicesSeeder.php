<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StudentInvoicesSeeder extends Seeder
{
    public function run(): void
    {
        $adminId        = DB::table('users')->where('email', 'superadmin@school.edu.kh')->value('id');
        $registrationFee = DB::table('fee_types')->where('name', 'Registration Fee')->first();
        $tuitionFee      = DB::table('fee_types')->where('name', 'Monthly Tuition')->first();
        $materialFee     = DB::table('fee_types')->where('name', 'Material / Book Fee')->first();

        $activeStudents = DB::table('students')->where('status', 'active')->get();
        $invoiceCounter = 1;
        $paymentCounter = 1;

        foreach ($activeStudents as $student) {
            // Skip if invoice already exists
            $exists = DB::table('student_invoices')
                ->where('student_id', $student->id)
                ->exists();

            if ($exists) {
                continue;
            }

            $invoiceNo    = 'INV-' . date('Y') . '-' . str_pad($invoiceCounter++, 5, '0', STR_PAD_LEFT);
            $invoiceDate  = now()->startOfMonth()->toDateString();
            $dueDate      = now()->endOfMonth()->toDateString();

            $regAmount  = $registrationFee?->amount ?? 10.00;
            $tuitAmount = $tuitionFee?->amount ?? 30.00;
            $matAmount  = $materialFee?->amount ?? 15.00;
            $total      = $regAmount + $tuitAmount + $matAmount;

            // Alternate: some paid, some partial, some unpaid
            $statusOptions = ['paid', 'paid', 'partial', 'unpaid'];
            $status        = $statusOptions[($invoiceCounter - 2) % 4];

            $paidAmount = match($status) {
                'paid'    => $total,
                'partial' => round($total / 2, 2),
                default   => 0,
            };
            $balance = $total - $paidAmount;

            $invoiceId = DB::table('student_invoices')->insertGetId([
                'branch_id'       => $student->branch_id,
                'invoice_no'      => $invoiceNo,
                'student_id'      => $student->id,
                'invoice_date'    => $invoiceDate,
                'due_date'        => $dueDate,
                'total_amount'    => $total,
                'discount_amount' => 0,
                'paid_amount'     => $paidAmount,
                'balance'         => $balance,
                'status'          => $status,
                'created_by'      => $adminId,
                'updated_by'      => $adminId,
                'created_at'      => now(),
                'updated_at'      => now(),
            ]);

            // Invoice line items
            foreach ([
                [$registrationFee, 'Registration Fee',    1, $regAmount],
                [$tuitionFee,       'Monthly Tuition Fee', 1, $tuitAmount],
                [$materialFee,      'Material / Book Fee', 1, $matAmount],
            ] as [$feeType, $desc, $qty, $price]) {
                DB::table('student_invoice_items')->insert([
                    'invoice_id'  => $invoiceId,
                    'fee_type_id' => $feeType?->id ?? null,
                    'description' => $desc,
                    'qty'         => $qty,
                    'unit_price'  => $price,
                    'total'       => $qty * $price,
                    'created_at'  => now(),
                    'updated_at'  => now(),
                ]);
            }

            // Payment record for paid/partial invoices
            if ($paidAmount > 0) {
                $paymentNo = 'PAY-' . date('Y') . '-' . str_pad($paymentCounter++, 5, '0', STR_PAD_LEFT);

                DB::table('payments')->insert([
                    'branch_id'      => $student->branch_id,
                    'payment_no'     => $paymentNo,
                    'invoice_id'     => $invoiceId,
                    'student_id'     => $student->id,
                    'payment_date'   => $invoiceDate,
                    'amount'         => $paidAmount,
                    'payment_method' => 'cash',
                    'received_by'    => $adminId,
                    'note'           => null,
                    'created_at'     => now(),
                    'updated_at'     => now(),
                ]);
            }
        }
    }
}
