<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SmtpModel extends Model
{
    use HasFactory;
	protected $table='email_smtp';
}
