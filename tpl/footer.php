<!-- Footer -->
<footer class="page-footer font-small pt-4 mt-5">
  <div class="container-fluid text-center">
    <div class="row">
      <div class="col-md p-0">
        <div class="top-footer">  
                "A walk about Paris will provide lessons in history, beauty, and in   the point of Life." Thomas Jefferson
        </div> 
      </div>    
    </div>
  </div>
  <div class= main-footer>
  <div class="container-fluid text-center text-md-left">
    <div class="row">
      <div class="col-md text-center mt-5">             
        <div style="font-size: 5rem;" class="icons">
            <a href="#"><i class="fab fa-facebook-square"></i></a>
            <a href="#"><i class="fab fa-whatsapp"></i></a>
            <a href="#"><i class="fab fa-twitter-square"></i></a>
            <a href="#"><i class="fab fa-instagram"></i></a>
        </div>
      </div>
      <div class="col-md">
        <div class="navigation">
          <h5 class="text-uppercase  navigate-left">Navigate</h5>
          <ul class="list-unstyled navigate-right">
            <li class="navigate-li">
              <a class="navigate-a" href="index.php">Home</a>
            </li>
            <li class="navigate-li">
                <a class="navigate-a" href="about.php">About</a>
            </li>
            <li class="navigate-li">
                <a class="navigate-a" href="blog.php">Blog</a>
            </li>
            <?php if(!auth_user()): ?>
            <li class="navigate-li">
                <a class="navigate-a" href="signup.php">Sign-Up</a>
            </li>
            <li class="navigate-li">
                <a class="navigate-a" href="login.php">Log-In</a>
            </li>
            <?php else: ?>
            <li class="navigate-li">
              <a class="navigate-a" href="profile.php">Profile</a>
            </li>
            <?php endif; ?>
          </ul>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-sm">
      <div class="footer-copyright text-center pb-3 d-none d-lg-block">
          © <?=date("Y")?> Michael Blum
      </div>
    </div>
  </div>
  


</footer>

<!-- Footer -->
<script src="https://kit.fontawesome.com/2dd5471de4.js" crossorigin="anonymous"></script>


<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<script src="js/script.js"></script>
</body>

</html>