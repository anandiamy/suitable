<?php

namespace Laravolt\Suitable;

use Illuminate\Contracts\Support\Responsable;

abstract class TableView implements Responsable
{
    protected $source = null;

    protected $view = '';

    protected $data = [];

    /**
     * TableView constructor.
     * @param string $view
     * @param array $data
     */
    public function __construct($source)
    {
        $this->source = $source;
    }

    public function toResponse($request)
    {
        $view = $this->view ?: 'suitable::layouts.print';
        $this->data = array_add($this->data, 'table', $this->table());

        return response()->view($view, $this->data);
    }

    public function view(string $view = '', array $data = [])
    {
        $this->view = $view;
        $this->data = $data;

        return $this;
    }

    abstract protected function table();
}
