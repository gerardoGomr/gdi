<?php
namespace GDI\Infraestructura\Coberturas;

use GDI\Aplicacion\Logger;
use GDI\Dominio\Coberturas\Cobertura;
use GDI\Dominio\Coberturas\Repositorios\CoberturasRepositorio;
use Doctrine\ORM\EntityManager;
use GDI\Dominio\Polizas\Servicio;
use GDI\Dominio\Vehiculos\Modalidad;
use Monolog\Logger as Log;
use Monolog\Handler\StreamHandler;
use PDOException;

/**
 * Class DoctrineCoberturasRepositorio
 * @package GDI\Infraestructura\Coberturas
 * @author Gerardo Adrián Gómez Ruiz
 * @version 1.0
 */
class DoctrineCoberturasRepositorio implements CoberturasRepositorio
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
	 * @param Modalidad|null $modalidad
	 * @return Cobertura
	 */
	public function obtenerPorId($id, Modalidad $modalidad = null)
	{
		// TODO: Implement obtenerPorId() method.
		try {
			if (is_null($modalidad)) {
				$query = 'SELECT c, o, s, r, co FROM Coberturas:Cobertura c JOIN c.oficina o JOIN c.servicio s LEFT JOIN c.responsabilidades r LEFT JOIN c.costos co WHERE c.id = :id';
			} else {
				$query = 'SELECT c, o, s, r, co FROM Coberturas:Cobertura c JOIN c.oficina o JOIN c.servicio s LEFT JOIN c.responsabilidades r LEFT JOIN c.costos co LEFT JOIN co.modalidad m WHERE c.id = :id AND m.id = :modalidadId';
			}

			$cobertura = $this->entityManager->createQuery($query)
				->setParameter('id', $id);

			if (!is_null($modalidad)) {
				$cobertura->setParameter('modalidadId', $modalidad->getId());
			}

			$cobertura = $cobertura->getResult();

			if (count($cobertura) > 0) {
				return $cobertura[0];
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
	}

	/**
	 * obtener coberturas en base a $servicio y $coberturaTipo
	 *
	 * @param Servicio $servicio
	 * @param int $coberturaTipo
	 * @return array|null
	 */
	public function obtenerPorServicioCoberturaTipo(Servicio $servicio, $coberturaTipo)
	{
		// TODO: Implement obtenerPorServicioCoberturaTipo() method.
		try {
			$coberturas = $this->entityManager->createQuery('SELECT c, o, s FROM Coberturas:Cobertura c JOIN c.oficina o JOIN c.servicio s WHERE s.id = :servicioId AND c.coberturaTipo = :coberturaTipoId')
				->setParameter('servicioId', $servicio->getId())
				->setParameter('coberturaTipoId', $coberturaTipo)
				->getResult();

			if (count($coberturas) > 0) {
				return $coberturas;
			}

			return null;

		} catch (PDOException $e) {
			$pdoLogger = new Logger(new Log('pdo_exception'), new StreamHandler(storage_path() . '/logs/pdo/sqlsrv_' . date('Y-m-d') . '.log', Log::ERROR));
			$pdoLogger->log($e);
			return null;
		}
	}

	/**
	 * persistir cambios de cobertura
	 * @param Cobertura $cobertura
	 * @return bool
	 */
	public function persistir(Cobertura $cobertura)
	{
		try {
			if (is_null($cobertura->getId())) {
				$this->entityManager->persist($cobertura);
			}

			$this->entityManager->flush();

			return true;

		} catch (PDOException $e) {
			$pdoLogger = new Logger(new Log('pdo_exception'), new StreamHandler(storage_path() . '/logs/pdo/sqlsrv_' . date('Y-m-d') . '.log', Log::ERROR));
			$pdoLogger->log($e);
			return false;
		}
	}
}