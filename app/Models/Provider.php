<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Provider extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function rootCategory(): HasOne
    {
        return $this->hasOne(Category::class)->whereNull('parent_id');
    }

    public function batches(): HasMany
    {
        return $this->hasMany(Batch::class);
    }
}
