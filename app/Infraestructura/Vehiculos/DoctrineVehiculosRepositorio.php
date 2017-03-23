<?php
namespace GDI\Infraestructura\Vehiculos;

use Doctrine\ORM\EntityManager;
use GDI\Aplicacion\Logger;
use GDI\Dominio\Vehiculos\Repositorios\VehiculosRepositorio;
use GDI\Dominio\Vehiculos\Vehiculo;
use Monolog\Logger as Log;
use Monolog\Handler\StreamHandler;
use PDOException;

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
     * obtener vehículo
     * @param int $id
     * @return Vehiculo
     */
    public function obtenerPorId($id)
    {
        // TODO: Implement obtenerPorId() method.
        try {
            $vehiculo = $this->entityManager->createQuery('SELECT v, mo, mod, o FROM Vehiculos:Vehiculo v LEFT JOIN v.modelo mo LEFT JOIN v.modalidad mod JOIN v.oficina o WHERE v.id = :id AND o.id = :oficinaId')
                ->setParameter('id', $id)
                ->getResult();

            if (count($vehiculo) > 0) {
                return $vehiculo[0];
            }

            return null;

        } catch (PDOException $e) {
            $pdoLogger = new Logger(new Log('pdo_exception'), new StreamHandler(storage_path() . '/logs/pdo/sqlsrv_' . date('Y-m-d') . '.log', Log::ERROR));
            $pdoLogger->log($e);
            return null;
        }
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
            $vehiculo = $this->entityManager->createQuery('SELECT v, mo, mod, o FROM Vehiculos:Vehiculo v LEFT JOIN v.modelo mo LEFT JOIN v.modalidad mod JOIN v.oficina o WHERE v.numeroSerie = :dato OR v.numeroMotor = :dato')
                ->setParameter('dato', $dato)
                ->getResult();

            if (count($vehiculo) > 0) {
                return $vehiculo;
            }

            return null;

        } catch (PDOException $e) {
            $pdoLogger = new Logger(new Log('pdo_exception'), new StreamHandler(storage_path() . '/logs/pdo/sqlsrv_' . date('Y-m-d') . '.log', Log::ERROR));
            $pdoLogger->log($e);
            return null;
        }
    }
}