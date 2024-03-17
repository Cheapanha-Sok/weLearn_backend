<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
     /** The table associated with the model.
     *
     * @var string
     */
    protected $table = 'categories';
    public function pdfs(): HasMany
    {
        return $this->hasMany(Pdf::class);
    }
}
