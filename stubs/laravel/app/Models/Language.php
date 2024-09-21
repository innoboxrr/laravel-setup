<?php

namespace App\Models;

use App\Models\Traits\Assignments\LanguageAssignment;
use App\Models\Traits\Mutators\LanguageMutators;
use App\Models\Traits\Operations\LanguageOperations;
use App\Models\Traits\Relations\LanguageRelations;
use App\Models\Traits\Storage\LanguageStorage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Innoboxrr\LaravelAudit\Support\Traits\Auditable;
use Innoboxrr\Traits\MetaOperations;

class Language extends Model
{
    use Auditable,
        HasFactory,
        LanguageAssignment,
        LanguageMutators,
        LanguageOperations,
        LanguageRelations,
        LanguageStorage,
        MetaOperations,
        SoftDeletes;

    protected $fillable = [
        'name',
        'code',
        'country_code',
    ];

    protected $creatable = [
        'name',
        'code',
        'country_code',
    ];

    protected $updatable = [
        'name',
        'code',
        'country_code',
    ];

    protected $casts = [];

    protected $protected_metas = [];

    protected $editable_metas = [];

    public static $export_cols = [
        'name',
        'code',
        'country_code',
    ];

    public static $loadable_relations = [
        'translations',
        'users',
    ];

    public static $loadable_counts = [
        'translations',
        'users',
    ];

    /*
    protected static function newFactory()
    {
        return \App\Database\Factories\LanguageFactory::new();
    }
    */

}
