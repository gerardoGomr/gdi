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
 * Class DoctrineAsociadosAgentesRepositorio
 * @package GDI\Infraestructura\Polizas
 * @author Gerardo Adrián Gómez Ruiz
 * @version 1.0
 */
class DoctrineAsociadosAgentesRepositorio implements AsociadosAgentesRepositorio
{
	/**
	 * @var EntityManager
	 */
	protected $entityManager;

	/**
	 * DoctrineUsuariosRepositorio constructor.
	 *
	 * @param EntityManager $em
	 */
	public function __construct(EntityManager $em)
	{
		$this->entityManager = $em;
	}

	/**
	 * obtener un asociado agente en base a su id
	 * @param int $id
	 * @return AsociadoAgente
	 */
	public function obtenerPorId($id)
	{
		// TODO: Implement obtenerPorId() method.
		try {

			$usuario = $this->entityManager->createQuery('SELECT a, d FROM Polizas:AsociadoAgente a LEFT JOIN a.domicilio d JOIN a.oficina o WHERE a.id = :id')
				->setParameter('id', $id)
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
			$asociados = $this->entityManager->createQuery("SELECT a, d, o FROM Polizas:AsociadoAgente a LEFT JOIN a.domicilio d JOIN a.oficina o ORDER BY a.nombre")
				->getResult();

			if (count($asociados) > 0) {
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