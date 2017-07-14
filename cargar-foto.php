<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Agregar usuario</title>
        <?php
        include("scripts.php");
        ?>
    </head>

    <body>

        <?php 
        include('templates/header.php');
?>



        <br><br><br>
        <div class="container-fluid">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="headingOne">
                            <h4 class="panel-title">
                                <a id="opcion-tomar-foto" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    Tomar foto
                                </a>
                            </h4>
                        </div>

                        <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                            <div class="panel-body">
                                
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="nombre">Ingrese su nombre completo:</label>
                                            <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre completo">
                                        </div>
                                    </div>
                                </div>

                                <br>

                                <div class="row">
                                    <div class="col-md-12 text-center">
                                        <button class="btn btn-primary btn-block" id="take">
                                            Tomar foto
                                        </button>
                                    </div>
                                </div>

                                <br>

                                <div class="row">
                                    <div class="col-md-6">
                                        <video style="width:100%;" class="embed-responsive-item" id="v"></video>
                                    </div>

                                    <div class="col-md-6">
                                        <img style="width:100%;"  id="photo" alt="photo">    
                                    </div>
                                </div>

                                <br>
                                <br>
                                <div class="row">
                                    <div class="col-md-12 text-center">
                                        <button data-style="zoom-in" id="btn-guardar" class="btn btn-success btn-block ladda-button">
                                            <span class="ladda-label">    
                                                Guardar foto
                                            </span>    
                                        </button>
                                    </div>
                                </div>
                            
                                <canvas id="canvas" style="display:none;"></canvas>
                            </div>
                        </div>
                    </div>

                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="headingTwo">
                            <h4 class="panel-title">
                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                Subir foto
                                </a>
                            </h4>
                        </div>
                        <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                            <div class="panel-body">
                                Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>

    
                    <script>
                    var timesButton = 0;
                    $(document).ready(function(){
                        $("#btn-guardar").on("click", function(){
                            var canvas = document.getElementById('canvas');
                            var dataURL = canvas.toDataURL();
                            var nombre = $("#nombre").val();

                            if( $('#nombre').val().length === 0 ) {
                                swal("Espera", "Debes ingresar tu nombre", "warning");
                                return false;
                            }

                            if(timesButton<1){
                                swal("Espera", "Debes tomarte una foto", "warning");
                                return false;
                            }

                            
                            var l = Ladda.create(this);
	 	                    l.start();
                            
                            $.ajax({
                                type: "POST",
                                url: "vendor/guardar-imagen.php",
                                data: { 
                                    imgBase64: dataURL,
                                    nombre: nombre
                                },
                                
                                }).done(function(o) {
                                timesButton = 0;
                                $("#nombre").val('');
                                $("#photo").attr('src', '');
                                swal("Ok", "Imagen guardada", "success");
                                $("#opcion-tomar-foto").trigger('click');
                                l.stop();
                                console.log('saved'); 
                                // If you want the file to be visible in the browser 
                                // - please modify the callback in javascript. All you
                                // need is to return the url to the file, you just saved 
                                // and than put the image in your browser.
                                });
                        });
                    });


                        ;(function(){
                            function userMedia(){
                                return navigator.getUserMedia = navigator.getUserMedia ||
                                navigator.webkitGetUserMedia ||
                                navigator.mozGetUserMedia ||
                                navigator.msGetUserMedia || null;

                            }


                            // Now we can use it
                            if( userMedia() ){
                                var videoPlaying = false;
                                var constraints = {
                                    video: true,
                                    audio:false
                                };
                                var video = document.getElementById('v');

                                var media = navigator.getUserMedia(constraints, function(stream){

                                    // URL Object is different in WebKit
                                    var url = window.URL || window.webkitURL;

                                    // create the url and set the source of the video element
                                    video.src = url ? url.createObjectURL(stream) : stream;

                                    // Start the video
                                    video.play();
                                    videoPlaying  = true;
                                }, function(error){
                                    console.log("ERROR");
                                    console.log(error);
                                });


                                // Listen for user click on the "take a photo" button
                                document.getElementById('take').addEventListener('click', function(){

                                    if( $('#nombre').val().length === 0 ) {
                                         swal("Espera", "Debes ingresar tu nombre", "warning");
                                        return false;
                                    }

                                    if (videoPlaying){
                                        var canvas = document.getElementById('canvas');
                                        canvas.width = video.videoWidth;
                                        canvas.height = video.videoHeight;
                                        canvas.getContext('2d').drawImage(video, 0, 0);
                                        var data = canvas.toDataURL('image/webp');
                                        document.getElementById('photo').setAttribute('src', data);
                                        timesButton++;
                                    }
                                }, false);



                            } else {
                                console.log("KO");
                            }
                        })();
                    </script>

    </body>

</html>