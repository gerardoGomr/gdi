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
			$query = $this->entityManager->createQuery('SELECT p, a, v, c, co, vi, m, ma FROM Polizas:Poliza p JOIN p.asociadoAgente a JOIN p.vehiculo v JOIN p.cobertura c JOIN p.costo co JOIN co.vigencia vi JOIN v.modelo m JOIN m.marca ma WHERE p.id = :id')
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
			$query = $this->entityManager->createQuery('SELECT p, a, v, c, co, vi, m FROM Polizas:Poliza p JOIN p.asociadoAgente a JOIN p.vehiculo v JOIN p.cobertura c JOIN p.costo co JOIN co.vigencia vi JOIN v.modelo m WHERE p.activa = 1 ORDER BY p.id')
				->setMaxResults(50);
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
	 * buscar pólizas dependiendo el dato del vehículo (número de serie o motor)
	 * @param string $dato
	 * @param int|null $oficinaId
	 * @return array|null
	 */
	public function obtenerPorVehiculo($dato, $oficinaId = null)
	{
		try {
			$query = $this->entityManager->createQuery('SELECT p, a, v, c, co, vi, m FROM Polizas:Poliza p JOIN p.asociadoAgente a JOIN p.vehiculo v JOIN p.cobertura c JOIN p.costo co JOIN co.vigencia vi JOIN v.modelo m WHERE v.numeroSerie LIKE :dato OR v.numeroMotor LIKE :dato ORDER BY p.id')
				->setMaxResults(50)
				->setParameter('dato', "%$dato%");
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
	 * obtener polizas en base a los parámetros de búsqueda
	 * @param array $parametros
	 * @return array|null
	 */
	public function obtenerPor(array $parametros)
	{
		try {
			$queryString = '';

			if (!is_null($parametros['estatus'])) {
				$queryString .= ' AND p.activa = :activa';
			}

			if (!is_null($parametros['entreFechaEmision'])) {
				if (!is_null($parametros['yFechaEmision'])) {
					$queryString .= ' AND p.fechaEmision BETWEEN :entreFechaEmision AND :yFechaEmision';
				} else {
					$queryString .= ' AND p.fechaEmision = :entreFechaEmision';
				}
			} else {
				if (!is_null($parametros['yFechaEmision'])) {
					$queryString .= ' AND p.fechaEmision = :yFechaEmision';
				}
			}

			if (!is_null($parametros['entreFechaVigencia'])) {
				if (!is_null($parametros['yFechaVigencia'])) {
					$queryString .= ' AND p.fechaVigencia BETWEEN :entreFechaVigencia AND :yFechaVigencia';
				} else {
					$queryString .= ' AND p.fechaVigencia = :entreFechaEmision';
				}
			} else {
				if (!is_null($parametros['yFechaVigencia'])) {
					$queryString .= ' AND p.fechaVigencia = :yFechaVigencia';
				}
			}

			$query = $this->entityManager->createQuery("SELECT p, a, v, c, co, vi, m FROM Polizas:Poliza p JOIN p.asociadoAgente a JOIN p.vehiculo v JOIN p.cobertura c JOIN p.costo co JOIN co.vigencia vi JOIN v.modelo m WHERE p.id IS NOT NULL $queryString ORDER BY p.id")
					->setMaxResults(50);

			if (!is_null($parametros['estatus'])) {
				$query->setParameter('activa', $parametros['estatus']);
			}

			if (!is_null($parametros['entreFechaEmision'])) {
				if (!is_null($parametros['yFechaEmision'])) {
					$query->setParameter('entreFechaEmision', $parametros['entreFechaEmision']);
					$query->setParameter('yFechaEmision', $parametros['yFechaEmision']);

				} else {
					$query->setParameter('entreFechaEmision', $parametros['entreFechaEmision']);
				}
			} else {
				if (!is_null($parametros['yFechaEmision'])) {
					$query->setParameter('yFechaEmision', $parametros['yFechaEmision']);
				}
			}

			if (!is_null($parametros['entreFechaVigencia'])) {
				if (!is_null($parametros['yFechaVigencia'])) {
					$query->setParameter('entreFechaVigencia', $parametros['entreFechaVigencia']);
					$query->setParameter('yFechaVigencia', $parametros['yFechaVigencia']);

				} else {
					$query->setParameter('entreFechaVigencia', $parametros['entreFechaVigencia']);
				}
			} else {
				if (!is_null($parametros['yFechaVigencia'])) {
					$query->setParameter('yFechaVigencia', $parametros['yFechaVigencia']);
				}
			}

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
}