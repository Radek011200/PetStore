<?php

namespace App\Enums;

use Illuminate\Validation\Rules\Enum;

class PetStatus extends Enum
{
    public const AVAILABLE = 'available';
    public const PENDING = 'pending';
    public const SOLD = 'sold';

}
