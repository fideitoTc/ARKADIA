
<?php 
require 'config/config.php';
require 'config/database.php';


$db = new database();
$con = $db->conectar();


$sql = $con->prepare("SELECT idproducto,	nombreproducto,	descripcionproducto,	precioproducto,	stockproducto,	texproducto,	fechacreacionproducto, idcategoria FROM productosp WHERE activo=1");
$sql->execute();
$resultado = $sql->fetchAll(PDO::FETCH_ASSOC);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ARKADIA</title>
    <link rel="stylesheet" href="css/stilos.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.js"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
        }
        .banner {
            position: relative;
            width: 100%;
            height: 50vh;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: white;
        }
        .carousel {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }
        .carousel img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            position: absolute;
            top: 0;
            left: 0;
            opacity: 0;
            transition: opacity 1s ease-in-out;
        }
        .carousel img:first-child {
            opacity: 1;
        }
        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
        }
        .content {
            position: relative;
            z-index: 2;
        }
        .content h1 {
            font-size: 2.5rem;
        }
        .content p {
            font-size: 1.2rem;
            margin: 10px 0;
        }
        .btn1 {
            display: inline-block;
            padding: 10px 20px;
            background: #7e5539;
            color: white;
            text-decoration: none;
            font-size: 1rem;
            border-radius: 5px;
            transition: 0.3s;
        }
        .btn1:hover {
            background: #7e5539;
        }
        @media (max-width: 768px) {
            .content h1 {
                font-size: 2rem;
            }
            .content p {
                font-size: 1rem;
            }
        }

    </style>
</head>
<body  style="background-color: #f1f0eb;" >
    

<nav class="navbar navbar bg fixed-top" style="background-color:  #9d7356;">
  <div class="container-fluid d-flex justify-content-between align-items-center" style="background-color: #f1f0eb;">
    <div class="d-flex align-items-center" >

      <a href=""><i class="bi bi-search me-3" style="color: #E6B17E; font-size: 24px;" class="bi bi-search"></i></a>
      <a href="checkout.php"><i class="bi bi-cart-fill me-3" style="color: #E6B17E; font-size: 24px;" class="bi bi-cart-fill"><span id="num_card" class="badge bg-secondary" ><?php echo $num_cart; ?> </span> </i></a>
      </div>
    <a class="navbar-brand text-center w-99" href="#"><H2 class="font-weight-bold" >    <img src="Imagenes/logo-letras.png" alt="" height="40px" width="170px" ></H2></a> 
    <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation" style="background-color: #E6B17E;">
      <span class="navbar-toggler-icon" ></span>
    </button>
    <div class="offcanvas offcanvas-end text-bg" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
      <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Dark offcanvas</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>
      <div class="offcanvas-body"  style="background-color: #E6B17E;"  >
        <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="#">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Link</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Dropdown
            </a>
            <ul class="dropdown-menu dropdown-menu">
              <li><a class="dropdown-item" href="#">Action</a></li>
              <li><a class="dropdown-item" href="#">Another action</a></li>
              <li>
                <hr class="dropdown-divider">
              </li>
              <li><a class="dropdown-item" href="#">Something else here</a></li>
            </ul>
          </li>
        </ul>
        <form class="d-flex mt-3" role="search">
          <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
          <button class="btn btn-success" type="submit">Search</button>
        </form>
      </div>
    </div>
  </div>
</nav>
<br>
<br>
<br>




<div class="banner">
        <div class="carousel">
            <img src="Imagenes/banner-1.png">
            <img src="Imagenes/banner-2.png">
        </div>
        <div class="overlay"></div>
        <div class="content">
            <h1>Bienvenido a Nuestro Sitio</h1>
            <p>Descubre lo mejor para ti</p>
            <a href="#" class="btn1">Explorar</a>
        </div>
    </div>
    <script>
        let images = document.querySelectorAll(".carousel img");
        let index = 0;
        
        function changeImage() {
            images[index].style.opacity = "0";
            index = (index + 1) % images.length;
            images[index].style.opacity = "1";
        }
        
        setInterval(changeImage, 4000);
    </script>


<ul class="nav nav-underline justify-content-center font-weight-bold"  >
  <li class="nav-item">
    <a class="nav-link text-dark" aria-current="page" href="#">Novedades</a>
  </li>
  <li class="nav-item">
    <a class="nav-link text-dark" href="#">Accesorios</a>
  </li>
  <li class="nav-item">
    <a class="nav-link text-dark" href="#">Link</a>
  </li>
  <li class="nav-item">
    <a class="nav-link text-dark" href="#">Disabled</a>
  </li>
</ul>





<div class="album py-5"  style="background-color: #f1f0eb;"  >
    <div class="container"  style="background-color: #f1f0eb;"  >

      <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-3"   style="background-color:#f1f0eb;"  >
      <?php foreach ($resultado as $row) { ?>
      <div class="col">
          <div class="card shadow-sm"  style="background-color: #9d7356;" >

          <?php 
          $idproducto = $row['idproducto'];
          $imagen = "imagenes/productos/" . $idproducto . "/principal.jpg";
          
          if(!file_exists($imagen)){
            $imagen = "imagenes/no-foto.png";
          }
          ?>

            <img src="<?php echo $imagen; ?>">
            <div class="card-body">
              <p class="card-title"><?php echo $row['nombreproducto']; ?></p>
              <p class="card-text" ><?php echo number_format($row['precioproducto'], 2, '.', ','); ?></p>
              <small class="text-body-secondary">9 mins</small>
              <div class="d-flex justify-content-between align-items-center">

                <div class="btn-group">
                  <a href="detalles.php?id=<?php echo $row['idproducto']; ?>&token=<?php echo hash_hmac('sha1', $row['idproducto'], KEY_TOKEN);?>" class="btn btn-secondary" >Detalles <span> <i class="bi bi-card-list"></i> </span>  </a>
                </div>
                <button class="btn btn-secondary"  type="button" onclick="addProducto(<?php echo $row['idproducto']; ?>, '<?php echo hash_hmac('sha1', $row['idproducto'], KEY_TOKEN); ?>')">Agregar al carrito  <span><i class="bi bi-cart-plus"></i> </span>  </button>

              </div>

            </div>
          </div>
        </div> <?php } ?>
      </div>                                                                                                                      
    </div>
  </div>

  <script>
    window._2chatConfig = {
    phoneNumber: '+573025254344',
    accountName: `¡Te damos la bienvenida!`,
    statusMessage: `Solemos responder en menos de una hora`,
    chatMessage: `¡Hola! 👋
Mi nombre es thiago,
¿En que te puedo ayudar?`,
    placeholder: 'Escribe tu mensaje aquí...',
    position: 'left',
    colorScheme: 'automatic',
    showNotification: false,
  };

  (function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = 'https://widgets.2chat.io/index.js';
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', '_2chat'));
</script>






  <script>
  function addProducto(id, token) {
    let url = 'clases/carrito.php'
    let formData = new FormData()
    formData.append('id', id)
    formData.append('token', token)

    fetch(url, {
      method: 'POST',
      body:formData,
      mode: 'cors'
    }).then(response => response.json())
    .then(data => {
      if (data.ok) {
        let elemento = document.getElementById("num_card")
        elemento.innerHTML = data.numero
      }
    })
  }













</script>


</body>
</html>