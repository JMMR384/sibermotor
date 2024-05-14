<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>OG Tech PC - Manage Products Panel</title>
  <?php
    include "header.php"; 
    include "static/pages/side_nav.html";
    include "static/pages/admin_nav.php";
  ?>
</head>
<script>
  Quagga.init({
    inputStream: {
      name: "Live",
      type: "LiveStream",
      target: document.querySelector('#scan-window'),
      constraints: {
        width: 400,
        height: 300,
        facingMode: "environment"
      }
    },
    decoder: {
      readers: ["code_128_reader"]
    }
  }, function(err) {
    if (err) {
      console.log(err);
      return;
    }
    Quagga.start();
  });

  Quagga.onDetected(function(result) {
    document.getElementById('scan-result').innerHTML = 'Código de barras: ' + result.codeResult.code;
    Quagga.stop();
  });
</script>
<body>
  <div class="container" style="margin-top: 150px">
    <h3 class="page-title">Manage Products</h3>

    <div class="rounded-card-parent center" style="margin-bottom: 100px">
      <div class="card rounded-card">
        <div class="card-content white-text">
          <span class="orange-text" style="font-size: 24px">Products List - Sorted by quantity
          <th>
            <button class='deep-orange btn'><a href="admin_manage_products.php"><i class='material-icons white-text'>refresh</i></a>
            </button>
          </th>
          </span>

          <!-- search product input field start -->
          <form action="admin_manage_products.php" method="POST">
            <div class="row" style="margin: 0px;">
              <div class="input-field col s3" style = "color:azure">
                <input name="search_product" id="search_product" type="text" class="validate white-text" maxlength="20">
                <label for="search_product">Search product by Name or Brand</label>
                <div id="error" class="errormsg">
                  
                </div>
                
              </div>
            </div>
          </form>
          <!-- search product input field end -->

          <!-- search product result list start -->
          <form action="" method="GET">
            <table class="responsive-table" id="pagination">
              <thead class="text-primary">
                <tr>
                  <th>Name</th><th>Brand</th><th class='center'>Quantity In Stock</th>
                </tr>
              </thead>
              <tbody>
                <?php
                  $products = new adminContr();
                  $products->productsList();
                ?>
              </tbody>
            </table>
            <div class="col-md-12 centertext-center">
              <span class="left" id="total_reg"></span>
              <ul class="pagination pager white-text" id="myPager"></ul>
            </div>
          </form>
          <!-- search product result list end -->
        </div>
      </div>
    </div>
    <!-- products table end -->

    <!-- selected product details start -->
  <?php if (isset($_GET["inspect_product"])) { ?>
  <div class="rounded-card-parent">
    <div class="card rounded-card">
      <div class="card-content white-text">
        <span class="card-title orange-text bold">Selected Product Details</span>
        <table class="responsive-table center">
          <form action="admin_manage_products.php" method="GET">
            <thead class="text-primary center">
            <tr><th>Image</th><th>Name</th><th>Brand</th>
            <th>Description</th><th>Category</th><th>Selling Price</th><th>Qty In Stock</th></tr>
            </thead>
            <tbody>
              <?php
                $showInspect = new adminContr();
                $showInspect->showInspectedProduct();
              ?>
            </tbody>
          </form>
        </table>
      </div>
    </div>
  </div>
  <?php }
    //delete product
    if (isset($_GET["delete_product"]))
    {
      $id = $_GET["delete_product"];
      $sql =  "DELETE FROM Items WHERE ItemID = $id";
      $dbh = new Dbhandler();
      $dbh->conn()->query($sql) or die ("<p class='red-text'>*Delete statement FAILED!</p>");
    }
  ?>
  <!-- selected member details end -->

  <!-- create product start -->
  <div class="rounded-card-parent" style="margin-top: 100px">
    <div class="card rounded-card">
      <div class="card-content">
        <span class="card-title orange-text bold">Create Product</span>
        <form id="create" name="create" action="" method="POST">
          <div class="row">
            <div class="col s6" style="padding-right: 40px;">
              <div class="row">
                <div class="input-field white-text">
                  <i class="material-icons prefix">inventory_2</i>
                  <input id="name" name="name" type="text" class="validate white-text" required>
                  <label for="name">Product Name</label>
                </div>
              </div>
              <div class="row">
                <div class="input-field white-text">
                  <i class="material-icons prefix">star_border</i>
                  <input id="brand" name="brand" type="text" class="validate white-text" required>
                  <label for="brand">Brand</label>
                </div>
              </div>
              <div class="row">
                <div class="input-field white-text">
                  <i class="material-icons prefix">info</i>
                  <textarea id="description" name="description" class="materialize-textarea white-text" required></textarea>
                  <label for="description">Description</label>
                </div>
              </div>
            </div>
            <div class="col s6" style="padding-left: 40px;">
              <div class="row">
                <div class="input-field white-text">
                  <i class="material-icons prefix">category</i>
                  <input id="category" name="category" type="text" class="validate white-text" required>
                  <label for="category">Category</label>
                </div>
              </div>
              <div class="row">
                <div class="input-field white-text">
                  <i class="material-icons prefix">attach_money</i>
                  <input id="price" name="price" type="number" class="validate white-text" required>
                  <label for="price">Selling Price</label>
                </div>
              </div>
              <div class="row">
                <div class="input-field white-text">
                  <i class="material-icons prefix">exposure_plus_1</i>
                  <input id="quantity" name="quantity" type="number" class="validate white-text" required>
                  <label for="quantity">Quantity In Stock</label>
                </div>
              </div>
              <div class="row">
                <div class="file-field input-field white-text">
                  <div class="btn deep-orange">
                    <span>Image</span>
                    <input type="file" name="image" id="image" required>
                  </div>
                  <div class="file-path-wrapper">
                    <input class="file-path validate white-text" type="text">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="file-field input-field white-text">
                  <div class="btn deep-orange">
                  <span id="scan-button">Escanear código de barras</span>
                  </div>
                  <div id="scan-window"></div>
                  <div id="scan-result"></div>
              </div>
            </div>
          </div>
          <div class="center">
            <button class="btn waves-effect waves-light deep-orange" type="submit" name="submit">Submit
              <i class="material-icons right">send</i>
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- create product end -->

  <!-- scripts -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
  <script src="../javascript/jquery.twbsPagination.min.js"></script>
  <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
  <script>
    $(document).ready(function() {
      function abrirVentanaYMostrarCamara() {
        const video = document.createElement('video');
        navigator.mediaDevices.getUserMedia({ video: { facingMode: 'environment' } })
          .then(function(stream) {
            video.srcObject = stream;
            video.play();
            const canvas = document.createElement('canvas');
            const ctx = canvas.getContext('2d');
            const codeReader = new ZXing.BrowserMultiFormatReader();
            codeReader.decodeFromVideoDevice(video, canvas, function(result, error) {
              if (result) {
                document.getElementById('scan-result').innerHTML = 'Código de barras: ' + result.text;
              } else {
                document.getElementById('scan-result').innerHTML = 'Error al escanear el código de barras';
              }
            });
            // Crea una ventana flotante usando jQuery UI
            $("#scan-window").dialog({
              title: "Escanear código de barras",
              width: 400,
              height: 300,
              modal: true,
              close: function() {
                // Detiene el video y la lectura del código de barras cuando se cierra la ventana
                video.srcObject.getTracks().forEach(function(track) {
                  track.stop();
                });
                codeReader.reset();
              }
            });
            // Agrega el video a la ventana flotante
            $("#scan-window").append(video);
          })
          .catch(function(error) {
document.getElementById('scan-result').innerHTML = 'Error al acceder a la cámara';
          });
      }
      document.getElementById('scan-button').addEventListener('click', abrirVentanaYMostrarCamara);
    });
  </script>

  <!-- escanear codigos de barras -->
  <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
  <script>
    $(function() {
      $("#scan-window").dialog({
        autoOpen: false,
        width: 400,
        height: 300,
        modal: true,
        buttons: {
          "Cerrar": function() {
            $(this).dialog("close");
          }
        }
      });
    });
  </script>

<?php include "footer.php"; ?>
</body>
</html>