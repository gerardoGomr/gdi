<?php
namespace GDI\Infraestructura\Coberturas;

use GDI\Aplicacion\Logger;
use Doctrine\ORM\EntityManager;
use GDI\Dominio\Coberturas\Costo;
use GDI\Dominio\Coberturas\Repositorios\CostosRepositorio;
use Monolog\Logger as Log;
use Monolog\Handler\StreamHandler;

/**
 * Class DoctrineCostosRepositorio
 * @package GDI\Infraestructura\Coberturas
 * @author Gerardo Adrián Gómez Ruiz
 * @version 1.0
 */
class DoctrineCostosRepositorio implements CostosRepositorio
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
	 * @param int|null $oficinaId
	 * @return Costo
	 */
	public function obtenerPorId($id, $oficinaId = null)
	{
		// TODO: Implement obtenerPorId() method.
		try {
			$query = $this->entityManager->createQuery('SELECT c, v, m FROM Coberturas:Costo c JOIN c.vigencia v JOIN c.modalidad m WHERE c.id = :id')
					->setParameter('id', $id);

			$costo = $query->getResult();

			if (count($costo) > 0) {
				return $costo[0];
			}

			return null;

		} catch (\PDOException $e) {
			$pdoLogger = new Logger(new Log('pdo_exception'), new StreamHandler(storage_path() . '/logs/pdo/sqlsrv_' . date('Y-m-d') . '.log', Log::ERROR));
			$pdoLogger->log($e);
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
}