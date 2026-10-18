<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Elequent\Relations\HasMany;

class Product extends Model
{
    protected $fillable = [
        'category_id' ,
        'sku',
        'name',
        'unit',
        'purchase_price',
        'selling_price',
        'stock',
        'min_stock',
        'description',
    ];

    protected function casts(): array
    {
        return [
            'purchase_price' => 'decimal:2',
            'selling_price' => 'decimal:2',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function stockMovements(): HasMany
    {
        return $this->hasMany(StockMovement::class);
    }
}
