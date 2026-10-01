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
namespace Idea\Framework\View\Wsdadm\Concerns;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Fieldset;
use Idea\Framework\Repository\Seo\SeoMetaTagRepository;
use Idea\Framework\Repository\Seo\SeoPageRepository;

trait HasSeoForm
{

    protected ?int $seoPageId = null;

    /**
     * Deve ser sobrescrito no Form
     */
    abstract protected function seoObject(): string;

    abstract protected function seoObjectId(): ?string;

    protected function mountSeo(array $data): void
    {
        $this->applySeoDefaults($data);
        $this->resolveSeoPage();
    }

    protected function applySeoDefaults(array $data): void
    {
        $this->data = $data;

        $this->data['seo_page'] = array_replace(
            $this->seoPageDefaults(),
            $this->data['seo_page'] ?? []
        );
    }

    protected function seoPageDefaults(): array
    {

        return [
            'robot_index' => 'index',
            'robot_follow' => 'follow',
            'change_frequency' => 'monthly',
            'priority' => 0.5,
            'title_source' => 'manual',
            'description_source' => 'manual',
        ];

    }

    protected function resolveSeoPage(): void
    {
        if (!$this->seoObjectId()) {
            return;
        }

        // Valida se há pagina de SEO vinculada
        $seoPage = SeoPageRepository::findByObject(
            $this->seoObject(),
            $this->seoObjectId()
        );

        if (!$seoPage) {

            // Monta o formulário de Tags com os padroes definidos
            $seoMetaTags = SeoMetaTagRepository::getData()->get();
            foreach ($seoMetaTags as $seoMetaTag) {
                $this->data['seo_meta'][$seoMetaTag->seo_meta_tag_id] = $seoMetaTag->default_value;
            }

        } else {

            $this->seoPageId = $seoPage->seo_page_id;

            // Preenche seo_page
            $this->data['seo_page'] = array_replace(
                $this->data['seo_page'] ?? [],
                [
                    'path' => $seoPage->path,
                    'canonical_url' => $seoPage->canonical_url,
                    'title' => $seoPage->title,
                    'title_source' => $seoPage->title_source,
                    'description' => $seoPage->description,
                    'description_source' => $seoPage->description_source,
                    'robot_index' => $seoPage->robot_index,
                    'robot_follow' => $seoPage->robot_follow,
                    'change_frequency' => $seoPage->change_frequency,
                    'priority' => $seoPage->priority,
                    'focus_keyword' => $seoPage->focus_keyword,
                    'tags' => $seoPage->tags,
                ]
            );

            // Valida se há meta-tags do SEO
            if (count($seoPage->metaTags()->get()) > 0) {

                // Preenche seo_meta
                foreach ($seoPage->metaTags()->get() as $meta) {

                    if (!$meta->content) {
                        $seoMetaTags = SeoMetaTagRepository::getData()->where(
                            column: 'seo_meta_tag_id',
                            operator: '=',
                            value: $meta->seo_meta_tag_id
                        )->first();

                        $this->data['seo_meta'][$meta->seo_meta_tag_id] = $seoMetaTags->default_value;
                    } else {
                        $this->data['seo_meta'][$meta->seo_meta_tag_id] = $meta->content;

                    }

                }

            } else {
                // Monta o formulário com os padroes
                $seoMetaTags = SeoMetaTagRepository::getData()->get();
                foreach ($seoMetaTags as $seoMetaTag) {
                    $this->data['seo_meta'][$seoMetaTag->seo_meta_tag_id] = $seoMetaTag->default_value;
                }

            }

        }

    }

    protected function seoTab(): array
    {

        return [

            Fieldset::make('Informações Seo da Página')
                ->schema(
                    components: $this->buildSeoPageFields()
                )
                ->columns(1),

            Fieldset::make('Informações das Meta Tags da página')
                ->schema(
                    components: $this->buildSeoMetaFields()
                )
                ->columns(1),
        ];

    }

