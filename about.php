<?php
session_start();
session_regenerate_id();
require_once 'app/helpers.php';

?>
<?php $page_title = 'About';?>
<?php include 'tpl/header.php';?>
<main class="min-h-900">
    <div class="container">
        <div class="row">
            <div class="col-12 mt-4 text-index">
                <h1>About us</h1>
                <p>The main goal of this blog is to let you, people who cares about paris, to talk, share and give tips to other users who love the city of lights.<br> please <a href="signup.php" class="btn btn-secondary btn-sm">sign-up</a> and start chating!</p>
            </div>
        </div>       
    </div>
</main>
<?php include 'tpl/footer.php'; ?>