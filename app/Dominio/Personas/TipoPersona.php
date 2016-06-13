<?php
namespace GDI\Dominio\Personas;

use \SplEnum;

/**
 * Class TipoPersona
 * @package GDI\Dominio\Personas
 * @author Gerardo Adrián Gómez Ruiz
 * @version 1.0
 */
class TipoPersona extends SplEnum
{
    const PERSONA_FISICA = 1;
    const PERSONA_MORAL  = 2;
    const __default      = self::PERSONA_FISICA;
}