    protected function buildSeoPageFields(): array
    {
        return [

            TextInput::make('seo_page.title')
                ->label('Title (SEO)')
                ->maxLength(70)
                ->helperText('Recomendado até 60 caracteres'),

            Select::make('seo_page.title_source')
                ->label('Origem do Title')
                ->options([
                    'manual' => 'Manual',
                    'object_name' => 'Nome do objeto',
                    'auto' => 'Automático',
                ])
                ->default('manual'),

            Textarea::make('seo_page.description')
                ->label('Description (SEO)')
                ->maxLength(180)
                ->rows(3)
                ->helperText('Recomendado até 160 caracteres'),

            Select::make('seo_page.description_source')
                ->label('Origem da Description')
                ->options([
                    'manual' => 'Manual',
                    'object_description' => 'Descrição do objeto',
                    'auto' => 'Automático',
                ])
                ->default('manual'),

            TextInput::make('seo_page.path')
                ->label('Caminho (Slug)')
                ->disabled()
                ->dehydrated(),

            TextInput::make('seo_page.canonical_url')
                ->label('URL Canônica')
                ->disabled(),

            Select::make('seo_page.robot_index')
                ->options(['index' => 'Index', 'noindex' => 'No Index'])
                ->default('noindex'),

            Select::make('seo_page.robot_follow')
                ->options(['follow' => 'Follow', 'nofollow' => 'No Follow'])
                ->default('nofollow'),

            Select::make('seo_page.change_frequency')
                ->options([
                    'always' => 'Always',
                    'daily' => 'Daily',
                    'weekly' => 'Weekly',
                    'monthly' => 'Monthly',
                    'yearly' => 'Yearly',
                ])
                ->default('monthly'),

            TextInput::make('seo_page.priority')
                ->numeric()
                ->minValue(0)
                ->maxValue(1)
                ->step(0.1)
                ->default(0.5),

            TextInput::make('seo_page.focus_keyword')
                ->label('Focus Keyword'),

            Textarea::make('seo_page.tags')
                ->label('Tags'),

        ];
    }

    protected function buildSeoMetaFields(): array
    {
        $fields = [];

        $metaTags = app(SeoMetaTagRepository::class)
            ->getActiveForPage();

        foreach ($metaTags as $tag) {

            if ($tag->status == 'active') {

                $name = "seo_meta.$tag->seo_meta_tag_id";

                $field = match ($tag->input_type) {
                    'text' => TextInput::make($name),
                    'number' => TextInput::make($name)->numeric(),
                    'url' => TextInput::make($name)->url(),
//                    'file' => FileUpload::make($name),
                    default => TextInput::make($name),
                };

                $fields[] = $field
                    ->label($tag->input_label ?? $tag->name ?? $tag->property)
                    ->helperText($tag->input_info)
                    ->placeholder($tag->input_placeholder)
                    ->default($tag->default_value);

            }

        }

        return $fields;

    }

    protected function saveSeo(): void
    {
        if (!$this->seoObjectId()) {
            return;
        }

        $seoPageData = $this->data['seo_page'] ?? [];
        $seoMetaData = $this->data['seo_meta'] ?? [];

        $seoPageData['object'] = $this->seoObject();
        $seoPageData['object_id'] = $this->seoObjectId();

        // path e canonical
        if (!empty($this->data['host'])) {
            $seoPageData['path'] = $this->data['host'];
            $seoPageData['canonical_url'] = "https://{$this->data['host']}/";

        } else {
            $seoPageData['path'] ??= $this->resolveSeoPath();
            $seoPageData['canonical_url'] ??= url($seoPageData['path']);

        }

        $seoPage = app(SeoPageRepository::class)
            ->saveOrUpdateByObject(
                $this->seoObject(),
                $this->seoObjectId(),
                $seoPageData
            );

        app(SeoPageRepository::class)
            ->syncMetaTags($seoPage->seo_page_id, $seoMetaData);

    }

    protected function resolveSeoPath(): string
    {
        return $this->data['slug_key']
            ?? throw new \RuntimeException('Slug não encontrado para SEO');
    }

}
