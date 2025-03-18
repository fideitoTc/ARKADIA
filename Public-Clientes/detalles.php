
<?php 
require 'config/config.php';
require 'config/database.php';


$db = new database();
$con = $db->conectar();


$id = isset($_GET['id']) ? $_GET['id'] : '';
$token = isset($_GET['token']) ? $_GET['token'] : '';

if ($id == '' || $token == ''){
    echo 'error al procesar la peticion';
    exit;
} else {
    $token_tmp = hash_hmac('sha1', $id, KEY_TOKEN);

    if ($token == $token_tmp) {

        $sql = $con->prepare("SELECT count(idproducto) FROM productosp WHERE idproducto=? AND activo=1");
        $sql->execute([$id]);
        if($sql->fetchColumn() > 0) {
        
            $sql = $con->prepare("SELECT idproducto, nombreproducto, descripcionproducto, precioproducto, descuentoproducto, stockproducto, texproducto, fechacreacionproducto, idcategoria FROM productosp WHERE idproducto=? AND activo=1 LIMIT 1");
            $sql->execute([$id]);
            $resultado = $sql->fetch(PDO::FETCH_ASSOC);
            $idproducto = $resultado['idproducto'];
            $precio = $resultado['precioproducto'];
            $nombre = $resultado['nombreproducto'];
            $descripcion = $resultado['descripcionproducto'];
            $stock = $resultado['stockproducto'];
            $tex = $resultado['texproducto'];
            $descuento = $resultado['descuentoproducto'];
            $precio_descuento = $precio - (($precio * $descuento) / 100);
            $dir_images = 'imagenes/productos/' . $idproducto . '/';

            $rutaimg = $dir_images . 'principal.jpg';

            if(!file_exists($rutaimg)){
                $rutaimg = 'imagenes/no-foto.png';
            }

            $imagenes = array();
            if (file_exists($dir_images)) 
            {
              
            
            $dir = dir($dir_images);

            while (($archivo = $dir->read()) != false ){
                if($archivo != 'principal.jpg' && (strpos($archivo, 'jpg') || strpos($archivo, 'jpeg'))) {
                    $imagenes[] = $dir_images . $archivo;
                }
            }
            $dir->close();
        }
      }


    }else {
        echo 'error al procesar la peticion :(';
        exit;
    }

}








?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ARKADIA</title>
    <link rel="stylesheet" href="stilos.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.js"></script>
</head>
<body>
    

<nav class="navbar navbar bg fixed-top">
  <div class="container-fluid d-flex justify-content-between align-items-center">
    <div class="d-flex align-items-center">

      <a href=""><i class="bi bi-search me-3" style="color: black; font-size: 24px;" class="bi bi-search"></i></a>
     <a href="checkout.php"><i class="bi bi-cart-fill me-3" style="color: black; font-size: 24px;" class="bi bi-cart-fill"><span id="num_card" class="badge bg-secondary" ><?php echo $num_cart; ?> </span> </i></a>
    </div>
    <a class="navbar-brand text-center w-99" href="#"><H2 class="font-weight-bold" >ARKADIA</H2></a> 
    <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="offcanvas offcanvas-end text-bg" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
      <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Dark offcanvas</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>
      <div class="offcanvas-body">
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

<div class="container" >
    <div class="row" >
        <div class="col-md-6 order-md-1" >

        <div id="carouselImages" class="carousel slide" data-ride="carousel">
  <div class="carousel-inner"> 
    <div class="carousel-item active">
    <img src=" <?php echo $rutaimg; ?> " alt="" class="b-block w-100" >
    </div>

    <?php foreach ($imagenes as $img) { ?>
        <div class="carousel-item">
            <img src="<?php echo $img; ?> " alt="" class="b-block w-100" >
        </div>
      <?php } ?>


   </div>


        <button class="carousel-control-prev" type="button" data-bs-target="#carouselImages" data-bs-slide="prev" >
            <span class="carousel-control-prev-icon" aria-hidden="true" ></span>
            <span class="visually-hidden" >Anterior</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselImages" data-bs-slide="next" >
            <span class="carousel-control-next-icon" aria-hidden="true" ></span>
            <span class="visually-hidden" >Siguiente</span>
        </button>
</div>



        </div>
        <div class="col-md-6 order-md-2" >
            <h2><?php echo $nombre ?> </h2>
            <p class="lead" >
                <?php echo $descripcion; ?>
            </p>


            <?php if($descuento > 0) { ?>
                <p><del> <?php echo MONEDA . number_format($precio, 2, '.', ','); ?> </del></p>
                <h2><?php echo MONEDA . number_format($precio_descuento, 2, '.', ',')?>
            <small class="text-success"><?php echo $descuento; ?>% descuento</small>
            </h2>

<?php } else { ?>

    <h2><?php echo MONEDA . number_format($precio, 2, '.', ',')?></h2>
<?php } ?>




            <div class="d-grid gap-3 col-10 max-auto" >
                <button class="btn btn-primary" type="button" >Comprar ahora</button>
                <button class="btn btn-outline-primary" type="button" onclick="addProducto(<?php echo $idproducto; ?>, '<?php echo $token_tmp ?>')" >Agregar al carrito</button>

            </div>

            </div>
    </div>
</div>

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