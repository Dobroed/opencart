$(document).ready(function(){	   
/*`Scroll to top */
$('.backtotop').click(function(){
  $('html, body').animate({scrollTop:0}, 'slow');
});
/* Navigation Menu */
$('#menu > span').click(function () {
	  $('#menu > ul').slideToggle('medium');
	});

/*Footer Link*/
$(".column h3").click(function () {
			$screensize = $(window).width();
			if ($screensize < 768) {
				$(this).next(".column ul").slideToggle('medium');}
		});
/*Title heading span wrap*/
$('.box-heading').wrapInner('<span></span>')

/*plus mines button in qty*/
$(".qtyBtn").click(function(){
		if($(this).hasClass("plus")){
			var qty = $("#qty").val();
			qty++;
			$("#qty").val(qty);
		}else{
			var qty = $("#qty").val();
			qty--;
			if(qty>0){
				$("#qty").val(qty);
			}
		}
	});	
});