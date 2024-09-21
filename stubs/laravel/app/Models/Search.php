<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Innoboxrr\Traits\MetaOperations;
use App\Models\Traits\Relations\SearchRelations;
use App\Models\Traits\Storage\SearchStorage;
use App\Models\Traits\Assignments\SearchAssignment;
use App\Models\Traits\Operations\SearchOperations;
use App\Models\Traits\Mutators\SearchMutators;
use Laravel\Scout\Searchable;

class Search extends Model
{

    use HasFactory,
        SoftDeletes,
        MetaOperations,
        SearchRelations,
        SearchStorage,
        SearchAssignment,
        SearchOperations,
        SearchMutators,
        Searchable;
        
    protected $fillable = [
        'term',
        'image',
        'description',
        'link',
        'locale',
        'other',
        'searchable_id',
        'searchable_type',
    ];

    protected $creatable = [
        'term',
        'image',
        'description',
        'link',
        'locale',
        'other',
        'searchable_id',
        'searchable_type',
    ];

    protected $updatable = [
        'term',
        'image',
        'description',
        'link',
        'locale',
        'other',
        'searchable_id',
        'searchable_type',
    ];

    protected $casts = [
        'other' => 'array',
    ];

    protected $protected_metas = [];

    protected $editable_metas = [];

    public static $export_cols = [];

    public static $loadable_relations = [];

    public static $loadable_counts = [];

    /*
    protected static function newFactory()
    {
        return \App\Database\Factories\SearchFactory::new();
    }
    */
    public function toSearchableArray()
    {
        // Define el tamaño máximo permitido para cada campo (en bytes)
        $maxFieldSize = 5000; // Por ejemplo, 5 KB por campo (ajústalo según lo que necesites)
        
        // Crear el array con los campos a indexar
        $array = [
            'id' => $this->id,
            'term' => $this->term,
            'description' => $this->description,
            'link' => $this->link,
            'image' => $this->image,
            'locale' => $this->locale,
            'searchable_id' => $this->searchable_id,
            'searchable_type' => $this->searchable_type,
        ];

        // Añadir los campos adicionales
        $array = array_merge($array, $this->other ?? []);
    
        // Truncar los campos que excedan el tamaño máximo permitido
        foreach ($array as $key => $value) {
            if (is_string($value)) {
                $array[$key] = $this->truncateField($value, $maxFieldSize);
            }
        }
    
        return $array;
    }
    
    protected function truncateField($value, $maxSize)
    {
        // Verificar si el valor excede el tamaño máximo permitido
        if (strlen($value) > $maxSize) {
            return substr($value, 0, $maxSize); // Truncar al tamaño permitido
        }
        
        return $value;
    }    
}
