<?php

namespace App\Support\Traits;

use App\Models\Category;
use Illuminate\Support\Facades\DB;

trait Categorizable
{
    /**
     * Relations
     */
    public function categories()
    {
        return $this->morphToMany(Category::class, 'categorizable')
            ->withPivot('is_primary')
            ->withTimestamps();
    }

    /**
     * Asigna categorías al modelo.
     *
     * @param  mixed  $categories
     * @return void
     */
    public function syncCategories($categories)
    {
        $this->categories()->sync($categories);
    }

    /**
     * Desasigna categorías del modelo.
     *
     * @param  mixed  $categories
     * @return void
     */
    public function removeCategories($categories)
    {
        $this->categories()->detach($categories);
    }

    /**
     * Establece una categoría como la categoría principal.
     *
     * @param  int  $categoryId
     * @return void
     */
    public function setPrimaryCategory($categoryId)
    {
        DB::transaction(function () use ($categoryId) {
            // Primero, quita la categoría principal actual, si existe
            DB::table('categorizables')
                ->where('categorizable_type', get_class($this))
                ->where('categorizable_id', $this->id)
                ->update(['is_primary' => false]);

            // Luego, establece la nueva categoría principal
            DB::table('categorizables')
                ->where('categorizable_type', get_class($this))
                ->where('categorizable_id', $this->id)
                ->where('category_id', $categoryId)
                ->update(['is_primary' => true]);

            // Buscar el Categorizable y actualizar su payload para registrar el nombre de la categoría principal actual
            $category = $this->categories()->wherePivot('category_id', $categoryId)->first();
            // Verificar que metas y updatePayload existan en el modelo
            if (!method_exists($this, 'metas') || !method_exists($this, 'updatePayload')) {
                return;
            }
            $this->metas()->updateOrCreate(
                ['key' => 'primary_category'],
                ['value' => $category->name]
            );
            $this->updatePayload();
        });
    }

    /**
     * Obtiene la categoría principal del modelo.
     *
     * @return mixed
     */
    public function getPrimaryCategory()
    {
        return $this->categories()->wherePivot('is_primary', true)->first();
    }

    public function getHierarchicalCategories()
    {
        $categories = $this->categories;
        $hierarchicalCategories = [];

        foreach ($categories as $category) {
            $hierarchy = $this->buildCategoryHierarchy($category);

            // Para cada categoría en la jerarquía, generamos los niveles
            foreach ($hierarchy as $index => $level) {
                $key = 'lvl' . $index;  // Genera los niveles: lvl0, lvl1, lvl2
                $hierarchicalCategories[$key] = implode(' > ', array_slice($hierarchy, 0, $index + 1));
            }
        }

        return $hierarchicalCategories;
    }

    /**
     * Construye la jerarquía de una categoría.
     */
    protected function buildCategoryHierarchy($category, $hierarchy = [])
    {
        // Añadir la categoría actual al principio del array
        array_unshift($hierarchy, $category->name);

        // Si la categoría tiene una categoría padre, seguir subiendo en la jerarquía
        if ($category->parent_id) {
            $parentCategory = Category::find($category->parent_id);
            return $this->buildCategoryHierarchy($parentCategory, $hierarchy);
        }

        return $hierarchy;
    }

}
