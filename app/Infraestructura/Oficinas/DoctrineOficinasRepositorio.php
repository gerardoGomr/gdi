<?php
namespace GDI\Infraestructura\Oficinas;

use DateTime;
use GDI\Aplicacion\Logger;
use Doctrine\ORM\EntityManager;
use GDI\Dominio\Oficinas\Oficina;
use GDI\Dominio\Oficinas\Repositorios\OficinasRepositorio;
use Monolog\Logger as Log;
use Monolog\Handler\StreamHandler;
use PDOException;

/**
 * Class DoctrineOficinasRepositorio
 * @package GDI\Infraestructura\Oficinas
 * @author Gerardo Adrián Gómez Ruiz
 * @version 1.0
 */
class DoctrineOficinasRepositorio implements OficinasRepositorio
{
	/**
	 * @var EntityManager
	 */
	protected $entityManager;

    /**
     * @var Logger
     */
	protected $pdoLogger;

	/**
	 * DoctrineUsuariosRepositorio constructor.
	 * @param EntityManager $em
	 */
	public function __construct(EntityManager $em)
	{
		$this->entityManager = $em;
        $this->pdoLogger     = new Logger(new Log('pdo_exception'), new StreamHandler(storage_path() . '/logs/pdo/sqlsrv_' . date('Y-m-d') . '.log', Log::ERROR));
	}

	/**
	 * @param int $id
	 * @param int|null $oficinaId
	 * @return Oficina|null
	 */
	public function obtenerPorId($id, $oficinaId = null)
	{
		// TODO: Implement obtenerPorId() method.
		try {
			$query = $this->entityManager->createQuery("SELECT o FROM Oficinas:Oficina o WHERE o.id = :id")
				->setParameter('id', $id);
			$oficina = $query->getResult();

			if (count($oficina) > 0) {
				return $oficina[0];
			}

			return null;

		} catch (PDOException $e) {
			$this->pdoLogger->log($e);
			return null;
		}
	}

	/**
	 * @param null $oficinaId
	 * @return array
	 */
	public function obtenerTodos($oficinaId = null)
	{
		// TODO: Implement obtenerTodos() method.
	}

    /**
     * obtener una lista de oficinas, asociados agentes asignados y las pólizas de estos en
     * base a la fecha de la quicena
     *
     * @param DateTime $fechaInicial
     * @param DateTime $fechaFinal
     * @return array
     */
    public function obtenerOficinasConAsociadosYPolizasDeLaQuincena(DateTime $fechaInicial, DateTime $fechaFinal)
    {
        // TODO: Implement obtenerOficinasConAsociadosYPolizasDeLaQuincena() method.
        try {
            $oficinas = $this->entityManager->createQuery('SELECT o, a, p FROM Oficinas:Oficina o JOIN o.asociadosAgentes a JOIN a.polizas p WHERE p.fechaEmision BETWEEN :fecha1 AND :fecha2 AND p.estaPagada = true')
                ->setParameter('fecha1', $fechaInicial)
                ->setParameter('fecha2', $fechaFinal)
                ->getResult();

            if (count($oficinas) > 0) {
                return $oficinas;
            }

            return null;

        } catch (PDOException $e) {
            $this->pdoLogger->log($e);
            return null;
        }
    }
}