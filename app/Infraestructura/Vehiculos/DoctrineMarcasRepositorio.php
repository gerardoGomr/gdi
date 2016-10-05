<?php
namespace GDI\Infraestructura\Vehiculos;

use Doctrine\ORM\EntityManager;
use GDI\Aplicacion\Logger;
use GDI\Dominio\Vehiculos\Repositorios\MarcasRepositorio;
use Monolog\Logger as Log;
use Monolog\Handler\StreamHandler;

/**
 * Class DoctrineMarcasRepositorio
 * @package GDI\Infraestructura\Vehiculos
 * @author Gerardo Adrián Gómez Ruiz
 * @version 1.0
 */
class DoctrineMarcasRepositorio implements MarcasRepositorio
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
            $query       = $this->entityManager->createQuery('SELECT m, o FROM Vehiculos:Marca m JOIN m.oficinas o');
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
            $query  = $this->entityManager->createQuery('SELECT m, mo FROM Vehiculos:Marca m LEFT JOIN m.modelos mo WHERE m.id = :id')
                ->setParameter('id', $id);

            $marcas = $query->getResult();

            if (count($marcas) > 0) {
                return $marcas[0];
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