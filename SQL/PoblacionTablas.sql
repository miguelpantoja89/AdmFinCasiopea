SET SERVEROUTPUT ON;


--BEGIN
--pck_comunidades.inicializar;
--pck_comunidades.insertar('Insertar una comunidad','Logroño 20',10,'ES3400000000000000000001',500,NULL,TRUE);
--
--pck_propietarios.inicializar;
--pck_propietarios.insertar('Insertar un propietario','Enrique Barba Roque','12345678B','954691579','enriquebarba@gmail.com',TRUE);
--pck_propietarios.insertar('Insertar un propietario','Brandon Sanderson','15647895Y','954671597','brandonsanderson@gmail.com',TRUE);
--
--pck_pisos.inicializar;
--pck_pisos.insertar('Insertar piso','1º E',1,1,TRUE);
--pck_pisos.insertar('Insertar piso','2º A',1,1,TRUE);
--pck_pisos.insertar('Insertar piso','1º E',2,1,FALSE);
--END;
--/

BEGIN
pck_comunidades.inicializar;
pck_comunidades.insertar('Insertar una comunidad','Logroño 20',10,'ES3400000000000000000001',500,NULL,TRUE);
pck_comunidades.insertar('Insertar una comunidad','Logroño 22',20,'ES3400000000000000000002',700,NULL,TRUE);
pck_comunidades.insertar('Insertar una comunidad','Reina Mercedes 3',15,'ES3400000000000000000003',400,NULL,TRUE);
pck_comunidades.insertar('Insertar una comunidad','Reina Mercedes 5',15,'ES3400000000000000000004',200,NULL,TRUE);
pck_comunidades.insertar('Insertar una comunidad con cuenta bancaria mal escrita','Logroño 22',10,'RE3400000000000000000002',600,NULL,FALSE);
pck_comunidades.actualizar('Actualizar una comunidad',1,'Palencia 3',14,'ES3400000000000000000001',300,NULL,TRUE);
pck_comunidades.actualizar('Actualizar una comunidad no existente',10,'Palencia 3',14,'ES3400000000000000000001',600,NULL,FALSE);
pck_comunidades.eliminar('Eliminar una comunidad',4,TRUE);


pck_propietarios.inicializar;
pck_propietarios.insertar('Insertar un propietario','Enrique Barba Roque','12345678B','954691579','enriquebarba@gmail.com',TRUE);
pck_propietarios.insertar('Insertar un propietario','Miquel Ángel Pantoja Bas','12364895N','954693257','miquelpantoja@gmail.com',TRUE);
pck_propietarios.insertar('Insertar un propietario','Jose Manuel Bejarano Pozo','15498764D','954687954','josebejarano@gmail.com',TRUE);
pck_propietarios.insertar('Insertar un propietario','Brandon Sanderson','15647895Y','954671597','brandonsanderson@gmail.com',TRUE);
pck_propietarios.insertar('Insertar un propietario','Clara Campoamor','15674894K','954671548','claracampoamor@gmail.com',TRUE);
pck_propietarios.insertar('Insertar un propietario','Alfonso Márquez','45478954J','954689475','alfonsomarquez@gmail.com',TRUE);
pck_propietarios.insertar('Insertar un propietario','Manuel Moreno','54789655B','954681523','manuelmoreno@gmail.com',TRUE);
pck_propietarios.insertar('Insertar un propietario','María Manzano','54687951R','954687415','mariamanzano@gmail.com',TRUE);
pck_propietarios.insertar('Insertar un propietario','Javier García','54789514B','954656479','javiergarcia@gmail.com',TRUE);
pck_propietarios.insertar('Insertar un propietario','Mariah Carey','632254789M','954645978','mariahcarey@gmail.com',TRUE);
pck_propietarios.insertar('Insertar un propietario con un DNI inválido','Brandon Sanderson','1564789RY','954671597','brandonsanderson@gmail.com',FALSE);
pck_propietarios.insertar('Insertar un propietario con un DNI repetido','Brandon Sanderson','12345678B','954671597','brandonsanderson@gmail.com',FALSE);
pck_propietarios.actualizar('Actualizar un propietario',1,'Enrique Barba Roque','30249059B','954691579','enriquebarba97@gmail.com',TRUE);
pck_propietarios.actualizar('Actualizar un propietario con DNI inválido',1,'Enrique Barba Roque','3024905SE','954691579','enriquebarba97@gmail.com',FALSE);
pck_propietarios.actualizar('Actualizar un propietario con DNI repetido',1,'Enrique Barba Roque','12364895N','954691579','enriquebarba97@gmail.com',FALSE);
pck_propietarios.actualizar('Actualizar un propietario no existente',100,'Enrique Barba Roque','12364895N','954691579','enriquebarba97@gmail.com',FALSE);
pck_propietarios.eliminar('Eliminar un propietario',10,TRUE);

