<?php

namespace App\Support\Enums;

enum Status: string
{
    case Free = 'free';
    case Published = 'published';
    case Draft = 'draft';
    case Pending = 'pending';
    case Rejected = 'rejected';
    case Active = 'active';
    case Inactive = 'inactive';
}
