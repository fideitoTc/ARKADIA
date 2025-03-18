
<?php 
require 'config/config.php';
require 'config/database.php';


$db = new database();
$con = $db->conectar();

$productos = isset($_SESSION['carrito']['productos']) ? $_SESSION['carrito']['productos'] : null;

$lista_carrito = array();

if($productos != null){
    foreach ($productos as $clave => $cantidad) {


$sql = $con->prepare("SELECT idproducto, nombreproducto, descripcionproducto, precioproducto, stockproducto, texproducto, descuentoproducto, fechacreacionproducto, idcategoria,  $cantidad AS cantidad FROM productosp WHERE idproducto=? AND activo=1");
$sql->execute([$clave]);
$lista_carrito[] = $sql->fetch(PDO::FETCH_ASSOC);

    }
} else {
    header("Location: index.php");
    exit;
}





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
    <script src="https://checkout.bold.co/library/boldPaymentButton.js"></script>
    
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

<div class="container" >

    <div class="row" >
        <div class="col-6" >
            <h4>Detalles de pago</h4>




        </div>


        <div class="col-6" >
        <div class="table-responsive" >
        <table class="table" >
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            
                <?php if($lista_carrito == null) {
                    echo '<tr><td colspan="5" class="text-center" ><b>lista vacia</b></td></tr>';
                }else {
                    $total = 0;
                    foreach ($lista_carrito as $producto) {
                        $_id = $producto['idproducto'];
                        $nombre = $producto['nombreproducto'];
                        $precio = $producto['precioproducto'];
                        $cantidad = $producto['cantidad'];
                        $descuento = $producto['descuentoproducto'];
                        $precio_desc = $precio - (($precio * $descuento) / 100);
                        $subtotal = $cantidad * $precio_desc;
                        $total += $subtotal;
                    ?>

                <tr>
                    <td> <?php echo $nombre; ?> </td>

                    <td>
                        <div id="subtotal_<?php echo $_id; ?>" name="subtotal[]">
                        <?php echo MONEDA . number_format($subtotal,2, '.', ','); ?> 
                        </div>
                    </td>
                </tr>
                <?php
                }
                ?>

              <tr>
                <td colspan="3" >
                  <p class="h3 text-end " id="total" > <?php echo MONEDA . number_format($total,2, '.', ','); ?> </p>
                </td>
              </tr>
            </tbody>
            <?php
                }
                ?>
        </table>

        </div>

        </div>
    </div>
</div>


<div id="paypal-button-container" >
<?php 
$total_sin_puntos = str_replace('.', '', str_replace(',', '', $total));
$cadena_concatenada = $_id . $total_sin_puntos . "COP" . "egqPmJ9-NVxk62_LUu3mWeMdnVda6_tMOvmJ2IzLm-g";
$hash = hash("sha256", $cadena_concatenada);
 
echo $cadena_concatenada;
  ?>

<script
  data-bold-button
  data-api-key="egqPmJ9-NVxk62_LUu3mWeMdnVda6_tMOvmJ2IzLm-g"
  data-description="Pago de mi reserva dinámica"
  data-redirection-url="pago.php"
></script>

<script
  data-bold-button
  data-order-id="ORD-UNICO-172252876954"
  data-currency="COP"
  data-amount="560000"
  data-api-key="egqPmJ9-NVxk62_LUu3mWeMdnVda6_tMOvmJ2IzLm-g"
  data-integrity-signature=" <?php echo $hash; ?> "
  data-redirection-url="https://micomercio.com/pagos/resultado"
  data-description="Camiseta Rolling Stones XL"
  data-tax="vat-19"
></script>


</div>

</body>
</html>