pck_pisos.inicializar;
pck_pisos.insertar('Insertar piso','1º E',1,1,TRUE);
pck_pisos.insertar('Insertar piso','3º A',2,2,TRUE);
pck_pisos.insertar('Insertar piso','4º B',3,3,TRUE);
pck_pisos.insertar('Insertar piso','1º A',4,1,TRUE);
pck_pisos.insertar('Insertar piso','2º C',5,2,TRUE);
pck_pisos.insertar('Insertar piso','1º B',6,3,TRUE);
pck_pisos.insertar('Insertar piso','5º D',7,1,TRUE);
pck_pisos.insertar('Insertar piso','2º A',8,2,TRUE);
pck_pisos.insertar('Insertar piso','1º E',9,3,TRUE);
pck_pisos.insertar('Insertar piso incumpliendo la RN-004','4º B',9,3,FALSE);
END;
/

-- Introducción de pertenencias y presidentes
BEGIN
pck_pertenece.inicializar;
pck_pertenece.insertar('Insertar pertenencia a comunidad',1,1,TRUE);
pck_pertenece.insertar('Insertar pertenencia a comunidad',2,2,TRUE);
pck_pertenece.insertar('Insertar pertenencia a comunidad',3,3,TRUE);
pck_pertenece.insertar('Insertar pertenencia a comunidad',1,4,TRUE);
pck_pertenece.insertar('Insertar pertenencia a comunidad',2,5,TRUE);
pck_pertenece.insertar('Insertar pertenencia a comunidad',3,6,TRUE);
pck_pertenece.insertar('Insertar pertenencia a comunidad',1,7,TRUE);
pck_pertenece.insertar('Insertar pertenencia a comunidad',2,8,TRUE);
pck_pertenece.insertar('Insertar pertenencia a comunidad',3,9,TRUE);
pck_pertenece.insertar('Insertar pertenencia a comunidad con comunidad no existente',4,1,FALSE);
pck_pertenece.insertar('Insertar pertenencia a comunidad con propietario no existente',1,100,FALSE);

pck_comunidades.actualizar('Actualizar el presidente de una comunidad',1,'Palencia 3',14,'ES3400000000000000000001',300,1,TRUE);
pck_comunidades.actualizar('Actualizar el presidente de una comunidad',2,'Logroño 22',20,'ES3400000000000000000002',700,2,TRUE);
pck_comunidades.actualizar('Actualizar el presidente de una comunidad',3,'Reina Mercedes 3',15,'ES3400000000000000000003',400,3,TRUE);
pck_comunidades.actualizar('Actualizar el presidente de una comunidad incumpliendo RN-003',1,'Palencia 3',14,'ES3400000000000000000001',300,2,FALSE);

END;
/

BEGIN
pck_empresas.inicializar;
pck_empresas.insertar('Insertar una empresa','Emasesa','Calle Escuelas Pías, 1, 41003 Sevilla','955010010',TRUE);
pck_empresas.insertar('Insertar una empresa','Endesa','Av. de Diego Martínez Barrio, 2, 41013 Sevilla','800760909',TRUE);
pck_empresas.insertar('Insertar una empresa','Agencia Alondra','Calle Asensio y Toledo, 38, 41014 Sevilla','610960915',TRUE);
pck_empresas.insertar('Insertar una empresa','Casiopea','Calle Antonio Abad, 2, 41014 Sevilla','697845126',TRUE);
pck_empresas.insertar('Insertar una empresa','Iberdrola','Calle Felipe II, 34, 41013 Sevilla','698745982',TRUE);
pck_empresas.insertar('Insertar una empresa','Gas Natural Fenosa','Calle E, 41013 Sevilla',NULL,TRUE);
pck_empresas.actualizar('Actualizar una empresa',5,'Iberdrola','Calle Felipe II, 34, 41013 Sevilla','954103601',TRUE);
pck_empresas.actualizar('Actualizar una empresa no existente',10,'Iberdrola','Calle Felipe II, 34, 41013 Sevilla','954103601',FALSE);
pck_empresas.eliminar('Eliminar una empresa',6,TRUE);

