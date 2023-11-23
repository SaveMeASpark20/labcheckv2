<?php
    require_once "../connection/database.php";
?>
<section id="content">
		<!-- NAVBAR -->
		<nav>
            <div>
				<div class="hamburger-row">
					<span class="fa fa-bars toggle-sidebar"></span>
					<h2 class="hamburger-text">
						<?=$page?>   
					</h2>
				</div>
				<div class="acad-year">
				<?= $_SESSION['school_year']?> <?= $_SESSION['semester']?> 
				</div>
            </div>
            <div>
				<div class="name-usertype">
					<h4>
						<?=$_SESSION['name']?>
					</h4>
					<small>Admin</small>
				</div>
			</div>
		</nav>
		<!-- NAVBAR -->