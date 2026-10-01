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

namespace Modules\System\Livewire\Form;

use App\Models\CatalogProductBrand;
use App\Models\SysStore;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Components\Utilities\Get;
use Idea\Framework\View\Wsdadm\Components\FormComponent;
use Idea\Framework\View\Wsdadm\Concerns\HasSeoForm;
use Modules\System\Services\SysStoreService;

class SysStoreForm extends FormComponent
{

    use HasSeoForm;

    public ?array $data = [];

    protected function getModel(): string
    {
        return SysStore::class;
    }

    protected function getTitle(): string
    {
        return 'Lojas';
    }

    protected function getDescription(): string
    {
        if ($this->isEditing()) {
            return "Atualizar Loja: {$this->data['store_name']}";
        }
        return 'Inserir uma nova Loja';
    }

    protected function getSuccessBody(): string
    {
        return 'A Loja foi inserida/atualizada com sucesso.';
    }

    protected function getRedirectUrl(): ?string
    {
        return route('wsdadm.sysstore');
    }

    protected function seoObject(): string
    {
        return 'store';
    }

    protected function seoObjectId(): ?string
    {
        return $this->data['store_id'] ?? null;
    }

    public function mount(array $data = [], array $params = []): void
    {
        $this->data = $data;
        $this->params = $params;

        // Carrega os dados do SEO
        $this->mountSeo($this->data);

        $this->initializeForm();
    }


    /**
     * Insere/Atualiza os dados da Loja
     * @param array $data
     * @return \App\Models\SysStore
     */
    protected function saveData(array $data): SysStore
    {

        // Insere/Atualiza as informações da loja
        $sysStore = app(SysStoreService::class)->saveStore($data);

        // Salva os dados do SEO
        $this->saveSeo();

        // Retorna o model
        return $sysStore;

    }

    protected function getFormSchema(): array
    {

        return [

            Tabs::make('Tabs')->tabs([

                Tab::make('Geral')->schema([
                    Hidden::make('store_id'),

                    TextInput::make('store_name')
                        ->label('Nome da Loja')
                        ->required(),

                    TextInput::make('code')
                        ->label('Código da Loja')
                        ->helperText('Código único da loja')
                        ->required(),

                    TextInput::make('code_order')
                        ->label('Código da Loja para os Pedidos')
                        ->helperText('Código único da loja para incluir no pedido')
                        ->required(),

                    TextInput::make('host')
                        ->label('URL Host da loja')
                        ->helperText('URL Host da loja para determinar o funcionamento')
                        ->required(),

                    TextInput::make('layout')
                        ->label('Layout')
                        ->helperText('Layout utilizado para a HOME da loja')
                        ->required(),

                    Select::make('type')
                        ->label('Tipo de Recurso')
                        ->helperText("O Tipo de Recurso é o que deve ser usado para listar os produtos da Loja")
                        ->options([
                            'default' => 'Loja padrão para todos os produtos',
                            'category' => 'Loja de uma Categoria especifica',
                        ])
                        ->required()
                        ->live(),

                    Select::make('parent_id')
                        ->label('Id do Recurso')
                        ->options(fn(Get $get): array => match ($get('type')) {
                            'default' => [
                                '1' => 'Loja Padrão'
                            ],
                            'brand' => CatalogProductBrand::query()
                                ->pluck('brand_name', 'brand_id')
                                ->toArray(),
                            'category' => collect($this->getInputCategories())
                                ->pluck('name', 'id')
                                ->toArray(),
                            default => [],
                        })
//                        ->disabled(fn(Get $get) => !$get('type') || $get('type') === 'default')
                        ->searchable() // Recomendado para listas longas de marcas/categorias
                        ->key('parent_id_options'), // Ajuda o Filament a rastrear o estado do componente

                    Radio::make('is_default')
                        ->label('Loja Padrão')
                        ->helperText("Caso seja SIM, esta loja é a padrão do sistema, e as outras que forem padrão deixaram de ser")
                        ->options([
                            true => 'Sim',
                            false => 'Não'
                        ])
                        ->required(),

                ]),
                Tab::make('SEO')->schema(
                    $this->seoTab()
                ),
            ])

        ];

    }

}

