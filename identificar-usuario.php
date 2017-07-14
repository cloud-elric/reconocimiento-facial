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
                                <a id="opcion-subir-foto" class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                Subir foto
                                </a>
                            </h4>
                        </div>
                        <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                            <div class="panel-body">
                               

                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="file" id="input-subir-imagen"/>
                                    </div>

                                    <div class="col-md-6">
                                        <img style="width:100%;"  id="photo2" alt="photo">    
                                    </div>
                                </div>

                                <br>
                                <br>
                                <div class="row">
                                    <div class="col-md-12 text-center">
                                        <button data-style="zoom-in" id="btn-guardar2" class="btn btn-success btn-block ladda-button">
                                            <span class="ladda-label">    
                                                Guardar foto
                                            </span>    
                                        </button>
                                    </div>
                                </div>
                            
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>

    
        <script>
            function agregarPreviewImage(element, jqelement){
	            var file = element.files[0];

                if (!file) {

                    return false;
                }

                var imagefile = file.type;

                var filename = jqelement.val();

                if (filename.substring(3, 11) == 'fakepath') {
                    filename = filename.substring(12);
                }// remove c:\fake at beginning from localhost chrome
                // var url = base+'usrUsuarios/guardarFotosCompetencia';

                var match = [ "image/jpeg", "image/jpg", 'image/png' ];

                if (!((imagefile == match[0]) || (imagefile == match[1]) || (imagefile == match[2]))) {

                    swal("Espera", "Archivo no aceptado por el sistema", "warning");

                    return false;
                }

                if (element.files && element.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function(e) {
                        var token = jqelement.data('token');
                        $('#photo2').attr('src',e.target.result);
                        
                        //$('#modal-sustain-art-' + token+' .sustain-art-cont-images-dialog-img').css(
                        //        'background-image', 'url(' + e.target.result + ')');
                        

                    }

                    reader.readAsDataURL(element.files[0]);
                }
            }
                    var timesButton = 0;
                    $(document).ready(function(){

                        $("#input-subir-imagen").on("change", function(){
                            agregarPreviewImage(this, $(this));
                        });

                        $("#btn-guardar").on("click", function(){
                            var canvas = document.getElementById('canvas');
                            var dataURL = canvas.toDataURL();


                            if(timesButton<1){
                                swal("Espera", "Debes tomarte una foto", "warning");
                                return false;
                            }

                            
                            var l = Ladda.create(this);
	 	                    l.start();
                            
                            $.ajax({
                                type: "POST",
                                url: "vendor/recuperar-persona.php",
                                data: { 
                                    imgBase64: dataURL,
                                },
                                
                                success:function(resp){
                                    if(resp.txt_token){
                                        swal("Ok", "Hola "+resp.txt_nombre_completo+"<img src='<?=imagenes?>/"+resp.txt_token+".png'>", "success");
                                    }
                                }
                                }).done(function(o) {
                                timesButton = 0;
                                
                                $("#photo").attr('src', '');
                                
                                $("#opcion-tomar-foto").trigger('click');
                                l.stop();
                                console.log('saved'); 
                                // If you want the file to be visible in the browser 
                                // - please modify the callback in javascript. All you
                                // need is to return the url to the file, you just saved 
                                // and than put the image in your browser.
                                });
                        });
                

                     $("#btn-guardar2").on("click", function(){
                            var canvas = $("#photo2");
                            var dataURL = canvas.attr('src');

                            if( document.getElementById("input-subir-imagen").files.length == 0 ){
                                swal("Espera", "Debes subir una foto", "warning");
                                return false;
                            }

                            
                            var l = Ladda.create(this);
	 	                    l.start();
                            
                            $.ajax({
                                type: "POST",
                                url: "vendor/recuperar-persona.php",
                                data: { 
                                    imgBase64: dataURL,
                                    
                                },
                                success:function(resp){
                                    if(resp.txt_token){
                                        swal("Ok", "Hola "+resp.txt_nombre_completo+"<img src='<?=imagenes?>/"+resp.txt_token+".png'>", "success");
                                    }
                                }
                                }).done(function(o) {
                                timesButton = 0;
                                
                                $("#photo2").attr('src', '');
                                
                                $("#opcion-subir-foto").trigger('click');
                                $("#input-subir-imagen").val('');
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