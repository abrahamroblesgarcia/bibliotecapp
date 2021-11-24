<?php 
namespace App\Http\Controllers\App;

use App\Http\Controllers\App\AppControllerInterface;

/**
 * Clase encargada de manejar todos los datos de la aplicación.
 * Utiliza intección de dependencias para manejar los datos de cada modelo de 
 * forma centralizada.
 */
class AppHandler 
{
    private $appController;

    public function __construct(AppControllerInterface $appController)
    {
        $this->appController = $appController;
    }

    public function show(int $id)
    {
        return $this->appController->show($id);
    }

    public function showAll()
    {
        return $this->appController->showAll();
    }

    public function create(Array $fields)
    {
        return $this->appController->create($fields);
    }

    public function update(Array $fields)
    {
        return $this->appController->update($fields);
    }

    public function delete(int $id)
    {
        return $this->appController->delete($id);
    }
}