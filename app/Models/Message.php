<?php

// Message.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = ['user_id', 'content']; // Permet d'ajouter ces champs à la base
}
