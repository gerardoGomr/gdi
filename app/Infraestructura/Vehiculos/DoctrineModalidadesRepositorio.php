<?php
namespace GDI\Infraestructura\Vehiculos;

use Doctrine\ORM\EntityManager;
use GDI\Aplicacion\Logger;
use GDI\Dominio\Vehiculos\Repositorios\ModalidadesRepositorio;
use Monolog\Logger as Log;
use Monolog\Handler\StreamHandler;

/**
 * Class DoctrineModalidadesRepositorio
 * @package GDI\Infraestructura\Vehiculos
 * @author Gerardo Adrián Gómez Ruiz
 * @version 1.0
 */
class DoctrineModalidadesRepositorio implements ModalidadesRepositorio
{
    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * DoctrineUsuariosRepositorio constructor.
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->entityManager = $em;
    }

    /**
     * @return array
     */
    public function obtenerTodos()
    {
        // TODO: Implement obtenerTodos() method.
        try {
            $query       = $this->entityManager->createQuery('SELECT m FROM Vehiculos:Modalidad m');
            $modalidades = $query->getResult();

            if (count($modalidades) > 0) {
                return $modalidades;
            }

            return null;

        } catch (\PDOException $e) {
            $pdoLogger = new Logger(new Log('pdo_exception'), new StreamHandler(storage_path() . '/logs/pdo/sqlsrv_' . date('Y-m-d') . '.log', Log::ERROR));
            $pdoLogger->log($e);
            return null;
        }
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function obtenerPorId($id)
    {
        // TODO: Implement obtenerPorId() method.
    }

    /**
     * obtener una lista de vehiculos en base al dato
     * @param string $dato
     * @return array
     */
    public function obtenerPor($dato)
    {

    }
}