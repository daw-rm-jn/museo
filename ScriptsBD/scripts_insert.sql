use bd_Museo;

INSERT INTO Planta_Museo(idPlanta,numeroPlanta, capacidad) VALUES (1,1,400);
INSERT INTO Sala_Museo (idSala,idPlanta, nombreSala, descripcionSala) VALUES (1,1,'salaprincipal','sala principal');
INSERT INTO Exposicion (idExposicion,idSala,nombreExposicion,fechaInicio,fechaFin,descripcionExpo) VALUES (1,1,'exposicion permanente',NOW(),NULL,'exposicion residente del museo');

INSERT INTO Administrador(email,clave,fechaAlta) VALUES ('admin@admin.com','250939a0f3f4b5513d6f5335bc9c9550',NOW()); /*la clave está cifrada, es 'clavemd5'*/

INSERT INTO Usuario(email,clave,nombre,nif,dir,pais,provincia,poblacion,cp,telf,fechaAlta) VALUES ('cliente1@prueba.com','d5a8d8c7ab0514e2b8a2f98769281585','Cliente1','50948753Y','c/falsa 123','España','Madrid','Madrid',28009,666666666,NOW()); /*la clave es 'cliente1'*/
INSERT INTO Usuario(email,clave,nombre,nif,dir,pais,provincia,poblacion,cp,telf,fechaAlta) VALUES ('cliente2@prueba.com','6dcd0e14f89d67e397b9f52bb63f5570','Cliente2','02248123H','c/montalba 4','España','Barcelona','Barcelona',27033,585474696,NOW()); /*la clave es 'cliente2'*/
INSERT INTO Usuario(email,clave,nombre,nif,dir,pais,provincia,poblacion,cp,telf,fechaAlta) VALUES ('cliente3@prueba.com','428e859901e1b27ec01c7921afc31d98','Cliente3','84695442F','c/desengaño, 21','España','Madrid','Madrid',20000,147258369,NOW()); /*la clave es 'cliente3'*/

INSERT INTO Carrito(idCarrito,email,fechaCreacion,fechaExpir) VALUES (1,'cliente1@prueba.com',NOW(),NOW()+INTERVAL 10 DAY);
INSERT INTO Carrito(idCarrito,email,fechaCreacion,fechaExpir) VALUES (2,'cliente2@prueba.com',NOW(),NOW()+INTERVAL 10 DAY);
INSERT INTO Carrito(idCarrito,email,fechaCreacion,fechaExpir) VALUES (3,'cliente3@prueba.com',NOW(),NOW()+INTERVAL 10 DAY);

INSERT INTO Copia_Cuadro(idCopia_Cuadro,nombreProducto,autor,estilo,orientacion,anioCuadro,fechaAlta,descripcion,precio,fotoCuadro) VALUES (1,'Crucifixión de San Pedro','Michelangelo Merisi da Caravaggio','Barroco','vertical','1601',NOW(),'Crucifixión de San Pedro (en italiano, Crocifissione di San Pietro) es una obra maestra del pintor italiano Caravaggio. Está realizado al óleo sobre lienzo y tiene unas dimensiones de 230 centímetros de alto por 175 de ancho. Fue pintada para la capilla Cerasi de la iglesia de Santa María del Popolo de Roma, Italia.',100,'Crucifixion de San Pedro.jpg');
INSERT INTO Copia_Cuadro(idCopia_Cuadro,nombreProducto,autor,estilo,orientacion,anioCuadro,fechaAlta,descripcion,precio,fotoCuadro) VALUES (2,'On White II','Vasili Kandinski','Expresionismo','vertical','1923',NOW(),'On White II expresa una combinación inteligente de los dos colores principales en la pintura: blanco y negro. Kandinsky utiliza el color para representar algo más que formas y figuras en sus pinturas.',82,'On White II.jpg');
INSERT INTO Copia_Cuadro(idCopia_Cuadro,nombreProducto,autor,estilo,orientacion,anioCuadro,fechaAlta,descripcion,precio,fotoCuadro) VALUES (3,'Las señoritas de Avignon','Pablo Picasso','Cubismo','vertical','1907',NOW(),'Las señoritas de Avignon, Las señoritas de Aviñón o de Avinyó es un cuadro del pintor español Pablo Picasso pintado en 1907. Está hecho mediante la técnica del óleo sobre lienzo y sus medidas son 243,9 x 233,7 cm. Se conserva en el Museo de Arte Moderno de Nueva York.',200,'Las señoritas de Avignon.jpg');

