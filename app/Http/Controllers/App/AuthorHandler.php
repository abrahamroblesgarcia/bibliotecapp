<?php 
namespace App\Http\Controllers\App;

use App\Utils\Util;
use App\Models\Author;

class AuthorHandler implements AppControllerInterface
{

    public function show(int $id)
    {
        $author = Author::find($id);
        if( $author !== null )
        {
            return $author;
        }

        return false;
    }

    public function showAll()
    {
        return Author::all();
    }

    public function create(Array $fields)
    {
        if( Util::checkIfKeysExistsInArray($fields, ['name','birth_date','death_date']) )
        {
            return Author::create($fields);
        }
        
        // No se han recibido los campos correctos
        return false;
    }

    public function update(Array $fields)
    {
        if( Util::checkIfKeysExistsInArray($fields, ['name','id','birth_date','death_date']) )
        {
            // 1º Obtiene el autor
            $author = $this->show($fields['id']);

            // 2º Actualiza el autor (si existe)
            if( !is_bool($author))
            {
                $author->name           = $fields['name'];
                $author->pseudonym      = $fields['pseudonym'];
                $author->birth_date     = $fields['birth_date'];
                $author->death_date     = $fields['death_date'];
                $author->save();
    
                return $author;
            }
        }
        
        // No se han recibido los campos correctos
        return false;
    }

    public function delete(int $id)
    {   
        // 1º Obtiene el autor
        $author = $this->show($id);

        // 2º Borra el autor (si existe)
        if( !is_bool($author) )
        {
            return $author->delete();
        }

        return false;
    }
}