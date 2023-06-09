<?php 

namespace Model; 

class Usuario extends ActiveRecord {
    // Base de datos
    protected static $tabla = 'usuarios'; 
    protected static $columnasDB = ['id', 'nombre', 'apellido', 'email', 'password', 'telefono', 'admin', 'confirmado', 'token']; // para iterar en cada elemento de la tabla

    // luego se debe crear un atributo por cada columna de la BD
    public $id; 
    public $nombre; 
    public $apellido; 
    public $email; 
    public $password; 
    public $telefono; 
    public $admin; 
    public $confirmado; 
    public $token; 

    public function __construct($args = []) {
        $this->id = $args['id'] ?? null; 
        $this->nombre = $args['nombre'] ?? ''; 
        $this->apellido = $args['apellido'] ?? ''; 
        $this->email = $args['email'] ?? ''; 
        $this->password = $args['password'] ?? ''; 
        $this->telefono = $args['telefono'] ?? ''; 
        $this->admin = $args['admin'] ?? '0'; 
        $this->confirmado = $args['confirmado'] ?? '0'; 
        $this->token = $args['token'] ?? ''; 
    }

    // MENSAJES VALIDACIÓN CREACIÓN CUENTA
    public function validarNuevaCuenta() {
        if(!$this->nombre) {
            self::$alertas['error'] [] = 'El nombre es obligatorio'; 
        }
        if(!$this->apellido) {
            self::$alertas['error'] [] = 'El apellido es obligatorio'; 
        }
        if(!$this->email) {
            self::$alertas['error'] [] = 'El email es obligatorio'; 
        }
        if(!$this->password) {
            self::$alertas['error'] [] = 'El password es obligatorio'; 
        } elseif (strlen($this->password) < 2) {
            self::$alertas['error'] [] = 'El password debe contener al menos 2 caractéres'; 
        }

        return self::$alertas; 
    }

    public function validaremail(){
        
        if(!$this->email) {
            self::$alertas['error'] [] = 'El email es obligatorio'; 
        }

        return self::$alertas; 
    }

    public function validarContraseña(){
        
        if(!$this->password) {
            self::$alertas['error'] [] = 'El password es obligatorio'; 
        } elseif (strlen($this->password) < 2) {
            self::$alertas['error'] [] = 'El password debe contener al menos 2 caractéres'; 
        }

        return self::$alertas; 
    }

    // Revisa si el usuario existe
    public function existeUsuario() {
        $query = "SELECT * FROM ". SELF::$tabla . " WHERE email='" . $this->email. "' LIMIT 1";

        $resultado = self::$db->query($query); 

        if($resultado->num_rows) {
            self::$alertas['error'] [] = 'El correo electrónico ya se encuentra registrado';
        }
        
        return $resultado; 
    }

    public function hashPassword() {
        $this->password = password_hash($this->password, PASSWORD_BCRYPT); 
    }

    public function crearToken(){
        $this->token = uniqid();
    }

    public function validarLogin(){
        if(!$this -> email) {
            self::$alertas['error'] [] = 'Debe ingresar un correo electrónico'; 
        }
        if(!$this -> password) {
            self::$alertas['error'] [] = 'Debe ingresar una contraseña'; 
        }

        return self::$alertas; 
    }

    public function comprobarPasswordAndVerificado($password) {
        $resultado = password_verify($password, $this->password); 

        if(!$resultado || !$this->confirmado) {
            self::$alertas['error'] [] = 'Password incorrecto o tu cuenta no ha sido confirmada'; 
        }else {
            return true;
        }
    }
    
}