pck_contratos.inicializar;
pck_contratos.insertar('Insertar un contrato',TO_DATE('01/01/2006','DD/MM/YYYY'),TO_DATE('01/01/2036','DD/MM/YYYY'),1,1,TRUE);
pck_contratos.insertar('Insertar un contrato',TO_DATE('01/01/2009','DD/MM/YYYY'),TO_DATE('01/01/2039','DD/MM/YYYY'),2,1,TRUE);
pck_contratos.insertar('Insertar un contrato',TO_DATE('01/01/2008','DD/MM/YYYY'),TO_DATE('01/01/2038','DD/MM/YYYY'),3,1,TRUE);
pck_contratos.insertar('Insertar un contrato',TO_DATE('01/01/2006','DD/MM/YYYY'),TO_DATE('01/01/2036','DD/MM/YYYY'),1,4,TRUE);
pck_contratos.insertar('Insertar un contrato',TO_DATE('01/01/2006','DD/MM/YYYY'),TO_DATE('01/01/2036','DD/MM/YYYY'),2,4,TRUE);
pck_contratos.insertar('Insertar un contrato',TO_DATE('01/01/2006','DD/MM/YYYY'),TO_DATE('01/01/2036','DD/MM/YYYY'),3,4,TRUE);
pck_contratos.insertar('Insertar un contrato',TO_DATE('01/01/2014','DD/MM/YYYY'),TO_DATE('01/01/2034','DD/MM/YYYY'),1,5,TRUE);
pck_contratos.insertar('Insertar un contrato',TO_DATE('01/01/2004','DD/MM/YYYY'),NULL,2,2,TRUE);
pck_contratos.insertar('Insertar un contrato',TO_DATE('01/01/2005','DD/MM/YYYY'),NULL,3,2,TRUE);
pck_contratos.insertar('Insertar un contrato',TO_DATE('01/01/2018','DD/MM/YYYY'),TO_DATE('01/01/2023','DD/MM/YYYY'),1,3,TRUE);
pck_contratos.insertar('Insertar un contrato',TO_DATE('01/01/2018','DD/MM/YYYY'),TO_DATE('01/01/2023','DD/MM/YYYY'),3,3,TRUE);
pck_contratos.insertar('Insertar un contrato inclumpiendo restricción de fechas',TO_DATE('01/01/2014','DD/MM/YYYY'),TO_DATE('01/01/2012','DD/MM/YYYY'),2,5,FALSE);
pck_contratos.actualizar('Actualizar un contrato',8,TO_DATE('01/01/2004','DD/MM/YYYY'),TO_DATE('01/01/2024','DD/MM/YYYY'),2,2,TRUE);
pck_contratos.actualizar('Actualizar un contrato inclumpiendo restricción de fechas',9,TO_DATE('01/01/2005','DD/MM/YYYY'),TO_DATE('01/01/2003','DD/MM/YYYY'),2,2,FALSE);
pck_contratos.actualizar('Actualizar un contrato no existente',15,TO_DATE('01/01/2004','DD/MM/YYYY'),TO_DATE('01/01/2024','DD/MM/YYYY'),2,2,FALSE);
pck_contratos.eliminar('Eliminar un contrato',11,TRUE);

END;
/

BEGIN
pck_cuotas.inicializar;
pck_cuotas.insertar('Insertar una cuota',TO_DATE('01/01/2018','DD/MM/YYYY'),10,1,1,TRUE);
pck_cuotas.insertar('Insertar una cuota',TO_DATE('01/01/2018','DD/MM/YYYY'),10,4,1,TRUE);
pck_cuotas.insertar('Insertar una cuota',TO_DATE('01/01/2018','DD/MM/YYYY'),10,7,1,TRUE);
pck_cuotas.insertar('Insertar una cuota',TO_DATE('01/02/2018','DD/MM/YYYY'),10,1,1,TRUE);
pck_cuotas.insertar('Insertar una cuota',TO_DATE('01/02/2018','DD/MM/YYYY'),10,4,1,TRUE);
pck_cuotas.insertar('Insertar una cuota',TO_DATE('01/02/2018','DD/MM/YYYY'),10,7,1,TRUE);
pck_cuotas.insertar('Insertar una cuota',TO_DATE('01/03/2018','DD/MM/YYYY'),10,1,1,TRUE);
pck_cuotas.insertar('Insertar una cuota',TO_DATE('01/03/2018','DD/MM/YYYY'),10,4,1,TRUE);
pck_cuotas.insertar('Insertar una cuota',TO_DATE('01/03/2018','DD/MM/YYYY'),10,7,1,TRUE);
pck_cuotas.insertar('Insertar una cuota',TO_DATE('01/04/2018','DD/MM/YYYY'),10,1,1,TRUE);
pck_cuotas.insertar('Insertar una cuota',TO_DATE('01/01/2018','DD/MM/YYYY'),15,2,2,TRUE);
pck_cuotas.insertar('Insertar una cuota',TO_DATE('01/01/2018','DD/MM/YYYY'),15,5,2,TRUE);
pck_cuotas.insertar('Insertar una cuota',TO_DATE('01/01/2018','DD/MM/YYYY'),15,8,2,TRUE);
pck_cuotas.insertar('Insertar una cuota incumpliendo la RN-005',TO_DATE('01/04/2018','DD/MM/YYYY'),10,2,1,FALSE);
pck_cuotas.actualizar('Actualizar una cuota',9,TO_DATE('01/03/2018','DD/MM/YYYY'),20,7,1,TRUE);
pck_cuotas.eliminar('Eliminar una cuota',10,TRUE);

