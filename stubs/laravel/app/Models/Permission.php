<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Innoboxrr\Traits\MetaOperations;
use App\Models\Traits\Relations\PermissionRelations;
use App\Models\Traits\Storage\PermissionStorage;
use App\Models\Traits\Assignments\PermissionAssignment;
use App\Models\Traits\Operations\PermissionOperations;
use App\Models\Traits\Mutators\PermissionMutators;

class Permission extends Model
{

    use HasFactory,
        SoftDeletes,
        MetaOperations,
        PermissionRelations,
        PermissionStorage,
        PermissionAssignment,
        PermissionOperations,
        PermissionMutators;
        
    protected $fillable = [
        'name',
        'slug',
        'description',
    ];

    protected $creatable = [
        'name',
        'slug',
        'description',
    ];

    protected $updatable = [
        'name',
        'description',
    ];

    protected $casts = [];

    protected $protected_metas = [];

    protected $editable_metas = [];

    public static $export_cols = [
        'id',
        'name',
        'slug',
        'description',
    ];

    public static $loadable_relations = [];

    public static $loadable_counts = [];

    /*
    protected static function newFactory()
    {
        return \App\Database\Factories\PermissionFactory::new();
    }
    */

}
