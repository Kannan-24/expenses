<?php

namespace Database\Seeders;

use App\Models\TemplateCategory;
use Illuminate\Database\Seeder;

class TemplateCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Financial Reports',
                'description' => 'Financial analysis and transaction reports',
                'icon' => 'chart-bar',
                'color' => '#10B981',
                'sort_order' => 1
            ],
            [
                'name' => 'Budget Analysis',
                'description' => 'Budget tracking and variance reports',
                'icon' => 'calculator',
                'color' => '#3B82F6',
                'sort_order' => 2
            ],
            [
                'name' => 'Operational Reports',
                'description' => 'Support tickets and operational metrics',
                'icon' => 'cog',
                'color' => '#8B5CF6',
                'sort_order' => 3
            ],
            [
                'name' => 'Custom Reports',
                'description' => 'User-defined custom reporting templates',
                'icon' => 'template',
                'color' => '#F59E0B',
                'sort_order' => 4
            ],
            [
                'name' => 'Dashboard Views',
                'description' => 'Summary and overview dashboards',
                'icon' => 'view-grid',
                'color' => '#EF4444',
                'sort_order' => 5
            ]
        ];

        foreach ($categories as $category) {
            TemplateCategory::create($category);
        }
    }
}
