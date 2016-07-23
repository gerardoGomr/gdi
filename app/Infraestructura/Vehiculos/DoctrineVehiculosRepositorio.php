<?php
namespace GDI\Infraestructura\Vehiculos;

use Doctrine\ORM\EntityManager;
use GDI\Aplicacion\Logger;
use GDI\Dominio\Vehiculos\Repositorios\VehiculosRepositorio;
use Monolog\Logger as Log;
use Monolog\Handler\StreamHandler;

/**
 * Class DoctrineVehiculosRepositorio
 * @package GDI\Infraestructura\Vehiculos
 * @author Gerardo Adrián Gómez Ruiz
 * @version 1.0
 */
class DoctrineVehiculosRepositorio implements VehiculosRepositorio
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
        // TODO: Implement obtenerPor() method.
        $dato = str_replace(' ', '', $dato);

        try {
            $query = $this->entityManager->createQuery('SELECT v, mo, mod FROM Vehiculos:Vehiculo v JOIN v.modelo mo JOIN v.modalidad mod WHERE v.numeroSerie = :dato OR v.numeroMotor = :dato')
                ->setParameter('dato', $dato);
            $usuarios = $query->getResult();

            if (count($usuarios) > 0) {
                return $usuarios;
            }

            return null;

        } catch (\PDOException $e) {
            $pdoLogger = new Logger(new Log('pdo_exception'), new StreamHandler(storage_path() . '/logs/pdo/sqlsrv_' . date('Y-m-d') . '.log', Log::ERROR));
            $pdoLogger->log($e);
            return null;
        }
    }
}