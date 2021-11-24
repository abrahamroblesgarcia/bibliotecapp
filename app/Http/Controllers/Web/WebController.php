<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Http\Controllers\App\AppHandler;
use App\Http\Controllers\App\CategoryHandler;
use App\Http\Controllers\App\AuthorHandler;
use App\Http\Controllers\App\BookHandler;


/**
 * Controlador principal que maneja las rutas web de la aplicación.
 * El manejo de los datos ocurre con AppHandler y se utiliza inyección de 
 * dependencias para abstraer las operaciones de cada controlador y ser controlado
 * desde una única clase.
 * 
 * Las rutas se dividen en 3 bloques: 
 * 
 * 1º Rutas de categorías
 * 2º Rutas de autores
 * 3º Rutas de libros
 */
class WebController extends Controller
{

    /**
     * CATEGORÍA
     */
    public function createCategory(Request $request)
    {
        $validator = $this->validateData(
            $request, 
            ['name' => 'required|unique:categories,name|max:100'], 
            ['name.required' => 'El campo "Nombre de la categoría" es requerido']
        );
        
        if( $validator->isValidated )
        {
            // Crea la categoría
            $category = new AppHandler( new CategoryHandler() );
            $categoryData = [
                'name'          => $request->name,
                'description'   => $request->description
            ];
            if( $category->create($categoryData) !== false )
            {
                // redirige a la vista principal del dashboard
                return redirect("/")
                            ->with('success', 'Categoría creada correctamente');
            }
            else 
            {
                // redirige a la vista de cración de categoría con error
                return redirect('create-category')
                            ->withErrors(['msg' => 'Ha habido un problema con los datos introducidos, por favor inténtelo de nuevo'])
                            ->withInput();
            }
        }
        else 
        {
            // Los datos recibidos no son correctos
            return $validator->validationResponse;
        }
    }

    public function showCategories(Request $request)
    {
        $category = new AppHandler( new CategoryHandler() );

        return view('category.get-categories', [
            'categories' => $category->showAll()
        ]);
    }

    public function updateCategoryView(Request $request)
    {
        // Muestra la vista de actualizar categoría.
        $category = new AppHandler( new CategoryHandler() );
        $category = $category->show($request->id);

        if( $category !== false )
        {
            return view('category.edit-category', [ 'category' => $category ]);
        }
        else 
        {
            return redirect()
                    ->back()
                    ->withErrors(['msg' => 'Ha habido un problema a la hora de acceder a la categoría a editar, por favor inténtelo de nuevo'])
                    ->withInput();
        }
    }

    public function processUpdateCategory(Request $request)
    {
        $validator = $this->validateData(
            $request, 
            [
                'id'   => 'required|exists:categories,id',
                'name' => [
                    'required',
                    'max:100',
                    // Esta regla es para ignorar en la propia validación como único nombre la propia categoría editada.
                    Rule::unique('categories')->ignore($request->id),
                    ]
            ], 
            [
                'id.exists'     => 'El ID de categoría recibido no existe', 
                'unique'        => 'El campo nombre de la categoría debe de ser único',
                'name.required' => 'El campo "Nombre de la categoría" es requerido',
                'id.required'   => 'El id de la categoría es requerido',
            ]
        );
        
        if( $validator->isValidated )
        {
            // Actualiza la categoría
            $category = new AppHandler( new CategoryHandler() );
            $categoryData = [
                'id'            => $request->id,
                'name'          => $request->name,
                'description'   => $request->description
            ];
            if( $category->update($categoryData) !== false )
            {
                // La actualización ha ido correctamente.
                return redirect()
                        ->back()
                        ->with('success', 'Categoría actualizada correctamente');
            }
            else 
            {
                // redirige a la vista de edición de categoría con error
                return redirect()
                        ->back()
                        ->withErrors(['msg' => 'Ha habido un problema con los datos introducidos, por favor inténtelo de nuevo'])
                        ->withInput();
            }
        }
        else 
        {
            // Los datos recibidos no son correctos
            return $validator->validationResponse;
        }
    }

