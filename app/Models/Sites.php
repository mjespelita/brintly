<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sites extends Model
{
    /** @use HasFactory<\Database\Factories\SitesFactory> */
protected $fillable = ["name","users_id","folder_name"];
    use HasFactory;
}
