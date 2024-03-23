<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Question extends Model
{
    /** The table associated with the model.
     *
     * @var string
     */
    protected $table = 'questions';
    protected $fillable = ['name', 'category_id', 'level_id'];
    public function choices(): HasMany
    {
        return $this->hasMany(Choice::class);
    }
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
    public function level():BelongsTo{
        return $this->belongsTo(Level::class);
    }

}
