<?php 
namespace App\Utils;

/**
 * Esta clase utiliza métodos que pueden ser útiles en otras partes de la aplicación 
 * que no requieran de un contexto o unos requisitos funcionales específicos.
 */
class Util 
{
    /**
     * Método que comprueba si las keys pasadas se encuentran dentro del array recibido.
     * 
     * @param $array    Es el array que se va a comprobar
     * @param $keys     Es un array de keys a comprobar si existen en $array.
     * 
     * @return boolean
     */
    public static function checkIfKeysExistsInArray(Array $array, Array $keys)
    {
        foreach( $keys as $key )
        {
            if( !array_key_exists($key, $array) )
            {
                return false;
            }
        }

        return true;
    }


}