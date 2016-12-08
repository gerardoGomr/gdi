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
     * @param int|null $oficinaId
     * @return array
     */
    public function obtenerTodos($oficinaId = null)
    {
        // TODO: Implement obtenerTodos() method.
    }

    /**
     * obtener vehículo
     * @param int $id
     * @param int|null $oficinaId
     * @return Vehiculo
     */
    public function obtenerPorId($id, $oficinaId = null)
    {
        // TODO: Implement obtenerPorId() method.
        try {
            $query = $this->entityManager->createQuery('SELECT v, mo, mod, o FROM Vehiculos:Vehiculo v LEFT JOIN v.modelo mo LEFT JOIN v.modalidad mod JOIN v.oficina o WHERE v.id = :id AND o.id = :oficinaId')
                ->setParameter('id', $id)
                ->setParameter('oficinaId', $oficinaId);
            $usuario = $query->getResult();

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
     * obtener una lista de vehiculos en base al dato
     * @param string $dato
     * @param int $oficinaId
     * @return array
     */
    public function obtenerPor($dato, $oficinaId)
    {
        // TODO: Implement obtenerPor() method.
        $dato = str_replace(' ', '', $dato);

        try {
            $query = $this->entityManager->createQuery('SELECT v, mo, mod, o FROM Vehiculos:Vehiculo v LEFT JOIN v.modelo mo LEFT JOIN v.modalidad mod JOIN v.oficina o WHERE v.numeroSerie = :dato OR v.numeroMotor = :dato AND o.id = :oficinaId')
                ->setParameter('dato', $dato)
                ->setParameter('oficinaId', $oficinaId);
            $usuarios = $query->getResult();

            if (count($usuarios) > 0) {
                return $usuarios;
            }

            return null;

        } catch (PDOException $e) {
            $pdoLogger = new Logger(new Log('pdo_exception'), new StreamHandler(storage_path() . '/logs/pdo/sqlsrv_' . date('Y-m-d') . '.log', Log::ERROR));
            $pdoLogger->log($e);
            return null;
        }
    }
}