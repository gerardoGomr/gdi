<?php
namespace GDI\Infraestructura\Polizas;

use GDI\Aplicacion\Logger;

use Doctrine\ORM\EntityManager;
use GDI\Dominio\Polizas\Repositorios\AsociadosProtegidosRepositorio;
use Monolog\Logger as Log;
use Monolog\Handler\StreamHandler;

/**
 * Class AsociadosProtegidosRepositorio
 * @package GDI\Infraestructura\Usuarios
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
	 * @return mixed
	 */
	public function obtenerPorId($id)
	{
		// TODO: Implement obtenerPorId() method.
		try {
			$query = $this->entityManager->createQuery('SELECT u, us, e FROM Usuarios:Usuario u JOIN u.usuarioTipo us JOIN u.especialidad e WHERE u.id = :id')
					->setParameter('id', $id);

			$usuario = $query->getResult();

			if (count($usuario) > 0) {
				return $usuario[0];
			}

			return null;

		} catch (\PDOException $e) {
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
	 * @param $dato
	 * @return array
	 */
	public function obtenerPor($dato):array
	{
		// TODO: Implement obtenerPor() method.
		$dato = str_replace(' ', '', $dato);

		try {
			$query = $this->entityManager->createQuery("SELECT a, d, o FROM Polizas:AsociadoProtegido a JOIN a.domicilio d JOIN a.oficina o WHERE REPLACE(CONCAT(a.nombre, a.paterno, a.materno), ' ', '') = :dato OR REPLACE(CONCAT(a.paterno, a.materno, a.nombre), ' ', '') = :dato")
					->setParameter('dato', $dato);
			$usuarios = $query->getResult();

			if (count($usuarios) > 0) {
				return $usuarios;
			}

			return null;

		} catch (\PDOException $e) {
			$pdoLogger = new Logger(new Log('pdo_exception'), new StreamHandler(storage_path() . '/logs/pdo/sqlsrv_' . date('Y-m-d') . '.log', Log::ERROR));
			$pdoLogger->log($e);
			return null;
		}
	}
}