/*---ACORDEÓN TABLA ÚLTIMOS CAMBIOS---*/
$(document).ready(function(){
		$('input.btVer') .click(
			function() {
				$(this) .parents('table.bodyupdates') .children('tbody') .toggle();
			}
		)

		$('input.btVer').parents('table.bodyupdates').children('tbody').toggle();

		$('li#limuseo') .click(
			function() {
				$('li.liexposiciones').toggle();
				$('li.liplantas').toggle();
				$('li.lisalas').toggle();
			}
		)
		$('li.liexposiciones').toggle();
		$('li.liplantas').toggle();
		$('li.lisalas').toggle();


});