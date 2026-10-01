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

use App\Models\EavAttributesSet;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Tabs;
use Idea\Framework\Jobs\UpdateAttributeSetProductJob;
use Idea\Framework\Repository\Eav\EavAttributeOptionValueRepository;
use Idea\Framework\Repository\Eav\EavAttributeSetRepository;
use Idea\Framework\Repository\Eav\EavAttributesRepository;
use Idea\Framework\View\Wsdadm\Components\FormComponent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
use Modules\Eav\Services\EavAttributeService;
use Modules\Eav\Services\EavAttributeSetService;

class EavAttributeSetForm extends FormComponent
{

    public ?array $data = [];

    protected function getModel(): string
    {
        return EavAttributesSet::class;
    }

    public function mount(array $data = [], array $params = []): void
    {
        $this->data = $data;
        $this->params = $params;

        if (empty($this->data['is_default']))
            $this->data['is_default'] = false;

        if (empty($this->data['is_category']))
            $this->data['is_category'] = true;

        $this->initializeForm();
    }

    protected function getTitle(): string
    {
        return 'Grupo de Atributos';
    }

    protected function getDescription(): string
    {
        if ($this->isEditing()) {
            return "Atualizar Grupo de Atributos: {$this->data['attribute_set_name']}";
        }
        return 'Inserir um Grupo de Atributos';
    }

    protected function getSuccessBody(): string
    {
        return 'Grupo de Atributos foi inserido/atualizado com sucesso.';
    }

    protected function getRedirectUrl(): ?string
    {
        return route('wsdadm.eav.attributeset');
    }

    protected function getFormSchema(): array
    {
        return [

            Tabs::make('Tabs')->tabs([

                Tabs\Tab::make('Geral')->schema([

                    Hidden::make('attribute_set_id'),

                    TextInput::make('attribute_set_name')
                        ->label('Grupo de Atributo')
                        ->helperText('Nome do Grupo de Atributos a ser criado')
                        ->required(),

                    Textarea::make('stemming_words')
                        ->label('Palavras Chaves de Busca')
                        ->helperText('Palavras chaves de busca quando esse atributo é usado para criação de Categorias'),

                    Radio::make('is_category')
                        ->label('Criar Categoria')
                        ->helperText('Quando Habilitado, é criado uma categoria do site com o mesmo nome')
                        ->boolean(),

                    Radio::make('is_default')
                        ->label('Grupo padrão')
                        ->helperText('Quando Habilitado, é usado na criação de produtos')
                        ->boolean(),

                ])

            ])

        ];

    }

    /**
     * @param array $data
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    protected function saveData(array $data): ?Model
    {


        // Atualiza o grupo de atributos
        $eavAttributeSet = EavAttributeSetRepository::updateAttributeSet(
            id: $data['attribute_set_id'],
            attributes: $data
        );

        if ($eavAttributeSet) {



            // Novos grupos de atributos herdam os atributos padrões
            if (empty($data['attribute_set_id'])) {

                // Lista todos os atributos padrões
                $attributes = EavAttributesRepository::getSystemAttributes();

                foreach ($attributes as $attribute) {

                    $attributeData = [
                        'attribute_set_id' => null,
                        'attribute_id' => $attribute['attribute_id'],
                        'attribute_label' => $attribute['attribute_label'],
                        'attribute_code' => $attribute['attribute_code'],
                        'note' => $attribute['note'],
                        'is_system' => $attribute['is_system'],
                        'is_global' => $attribute['is_global'],
                        'is_filterable' => $attribute['is_filterable'],
                        'frontend_input' => $attribute['frontend_input'],
                        'sort_order' => $attribute['sort_order'],
                        'is_visible' => $attribute['is_visible'],
                        'is_searchable' => $attribute['is_searchable'],
                        'is_required' => $attribute['is_required'],
                        'default_value' => $attribute['default_value'],
                        'values' => $attribute['values'],
                    ];

                    // Atributos SelectOptions devem retornar as opções
                    if (($attribute->frontend_input == 'select') || $attribute->frontend_input == 'select-options'){
                        $attributeData['options'] = EavAttributeOptionValueRepository::getOptionsArray(
                            attributeCode: $attribute->attribute_code
                        );
                    }

                    EavAttributeService::saveOrUpdateAttributes(
                        attributeData: $attributeData
                    );

                }

            }

            // Realiza as validações do grupo de atributos
            EavAttributeSetService::saveAttributeSet([
                'attributeSetKey' => $eavAttributeSet->attribute_set_key,
                'attributeSetName' => $eavAttributeSet->attribute_set_name
            ]);

            // Cria o JOB para atualizacao dos produtos
            UpdateAttributeSetProductJob::dispatch(
                $eavAttributeSet->attribute_set_id
            );

            if (empty($data['attribute_set_id'])) {

            }

            Session::flash('success', "Grupo de Atributos Atualizado com Sucesso: {$data['attribute_set_name']}");

            return $eavAttributeSet;

        }

        Session::flash('success', "Erro ao salvar o Grupo de Atributos");

        return null;

    }


}
