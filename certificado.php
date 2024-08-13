<?php 
session_start();
if (!isset($_SESSION["user"])) {
  header("Location: login.php");
  return;
}
if (!isset($_SESSION["flash"]["exam_passed"])) {
  header("Location: home.php");
  return;
}
?>

<?php require "partials/header.php" ?>
<div class="container pt-4 p-3">
    <div class="row">
        <div class="col-md-8 mx-auto text-center">
          <div class="card card-body">
      

           
            <div id="loading" class="pt-3 justify-content-center align-items-center" style="height: auto; max-height: 600px; min-height:250px;">
                <div class="spinner-border mt-5 text-primary" role="status">
                    <span class="visually-hidden">Generando PDF...</span>
                </div>
            </div>

         
            <iframe id="pdfFrame" src="fpdf/generate_certificate.php" style="width:100%; height:500px; display:none;" frameborder="0"></iframe>
            
           
            <a id="downloadButton" href="fpdf/generate_certificate.php" class="btn btn-primary mt-3" download="Certificado_<?php echo htmlspecialchars($_SESSION["user"]["name"]); ?>">Descargar certificado, puede tomar unos segundos</a>
          </div>
        </div>
    </div>
</div>
<?php require "partials/footer.php" ?>

<script>
    document.getElementById('pdfFrame').onload = function() {
       
        document.getElementById('loading').style.display = 'none';
        document.getElementById('pdfFrame').style.display = 'block';
    };
</script>