    public function deleteCategory(Request $request)
    {
        $category = new AppHandler( new CategoryHandler() );
        $deleted = $category->delete($request->id);

        if( $deleted !== false )
        {
            return redirect()
                        ->back()
                        ->with('success', 'Categoría borrada correctamente');
        }
        else 
        {
            return redirect()
                    ->back()
                    ->withErrors(['msg' => 'Ha habido un problema a la hora de borrar la categoría, por favor inténtelo de nuevo'])
                    ->withInput();
        }
    }


    /**
     * AUTORES
     */

     public function createAuthor(Request $request)
     {
        $validator = $this->validateData(
            $request, 
            [
                'name'          => 'required|unique:categories,name|max:100',
                'birth_date'    => 'required|date|before_or_equal:now',
                'death_date'    => 'required|date|after_or_equal:birth_date',
            ], 
            [
                'name.required'                 => 'El campo "Nombre de la categoría" es requerido',
                'birth_date.required'           => 'El campo "Fecha de nacimiento" es requerido',
                'death_date.required'           => 'El campo "Fecha de fallecimiento" es requerido',
                'death_date.after_or_equal'     => 'La fecha de fallecimiento tiene que ser posterior a la de nacimiento.',
                'birth_date.before_or_equal'     => 'La fecha de nacimiento tiene que ser anterior al día de hoy',
            ]
        );
        
        if( $validator->isValidated )
        {
            // Crea el autor
            $author = new AppHandler( new AuthorHandler() );
            $authorData = [
                'name'          => $request->name,
                'pseudonym'     => $request->pseudonym,
                'birth_date'    => $request->birth_date,
                'death_date'    => $request->death_date
            ];
            if( $author->create($authorData) !== false )
            {
                // redirige a la vista principal del dashboard
                return redirect("/")
                            ->with('success', 'Autor creado correctamente');
            }
            else 
            {
                // redirige a la vista de cración de autor con error
                return redirect()
                            ->back()
                            ->withErrors(['msg' => 'Ha habido un problema con los datos introducidos, por favor inténtelo de nuevo'])
                            ->withInput();
            }
        }
        else 
        {
            // Los datos recibidos no son correctos
            return $validator->validationResponse;
        }
     }

    public function showAuthors(Request $request)
    {
        $author = new AppHandler( new AuthorHandler() );

        return view('author.get-authors', [
            'authors' => $author->showAll()
        ]);
    }

    public function updateAuthorView(Request $request)
    {
        // Muestra la vista de actualizar autor.
        $author = new AppHandler( new AuthorHandler() );
        $author = $author->show($request->id);

        if( $author !== false )
        {
            return view('author.edit-author', [ 'author' => $author ]);
        }
        else 
        {
            return redirect()
                    ->back()
                    ->withErrors(['msg' => 'Ha habido un problema a la hora de acceder al autor a editar, por favor inténtelo de nuevo'])
                    ->withInput();
        }
    }

    public function processUpdateAuthor(Request $request)
    {
        $validator = $this->validateData(
            $request, 
            [
                'id'   => 'required|exists:authors,id',
                'name' => [
                    'required',
                    'max:100',
                    // Esta regla es para ignorar en la propia validación como único nombre la propia categoría editada.
                    Rule::unique('authors')->ignore($request->id),
                ],
                'birth_date'    => 'required|date|before_or_equal:now',
                'death_date'    => 'required|date|after_or_equal:birth_date',
            ], 
            [
                'id.exists'                    => 'El ID de categoría recibido no existe', 
                'unique'                       => 'El campo nombre de la categoría debe de ser único',
                'name.required'                => 'El campo "Nombre de la categoría" es requerido',
                'id.required'                  => 'El id de la categoría es requerido',
                'death_date.after_or_equal'    => 'La fecha de fallecimiento tiene que ser posterior a la de nacimiento.',
                'birth_date.before_or_equal'   => 'La fecha de nacimiento tiene que ser anterior al día de hoy',
            ]
        );
        
        if( $validator->isValidated )
        {
            // Actualiza el autor
            $author = new AppHandler( new AuthorHandler() );
            $authorData = [
                'id'            => $request->id,
                'name'          => $request->name,
                'pseudonym'     => $request->pseudonym,
                'birth_date'    => $request->birth_date,
                'death_date'    => $request->death_date
            ];
            if( $author->update($authorData) !== false )
            {
                // La actualización ha ido correctamente.
                return redirect()
                        ->back()
                        ->with('success', 'Autor actualizado correctamente');
            }
            else 
            {
                // redirige a la vista de edición de autor con error
                return redirect()
                        ->back()
                        ->withErrors(['msg' => 'Ha habido un problema con los datos introducidos, por favor inténtelo de nuevo'])
                        ->withInput();
            }
        }
        else 
        {
            // Los datos recibidos no son correctos
            return $validator->validationResponse;
        }
    }

