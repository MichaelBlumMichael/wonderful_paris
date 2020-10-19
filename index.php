<?php 
session_start();
session_regenerate_id();
$page_title = 'Wonderful Paris';
require_once 'app/helpers.php';

?>
<?php include 'tpl/header.php'; ?>
    <main class="min-h-900 bg-all">
        <div class="container-fluid">
            <div class="row">
                <div class="text-index text-center mt-3">
                    <h1>Let's Talk About Paris</h1>
                    <p>This is the best forum to share and talk about paris. Please sign in and join the conversation.</p>
                </div> 
            </div>
           
            
        <div class="row">
               <div class="col-lg-12">
               <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                    <img class="d-block w-100" src="images/gallery/1.jpg" alt="First slide">
                    </div>
                    <div class="carousel-item">
                    <img class="d-block w-100" src="images/gallery/2.jpg" alt="Second slide">
                    </div>
                    <div class="carousel-item">
                    <img class="d-block w-100" src="images/gallery/3.jpg" alt="Third slide">
                    </div>
                    <div class="carousel-item">
                    <img class="d-block w-100" src="images/gallery/4.jpg" alt="Third slide">
                    </div>
                    <div class="carousel-item">
                    <img class="d-block w-100" src="images/gallery/5.jpg" alt="Third slide">
                    </div>
                    <div class="carousel-item">
                    <img class="d-block w-100" src="images/gallery/6.jpg" alt="Third slide">
                    </div>
                </div>
                <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
                </div>
               </div>
            </div>
        </div>
    </main>
    <?php include 'tpl/footer.php'; ?>
</html>