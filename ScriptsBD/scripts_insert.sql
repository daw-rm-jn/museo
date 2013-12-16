use bd_Museo;

INSERT INTO Administrador(email,clave,fechaAlta) VALUES ('admin@admin.com','250939a0f3f4b5513d6f5335bc9c9550',NOW()); /*la clave está cifrada, es 'clavemd5'*/

INSERT INTO Usuario(email,clave,nombre,nif,cp,telf,fechaAlta) VALUES ('cliente1@prueba.com','d5a8d8c7ab0514e2b8a2f98769281585','Cliente1','50948753Y',28009,666666666,NOW()); /*la clave es 'cliente1'*/
INSERT INTO Usuario(email,clave,nombre,nif,cp,telf,fechaAlta) VALUES ('cliente2@prueba.com','6dcd0e14f89d67e397b9f52bb63f5570','Cliente2','02248123H',27033,585474696,NOW()); /*la clave es 'cliente2'*/
INSERT INTO Usuario(email,clave,nombre,nif,cp,telf,fechaAlta) VALUES ('cliente3@prueba.com','428e859901e1b27ec01c7921afc31d98','Cliente3','84695442F',20000,147258369,NOW()); /*la clave es 'cliente3'*/

INSERT INTO Carrito(email,fechaCreacion,fechaExpir) VALUES ('cliente1@prueba.com',NOW(),NOW()+INTERVAL 10 DAY);
INSERT INTO Carrito(email,fechaCreacion,fechaExpir) VALUES ('cliente2@prueba.com',NOW(),NOW()+INTERVAL 10 DAY);
INSERT INTO Carrito(email,fechaCreacion,fechaExpir) VALUES ('cliente3@prueba.com',NOW(),NOW()+INTERVAL 10 DAY);

INSERT INTO Copia_Cuadro(nombreProducto,autor,estilo,fechaAlta,descripcion,precio,fotoCuadro) VALUES ();
INSERT INTO Copia_Cuadro(nombreProducto,autor,estilo,fechaAlta,descripcion,precio,fotoCuadro) VALUES ();
INSERT INTO Copia_Cuadro(nombreProducto,autor,estilo,fechaAlta,descripcion,precio,fotoCuadro) VALUES ();

INSERT INTO Estilo(nombreEstilo,descripcionEstilo) VALUES ('Barroco','La pintura barroca es la pintura relacionada con el movimiento cultural barroco. El movimiento a menudo se le identifica con el absolutismo, la Contrarreforma y el renacimiento católico, pero la existencia de importante arte y arquitectura barrocos en países no absolutistas y protestantes por toda Europa Occidental evidencian su amplia popularidad.');
INSERT INTO Estilo(nombreEstilo,descripcionEstilo) VALUES ('Expresionismo','El expresionismo fue un movimiento cultural surgido en Alemania a principios del siglo XX, que tuvo plasmación en un gran número de campos: artes plásticas, literatura, música, cine, teatro, danza, fotografía, etc.');
INSERT INTO Estilo(nombreEstilo,descripcionEstilo) VALUES ('Cubismo','El cubismo fue un movimiento artístico desarrollado entre 1907 y 1914, nacido en Francia y encabezado por Pablo Picasso, Georges Braque y Juan Gris. Es una tendencia esencial, pues da pie al resto de las vanguardias europeas del siglo XX. No se trata de un ismo más, sino de la ruptura definitiva con la pintura tradicional.');

INSERT INTO Pintor(nombrePintor,bioPintor,fechaNacimiento,fechaMuerte,fotoPintor) VALUES ();
INSERT INTO Pintor(nombrePintor,bioPintor,fechaNacimiento,fechaMuerte,fotoPintor) VALUES ();
INSERT INTO Pintor(nombrePintor,bioPintor,fechaNacimiento,fechaMuerte,fotoPintor) VALUES ();

INSERT INTO Cuadro(idPintor,idExposicion,idEstilo,nombreCuadro,descripcionCuadro,fotoCuadro) VALUES ();
INSERT INTO Cuadro(idPintor,idExposicion,idEstilo,nombreCuadro,descripcionCuadro,fotoCuadro) VALUES ();
INSERT INTO Cuadro(idPintor,idExposicion,idEstilo,nombreCuadro,descripcionCuadro,fotoCuadro) VALUES ();

INSERT INTO Datos_Bancarios(email,numeroTarjeta,CCV,fechaCaducidad) VALUES ('cliente1@prueba.com',0123456789123456,753,2017-01-01);
INSERT INTO Datos_Bancarios(email,numeroTarjeta,CCV,fechaCaducidad) VALUES ('cliente2@prueba.com',6543219876543210,357,2017-01-01);
INSERT INTO Datos_Bancarios(email,numeroTarjeta,CCV,fechaCaducidad) VALUES ('cliente3@prueba.com',1472583690963852,456,2018-05-01);

INSERT INTO Linea_Carrito(idLinea_Carrito,idCarrito,idCopia_Cuadro,nombreProducto,unidades,precio,IVA,totalLinea) VALUES ();
INSERT INTO Linea_Carrito(idLinea_Carrito,idCarrito,idCopia_Cuadro,nombreProducto,unidades,precio,IVA,totalLinea) VALUES ();
INSERT INTO Linea_Carrito(idLinea_Carrito,idCarrito,idCopia_Cuadro,nombreProducto,unidades,precio,IVA,totalLinea) VALUES ();

INSERT INTO Pedido(email,fecha,precioTotal,estado) VALUES ('cliente1@prueba.com',2011-06-26,105,'Entregado');
INSERT INTO Pedido(email,fecha,precioTotal,estado) VALUES ('cliente2@prueba.com',2013-05-21,82,'Entregado');
INSERT INTO Pedido(email,fecha,precioTotal,estado) VALUES ('cliente3@prueba.com',NOW(),'En Espera');

INSERT INTO Linea_Pedido(idLinea_Pedido,idPedido,idCopia_Cuadro,nombreProducto,unidades,precio,IVA,totalLinea) VALUES ();
INSERT INTO Linea_Pedido(idLinea_Pedido,idPedido,idCopia_Cuadro,nombreProducto,unidades,precio,IVA,totalLinea) VALUES ();
INSERT INTO Linea_Pedido(idLinea_Pedido,idPedido,idCopia_Cuadro,nombreProducto,unidades,precio,IVA,totalLinea) VALUES ();

INSERT INTO Recibo(idRecibo,idPedido,reciboHTML) VALUES ();

INSERT INTO Planta_Museo(numeroPlanta, capacidad) VALUES (1,400);
INSERT INTO Sala_Museo (idPlanta, nombreSala, descripcionSala) VALUES (1,'salaprincipal','sala principal');
INSERT INTO Exposicion (idSala,nombreExposicion,fechaInicio,fechaFin,descripcionExpo) VALUES (1,'exposicion permanente',NOW(),NULL,'exposicion residente del museo');