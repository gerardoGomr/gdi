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
	 * @param null $oficinaId
	 * @param Modalidad|null $modalidad
	 * @return Cobertura
	 */
	public function obtenerPorId($id, $oficinaId = null, Modalidad $modalidad = null)
	{
		// TODO: Implement obtenerPorId() method.
		try {
			$query = $this->entityManager->createQuery('SELECT c, o, s, co FROM Coberturas:Cobertura c JOIN c.oficina o JOIN c.servicio s JOIN c.costos co JOIN co.modalidad m WHERE c.id = :id AND m.id = :modalidadId')
					->setParameter('id', $id)
					->setParameter('modalidadId', $modalidad->getId());

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
	 * @param null $oficinaId
	 * @return array
	 */
	public function obtenerTodos($oficinaId = null)
	{
		// TODO: Implement obtenerTodos() method.
	}

	/**
	 * @param Servicio $servicio
	 * @param int $coberturaTipo
	 * @param int $oficinaId
	 * @return array|null
	 */
	public function obtenerPorServicioCoberturaTipo(Servicio $servicio, $coberturaTipo, $oficinaId)
	{
		// TODO: Implement obtenerPorServicioCoberturaTipo() method.
		try {
			$query = $this->entityManager->createQuery('SELECT c, o, s FROM Coberturas:Cobertura c JOIN c.oficina o JOIN c.servicio s WHERE s.id = :servicioId AND c.coberturaTipo = :coberturaTipoId AND o.id = :oficinaId')
					->setParameter('servicioId', $servicio->getId())
					->setParameter('coberturaTipoId', $coberturaTipo)
					->setParameter('oficinaId', $oficinaId);

			$coberturas = $query->getResult();

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
}