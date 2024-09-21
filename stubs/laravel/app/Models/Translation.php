<?php

namespace App\Models;

use App\Models\Traits\Assignments\TranslationAssignment;
use App\Models\Traits\Mutators\TranslationMutators;
use App\Models\Traits\Operations\TranslationOperations;
use App\Models\Traits\Relations\TranslationRelations;
use App\Models\Traits\Storage\TranslationStorage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Innoboxrr\LaravelAudit\Support\Traits\Auditable;
use Innoboxrr\Traits\MetaOperations;

class Translation extends Model
{
    use Auditable,
        HasFactory,
        MetaOperations,
        SoftDeletes,
        TranslationAssignment,
        TranslationMutators,
        TranslationOperations,
        TranslationRelations,
        TranslationStorage;

    protected $fillable = [
        'language_id',
        'map',
        'translationable_id',
        'translationable_type',
    ];

    protected $creatable = [
        'language_id',
        'map',
        'translationable_id',
        'translationable_type',
    ];

    protected $updatable = [
        'language_id',
        'map',
    ];

    protected $casts = [
        'map' => 'array',
    ];

    protected $protected_metas = [];

    protected $editable_metas = [];

    public static $export_cols = [
        'language_id',
        'map',
        'translationable_id',
        'translationable_type',
    ];

    public static $loadable_relations = [
        'language',
        'translatable',
    ];

    public static $loadable_counts = [
        'language',
        'translatable',
    ];

    /*
    protected static function newFactory()
    {
        return \App\Database\Factories\TranslationFactory::new();
    }
    */

}
