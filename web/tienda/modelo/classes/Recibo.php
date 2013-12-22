<?php 
	class Recibo{
		private $idRecibo;
		private $datosPedido;
		private $datosCliente;
		private $lineasPedido;

		public function Recibo($idRecibo,$datosPedido,$datosCliente,$lineasPedido){
			$this->idRecibo = $idRecibo;
			$this->datosPedido = $datosPedido;
			$this->datosCliente = $datosCliente;
			$this->lineasPedido = $lineasPedido;
		}

		public function getidRecibo()
		{
		    return $this->idRecibo;
		}
		
		public function setidRecibo($idRecibo)
		{
		    $this->idRecibo = $idRecibo;
		    return $this;
		}

		public function getdatosPedido()
		{
		    return $this->datosPedido;
		}
		
		public function setdatosPedido($datosPedido)
		{
		    $this->datosPedido = $datosPedido;
		    return $this;
		}

		public function getdatosCliente()
		{
		    return $this->datosCliente;
		}
		
		public function setdatosCliente($datosCliente)
		{
		    $this->datosCliente = $datosCliente;
		    return $this;
		}

		public function getlineasPedido()
		{
		    return $this->lineasPedido;
		}
		
		public function setlineasPedido($lineasPedido)
		{
		    $this->lineasPedido = $lineasPedido;
		    return $this;
		}

		public function genHtml(){
			$idRecibo = $this->getidRecibo();
			$datosPedido = $this->getdatosPedido();
			$datosCliente = $this->getdatosCliente();
			$lineasPedido = $this->getlineasPedido();
			$html = "
<html>
	<head>
		<style>
			body{
			} 
			.titulo{
			font-weight:bold;
			font-size:12px;
			padding: 5 0 5 0;
			background: #4952a3;
			color: #fff;
			text-align:center;
			}
			.descl{
			font-weight:bold;
			font-size:12px;
			color: #000;
			padding: 5 0 5 5;
			background: #d3def2;
			text-align:left;
			border:1px solid #4952a3;
			}
			.descd{
			font-weight:bold;
			font-size:12px;
			color: #000;
			padding: 5 5 5 5;
			background: #d3def2;
			text-align:right;
			border:1px solid #4952a3;
			}
			.td1{
			font-weight:bold;
			font-size:12px;
			color: #000;
			text-align:left;
			padding: 5 0 5 5;
			border:1px solid #4952a3;
			}
			.td2{
			font-weight:bold;
			font-size:12px;
			color: #000;
			text-align:right;
			padding: 5 5 5 5;
			border:1px solid #4952a3;
			}
			.tabla{
			border:1px solid #4952a3;
			}
		</style>
	</head>
	<body>
		<br/>
		<br/>
		<br/>
		<table class='tabla'>
			<tr><td colspan='6' class='titulo'>FACTURA nº" . $idRecibo . "</td></tr>
			<tr>
				<td colspan='6' class='td1'>
					Fecha: " . $datosPedido->getfecha() . "<br />
					Pedido nº " . $datosPedido->getidPedido() . "<br />
				</td>
			</tr>
			<tr><td colspan='6' class='descl'>Datos CLIENTE</td></tr>
			<tr>
				<td colspan='6' class='td1'>
					Nombre: " . $datosCliente->getNombre() . "<br />
					N.I.F: " . $datosCliente->getNif() . " <br />
					Direccion de envio: " . $datosCliente->getDir() . " <br />
					País: " . $datosCliente->getPais() . " <br />
					Provincia: " . $datosCliente->getProvincia() . " <br />
					Población: " . $datosCliente->getPoblacion() . " <br />
					Cod. postal: " . $datosCliente->getCp() . " <br />
				</td>
			</tr>
			<tr><td colspan='6' class='descl'>Datos FACTURA</td></tr>
			<tr><td class='descd'>REF.</td><td class='descd'>DESCRIPCION</td><td class='descd'>CANT.</td><td class='descd'>PRECIO</td><td class='descd'>IVA</td><td class='descd'>IMPORTE</td></tr>";

			foreach($lineasPedido as $linea){
				$html .= "<tr><td class='td2'>" . $linea['idCopia_Cuadro'] . "</td><td class='td2'>" . $linea['nombreProducto'] . "</td><td class='td2'>" . $linea['unidades'] . "</td><td class='td2'>" . $linea['precio'] . " EUR.</td><td class='td2'>" . $linea['IVA'] . "%</td><td class='td2'>" . $linea['totalLinea'] . " EUR.</td></tr>";
			}

			$html .= "<tr><td colspan='6' class='titulo'>TOTAL FACTURA: " . $datosPedido->getprecioTotal() . "</td></tr>
		</table>
	</body>
</html>";
			return $html;
		}
	}
?>