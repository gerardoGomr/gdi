<?php
namespace GDI\Infraestructura\Vehiculos;

use Doctrine\ORM\EntityManager;
use GDI\Aplicacion\Logger;
use GDI\Dominio\Vehiculos\Repositorios\ModelosRepositorio;
use Monolog\Logger as Log;
use Monolog\Handler\StreamHandler;

/**
 * Class DoctrineModelosRepositorio
 * @package GDI\Infraestructura\Vehiculos
 * @author Gerardo Adrián Gómez Ruiz
 * @version 1.0
 */
class DoctrineModelosRepositorio implements ModelosRepositorio
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
        try {
            $query       = $this->entityManager->createQuery('SELECT m, o FROM Vehiculos:Marca m JOIN m.oficinas o WHERE o.id = :id')->setParameter('id', $oficinaId);
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
     * @param int|null $oficinaId
     * @return mixed
     */
    public function obtenerPorId($id, $oficinaId = null)
    {
        // TODO: Implement obtenerPorId() method.
        try {
            $query  = $this->entityManager->createQuery('SELECT mo, m FROM Vehiculos:Modelo mo JOIN mo.marca m JOIN mo.oficina o WHERE mo.id = :id AND o.id = :oficinaId')
                ->setParameter('id', $id)
                ->setParameter('oficinaId', $oficinaId);
            $modelo = $query->getResult();

            if (count($modelo) > 0) {
                return $modelo[0];
            }

            return null;

        } catch (\PDOException $e) {
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

    }
}