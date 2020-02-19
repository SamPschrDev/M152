<?php
    include("functions.php");
?>

<!DOCTYPE html>
<html lang="en">
	<head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8"> 
        <meta charset="utf-8">
        <title>M152 Facebook</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <link href="assets/css/bootstrap.css" rel="stylesheet">
        <!--[if lt IE 9]>
          <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
        <link href="assets/css/facebook.css" rel="stylesheet">
    </head>    
    <body>        
        <div class="wrapper">
			<div class="box">
				<div class="row row-offcanvas row-offcanvas-left">					
				  
					<!-- main right col -->
					<div class="column col-sm-12 col-xs-12" id="main">
						<!-- top nav -->
						<div class="navbar navbar-blue navbar-static-top">
							<nav class="collapse navbar-collapse" role="navigation">
                                <ul class="nav navbar-nav">
                                    <li>
                                        <a href="index.php"><i class="glyphicon glyphicon-home"></i> Home</a>
                                    </li>
                                    <li>
                                        <a href="post.php" role="button" data-toggle="modal"><i class="glyphicon glyphicon-plus"></i> Post</a>
                                    </li>
                                </ul>
							</nav>
                        </div>
                        <!-- Espace de post -->
						<div class="padding">
							<div class="full col-sm-9">
								 <!-- main col left --> 
								 <div class="col-sm-5" style="margin-left: 28%;">
                                      <!-- GARDER POUR POST -->
									  <div class="well"> 
										   <form class="form-horizontal" role="form" method="POST">
											<h4>Quoi de neuf ?</h4>
												<textarea class="form-control" placeholder="Commentez votre post" name="txtaCommentaire"></textarea>
												<form action="file-upload.php" method="post" enctype="multipart/form-data">													
													<input class="btn btn-primary pull-right" type="submit" name="btnPost" value="Poster" style="margin-top: 4%;"/>
													<input name="userFiles[]" accept="image/jpeg, image/png" type="file" style="margin-top: 5%;" multiple/><br/>
												</form>
										  	</form>
									  </div>
								  </div><!-- /col-sm-5 -->
							</div><!-- /col-9 -->
						</div><!-- / Espace de post -->
					</div>
					<!-- /main -->
				</div>
			</div>
		</div>       
        <script type="text/javascript" src="assets/js/jquery.js"></script>
        <script type="text/javascript" src="assets/js/bootstrap.js"></script>
        <script type="text/javascript">
        $(document).ready(function() {
			$('[data-toggle=offcanvas]').click(function() {
				$(this).toggleClass('visible-xs text-center');
				$(this).find('i').toggleClass('glyphicon-chevron-right glyphicon-chevron-left');
				$('.row-offcanvas').toggleClass('active');
				$('#lg-menu').toggleClass('hidden-xs').toggleClass('visible-xs');
				$('#xs-menu').toggleClass('visible-xs').toggleClass('hidden-xs');
				$('#btnShow').toggle();
			});
        });
        </script>
</body></html>