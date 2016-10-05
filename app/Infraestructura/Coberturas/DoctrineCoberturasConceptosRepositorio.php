<?php
namespace GDI\Infraestructura\Coberturas;

use GDI\Aplicacion\Logger;
use Doctrine\ORM\EntityManager;
use GDI\Dominio\Coberturas\CoberturaConcepto;
use GDI\Dominio\Coberturas\Repositorios\CoberturasConceptosRepositorio;
use Monolog\Logger as Log;
use Monolog\Handler\StreamHandler;
use PDOException;

/**
 * Class DoctrineCoberturasConceptosRepositorio
 * @package GDI\Infraestructura\Coberturas
 * @author Gerardo Adrián Gómez Ruiz
 * @version 1.0
 */
class DoctrineCoberturasConceptosRepositorio implements CoberturasConceptosRepositorio
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
	 * @return CoberturaConcepto
	 */
	public function obtenerPorId($id, $oficinaId = null)
	{
		// TODO: Implement obtenerPorId() method.
		try {
			$query = $this->entityManager->createQuery('SELECT c FROM Coberturas:CoberturaConcepto c WHERE c.id = :id')
				->setParameter('id', $id);

			$coberturasConceptos = $query->getResult();

			if (count($coberturasConceptos) > 0) {
				return $coberturasConceptos[0];
			}

			return null;

		} catch (PDOException $e) {
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
		try {
			$query               = $this->entityManager->createQuery('SELECT c FROM Coberturas:CoberturaConcepto c ORDER BY c.concepto');
			$coberturasConceptos = $query->getResult();

			if (count($coberturasConceptos) > 0) {
				return $coberturasConceptos;
			}

			return null;

		} catch (PDOException $e) {
			$pdoLogger = new Logger(new Log('pdo_exception'), new StreamHandler(storage_path() . '/logs/pdo/sqlsrv_' . date('Y-m-d') . '.log', Log::ERROR));
			$pdoLogger->log($e);
			return null;
		}
	}
}