pck_pagos.inicializar;
pck_pagos.insertar('Insertar un pago',10,TO_DATE('02/01/2018','DD/MM/YYYY'),1,1,TRUE);
pck_pagos.insertar('Insertar un pago',10,TO_DATE('02/02/2018','DD/MM/YYYY'),1,1,TRUE);
pck_pagos.insertar('Insertar un pago',10,TO_DATE('02/03/2018','DD/MM/YYYY'),1,1,TRUE);
pck_pagos.insertar('Insertar un pago',40,TO_DATE('05/01/2018','DD/MM/YYYY'),4,1,TRUE);
pck_pagos.insertar('Insertar un pago',10,TO_DATE('06/01/2018','DD/MM/YYYY'),7,1,TRUE);
pck_pagos.insertar('Insertar un pago',10,TO_DATE('06/02/2018','DD/MM/YYYY'),7,1,TRUE);
pck_pagos.insertar('Insertar un pago',15,TO_DATE('02/01/2018','DD/MM/YYYY'),2,2,TRUE);
pck_pagos.insertar('Insertar un pago',15,TO_DATE('02/01/2018','DD/MM/YYYY'),5,2,TRUE);
pck_pagos.insertar('Insertar un pago',10,TO_DATE('02/01/2018','DD/MM/YYYY'),8,2,TRUE);
pck_pagos.insertar('Insertar un pago incumpliendo la RN-005',10,TO_DATE('06/01/2018','DD/MM/YYYY'),6,1,FALSE);
pck_pagos.actualizar('Actualizar un pago',5,20,TO_DATE('06/02/2018','DD/MM/YYYY'),7,1,TRUE);
pck_pagos.eliminar('Eliminar un pago',6,TRUE);
END;
/

BEGIN
pck_facturas.inicializar;
pck_facturas.insertar('Insertar una factura',200,TO_DATE('01/03/2018','DD/MM/YYYY'),'Emasesa',1,1,TRUE);
pck_facturas.insertar('Insertar una factura',100,TO_DATE('01/01/2018','DD/MM/YYYY'),'Limpieza',1,3,TRUE);
pck_facturas.insertar('Insertar una factura',50,TO_DATE('01/02/2018','DD/MM/YYYY'),'Gastos administrativos',1,4,TRUE);
pck_facturas.insertar('Insertar una factura',250,TO_DATE('01/03/2018','DD/MM/YYYY'),'Luz',1,5,TRUE);
pck_facturas.insertar('Insertar una factura',10,TO_DATE('15/03/2018','DD/MM/YYYY'),'Varios',1,NULL,TRUE);
----
pck_facturas.insertar('Insertar una factura',500,TO_DATE('15/04/2018','DD/MM/YYYY'),'Varios',2,NULL,TRUE);


END;
/

BEGIN
pck_presupuestos.inicializar;
pck_conceptos.inicializar;
pck_presupuestos.insertar('Insertar un presupuesto',TO_DATE('20/11/2017','DD/MM/YYYY'),TO_DATE('01/01/2018','DD/MM/YYYY'),'Presupuesto anual 2018',1,TRUE);
pck_conceptos.insertar('Insertar un concepto','Alcantarillado','9,25','Alcantarillado',1,TRUE);
pck_conceptos.insertar('Insertar un concepto','Gastos bancarios','8,08','Gastos bancarios',1,TRUE);
pck_conceptos.insertar('Insertar un concepto','Administrador','52,27','Gastos administrativos',1,TRUE);
pck_conceptos.insertar('Insertar un concepto','Gastos varios','11,27','Varios',1,TRUE);
pck_conceptos.insertar('Insertar un concepto','Limpieza','18,39','Limpieza',1,TRUE);
pck_conceptos.insertar('Insertar un concepto','Iberdrola',16,'Luz',1,TRUE);

END;
/