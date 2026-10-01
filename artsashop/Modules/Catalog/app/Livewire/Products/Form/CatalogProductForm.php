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

namespace Modules\Catalog\Livewire\Products\Form;

use App\Models\CatalogProduct;
use App\Models\CatalogProductBrand;
use App\Models\CatalogProductStatus;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Idea\Framework\Repository\Catalog\CatalogProductTagRepository;
use Idea\Framework\Repository\Eav\EavAttributeSetRepository;
use Idea\Framework\View\Wsdadm\Components\Catalog\HasProductForm;
use Idea\Framework\View\Wsdadm\Components\FormComponent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
use Modules\Catalog\Services\CatalogProductService;


class CatalogProductForm extends FormComponent
{

    use HasProductForm;

    public ?array $data = [];
    public string $title = 'Inserir novo Produto';


    protected function getModel(): string
    {
        return CatalogProduct::class;
    }


    protected function getTitle(): string
    {
        if ($this->isEditing()) {
            return "Editar Produto: {$this->data['name']}";
        }
        return 'Inserir um novo Produto';
    }

    protected function getDescription(): string
    {
        if ($this->isEditing()) {
            return "Grupo de Atributo: {$this->data['attribute_set_name']}";
        }
        return 'Inserir um novo Produto';
    }

    protected function getSuccessBody(): string
    {
        return 'A Página de Conteúdo foi inserida/atualizada com sucesso.';
    }

    protected function getRedirectUrl(): ?string
    {
        return route('wsdadm.cms.pages');
    }


    public function mount(array $data = [], array $params = []): void
    {

        $this->data = $data;
        $this->params = $params;

        // Carrega os dados do SEO
        $this->mountSeo($this->data);

        // Carrega os dados dos atributos do produto
        $this->mountFormAttributes(
            attributeSetId: $this->data['attribute_set_id'],
            productId: $this->data['product_id'] ?? null
        );

        // Inicializa o form
        $this->initializeForm();

    }

    /**
     * Retorna o Form de produtos
     * @return array|\Filament\Actions\Action[]|\Filament\Actions\ActionGroup[]|\Filament\Schemas\Components\Component[]
     */
    protected function getFormSchema(): array
    {
        return [
            Tabs::make('Tabs')->schema([

                Tab::make('Geral')->schema([

                    Fieldset::make('Informações Gerais Sobre o Produto')
                        ->schema([
                            Hidden::make('product_id'),
                            TextInput::make('name')
                                ->label('Nome do Produto')
                                ->required(),

                            Textarea::make('short_description')
                                ->label('Descrição Curta do produto')
                                ->rows(5)
                                ->required(),

                            RichEditor::make('description')
                                ->label('Descrição do produto')
                                ->required(),

                            TextInput::make('slug_key')
                                ->disabled()
                                ->label('URL do Produto')
                                ->helperText('URL do produto no site'),

                            TextInput::make('video_url')
                                ->label('URL do Video do YouTube'),

                        ])
                        ->columns(1)
                        ->extraAttributes([
                            'style' => '
                            background-color: #E9F7F7;
                            @media (prefers-color-scheme: dark) {
                                background-color: #E9F7F7
                            }'
                        ]),

                    Fieldset::make('Informações do SKU')
                        ->schema([
                            TextInput::make('sku')
                                ->label('SKU')
                                ->readOnly()
                                ->required(),

                            TextInput::make('ean')
                                ->label('EAN')
                                ->helperText('EAN/NBM do Produto')
                                ->required(),

                        ])
                        ->columns()
                        ->extraAttributes([
                            'style' => '
                            background-color: #FCF7F8;
                            @media (prefers-color-scheme: dark) {
                                background-color: #FCF7F8
                            }'
                        ]),

                    Fieldset::make('Categorização')
                        ->schema([
                            Select::make('attribute_set_id')
                                ->label('Grupo de Atributos')
                                ->options(EavAttributeSetRepository::getAttibuteSetOptions())
                                ->required()
                                ->searchable()
                                ->live()
                                ->afterStateUpdated(function ($newId, $oldId) {
                                    if ($newId === $oldId) {
                                        return;
                                    }

                                    CatalogProductService::updateAttributeSet(
                                        productId:$this->data['product_id'],
                                        attributeSetId: $newId
                                    );
                                }),

                            Select::make('brand_id')
                                ->label('Marca')
                                ->options(CatalogProductBrand::query()->pluck('brand_name', 'brand_id'))
                                ->required()
                                ->searchable(),

                            Select::make('tags')
                                ->label('Tags do Produto')
                                ->multiple()
                                ->searchable()
                                ->preload()
                                ->options(CatalogProductTagRepository::getOptions())
                                ->createOptionForm([
                                    TextInput::make('tag_name')
                                        ->label('Nome da Tag')
                                        ->required(),
                                ])
                                ->createOptionUsing(function (array $data) {
                                    return CatalogProductTagRepository::firstOrCreateByName(
                                        $data['tag_name']
                                    )->tag_id;
                                }),

                        ])
                        ->columns()
                        ->extraAttributes([
                            'style' => '
                            background-color: #FCF7F8;
                            @media (prefers-color-scheme: dark) {
                                background-color: #FCF7F8
                            }'
                        ]),

                    // Bloco do produto que mostra o status de estoque
                    Fieldset::make('Estoque e Entrega')
                        ->schema([
                            // Prazo de entrega padrao
                            TextInput::make('prazo_postagem')
                                ->label('Prazo de Fabricação/Postagem')
                                ->default('15')
                                ->helperText('Prazo de Fabricação/Postagem do produto em dias uteis')
                                ->required(false),

                            Select::make('status_id')
                                ->label('Status do Produto')
                                ->options(
                                    options: CatalogProductStatus::query()->pluck('status', 'status_id')
                                )
                                ->required(),

                            TextInput::make('qty')
                                ->numeric()
                                ->label('Estoque')
                                ->required(),

                        ])
                        ->columns(1)
                        ->extraAttributes([
                            'style' => '
                            background-color: #FCF7F8;
                            @media (prefers-color-scheme: dark) {
                                background-color: #FCF7F8
                            }'
                        ]),

                ]),
                // Tab de SEO do produto
                Tab::make('SEO')->schema(
                    $this->seoTab()
                ),
                // Tab de Pesos do produto
                Tab::make('Pesos e Medidas')->schema(
                    $this->formWeights()
                ),
                // Tab de Preços do produto
                Tab::make('Preços')->schema(
                    $this->formPrices()
                ),
                // Atributos do produto
                Tab::make('Atributos')->schema(
                    $this->formAttributes(
                        attributeSetId: $this->data['attribute_set_id']
                    )
                ),
                // Imagens do produto
                Tab::make('Imagens')->schema(
                    $this->formImages(
                        productId: $this->data['product_id'] ?? null
                    )
                )

            ])

        ];

    }

    protected function saveData(array $data): ?Model
    {

        // Atualiza os dados do produto
        $catalogProduct = CatalogProductService::saveCatalogProduct($data);

        if ($catalogProduct) {
            if (!empty($data['product_id'])) {
                // Mensagem de sucesso ao salvar os dados
                Session::flash('success', 'Produto Atualizado com sucesso');

            } else {
                // Mensagem de sucesso ao salvar os dados
                Session::flash('success', 'Produto Criado com sucesso');

            }

            return $catalogProduct;
        }

        // Mensagem de sucesso ao salvar os dados
        Session::flash('error', 'Erro ao Criar o Produto');

        return null;

    }


}
