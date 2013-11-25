use bd_Museo;

insert into Sala_Museo (idPlanta, nombreSala, descripcionSala) values (1,'salaprincipal','sala principal');
insert into Planta_Museo(numeroPlanta, capacidad) values (1,400);
insert into Exposicion (idSala,nombreExposicion,fechaInicio,fechaFin,descripcionExpo) values (1,'exposicion permanente',NOW(),NULL,'exposicion residente del museo');
	