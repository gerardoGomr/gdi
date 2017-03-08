<?php
namespace GDI\Infraestructura\Vehiculos;

use Doctrine\ORM\EntityManager;
use GDI\Aplicacion\Logger;
use GDI\Dominio\Oficinas\Oficina;
use GDI\Dominio\Vehiculos\Modalidad;
use GDI\Dominio\Vehiculos\Repositorios\ModalidadesRepositorio;
use Monolog\Logger as Log;
use Monolog\Handler\StreamHandler;
use PDOException;

/**
 * Class DoctrineModalidadesOficinaRepositorio
 * @package GDI\Infraestructura\Vehiculos
 * @author Gerardo Adrián Gómez Ruiz
 * @version 1.0
 */
class DoctrineModalidadesOficinaRepositorio implements ModalidadesRepositorio
{
    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * @var Oficina
     */
    protected $oficina;

    /**
     * DoctrineUsuariosRepositorio constructor.
     *
     * @param EntityManager $em
     * @param Oficina $oficina
     */
    public function __construct(EntityManager $em, Oficina $oficina)
    {
        $this->entityManager = $em;
        $this->oficina       = $oficina;
    }

    /**
     * @return array
     */
    public function obtenerTodos()
    {
        // TODO: Implement obtenerTodos() method.
        try {
            $modalidades = $this->entityManager->createQuery('SELECT m, o FROM Vehiculos:Modalidad m JOIN m.oficina o WHERE o.id = :oficina')
                ->setParameter('oficina', $this->oficina->getId())
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
     * @param int $id
     * @return Modalidad
     */
    public function obtenerPorId($id)
    {
        // TODO: Implement obtenerPorId() method.
        try {
            $modalidades = $this->entityManager->createQuery('SELECT m, o FROM Vehiculos:Modalidad m JOIN m.oficina o WHERE m.id = :id AND o.id = :oficina')
                ->setParameter('id', $id)
                ->setParameter('oficina', $this->oficina->getId())
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