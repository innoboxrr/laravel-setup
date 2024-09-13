<?php

namespace App\Support\Traits;

use App\Models\Language;
use App\Models\Translation;
use Exception;
use Illuminate\Support\Arr;

trait TranslationTrait
{
    // Boot the trait
    protected static function bootTranslationTrait()
    {
        static::retrieved(function ($model) {
            if (! property_exists($model, 'translationable')) {
                throw new Exception('The translationable property is not defined in the model');
            }
            $langCode = request()->get('lang', session('app_locale', null));
            if ($model->isValidLang($langCode)) {
                $model->loadTranslation($langCode);
            }
        });
    }

    protected function loadTranslation($langCode)
    {
        $this->load(['translation' => function ($query) use ($langCode) {
            $query->whereHas('language', function ($query) use ($langCode) {
                $query->where('code', $langCode);
            });
        }]);
    }

    // Relations
    public function translations()
    {
        return $this->morphMany(Translation::class, 'translationable');
    }

    public function translation()
    {
        return $this->morphOne(Translation::class, 'translationable');
    }

    // Operations
    protected function isValidLang($lang)
    {
        if(is_array($lang)) {
            $lang = isset($lang['code']) ? $lang['code'] : null;
        }
        $cacheKey = 'valid_languages';
        $languages = cache()->remember($cacheKey, now()->addDay(), function () {
            return Language::pluck('code')->toArray();
        });

        return in_array($lang, $languages);
    }

    protected function updateTranslation(array $data)
    {
        $language = cache()->remember('language_'.$data['lang'], now()->addYear(), function () use ($data) {
            return Language::where('code', $data['lang'])->firstOrFail();
        });

        $this->translations()->where('language_id', $language->id)->updateOrCreate([
            'language_id' => $language->id,
        ], [
            'map' => $this->getMap($data),
        ]);

        return $this;
    }

    public function getMap(array $data)
    {
        // Recuperar la representación JSON actual del modelo, incluidos los arrays anidados.
        $currentModelData = json_decode($this->toJson(), true);

        // Decodificar recursivamente cualquier JSON anidado.
        $currentModelData = $this->decodeJsonRecursive($currentModelData);

        // Eliminar la claves del arreglo
        $currentModelData = Arr::except($currentModelData, [
            'translation',
            'created_at',
            'updated_at',
            'deleted_at',
            'id',
        ]);

        // Supongamos que 'payload' es un campo JSON que puede contener estructuras anidadas.
        /*
        if (isset($currentModelData['payload'])) {
            $currentModelData['payload'] = json_decode($currentModelData['payload'], true);
        }
        */

        // Si existe una traducción previa, combinarla con la representación actual.
        $existingTranslation = $this->translations()->where('language_id', $data['lang'])->first();
        if ($existingTranslation) {
            $translatedData = json_decode($existingTranslation->map, true);
            $currentModelData = $this->mergeTranslation($currentModelData, $translatedData);
        }

        // Recorrer $data para actualizar $currentModelData con los nuevos valores.
        foreach ($data as $key => $value) {
            $currentModelData = $this->updateNestedData($currentModelData, $key, $value);
        }

        // Convertir de vuelta a JSON si necesario, por ejemplo, para 'payload'.
        /*
        if (isset($currentModelData['payload'])) {
            $currentModelData['payload'] = json_encode($currentModelData['payload']);
        }
        */

        return $currentModelData;
    }

    protected function decodeJsonRecursive($data)
    {
        if (is_string($data)) {
            // Verificar si la cadena es un JSON válido
            $decodedData = json_decode($data, true);
            if (json_last_error() === JSON_ERROR_NONE) {
                $data = $this->decodeJsonRecursive($decodedData); // Decodificar recursivamente
            }
        } elseif (is_array($data)) {
            // Si es un array, aplicar la función a cada elemento
            foreach ($data as $key => $value) {
                $data[$key] = $this->decodeJsonRecursive($value);
            }
        } elseif (is_object($data)) {
            // Si es un objeto, aplicar la función a cada propiedad
            foreach ($data as $key => $value) {
                $data->$key = $this->decodeJsonRecursive($value);
            }
        }

        return $data;
    }

    protected function mergeTranslation($currentModelData, $translatedData)
    {
        // Fusiona recursivamente el arreglo actual del modelo con los datos traducidos.
        // Ajusta esta función según las necesidades específicas de tu aplicación.
        foreach ($translatedData as $key => $value) {
            if (is_array($value) && isset($currentModelData[$key]) && is_array($currentModelData[$key])) {
                $currentModelData[$key] = $this->mergeTranslation($currentModelData[$key], $value);
            } else {
                $currentModelData[$key] = $value;
            }
        }

        return $currentModelData;
    }

    protected function updateNestedData($array, $key, $value)
    {
        // Esta función asume que $key puede ser una clave simple o una ruta anidada.
        if (strpos($key, '.') !== false) {
            // Para claves anidadas, como 'payload.someNestedKey'.
            $keys = explode('.', $key);
            $lastKey = array_pop($keys);
            $temp = &$array;
            foreach ($keys as $innerKey) {
                if (! isset($temp[$innerKey]) || ! is_array($temp[$innerKey])) {
                    $temp[$innerKey] = [];
                }
                $temp = &$temp[$innerKey];
            }
            $temp[$lastKey] = $value;
        } else {
            // Para claves de nivel superior.
            $array[$key] = $value;
        }

        return $array;
    }

    // Función para traducir el modelo en el backend
    public function translateModel($locale = null)
    {
        // Cargar la traducción correspondiente al locale (si no está cargada ya)
        if ($locale && !$this->relationLoaded('translation')) {
            $this->loadTranslation($locale);
        }

        // Si no existe una traducción para el modelo, devolver el modelo tal cual
        if (!$this->translation || !$this->translation->map) {
            return $this;
        }

        // Iterar sobre el array de traducción y sobreescribir los valores del modelo
        foreach ($this->translation->map as $key => $value) {
            // Verificar si la clave existe en el modelo actual
            if ($this->getAttribute($key) !== null) {
                $this->setAttribute($key, $value);
            }
        }

        return $this;
    }
}