    public function deleteAuthor(Request $request)
    {
        $author = new AppHandler( new AuthorHandler() );
        $deleted = $author->delete($request->id);

        if( $deleted !== false )
        {
            return redirect()
                        ->back()
                        ->with('success', 'Autor borrado correctamente');
        }
        else 
        {
            return redirect()
                    ->back()
                    ->withErrors(['msg' => 'Ha habido un problema a la hora de borrar el autor, por favor inténtelo de nuevo'])
                    ->withInput();
        }
    }


    /**
     * LIBROS
     */

    public function createBookView(Request $request)
    {
        $author = new AppHandler(new AuthorHandler());
        $category = new AppHandler(new CategoryHandler());
        return view('book.create-book', [ 
            'authors'       => $author->showAll(),
            'categories'    => $category->showAll(),
        ]);
    }

    public function createBook(Request $request)
    {
       $validator = $this->validateData(
           $request, 
           [
               'title'          => 'required|unique:books,title|max:100',
               'ISBN'           => 'required|unique:books,ISBN',
               'description'    => 'required',
               'author_id'      => 'required|exists:authors,id',
               'category_id'    => 'required|array',
               'category_id.*'  => 'exists:categories,id',
           ], 
           [
               'title.required'             => 'El campo "Título del libro" es requerido',
               'ISBN.required'              => 'El campo "ISBN" es requerido',
               'description.required'       => 'El campo "Descripción" es requerido',
               'author_id.required'         => 'El campo "Autor" es requerido',
               'category_id.required'       => 'El campo "Categoría" es requerido',
           ]
       );
       
       if( $validator->isValidated )
       {
           // Crea el libro
           $book = new AppHandler( new BookHandler() );
           $bookData = [
               'title'          => $request->title,
               'ISBN'           => $request->ISBN,
               'description'    => $request->description,
               'author_id'      => $request->author_id,
               'category_id'    => $request->category_id
           ];
           if( $book->create($bookData) !== false )
           {
               // redirige a la vista principal del dashboard
               return redirect("/")
                           ->with('success', 'Libro creado correctamente');
           }
           else 
           {
               // redirige a la vista de cración de libro con error
               return redirect()
                           ->back()
                           ->withErrors(['msg' => 'Ha habido un problema con los datos introducidos, por favor inténtelo de nuevo'])
                           ->withInput();
           }
       }
       else 
       {
           // Los datos recibidos no son correctos
           return $validator->validationResponse;
       }
    }

    public function showBooks(Request $request)
    {
        $book = new AppHandler( new BookHandler() );

        $books = $book->showAll();
        return view('book.get-books', [
            'books' => $book->showAll()
        ]);
    }

