<?php
namespace GDI\Infraestructura\Oficinas;

use GDI\Aplicacion\Logger;
use GDI\Dominio\Oficinas\CorteCaja;
use GDI\Dominio\Oficinas\Repositorios\CortesCajaRepositorio;
use Doctrine\ORM\EntityManager;
use Monolog\Logger as Log;
use Monolog\Handler\StreamHandler;
use PDOException;

/**
 * Class DoctrineCortesCajaRepositorio
 * @package GDI\Infraestructura\Usuarios
 * @author Gerardo Adrián Gómez Ruiz
 * @version 1.0
 */
class DoctrineCortesCajaRepositorio implements CortesCajaRepositorio
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
	 * @return CorteCaja
	 */
	public function obtenerPorId($id)
	{
		// TODO: Implement obtenerPorId() method.
		try {
			$corteCaja = $this->entityManager->createQuery('SELECT c, a, o FROM Oficinas:CorteCaja c JOIN c.auditor a JOIN c.oficina o WHERE c.id = :id')
				->setParameter('id', $id)
				->getResult();

			if (count($corteCaja) > 0) {
				return $corteCaja[0];
			}

			return null;

		} catch (PDOException $e) {
			$pdoLogger = new Logger(new Log('pdo_exception'), new StreamHandler(storage_path() . '/logs/pdo/sqlsrv_' . date('Y-m-d') . '.log', Log::ERROR));
			$pdoLogger->log($e);
			return null;
		}
	}

	/**
	 * devuelve la lista de cortes de caja
	 *
	 * @return array
	 */
	public function obtenerTodos()
	{
		// TODO: Implement obtenerTodos() method.
		try {
			$cortes = $this->entityManager->createQuery('SELECT c, a, o FROM Oficinas:CorteCaja c JOIN c.auditor a JOIN c.oficina o ORDER BY c.fecha DESC')
				->getResult();

			$this->entityManager->createQuery('SELECT c, pa FROM Oficinas:CorteCaja c LEFT JOIN c.polizasPagos pa JOIN pa.poliza p ORDER BY c.fecha DESC')
				->getResult();

			if (count($cortes) > 0) {
				return $cortes;
			}

			return null;

		} catch (PDOException $e) {
			$pdoLogger = new Logger(new Log('pdo_exception'), new StreamHandler(storage_path() . '/logs/pdo/sqlsrv_' . date('Y-m-d') . '.log', Log::ERROR));
			$pdoLogger->log($e);
			return null;
		}
	}

	/**
	 * persistir cambios del corte de caja
	 *
	 * @param CorteCaja $corteCaja
	 * @return bool
	 */
	public function persistir(CorteCaja $corteCaja)
	{
		// TODO: Implement persistir() method.
		try {
			if (is_null($corteCaja->getId())) {
				$this->entityManager->persist($corteCaja);
			}

			$this->entityManager->flush();

			return true;

		} catch (PDOException $e) {
			$pdoLogger = new Logger(new Log('pdo_exception'), new StreamHandler(storage_path() . '/logs/pdo/sqlsrv_' . date('Y-m-d') . '.log', Log::ERROR));
			$pdoLogger->log($e);
			return false;
		}
	}

	/**
	 * obtener cortes de caja en base a fecha
	 *
	 * @param string $fechaCorte
	 * @return CorteCaja|null
	 */
	public function obtenerPorFecha($fechaCorte)
	{
		// TODO: Implement obtenerPorFecha() method.
		try {
			$corte = $this->entityManager->createQuery('SELECT c, a, o FROM Oficinas:CorteCaja c JOIN c.auditor a JOIN c.oficina o WHERE c.fecha = :fecha')
				->setParameter('fecha', $fechaCorte)
				->getResult();

			$this->entityManager->createQuery('SELECT c, p FROM Oficinas:CorteCaja c LEFT JOIN c.polizasPagos p WHERE c.fecha = :fecha')
				->setParameter('fecha', $fechaCorte)
				->getResult();

			if (count($corte) > 0) {
				return $corte[0];
			}

			return null;

		} catch (PDOException $e) {
			$pdoLogger = new Logger(new Log('pdo_exception'), new StreamHandler(storage_path() . '/logs/pdo/sqlsrv_' . date('Y-m-d') . '.log', Log::ERROR));
			$pdoLogger->log($e);
			return null;
		}
	}
}