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

namespace Modules\Cms\Livewire\Form;

use App\Models\CmsBanner;
use App\Models\SysStore;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Utilities\Get;
use Idea\Framework\Repository\Cms\CmsBannerRepository;
use Idea\Framework\View\Wsdadm\Components\FormComponent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class BannersForm extends FormComponent
{

    public ?array $data = [];
    public string $title = 'CMS: Blocks de Conteúdo';
    public string $description = 'Inserir um Bloco de Conteúdo';

    protected function getModel(): string
    {
        return CmsBanner::class;
    }

    protected function getTitle(): string
    {
        return 'Bloco de Conteúdo';
    }

    protected function getDescription(): string
    {
        if ($this->isEditing()) {
            return "Atualizar Banner: {$this->data['title']}";
        }
        return 'Inserir um novo Banner';
    }

    protected function getSuccessBody(): string
    {
        return 'O Banner foi inserido/atualizado com sucesso.';
    }

    protected function getRedirectUrl(): ?string
    {
        return route('wsdadm.cms.banners');
    }

    protected function saveData(array $data): ?Model
    {

        $cmsBanner = CmsBannerRepository::updateOrCreate(
            id: $data['banner_id'],
            values: $data
        );

        if (!empty($postData['banner_id'])) {
            Session::flash('success', 'Banner Atualizado com sucesso!');

        } else {
            Session::flash('success', 'Banner Criado com sucesso!');

        }

        return $cmsBanner;

    }

    protected function getFormSchema(): array
    {
        return [
            Tabs::make('Tabs')->tabs([

                Tabs\Tab::make('Informações do Banner')->schema([

                    Hidden::make('banner_id'),

                    // Loja que o Banner será exibido
                    Select::make('store_id')
                        ->label('Loja que será exibido o Banner')
                        ->helperText('Loja que será exibido o Banner')
                        ->options(SysStore::query()->pluck('store_name', 'store_id'))
                        ->searchable(false)
                        ->required(),

                    // Titulo do Banner
                    TextInput::make('title')
                        ->label('Título do banner')
                        ->required(),

                    Select::make('banner_type')
                        ->label('Tipo do Banner')
                        ->helperText('Qual o tipo de Banner e local ele será apresentado')
                        ->options([
                            'banner_home' => 'Página Inicial',
                            'banner_category' => 'Banner Principal - Página de Categoria',
                        ])
                        ->required()
                        ->live(),

                    Select::make('banner_local')
                        ->label('Local do Banner')
                        ->options(fn(Get $get): array => match ($get('banner_type')) {
                            'banner_home' => [
                                'banner_main_top' => 'Banner principal : Topo da página',
                                'banner_main_upper' => 'Banner principal : Direita Superior',
                                'banner_main_bottom' => 'Banner principal : Direita Inferior',
                                'banner_middle_home' => 'Banner Meio Home',
                                'banner_bottom_home_one' => 'Banner Inferior 1',
                                'banner_bottom_home_two' => 'Banner Inferior 2',
                                'banner_bottom_home_tree' => 'Banner Inferior 3',
                            ],
                            'banner_category' => collect($this->getInputCategories())
                                ->pluck('name', 'id')
                                ->toArray(),
                            default => [],
                        })
                        ->disabled(fn(Get $get) => !$get('banner_type') || $get('banner_type') === 'default')
                        ->searchable() // Recomendado para listas longas de marcas/categorias
                        ->key('parent_id_options'), // Ajuda o Filament a rastrear o estado do componente

                    TextInput::make('content')
                        ->label('Conteúdo do Banner')
                        ->helperText('Conteúdo do banner que será exibido nele'),

                    FileUpload::make('image')
                        ->label("Imagem do Banner")
                        ->image()
                        ->directory('banners')
                        ->imageEditor()
                        ->visibility('public'),

                    TextInput::make('banner_url')
                        ->label('Link do Banner')
                        ->helperText("Página para onde o banner apontará")
                        ->required(),

                    TextInput::make('banner_order')
                        ->label('Ordenação')
                        ->helperText('Ordenação da apresentação do Banner')
                        ->required(),

                    Radio::make('is_active')
                        ->label('Ativo')
                        ->boolean()
                        ->required(),


                ])

            ])

        ];
    }
}
