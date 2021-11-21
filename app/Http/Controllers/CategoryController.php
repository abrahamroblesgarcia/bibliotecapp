<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function create(Request $request)
    {
        $validator = $this->validateData(
            $request, 
            ['name' => 'required|max:100'], 
            ['name.required' => 'El campo "Nombre de la categoría" es requerido'], 
            '/create-category'
        );
        
        if( $validator->isValidated )
        {
            var_dump("datos correctos");
            exit();
        }
        else 
        {
            return $validator->validationResponse;
        }
    }


    /**
     * Método para validar los datos que llegan a cada método del controlador
     * 
     * 
     * @param string $request          (Request)    La petición recibida en el controlador
     * @param string $validateRules    (Array)      Array de strings con reglas para validar campos de $request
     * @param string $validatemessages (Array)      Array de strings con los mensajes de validación de los campos de $request
     * @param string $validateErrorURI (String)     URI a la que hacer una redirección en caso de no cumplirse las $validateRules
     * 
     * @return \Validator
     */
    private function validateData(Request $request, Array $validateRules = [], Array $validateMessages, String $validateErrorURI = '/')
    {
        $validator = Validator::make($request->all(), $validateRules, $validateMessages);

        $response = new \StdClass();
        if ($validator->fails()) 
        {
            $response->isValidated = false;
            $response->validationResponse = redirect($validateErrorURI)
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
