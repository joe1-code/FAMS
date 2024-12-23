<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationDocument extends Model
{
    use HasFactory;

   protected $fillable = [
        'filename',
        'path',
        'mime_type',
        'user_id',
        'document_type',
    ];
}
