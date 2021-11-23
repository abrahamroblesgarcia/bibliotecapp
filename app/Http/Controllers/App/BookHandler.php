<?php 
namespace App\Http\Controllers\App;

use App\Utils\Util;
use App\Models\Book;

class BookHandler implements AppControllerInterface
{

    public function show(int $id)
    {
        $book = Book::find($id);
        if( $book !== null )
        {
            return $book;
        }

        return false;
    }

    public function showAll()
    {
        return Book::all();
    }

    public function create(Array $fields)
    {
        if( Util::checkIfKeysExistsInArray($fields, ['title','ISBN','description','author_id']) )
        {
            return Book::create($fields);
        }
        
        // No se han recibido los campos correctos
        return false;
    }

    public function update(Array $fields)
    {
        if( Util::checkIfKeysExistsInArray($fields, ['title','ISBN','description','author_id']) )
        {
            // 1º Obtiene el libro
            $book = $this->show($fields['id']);

            // 2º Actualiza el libro (si existe)
            if( !is_bool($book))
            {
                $book->title            = $fields['title'];
                $book->ISBN             = $fields['ISBN'];
                $book->description      = $fields['description'];
                $book->author_id        = $fields['author_id'];
                $book->save();
    
                return $book;
            }
        }
        
        // No se han recibido los campos correctos
        return false;
    }

    public function delete(int $id)
    {   
        // 1º Obtiene el libro
        $book = $this->show($id);

        // 2º Borra el book (si existe)
        if( !is_bool($book) )
        {
            return $book->delete();
        }

        return false;
    }
}