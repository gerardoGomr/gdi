<?php
namespace GDI\Infraestructura\Vehiculos;

use Doctrine\ORM\EntityManager;
use GDI\Aplicacion\Logger;
use GDI\Dominio\Vehiculos\Modalidad;
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
     * obtener una lista de modalidades
     *
     * @return array
     */
    public function obtenerTodos()
    {
        // TODO: Implement obtenerTodos() method.
        try {
            $modalidades = $this->entityManager->createQuery('SELECT m, o FROM Vehiculos:Modalidad m JOIN m.oficina o')
                ->getResult();

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
     * obtener una modalidad en base a su id
     *
     * @param int $id
     * @return Modalidad
     */
    public function obtenerPorId($id)
    {
        // TODO: Implement obtenerPorId() method.
        try {
            $modalidades = $this->entityManager->createQuery('SELECT m, o FROM Vehiculos:Modalidad m JOIN m.oficina o WHERE m.id = :id')
                ->setParameter('id', $id)
                ->getResult();

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
}