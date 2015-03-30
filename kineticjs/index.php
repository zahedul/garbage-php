<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="Kinetic JS Experiment">
<meta name="author" content="Zahedul Alams">
<!-- <link rel="shortcut icon" href="../../docs-assets/ico/favicon.png"> -->

<title>Kinetic Js Drawing tools</title>

<!-- Bootstrap core CSS -->
<link href="bootstrap/css/bootstrap.css" rel="stylesheet">
<style type="text/css">
#wrapper {
    margin-top: 60px;
}

#canvas-holder{
background: #ddd;
}
</style>

<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
</head>

<body>

	<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse"
					data-target=".navbar-collapse">
					<span class="sr-only">Toggle navigation</span> <span
						class="icon-bar"></span> <span class="icon-bar"></span> <span
						class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="#">Drawing Tool - Kinetic JS</a>
			</div>
			<div class="collapse navbar-collapse">
				<ul class="nav navbar-nav">
					<li class="active"><a href="#">Home</a></li>					
				</ul>
			</div>
			<!--/.nav-collapse -->
		</div>
		<div class="clearfix"></div>
	</div>

	<div class="container">		
        <div id="wrapper">
            <div class="row">
                <div class="col-md-12">
                    <h3>Drowing Tool</h3>
                    <div id="canvas-holder"></div>
                </div>
            </div>            
        </div>
	</div>
	<!-- /.container -->


	<!-- Bootstrap core JavaScript
    ================================================== -->
	<!-- Placed at the end of the document so the pages load faster -->
	<script type="text/javascript" src="js/jquery-v1.10.2.min.js"></script>
	<script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="js/kinetic-v4.7.4.min.js"></script>
	<script type="text/javascript" src="js/fencedrawing.js"></script>
</body>
</html>
