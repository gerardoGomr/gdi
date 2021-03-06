<?php
namespace GDI\Infraestructura\Polizas;

use GDI\Aplicacion\Logger;

use Doctrine\ORM\EntityManager;
use GDI\Dominio\Polizas\Repositorios\ServiciosRepositorio;
use Monolog\Logger as Log;
use Monolog\Handler\StreamHandler;

/**
 * Class DoctrineServiciosOficinaRepositorio
 * @package GDI\Infraestructura\Polizas
 * @author Gerardo Adrián Gómez Ruiz
 * @version 1.0
 */
class DoctrineServiciosOficinaRepositorio implements ServiciosRepositorio
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
	 * @param int $id
	 * @return array
	 */
	public function obtenerPorId($id)
	{
		// TODO: Implement obtenerPorId() method.
		try {
			$query = $this->entityManager->createQuery('SELECT s FROM Polizas:Servicio s WHERE s.id = :id')
					->setParameter('id', $id);

			$servicios = $query->getResult();

			if (count($servicios) > 0) {
				return $servicios[0];
			}

			return null;

		} catch (\PDOException $e) {
			$pdoLogger = new Logger(new Log('pdo_exception'), new StreamHandler(storage_path() . '/logs/pdo/sqlsrv_' . date('Y-m-d') . '.log', Log::ERROR));
			$pdoLogger->log($e);
			return null;
		}
	}

	/**
	 * @return array|null
	 */
	public function obtenerTodos()
	{
		// TODO: Implement obtenerTodos() method.
		try {
			$query = $this->entityManager->createQuery("SELECT s FROM Polizas:Servicio s ORDER BY s.servicio");
			$servicios = $query->getResult();

			if (count($servicios) > 0) {
				return $servicios;
			}

			return null;

		} catch (\PDOException $e) {
			$pdoLogger = new Logger(new Log('pdo_exception'), new StreamHandler(storage_path() . '/logs/pdo/sqlsrv_' . date('Y-m-d') . '.log', Log::ERROR));
			$pdoLogger->log($e);
			return null;
		}
	}
}