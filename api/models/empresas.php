<?php
/*
*   Clase para manejar la tabla empresas de la base de datos.
*   Es clase hija de Validator.
*/
class Empresas extends Validator
{
    // Declaración de atributos (propiedades).
    private $id_empresa = null;
    private $nombre_cliente = null;
    private $apellido_cliente = null;
    private $nombre_empresa = null;
    private $numero_empresacontc = null;
    private $correo_empresacontc = null;
    private $direccion_empresa = null;
    private $nit_empresa = null;
    private $fk_id_estado = null;

    /*
    *   Métodos para validar y asignar valores de los atributos.
    */
    public function setId($value)
    {
        if ($this->validateNaturalNumber($value)) {
            $this->id_empresa = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setNombreClt($value)
    {
        if ($this->validateString($value, 1, 100)) {
            $this->nombre_cliente = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setApellidoClt($value)
    {
        if ($this->validateString($value, 1, 100)) {
            $this->apellido_cliente = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setNombreEmp($value)
    {
        if ($this->validateString($value, 1, 100)) {
            $this->nombre_empresa = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setNumeroEmp($value)
    {
        if ($this->validatePhone($value)) {
            $this->numero_empresacontc = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setCorreoEmp($value)
    {
        if ($this->validateEmail($value)) {
            $this->correo_empresacontc = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setDireccionEmp($value)
    {
        if ($this->validateString($value, 1, 150)) {
            $this->direccion_empresa = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setNitEmp($value)
    {
        if ($this->validateNIT($value, 1, 150) || $this->validateDUI($value, 1, 150)) {
            $this->nit_empresa = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setIdEstado($value)
    {
        if ($this->validateNaturalNumber($value)) {
            $this->fk_id_estado = $value;
            return true;
        } else {
            return false;
        }
    }

    /*
    *   Métodos para obtener valores de los atributos.
    */
    public function getId()
    {
        return $this->id_empresa;
    }

    public function getNombreClt()
    {
        return $this->nombre_cliente;
    }

    public function getApellidoClt()
    {
        return $this->apellido_cliente;
    }

    public function getNombreEmp()
    {
        return $this->nombre_empresa;
    }

    public function getNumeroEmp()
    {
        return $this->numero_empresacontc;
    }

    public function getCorreoEmp()
    {
        return $this->correo_empresacontc;
    }

    public function getDireccionEmp()
    {
        return $this->direccion_empresa;
    }

    public function getNitEmp()
    {
        return $this->nit_empresa;
    }

    public function getIdEstado()
    {
        return $this->fk_id_estado;
    }

    /*
    *   Metodos para consultas
    */
    //Función para consultar las empresas con limit
    public function obtenerEmpresasLimit($limit)
    {
        $sql = 'SELECT emp.id_empresa, emp.nombre_cliente, emp.apellido_cliente, emp.nombre_empresa, emp.numero_empresacontc, emp.correo_empresacontc, emp.direccion_empresa, emp.nit_empresa, est.nombre_estado
                FROM empresas AS emp
                INNER JOIN estados AS est ON emp.fk_id_estado = est.id_estado
                WHERE emp.fk_id_estado = 4 ORDER BY emp.id_empresa DESC OFFSET ? LIMIT 6';
        $params = array($limit);
        return Database::getRows($sql, $params);
    }

    public function obtenerEmpresasAsignadas($limit)
    {
        $sql = 'SELECT emp.id_empresa, emp.nombre_cliente, emp.apellido_cliente, emp.nombre_empresa, emp.numero_empresacontc, emp.correo_empresacontc, emp.direccion_empresa, emp.nit_empresa, est.nombre_estado, epl.fk_id_empleado
                FROM empresas AS emp
                INNER JOIN estados AS est ON emp.fk_id_estado = est.id_estado
                INNER JOIN empresas_empleados AS epl ON epl.fk_id_empresa = emp.id_empresa
                WHERE epl.fk_id_empleado=? AND emp.fk_id_estado = 4 OFFSET ? limit 6';
        $params = array($_SESSION['id_usuario'], $limit);
        return Database::getRows($sql, $params);
    }

    //Buscar empresas para el admin

    public function buscarEmpresasAdm($value, $limit)
    {
        $sql = 'SELECT emp.id_empresa, emp.nombre_cliente, emp.apellido_cliente, emp.nombre_empresa, emp.numero_empresacontc, emp.correo_empresacontc, emp.direccion_empresa, emp.nit_empresa, est.nombre_estado
        FROM empresas AS emp
        INNER JOIN estados AS est ON emp.fk_id_estado = est.id_estado
        WHERE (emp.nombre_cliente ILIKE ? OR emp.apellido_cliente ILIKE ? OR emp.nombre_empresa ILIKE ? OR emp.numero_empresacontc ILIKE ? OR emp.correo_empresacontc ILIKE ? OR emp.direccion_empresa ILIKE ? OR emp.nit_empresa ILIKE ?) 
        AND emp.fk_id_estado = 4 LIMIT ?';
        $params = array("%$value%", "%$value%", "%$value%", "%$value%", "%$value%", "%$value%", "%$value%", $limit);
        return Database::getRows($sql, $params);
    }
    //buscar empresas para el que no es admin
    public function buscarEmpresaCl($value, $limit)
    {
        $sql = 'SELECT emp.id_empresa, emp.nombre_cliente, emp.apellido_cliente, emp.nombre_empresa, emp.numero_empresacontc, emp.correo_empresacontc, emp.correo_empresacontc, emp.direccion_empresa, emp.nit_empresa, est.nombre_estado
                FROM empresas AS emp
                INNER JOIN estados AS est ON emp.fk_id_estado = est.id_estado
                INNER JOIN empresas_empleados AS epl ON epl.fk_id_empresa = emp.id_empresa
                WHERE (emp.nombre_cliente ILIKE ? OR emp.apellido_cliente ILIKE ? OR emp.nombre_empresa ILIKE ? OR emp.numero_empresacontc ILIKE ? OR emp.correo_empresacontc ILIKE ? OR emp.direccion_empresa ILIKE ? OR emp.nit_empresa ILIKE ?) 
                AND epl.fk_id_empleado=? AND emp.fk_id_estado = 4 LIMIT ?';
        $params = array("%$value%", "%$value%", "%$value%", "%$value%", "%$value%", "%$value%", "%$value%", $_SESSION['id_usuario'], $limit);
        return Database::getRows($sql, $params);
    }
    //Buscar una empresa especifica
    public function obtenerEmpresa()
    {
        $sql = 'SELECT emp.id_empresa, emp.nombre_cliente, emp.apellido_cliente, emp.nombre_empresa, emp.numero_empresacontc, emp.correo_empresacontc, emp.direccion_empresa, emp.nit_empresa, est.nombre_estado
        FROM empresas AS emp
        INNER JOIN estados AS est ON emp.fk_id_estado = est.id_estado
        WHERE emp.fk_id_estado = 4 AND emp.id_empresa = ?';
        $params = array($this->id_empresa);
        return Database::getRow($sql, $params);
    }

    //Obtener empresas
    public function obtenerEmpresas()
    {
        $sql = 'SELECT emp.id_empresa, emp.nombre_empresa, emp.nombre_cliente, emp.apellido_cliente, emp.numero_empresacontc, emp.correo_empresacontc, emp.direccion_empresa, emp.nit_empresa, est.nombre_estado
        FROM empresas AS emp
        INNER JOIN estados AS est ON emp.fk_id_estado = est.id_estado WHERE emp.fk_id_estado = 4 ORDER BY emp.id_empresa';
        $params = null;
        return Database::getRows($sql, $params);
    }

    //Obtener empresas asignadas para el checkbox
    public function obtenerEmpresasAsignCheck($idemp)
    {
        $sql = 'SELECT emp.id_empresa, emp.nombre_empresa, emp.nombre_cliente, emp.apellido_cliente, emp.numero_empresacontc, emp.correo_empresacontc, emp.direccion_empresa, emp.nit_empresa, est.nombre_estado, epl.fk_id_empleado
                FROM empresas AS emp
                INNER JOIN estados AS est ON emp.fk_id_estado = est.id_estado
                INNER JOIN empresas_empleados AS epl ON epl.fk_id_empresa = emp.id_empresa
                WHERE epl.fk_id_empleado=? AND emp.fk_id_estado = 4';
        $params = array($idemp);
        return Database::getRows($sql, $params);
    }

    /*
    *   Métodos para realizar las operaciones SCRUD (search, create, read, update, delete).
    */
    //Crear empresa
    public function crearEmpresa()
    {
        $sql = 'INSERT INTO empresas(nombre_cliente, apellido_cliente, nombre_empresa, numero_empresacontc, correo_empresacontc, direccion_empresa, nit_empresa)
                VALUES (?, ?, ?, ?, ?, ?, ?)';
        $params = array($this->nombre_cliente, $this->apellido_cliente, $this->nombre_empresa, $this->numero_empresacontc, $this->correo_empresacontc, $this->direccion_empresa, $this->nit_empresa,);
        return Database::executeRow($sql, $params);
    }
    //Actualizar empresa
    public function actualizarEmpresa()
    {
        $sql = 'UPDATE empresas
                SET nombre_cliente=?, apellido_cliente=?, nombre_empresa=?, numero_empresacontc=?, correo_empresacontc=?, direccion_empresa=?, nit_empresa=?
                WHERE id_empresa = ?';
        $params = array($this->nombre_cliente, $this->apellido_cliente, $this->nombre_empresa, $this->numero_empresacontc, $this->correo_empresacontc, $this->direccion_empresa, $this->nit_empresa, $this->id_empresa);
        return Database::executeRow($sql, $params);
    }
    //Cambiar estado de empresa (Eliminado)
    public function cambiarEstadoEmp()
    {
        $sql = 'UPDATE empresas
                SET fk_id_estado=3
                WHERE id_empresa = ?';
        $params = array($this->id_empresa);
        return Database::executeRow($sql, $params);
    }
    //Eliminar empresa NO SE USARA A MENOS QUE EL PROFESOR DIGA
    public function eliminarEmpresa()
    {
        $sql = 'DELETE FROM empresas WHERE id_empresa = ?';
        $params = array($this->id_empresa);
        return Database::executeRow($sql, $params);
    }

    //Comprobar que exista un folder con el nombre actual (PARA CREAR)
    public function checkEmpresaName()
    {
        $sql = 'SELECT id_empresa FROM empresas WHERE nombre_empresa = ? AND fk_id_estado = 4';
        $params = array($this->nombre_empresa);
        if ($data = Database::getRow($sql, $params)) {
            return false;
        } else {
            return true;
        }
    }
    //Comprobar que exista un folder con el nombre actual (PARA ACTUALIZAR)
    public function checkEmpresaAct()
    {
        $sql = 'SELECT id_empresa FROM empresas WHERE nombre_empresa = ? AND fk_id_estado = 4 AND id_empresa !=?';
        $params = array($this->nombre_empresa, $this->id_empresa);
        if ($data = Database::getRow($sql, $params)) {
            return false;
        } else {
            return true;
        }
    }

    /*

        METODOS PARA GRAFICAS

    */
    //Obtener la cantidad de empleados por el tipo al que pertenecen
    public function graficaCantidadFlEm($rangoi, $rangof)
    {
        $sql = 'SELECT nombre_empresa, COUNT(fk_id_empresa) as cantidad
                FROM empresas as emp
                LEFT JOIN folders AS fol ON emp.id_empresa = fol.fk_id_empresa
                GROUP BY nombre_empresa 
                HAVING COUNT(fk_id_empresa)>=? AND COUNT(fk_id_empresa)<=? ORDER BY cantidad DESC LIMIT 5';
        $params = array($rangoi, $rangof);
        return Database::getRows($sql, $params);
    }

    //Top 5 de empresas a la cual más empleados poseen acceso (Jonathan)
    public function graficaEmpresasAccesos()
    {
        $sql = 'SELECT emp.nombre_empresa, COUNT(eme.fk_id_empresa) AS accesos
                FROM empresas AS emp
                INNER JOIN empresas_empleados AS eme ON emp.id_empresa = eme.fk_id_empresa
                GROUP BY emp.nombre_empresa
                ORDER BY accesos DESC LIMIT 5';
        $params = null;
        return Database::getRows($sql, $params);
    }


    /*
        
        METODOS PARA REPORTES

    */
    //Obtener la cantidad de empleados con acceso a las empresas
    public function reportCantidadEmpAcc()
    {
        $sql = 'SELECT emp.nombre_empresa, COUNT(eme.fk_id_empresa) AS acceso FROM empresas_empleados AS eme
                RIGHT JOIN empresas AS emp ON eme.fk_id_empresa = emp.id_empresa
                WHERE emp.fk_id_estado != 3
                GROUP BY emp.nombre_empresa ORDER BY COUNT(eme.fk_id_empresa) DESC';
        $params = null;
        return Database::getRows($sql, $params);
    }
    //Obtener el número de archivos y los folders totales que posee la empresa
    public function reportFAEmp($idemp)
    {
        $sql = 'SELECT fold.nombre_folder, COUNT(arc.fk_id_folder) AS total FROM archivos AS arc
                RIGHT JOIN folders AS fold ON arc.fk_id_folder = fold.id_folder
                WHERE fold.fk_id_estado !=3 AND fold.fk_id_empresa = ?
                GROUP BY fold.nombre_folder ORDER BY COUNT(arc.fk_id_folder) DESC';
        $params = array($idemp);
        return Database::getRows($sql, $params);
    }

    //Checar si la empresa existe y de paso obtener el número de folders
    public function checkReportEmp($idemp)
    {
        $sql = 'SELECT COUNT(fold.fk_id_empresa) as folders, emp.id_empresa, emp.nombre_cliente, emp.apellido_cliente, emp.nombre_empresa, emp.numero_empresacontc, emp.correo_empresacontc, emp.direccion_empresa, emp.nit_empresa
                FROM empresas AS emp
                LEFT JOIN folders AS fold ON emp.id_empresa = fold.fk_id_empresa
                WHERE emp.id_empresa = ? AND emp.fk_id_estado !=3
                GROUP BY emp.id_empresa';
        $params = array($idemp);
        return Database::getRows($sql, $params);
    }

    //Obtener todas las empresas registradas
    public function registroEmpresas()
    {
        $sql = 'SELECT nombre_empresa, nombre_cliente, apellido_cliente, nit_empresa, numero_empresacontc 
                FROM empresas 
                WHERE fk_id_estado !=3
                GROUP BY nombre_empresa, nombre_cliente, apellido_cliente, nit_empresa, numero_empresacontc 
                ORDER BY nombre_empresa';
        $params = null;
        return Database::getRows($sql, $params);
    }

    //Función de top 5 empresas con más archivos
    public function top5EmpresasArchivos()
    {
        $sql = 'SELECT emp.nombre_empresa, COUNT(aremp.fk_id_folder) AS archivos
                FROM folders AS fol
                INNER JOIN empresas AS emp ON fol.fk_id_empresa = emp.id_empresa
                LEFT JOIN archivos AS aremp ON fol.id_folder = aremp.fk_id_folder
                WHERE emp.fk_id_estado != 3
                GROUP BY emp.nombre_empresa ORDER BY archivos DESC LIMIT 5';
        $params = null;
        return Database::getRows($sql, $params);
    }
}
