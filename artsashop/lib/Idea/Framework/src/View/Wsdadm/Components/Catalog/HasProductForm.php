<?php

namespace Idea\Framework\View\Wsdadm\Components\Catalog;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Fieldset;
use Filament\Support\RawJs;
use Idea\Framework\Admin\Components\ExternalImageGallery;
use Idea\Framework\Repository\Catalog\CatalogProductAttributeRepository;
use Idea\Framework\Repository\Catalog\CatalogProductMediaRepository;
use Idea\Framework\Repository\Catalog\CatalogProductTagRepository;
use Idea\Framework\Repository\Eav\EavAttributesRepository;
use Idea\Framework\Repository\Eav\EavEntityAttributeOptionRepository;
use Idea\Framework\View\Wsdadm\Concerns\HasSeoForm;
use Idea\Framework\View\Wsdadm\Concerns\HasStoreForm;

trait HasProductForm
{

    use HasSeoForm;
    use HasStoreForm;

    protected function seoObject(): string
    {
        return 'product';
    }

    protected function seoObjectId(): ?string
    {
        return $this->data['product_id'] ?? null;
    }

    /**
     * Retorna as tags do Produto
     * @param int|null $productId
     * @return void
     */
    protected function mountFormTags(?int $productId): void
    {

        if ($productId) {

            // Retorna as tags do produto
            $this->data['tags'] = CatalogProductTagRepository::getTagsByProductId($productId)
                ->pluck('tag_name', 'slug_key')
                ->toArray();

        } else
            $this->data['tags'] = [];

    }

    /**
     * Metodo responsavel por retornar os valores dos atributos de um Produto
     * @param $attributeSetId
     * @param $productId
     * @return void
     */
    public function mountFormAttributes($attributeSetId, $productId): void
    {

        // Retorna os atributos do Grupo
        $eavAttributes = EavAttributesRepository::getAttributesBySetId($attributeSetId)->get();

        if ($eavAttributes) {

            foreach ($eavAttributes->toArray() as $eavAttribute) {

                if ($productId) {

                    // Monta o array com o valor do attributo cadastrado no produto
                    $attributeValue = CatalogProductAttributeRepository::getAttributeFormValue(
                        $productId,
                        $eavAttribute['attribute_id']
                    );

                    if ($eavAttribute['frontend_input'] == 'select-options') {
                        if ($attributeValue == '')
                            $this->data["attributes_{$eavAttribute['attribute_code']}"] = [];
                        else
                            $this->data["attributes_{$eavAttribute['attribute_code']}"] = json_decode($attributeValue, true);
                    } else {
                        $this->data["attributes_{$eavAttribute['attribute_code']}"] = $attributeValue;

                    }

                } else {
                    if ($eavAttribute['frontend_input'] == 'select-options') {
                        $this->data["attributes_{$eavAttribute['attribute_code']}"] = [];
                    } else {
                        $this->data["attributes_{$eavAttribute['attribute_code']}"] = '';
                    }

                }

            }

        }

    }

    /**
     * Retorna o componente para upload de imagens do formulário
     * @return \Filament\Forms\Components\FileUpload
     */
    public function getImageUploadComponent(): FileUpload
    {
        // Campo de upload de imagens do produto
        return
            FileUpload::make('images')
                ->label("Imagens do Produto por ordem de exibição (Máximo de 5 imagens por produto, apenas imagens JPG)")
                ->helperText("Permitido apenas imagens JPG")

                ->imagePreviewHeight("250")
                ->loadingIndicatorPosition('left')

                ->acceptedFileTypes(['image/jpeg', 'image/jpg'])
                ->disk('public')
                ->directory('custom_images')
                ->visibility('public')
                ->preserveFilenames()
                ->multiple()
//                ->appendFiles()
                ->maxFiles(6)
                ->maxParallelUploads(1);
    }

    /**
     * Metodo que gera o sistema de imagens
     * @param int|null $productId
     * @return array
     */
    protected function formImages(?int $productId): array
    {

        if (!$productId) {
            return [
                // campo para novas imagens
                $this->getImageUploadComponent()
            ];
        } else {

            return [

                // campo para novas imagens
                $this->getImageUploadComponent(),

                // Campo de organizacao das imagens
                ExternalImageGallery::make('external_images')
                    ->label('Imagens do produto')
                    ->images(
                        images: CatalogProductMediaRepository::getProductImagesArray(
                            productId: $productId
                        )
                    )
            ];

        }

    }

