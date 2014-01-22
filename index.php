<?php
  require_once($_SERVER['DOCUMENT_ROOT'] . '/src/includes.php');
?>
<!DOCTYPE html>
<html>
<head>
	<title><?=Router::getTitle($viewValue)?></title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="author" content="Oleg Tikhonov">
	<meta name="distribution" content="Global">
	<meta name="resource-type" content="document">
	<meta name="robots" content="INDEX,FOLLOW">

	<?php
		foreach(Router::getStatics($viewValue, 'css') as $path){
			echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"{$path}\">";
		}
	?>
</head>
	<body>
      <?php
       Router::includeView('menu'); 
      ?>
        <div class="col-lg-3">

            <div class="well">

           </div>
        </div>
       <div class="col-lg-9">
       		<div class="jumbotron">
              <?php
                if(Router::showSearchDialog($viewValue))
                    Router::includeView('search');
              ?>
       	 	   <div id="blockContent">
               <?php 
         	 	     Router::includeView($viewValue, true);
         	 	   ?>  
             </div>
 		   </div>
        </div>
        

        <?php
          foreach(Router::getStatics($viewValue, 'js') as $path){
            echo "<script type=\"text/javascript\" src=\"{$path}\"></script>";
          }
        ?>
    </body>
</html>
</body>
</html>