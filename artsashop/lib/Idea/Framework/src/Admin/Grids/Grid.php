<?php
/**
 * Fabiano Gato
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the EULA
 * that is bundled with this package in the file LICENSE.txt.
 *
 * Não editar ou acrescentar à este arquivo se você quiser fazer o upgrade para versões
 * mais recentes no futuro.
 *****************************************************
 *
 * @copyright    Copyright (c) Fabiano Gato
 * @author       Fabiano Gato <fabianogattoti@gmail.com>
 *
 */
namespace Idea\Framework\Admin\Grids;

use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Grid extends Component implements HasForms, HasTable, HasActions
{

    use InteractsWithTable;
    use InteractsWithForms;
    use InteractsWithActions;

    // Prefixo caso seja usado
    public string $prefix = '';

    // Ordenacao padrao
    public string $sortDirection = 'desc';

    // Texto padrao para todos os menus de informaçoes
    public string $textInfo = 'Visualizar Informações';

    // Paginação padrão de resultados
    public array $paginationPageOptions = [30, 60, 90, 120, 240, 360];

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function render(): View
    {
        return view('wsdadm.partials.tables');
    }

}
