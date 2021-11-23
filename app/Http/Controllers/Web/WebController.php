<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Http\Controllers\App\AppHandler;
use App\Http\Controllers\App\CategoryHandler;
use App\Http\Controllers\App\AuthorHandler;

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
                return redirect("dashboard")
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
     * LIBROS
     */

     /**
      * TODO: seguir con las validaciones de las fechas y crear AuthorHandler.php
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
                return redirect("dashboard")
                            ->with('success', 'Autor creado correctamente');
            }
            else 
            {
                // redirige a la vista de cración de categoría con error
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
        // Muestra la vista de actualizar categoría.
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
            // Actualiza la categoría
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
     * AUTORES
     */


    /**
     * Método para validar los datos que llegan a cada método del controlador
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
