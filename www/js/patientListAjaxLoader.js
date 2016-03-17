;function loadToTable(){
	$('#search-patient').keyup(function(){
      var name = $('#search-patient').val(),
          request = 'name=' + name;
      $.ajax({
        type: 'GET',
        url: 'get_patient_list.php',
        data: request,
        success: function(data){
        	
        }
      });
	});
};