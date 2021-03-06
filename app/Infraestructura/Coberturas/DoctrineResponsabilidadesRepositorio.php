<?php
namespace GDI\Infraestructura\Coberturas;

use GDI\Aplicacion\Logger;
use Doctrine\ORM\EntityManager;
use GDI\Dominio\Coberturas\Repositorios\ResponsabilidadesRepositorio;
use GDI\Dominio\Coberturas\ResponsabilidadCobertura;
use Monolog\Logger as Log;
use Monolog\Handler\StreamHandler;
use PDOException;

/**
 * Class DoctrineResponsabilidadesRepositorio
 * @package GDI\Infraestructura\Coberturas
 * @author Gerardo Adrián Gómez Ruiz
 * @version 1.0
 */
class DoctrineResponsabilidadesRepositorio implements ResponsabilidadesRepositorio
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
	 * @param null $oficinaId
	 * @return ResponsabilidadCobertura|null
	 */
	public function obtenerPorId($id, $oficinaId = null)
	{
		// TODO: Implement obtenerPorId() method.
		try {
			$query = '';

			if (!is_null($oficinaId)) {
				$query = 'SELECT r, c FROM Coberturas:ResponsabilidadCobertura r JOIN r.coberturaConcepto c WHERE r.id = :id';
			} else {
				$query = 'SELECT r, c FROM Coberturas:ResponsabilidadCobertura r JOIN r.coberturaConcepto c WHERE r.id = :id';
			}

			$query = $this->entityManager->createQuery($query)
					->setParameter('id', $id);

			if (!is_null($oficinaId)) {
				$query->setParameter('oficinaId', $oficinaId);
			}

			$responsabilidad = $query->getResult();

			if (count($responsabilidad) > 0) {
				return $responsabilidad[0];
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
	}

	/**
	 * obtener responsabilidades en base al concepto id
	 * @param int $coberturaConceptoId
	 * @param int|null $oficinaId
	 * @return array|null
	 */
	public function obtenerPorCoberturaConceptoId($coberturaConceptoId, $oficinaId = null)
	{
		try {
			$query = '';

			if (!is_null($oficinaId)) {
				$query = 'SELECT r, c FROM Coberturas:ResponsabilidadCobertura r JOIN r.coberturaConcepto c WHERE c.id = :coberturaConceptoId';
			} else {
				$query = 'SELECT r, c FROM Coberturas:ResponsabilidadCobertura r JOIN r.coberturaConcepto c WHERE c.id = :coberturaConceptoId';
			}

			$query = $this->entityManager->createQuery($query)
					->setParameter('coberturaConceptoId', $coberturaConceptoId);

			if (!is_null($oficinaId)) {
				$query->setParameter('oficinaId', $oficinaId);
			}

			$responsabilidades = $query->getResult();

			if (count($responsabilidades) > 0) {
				return $responsabilidades;
			}

			return null;

		} catch (PDOException $e) {
			$pdoLogger = new Logger(new Log('pdo_exception'), new StreamHandler(storage_path() . '/logs/pdo/sqlsrv_' . date('Y-m-d') . '.log', Log::ERROR));
			$pdoLogger->log($e);
			return null;
		}
	}
}