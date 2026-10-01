<?php
/**
 * Fabiano Gato
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the EULA
 * that is bundled with this package in the file LICENSE.txt.
 *
 *****************************************************
 *
 * @copyright    Copyright (c) Fabiano Gato
 * @author       Fabiano Gato <fabianogattoti@gmail.com>
 *
 */

namespace Modules\System\Livewire\Form;

use App\Models\SeoMetaTag;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Idea\Framework\Repository\Seo\SeoMetaTagRepository;
use Idea\Framework\View\Wsdadm\Components\FormComponent;
use Illuminate\Support\Facades\Session;

class SeoConfigForm extends FormComponent
{

    public ?array $data = [];

    protected function getModel(): string
    {
        return SeoMetaTag::class;
    }

    protected function getTitle(): string
    {
        return 'Configuração da MetaTag para SEO';
    }

    protected function getDescription(): string
    {
        if ($this->isEditing()) {
            return "Atualizar a MetaTag: {$this->data['name']}";
        }
        return 'Inserir uma nova MetaTag';
    }

    protected function getSuccessBody(): string
    {
        return 'O Status de produto foi inserido/atualizado com sucesso.';
    }

    protected function getRedirectUrl(): ?string
    {
        return route('wsdadm.seo-config');
    }

    protected function getFormSchema(): array
    {
        return [
            Tabs::make('Tabs')->tabs([

                Tab::make('Informações da MetaTag')->schema([

                    Hidden::make('seo_meta_tag_id'),

                    TextInput::make('name')
                        ->label('Nome')
                        ->required(),

                    TextInput::make('property')
                        ->label('Propriedade')
                        ->required(),

                    TextInput::make('default_value')
                        ->label('Valor Padrão')
                        ->required(false),

                    TextInput::make('input_label')
                        ->label('Rótulo')
                        ->required(),

                    TextInput::make('input_placeholder')
                        ->label('Espaço reservado')
                        ->required(false),

                    TextInput::make('input_info')
                        ->label('Texto de informação do campo')
                        ->required(),

                    Select::make('group')
                        ->label('Grupo')
                        ->helperText('Informe o grupo que essa meta-tag pertence')
                        ->options([
                            'article' => 'MetaTag Artigo',
                            'og' => 'MetaTag para Open Graph ',
                            'twitter' => 'MetaTag para o Twitter',
                            'webmaster_tools' => 'MetaTag para o Google',
                        ]),

                    Select::make('input_type')
                        ->label('Tipo de Campo')
                        ->helperText('Informe o tipo de campo que será exibido nos formulários')
                        ->options([
                            'text' => 'Texto',
                            'file' => 'Arquivo ',
                            'number' => 'texto que aceita somente números',
                            'url' => 'texto que aceita somente URL',
                        ]),

                    Select::make('visibility')
                        ->label('Visibilidade')
                        ->helperText('Informe a visibilidade que este campo terá nas páginas do site')
                        ->options([
                            'page' => 'Página',
                            'global' => 'Global'
                        ]),

                    Radio::make('status')
                        ->options([
                            'active' => 'Habilitado',
                            'inactive' => 'Desabilitado'
                        ])

                ]),

            ])
        ];
    }

    protected function saveData(array $data): SeoMetaTag
    {

        $seoMetaTag = SeoMetaTagRepository::getData()->updateOrCreate(
            attributes: [
                'seo_meta_tag_id' => $data['seo_meta_tag_id'] ?? null
            ],
            values: [
                'name' => $data['name'],
                'property' => $data['property'],
                'status' => $data['status'] ?? 'inactive',
                'group' => $data['group'],
                'input_type' => $data['input_type'],
                'default_value' => $data['default_value'],
                'input_placeholder' => $data['input_placeholder'],
                'input_label' => $data['input_label'],
                'input_info' => $data['input_info'],
                'visibility' => $data['visibility'],
            ]

        );

        if ($seoMetaTag) {
            Session::flash('success', 'SEO MetaTag Inserida/Atualizada com Sucesso!');
        } else
            Session::flash('error', 'Erro ao salvar a SEO MetaTag!');

        return $seoMetaTag;

    }


}
