<!-- Latest compiled and minified JavaScript -->
<footer class="footer">
	<div class="container">
		<p>Current version:0.1 (development)</p>
	</div>
</footer>
<script src="js/bootstrap.min.js"></script>
<link rel="stylesheet" type="text/css" href="frontside/fancybox/source/jquery.fancybox.css" media="screen">
<script type="text/javascript" src="js/script.js"></script>
<script type="text/javascript" src="frontside/fancybox/source/jquery.fancybox.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
	  $('[data-toggle="tooltip"]').tooltip();
      $('.get-app-data').fancybox({
      	type: 'ajax',
        ajax : {
          type    : "GET"
        }, 
      	'transitionIn'	:	'fade',
		'transitionOut'	:	'fade',
		'speedIn'		:	1000, 
		'speedOut'		:	200,
		'showCloseButton': false
	  });
	});
</script>
</body>
</html>