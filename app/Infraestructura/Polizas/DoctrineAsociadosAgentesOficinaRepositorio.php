<?php
namespace GDI\Infraestructura\Polizas;

use GDI\Aplicacion\Logger;
use Doctrine\ORM\EntityManager;
use GDI\Dominio\Oficinas\Oficina;
use GDI\Dominio\Polizas\AsociadoAgente;
use GDI\Dominio\Polizas\Repositorios\AsociadosAgentesRepositorio;
use Monolog\Logger as Log;
use Monolog\Handler\StreamHandler;
use PDOException;

/**
 * Class DoctrineAsociadosAgentesOficinaRepositorio
 * @package GDI\Infraestructura\Polizas
 * @author Gerardo Adrián Gómez Ruiz
 * @version 1.0
 */
class DoctrineAsociadosAgentesOficinaRepositorio implements AsociadosAgentesRepositorio
{
	/**
	 * @var EntityManager
	 */
	protected $entityManager;

	/**
	 * @var Oficina
	 */
	protected $oficina;

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
	 * obtener un asociado agente en base a su id
	 *
	 * @param int $id
	 * @return AsociadoAgente
	 */
	public function obtenerPorId($id)
	{
		// TODO: Implement obtenerPorId() method.
		try {

			$usuario = $this->entityManager->createQuery('SELECT a, d FROM Polizas:AsociadoAgente a LEFT JOIN a.domicilio d JOIN a.oficina o WHERE o.id = :oficina AND a.id = :id')
				->setParameter('id', $id)
				->setParameter('oficina', $this->oficina->getId())
				->getResult();

			if (count($usuario) > 0) {
				return $usuario[0];
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
		try {
			$asociados = $this->entityManager->createQuery("SELECT a, d, o FROM Polizas:AsociadoAgente a LEFT JOIN a.domicilio d JOIN a.oficina o WHERE o.id = :oficina ORDER BY a.nombre")
				->setParameter('oficina', $this->oficina->getId())
				->getResult();

			if (count() > 0) {
				return $asociados;
			}

			return null;

		} catch (PDOException $e) {
			$pdoLogger = new Logger(new Log('pdo_exception'), new StreamHandler(storage_path() . '/logs/pdo/sqlsrv_' . date('Y-m-d') . '.log', Log::ERROR));
			$pdoLogger->log($e);
			return null;
		}
	}
}