<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory;

    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'image',
        'category',
        'taxable',
        'variants',
        'active',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'taxable' => 'boolean',
            'variants' => 'array',
            'active' => 'boolean',
        ];
    }

    /**
     * Get available colors for the product.
     *
     * @return array<string>
     */
    public function getColorsAttribute(): array
    {
        return $this->variants['colors'] ?? [];
    }

    /**
     * Get available sizes for the product.
     *
     * @return array<string>
     */
    public function getSizesAttribute(): array
    {
        return $this->variants['sizes'] ?? [];
    }
}
