DROP TABLE Pertenece;
DROP TABLE Pisos;
DROP TABLE Cuotas;
DROP TABLE Pagos;
DROP TABLE Contratos;
DROP TABLE Facturas;
DROP TABLE Empresas;
DROP TABLE Conceptos;
DROP TABLE Presupuestos;
DROP TABLE Comunidades;
DROP TABLE Propietarios;
DROP TABLE Usuarios;

CREATE TABLE Usuarios(
Login VARCHAR(20),
Pass VARCHAR(20),
PRIMARY KEY (Login)
);

INSERT INTO Usuarios VALUES('admin', 'admin');

CREATE TABLE Propietarios(
IdP INTEGER,
NombreAp VARCHAR2(50),
Dni CHAR(9) NOT NULL UNIQUE,
Telefono CHAR(9),
Email VARCHAR(50),
PRIMARY KEY (IdP)
);

CREATE TABLE Comunidades(
IdC INTEGER,
Direccion VARCHAR2(50),
NumeroPropietarios INTEGER,
CuentaCorriente CHAR(24),
SaldoInicial NUMBER(6,2),
Presidente INTEGER,
PRIMARY KEY (IdC),
FOREIGN KEY (Presidente) REFERENCES Propietarios (IdP),
unique(CuentaCorriente)
);



CREATE TABLE Pertenece(
IdPert INTEGER,
IdP INTEGER NOT NULL,
IdC INTEGER NOT NULL,
PRIMARY KEY (IdPert),
UNIQUE(IdP,IdC),
FOREIGN KEY (IdP) REFERENCES Propietarios,
FOREIGN KEY (IdC) REFERENCES Comunidades
);

CREATE TABLE Pisos(
IdPiso INTEGER,
PisoLetra VARCHAR(50),
IdP INTEGER,
IdC INTEGER,
PRIMARY KEY (IdPiso),
FOREIGN KEY (IdP) REFERENCES Propietarios,
FOREIGN KEY (IdC) REFERENCES Comunidades
);

CREATE TABLE Cuotas(
IdCuota INTEGER,
Mes DATE,
PagoExigido NUMBER(6,2) CHECK (PagoExigido>=0),
IdP INTEGER,
IdC INTEGER,
PRIMARY KEY (IdCuota),
FOREIGN KEY (IdP) REFERENCES Propietarios,
FOREIGN KEY (IdC) REFERENCES Comunidades
);
CREATE TABLE Pagos(
IdPago INTEGER,
Cantidad NUMBER(6,2) CHECK (Cantidad>=0),
FechaPago DATE,
IdP INTEGER,
IdC INTEGER,
PRIMARY KEY (IdPago),
FOREIGN KEY (IdP) REFERENCES Propietarios,
FOREIGN KEY (IdC) REFERENCES Comunidades
);

CREATE TABLE Empresas(
IdEmpresa INTEGER,
Nombre VARCHAR2(50),
Direccion VARCHAR2(50),
Telf CHAR(9),
PRIMARY KEY(IdEmpresa)
);

CREATE TABLE Contratos(
IdContrato INTEGER,
FechaInicio DATE not null,
FechaFin DATE,
IdC INTEGER,
IdEmpresa INTEGER,
constraint fechas check(FechaFin>FechaInicio),
PRIMARY KEY(IdContrato),
FOREIGN KEY(IdC) REFERENCES Comunidades,
FOREIGN KEY(IdEmpresa) REFERENCES Empresas
);

CREATE TABLE Facturas(
IdFactura INTEGER,
Importe NUMBER(6,2) CHECK (Importe>=0),
FechaEmision DATE,
TipoServicio VARCHAR2(50),
IdC INTEGER,
IdEmpresa INTEGER,
PRIMARY KEY (IdFactura),
FOREIGN KEY (Idc) REFERENCES Comunidades,
FOREIGN KEY(IdEmpresa) REFERENCES Empresas
);

CREATE TABLE Presupuestos(
IdPresupuesto INTEGER,
FechaAprobacion DATE,
FechaAplicacion DATE,
Motivo VARCHAR(50),
IdC INTEGER,
PRIMARY KEY (IdPresupuesto),
FOREIGN KEY (IdC) REFERENCES Comunidades
);

CREATE TABLE Conceptos(
IdConcepto INTEGER,
Nombre VARCHAR(50),
Cantidad NUMBER(6,2) CHECK (Cantidad>=0),
Servicio VARCHAR(50),
IdPresupuesto INTEGER,
PRIMARY KEY (IdConcepto),
FOREIGN KEY (IdPresupuesto) REFERENCES Presupuestos
);

ALTER TABLE Propietarios ADD CONSTRAINT CK_Telefono_Propietario CHECK (REGEXP_LIKE(Telefono, '[0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9]'));
ALTER TABLE Propietarios ADD CONSTRAINT CK_DNI_Propietario CHECK (REGEXP_LIKE(Dni, '[0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9][A-Z]'));
ALTER TABLE Comunidades ADD CONSTRAINT CK_Cuenta_corriente CHECK (REGEXP_LIKE(CuentaCorriente, '[E][S][0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9]'));
ALTER TABLE Facturas ADD CONSTRAINT CK_TipoServicio CHECK (TipoServicio IN ('Alcantarillado', 'Extintores', 'Emasesa', 'Gastos bancarios', 'Gastos administrativos', 'Limpieza', 'Mant. Ascensores', 'Seguro Bloque', 'Luz', 'Varios'));
ALTER TABLE Conceptos ADD CONSTRAINT CK_ServicioConcepto CHECK (Servicio IN ('Alcantarillado', 'Extintores', 'Emasesa', 'Gastos bancarios', 'Gastos administrativos', 'Limpieza', 'Mant. Ascensores', 'Seguro Bloque', 'Luz', 'Varios'));

DROP SEQUENCE seq_propietario;
DROP SEQUENCE seq_comunidad;
DROP SEQUENCE seq_piso;
DROP SEQUENCE seq_presupuesto;
DROP SEQUENCE seq_pertenece;
DROP SEQUENCE seq_concepto;
DROP SEQUENCE seq_contrato;
DROP SEQUENCE seq_cuota;
DROP SEQUENCE seq_empresa;
DROP SEQUENCE seq_factura;
DROP SEQUENCE seq_pago;

CREATE SEQUENCE seq_propietario INCREMENT BY 1 START WITH 1;
CREATE SEQUENCE seq_comunidad INCREMENT BY 1 START WITH 1;
CREATE SEQUENCE seq_piso INCREMENT BY 1 START WITH 1;
CREATE SEQUENCE seq_presupuesto INCREMENT BY 1 START WITH 1;
CREATE SEQUENCE seq_pertenece INCREMENT BY 1 START WITH 1;
CREATE SEQUENCE seq_concepto INCREMENT BY 1 START WITH 1;
CREATE SEQUENCE seq_contrato INCREMENT BY 1 START WITH 1;
CREATE SEQUENCE seq_cuota INCREMENT BY 1 START WITH 1;
CREATE SEQUENCE seq_empresa INCREMENT BY 1 START WITH 1;
CREATE SEQUENCE seq_factura INCREMENT BY 1 START WITH 1;
CREATE SEQUENCE seq_pago INCREMENT BY 1 START WITH 1;

CREATE OR REPLACE TRIGGER tr_sec_propietarios
BEFORE INSERT ON propietarios
FOR EACH ROW
BEGIN
    IF :NEW.IdP IS NULL THEN
        SELECT seq_propietario.nextval INTO :NEW.IdP FROM DUAL;
    END IF;
END;
/

CREATE OR REPLACE TRIGGER tr_sec_presupuestos
BEFORE INSERT ON presupuestos
FOR EACH ROW
BEGIN
    IF :NEW.IdPresupuesto IS NULL THEN
        SELECT seq_presupuesto.nextval INTO :NEW.IdPresupuesto FROM DUAL;
    END IF;
END;
/

CREATE OR REPLACE TRIGGER tr_sec_pisos
BEFORE INSERT ON pisos
FOR EACH ROW
BEGIN
    IF :NEW.IdPiso IS NULL THEN
        SELECT seq_piso.nextval INTO :NEW.IdPiso FROM DUAL;
    END IF;
END;
/

CREATE OR REPLACE TRIGGER tr_sec_pertenece
BEFORE INSERT ON pertenece
FOR EACH ROW
BEGIN
    IF :NEW.IdPert IS NULL THEN
        SELECT seq_pertenece.nextval INTO :NEW.IdPert FROM DUAL;
    END IF;
END;
/

CREATE OR REPLACE TRIGGER tr_sec_pagos
BEFORE INSERT ON pagos
FOR EACH ROW
BEGIN
    IF :NEW.IdPago IS NULL THEN
        SELECT seq_pago.nextval INTO :NEW.IdPago FROM DUAL;
    END IF;
END;
/

CREATE OR REPLACE TRIGGER tr_sec_facturas
BEFORE INSERT ON facturas
FOR EACH ROW
BEGIN
    IF :NEW.IdFactura IS NULL THEN
        SELECT seq_factura.nextval INTO :NEW.IdFactura FROM DUAL;
    END IF;
END;
/

CREATE OR REPLACE TRIGGER tr_sec_empresas
BEFORE INSERT ON empresas
FOR EACH ROW
BEGIN
    IF :NEW.IdEmpresa IS NULL THEN
        SELECT seq_empresa.nextval INTO :NEW.IdEmpresa FROM DUAL;
    END IF;
END;
/

CREATE OR REPLACE TRIGGER tr_sec_cuotas
BEFORE INSERT ON cuotas
FOR EACH ROW
BEGIN
    IF :NEW.IdCuota IS NULL THEN
        SELECT seq_cuota.nextval INTO :NEW.IdCuota FROM DUAL;
    END IF;
END;
/

CREATE OR REPLACE TRIGGER tr_sec_contratos
BEFORE INSERT ON contratos
FOR EACH ROW
BEGIN
    IF :NEW.IdContrato IS NULL THEN
        SELECT seq_contrato.nextval INTO :NEW.IdContrato FROM DUAL;
    END IF;
END;
/

CREATE OR REPLACE TRIGGER tr_sec_conceptos
BEFORE INSERT ON conceptos
FOR EACH ROW
BEGIN
    IF :NEW.IdConcepto IS NULL THEN
        SELECT seq_concepto.nextval INTO :NEW.IdConcepto FROM DUAL;
    END IF;
END;
/

CREATE OR REPLACE TRIGGER tr_sec_comunidades
BEFORE INSERT ON comunidades
FOR EACH ROW
BEGIN
    IF :NEW.IdC IS NULL THEN
        SELECT seq_comunidad.nextval INTO :NEW.IdC FROM DUAL;
    END IF;
END;
/

ALTER TRIGGER tr_sec_propietarios ENABLE;
ALTER TRIGGER tr_sec_presupuestos ENABLE;
ALTER TRIGGER tr_sec_pisos ENABLE;
ALTER TRIGGER tr_sec_pertenece ENABLE;
ALTER TRIGGER tr_sec_pagos ENABLE;
ALTER TRIGGER tr_sec_facturas ENABLE;
ALTER TRIGGER tr_sec_empresas ENABLE;
ALTER TRIGGER tr_sec_cuotas ENABLE;
ALTER TRIGGER tr_sec_contratos ENABLE;
ALTER TRIGGER tr_sec_conceptos ENABLE;
ALTER TRIGGER tr_sec_comunidades ENABLE;

