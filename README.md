Sistema de proyectos

<h2>Instalación </h2>

<code>
  composer install
</code>
 <br>

Crear la BD en administrador de base de datos
<br>

Crear archivo de configuración .env y copia el contenido del archivo .env.example y edita las siguientes lineas con la confiracion de tu DBMS y tu BD
<br>
<code>
  DB_CONNECTION=mysql
</code>
<br>
<code>
  DB_HOST=127.0.0.1
</code>
<br>
<code>
  DB_PORT=3306
</code>
<br>
<code>
  DB_DATABASE=proyectos
</code>
<br>
<code>
  DB_USERNAME=root
</code>
<br>
<code>
   DB_PASSWORD=password
</code>
 <br>
 Ahora ejecuta los siguientes comandos
 <br>
 <code>
   php artisan migrate:fresh –-seed 
</code>
#para crear las tablas y guardar los roles en la BD
 <br>

<code>
  php artisan serve
</code>

<h2>Descripción </h2>

Paquetes php usados<br>
•	Spatie - https://github.com/spatie/laravel-permission/tree/v3, asignación de roles y permisos<br>
•	Laravel UI - https://github.com/laravel/ui, autenticación de usuarios<br>
Librería<br>
•	Vue moment - validación de fechas paquete para fechas<br>
Frameworks<br>
•	Laravel v8<br>
•	Vuejs v2.5<br>
El sistema funciona de esta forma<br>
El primer usuario que se registre se va registrar como administrador, después todos los usuarios que se registren van a tener el rol de alumno.<br>

Usuario: alumno<br>
Los alumnos pueden crear proyectos en los que han trabajado<br>
En la vista de crear proyecto le aparecerán asignaturas que se hayan registrado y si no aparece la asignatura tiene la opción de registrar otra nueva.<br>
En el proyecto se le puede agregar habilidades adquiridas, y se mostraran vayan agregando mas opciones en la base datos, de igual manera funciona las tecnologías usadas en el proyecto.<br>
Una vez guardado el proyecto redirigirá al alumno a listado de proyectos en los que ha trabajado.<br>
