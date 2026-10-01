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

namespace Modules\Catalog\Livewire\Categories;

use App\Models\CatalogCategoryEntity;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Tabs;
use Idea\Framework\Repository\Catalog\CatalogCategoryRepository;
use Idea\Framework\Repository\System\SysUrlRewriteRepository;
use Idea\Framework\View\Wsdadm\Components\FormComponent;
use Idea\Framework\View\Wsdadm\Concerns\HasSeoForm;
use Illuminate\Database\Eloquent\Model;

class CategoriesForm extends FormComponent
{

    use HasSeoForm;

    public ?int $categoryId = null;
    public ?array $data = [];
    public string $title = 'Categorias de Produtos';
    public string $description = 'Inserir uma nova Categoria';

    protected function seoObject(): string
    {
        return 'category';
    }

    protected function seoObjectId(): ?string
    {
        return $this->data['entity_id'] ?? null;
    }

    public function mount(array $data = [], array $params = []): void
    {
        $this->data = $data;
        $this->params = $params;

        if (! empty($this->params['categoryId'])) {
            $this->loadCategory($this->params['categoryId']);
        }

        $this->initializeForm();
    }

    public function loadCategory(int $categoryId): void
    {
        $this->categoryId = $categoryId;

        $this->data = CatalogCategoryRepository::getCategoryById(
            $categoryId
        )->toArray();

        $this->mountSeo($this->data);

        $this->form->fill($this->data);
    }

    public function render(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        return view('catalog::wsdadm.livewire.categories.categories-form');
    }

    protected function saveData(array $data): ?Model
    {
        if (!empty($data['entity_id'])) {
            // Atualiza as informações da Categoria
            $catalogCategory = CatalogCategoryRepository::saveOrUpdate([
                'entity_id' => $data['entity_id'],
                'category' => $data['category'],
                'slug_key' => $data['slug_key'],
            ]);
            $message = "A Categoria foi atualizada com sucesso";
        } else {
            // Atualiza as informações da Categoria
            $catalogCategory = CatalogCategoryRepository::saveOrUpdate([
                'entity_id' => $data['entity_id'],
                'category' => $data['category'],
                'slug_key' => $data['slug_key'],
            ]);
            $message = "A Categoria foi inserida com sucesso";
        }

        // Retorna a categoria
        $catalogCategory = CatalogCategoryRepository::getCategoryById($catalogCategory->entity_id);

        // Salva os dados na SysUrlRewrite
        SysUrlRewriteRepository::saveUrlRewrite([
            'request_path' => $catalogCategory->slug_key,
            'target_path' => 'category/' . $catalogCategory->entity_id,
            'target_type' => 'category',
            'is_system' => 1,
        ]);

        // Salva os dados do SEO
        $this->saveSeo();

        Notification::make()
            ->title('Categoria salva com sucesso')
            ->body($message)
            ->success()
            ->send();

        return $catalogCategory;

    }

    protected function getFormSchema(): array
    {
        return [

            Tabs::make('Tabs')->tabs([

                Tabs\Tab::make('Informações da Categoria')->schema([
                    Hidden::make('entity_id'),
                    TextInput::make('category')
                        ->label('Título da Categoria')
                        ->helperText("O nome da categoria que será mostrado nas páginas do frontend")
                        ->required(),
                    TextInput::make('slug_key')
                        ->label('Slug')
                        ->required(),


                ]),
                Tabs\Tab::make('Seo')->schema(
                    // Informações de SEO
                    $this->seoTab()
                )
            ])
        ];
    }

    protected function getModel(): string
    {
        return CatalogCategoryEntity::class;
    }
}
