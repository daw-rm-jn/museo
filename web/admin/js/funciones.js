/*---ACORDEÓN TABLA ÚLTIMOS CAMBIOS---*/
$(document).ready(function(){
/*--- OCULTAR/MOSTRAR DESCRIPCION DE ACTUALIZACIONES ---*/
		$('input.btVer') .click(
			function() {
				$(this) .parents('table.bodycrud') .children('tbody') .toggle();
			}
		)

		$('input.btVer').parents('table.bodycrud').children('tbody').toggle();
/*--- DESPLEGABLE LISTA MUSEO---*/
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

		$('li#liusuarios') .click(
			function() {
				$('li.liclientes').toggle();
				$('li.liadmins').toggle();
			}
		)
		$('li.liclientes').toggle();
		$('li.liadmins').toggle();

});