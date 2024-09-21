<?php

namespace App\Contracts\Search;

/**
 * Docs:
 *  - Paso 1: Implementar esta interfaz en los modelos que se deseen indexar.
 *  - Paso 2: Registrar el modelo en el archivo de configuración config/search.php.
 *  - Paso 3: Crear el [Model]Search trait con los métodos correspondientes.
 *  - Paso 4: Añadir el SearchableTrait para los métodos generales.
 *  - Paso 5: Ejecutar el job SearchIndexingJob para indexar los modelos a través del comando php artisan search:indexing-command
 */

interface SearchableInterface
{
    public function getSearchImage(): ?string;

    public function getSearchTerm(): string;

    public function getSearchDescription(): ?string;

    public function getSearchLink(): ?string;

    public function getSearchOther(): ?array;

    public function getSearchSearchableType(): string;

    public function getSearchSearchableId(): int;

    public function removeSearchableData($local = null): void;

    public function updateSearchableData($local = null): void;

}