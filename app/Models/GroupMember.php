<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GroupMember extends Model
{
    protected $fillable = [
        'group_id',
        'name',
        'student_id',
        'batch',
        'session',
        'department',
        'role',
    ];

    public function group()
    {
        return $this->belongsTo(Group::class);
    }
}