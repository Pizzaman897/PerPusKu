<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['user_id', 'buku_id', 'dipinjam_pada', 'batas_pengembalian', 'dikembalikan_pada', 'status'])]
#[Table('peminjaman')]
class Peminjaman extends Model
{
    protected $attributes = [
        'status' => 'pending',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'dipinjam_pada' => 'datetime',
            'batas_pengembalian' => 'datetime',
            'dikembalikan_pada' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function buku(): BelongsTo
    {
        return $this->belongsTo(Buku::class, 'buku_id');
    }

    public function statusEfektif(): string
    {
        if (in_array($this->status, ['dikembalikan', 'terlambat'], true)) {
            return $this->status;
        }

        if ($this->dikembalikan_pada !== null) {
            return $this->batas_pengembalian !== null
                && $this->dikembalikan_pada->greaterThan($this->batas_pengembalian)
                ? 'terlambat'
                : 'dikembalikan';
        }

        if ($this->status === 'dipinjam' && $this->batas_pengembalian?->isPast()) {
            return 'lewat_batas_waktu';
        }

        return $this->status;
    }
}
