<?php

namespace MOIREI\Settings\Tests;

use Illuminate\Database\Eloquent\Model;
use MOIREI\Settings\HasSettings;

class User extends Model
{
  use HasSettings;
};
