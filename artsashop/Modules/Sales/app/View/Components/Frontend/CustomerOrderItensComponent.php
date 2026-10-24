<?php
/**
 * Fabiano Gato
 *
 * NOTICE OF LICENSE
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 *
 * É concedida permissão, gratuitamente, a qualquer pessoa que obtenha uma cópia
 * deste software e arquivos de documentação associados
 *
 *****************************************************
 *
 * @copyright    Copyright (c) Fabiano Gato
 * @author       Fabiano Gato <fabianogattoti@gmail.com>
 *
 */
namespace Modules\Sales\View\Components\Frontend;

use Idea\Framework\Repository\Sales\SalesOrderRepository;
use Illuminate\View\Component;
use Illuminate\View\View;

class CustomerOrderItensComponent extends Component
{

    public $orderItens;

    /**
     * Create a new component instance.
     */
    public function __construct($orderId)
    {
        $this->orderItens = SalesOrderRepository::getOrderItens($orderId)->get();
    }

    /**
     * Get the view/contents that represent the component.
     */
    public function render(): View|string
    {
        return view('sales::components.frontend/customerorderitenscomponent');
    }
}
