<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{

    protected $fillable = [
        'user_id',
        'action',
        'description',
        'subject_id',
        'subject_type'
    ];

    // Définir la relation polymorphique
    public function subject()
    {
        return $this->morphTo();
    }

    // Récupérer l'utilisateur associé à l'activité
    public function user()
    {
        return $this->belongsTo(User::class);
    }


}
