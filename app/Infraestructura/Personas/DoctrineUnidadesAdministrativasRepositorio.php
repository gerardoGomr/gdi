<?php
namespace GDI\Infraestructura\Personas;

use GDI\Aplicacion\Logger;

use Doctrine\ORM\EntityManager;
use GDI\Dominio\Personas\Repositorios\UnidadesAdministrativasRepositorio;
use GDI\Dominio\Personas\UnidadAdministrativa;
use Monolog\Logger as Log;
use Monolog\Handler\StreamHandler;
use PDOException;

/**
 * Class DoctrineUnidadesAdministrativasRepositorio
 * @package GDI\Infraestructura\Personas
 * @author Gerardo Adrián Gómez Ruiz
 * @version 1.0
 */
class DoctrineUnidadesAdministrativasRepositorio implements UnidadesAdministrativasRepositorio
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
	 * @return UnidadAdministrativa
	 */
	public function obtenerPorId($id, $oficinaId = null)
	{
		// TODO: Implement obtenerPorId() method.
		try {
			$query = $this->entityManager->createQuery('SELECT u FROM Personas:UnidadAdministrativa u WHERE u.id = :id')
					->setParameter('id', $id);

			$unidadAdministrativa = $query->getResult();

			if (count($unidadAdministrativa) > 0) {
				return $unidadAdministrativa[0];
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
		try {
			$query     = $this->entityManager->createQuery('SELECT u FROM Personas:UnidadAdministrativa u WHERE u.unidadPadre IS NOT NULL');
			$unidades  = $query->getResult();

			if (count($unidades) > 0) {
				return $unidades;
			}

			return null;

		} catch (PDOException $e) {
			$pdoLogger = new Logger(new Log('pdo_exception'), new StreamHandler(storage_path() . '/logs/pdo/sqlsrv_' . date('Y-m-d') . '.log', Log::ERROR));
			$pdoLogger->log($e);
			return null;
		}
	}
}