    public function updateBookView(Request $request)
    {
        // Muestra la vista de actualizar un libro.
        $book = new AppHandler( new BookHandler() );
        $book = $book->show($request->id);

        $author = new AppHandler(new AuthorHandler());
        $category = new AppHandler(new CategoryHandler());

        if( $book !== false )
        {
            return view(
                'book.edit-book', 
                [ 
                    'book'       => $book,
                    'authors'    => $author->showAll(),
                    'categories' => $category->showAll()
                ]
            );
        }
        else 
        {
            return redirect()
                    ->back()
                    ->withErrors(['msg' => 'Ha habido un problema a la hora de acceder al libro a editar, por favor inténtelo de nuevo'])
                    ->withInput();
        }
    }

    public function processUpdateBook(Request $request)
    {
        $validator = $this->validateData(
            $request, 
            [
                'id'   => 'required|exists:books,id',
                'title' => [
                    'required',
                    'max:100',
                    // Esta regla es para ignorar en la propia validación como único titulo del libro editado.
                    Rule::unique('books')->ignore($request->id),
                ],
                'ISBN' => [
                    'required',
                    'max:100',
                    // Esta regla es para ignorar en la propia validación como único ISBN del libro editado.
                    Rule::unique('books')->ignore($request->id),
                ],
                'description'    => 'required',
                'author_id'      => 'required|exists:authors,id',
                'category_id'    => 'required|array',
                'category_id.*'  => 'exists:categories,id',
            ], 
            [
                'id.exists'                  => 'El ID de libro recibido no existe', 
                'title.required'             => 'El campo "Título del libro" es requerido',
                'ISBN.required'              => 'El campo "ISBN" es requerido',
                'description.required'       => 'El campo "Descripción" es requerido',
                'author_id.required'         => 'El campo "Autor" es requerido',
                'category_id.required'       => 'El campo "Categoría" es requerido',
            ]
        );
        
        if( $validator->isValidated )
        {
            // Actualiza el libro
            $book = new AppHandler( new BookHandler() );
            $bookData = [
                'id'             => $request->id,
                'title'          => $request->title,
                'ISBN'           => $request->ISBN,
                'description'    => $request->description,
                'author_id'      => $request->author_id,
                'category_id'    => $request->category_id
            ];
            if( $book->update($bookData) !== false )
            {
                // La actualización ha ido correctamente.
                return redirect()
                        ->back()
                        ->with('success', 'Libro actualizado correctamente');
            }
            else 
            {
                // redirige a la vista de edición de libro con error
                return redirect()
                        ->back()
                        ->withErrors(['msg' => 'Ha habido un problema con los datos introducidos, por favor inténtelo de nuevo'])
                        ->withInput();
            }
        }
        else 
        {
            // Los datos recibidos no son correctos
            return $validator->validationResponse;
        }
    }

    public function deleteBook(Request $request)
    {
        $book = new AppHandler( new BookHandler() );
        $deleted = $book->delete($request->id);

        if( $deleted !== false )
        {
            return redirect()
                        ->back()
                        ->with('success', 'Libro borrado correctamente');
        }
        else 
        {
            return redirect()
                    ->back()
                    ->withErrors(['msg' => 'Ha habido un problema a la hora de borrar el libro, por favor inténtelo de nuevo'])
                    ->withInput();
        }
    }


    /**
     * Método para validar los datos que llegan a cada método del controlador, de esta forma se consigue cierta "abstracción"
     * del validador de Laravel.
     * 
     * 
     * @param string $request          (Request)    La petición recibida en el controlador
     * @param string $validateRules    (Array)      Array de strings con reglas para validar campos de $request
     * @param string $validatemessages (Array)      Array de strings con los mensajes de validación de los campos de $request
     * 
     * @return \Validator
     */
    private function validateData(Request $request, Array $validateRules = [], Array $validateMessages)
    {
        $validator = Validator::make($request->all(), $validateRules, $validateMessages);

        $response = new \StdClass();
        if ($validator->fails()) 
        {
            // Vuelve a la url de la que procede esta petición.
            $response->isValidated = false;
            $response->validationResponse = redirect()
                                                ->back()
                                                ->withErrors($validator)
                                                ->withInput();
        }
        else 
        {
            $response->isValidated = true;
            $response->validationResponse = $validator;
        }

        return $response;
    }
}
