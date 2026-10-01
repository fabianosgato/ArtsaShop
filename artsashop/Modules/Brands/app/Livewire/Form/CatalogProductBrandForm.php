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

namespace Modules\Brands\Livewire\Form;

use App\Models\CatalogProductBrand;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Idea\Framework\Repository\Brand\CatalogProductBrandRepository;
use Idea\Framework\Repository\System\SysUrlRewriteRepository;
use Idea\Framework\View\Wsdadm\Components\FormComponent;
use Idea\Framework\View\Wsdadm\Concerns\HasSeoForm;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class CatalogProductBrandForm extends FormComponent
{

    use HasSeoForm;

    public ?array $data = [];
    public string $title = 'Marca de Produtos';
    public string $description = 'Inserir uma nova marca';

    protected function getModel(): string
    {
        return CatalogProductBrand::class;
    }

    protected function seoObject(): string
    {
        return 'brand';
    }

    protected function seoObjectId(): ?string
    {
        return $this->data['brand_id'] ?? null;
    }

    protected function getTitle(): string
    {
        return 'Marcas';
    }

    protected function getDescription(): string
    {
        if ($this->isEditing()) {
            return "Atualizar Marca: {$this->data['brand_name']}";
        }
        return 'Inserir uma nova Marca';
    }

    protected function getSuccessBody(): string
    {
        return 'A Marca foi inserida/atualizada com sucesso.';
    }

    protected function getRedirectUrl(): ?string
    {
        return route('wsdadm.brands');
    }


    public function mount(array $data = [], array $params = []): void
    {
        $this->data = $data;
        $this->params = $params;
        // Carrega os dados do SEO
        $this->mountSeo($this->data);
        // Inicializa o form
        $this->initializeForm();
    }

    protected function saveData(array $data): CatalogProductBrand
    {

        $catalogProductBrand = CatalogProductBrandRepository::updateOrCreate(
            id: $data['brand_id'],
            values: [
                'brand_name' => $data['brand_name'],
                'page_title' => $data['page_title'],
                'brand_key' => Str::slug($data['page_title']),
                'brand_url' => $data['brand_url'],
                'content' => $data['content'],
                'is_salable' => $data['is_salable'],
            ]
        );

        if ($catalogProductBrand) {

            if (!empty($postData['brand_id'])) {
                $message = "Marca atualizada com sucesso";

            } else {
                $message = 'Marca criada com sucesso!';

            }

            // Salva os dados do SEO
            $this->saveSeo();

            // Salva na tabela de UrlRewrite
            SysUrlRewriteRepository::saveUrlRewrite([
                'request_path' => $catalogProductBrand->brand_key,
                'target_path' => 'brand/' . $catalogProductBrand->brand_id,
                'target_type' => 'brand',
                'is_system' => 1,
            ]);

            // Mensagem de sucesso ao salvar os dados
            Session::flash('success', $message);
        }

        return $catalogProductBrand;

    }

    protected function getFormSchema(): array
    {
        return [
            Hidden::make('brand_id'),

            Tabs::make('Tabs')->tabs([

                Tab::make('Geral')->schema([

                    TextInput::make('brand_name')
                        ->label('Nome da marca')
                        ->required(),

                    TextInput::make('brand_url')
                        ->label('URL da marca'),

                    Select::make('is_salable')
                        ->label('Permitir Página da Marca')
                        ->options([
                            1 => 'Sim',
                            0 => 'Não'
                        ])
                        ->required(),
                ]),

                Tab::make('Página')->schema([

                    TextInput::make('page_title')
                        ->label('Título da Página')
                        ->required(),

                    RichEditor::make('content')
                        ->label('Conteúdo')
                        ->required(),

                ]),
                Tab::make('SEO')->schema(
                    $this->seoTab()
                )
            ])
        ];
    }

}
