<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DataSeeder extends Seeder
{
    public function run(): void
    {
        $csvPath = base_path('../course-work/dataset/ecommerce_data.csv');

        if (!file_exists($csvPath)) {
            $this->command->error('CSV file not found at: ' . $csvPath);
            return;
        }

        $file = fopen($csvPath, 'r');
        $header = fgetcsv($file);
        $batch = [];
        $count = 0;

        while (($row = fgetcsv($file)) !== false) {
            $batch[] = [
                'customer_id' => $row[0],
                'customer_name' => $row[1],
                'age' => (int)$row[2],
                'gender' => $row[3],
                'city' => $row[4],
                'registration_date' => $row[5],
                'order_id' => $row[6],
                'order_date' => $row[7],
                'product_category' => $row[8],
                'product_name' => $row[9],
                'unit_price' => (int)$row[10],
                'quantity' => (int)$row[11],
                'total_amount' => (int)$row[12],
                'payment_method' => $row[13],
                'discount_applied' => $row[14],
                'discount_percent' => (int)$row[15],
                'satisfaction_score' => (int)$row[16],
                'session_duration_min' => (int)$row[17],
                'device_type' => $row[18],
                'num_previous_purchases' => (int)$row[19],
            ];

            $count++;

            if (count($batch) >= 100) {
                DB::table('orders')->insert($batch);
                $batch = [];
            }
        }

        if (!empty($batch)) {
            DB::table('orders')->insert($batch);
        }

        fclose($file);
        $this->command->info("Imported {$count} records from CSV.");
    }
}
