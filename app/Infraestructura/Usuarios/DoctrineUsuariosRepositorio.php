<?php
namespace GDI\Infraestructura\Usuarios;

use GDI\Aplicacion\Logger;
use GDI\Dominio\Usuarios\Repositorios\UsuariosRepositorio;
use Doctrine\ORM\EntityManager;
use Monolog\Logger as Log;
use Monolog\Handler\StreamHandler;
use PDOException;

/**
 * Class DoctrineUsuariosRepositorio
 * @package GDI\Infraestructura\Usuarios
 * @author Gerardo Adrián Gómez Ruiz
 * @version 1.0
 */
class DoctrineUsuariosRepositorio implements UsuariosRepositorio
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
	 * obtener un usuario por su username
	 * @param string $username
	 * @return \GDI\Dominio\Usuarios\Usuario
	 */
	public function obtenerPorUsername($username)
	{
		// TODO: Implement obtenerPorUsername() method.
		try {
			$query = $this->entityManager->createQuery('SELECT u, us, o FROM Usuarios:Usuario u JOIN u.usuarioTipo us JOIN u.oficina o WHERE u.username = :username')
				->setParameter('username', $username);
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
	 * @param int $id
	 * @param null $oficinaId
	 * @return mixed
	 */
	public function obtenerPorId($id, $oficinaId = null)
	{
		// TODO: Implement obtenerPorId() method.
		try {
			$query = $this->entityManager->createQuery('SELECT u, us, o FROM Usuarios:Usuario u JOIN u.usuarioTipo us JOIN u.oficina o WHERE u.id = :id')
					->setParameter('id', $id);

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
	 * @param null $oficinaId
	 * @return array
	 */
	public function obtenerTodos($oficinaId = null)
	{
		// TODO: Implement obtenerTodos() method.
	}
}