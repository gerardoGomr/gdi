<?php
namespace GDI\Infraestructura\Polizas;

use GDI\Aplicacion\Logger;

use Doctrine\ORM\EntityManager;
use GDI\Dominio\Polizas\AsociadoProtegido;
use GDI\Dominio\Polizas\Repositorios\AsociadosProtegidosRepositorio;
use Monolog\Logger as Log;
use Monolog\Handler\StreamHandler;
use PDOException;

/**
 * Class DoctrineAsociadosProtegidosRepositorio
 *
 * @package GDI\Infraestructura\Polizas
 * @author Gerardo Adrián Gómez Ruiz
 * @version 1.0
 */
class DoctrineAsociadosProtegidosRepositorio implements AsociadosProtegidosRepositorio
{
    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * DoctrineUsuariosRepositorio constructor.
     *
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->entityManager = $em;
    }

    /**
     * obtener Asociado por $id
     * @param int $id
     * @return AsociadoProtegido
     */
    public function obtenerPorId($id)
    {
        // TODO: Implement obtenerPorId() method.
        try {
            $usuario = $this->entityManager->createQuery('SELECT a, d, o FROM Polizas:AsociadoProtegido a JOIN a.domicilio d JOIN a.oficina o WHERE a.id = :id')
                ->setParameter('id', $id)
                ->getResult();

            if (count($usuario) > 0) {
                return $usuario[0];
            }

            return null;

        } catch (PDOException $e) {
            $pdoLogger = new Logger(new Log('pdo_exception'), new StreamHandler(storage_path() . '/logs/pdo/sqlsrv_' . date('Y-m-d') . '.log', Log::ERROR));
            $pdoLogger->log($e);
            return null;
        }
    }

    /**
     * @return array
     */
    public function obtenerTodos()
    {
        // TODO: Implement obtenerTodos() method.
    }

    /**
     * @param $dato
     * @return array
     */
    public function obtenerPor($dato)
    {
        // TODO: Implement obtenerPor() method.
        $dato = str_replace(' ', '', $dato);

        try {
            $asociados = $this->entityManager->createQuery("SELECT a, d, o FROM Polizas:AsociadoProtegido a JOIN a.domicilio d JOIN a.oficina o WHERE (CONCAT(a.nombre, a.paterno, a.materno)) = :dato OR (CONCAT(a.paterno, a.materno, a.nombre) = :dato OR a.rfc = :dato)")
                ->setParameter('dato', $dato)
                ->getResult();

            if (count($asociados) > 0) {
                return $asociados;
            }

            return null;

        } catch (PDOException $e) {
            $pdoLogger = new Logger(new Log('pdo_exception'), new StreamHandler(storage_path() . '/logs/pdo/sqlsrv_' . date('Y-m-d') . '.log', Log::ERROR));
            $pdoLogger->log($e);
            return null;
        }
    }
}