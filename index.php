  <?php
    include("header.php");
    getHeader("Wypożyczalnia Luksusowych Samochodów", "mainCss.css");
    require("adminPanel/displayInfo.php");
    include("menu.php");
    if(isset($_GET['status'])){
      if($_GET['status'] == "OK"){
        echo '
        <script>
        swal({
            title: "Transakcja przebiegła pomyślnie!",
            text: "Rezerwacja została opłacona.",
            type: "success",
            confirmButtonColor: "#3085d6",
            confirmButtonText: "OK!"
          }).then(function () {
            window.location.href = "index.php";
          })
        </script>';
      }
    }
    include("body.php");
    include("footer.php");
   ?>
