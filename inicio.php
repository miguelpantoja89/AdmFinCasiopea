
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css"  href="style.css">
    
    <title>Comunidades</title>
</head>
<body>
  <!--      <div class="loader">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
        <script type="text/javascript">
            $(window).load(function(){
                $(".loader").delay(1000).fadeOut(1000);
            });
            </script> -->
            </div>
    <?php include('cabecera.php') ?>
    <?php include('navegacion.php') ?>
  
    <main>
    
       <section>
        <article class="inp">
            <div class="contenedor">
                <style type="text/css">
                #pen{
                    width: 20px;
                    height: 20px;
                    float:right;
                }
                #trash{
                    width: 20px;
                    height: 20px;
                    float:right;
                }
                .caja { 
   font-family: sans-serif; 
   font-size: 18px; 
   font-weight: 400; 
   color: #ffffff; 
   background:#d7cec7;}
                            
                </style>
                    <ul >
                        
                        <li class="caja"><a href="infoComunidades.php">Finca San Isidro .... C/ Reina Mercedes, 23</a> <a href="elimina.php"><img id="trash" src="img/trash.png" alt=""></a><a href="modifica.php"><img id="pen" src="img/pencil.png" alt=""></a></li>
                        <li class="caja"><a href="">Comunidad 1</a></li>
                        <li>Comunidad 1</li>
                        <li>Comunidad 1</li>
                        <li>Comunidad 1</li>
                        <li>Comunidad 1</li>
                        <li>Comunidad 1</li>
                        <li>Comunidad 1</li>
                        <li>Comunidad 1</li>
                    </ul>
                </div>
               <?php include('botonAlta.php') ?>
         </article>
        </section>
    

    </main>
    <?php include('foot.php') ?>
    
</body>
</html>
