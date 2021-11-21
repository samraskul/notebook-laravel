<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NavbarMenu extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'name', 'slug', 'parent_id', 'icon', 'link', 'is_active'];
}