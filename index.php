<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Elegir opción</title>
        <?php
        include ("scripts.php");
        ?>
    </head>

    <body>

        <?php 
        include("templates/header.php");    
        ?>
<br><br><br>
        <div class="container-fluid">
            <div class="col-md-4 col-md-offset-2">
                <a href="cargar-foto.php" class="btn btn-primary btn-block">
                    <h3>
                        <span class="glyphicon glyphicon-open" aria-hidden="true"></span> 
                        Cargar imagen
                    </h3>
                </a>
            </div>
            <div class="col-md-4">
                <a href="identificar-usuario.php" class="btn btn-primary btn-block">
                    <h3>
                        <span class="glyphicon glyphicon-user" aria-hidden="true"></span> 
                        Identificar usuario
                    </h3>
                </a>
            </div>
        </div>
    </body>

</html>