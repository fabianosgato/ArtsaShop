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

namespace Idea\Framework\View\Wsdadm\Components;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Concerns\InteractsWithForms;
use Idea\Framework\Repository\Catalog\CatalogProductAttributeRepository;
use Idea\Framework\Repository\Eav\EavAttributesRepository;

class CatalogProductComponent
{

    use InteractsWithForms;


    /**
     * Retorna o componente para upload de imagens do formulário
     * @return \Filament\Forms\Components\FileUpload
     */
    public function getImageUploadComponent(): FileUpload
    {
        // Campo de upload de imagens do produto
        return
            FileUpload::make('images')
                ->label("Imagens do produto por ordem de exibição (Máximo de 5 imagens por produto, apenas imagens JPG)")
                ->helperText("Permitido apenas imagens JPG")
                ->panelLayout(null)
                ->automaticallyResizeImagesToWidth(1000) // Example target width
                ->automaticallyResizeImagesToHeight(1000) // Example target height
                ->imagePreviewHeight("560px")
                ->acceptedFileTypes(['image/jpeg', 'image/jpg'])
                ->disk('public')
                ->directory('custom_images')
                ->visibility('public')
                ->preserveFilenames()
                ->multiple()
                ->maxFiles(6)
                ->appendFiles()
                ->maxParallelUploads(1)
                ->imageAspectRatio('1:1');
    }

    /**
     * Metodo responsavel por retornar os valores dos atributos de um produto
     * @param $attributeSetId
     * @param $productId
     * @return array
     */
    public function mountFormAttributes($attributeSetId, $productId): array
    {

        // Inicializa a variavel que recebera os dados dos atributos
        $formData = [];

        // Retorna os atributos do Grupo
        $eavAttributes = EavAttributesRepository::getAttributesBySetId($attributeSetId);

        if ($eavAttributes) {

            foreach ($eavAttributes->toArray() as $eavAttribute) {

                // Monta o array com o valor do attributo cadastrado no Produto
                $attributeValue = CatalogProductAttributeRepository::getAttributeFormValue(
                    $productId,
                    $eavAttribute['attribute_id']
                );

                if ($eavAttribute['frontend_input'] == 'select-options') {
                    if ($attributeValue == '')
                        $formData["attributes_{$eavAttribute['attribute_code']}"] = [];
                    else
                        $formData["attributes_{$eavAttribute['attribute_code']}"] = json_decode($attributeValue, true);
                } else {
                    $formData["attributes_{$eavAttribute['attribute_code']}"] = $attributeValue;

                }

            }


        }

        return $formData;

    }

    /**
     * Preeche os dados do formulario com valores padroes
     * @param array $fullData
     * @return array
     */
    protected function fillFields(array $fullData): array
    {

        // Valida se os campos estao preenchidos
        if (empty($fullData['prazo_postagem'])) {
            $fullData['prazo_postagem'] = 25;
        }

        // Valida se os campos estao preenchidos
        if (empty($fullData['attributes_bulletPoint00'])) {
            $fullData['attributes_bulletPoint00'] = 'Produto importado dos Estados Unidos com impostos já pagos e frete grátis. Prazo de entrega máximo de 25 dias.';
        }

        // Valida se os campos estao preenchidos
        if (empty($fullData['attributes_model'])) {
            $fullData['attributes_model'] = 'N/A';
        }

        // Valida se os campos estao preenchidos
        if (empty($fullData['attributes_item_condition'])) {
            $fullData['attributes_item_condition'] = 'Novo';
        }

        // Valida se os campos estao preenchidos
//        if (empty($fullData['attributes_color'])) {
//            $fullData['attributes_color'] = $fullData['main_collor'];
//        }
//
//        // Valida se os campos estao preenchidos
//        if (empty($fullData['attributes_Fabricante'])) {
//            $fullData['attributes_Fabricante'] = $fullData['manufacturer'];
//        }

        // Valida se os campos estao preenchidos
        if (empty($fullData['attributes_prazo_garantia'])) {
            $fullData['attributes_prazo_garantia'] = '3 meses';
        }

        if (empty($fullData['attributes_voltagem'])) {
            $fullData['attributes_voltagem'] = '110v';
        }

        if (empty($fullData['attributes_is_suitable_for_shipment'])) {
            $fullData['attributes_is_suitable_for_shipment'] = 'Sim';
        }

        if (empty($fullData['attributes_product_data_source'])) {
            $fullData['attributes_product_data_source'] = 'Estados Unidos';
        }

        // Inicializa o array de imagens
        $fullData['images'] = [];

        return $fullData;

    }

}
