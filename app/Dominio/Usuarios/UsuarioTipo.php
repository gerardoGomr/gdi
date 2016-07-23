<?php
namespace GDI\Dominio\Usuarios;

/**
 * Class UsuarioTipo
 * @package GDI\Dominio\Usuarios
 * @author  Gerardo Adrián Gómez Ruiz
 * @version 1.0
 */
class UsuarioTipo
{
    /**
     * @var int
     */
	private $id;

    /**
     * @var UsuarioTipo
     */
    private $usuarioTipo;

    /**
     * UsuarioTipo constructor.
     * @param int|null $id
     * @param UsuarioTipo|null $usuarioTipo
     */
    public function __construct($id = null, UsuarioTipo $usuarioTipo = null)
    {
        $this->id          = $id;
        $this->usuarioTipo = $usuarioTipo;
    }

    /**
     * @return int|null
     */
    public function getId()
    {
    	return $this->id;
    }

    /**
     * @return UsuarioTipo|null
     */
    public function getUsuarioTipo()
    {
    	return $this->usuarioTipo;
    }
}
