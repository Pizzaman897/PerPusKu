<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Buku;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use RuntimeException;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        if (! app()->environment(['local', 'testing'])) {
            throw new RuntimeException('Demo records can only be seeded in local or testing environments.');
        }

        $adminPassword = config('seeders.admin_password');
        $userPassword = config('seeders.user_password');

        if (! is_string($adminPassword) || $adminPassword === ''
            || ! is_string($userPassword) || $userPassword === '') {
            throw new RuntimeException('Set SEED_ADMIN_PASSWORD and SEED_USER_PASSWORD before running the seeder.');
        }

        Admin::updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Admin1',
                'password' => $adminPassword,
            ],
        );

        User::updateOrCreate(
            ['email' => 'user@gmail.com'],
            [
                'name' => 'User1',
                'password' => $userPassword,
            ],
        );

        Buku::updateOrCreate(
            ['judul' => '3726 MDPL'],
            [
                'kategori' => 'Novel',
                'deskripsi' => 'Novel karya Nurwina Sari tentang Rangga, mahasiswa Fakultas Kehutanan yang menjadi ketua OSPEK dan menyukai Andini. Saat Andini berencana mendaki Gunung Rinjani, sosok dari masa lalunya membuat Rangga mempertanyakan hubungan mereka.',
                'url_sampul' => 'https://image.gramedia.net/rs:fit:0:0/f:webp/plain/https://cdn.gramedia.com/uploads/products/9397p4603v.jpg',
            ],
        );
    }
}
