<?php

namespace Database\Seeders;

use App\Models\Opportunity;
use Illuminate\Database\Seeder;

/**
 * OPTIONAL demo data so the progress bars look like the mock-up (28/40, 60/60, ...).
 *   php artisan db:seed --class=DemoRegistrationsSeeder
 */
class DemoRegistrationsSeeder extends Seeder
{
    public function run(): void
    {
        $fill = [
            'حملة تشجير الرياض' => 28,
            'توزيع وجبات إفطار الصائم' => 60,
            'مرشد سياحي متطوع في العلا' => 11,
            'تنظيف شاطئ جدة' => 35,
            'دروس تقوية للطلاب' => 9,
            'مسعف متطوع في الفعاليات' => 22,
        ];

        foreach ($fill as $title => $target) {
            $opportunity = Opportunity::where('title', $title)->first();
            if (! $opportunity) {
                continue;
            }

            $existing = $opportunity->registrations()->count();

            for ($i = $existing + 1; $i <= min($target, $opportunity->capacity); $i++) {
                $opportunity->registrations()->create([
                    'name' => "متطوع تجريبي {$i}",
                    'email' => "demo{$opportunity->id}_{$i}@example.com",
                    'phone' => '05'.str_pad((string) (10000000 + $opportunity->id * 1000 + $i), 8, '0', STR_PAD_LEFT),
                    'age' => 18 + ($i % 40),
                ]);
            }
        }
    }
}
