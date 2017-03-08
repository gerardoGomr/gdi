<?php
namespace GDI\Infraestructura\Coberturas;

use GDI\Aplicacion\Logger;
use Doctrine\ORM\EntityManager;
use GDI\Dominio\Coberturas\Repositorios\VigenciasRepositorio;
use GDI\Dominio\Coberturas\Vigencia;
use Monolog\Logger as Log;
use Monolog\Handler\StreamHandler;
use PDOException;

/**
 * Class DoctrineVigenciasRepositorio
 * @package GDI\Infraestructura\Coberturas
 * @author Gerardo Adrián Gómez Ruiz
 * @version 1.0
 */
class DoctrineVigenciasRepositorio implements VigenciasRepositorio
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
	 * @return Vigencia
	 */
	public function obtenerPorId($id)
	{
		// TODO: Implement obtenerPorId() method.
		try {
			$vigencias = $this->entityManager->createQuery('SELECT v FROM Coberturas:Vigencia v WHERE v.id = :id')
				->setParameter('id', $id)
				->getResult();

			if (count($vigencias) > 0) {
				return $vigencias[0];
			}

			return null;

		} catch (PDOException $e) {
			$pdoLogger = new Logger(new Log('pdo_exception'), new StreamHandler(storage_path() . '/logs/pdo/sqlsrv_' . date('Y-m-d') . '.log', Log::ERROR));
			$pdoLogger->log($e);
			return null;
		}
	}

	/**
	 * @return array
	 */
	public function obtenerTodos()
	{
		// TODO: Implement obtenerTodos() method.
		try {
			$vigencias = $this->entityManager->createQuery('SELECT v FROM Coberturas:Vigencia v ORDER BY v.vigencia')
				->getResult();

			if (count($vigencias) > 0) {
				return $vigencias;
			}

			return null;

		} catch (PDOException $e) {
			$pdoLogger = new Logger(new Log('pdo_exception'), new StreamHandler(storage_path() . '/logs/pdo/sqlsrv_' . date('Y-m-d') . '.log', Log::ERROR));
			$pdoLogger->log($e);
			return null;
		}
	}
}