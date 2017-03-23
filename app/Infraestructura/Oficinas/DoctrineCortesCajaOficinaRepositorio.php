<?php
namespace GDI\Infraestructura\Oficinas;

use GDI\Aplicacion\Logger;
use GDI\Dominio\Oficinas\CorteCaja;
use GDI\Dominio\Oficinas\Oficina;
use GDI\Dominio\Oficinas\Repositorios\CortesCajaRepositorio;
use Doctrine\ORM\EntityManager;
use Monolog\Logger as Log;
use Monolog\Handler\StreamHandler;
use PDOException;

/**
 * Class DoctrineCortesCajaOficinaRepositorio
 * @package GDI\Infraestructura\Usuarios
 * @author Gerardo Adrián Gómez Ruiz
 * @version 1.0
 */
class DoctrineCortesCajaOficinaRepositorio implements CortesCajaRepositorio
{
	/**
	 * @var Oficina
	 */
	private $oficina;

	/**
	 * @var EntityManager
	 */
	protected $entityManager;

	/**
	 * DoctrineUsuariosRepositorio constructor.
	 *
	 * @param EntityManager $em
	 * @param Oficina $oficina
	 */
	public function __construct(EntityManager $em, Oficina $oficina)
	{
		$this->entityManager = $em;
		$this->oficina       = $oficina;
	}

	/**
	 * @param int $id
	 * @return CorteCaja
	 */
	public function obtenerPorId($id)
	{
		// TODO: Implement obtenerPorId() method.
		try {
			$corteCaja = $this->entityManager->createQuery('SELECT c, a, o FROM Oficinas:CorteCaja c JOIN c.auditor a JOIN c.oficina o WHERE o.id = :id')
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
			$cortes = $this->entityManager->createQuery('SELECT c, a, o FROM Oficinas:CorteCaja c JOIN c.auditor a JOIN c.oficina o WHERE o.id = :oficinaId ORDER BY c.fecha DESC')
				->setParameter('oficinaId', $this->oficina->getId())
				->getResult();

			$this->entityManager->createQuery('SELECT c, p FROM Oficinas:CorteCaja c JOIN c.oficina o LEFT JOIN c.polizas p WHERE o.id = :oficinaId ORDER BY c.fecha DESC')
				->setParameter('oficinaId', $this->oficina->getId())
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

			$this->entityManager->createQuery('SELECT c, p FROM Oficinas:CorteCaja c LEFT JOIN c.polizas p WHERE c.fecha = :fecha')
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