<?php
namespace GDI\Infraestructura\Polizas;

use GDI\Aplicacion\Logger;

use Doctrine\ORM\EntityManager;
use GDI\Dominio\Oficinas\Oficina;
use GDI\Dominio\Polizas\Poliza;
use GDI\Dominio\Polizas\Repositorios\PolizasRepositorio;
use Monolog\Logger as Log;
use Monolog\Handler\StreamHandler;
use PDOException;

/**
 * Class DoctrinePolizasRepositorio
 * @package GDI\Infraestructura\Polizas
 * @author Gerardo Adrián Gómez Ruiz
 * @version 1.0
 */
class DoctrinePolizasRepositorio implements PolizasRepositorio
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
	 * @return array
	 */
	public function obtenerPorId($id, $oficinaId = null)
	{
		// TODO: Implement obtenerPorId() method.
		try {
			$query = $this->entityManager->createQuery('SELECT p, a, v, c, co, vi, m FROM Polizas:Poliza p JOIN p.asociadoAgente a JOIN p.vehiculo v JOIN p.cobertura c JOIN p.costo co JOIN co.vigencia vi JOIN v.modelo m WHERE p.id = :id')
				->setParameter('id', $id);

			$cobertura = $query->getResult();

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
	 * @param int|null $oficinaId
	 * @return array|null
	 */
	public function obtenerTodos($oficinaId = null)
	{
		// TODO: Implement obtenerTodos() method.
		try {
			$query = $this->entityManager->createQuery('SELECT p, a, v, c, co, vi, m FROM Polizas:Poliza p JOIN p.asociadoAgente a JOIN p.vehiculo v JOIN p.cobertura c JOIN p.costo co JOIN co.vigencia vi JOIN v.modelo m ORDER BY p.id');
			$polizas = $query->getResult();

			if (count($polizas) > 0) {
				return $polizas;
			}

			return null;

		} catch (PDOException $e) {
			$pdoLogger = new Logger(new Log('pdo_exception'), new StreamHandler(storage_path() . '/logs/pdo/sqlsrv_' . date('Y-m-d') . '.log', Log::ERROR));
			$pdoLogger->log($e);
			return null;
		}
	}

	/**
	 * guardar o editar una póliza
	 * @param Poliza $poliza
	 * @return bool
	 */
	public function persistir(Poliza $poliza)
	{
		try {
			$this->entityManager->persist($poliza);
			$this->entityManager->flush();

			return true;

		} catch (PDOException $e) {
			$pdoLogger = new Logger(new Log('pdo_exception'), new StreamHandler(storage_path() . '/logs/pdo/sqlsrv_' . date('Y-m-d') . '.log', Log::ERROR));
			$pdoLogger->log($e);
			return false;
		}
	}

	/**
	 * obtener una oficina por id
	 * @param int $oficinaId
	 * @return Oficina
	 */
	public function obtenerOficinaPorId($oficinaId)
	{
		try {
			$query = $this->entityManager->createQuery("SELECT o FROM Oficinas:Oficina o WHERE o.id = :id")
				->setParameter('id', $oficinaId);
			$oficina = $query->getResult();

			if (count($oficina) > 0) {
				return $oficina[0];
			}

			return null;

		} catch (PDOException $e) {
			$pdoLogger = new Logger(new Log('pdo_exception'), new StreamHandler(storage_path() . '/logs/pdo/sqlsrv_' . date('Y-m-d') . '.log', Log::ERROR));
			$pdoLogger->log($e);
			return null;
		}
	}

	/**
	 * actualizar cambios realizados al objeto Poliza en la BD
	 * @param Poliza $poliza
	 * @return bool
	 */
	public function actualizar(Poliza $poliza)
	{
		try {
			$this->entityManager->flush();

			return true;

		} catch (PDOException $e) {
			$pdoLogger = new Logger(new Log('pdo_exception'), new StreamHandler(storage_path() . '/logs/pdo/sqlsrv_' . date('Y-m-d') . '.log', Log::ERROR));
			$pdoLogger->log($e);
			return false;
		}
	}

	/**
	 * obtener una Vigencia por su id
	 * @param int $vigenciaId
	 * @return Vigencia
	 */
	public function obtenerVigenciaPorId($vigenciaId)
	{
		try {
			$query = $this->entityManager->createQuery('SELECT v FROM Coberturas:Vigencia v WHERE v.id = :vigenciaId')
					->setParameter('vigenciaId', $vigenciaId);

			$vigencia = $query->getResult();

			if (count($vigencia) > 0) {
				return $vigencia[0];
			}

			return null;

		} catch (PDOException $e) {
			$pdoLogger = new Logger(new Log('pdo_exception'), new StreamHandler(storage_path() . '/logs/pdo/sqlsrv_' . date('Y-m-d') . '.log', Log::ERROR));
			$pdoLogger->log($e);
			return null;
		}
	}

	/**
	 * obtener costo por Id
	 * @param int $costoId
	 * @return Costo
	 */
	public function obtenerCostoPorId($costoId)
	{
		try {
			$query = $this->entityManager->createQuery('SELECT c, v, m FROM Coberturas:Costo c JOIN c.vigencia v JOIN c.modalidad m WHERE c.id = :costoId')
					->setParameter('costoId', $id);

			$costo = $query->getResult();

			if (count($costo) > 0) {
				return $costo[0];
			}

			return null;

		} catch (PDOException $e) {
			$pdoLogger = new Logger(new Log('pdo_exception'), new StreamHandler(storage_path() . '/logs/pdo/sqlsrv_' . date('Y-m-d') . '.log', Log::ERROR));
			$pdoLogger->log($e);
			return null;
		}
	}
}