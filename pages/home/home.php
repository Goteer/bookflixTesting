<head><link rel="stylesheet" href="../../resources/libs/swiper.min.css"></head>
<?php

include_once "../../resources/framework/class/class.libro.php";
include_once "../../resources/framework/class/class.user.php";
$libros = new LibroDB();
$userRecord = new UserDB();
?>
<br>




<?php
	$libros->fetchRecordSet($conn);
?>
<h2>Libros disponibles</h2>

<div class="bookflix-carousel">
<div class="swiper-container">
    <div class="swiper-wrapper">
		<?php


			while ($next = $libros->getNextRecord()){
				echo 	'<div class="swiper-slide" style="background:#222;height:auto;max-width: 100%;">
								<form method="post" action="../../viewer.php">
									<input type="hidden" name="bookID" value="'.$next->idLibro.'"/>
									<a class="overText" title="'.$next->nombre.'" onclick="this.parentNode.submit();">
										<img src="../../'.$next->foto.'" alt="'.$next->nombre.'">
									</a>
								</form>
							</div>';
			}

		?>
    <div class="swiper-slide" style="background:#222;height:auto;max-width:100%;"> <a href="index.php?verMas=populares"><h1 style="color:#fff;"> Ver m&aacute;s... </h1></a></div>
	</div>


    <!-- If we need navigation buttons -->
    <div class="swiper-button-prev"></div>
    <div class="swiper-button-next"></div>

</div>
</div>

<hr>




<script src="../../resources/libs/swiper.min.js"></script>
 <script><?php include "configCarousel.js"?></script>
