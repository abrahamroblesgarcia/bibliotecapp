# Bibliotecapp
Aplicación creada para la prueba técnica con Doofinder.
Se trata de una sencilla aplicación de gestión de una biblioteca creada con Laravel.

# Requisitos

 - composer
 - php >=7.4
 - docker-compose

## Instalación
Una vez descargado el repositorio, instalar todas las dependencias con:

    composer install
   Una vez descargadas las dependencias de Laravel (debes de tener el directorio /vendor en la raiz), se lanza docker con sail (sail es una herramienta que vienen integrada con laravel para ejecutar cualquier comando desde el contenedor de docker)
   

    ./vendor/bin/sail up
La primera vez descargará todas las imágenes necesarias para desplegar un entorno que sea amigable con laravel

Una vez activado, la primera vez que se ejecute este proyecto, se deberán lanzar las migraciones necesarias para que la base de datos tenga toda la estructura de tablas que necesita. Para esto lanzamos:

    ./vendor/bin/sail artisan migrate
Terminado este punto, ya se puede acceder a la aplicacioń a través de un navegador por la siguiente url:

    localhost

 

## Ficheros interesantes

Dado que Laravel incorpora muchas funcionalidades "out the box",  no todos los ficheros requieren ser evaluados. Los que tienen relevancia son:

 - **app/routes/web.php** 	     Aquí se definen todas las rutas de la aplicación.
 - **app/resources/views/*** 		Aquí se definen todas las vistas HTML de la aplicación
 - **app/Http/Controllers/***		Aquí se definen los controladores que se usan en la aplicación. **WebControoler.php** se encarga de ser el controlador de las urls de la aplicación, mientras que **AppHandler.php** se encarga de gestionar toda la lógica de la aplicación. (he decidido desacoplar esta funcionalidad con una inyección básica de dependencias ya que como la mayor parte de la prueba consiste en definir CRUDs he pensado que este enfoque puede ser maś escalable.
