<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['judul', 'kategori', 'deskripsi', 'url_sampul', 'aktif'])]
#[Table('buku')]
class Buku extends Model
{
    public const CATEGORIES = ['Pelajaran', 'Novel', 'Komik', 'Kamus', 'Biografi'];

    protected $attributes = [
        'aktif' => true,
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'aktif' => 'boolean',
        ];
    }

    public function peminjaman(): HasMany
    {
        return $this->hasMany(Peminjaman::class, 'buku_id');
    }
}
