<?php 
namespace App\Http\Controllers\App;

use App\Utils\Util;
use App\Models\Category;

class CategoryHandler implements AppControllerInterface
{

    public function show(int $id)
    {
        $category = Category::find($id);
        if( $category !== null )
        {
            return $category;
        }

        return false;
    }

    public function showAll()
    {
        return Category::all();
    }

    public function create(Array $fields)
    {
        if( Util::checkIfKeysExistsInArray($fields, ['name']) )
        {
            return Category::create($fields);
        }
        
        // No se han recibido los campos correctos
        return false;
    }

    public function update(Array $fields)
    {
        if( Util::checkIfKeysExistsInArray($fields, ['name','id']) )
        {
            // 1º Obtiene la categoría
            $category = $this->show($fields['id']);

            // 2º Actualiza la categoría (si existe)
            if( !is_bool($category))
            {
                $category->name         = $fields['name'];
                $category->description  = $fields['description'];
                $category->save();
    
                return $category;
            }
        }
        
        // No se han recibido los campos correctos
        return false;
    }

    public function delete(int $id)
    {   
        // 1º Obtiene la categoría
        $category = $this->show($id);

        // 2º Borra la categoría (si existe)
        if( !is_bool($category) )
        {
            return $category->delete();
        }

        return false;
    }
}