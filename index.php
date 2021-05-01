  <?php
    include("header.php");
    getHeader("Luxury Car Rental", "mainCss.css");
    require("adminPanel/displayInfo.php");
    include("menu.php");
    if (isset($_GET['status'])) {
        if ($_GET['status'] == "OK") {
            echo '
        <script>
        swal({
            title: "The transaction was successful!",
            text: "The reservation has been paid for.",
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
