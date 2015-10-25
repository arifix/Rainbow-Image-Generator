$(document).ready(function(){
	$("#save").hide();
	 
	 $('#myForm').ajaxForm({
	 	beforeSend:function(){
	 		 $(".progress").show();
	 		 $(".complete").show();
	 	},
	 	uploadProgress:function(event, position, total, percentComplete){
	 		$(".progress-bar").width(percentComplete+'%');
	 		$(".complete").html(percentComplete+'% Complete');
	 	},
	 	success:function(){
	 		$(".progress").hide();
	 		$(".complete").hide();
	 	},
	 	complete:function(response){
	 		if(response.responseText=='0')
	 			$(".notice").html("Error");
	 		else
	 			$(".notice").html(response.responseText);
	 			$("#save").show();
	 	}
	 });
});
