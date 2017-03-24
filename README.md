Formulario y estadísticas para Plataforma ReActive
========

Aplicación desarrollada para reducir el uso de Excel en las empresas, mediante formularios. Además cuenta con un módulo 
de creación dinámica de formularios y vista de resultados.

Fue desarrollada en Symfony 2.8.

Fase proceso de postulación ReActive.

Prerequisitos
========

Se debe tener instalado:
- GIT
- Composer
- PHP 5.6 o >
- Mysql

Instalar aplicación
========
1. Clonar el proyecto con el comando:<br>

        $ git clone https://github.com/VictorFuentesCereceda/reactive.git

2. Entrar a la carpeta creada: <br>
    
        $ cd reactive

3. Instalar librerías con el comando
  
        $ composer update 
    
   Este comando empezará a instalar las librerías, podría demorar un par de minutos. 
   Al terminar solicitará valores para los parámetros de configuración:
   
        database_host: nombre_host
        database_port: puerto_BD
        database_name: nombre_BD
        database_user: usuario_BD
        database_password: paswword_usuario_BD
    
    Todos los demás los dejamos por defecto presionando la tecla 'Enter' por cada parámetro.
    
4. Al terminar  saldrá el mensaje:
        
        [OK] All assets were successfully installed. 
        
5. Configurar la Base de datos:
  
        php app/console doctrine:database:create
        php app/console doctrine:schema:update --force
        
        Estos comandos crearán la Base de datos y crearán las tablas y sus relaciones.
        
        Puede que tengamos problemas de permisos al correr estos comandos, si eso sucede se debe dar permisos a las sigueintes carpetas:
        
        - app/logs
        - app/cache
        
        En Linux o MacOs
        
        $ sudo chmod 777 app/logs
        $ sudo chmod 777 app/cache
        
6. Cargar datos básicos:

        php app/console doctrine:f:l
        
        El sistema tiene datos básicos para realizar pruebas, esos serán cargador con ese comando.
         
7. Configurar servidor web (Se recomienda configurar un VirtualHost) 

        #ReActive
        <VirtualHost *:80>
            DocumentRoot   "/ruta_proyectos/reactive/web"
            DirectoryIndex app.php
            

            <Directory "/ruta_proyectos/reactive/web">
                AllowOverride All
                Allow from All
            </Directory>
        </VirtualHost>
        
        Recuerda reemplazar "ruta_proyectos" por la ruta de tus rproyectos. Una vez guardado recuerda reiniciar el servidor web.
        

Usuarios de acceso
====

          
          nombre: Juan
          usuario: admin@reactive.cl
          password: administrador
          Puede crear formularios y ver resultados.
          
          nombre: Cristian
          usuario: usuario@reactive.cl
          password: usuario
          Puede contestar formularios. 

Autor
====
Víctor Fuentes