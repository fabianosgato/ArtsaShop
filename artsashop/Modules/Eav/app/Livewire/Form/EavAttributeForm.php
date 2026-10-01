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

namespace Modules\Eav\Livewire\Form;

use App\Models\EavAttribute;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Utilities\Get;
use Idea\Framework\Repository\Eav\EavEntityAttributeOptionRepository;
use Idea\Framework\View\Wsdadm\Components\FormComponent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Modules\Eav\Enums\FrontendInputType;
use Modules\Eav\Services\EavAttributeService;

class EavAttributeForm extends FormComponent
{

    public ?array $data = [];

    protected function getModel(): string
    {
        return EavAttribute::class;
    }

    public function mount(array $data = [], array $params = []): void
    {

        $this->data = $data;

        if (!empty($this->data['entity_attribute_id'])) {
            $this->data['options'] = EavEntityAttributeOptionRepository::getAtributeOptions(
                entityAttributeId: $this->data['entity_attribute_id'],
                attributeId: $this->data['attribute_id']
            );
        } else {
            // Por padrão um atributo nao pode ser de sistema
            $this->data['is_system'] = false;
        }

        // Monta os atributos padrões caso seja um novo atributo
        if (empty($this->data['attribute_id'])) {
            $this->data['is_required'] = false;
            $this->data['is_global'] = false;
            $this->data['is_system'] = false;
            $this->data['is_filterable'] = true;
            $this->data['is_searchable'] = true;
            $this->data['is_visible'] = true;
        }

        $this->params = $params;
        $this->initializeForm();
    }

    protected function getTitle(): string
    {
        return 'Atributos de Produtos';
    }

    protected function getDescription(): string
    {
        if ($this->isEditing()) {
            return "Atualizar Atributos de Produtos: {$this->data['attribute_label']}";
        }
        return 'Inserir um Atributo de Produto';
    }

    protected function getSuccessBody(): string
    {
        return 'O atributo foi inserido/atualizado com sucesso.';
    }

    protected function getRedirectUrl(): ?string
    {
        return route('wsdadm.eav.attribute', [
            'attributeSetId' => $this->data['attribute_set_id']
        ]);
    }

    protected function getFormSchema(): array
    {
        return [

            Tabs::make('Tabs')->tabs([

                Tabs\Tab::make('Geral')->schema([

                    // Id do Grupo de Atributos
                    Hidden::make('attribute_set_id'),

                    // Id do atributo
                    Hidden::make('attribute_id'),

                    // Id da entidade do atributo
                    Hidden::make('entity_attribute_id'),
                    Hidden::make('is_global'),

                    TextInput::make('attribute_label')
                        ->label('Nome do atributo')
                        ->helperText('Nome do atributo que será mostrado nos formulários de produtos. Exemplo: no atributo voltage, tem o nome Voltagem')
                        ->required()
                        ->live(onBlur: true)
                        ->afterStateUpdated(function ($state, callable $set, callable $get) {
                            // Só gera automaticamente se o usuário ainda não personalizou o attribute_code
                            if (blank($get('attribute_code')) || $get('attribute_code') === Str::upper(Str::slug($get('attribute_label'), '-'))) {
                                $set(
                                    'attribute_code',
                                    Str::lower(
                                        Str::slug($state, '-')
                                    )
                                );
                            }
                        }),


                    TextInput::make('attribute_code')
                        ->label('Código do atributo')
                        ->helperText('Para uso interno. Deve ser único e sem espaços. O comprimento máximo do código do atributo deve ser inferior a 60 caracteres. Não utilize a palavra "event" como código de atributo; trata-se de uma palavra-chave reservada.')
                        ->required(),

                    Radio::make('is_system')
                        ->label('Atributo de Sistema')
                        ->helperText('Um atributo de sistema é um atributo que pertence a todos os grupos de atributos')
                        ->boolean()
                        ->required(),

                    Radio::make('is_required')
                        ->label('Atributo Requerido')
                        ->helperText('Este atributo é requerido no formulário de Cadastro do Produto')
                        ->boolean()
                        ->required(),

                    Radio::make('is_filterable')
                        ->label('Usado nos filtros do site')
                        ->helperText('Quando Habilitado, é usado como filtro na lateral do site')
                        ->boolean()
                        ->required(),

                    Radio::make('is_searchable')
                        ->label('Usado nas pesquisas do site')
                        ->helperText('Quando Habilitado, é usado nas buscas do produto')
                        ->boolean()
                        ->required(),

                    Radio::make('is_visible')
                        ->label('Visível no Site')
                        ->helperText('Quando Habilitado, é visível na página do produto')
                        ->boolean()
                        ->required(),

                ]),
                Tabs\Tab::make('Opções')->schema([

                    Select::make('frontend_input')
                        ->label('Tipo do Campo')
                        ->options(FrontendInputType::options())
                        ->live()
                        ->required(),

                    // Campo "valor padrão" quando o tipo do campo for boolean
                    Radio::make('default_value')
                        ->label('Valor Padrão')
                        ->boolean()
                        ->visible(fn(Get $get) => $get('frontend_input') === FrontendInputType::BOOLEAN->value
                        ),

                    // Campo "valor padrão" quando o tipo do campo for text
                    TextInput::make('default_value')
                        ->label('Valor Padrão')
                        ->visible(fn(Get $get) => $get('frontend_input') === FrontendInputType::TEXT->value
                        ),

                    // Campo "valor padrão" quando o tipo do campo for textarea
                    Textarea::make('default_value')
                        ->label('Valor Padrão')
                        ->visible(fn(Get $get) => $get('frontend_input') === FrontendInputType::TEXTAREA->value
                        ),

                    // Campo "valor padrão" quando o tipo do campo for 'multi-select'
                    Repeater::make('options')
                        ->label('Opções do atributo')
                        ->visible(fn(Get $get) => in_array(
                            $get('frontend_input'),
                            [
                                FrontendInputType::SELECT->value,
                                FrontendInputType::MULTISELECT->value,
                            ]
                        ))
                        ->schema([
                            Hidden::make('attribute_set_id'),
                            Hidden::make('entity_attribute_id'),
                            Hidden::make('eav_attribute_option_id'),

                            TextInput::make('option_name')
                                ->label('Nome da opção')
                                ->distinct()
                                ->required()
                                ->helperText('Opcional. Utilizado em integrações externas.'),

                            TextInput::make('option_value')
                                ->label('Valor da opção')
                                ->helperText('Para uso interno. Deve ser único e sem espaços. O comprimento máximo do código do atributo deve ser inferior a 20 caracteres')
                                ->columnSpan(2),

                            Radio::make('is_default')
                                ->label('Padrão')
                                ->boolean(),

                        ])
                        ->defaultItems(0)
                        ->addActionLabel('Adicionar opção')
                        ->reorderable()
                        ->cloneable(false)
                        ->itemLabel(fn(array $state): ?string => $state['option_name'] ?? 'Nova opção')
                        ->collapsible()
                        ->columns(4)

                ])

            ])

        ];
    }

    /**
     * Salva os dados do Atributo
     * @param array $data
     * @return \Illuminate\Database\Eloquent\Model
     */
    protected function saveData(array $data): Model
    {

        $eavAttribute = EavAttributeService::saveOrUpdateAttributes(
            attributeData: $data
        );

        if (!empty($data['attribute_id'])) {
            Session::flash('success', 'Atributo atualizado com sucesso!');
        } else {
            Session::flash('success', 'Atributo inserido com sucesso!');
        }

        return $eavAttribute;

    }

}
