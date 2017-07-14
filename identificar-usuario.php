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

        <div class="container">
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <br>
                    <br>
                    <br>

                   <div class="row"> 
                        <div class="col-md-12 text-center">
                            <button class="btn btn-primary" id="take">
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
                    <div class="row">
                        <div class="col-md-12">
                            <div class="input-group">
                                <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre completo">
                            </div>
                        </div>
                    </div>
                    <br>
                    <br>
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <button id="btn-guardar" class="btn btn-success">
                                Identificar usuario
                            </button>
                        </div>
                    </div>
                    <canvas id="canvas" style="display:none;"></canvas>
                   
                    <script>

                    $(document).ready(function(){
                        $("#btn-guardar").on("click", function(){
                            var canvas = document.getElementById('canvas');
                            var dataURL = canvas.toDataURL();
                            var nombre = $("#nombre").val();
                            $.ajax({
                                type: "POST",
                                url: "vendor/guardar-imagen.php",
                                data: { 
                                    imgBase64: dataURL,
                                    nombre: nombre
                                },
                                
                                }).done(function(o) {
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
                                    if (videoPlaying){
                                        var canvas = document.getElementById('canvas');
                                        canvas.width = video.videoWidth;
                                        canvas.height = video.videoHeight;
                                        canvas.getContext('2d').drawImage(video, 0, 0);
                                        var data = canvas.toDataURL('image/webp');
                                        document.getElementById('photo').setAttribute('src', data);
                                    }
                                }, false);



                            } else {
                                console.log("KO");
                            }
                        })();
                    </script>

                </div>
            </div>
        </div>

    </body>

</html>