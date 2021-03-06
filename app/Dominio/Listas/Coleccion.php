<?php
namespace GDI\Dominio\Listas;


class Coleccion
{
    private $lista;

    public function __construct(IColeccion $lista)
    {
        $this->lista = $lista;
    }

    public function agregar($elemento)
    {
        $this->lista->push($elemento);
    }

    public function obtener()
    {

    }

    public function elementos()
    {
        return $this->lista;
    }

    public function ultimo()
    {
        return $this->lista->pop();
    }
}