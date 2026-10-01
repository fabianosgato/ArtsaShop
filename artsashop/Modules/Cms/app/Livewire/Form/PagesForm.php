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

use App\Models\CmsPage;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Idea\Framework\Repository\Cms\CmsPageRepository;
use Idea\Framework\Repository\System\SysUrlRewriteRepository;
use Idea\Framework\View\Wsdadm\Components\FormComponent;
use Idea\Framework\View\Wsdadm\Concerns\HasSeoForm;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class PagesForm extends FormComponent
{

    use HasSeoForm;

    public ?array $data = [];
    public string $title = 'CMS: Páginas de Conteúdo';
    public string $description = '';

    protected function getModel(): string
    {
        return CmsPage::class;
    }

    protected function seoObject(): string
    {
        return 'cms';
    }

    protected function seoObjectId(): ?string
    {
        return $this->data['page_id'] ?? null;
    }

    protected function getTitle(): string
    {
        return 'Páginas de Conteúdo';
    }

    protected function getDescription(): string
    {
        if ($this->isEditing()) {
            return "Atualizar Página de Conteúdo: {$this->data['title']}";
        }
        return 'Inserir uma nova página de Conteúdo';
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
        // Inicializa o form
        $this->initializeForm();
    }

    protected function getFormSchema(): array
    {
        return [
            Hidden::make('page_id'),

            Tabs::make('Tabs')->tabs([

                Tabs\Tab::make('Geral')->schema([

                    TextInput::make('title')
                        ->label('Título da página')
                        ->required(),

                    RichEditor::make('content')
                        ->label('Conteúdo')
                        ->fileAttachmentsVisibility('public')
                        ->required(),

                    Select::make('is_active')
                        ->label('Ativo')
                        ->options([
                            1 => 'Sim',
                            0 => 'Não'
                        ])
                        ->required(),

                ]),
                Tab::make('SEO')->schema(
                    $this->seoTab()
                ),

            ]),
        ];
    }

    /**
     * @param array $data
     * @return \App\Models\CmsPage
     */
    protected function saveData(array $data): CmsPage
    {

        // Insere/Atualiza os dados da página
        $cmsPage = CmsPageRepository::updateOrCreate(
            id: $data['page_id'],
            values: [
                'title' => $data['title'],
                'content' => $data['content'],
                'slug_key' => Str::slug($data['title']),
                'is_active' => $data['is_active'],
            ]
        );

        if (!empty($data['page_id'])) {
            $message = "Página Atualizada com sucesso";
        } else {
            $message = "Página Criada com sucesso";
        }

        // Salva os dados do SEO
        $this->saveSeo();

        // Salva na tabela de UrlRewrite
        SysUrlRewriteRepository::saveUrlRewrite([
            'request_path' => $cmsPage->slug_key,
            'target_path' => 'cms/' . $cmsPage->page_id,
            'target_type' => 'cms',
            'is_system' => 1,
        ]);

        // Mensagem de sucesso ao salvar os dados
        Session::flash('success', $message);

        return $cmsPage;

    }

}