/*
CREATE OR REPLACE PROCEDURE insertar_propietario (NombreAp VARCHAR, Dni VARCHAR) IS
BEGIN
INSERT INTO Propietarios VALUES (seq_propietario.nextval,NombreAp, Dni);
END;
/

CREATE OR REPLACE PROCEDURE insertar_pesupuesto (FechaAprobacion DATE, FechaAplicacion DATE, IdC INTEGER) IS
BEGIN
INSERT INTO Presupuestos VALUES (SEQ_PRESUPUESTO.nextval, FechaAprobacion, FechaAplicacion, IdC);
END;
/

CREATE OR REPLACE PROCEDURE insertar_piso (PisoLetra VARCHAR, IdP INTEGER) IS
BEGIN
INSERT INTO Pisos VALUES (SEQ_PISOS.nextval, PisoLetra, IdP);
END;
/

CREATE OR REPLACE PROCEDURE insertar_pertenencia (IdP INTEGER, IdC INTEGER) IS
BEGIN
INSERT INTO Pertenencia VALUES (seq_pertenece.nextval, IdP, IdC);
END;
/

CREATE OR REPLACE PROCEDURE insertar_pago (Cantidad NUMBER, IdP INTEGER, IdC INTEGER) IS
BEGIN
INSERT INTO Pagos VALUES (seq_pago.nextval, Cantidad, IdP, IdC);
END;
/

CREATE OR REPLACE PROCEDURE insertar_factura (Importe NUMBER, FechaEmision DATE, IdC INTEGER, IdEmpresa INTEGER) IS
BEGIN
INSERT INTO Facturas VALUES (seq_factura, Importe, FechaEmision, IdC, IdEmpresa);
END;
/

CREATE OR REPLACE PROCEDURE insertar_pertenencia (IdP INTEGER, IdC INTEGER) IS
BEGIN
INSERT INTO Pisos VALUES (seq_pertenece, IdP, IdC);
END;
/

CREATE OR REPLACE PROCEDURE insertar_pertenencia (IdP INTEGER, IdC INTEGER) IS
BEGIN
INSERT INTO Pisos VALUES (seq_pertenece, IdP, IdC);
END;
/

CREATE OR REPLACE PROCEDURE insertar_pertenencia (IdP INTEGER, IdC INTEGER) IS
BEGIN
INSERT INTO Pisos VALUES (seq_pertenece, IdP, IdC);
END;
/

CREATE OR REPLACE PROCEDURE insertar_pertenencia (IdP INTEGER, IdC INTEGER) IS
BEGIN
INSERT INTO Pisos VALUES (seq_pertenece, IdP, IdC);
END;
/

CREATE OR REPLACE PROCEDURE insertar_pertenencia (IdP INTEGER, IdC INTEGER) IS
BEGIN
INSERT INTO Pisos VALUES (seq_pertenece, IdP, IdC);
END;
/

--Procedimientos y funciones asociadas a las reglas funcionales
--RF 001-Saldo de una comunidad
CREATE OR REPLACE FUNCTION Saldo_comunidad(v_IdC IN comunidades.idc%TYPE) RETURN NUMBER
IS
    v_saldo NUMBER;
    v_saldoInicial NUMBER;
    v_pagos NUMBER;
    v_facturas NUMBER;
BEGIN
    SELECT saldoInicial INTO v_saldoInicial FROM Comunidades WHERE IdC=v_IdC;
    SELECT SUM(cantidad) INTO v_pagos FROM Pagos WHERE IdC=v_IdC;
    SELECT SUM(importe) INTO v_facturas FROM Facturas WHERE IdC=v_IdC;
    v_saldo := v_saldoInicial+v_pagos-v_facturas;
    RETURN v_saldo;
END saldo_comunidad;
/

CREATE OR REPLACE FUNCTION Saldo_comunidad_hasta(v_IdC IN comunidades.idc%TYPE, fechafin DATE) RETURN NUMBER
IS
    v_saldo NUMBER;
    v_saldoInicial NUMBER;
    v_pagos NUMBER;
    v_facturas NUMBER;
BEGIN
    SELECT saldoInicial INTO v_saldoInicial FROM Comunidades WHERE IdC=v_IdC;
    SELECT SUM(cantidad) INTO v_pagos FROM Pagos WHERE IdC=v_IdC AND fechapago<=fechafin;
    SELECT SUM(importe) INTO v_facturas FROM Facturas WHERE IdC=v_IdC AND fechaemision<=fechafin;
    v_saldo := v_saldoInicial+v_pagos-v_facturas;
    RETURN v_saldo;
END saldo_comunidad_hasta;
/

-- Saldo de todas las comunidades
CREATE OR REPLACE PROCEDURE saldo_comunidades
IS
    CURSOR c_comunidades IS
        SELECT IdC, direccion, saldoInicial FROM Comunidades;
    v_comunidades c_comunidades%ROWTYPE;
    v_ingresos number;
    v_gastos number;
        
BEGIN
    OPEN c_comunidades;
    FETCH c_comunidades into v_comunidades;
    DBMS_OUTPUT.PUT_LINE('Saldo de las comunidades:');
    DBMS_OUTPUT.PUT_LINE(RPAD('Comunidad:', 100) || RPAD('Saldo:', 25));
    DBMS_OUTPUT.PUT_LINE(LPAD('-', 135, '-'));
    WHILE c_comunidades%FOUND LOOP
       SELECT COALESCE(SUM(cantidad),0) INTO v_ingresos FROM Pagos WHERE IdC=v_comunidades.IdC;
       SELECT COALESCE(SUM(importe),0) INTO v_gastos FROM Facturas WHERE IdC=v_comunidades.IdC;
       DBMS_OUTPUT.PUT_LINE(RPAD(v_comunidades.direccion, 100) || RPAD(v_comunidades.saldoInicial+v_ingresos-v_gastos, 25));
       FETCH c_comunidades into v_comunidades;
    END LOOP;
CLOSE c_comunidades;
END;
/
--RF 002 Facturas de una comunidad
--Revisar porque no sé si está corecto
CREATE OR REPLACE PROCEDURE Facturas_Periodo(FechaInicio In facturas.fechaemision%TYPE, FechaFin IN facturas.fechaemision%TYPE, v_IdC IN Comunidades.IdC%TYPE)
IS

    CURSOR C IS
        SELECT nombre, importe, fechaemision FROM Empresas NATURAL JOIN Facturas WHERE FechaInicio<=fechaemision and fechaemision<=FechaFin;
        v_facturas C%ROWTYPE;
        v_comunidad VARCHAR2(50);
BEGIN
    OPEN C;
    SELECT direccion INTO v_comunidad FROM comunidades WHERE IdC=v_IdC;
    FETCH C INTO v_facturas;
    DBMS_OUTPUT.PUT_LINE('Facturas de la comunidad ' || v_comunidad || ' del ' || fechaInicio || ' a ' || fechaFin || ':');
    DBMS_OUTPUT.PUT_LINE(RPAD('Empresa:', 100) || RPAD('Importe:', 25) || RPAD('Fecha de la factura:', 25));
    DBMS_OUTPUT.PUT_LINE(LPAD('-', 135, '-'));
    WHILE C%FOUND LOOP 
        DBMS_OUTPUT.PUT_LINE(RPAD(v_facturas.nombre, 100) || RPAD(v_facturas.importe, 25) || RPAD(v_facturas.fechaemision, 25));
        FETCH C INTO v_facturas;
	END LOOP;
	CLOSE C;
END Facturas_Periodo;
/

--RF 003 Pagos a una comunidad
CREATE OR REPLACE PROCEDURE Pagos_Periodo(FechaInicio IN pagos.fechapago%TYPE, FechaFin IN pagos.fechapago%TYPE, v_IdC IN Comunidades.IdC%TYPE)
IS
CURSOR C IS
        SELECT Nombreap, cantidad, fechapago FROM Propietarios NATURAL JOIN Pagos WHERE FechaInicio<=fechapago and fechapago<=FechaFin AND IdC=v_IdC;
        v_pagos c%ROWTYPE;
        v_comunidad VARCHAR2(50);
BEGIN
    OPEN C;
    SELECT direccion INTO v_comunidad FROM comunidades WHERE IdC=v_IdC;
    FETCH C INTO v_pagos;
    DBMS_OUTPUT.PUT_LINE('Pagos de los propietarios de la comunidad ' || v_comunidad || ' entre el ' || fechaInicio || ' y el ' || fechaFin || ':');
    DBMS_OUTPUT.PUT_LINE(RPAD('Propietario:', 100) || RPAD('Cantidad pagada:', 25) || RPAD('Fecha del pago:', 25));
    DBMS_OUTPUT.PUT_LINE(LPAD('-', 135, '-'));
    WHILE C%FOUND LOOP 
		DBMS_OUTPUT.PUT_LINE(RPAD(v_pagos.nombreap, 100) || RPAD(v_pagos.cantidad, 25) || RPAD(v_pagos.fechaPago, 25));
        FETCH C INTO v_pagos;
	END LOOP;
	CLOSE C;
END Pagos_Periodo;
/

-- RF 005
CREATE OR REPLACE PROCEDURE Morosos(IdComunidad IN Comunidades.IdC%TYPE)
--SELECT SUM(cantidad),SUM(PagoExigido),IdC,IdP FROM Pagos,Coutas WHERE IdComunidad=IdC GROUP BY IdP;
IS 	
	CURSOR C IS
		SELECT IdP, nombreap FROM Propietarios NATURAL JOIN Pertenece WHERE IdC=IdComunidad;
	 v_morosos C%ROWTYPE;
     pagado number;
     exigido number;
     v_comunidad VARCHAR2(50);
BEGIN
	OPEN C;
    SELECT direccion INTO v_comunidad FROM comunidades WHERE IdC=IdComunidad;
	FETCH C INTO v_morosos;
    DBMS_OUTPUT.PUT_LINE('Morosidad de los propietarios de la comunidad ' || v_comunidad ||':');
    DBMS_OUTPUT.PUT_LINE(RPAD('Propietario:', 100) || RPAD('Cantidad debida:', 25));
    DBMS_OUTPUT.PUT_LINE(LPAD('-', 135, '-'));
	WHILE C%FOUND LOOP
        SELECT COALESCE(SUM(cantidad),0) INTO pagado FROM Pagos WHERE IdC=idcomunidad AND IdP=v_morosos.idp;
        SELECT COALESCE(SUM(pagoexigido),0) INTO exigido FROM Cuotas WHERE IdC=idcomunidad AND IdP=v_morosos.idp;
		DBMS_OUTPUT.PUT_LINE(RPAD(v_morosos.nombreap, 100) || RPAD(exigido-pagado, 25));
        FETCH C INTO v_morosos;
	END LOOP;  
	CLOSE C;
END Morosos;
/

CREATE OR REPLACE PROCEDURE Morosos_hasta(IdComunidad IN Comunidades.IdC%TYPE, fechafin DATE)
--SELECT SUM(cantidad),SUM(PagoExigido),IdC,IdP FROM Pagos,Coutas WHERE IdComunidad=IdC GROUP BY IdP;
IS 	
	CURSOR C IS
		SELECT IdP, nombreap FROM Propietarios NATURAL JOIN Pertenece WHERE IdC=IdComunidad;
	 v_morosos C%ROWTYPE;
     pagado number;
     exigido number;
     v_comunidad VARCHAR2(50);
BEGIN
	OPEN C;
    SELECT direccion INTO v_comunidad FROM comunidades WHERE IdC=IdComunidad;
	FETCH C INTO v_morosos;
    DBMS_OUTPUT.PUT_LINE('Morosidad de los propietarios de la comunidad ' || v_comunidad ||':');
    DBMS_OUTPUT.PUT_LINE(RPAD('Propietario:', 100) || RPAD('Cantidad debida:', 25));
    DBMS_OUTPUT.PUT_LINE(LPAD('-', 135, '-'));
	WHILE C%FOUND LOOP
        SELECT COALESCE(SUM(cantidad),0) INTO pagado FROM Pagos WHERE IdC=idcomunidad AND IdP=v_morosos.idp AND fechapago<fechafin;
        SELECT COALESCE(SUM(pagoexigido),0) INTO exigido FROM Cuotas WHERE IdC=idcomunidad AND IdP=v_morosos.idp AND mes<fechafin;
		DBMS_OUTPUT.PUT_LINE(RPAD(v_morosos.nombreap, 100) || RPAD(exigido-pagado, 25));
        FETCH C INTO v_morosos;
	END LOOP;  
	CLOSE C;
END Morosos_hasta;
/

-- RF 004
CREATE OR REPLACE PROCEDURE Estadillo(FechaInicio IN pagos.fechapago%TYPE, FechaFin IN pagos.fechapago%TYPE, v_IdC IN Comunidades.IdC%TYPE)
IS
    v_comunidad VARCHAR(50);
BEGIN
SELECT direccion INTO v_comunidad FROM Comunidades WHERE IdC=v_IdC;
DBMS_OUTPUT.PUT_LINE('Estadillo de la comunidad ' || v_comunidad || ' del ' || fechaInicio || ' a ' || fechaFin || ':');
dbms_output.put_line(chr(10));
morosos_hasta(v_IdC,fechafin);
dbms_output.put_line(chr(10));
facturas_periodo(fechainicio,fechafin,v_idc);
dbms_output.put_line(chr(10));
dbms_output.put_line('Saldo de la comunidad: ' || saldo_comunidad_hasta(1,fechafin));
END;
/

-- RF-006
CREATE OR REPLACE PROCEDURE contratos_de_comunidad(v_idc IN comunidades.idc%TYPE)
IS
    CURSOR contratos_comunidad IS
        SELECT nombre, fechainicio, fechafin FROM contratos NATURAL JOIN empresas WHERE IdC=v_IdC;
    v_contrato contratos_comunidad%ROWTYPE;
    v_comunidad VARCHAR2(50);
BEGIN
    OPEN contratos_comunidad;
    SELECT direccion INTO v_comunidad FROM comunidades WHERE IdC=v_IdC;
    FETCH contratos_comunidad INTO v_contrato;
    DBMS_OUTPUT.PUT_LINE('Contratos para la comunidad ' || v_comunidad ||':');
    DBMS_OUTPUT.PUT_LINE(RPAD('Empresa:', 100) || RPAD('Fecha de inicio:', 25) || RPAD('Fecha de fin:', 25));
    DBMS_OUTPUT.PUT_LINE(LPAD('-', 135, '-'));
    WHILE contratos_comunidad%FOUND LOOP
        DBMS_OUTPUT.PUT_LINE(RPAD(v_contrato.nombre, 100) || RPAD(v_contrato.fechainicio, 25) || RPAD(v_contrato.fechafin, 25));
        FETCH contratos_comunidad INTO v_contrato;
    END LOOP;
    CLOSE contratos_comunidad;
END;
/

-- RF-007
CREATE OR REPLACE PROCEDURE BalancePresupuesto(v_IdPresupuesto IN Presupuestos.IdPresupuesto%TYPE)
IS
    CURSOR C IS
        SELECT IdC, FechaAplicacion, Servicio, Cantidad FROM Presupuestos NATURAL JOIN Conceptos WHERE IdPresupuesto=v_IdPresupuesto;
    v_concepto C%ROWTYPE;
    v_presupuesto VARCHAR2(50);
    gastado number;
    comprobacion boolean;
BEGIN
    OPEN C;
    FETCH C INTO v_concepto;
    SELECT motivo INTO v_presupuesto FROM Presupuestos WHERE IdPresupuesto=v_IdPresupuesto;
    DBMS_OUTPUT.PUT_LINE('Comprobacion del presupuesto ' || v_presupuesto || ':');
    DBMS_OUTPUT.PUT_LINE(RPAD('Servicio',25) || RPAD('Presupuestado', 25) || RPAD('Gastado', 25) || RPAD('Estado', 25));
    DBMS_OUTPUT.PUT_LINE(LPAD('-', 135, '-'));
    WHILE C%FOUND LOOP
        SELECT COALESCE(SUM(importe),0) INTO gastado FROM Facturas WHERE IdC=v_concepto.IdC AND TipoServicio=v_concepto.Servicio AND fechaemision>=v_concepto.fechaaplicacion;
        comprobacion := (v_concepto.cantidad-gastado)<0;
        IF comprobacion THEN
            DBMS_OUTPUT.PUT_LINE(RPAD(v_concepto.servicio,25) || RPAD(v_concepto.cantidad, 25) || RPAD(gastado, 25) || RPAD('Presupuesto superado', 25));
        ELSE
            DBMS_OUTPUT.PUT_LINE(RPAD(v_concepto.servicio,25) || RPAD(v_concepto.cantidad, 25) || RPAD(gastado, 25) || RPAD('Presupuesto correcto', 25));
        END IF;
        FETCH C INTO v_concepto;
    END LOOP;
    CLOSE C;
END;
/

-- RF-008
CREATE OR REPLACE PROCEDURE nueva_cuota(v_mes IN cuotas.mes%TYPE, v_pagoexigido IN cuotas.pagoexigido%TYPE, v_IdC IN cuotas.idc%TYPE)
IS
    CURSOR c1 is
        SELECT IdP FROM pertenece WHERE IdC=v_idc;
BEGIN
    FOR propietario IN c1 LOOP
        INSERT INTO Cuotas (mes,pagoexigido,idp,idc) VALUES (v_mes, v_pagoexigido, propietario.IdP, v_IdC);
    END LOOP;
END;
/
-- RF 009
CREATE OR REPLACE PROCEDURE Contratos_Empresa
IS 
    CURSOR C IS
        SELECT  IDEMPRESA ,COUNT(*) AS counti FROM Contratos NATURAL JOIN Empresas GROUP BY IDEMPRESA ORDER BY counti DESC;
        v_empresa varchar(50);
BEGIN 
    DBMS_OUTPUT.PUT_LINE('Contratos con una empresa' ||  ':');
    DBMS_OUTPUT.PUT_LINE(RPAD('Empresa',25) || RPAD('Contratos', 25));
    DBMS_OUTPUT.PUT_LINE(LPAD('-', 135, '-'));
    FOR CR1 IN C LOOP
        SELECT NOMBRE INTO v_empresa FROM EMPRESAS where idempresa=cr1.idempresa ;
        dbms_output.put_line( RPAD(v_empresa,25) || RPAD(cr1.counti,25));
    END LOOP;
    
END Contratos_Empresa;
/
--RF 010
CREATE OR REPLACE PROCEDURE Pisos_Propietarios
IS 
    CURSOR C IS 
        SELECT pisos.pisoletra,pisos.idp,pisos.idc FROM PISOS ORDER BY pisos.idc DESC;
        v_nombre varchar(50);
        v_direccion varchar(50);
BEGIN 
    DBMS_OUTPUT.PUT_LINE('Pisos de Propietarios ' || ':');
    DBMS_OUTPUT.PUT_LINE(RPAD('Propietarios',35) || RPAD('Piso y Letra', 35) || RPAD('Comunidad',35));
    DBMS_OUTPUT.PUT_LINE(LPAD('-', 100 , '-'));
    FOR CR2 IN C LOOP
        SELECT NOMBREAP INTO v_nombre FROM Propietarios where IDP=cr2.idp;
        SELECT DIRECCION INTO v_direccion FROM Comunidades where IDC=cr2.idc;
        dbms_output.put_line( RPAD(v_nombre,35 )||RPAD(cr2.pisoletra,35)|| RPAD(v_direccion,35));
    END LOOP;
END Pisos_Propietarios;
/
--RF 011
CREATE OR REPLACE PROCEDURE FacturasSuperiorA(v_umbral IN number)
IS
   CURSOR C IS 
    SELECT facturas.importe, facturas.idc FROM Facturas GROUP BY facturas.importe,facturas.idc HAVING MAX(facturas.importe)>v_umbral ORDER BY facturas.idc DESC ;
    v_direccion varchar(50);
BEGIN 
    DBMS_OUTPUT.PUT_LINE('Factura superior a importe  ' || v_umbral || ':');
    DBMS_OUTPUT.PUT_LINE(RPAD('Comunidad',35) || RPAD('Importe', 35) );
    DBMS_OUTPUT.PUT_LINE(LPAD('-', 50 , '-'));
   FOR CR2 IN C LOOP
        SELECT direccion INTO v_direccion FROM Comunidades where IDC=cr2.idc;
        dbms_output.put_line( RPAD(v_direccion,35 )||RPAD(cr2.importe,35));
   END LOOP;
END FacturasSuperiorA;
/

-- RN-002
CREATE OR REPLACE TRIGGER fecha_presupuestos
BEFORE INSERT OR UPDATE ON Presupuestos
FOR EACH ROW
BEGIN
IF (:NEW.FechaAprobacion IS NOT NULL AND :NEW.FechaAplicacion IS NOT NULL AND :NEW.FechaAplicacion<:NEW.FechaAprobacion) THEN
    raise_application_error(-20002,:NEW.FechaAprobacion||' La fecha de aprobación del presupuesto debe ser anterior a la fecha de aplicación.');
END IF;
END;
/


-- RN-003
CREATE OR REPLACE TRIGGER presidente_en_comunidad
BEFORE INSERT OR UPDATE ON Comunidades
FOR EACH ROW
DECLARE
    Comun_presidente INTEGER;
BEGIN
IF (:NEW.presidente IS NOT NULL) THEN
    SELECT IdC INTO Comun_presidente FROM Pertenece WHERE IdP = :NEW.Presidente;
    IF (Comun_presidente<>:NEW.IdC) THEN
        raise_application_error(-20003,:NEW.Presidente||' El presidente de la comunidad debe ser propietario de la misma.');
    END IF;
END IF;
END;
/

-- RN-004
CREATE OR REPLACE TRIGGER pisos_no_repetidos
BEFORE INSERT OR UPDATE ON Pisos
FOR EACH ROW
DECLARE
    piso_actual VARCHAR2(50);
    existe number;
BEGIN
     SELECT COUNT(*) INTO existe FROM Pisos WHERE IdC=:NEW.IdC AND Pisoletra=:NEW.pisoletra;
    IF (existe<>0) THEN
        raise_application_error(-20004,:NEW.PisoLetra||' El nuevo propietario tiene un piso que ya posee otro propietario');
    END IF;
END;
/

-- RN-005

CREATE OR REPLACE TRIGGER cuotas_para_propietarios
BEFORE INSERT OR UPDATE ON Cuotas
FOR EACH ROW
DECLARE
    Comun_propietario NUMBER;
BEGIN
IF (:NEW.IdP IS NOT NULL) THEN
    SELECT COUNT(*) INTO Comun_propietario FROM Pertenece WHERE IdP=:NEW.IdP AND IdC=:NEW.IdC;
    IF (Comun_propietario=0) THEN
        raise_application_error(-20005,:NEW.IdP||' El propietario debe pertenecer a la comunidad para aplicarle la cuota.');
    END IF;
END IF;
END;
/

CREATE OR REPLACE TRIGGER pagos_para_propietarios
BEFORE INSERT OR UPDATE ON Pagos
FOR EACH ROW
DECLARE
    Comun_propietario INTEGER;
BEGIN
IF (:NEW.IdP IS NOT NULL) THEN
    SELECT COUNT(*) INTO Comun_propietario FROM Pertenece WHERE IdP=:NEW.IdP AND IdC=:NEW.IdC;
    IF (Comun_propietario=0) THEN
        raise_application_error(-20005,:NEW.IdP||' El propietario debe pertenecer a la comunidad para registrar el pago.');
    END IF;
END IF;
END;
/

ALTER TRIGGER fecha_presupuestos ENABLE;
ALTER TRIGGER presidente_en_comunidad ENABLE;
ALTER TRIGGER pisos_no_repetidos ENABLE;
ALTER TRIGGER cuotas_para_propietarios ENABLE;
ALTER TRIGGER pagos_para_propietarios ENABLE;



CREATE OR REPLACE FUNCTION ASSERT_EQUALS (v_Salida BOOLEAN, salidaEsperada BOOLEAN)
RETURN VARCHAR2
IS
BEGIN
	IF v_Salida = salidaEsperada THEN
		RETURN 'ÉXITO';
	ELSE
		RETURN 'FALLO';
	END IF;
END;
/


-- Tabla Comunidades
CREATE OR REPLACE PACKAGE PCK_comunidades
IS
PROCEDURE Inicializar;
PROCEDURE Insertar (nombrePrueba VARCHAR2, v_direccion IN comunidades.direccion%TYPE, v_numeroPropietarios IN comunidades.numeropropietarios%TYPE, v_cuentaCorriente IN comunidades.cuentacorriente%TYPE, v_saldoInicial IN comunidades.saldoInicial%TYPE, v_presidente IN comunidades.presidente%TYPE, salidaEsperada BOOLEAN);
PROCEDURE Actualizar (nombrePrueba VARCHAR2, v_IdC IN comunidades.idc%TYPE, v_direccion IN comunidades.direccion%TYPE, v_numeroPropietarios IN comunidades.numeropropietarios%TYPE, v_cuentaCorriente IN comunidades.cuentacorriente%TYPE, v_saldoInicial IN comunidades.saldoInicial%TYPE, v_presidente IN comunidades.presidente%TYPE, salidaEsperada BOOLEAN);
PROCEDURE Eliminar (nombrePrueba VARCHAR2, v_IdC IN comunidades.idc%TYPE, salidaEsperada BOOLEAN);
END;
/

-- Tabla Conceptos
CREATE OR REPLACE PACKAGE PCK_conceptos
IS
PROCEDURE Inicializar;
PROCEDURE Insertar (nombrePrueba VARCHAR2, v_nombre IN conceptos.nombre%TYPE, v_cantidad IN conceptos.cantidad%TYPE, v_servicio IN conceptos.servicio%TYPE, v_IdPresupuesto IN conceptos.idpresupuesto%TYPE, salidaEsperada BOOLEAN);
PROCEDURE Actualizar (nombrePrueba VARCHAR2, v_IdConcepto IN conceptos.idconcepto%TYPE, v_nombre IN conceptos.nombre%TYPE, v_cantidad IN conceptos.cantidad%TYPE, v_servicio IN conceptos.servicio%TYPE, v_IdPresupuesto IN conceptos.idpresupuesto%TYPE, salidaEsperada BOOLEAN);
PROCEDURE Eliminar (nombrePrueba VARCHAR2, v_IdConcepto IN conceptos.idconcepto%TYPE, salidaEsperada BOOLEAN);
END;
/

-- Tabla Contratos
CREATE OR REPLACE PACKAGE PCK_contratos
IS
PROCEDURE Inicializar;
PROCEDURE Insertar (nombrePrueba VARCHAR2, v_fechaInicio IN contratos.fechainicio%TYPE, v_fechaFin IN contratos.fechafin%TYPE, v_IdC IN contratos.idc%TYPE, v_IdEmpresa IN contratos.idempresa%TYPE, salidaEsperada BOOLEAN);
PROCEDURE Actualizar (nombrePrueba VARCHAR2, v_IdContrato IN contratos.idcontrato%TYPE, v_fechaInicio IN contratos.fechainicio%TYPE, v_fechaFin IN contratos.fechafin%TYPE, v_IdC IN contratos.idc%TYPE, v_IdEmpresa IN contratos.idempresa%TYPE, salidaEsperada BOOLEAN);
PROCEDURE Eliminar (nombrePrueba VARCHAR2, v_IdContrato IN contratos.idcontrato%TYPE, salidaEsperada BOOLEAN);
END;
/

-- Tabla Cuotas
CREATE OR REPLACE PACKAGE PCK_cuotas
IS
PROCEDURE Inicializar;
PROCEDURE Insertar (nombrePrueba VARCHAR2, v_mes IN cuotas.mes%TYPE, v_pagoExigido IN cuotas.pagoexigido%TYPE, v_IdP IN cuotas.idp%TYPE, v_IdC IN cuotas.idc%TYPE, salidaEsperada BOOLEAN);
PROCEDURE Actualizar (nombrePrueba VARCHAR2, v_IdCuota IN cuotas.idcuota%TYPE, v_mes IN cuotas.mes%TYPE, v_pagoExigido IN cuotas.pagoexigido%TYPE, v_IdP IN cuotas.idp%TYPE, v_IdC IN cuotas.idc%TYPE, salidaEsperada BOOLEAN);
PROCEDURE Eliminar (nombrePrueba VARCHAR2, v_IdCuota IN cuotas.idcuota%TYPE, salidaEsperada BOOLEAN);
END;
/

-- Tabla Empresas
CREATE OR REPLACE PACKAGE PCK_empresas
IS
PROCEDURE Inicializar;
PROCEDURE Insertar (nombrePrueba VARCHAR2, v_nombre IN empresas.nombre%TYPE, v_direccion IN empresas.direccion%TYPE, v_telf IN empresas.telf%TYPE, salidaEsperada BOOLEAN);
PROCEDURE Actualizar (nombrePrueba VARCHAR2, v_IdEmpresa IN empresas.idempresa%TYPE, v_nombre IN empresas.nombre%TYPE, v_direccion IN empresas.direccion%TYPE, v_telf IN empresas.telf%TYPE, salidaEsperada BOOLEAN);
PROCEDURE Eliminar (nombrePrueba VARCHAR2, v_IdEmpresa IN empresas.idempresa%TYPE, salidaEsperada BOOLEAN);
END;
/

-- Tabla Facturas
CREATE OR REPLACE PACKAGE PCK_facturas
IS
PROCEDURE Inicializar;
PROCEDURE Insertar (nombrePrueba VARCHAR2, v_importe IN facturas.importe%TYPE, v_fechaEmision IN facturas.fechaemision%TYPE, v_tipoServicio IN facturas.tiposervicio%TYPE, v_IdC IN facturas.idc%TYPE, v_IdEmpresa IN facturas.idempresa%TYPE, salidaEsperada BOOLEAN);
PROCEDURE Actualizar (nombrePrueba VARCHAR2, v_IdFactura IN facturas.idfactura%TYPE, v_importe IN facturas.importe%TYPE, v_fechaEmision IN facturas.fechaemision%TYPE, v_tipoServicio IN facturas.tiposervicio%TYPE, v_IdC IN facturas.idc%TYPE, v_IdEmpresa IN facturas.idempresa%TYPE, salidaEsperada BOOLEAN);
PROCEDURE Eliminar (nombrePrueba VARCHAR2, v_IdFactura IN facturas.idfactura%TYPE, salidaEsperada BOOLEAN);
END;
/

-- Tabla Pagos
CREATE OR REPLACE PACKAGE PCK_pagos
IS
PROCEDURE Inicializar;
PROCEDURE Insertar (nombrePrueba VARCHAR2, v_cantidad IN pagos.cantidad%TYPE, v_fechaPago IN pagos.fechapago%TYPE, v_IdP IN pagos.idp%TYPE, v_IdC IN pagos.idc%TYPE, salidaEsperada BOOLEAN);
PROCEDURE Actualizar (nombrePrueba VARCHAR2, v_IdPago IN pagos.idpago%TYPE, v_cantidad IN pagos.cantidad%TYPE, v_fechaPago IN pagos.fechapago%TYPE, v_IdP IN pagos.idp%TYPE, v_IdC IN pagos.idc%TYPE, salidaEsperada BOOLEAN);
PROCEDURE Eliminar (nombrePrueba VARCHAR2, v_IdPago IN pagos.idpago%TYPE, salidaEsperada BOOLEAN);
END;
/

-- Tabla Pertenece
CREATE OR REPLACE PACKAGE PCK_pertenece
IS
PROCEDURE Inicializar;
PROCEDURE Insertar (nombrePrueba VARCHAR2, v_IdC IN pertenece.idc%TYPE, v_IdP IN pertenece.idp%TYPE, salidaEsperada BOOLEAN);
PROCEDURE Actualizar (nombrePrueba VARCHAR2, v_IdPert IN pertenece.idpert%TYPE, v_IdC IN pertenece.idc%TYPE, v_IdP IN pertenece.idp%TYPE, salidaEsperada BOOLEAN);
PROCEDURE Eliminar (nombrePrueba VARCHAR2, v_IdPert IN pertenece.idpert%TYPE, salidaEsperada BOOLEAN);
END;
/

-- Tabla Pisos
CREATE OR REPLACE PACKAGE PCK_pisos
IS
PROCEDURE Inicializar;
PROCEDURE Insertar (nombrePrueba VARCHAR2, v_pisoLetra IN pisos.pisoletra%TYPE, v_IdP IN pisos.idp%TYPE, v_IdC IN pisos.IdC%TYPE, salidaEsperada BOOLEAN);
PROCEDURE Actualizar (nombrePrueba VARCHAR2, v_IdPiso IN pisos.idpiso%TYPE, v_pisoLetra IN pisos.pisoletra%TYPE, v_IdP IN pisos.idp%TYPE, v_IdC IN pisos.IdC%TYPE, salidaEsperada BOOLEAN);
PROCEDURE Eliminar (nombrePrueba VARCHAR2, v_IdPiso IN pisos.idpiso%TYPE, salidaEsperada BOOLEAN);
END;
/

-- Tabla Presupuesto
CREATE OR REPLACE PACKAGE PCK_presupuestos
IS
PROCEDURE Inicializar;
PROCEDURE Insertar (nombrePrueba VARCHAR2, v_fechaAprobacion IN presupuestos.fechaaprobacion%TYPE, v_fechaAplicacion IN presupuestos.fechaaplicacion%TYPE, v_motivo IN presupuestos.motivo%TYPE, v_IdC IN presupuestos.idc%TYPE, salidaEsperada BOOLEAN);
PROCEDURE Actualizar (nombrePrueba VARCHAR2, v_IdPresupuesto IN presupuestos.idpresupuesto%TYPE, v_fechaAprobacion IN presupuestos.fechaaprobacion%TYPE, v_fechaAplicacion IN presupuestos.fechaaplicacion%TYPE, v_motivo IN presupuestos.motivo%TYPE, v_IdC IN presupuestos.idc%TYPE, salidaEsperada BOOLEAN);
PROCEDURE Eliminar (nombrePrueba VARCHAR2, v_IdPresupuesto IN presupuestos.idpresupuesto%TYPE, salidaEsperada BOOLEAN);
END;
/

-- Tabla Propietarios
CREATE OR REPLACE PACKAGE PCK_propietarios
IS
PROCEDURE Inicializar;
PROCEDURE Insertar (nombrePrueba VARCHAR2, v_nombreAp IN propietarios.nombreap%TYPE, v_dni IN propietarios.dni%TYPE, v_telefono IN propietarios.telefono%TYPE, v_email IN propietarios.email%TYPE, salidaEsperada BOOLEAN);
PROCEDURE Actualizar (nombrePrueba VARCHAR2, v_IdP IN propietarios.idp%TYPE, v_nombreAp IN propietarios.nombreap%TYPE, v_dni IN propietarios.dni%TYPE, v_telefono IN propietarios.telefono%TYPE, v_email IN propietarios.email%TYPE, salidaEsperada BOOLEAN);
PROCEDURE Eliminar (nombrePrueba VARCHAR2, v_IdP IN propietarios.idp%TYPE, salidaEsperada BOOLEAN);
END;
/

-- CUERPOS DE PAQUETES

-- Tabla Comunidades
CREATE OR REPLACE PACKAGE BODY PCK_comunidades
IS
PROCEDURE Inicializar
	IS
	BEGIN
		DELETE FROM Comunidades;
	END Inicializar;

PROCEDURE Insertar (nombrePrueba VARCHAR2, v_direccion IN comunidades.direccion%TYPE, v_numeroPropietarios IN comunidades.numeropropietarios%TYPE, v_cuentaCorriente IN comunidades.cuentacorriente%TYPE, v_saldoInicial IN comunidades.saldoInicial%TYPE, v_presidente IN comunidades.presidente%TYPE, salidaEsperada BOOLEAN)
	IS
		v_IdC comunidades.idc%TYPE;
        v_Comunidad Comunidades%ROWTYPE;
        v_salida BOOLEAN := true;
	BEGIN
		INSERT INTO Comunidades (Direccion, numeropropietarios, cuentacorriente, saldoInicial, presidente) VALUES (v_direccion, v_numeroPropietarios, v_cuentaCorriente, v_saldoInicial, v_presidente);
		v_IdC := SEQ_COMUNIDAD.currval;
		SELECT * INTO v_Comunidad FROM Comunidades WHERE IdC = v_IdC;
		IF (v_direccion<>v_comunidad.direccion OR v_numeroPropietarios<>v_comunidad.numeroPropietarios OR v_cuentaCorriente<>v_comunidad.cuentaCorriente OR v_saldoinicial<>v_comunidad.saldoInicial OR v_presidente<>v_comunidad.presidente) THEN
			v_Salida := FALSE;
		END IF;
		COMMIT;
		DBMS_OUTPUT.PUT_LINE(nombrePrueba || ': ' || ASSERT_EQUALS(v_Salida, salidaEsperada));
		EXCEPTION
			WHEN OTHERS THEN
				DBMS_OUTPUT.PUT_LINE(nombrePrueba || ': ' || ASSERT_EQUALS(FALSE, salidaEsperada));
				ROLLBACK;
	END Insertar;
    
PROCEDURE Actualizar (nombrePrueba VARCHAR2, v_IdC IN comunidades.idc%TYPE, v_direccion IN comunidades.direccion%TYPE, v_numeroPropietarios IN comunidades.numeropropietarios%TYPE, v_cuentaCorriente IN comunidades.cuentacorriente%TYPE, v_saldoInicial IN comunidades.saldoInicial%TYPE, v_presidente IN comunidades.presidente%TYPE, salidaEsperada BOOLEAN)
	IS
        v_Comunidad Comunidades%ROWTYPE;
        v_salida BOOLEAN := true;
	BEGIN
		UPDATE Comunidades SET Direccion = v_direccion, numeroPropietarios = v_numeroPropietarios, cuentaCorriente = v_cuentacorriente, saldoInicial=v_saldoInicial, presidente=v_presidente WHERE IdC = v_IdC;
		SELECT * INTO v_Comunidad FROM Comunidades WHERE IdC = v_IdC;
		IF (v_direccion<>v_comunidad.direccion OR v_numeroPropietarios<>v_comunidad.numeroPropietarios OR v_cuentaCorriente<>v_comunidad.cuentaCorriente OR v_saldoinicial<>v_comunidad.saldoInicial OR v_presidente<>v_comunidad.presidente) THEN
			v_Salida := FALSE;
		END IF;
		COMMIT;
		DBMS_OUTPUT.PUT_LINE(nombrePrueba || ': ' || ASSERT_EQUALS(v_Salida, salidaEsperada));
		EXCEPTION
			WHEN OTHERS THEN
				DBMS_OUTPUT.PUT_LINE(nombrePrueba || ': ' || ASSERT_EQUALS(FALSE, salidaEsperada));
				ROLLBACK;
	END Actualizar;
    
PROCEDURE Eliminar (nombrePrueba VARCHAR2, v_IdC IN comunidades.idc%TYPE, salidaEsperada BOOLEAN)
	IS
		v_NumComunidades NUMBER := 0;
        v_salida BOOLEAN := true;
	BEGIN
		DELETE FROM Comunidades WHERE IdC = v_IdC;
		SELECT COUNT(*) INTO v_NumComunidades FROM Comunidades WHERE IdC = v_IdC;
		IF v_NumComunidades != 0 THEN
			v_Salida := FALSE;
		END IF;
		COMMIT;
		DBMS_OUTPUT.PUT_LINE(nombrePrueba || ': ' || ASSERT_EQUALS(v_Salida, salidaEsperada));
		EXCEPTION
			WHEN OTHERS THEN
				DBMS_OUTPUT.PUT_LINE(nombrePrueba || ': ' || ASSERT_EQUALS(FALSE, salidaEsperada));
				ROLLBACK;
	END Eliminar;
END;
/

-- Tabla Conceptos
CREATE OR REPLACE PACKAGE BODY PCK_conceptos
IS
PROCEDURE Inicializar
	IS
	BEGIN
		DELETE FROM Conceptos;
	END Inicializar;
    
PROCEDURE Insertar (nombrePrueba VARCHAR2, v_nombre IN conceptos.nombre%TYPE, v_cantidad IN conceptos.cantidad%TYPE, v_servicio IN conceptos.servicio%TYPE, v_IdPresupuesto IN conceptos.idpresupuesto%TYPE, salidaEsperada BOOLEAN)
	IS
		v_IdConcepto conceptos.idconcepto%TYPE;
        v_Concepto Conceptos%ROWTYPE;
        v_salida BOOLEAN := true;
	BEGIN
		INSERT INTO Conceptos (Nombre, Cantidad, servicio, idpresupuesto) VALUES (v_nombre, v_cantidad, v_servicio, v_IdPresupuesto);
		v_IdConcepto := SEQ_CONCEPTO.currval;
		SELECT * INTO v_Concepto FROM Conceptos WHERE IdConcepto = v_IdConcepto;
		IF (v_nombre<>v_Concepto.nombre OR v_cantidad<>v_concepto.cantidad OR v_servicio<>v_Concepto.servicio OR v_idpresupuesto<>v_Concepto.IdPresupuesto) THEN
			v_Salida := FALSE;
		END IF;
		COMMIT;
		DBMS_OUTPUT.PUT_LINE(nombrePrueba || ': ' || ASSERT_EQUALS(v_Salida, salidaEsperada));
		EXCEPTION
			WHEN OTHERS THEN
				DBMS_OUTPUT.PUT_LINE(nombrePrueba || ': ' || ASSERT_EQUALS(FALSE, salidaEsperada));
				ROLLBACK;
	END Insertar;

PROCEDURE Actualizar (nombrePrueba VARCHAR2, v_IdConcepto IN conceptos.idconcepto%TYPE, v_nombre IN conceptos.nombre%TYPE, v_cantidad IN conceptos.cantidad%TYPE, v_servicio IN conceptos.servicio%TYPE, v_IdPresupuesto IN conceptos.idpresupuesto%TYPE, salidaEsperada BOOLEAN)
	IS
        v_Concepto Conceptos%ROWTYPE;
        v_salida BOOLEAN := true;
	BEGIN
		UPDATE Conceptos SET nombre=v_nombre, cantidad=v_cantidad, servicio=v_servicio, idpresupuesto=v_idpresupuesto WHERE IdConcepto = v_IdConcepto;
		SELECT * INTO v_Concepto FROM Conceptos WHERE IdConcepto = v_IdConcepto;
		IF (v_nombre<>v_Concepto.nombre OR v_cantidad<>v_concepto.cantidad OR v_servicio<>v_Concepto.servicio OR v_idpresupuesto<>v_Concepto.IdPresupuesto) THEN
			v_Salida := FALSE;
		END IF;
		COMMIT;
		DBMS_OUTPUT.PUT_LINE(nombrePrueba || ': ' || ASSERT_EQUALS(v_Salida, salidaEsperada));
		EXCEPTION
			WHEN OTHERS THEN
				DBMS_OUTPUT.PUT_LINE(nombrePrueba || ': ' || ASSERT_EQUALS(FALSE, salidaEsperada));
				ROLLBACK;
	END Actualizar;
    
PROCEDURE Eliminar (nombrePrueba VARCHAR2, v_IdConcepto IN conceptos.idconcepto%TYPE, salidaEsperada BOOLEAN)
	IS
		v_NumConceptos NUMBER := 0;
        v_salida BOOLEAN := true;
	BEGIN
		DELETE FROM Conceptos WHERE IdConcepto = v_IdConcepto;
		SELECT COUNT(*) INTO v_NumConceptos FROM Conceptos WHERE IdConcepto = v_IdConcepto;
		IF v_NumConceptos != 0 THEN
			v_Salida := FALSE;
		END IF;
		COMMIT;
		DBMS_OUTPUT.PUT_LINE(nombrePrueba || ': ' || ASSERT_EQUALS(v_Salida, salidaEsperada));
		EXCEPTION
			WHEN OTHERS THEN
				DBMS_OUTPUT.PUT_LINE(nombrePrueba || ': ' || ASSERT_EQUALS(FALSE, salidaEsperada));
				ROLLBACK;
	END Eliminar;
END;
/

-- Tabla Contratos
CREATE OR REPLACE PACKAGE BODY PCK_contratos
IS
PROCEDURE Inicializar
	IS
	BEGIN
		DELETE FROM Contratos;
	END Inicializar;
    
PROCEDURE Insertar (nombrePrueba VARCHAR2, v_fechaInicio IN contratos.fechainicio%TYPE, v_fechaFin IN contratos.fechafin%TYPE, v_IdC IN contratos.idc%TYPE, v_IdEmpresa IN contratos.idempresa%TYPE, salidaEsperada BOOLEAN)
	IS
		v_Idcontrato contratos.idcontrato%TYPE;
        v_contrato contratos%ROWTYPE;
        v_salida BOOLEAN := true;
	BEGIN
		INSERT INTO contratos (fechainicio, fechafin, idc, idempresa) VALUES (v_fechainicio, v_fechafin, v_idc, v_idempresa);
		v_Idcontrato := SEQ_CONTRATO.currval;
		SELECT * INTO v_Contrato FROM contratos WHERE IdContrato = v_IdContrato;
		IF (v_fechainicio<>v_contrato.fechainicio OR v_fechafin<>v_contrato.fechafin OR v_idc<>v_contrato.idc OR v_idempresa<>v_contrato.idempresa) THEN
			v_Salida := FALSE;
		END IF;
		COMMIT;
		DBMS_OUTPUT.PUT_LINE(nombrePrueba || ': ' || ASSERT_EQUALS(v_Salida, salidaEsperada));
		EXCEPTION
			WHEN OTHERS THEN
				DBMS_OUTPUT.PUT_LINE(nombrePrueba || ': ' || ASSERT_EQUALS(FALSE, salidaEsperada));
				ROLLBACK;
	END Insertar;

PROCEDURE Actualizar (nombrePrueba VARCHAR2, v_IdContrato IN contratos.idcontrato%TYPE, v_fechaInicio IN contratos.fechainicio%TYPE, v_fechaFin IN contratos.fechafin%TYPE, v_IdC IN contratos.idc%TYPE, v_IdEmpresa IN contratos.idempresa%TYPE, salidaEsperada BOOLEAN)
	IS
        v_contrato contratos%ROWTYPE;
        v_salida BOOLEAN := true;
	BEGIN
		UPDATE contratos SET fechainicio=v_fechainicio, fechafin=v_fechafin, idc=v_idc, idempresa=v_idempresa WHERE Idcontrato = v_Idcontrato;
		SELECT * INTO v_contrato FROM contratos WHERE Idcontrato = v_Idcontrato;
		IF (v_fechainicio<>v_contrato.fechainicio OR v_fechafin<>v_contrato.fechafin OR v_idc<>v_contrato.idc OR v_idempresa<>v_contrato.idempresa) THEN
			v_Salida := FALSE;
		END IF;
		COMMIT;
		DBMS_OUTPUT.PUT_LINE(nombrePrueba || ': ' || ASSERT_EQUALS(v_Salida, salidaEsperada));
		EXCEPTION
			WHEN OTHERS THEN
				DBMS_OUTPUT.PUT_LINE(nombrePrueba || ': ' || ASSERT_EQUALS(FALSE, salidaEsperada));
				ROLLBACK;
	END Actualizar;
    
PROCEDURE Eliminar (nombrePrueba VARCHAR2, v_IdContrato IN contratos.idcontrato%TYPE, salidaEsperada BOOLEAN)
	IS
		v_NumContratos NUMBER := 0;
        v_salida BOOLEAN := true;
	BEGIN
		DELETE FROM Contratos WHERE IdContrato = v_IdContrato;
		SELECT COUNT(*) INTO v_NumContratos FROM Contratos WHERE IdContrato = v_IdContrato;
		IF v_NumContratos != 0 THEN
			v_Salida := FALSE;
		END IF;
		COMMIT;
		DBMS_OUTPUT.PUT_LINE(nombrePrueba || ': ' || ASSERT_EQUALS(v_Salida, salidaEsperada));
		EXCEPTION
			WHEN OTHERS THEN
				DBMS_OUTPUT.PUT_LINE(nombrePrueba || ': ' || ASSERT_EQUALS(FALSE, salidaEsperada));
				ROLLBACK;
	END Eliminar;
END;
/

-- Tabla Cuotas
CREATE OR REPLACE PACKAGE BODY PCK_cuotas
IS
PROCEDURE Inicializar
	IS
	BEGIN
		DELETE FROM Cuotas;
	END Inicializar;
    
PROCEDURE Insertar (nombrePrueba VARCHAR2, v_mes IN cuotas.mes%TYPE, v_pagoExigido IN cuotas.pagoexigido%TYPE, v_IdP IN cuotas.idp%TYPE, v_IdC IN cuotas.idc%TYPE, salidaEsperada BOOLEAN)
	IS
		v_Idcuota cuotas.idcuota%TYPE;
        v_cuota cuotas%ROWTYPE;
        v_salida BOOLEAN := true;
	BEGIN
		INSERT INTO cuotas (mes, pagoexigido, idp, idc) VALUES (v_mes, v_pagoexigido, v_idp, v_idc);
		v_Idcuota := SEQ_cuota.currval;
		SELECT * INTO v_cuota FROM cuotas WHERE Idcuota = v_Idcuota;
		IF (v_mes<>v_cuota.mes OR v_pagoexigido<>v_cuota.pagoexigido OR v_idp<>v_cuota.idp OR v_idc<>v_cuota.idc) THEN
			v_Salida := FALSE;
		END IF;
		COMMIT;
		DBMS_OUTPUT.PUT_LINE(nombrePrueba || ': ' || ASSERT_EQUALS(v_Salida, salidaEsperada));
		EXCEPTION
			WHEN OTHERS THEN
				DBMS_OUTPUT.PUT_LINE(nombrePrueba || ': ' || ASSERT_EQUALS(FALSE, salidaEsperada));
				ROLLBACK;
	END Insertar;
    
PROCEDURE Actualizar (nombrePrueba VARCHAR2, v_IdCuota IN cuotas.idcuota%TYPE, v_mes IN cuotas.mes%TYPE, v_pagoExigido IN cuotas.pagoexigido%TYPE, v_IdP IN cuotas.idp%TYPE, v_IdC IN cuotas.idc%TYPE, salidaEsperada BOOLEAN)
	IS
        v_cuota cuotas%ROWTYPE;
        v_salida BOOLEAN := true;
	BEGIN
		UPDATE cuotas SET mes=v_mes, pagoexigido=v_pagoexigido, idp=v_idp, idc=v_idc WHERE Idcuota = v_Idcuota;
		SELECT * INTO v_cuota FROM cuotas WHERE Idcuota = v_Idcuota;
		IF (v_mes<>v_cuota.mes OR v_pagoexigido<>v_cuota.pagoexigido OR v_idp<>v_cuota.idp OR v_idc<>v_cuota.idc) THEN
			v_Salida := FALSE;
		END IF;
		COMMIT;
		DBMS_OUTPUT.PUT_LINE(nombrePrueba || ': ' || ASSERT_EQUALS(v_Salida, salidaEsperada));
		EXCEPTION
			WHEN OTHERS THEN
				DBMS_OUTPUT.PUT_LINE(nombrePrueba || ': ' || ASSERT_EQUALS(FALSE, salidaEsperada));
				ROLLBACK;
	END Actualizar;
    
PROCEDURE Eliminar (nombrePrueba VARCHAR2, v_IdCuota IN cuotas.idcuota%TYPE, salidaEsperada BOOLEAN)
	IS
		v_Numcuotas NUMBER := 0;
        v_salida BOOLEAN := true;
	BEGIN
		DELETE FROM cuotas WHERE Idcuota = v_Idcuota;
		SELECT COUNT(*) INTO v_Numcuotas FROM cuotas WHERE Idcuota = v_Idcuota;
		IF v_Numcuotas != 0 THEN
			v_Salida := FALSE;
		END IF;
		COMMIT;
		DBMS_OUTPUT.PUT_LINE(nombrePrueba || ': ' || ASSERT_EQUALS(v_Salida, salidaEsperada));
		EXCEPTION
			WHEN OTHERS THEN
				DBMS_OUTPUT.PUT_LINE(nombrePrueba || ': ' || ASSERT_EQUALS(FALSE, salidaEsperada));
				ROLLBACK;
	END Eliminar;
END;
/

-- Tabla Empresas
CREATE OR REPLACE PACKAGE BODY PCK_empresas
IS
PROCEDURE Inicializar
	IS
	BEGIN
		DELETE FROM Empresas;
	END Inicializar;
    
PROCEDURE Insertar (nombrePrueba VARCHAR2, v_nombre IN empresas.nombre%TYPE, v_direccion IN empresas.direccion%TYPE, v_telf IN empresas.telf%TYPE, salidaEsperada BOOLEAN)
	IS
		v_Idempresa empresas.idempresa%TYPE;
        v_empresa empresas%ROWTYPE;
        v_salida BOOLEAN := true;
	BEGIN
		INSERT INTO empresas (nombre, direccion, telf) VALUES (v_nombre, v_direccion, v_telf);
		v_Idempresa := SEQ_empresa.currval;
		SELECT * INTO v_empresa FROM empresas WHERE Idempresa = v_Idempresa;
		IF (v_nombre<>v_empresa.nombre OR v_direccion<>v_empresa.direccion OR v_telf<>v_empresa.telf) THEN
			v_Salida := FALSE;
		END IF;
		COMMIT;
		DBMS_OUTPUT.PUT_LINE(nombrePrueba || ': ' || ASSERT_EQUALS(v_Salida, salidaEsperada));
		EXCEPTION
			WHEN OTHERS THEN
				DBMS_OUTPUT.PUT_LINE(nombrePrueba || ': ' || ASSERT_EQUALS(FALSE, salidaEsperada));
				ROLLBACK;
	END Insertar;
    
PROCEDURE Actualizar (nombrePrueba VARCHAR2, v_IdEmpresa IN empresas.idempresa%TYPE, v_nombre IN empresas.nombre%TYPE, v_direccion IN empresas.direccion%TYPE, v_telf IN empresas.telf%TYPE, salidaEsperada BOOLEAN)
	IS
        v_empresa empresas%ROWTYPE;
        v_salida BOOLEAN := true;
	BEGIN
		UPDATE empresas SET nombre=v_nombre, direccion=v_direccion, telf=v_telf WHERE Idempresa = v_Idempresa;
		SELECT * INTO v_empresa FROM empresas WHERE Idempresa = v_Idempresa;
		IF (v_nombre<>v_empresa.nombre OR v_direccion<>v_empresa.direccion OR v_telf<>v_empresa.telf) THEN
			v_Salida := FALSE;
		END IF;
		COMMIT;
		DBMS_OUTPUT.PUT_LINE(nombrePrueba || ': ' || ASSERT_EQUALS(v_Salida, salidaEsperada));
		EXCEPTION
			WHEN OTHERS THEN
				DBMS_OUTPUT.PUT_LINE(nombrePrueba || ': ' || ASSERT_EQUALS(FALSE, salidaEsperada));
				ROLLBACK;
	END Actualizar;
    
PROCEDURE Eliminar (nombrePrueba VARCHAR2, v_IdEmpresa IN empresas.idempresa%TYPE, salidaEsperada BOOLEAN)
	IS
		v_Numempresas NUMBER := 0;
        v_salida BOOLEAN := true;
	BEGIN
		DELETE FROM empresas WHERE Idempresa = v_Idempresa;
		SELECT COUNT(*) INTO v_Numempresas FROM empresas WHERE Idempresa = v_Idempresa;
		IF v_Numempresas != 0 THEN
			v_Salida := FALSE;
		END IF;
		COMMIT;
		DBMS_OUTPUT.PUT_LINE(nombrePrueba || ': ' || ASSERT_EQUALS(v_Salida, salidaEsperada));
		EXCEPTION
			WHEN OTHERS THEN
				DBMS_OUTPUT.PUT_LINE(nombrePrueba || ': ' || ASSERT_EQUALS(FALSE, salidaEsperada));
				ROLLBACK;
	END Eliminar;
END;
/

-- Tabla Facturas
CREATE OR REPLACE PACKAGE BODY PCK_facturas
IS
PROCEDURE Inicializar
	IS
	BEGIN
		DELETE FROM Facturas;
	END Inicializar;
    
PROCEDURE Insertar (nombrePrueba VARCHAR2, v_importe IN facturas.importe%TYPE, v_fechaEmision IN facturas.fechaemision%TYPE, v_tipoServicio IN facturas.tiposervicio%TYPE, v_IdC IN facturas.idc%TYPE, v_IdEmpresa IN facturas.idempresa%TYPE, salidaEsperada BOOLEAN)
	IS
		v_Idfactura facturas.idfactura%TYPE;
        v_factura facturas%ROWTYPE;
        v_salida BOOLEAN := true;
	BEGIN
		INSERT INTO facturas (importe, fechaemision, tiposervicio, idc, idempresa) VALUES (v_importe, v_fechaemision, v_tiposervicio, v_idc, v_idempresa);
		v_Idfactura := SEQ_factura.currval;
		SELECT * INTO v_factura FROM facturas WHERE Idfactura = v_Idfactura;
		IF (v_importe<>v_factura.importe OR v_fechaemision<>v_factura.fechaemision OR v_tiposervicio<>v_factura.tiposervicio OR v_idc<>v_factura.idc OR v_idempresa<>v_factura.idempresa) THEN
			v_Salida := FALSE;
		END IF;
		COMMIT;
		DBMS_OUTPUT.PUT_LINE(nombrePrueba || ': ' || ASSERT_EQUALS(v_Salida, salidaEsperada));
		EXCEPTION
			WHEN OTHERS THEN
				DBMS_OUTPUT.PUT_LINE(nombrePrueba || ': ' || ASSERT_EQUALS(FALSE, salidaEsperada));
				ROLLBACK;
	END Insertar;
    
PROCEDURE Actualizar (nombrePrueba VARCHAR2, v_IdFactura IN facturas.idfactura%TYPE, v_importe IN facturas.importe%TYPE, v_fechaEmision IN facturas.fechaemision%TYPE, v_tipoServicio IN facturas.tiposervicio%TYPE, v_IdC IN facturas.idc%TYPE, v_IdEmpresa IN facturas.idempresa%TYPE, salidaEsperada BOOLEAN)
	IS
        v_factura facturas%ROWTYPE;
        v_salida BOOLEAN := true;
	BEGIN
		UPDATE facturas SET importe=v_importe, fechaemision=v_fechaemision, tiposervicio=v_tiposervicio, idc=v_idc, idempresa=v_idempresa WHERE Idfactura = v_Idfactura;
		SELECT * INTO v_factura FROM facturas WHERE Idfactura = v_Idfactura;
		IF (v_importe<>v_factura.importe OR v_fechaemision<>v_factura.fechaemision OR v_tiposervicio<>v_factura.tiposervicio OR v_idc<>v_factura.idc OR v_idempresa<>v_factura.idempresa) THEN
			v_Salida := FALSE;
		END IF;
		COMMIT;
		DBMS_OUTPUT.PUT_LINE(nombrePrueba || ': ' || ASSERT_EQUALS(v_Salida, salidaEsperada));
		EXCEPTION
			WHEN OTHERS THEN
				DBMS_OUTPUT.PUT_LINE(nombrePrueba || ': ' || ASSERT_EQUALS(FALSE, salidaEsperada));
				ROLLBACK;
	END Actualizar;
    
PROCEDURE Eliminar (nombrePrueba VARCHAR2, v_IdFactura IN facturas.idfactura%TYPE, salidaEsperada BOOLEAN)
	IS
		v_Numfacturas NUMBER := 0;
        v_salida BOOLEAN := true;
	BEGIN
		DELETE FROM facturas WHERE Idfactura = v_Idfactura;
		SELECT COUNT(*) INTO v_Numfacturas FROM facturas WHERE Idfactura = v_Idfactura;
		IF v_Numfacturas != 0 THEN
			v_Salida := FALSE;
		END IF;
		COMMIT;
		DBMS_OUTPUT.PUT_LINE(nombrePrueba || ': ' || ASSERT_EQUALS(v_Salida, salidaEsperada));
		EXCEPTION
			WHEN OTHERS THEN
				DBMS_OUTPUT.PUT_LINE(nombrePrueba || ': ' || ASSERT_EQUALS(FALSE, salidaEsperada));
				ROLLBACK;
	END Eliminar;
END;
/

-- Tabla Pagos
CREATE OR REPLACE PACKAGE BODY PCK_pagos
IS
PROCEDURE Inicializar
	IS
	BEGIN
		DELETE FROM pagos;
	END Inicializar;
    
PROCEDURE Insertar (nombrePrueba VARCHAR2, v_cantidad IN pagos.cantidad%TYPE, v_fechaPago IN pagos.fechapago%TYPE, v_IdP IN pagos.idp%TYPE, v_IdC IN pagos.idc%TYPE, salidaEsperada BOOLEAN)
	IS
		v_Idpago pagos.idpago%TYPE;
        v_pago pagos%ROWTYPE;
        v_salida BOOLEAN := true;
	BEGIN
		INSERT INTO pagos (cantidad, fechapago, idp, idc) VALUES (v_cantidad, v_fechapago, v_idp, v_idc);
		v_Idpago := SEQ_pago.currval;
		SELECT * INTO v_pago FROM pagos WHERE Idpago = v_Idpago;
		IF (v_cantidad<>v_pago.cantidad OR v_fechapago<>v_pago.fechapago OR v_idp<>v_pago.idp OR v_idc<>v_pago.idc) THEN
			v_Salida := FALSE;
		END IF;
		COMMIT;
		DBMS_OUTPUT.PUT_LINE(nombrePrueba || ': ' || ASSERT_EQUALS(v_Salida, salidaEsperada));
		EXCEPTION
			WHEN OTHERS THEN
				DBMS_OUTPUT.PUT_LINE(nombrePrueba || ': ' || ASSERT_EQUALS(FALSE, salidaEsperada));
				ROLLBACK;
	END Insertar;
    
PROCEDURE Actualizar (nombrePrueba VARCHAR2, v_IdPago IN pagos.idpago%TYPE, v_cantidad IN pagos.cantidad%TYPE, v_fechaPago IN pagos.fechapago%TYPE, v_IdP IN pagos.idp%TYPE, v_IdC IN pagos.idc%TYPE, salidaEsperada BOOLEAN)
	IS
        v_pago pagos%ROWTYPE;
        v_salida BOOLEAN := true;
	BEGIN
		UPDATE pagos SET cantidad=v_cantidad, fechapago=v_fechapago, idp=v_idp, idc=v_idc WHERE Idpago = v_Idpago;
		SELECT * INTO v_pago FROM pagos WHERE Idpago = v_Idpago;
		IF (v_cantidad<>v_pago.cantidad OR v_fechapago<>v_pago.fechapago OR v_idp<>v_pago.idp OR v_idc<>v_pago.idc) THEN
			v_Salida := FALSE;
		END IF;
		COMMIT;
		DBMS_OUTPUT.PUT_LINE(nombrePrueba || ': ' || ASSERT_EQUALS(v_Salida, salidaEsperada));
		EXCEPTION
			WHEN OTHERS THEN
				DBMS_OUTPUT.PUT_LINE(nombrePrueba || ': ' || ASSERT_EQUALS(FALSE, salidaEsperada));
				ROLLBACK;
	END Actualizar;
    
PROCEDURE Eliminar (nombrePrueba VARCHAR2, v_IdPago IN pagos.idpago%TYPE, salidaEsperada BOOLEAN)
	IS
		v_Numpagos NUMBER := 0;
        v_salida BOOLEAN := true;
	BEGIN
		DELETE FROM pagos WHERE Idpago = v_Idpago;
		SELECT COUNT(*) INTO v_Numpagos FROM pagos WHERE Idpago = v_Idpago;
		IF v_Numpagos != 0 THEN
			v_Salida := FALSE;
		END IF;
		COMMIT;
		DBMS_OUTPUT.PUT_LINE(nombrePrueba || ': ' || ASSERT_EQUALS(v_Salida, salidaEsperada));
		EXCEPTION
			WHEN OTHERS THEN
				DBMS_OUTPUT.PUT_LINE(nombrePrueba || ': ' || ASSERT_EQUALS(FALSE, salidaEsperada));
				ROLLBACK;
	END Eliminar;
END;
/

-- Tabla Pertenece
CREATE OR REPLACE PACKAGE BODY PCK_pertenece
IS
PROCEDURE Inicializar
	IS
	BEGIN
		DELETE FROM Pertenece;
	END Inicializar;
    
PROCEDURE Insertar (nombrePrueba VARCHAR2, v_IdC IN pertenece.idc%TYPE, v_IdP IN pertenece.idp%TYPE, salidaEsperada BOOLEAN)
	IS
		v_IdPert pertenece.idpert%TYPE;
        v_pertenece pertenece%ROWTYPE;
        v_salida BOOLEAN := true;
	BEGIN
		INSERT INTO pertenece (idp, idc) VALUES (v_idp, v_idc);
		v_IdPert := SEQ_pertenece.currval;
		SELECT * INTO v_pertenece FROM pertenece WHERE IdPert = v_IdPert;
		IF (v_idp<>v_pertenece.idp OR v_idc<>v_pertenece.idc) THEN
			v_Salida := FALSE;
		END IF;
		COMMIT;
		DBMS_OUTPUT.PUT_LINE(nombrePrueba || ': ' || ASSERT_EQUALS(v_Salida, salidaEsperada));
		EXCEPTION
			WHEN OTHERS THEN
				DBMS_OUTPUT.PUT_LINE(nombrePrueba || ': ' || ASSERT_EQUALS(FALSE, salidaEsperada));
				ROLLBACK;
	END Insertar;
    
PROCEDURE Actualizar (nombrePrueba VARCHAR2, v_IdPert IN pertenece.idpert%TYPE, v_IdC IN pertenece.idc%TYPE, v_IdP IN pertenece.idp%TYPE, salidaEsperada BOOLEAN)
	IS
        v_pertenece pertenece%ROWTYPE;
        v_salida BOOLEAN := true;
	BEGIN
		UPDATE pertenece SET idp=v_idp, idc=v_idc WHERE IdPert = v_IdPert;
		SELECT * INTO v_pertenece FROM pertenece WHERE IdPert = v_IdPert;
		IF (v_idp<>v_pertenece.idp OR v_idc<>v_pertenece.idc) THEN
			v_Salida := FALSE;
		END IF;
		COMMIT;
		DBMS_OUTPUT.PUT_LINE(nombrePrueba || ': ' || ASSERT_EQUALS(v_Salida, salidaEsperada));
		EXCEPTION
			WHEN OTHERS THEN
				DBMS_OUTPUT.PUT_LINE(nombrePrueba || ': ' || ASSERT_EQUALS(FALSE, salidaEsperada));
				ROLLBACK;
	END Actualizar;
    
PROCEDURE Eliminar (nombrePrueba VARCHAR2, v_IdPert IN pertenece.idpert%TYPE, salidaEsperada BOOLEAN)
	IS
		v_NumPertenece NUMBER := 0;
        v_salida BOOLEAN := true;
	BEGIN
		DELETE FROM pertenece WHERE IdPert = v_IdPert;
		SELECT COUNT(*) INTO v_NumPertenece FROM pertenece WHERE IdPert = v_IdPert;
		IF v_NumPertenece != 0 THEN
			v_Salida := FALSE;
		END IF;
		COMMIT;
		DBMS_OUTPUT.PUT_LINE(nombrePrueba || ': ' || ASSERT_EQUALS(v_Salida, salidaEsperada));
		EXCEPTION
			WHEN OTHERS THEN
				DBMS_OUTPUT.PUT_LINE(nombrePrueba || ': ' || ASSERT_EQUALS(FALSE, salidaEsperada));
				ROLLBACK;
	END Eliminar;
END;
/

-- Tabla Pisos
CREATE OR REPLACE PACKAGE BODY PCK_pisos
IS
PROCEDURE Inicializar
	IS
	BEGIN
		DELETE FROM pisos;
	END Inicializar;
    
PROCEDURE Insertar (nombrePrueba VARCHAR2, v_pisoLetra IN pisos.pisoletra%TYPE, v_IdP IN pisos.idp%TYPE, v_IdC IN pisos.IdC%TYPE, salidaEsperada BOOLEAN)
	IS
		v_Idpiso pisos.idpiso%TYPE;
        v_piso pisos%ROWTYPE;
        v_salida BOOLEAN := true;
	BEGIN
		INSERT INTO pisos (pisoletra, idp, idc) VALUES (v_pisoletra, v_idp, v_IdC);
		v_Idpiso := SEQ_piso.currval;
		SELECT * INTO v_piso FROM pisos WHERE Idpiso = v_Idpiso;
		IF (v_pisoletra<>v_piso.pisoletra OR v_idp<>v_piso.idp OR v_idc<>v_piso.IdC) THEN
			v_Salida := FALSE;
		END IF;
		COMMIT;
		DBMS_OUTPUT.PUT_LINE(nombrePrueba || ': ' || ASSERT_EQUALS(v_Salida, salidaEsperada));
		EXCEPTION
			WHEN OTHERS THEN
				DBMS_OUTPUT.PUT_LINE(nombrePrueba || ': ' || ASSERT_EQUALS(FALSE, salidaEsperada));
				ROLLBACK;
	END Insertar;
    
PROCEDURE Actualizar (nombrePrueba VARCHAR2, v_IdPiso IN pisos.idpiso%TYPE, v_pisoLetra IN pisos.pisoletra%TYPE, v_IdP IN pisos.idp%TYPE, v_IdC IN pisos.IdC%TYPE, salidaEsperada BOOLEAN)
	IS
        v_piso pisos%ROWTYPE;
        v_salida BOOLEAN := true;
	BEGIN
		UPDATE pisos SET pisoletra=v_pisoletra, idp=v_idp, idc=v_idc WHERE Idpiso = v_Idpiso;
		SELECT * INTO v_piso FROM pisos WHERE Idpiso = v_Idpiso;
		IF (v_pisoletra<>v_piso.pisoletra OR v_idp<>v_piso.idp OR v_idc<>v_piso.idc) THEN
			v_Salida := FALSE;
		END IF;
		COMMIT;
		DBMS_OUTPUT.PUT_LINE(nombrePrueba || ': ' || ASSERT_EQUALS(v_Salida, salidaEsperada));
		EXCEPTION
			WHEN OTHERS THEN
				DBMS_OUTPUT.PUT_LINE(nombrePrueba || ': ' || ASSERT_EQUALS(FALSE, salidaEsperada));
				ROLLBACK;
	END Actualizar;
    
PROCEDURE Eliminar (nombrePrueba VARCHAR2, v_IdPiso IN pisos.idpiso%TYPE, salidaEsperada BOOLEAN)
	IS
		v_Numpisos NUMBER := 0;
        v_salida BOOLEAN := true;
	BEGIN
		DELETE FROM pisos WHERE Idpiso = v_Idpiso;
		SELECT COUNT(*) INTO v_Numpisos FROM pisos WHERE Idpiso = v_Idpiso;
		IF v_Numpisos != 0 THEN
			v_Salida := FALSE;
		END IF;
		COMMIT;
		DBMS_OUTPUT.PUT_LINE(nombrePrueba || ': ' || ASSERT_EQUALS(v_Salida, salidaEsperada));
		EXCEPTION
			WHEN OTHERS THEN
				DBMS_OUTPUT.PUT_LINE(nombrePrueba || ': ' || ASSERT_EQUALS(FALSE, salidaEsperada));
				ROLLBACK;
	END Eliminar;
END;
/

-- Tabla Presupuestos
CREATE OR REPLACE PACKAGE BODY PCK_presupuestos
IS
PROCEDURE Inicializar
	IS
	BEGIN
		DELETE FROM presupuestos;
	END Inicializar;
    
PROCEDURE Insertar (nombrePrueba VARCHAR2, v_fechaAprobacion IN presupuestos.fechaaprobacion%TYPE, v_fechaAplicacion IN presupuestos.fechaaplicacion%TYPE, v_motivo IN presupuestos.motivo%TYPE, v_IdC IN presupuestos.idc%TYPE, salidaEsperada BOOLEAN)
	IS
		v_Idpresupuesto presupuestos.idpresupuesto%TYPE;
        v_presupuesto presupuestos%ROWTYPE;
        v_salida BOOLEAN := true;
	BEGIN
		INSERT INTO presupuestos (fechaAprobacion, fechaAplicacion, motivo, idc) VALUES (v_fechaaprobacion, v_fechaaplicacion, v_motivo, v_idc);
		v_Idpresupuesto := SEQ_presupuesto.currval;
		SELECT * INTO v_presupuesto FROM presupuestos WHERE Idpresupuesto = v_Idpresupuesto;
		IF (v_fechaaprobacion<>v_presupuesto.fechaaprobacion OR v_fechaaplicacion<>v_presupuesto.fechaaplicacion OR v_motivo<>v_presupuesto.motivo OR v_idc<>v_presupuesto.idc) THEN
			v_Salida := FALSE;
		END IF;
		COMMIT;
		DBMS_OUTPUT.PUT_LINE(nombrePrueba || ': ' || ASSERT_EQUALS(v_Salida, salidaEsperada));
		EXCEPTION
			WHEN OTHERS THEN
				DBMS_OUTPUT.PUT_LINE(nombrePrueba || ': ' || ASSERT_EQUALS(FALSE, salidaEsperada));
				ROLLBACK;
	END Insertar;
    
PROCEDURE Actualizar (nombrePrueba VARCHAR2, v_IdPresupuesto IN presupuestos.idpresupuesto%TYPE, v_fechaAprobacion IN presupuestos.fechaaprobacion%TYPE, v_fechaAplicacion IN presupuestos.fechaaplicacion%TYPE, v_motivo IN presupuestos.motivo%TYPE, v_IdC IN presupuestos.idc%TYPE, salidaEsperada BOOLEAN)
	IS
        v_presupuesto presupuestos%ROWTYPE;
        v_salida BOOLEAN := true;
	BEGIN
		UPDATE presupuestos SET fechaaprobacion=v_fechaaprobacion, fechaaplicacion=v_fechaaplicacion, motivo=v_motivo, idc=v_idc WHERE Idpresupuesto = v_Idpresupuesto;
		SELECT * INTO v_presupuesto FROM presupuestos WHERE Idpresupuesto = v_Idpresupuesto;
		IF (v_fechaaprobacion<>v_presupuesto.fechaaprobacion OR v_fechaaplicacion<>v_presupuesto.fechaaplicacion OR v_motivo<>v_presupuesto.motivo OR v_idc<>v_presupuesto.idc) THEN
			v_Salida := FALSE;
		END IF;
		COMMIT;
		DBMS_OUTPUT.PUT_LINE(nombrePrueba || ': ' || ASSERT_EQUALS(v_Salida, salidaEsperada));
		EXCEPTION
			WHEN OTHERS THEN
				DBMS_OUTPUT.PUT_LINE(nombrePrueba || ': ' || ASSERT_EQUALS(FALSE, salidaEsperada));
				ROLLBACK;
	END Actualizar;
    
PROCEDURE Eliminar (nombrePrueba VARCHAR2, v_IdPresupuesto IN presupuestos.idpresupuesto%TYPE, salidaEsperada BOOLEAN)
	IS
		v_Numpresupuestos NUMBER := 0;
        v_salida BOOLEAN := true;
	BEGIN
		DELETE FROM presupuestos WHERE Idpresupuesto = v_Idpresupuesto;
		SELECT COUNT(*) INTO v_Numpresupuestos FROM presupuestos WHERE Idpresupuesto = v_Idpresupuesto;
		IF v_Numpresupuestos != 0 THEN
			v_Salida := FALSE;
		END IF;
		COMMIT;
		DBMS_OUTPUT.PUT_LINE(nombrePrueba || ': ' || ASSERT_EQUALS(v_Salida, salidaEsperada));
		EXCEPTION
			WHEN OTHERS THEN
				DBMS_OUTPUT.PUT_LINE(nombrePrueba || ': ' || ASSERT_EQUALS(FALSE, salidaEsperada));
				ROLLBACK;
	END Eliminar;
END;
/

-- Tabla Propietarios
CREATE OR REPLACE PACKAGE BODY PCK_propietarios
IS
PROCEDURE Inicializar
	IS
	BEGIN
		DELETE FROM propietarios;
	END Inicializar;
    
PROCEDURE Insertar (nombrePrueba VARCHAR2, v_nombreAp IN propietarios.nombreap%TYPE, v_dni IN propietarios.dni%TYPE, v_telefono IN propietarios.telefono%TYPE, v_email IN propietarios.email%TYPE, salidaEsperada BOOLEAN)
	IS
		v_IdP propietarios.idp%TYPE;
        v_propietario propietarios%ROWTYPE;
        v_salida BOOLEAN := true;
	BEGIN
		INSERT INTO propietarios (nombreap, dni, telefono, email) VALUES (v_nombreap, v_dni, v_telefono, v_email);
		v_IdP := SEQ_propietario.currval;
		SELECT * INTO v_propietario FROM propietarios WHERE IdP = v_IdP;
		IF (v_nombreap<>v_propietario.nombreap OR v_dni<>v_propietario.dni OR v_telefono<>v_propietario.telefono OR v_email<>v_propietario.email) THEN
			v_Salida := FALSE;
		END IF;
		COMMIT;
		DBMS_OUTPUT.PUT_LINE(nombrePrueba || ': ' || ASSERT_EQUALS(v_Salida, salidaEsperada));
		EXCEPTION
			WHEN OTHERS THEN
				DBMS_OUTPUT.PUT_LINE(nombrePrueba || ': ' || ASSERT_EQUALS(FALSE, salidaEsperada));
				ROLLBACK;
	END Insertar;
    
PROCEDURE Actualizar (nombrePrueba VARCHAR2, v_IdP IN propietarios.idp%TYPE, v_nombreAp IN propietarios.nombreap%TYPE, v_dni IN propietarios.dni%TYPE, v_telefono IN propietarios.telefono%TYPE, v_email IN propietarios.email%TYPE, salidaEsperada BOOLEAN)
	IS
        v_propietario propietarios%ROWTYPE;
        v_salida BOOLEAN := true;
	BEGIN
		UPDATE propietarios SET nombreap=v_nombreap, dni=v_dni, telefono=v_telefono, email=v_email WHERE IdP = v_IdP;
		SELECT * INTO v_propietario FROM propietarios WHERE IdP = v_IdP;
		IF (v_nombreap<>v_propietario.nombreap OR v_dni<>v_propietario.dni OR v_telefono<>v_propietario.telefono OR v_email<>v_propietario.email) THEN
			v_Salida := FALSE;
		END IF;
		COMMIT;
		DBMS_OUTPUT.PUT_LINE(nombrePrueba || ': ' || ASSERT_EQUALS(v_Salida, salidaEsperada));
		EXCEPTION
			WHEN OTHERS THEN
				DBMS_OUTPUT.PUT_LINE(nombrePrueba || ': ' || ASSERT_EQUALS(FALSE, salidaEsperada));
				ROLLBACK;
	END Actualizar;
    
PROCEDURE Eliminar (nombrePrueba VARCHAR2, v_IdP IN propietarios.idp%TYPE, salidaEsperada BOOLEAN)
	IS
		v_Numpropietarios NUMBER := 0;
        v_salida BOOLEAN := true;
	BEGIN
		DELETE FROM propietarios WHERE IdP = v_IdP;
		SELECT COUNT(*) INTO v_Numpropietarios FROM propietarios WHERE IdP = v_IdP;
		IF v_Numpropietarios != 0 THEN
			v_Salida := FALSE;
		END IF;
		COMMIT;
		DBMS_OUTPUT.PUT_LINE(nombrePrueba || ': ' || ASSERT_EQUALS(v_Salida, salidaEsperada));
		EXCEPTION
			WHEN OTHERS THEN
				DBMS_OUTPUT.PUT_LINE(nombrePrueba || ': ' || ASSERT_EQUALS(FALSE, salidaEsperada));
				ROLLBACK;
	END Eliminar;
END;
/


