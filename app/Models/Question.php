<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Question extends Model
{
    /** The table associated with the model.
     *
     * @var string
     */
    protected $table = 'questions';
    public function choices(): BelongsTo
    {
        return $this->belongsTo(Choice::class, 'choice_id');
    }
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
    public function level():BelongsTo{
        return $this->belongsTo(Level::class , "level_id");
    }

}
