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
	 * obtener póliza por id
	 * @param int $id
	 * @return Poliza
	 */
	public function obtenerPorId($id)
	{
		// TODO: Implement obtenerPorId() method.
		try {

			$poliza = $this->entityManager->createQuery('SELECT p, a, v, c, co, vi, m, ma, s, o FROM Polizas:Poliza p JOIN p.asociadoAgente a JOIN p.vehiculo v JOIN p.cobertura c JOIN p.costo co JOIN co.vigencia vi JOIN v.modelo m JOIN m.marca ma JOIN c.servicio s JOIN p.oficina o WHERE p.id = :id AND p.activa = 1')
				->setParameter('id', $id)
				->getResult();


			if (count($poliza) > 0) {
				return $poliza[0];
			}

			return null;

		} catch (PDOException $e) {
			$pdoLogger = new Logger(new Log('pdo_exception'), new StreamHandler(storage_path() . '/logs/pdo/sqlsrv_' . date('Y-m-d') . '.log', Log::ERROR));
			$pdoLogger->log($e);
			return null;
		}
	}

	/**
	 * obtener lista de pólizas
	 *
	 * @return array|null
	 */
	public function obtenerTodos()
	{
		// TODO: Implement obtenerTodos() method.
		try {
			$polizas = $this->entityManager->createQuery("SELECT p, a, v, c, co, vi, m, o FROM Polizas:Poliza p JOIN p.asociadoAgente a JOIN p.vehiculo v JOIN p.cobertura c JOIN p.costo co JOIN co.vigencia vi JOIN v.modelo m JOIN p.oficina o WHERE p.activa = 1 ORDER BY p.id")
				->setMaxResults(50)
				->getResult();

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
	 * obtener lista de pólizas en base al dato de búsqueda
	 *
	 * @param string $dato
	 * @return array|null
	 */
	public function obtenerPorVehiculo($dato)
	{
		try {

			$polizas = $this->entityManager->createQuery("SELECT p, a, v, c, co, vi, m, o FROM Polizas:Poliza p JOIN p.asociadoAgente a JOIN p.vehiculo v JOIN p.cobertura c JOIN p.costo co JOIN co.vigencia vi JOIN v.modelo m JOIN p.oficina o WHERE v.numeroSerie LIKE :dato OR v.numeroMotor LIKE :dato ORDER BY p.id")
				->setParameter('dato', "%$dato%")
				->setMaxResults(50)
				->getResult();

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
	 * obtener polizas en base a los parámetros de búsqueda
	 *
	 * @param array $parametros
	 * @return array|null
	 */
	public function obtenerPor(array $parametros)
	{
		try {
			$queryString = '';

			if (array_key_exists('estatus', $parametros)) {
				$queryString .= ' AND p.activa = :activa';
			}

			if (array_key_exists('entreFechaEmision', $parametros)) {
				if (array_key_exists('yFechaEmision', $parametros)) {
					$queryString .= ' AND p.fechaEmision BETWEEN :entreFechaEmision AND :yFechaEmision';
				} else {
					$queryString .= ' AND p.fechaEmision = :entreFechaEmision';
				}
			} else {
				if (array_key_exists('yFechaEmision', $parametros)) {
					$queryString .= ' AND p.fechaEmision = :yFechaEmision';
				}
			}

			if (array_key_exists('entreFechaVigencia', $parametros)) {
				if (array_key_exists('yFechaVigencia', $parametros)) {
					$queryString .= ' AND p.fechaVigencia BETWEEN :entreFechaVigencia AND :yFechaVigencia';
				} else {
					$queryString .= ' AND p.fechaVigencia = :entreFechaEmision';
				}
			} else {
				if (array_key_exists('yFechaVigencia', $parametros)) {
					$queryString .= ' AND p.fechaVigencia = :yFechaVigencia';
				}
			}

			$polizas = $this->entityManager->createQuery("SELECT p, a, v, c, co, vi, m, o FROM Polizas:Poliza p JOIN p.asociadoAgente a JOIN p.vehiculo v JOIN p.cobertura c JOIN p.costo co JOIN co.vigencia vi JOIN v.modelo m JOIN p.oficina o WHERE p.id IS NOT NULL $queryString ORDER BY p.id")
				->setParameters($parametros)
				->setMaxResults(50)
				->getResult();

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
	 * obtener pagos de la póliza
	 *
	 * @param string $fecha
	 * @return array|null
	 */
	public function obtenerPorFechaPago($fecha)
	{
		try {
			$polizasPagos = $this->entityManager->createQuery("SELECT pa, p, a, v, c, co, vi, m, o FROM Pagos:PolizaPago pa JOIN pa.poliza p JOIN p.asociadoAgente a JOIN p.vehiculo v JOIN p.cobertura c JOIN p.costo co JOIN co.vigencia vi JOIN v.modelo m JOIN p.oficina o WHERE pa.fechaPago = :fechaPago ORDER BY p.id")
				->setParameter('fechaPago', $fecha)
				->getResult();

			if (count($polizasPagos) > 0) {
				return $polizasPagos;
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
	 *
	 * @param Poliza $poliza
	 * @return bool
	 */
	public function persistir(Poliza $poliza)
	{
		try {
			if (is_null($poliza->getId())) {
				$this->entityManager->persist($poliza);
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