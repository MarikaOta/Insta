<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    private $category;

    public function __construct(Category $category)
    {
        $this->category = $category;
    }

    public function run(): void
    {

        $categories = [[
            'name' =>'Sample category1',
            'created_at' => now(),
            'updated_at' => now()
        ],[
            'name' => 'Sample category2',
            'created_at' => now(),
            'updated_at' => now()
        ],[
            'name' => 'Sample Category 3',
            'created_at' => now(),
            'updated_at' =>now()
        ]
    ];

    //     $categories = [[
    //         'name' =>'Games',
    //         'created_at' => now(),
    //         'updated_at' => now()
    //     ],[
    //         'name' => 'Programming',
    //         'created_at' => now(),
    //         'updated_at' => now()
    //     ],[
    //         'name' => 'MySql',
    //         'created_at' => now(),
    //         'updated_at' =>now()
    //     ]
    // ];

     $this->category->insert($categories);
    }
}

// php artisan db:seed
// seederを使ったdbへの情報の挿入方法①
