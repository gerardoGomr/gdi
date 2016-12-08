<?php
namespace GDI\Infraestructura\Vehiculos;

use Doctrine\ORM\EntityManager;
use GDI\Aplicacion\Logger;
use GDI\Dominio\Vehiculos\Repositorios\ModalidadesRepositorio;
use Monolog\Logger as Log;
use Monolog\Handler\StreamHandler;
use PDOException;

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
     * @param int|null $oficinaId
     * @return array
     */
    public function obtenerTodos($oficinaId = null)
    {
        // TODO: Implement obtenerTodos() method.
        try {
            $query       = $this->entityManager->createQuery('SELECT m, o FROM Vehiculos:Modalidad m JOIN m.oficina o WHERE o.id = :id')->setParameter('id', $oficinaId);
            $modalidades = $query->getResult();

            if (count($modalidades) > 0) {
                return $modalidades;
            }

            return null;

        } catch (PDOException $e) {
            $pdoLogger = new Logger(new Log('pdo_exception'), new StreamHandler(storage_path() . '/logs/pdo/sqlsrv_' . date('Y-m-d') . '.log', Log::ERROR));
            $pdoLogger->log($e);
            return null;
        }
    }

    /**
     * @param int $id
     * @param null $oficinaId
     * @return mixed
     */
    public function obtenerPorId($id, $oficinaId = null)
    {
        // TODO: Implement obtenerPorId() method.
        try {
            $query       = $this->entityManager->createQuery('SELECT m, o FROM Vehiculos:Modalidad m JOIN m.oficina o WHERE m.id = :id AND o.id = :oficinaId')
                ->setParameter('id', $id)
                ->setParameter('oficinaId', $oficinaId);

            $modalidades = $query->getResult();

            if (count($modalidades) > 0) {
                return $modalidades[0];
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

    }
}