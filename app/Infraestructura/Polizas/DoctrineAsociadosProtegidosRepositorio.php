<?php
namespace GDI\Infraestructura\Polizas;

use GDI\Aplicacion\Logger;

use Doctrine\ORM\EntityManager;
use GDI\Dominio\Polizas\Repositorios\AsociadosProtegidosRepositorio;
use Monolog\Logger as Log;
use Monolog\Handler\StreamHandler;
use PDOException;

/**
 * Class DoctrineAsociadosProtegidosRepositorio
 * @package GDI\Infraestructura\Polizas
 * @author Gerardo Adrián Gómez Ruiz
 * @version 1.0
 */
class DoctrineAsociadosProtegidosRepositorio implements AsociadosProtegidosRepositorio
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
			$query = $this->entityManager->createQuery('SELECT a, d, o FROM Polizas:AsociadoProtegido a JOIN a.domicilio d JOIN a.oficina o WHERE o.id = :oficinaId AND a.id = :id')
				->setParameter('id', $id)
				->setParameter('oficinaId', $oficinaId);

			$usuario = $query->getResult();

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
	 * @param int|null $oficinaId
	 * @return array
	 */
	public function obtenerTodos($oficinaId = null)
	{
		// TODO: Implement obtenerTodos() method.
	}

	/**
	 * @param $dato
	 * @param int|null $oficinaId
	 * @return array
	 */
	public function obtenerPor($dato, $oficinaId = null)
	{
		// TODO: Implement obtenerPor() method.
		$dato = str_replace(' ', '', $dato);

		try {
			$query = $this->entityManager->createQuery("SELECT a, d, o FROM Polizas:AsociadoProtegido a JOIN a.domicilio d JOIN a.oficina o WHERE (CONCAT(a.nombre, a.paterno, a.materno)) = :dato OR (CONCAT(a.paterno, a.materno, a.nombre)) = :dato AND o.id = :oficinaId")
					->setParameter('dato', $dato)
					->setParameter('oficinaId', $oficinaId);
			$asociados = $query->getResult();

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