INSERT INTO Estilo(idEstilo,nombreEstilo,descripcionEstilo) VALUES (1,'Barroco','La pintura barroca es la pintura relacionada con el movimiento cultural barroco. El movimiento a menudo se le identifica con el absolutismo, la Contrarreforma y el renacimiento católico, pero la existencia de importante arte y arquitectura barrocos en países no absolutistas y protestantes por toda Europa Occidental evidencian su amplia popularidad.');
INSERT INTO Estilo(idEstilo,nombreEstilo,descripcionEstilo) VALUES (2,'Expresionismo','El expresionismo fue un movimiento cultural surgido en Alemania a principios del siglo XX, que tuvo plasmación en un gran número de campos: artes plásticas, literatura, música, cine, teatro, danza, fotografía, etc.');
INSERT INTO Estilo(idEstilo,nombreEstilo,descripcionEstilo) VALUES (3,'Cubismo','El cubismo fue un movimiento artístico desarrollado entre 1907 y 1914, nacido en Francia y encabezado por Pablo Picasso, Georges Braque y Juan Gris. Es una tendencia esencial, pues da pie al resto de las vanguardias europeas del siglo XX. No se trata de un ismo más, sino de la ruptura definitiva con la pintura tradicional.');

INSERT INTO Pintor(idPintor,nombrePintor,bioPintor,fechaNacimiento,fechaMuerte,fotoPintor) VALUES (1,'Michelangelo Merisi da Caravaggio','Pintor italiano activo en Roma, Nápoles, Malta y Sicilia entre los años de 1593 y 1610. Es considerado como el primer gran exponente de la pintura del Barroco. ','1571-09-29','1610-07-18','Michelangelo Merisi da Caravaggio.jpg');
INSERT INTO Pintor(idPintor,nombrePintor,bioPintor,fechaNacimiento,fechaMuerte,fotoPintor) VALUES (2,'Vasili Kandinski','pintor ruso, precursor de la abstracción en pintura y teórico del arte, con él se considera que comienza la abstracción lírica.','1866-12-04','1944-12-13','Vasili Kandinski.jpeg');
INSERT INTO Pintor(idPintor,nombrePintor,bioPintor,fechaNacimiento,fechaMuerte,fotoPintor) VALUES (3,'Pablo Picasso','pintor y escultor español, creador, junto con Georges Braque y Juan Gris, del movimiento cubista.','1881-10-25','1973-04-08','Pablo Picasso.jpg');

INSERT INTO Cuadro(idCuadro,idPintor,idExposicion,idEstilo,nombreCuadro,descripcionCuadro,orientacion,anioCuadro,fotoCuadro) VALUES (1,1,1,1,'Crucifixión de San Pedro','Crucifixión de San Pedro (en italiano, Crocifissione di San Pietro) es una obra maestra del pintor italiano Caravaggio. Está realizado al óleo sobre lienzo y tiene unas dimensiones de 230 centímetros de alto por 175 de ancho. Fue pintada para la capilla Cerasi de la iglesia de Santa María del Popolo de Roma, Italia.','vertical','1601','Crucifixion de San Pedro.jpg');
INSERT INTO Cuadro(idCuadro,idPintor,idExposicion,idEstilo,nombreCuadro,descripcionCuadro,orientacion,anioCuadro,fotoCuadro) VALUES (2,2,1,2,'On White II','On White II expresa una combinación inteligente de los dos colores principales en la pintura: blanco y negro. Kandinsky utiliza el color para representar algo más que formas y figuras en sus pinturas.','vertical','1923','On White II.jpg');
INSERT INTO Cuadro(idCuadro,idPintor,idExposicion,idEstilo,nombreCuadro,descripcionCuadro,orientacion,anioCuadro,fotoCuadro) VALUES (3,3,1,3,'Las señoritas de Avignon','Las señoritas de Avignon, Las señoritas de Aviñón o de Avinyó es un cuadro del pintor español Pablo Picasso pintado en 1907. Está hecho mediante la técnica del óleo sobre lienzo y sus medidas son 243,9 x 233,7 cm. Se conserva en el Museo de Arte Moderno de Nueva York.','vertical','1907','Las señoritas de Avignon.jpg');

INSERT INTO Datos_Bancarios(email,numeroTarjeta,CCV,fechaCaducidad) VALUES ('cliente1@prueba.com',0123456789123456,753,'2017-01-01');
INSERT INTO Datos_Bancarios(email,numeroTarjeta,CCV,fechaCaducidad) VALUES ('cliente2@prueba.com',6543219876543210,357,'2017-01-01');
INSERT INTO Datos_Bancarios(email,numeroTarjeta,CCV,fechaCaducidad) VALUES ('cliente3@prueba.com',1472583690963852,456,'2018-05-01');

INSERT INTO Pedido(email,idPedido,fecha,precioTotal,estado) VALUES ('cliente1@prueba.com',1,'2011-06-26',105,'Entregado');
INSERT INTO Pedido(email,idPedido,fecha,precioTotal,estado) VALUES ('cliente2@prueba.com',2,'2013-05-21',82,'Entregado');
INSERT INTO Pedido(email,idPedido,fecha,precioTotal,estado) VALUES ('cliente3@prueba.com',3,NOW(),200,'En Espera');