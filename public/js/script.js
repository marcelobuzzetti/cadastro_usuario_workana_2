$(function () {
	/*Define o maximo de materiais que podem ser cautelados*/
    $('#material').change(function () {
        $('#quantidade').load('/cautelamaterial/maximo/' + $.param({id: $('#material').val()}));
        /*$('#alerta').load('../model/informaQntCombustivel.php?' + $.param({combustivel: $('#combustivel').val(), tp: $('#tp').val(), qnt: $('#qnt').val()}));*/
    });
    /*Define o maximo de materiais que podem ser cautelados*/

    /*Autocompleta o pelotao em adicionar militar*/
    $( "#pelotao" ).autocomplete({
	  source: "/militar/pelotao/",
	  minLength: 1,
	  select: function(event, ui) {
	  	$('#pelotao').val(ui.item.value);
	  }
	});
    /*Autocompleta o pelotao em adicionar militar*/

});