var main = function(){
	'use strict';
	var count = 0;

	$('.produtos-output').hide();

	$('.produtos-input .button').on("click", function(event){
		var qtd = $('#qtd').val();
		$('#qtd').val("");
		var nome = $('#nome').val();
		$('#nome').val("");
		var vlr_uni = $('#vlr_uni').val();
		$('#vlr_uni').val("");
		var vlr_total = $('#vlr_total').val();
		$('#vlr_total').val("");

		if(nome.length > 0 && qtd.length > 0 && vlr_uni.length > 0 && vlr_total.length > 0)
		{
			if(count == 0)
				$('.produtos-output').fadeIn();

			var new_div = $("<input type='number' style='width: 40px' name='new_qtd"+count+"' id='qtd' min=1 max=99>");
			$('.produtos-output').append(new_div.val(qtd));
			
			var new_div = $("<input type='text' style='width: 180px' name='new_nome"+count+"' id='nome' maxlength='30'>");
			$('.produtos-output').append(new_div.val(nome));

			var new_div = $("<input type='text' style='width: 105px' name='new_vlr_uni"+count+"' id='vlr_uni' onKeyUp='moeda(this);' >");
			$('.produtos-output').append(new_div.val(vlr_uni));
			
			var new_div = $("<input type='text' style='width: 105px'  name='new_vlr_total"+count+"' id='vlr_total' onKeyUp='moeda(this);' ><br>");
			$('.produtos-output').append(new_div.val(vlr_total));

			count++;

		}else
			alert("Campo informado esta em branco");

	});

};

$(document).ready(main);