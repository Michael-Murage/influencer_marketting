<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $socials = [ 'X', 'tiktok', 'youtube', 'facebook', 'instagram'];
        $interests = ['personal_finance', 'fashion', 'music', 'lifestyle', 'fitness', 'cars'];
        $professions = ['content_creator', 'podcasts', 'youtube_channel', 'musician'];
        $gender = ['male', 'female'];
        $roles = [\App\Enums\UserRole::BRAND, \App\Enums\UserRole::CREATOR];

        for ($i=0; $i < 150; $i++) { 
            \App\Models\User::create([
                'name' => "user$i",
                'username' => "user$i",
                'gender' => $gender[rand(0, count($gender) - 1)],
                'phone_number' => "+25470012$i",
                'email' => "user$i$i@mail.net",
                'password' => \Illuminate\Support\Facades\Hash::make('12345678'),
                'user_type' => $roles[rand(0, count($roles) - 1)],
                'company_name' => "company $i",
                'email_verified_at' => "2024-05-05 21:41:37",
                'role' => null,
                'company_size' => '10',
                'industry' => null,
                'website_url' => null,
                'profession' => $professions[mt_rand(0, count($professions) - 1)] . ',' . $professions[mt_rand(0, count($professions) - 1)] . ',' . $professions[mt_rand(0, count($professions) - 1)],
                'interest' => $interests[mt_rand(0, count($interests) - 1)] . ',' . $interests[mt_rand(0, count($interests) - 1)] . ',' . $interests[mt_rand(0, count($interests) - 1)],
                'active_socials' => implode(',', $socials),
                'profile_pic' => null,
                'pic_1' => null,
                'pic_2' => null,
                'pic_3' => null,
                'profile_complete' => 0,
                'info_gathering_prompted' => 1,
                'google_id' => null,
                'bio' => "Lorem ipsum dolor sit amet consectetur adipisicing elit. Deleniti corporis quisquam natus. Nesciunt necessitatibus suscipit odit delectus excepturi nisi architecto veritatis quo aspernatur dicta, porro vero tenetur hic nostrum, reiciendis corrupti eaque! Magni laboriosam ullam possimus dignissimos animi non! Quam tempore a alias distinctio praesentium, sapiente culpa amet voluptatem iste voluptates. Impedit nisi quos facere accusantium est! Explicabo sit velit quibusdam quaerat ex, reprehenderit animi? Repudiandae laboriosam perspiciatis accusantium esse exercitationem, neque quaerat qui vel accusamus dolorum. Voluptate aperiam ex obcaecati numquam consectetur laudantium quod temporibus atque, iure quidem omnis molestiae recusandae sed veritatis vitae ipsa provident! Obcaecati nihil vero temporibus similique, debitis iure perferendis repudiandae culpa at amet ex repellat deserunt cumque tenetur et dolorum molestiae voluptatibus. Nesciunt iusto quos tempore rem. Vel iste culpa cumque possimus dolore asperiores aliquam officia doloremque corporis voluptate dolores, quidem fugit officiis nam.",
            ]);
            
        }
    }
}