    /**
     * Monta o formulario de pesos para os produtos
     * @return array
     */
    public function formWeights(): array
    {

        return [

            TextInput::make('weight')
                ->helperText('Peso real do produto')
                ->label('Peso')
                ->required(),

            TextInput::make('height')
                ->label('Altura')
                ->helperText('Altura do produto em CM')
                ->required(),

            TextInput::make('width')
                ->label('Largura')
                ->helperText('Largura do produto em CM')
                ->required(),

            TextInput::make('length')
                ->label('Comprimento')
                ->helperText('Comprimento do produto em CM')
                ->required(),

            TextInput::make('volume_weight')
                ->helperText('Peso Cubado do produto, é atualizado de acordo com os campos de Altura, Largura e Comprimento')
                ->readOnly()
                ->disabled()
                ->label('Peso Cubado')
                ->required(),


        ];

    }

    /**
     * Cria o formulario de Atributos
     * @param $attributeSetId
     * @return array
     */
    protected function formAttributes($attributeSetId): array
    {

        // Inicializa o array do formulario de Marketplaces
        $schema = [];

        // Retorna os atributos do Grupo
        $eavAttributes = EavAttributesRepository::getAttributesBySetId($attributeSetId)->get();

        if ($eavAttributes) {

            foreach ($eavAttributes->toArray() as $eavAttribute) {

                if ($eavAttribute['frontend_input'] == 'text') {

                    $schema[] = TextInput::make("attributes_{$eavAttribute['attribute_code']}")
                        ->name("attributes_{$eavAttribute['attribute_code']}")
                        ->label("{$eavAttribute['attribute_label']}")
                        ->helperText(strip_tags($eavAttribute['note']))
                        ->required($eavAttribute['is_required'])
                        ->default(false);

                } else if ($eavAttribute['frontend_input'] == 'textarea') {
                    $schema[] = Textarea::make("attributes_{$eavAttribute['attribute_code']}")
                        ->name("attributes_{$eavAttribute['attribute_code']}")
                        ->label("{$eavAttribute['attribute_label']}")
                        ->helperText(strip_tags($eavAttribute['note']))
                        ->required($eavAttribute['is_required'])
                        ->default(false);

                } else if ($eavAttribute['frontend_input'] == 'select') {

                    $schema[] = Select::make("attributes_{$eavAttribute['attribute_code']}")
                        ->name("attributes_{$eavAttribute['attribute_code']}")
                        ->label("{$eavAttribute['attribute_label']}")
                        ->options(EavEntityAttributeOptionRepository::getOptionsArray(
                            entityAttributeId: $eavAttribute['entity_attribute_id'],
                            attributeId: $eavAttribute['attribute_id']
                        ))
                        ->required($eavAttribute['is_required']);

                } else if ($eavAttribute['frontend_input'] == 'select-options') {

                    $schema[] = Select::make("attributes_{$eavAttribute['attribute_code']}")
                        ->name("attributes_{$eavAttribute['attribute_code']}")
                        ->label("{$eavAttribute['attribute_label']}")
                        ->options(EavEntityAttributeOptionRepository::getOptionsArray(
                            entityAttributeId: $eavAttribute['entity_attribute_id'],
                            attributeId: $eavAttribute['attribute_id']
                        ))
                        ->multiple()
                        ->required($eavAttribute['is_required']);

                } else if ($eavAttribute['frontend_input'] == 'boolean') {

                    $schema[] = Radio::make("attributes_{$eavAttribute['attribute_code']}")
                        ->name("attributes_{$eavAttribute['attribute_code']}")
                        ->label("{$eavAttribute['attribute_label']}")
                        ->boolean()
                        ->required($eavAttribute['is_required']);

                }

            }


        }

        return $schema;

    }


    /**
     * Metodo que monta o form de preços do produto
     * @return array
     */
    protected function formPrices(): array
    {

        $schema[] = Fieldset::make("Preços do produto")
            ->schema([
                TextInput::make("price")
                    ->inputMode('decimal')
                    ->label("Preço Padrão do produto")
                    ->helperText("Preço padrão do produto sem desconto")
                    ->stripCharacters('')
                    ->prefix('R$')
                    ->mask(RawJs::make(<<<'JS'
                        $money($input, ',', '.', 2)
                    JS))
                    ->formatStateUsing(fn ($state) => ! $state ? null : number_format($state, 2, ',', '.'))
                    ->dehydrateStateUsing(fn ($state) => (float) str_replace(['.', ','], ['', '.'], $state))
                    ->default(false),

                TextInput::make("final_price")
                    ->inputMode('decimal')
                    ->label("Preço do produto com desconto")
                    ->helperText("Preço do produto com desconto se houver")
                    ->stripCharacters('')
                    ->prefix('R$')
                    ->mask(RawJs::make(<<<'JS'
                        $money($input, ',', '.', 2)
                    JS))
                    ->formatStateUsing(fn ($state) => ! $state ? null : number_format($state, 2, ',', '.'))
                    ->dehydrateStateUsing(fn ($state) => (float) str_replace(['.', ','], ['', '.'], $state))
                    ->default(false),

            ])->extraAttributes([
                'style' => 'background-color: #E9F7F7;'
            ]);

        return $schema;

    }

}
