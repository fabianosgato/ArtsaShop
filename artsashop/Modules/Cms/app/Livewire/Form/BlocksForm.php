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

use App\Models\CmsBlock;
use Filament\Forms\Components\CodeEditor;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Tabs;
use Idea\Framework\Repository\Cms\CmsBlockRepository;
use Idea\Framework\View\Wsdadm\Components\FormComponent;
use Illuminate\Support\Facades\Session;


class BlocksForm extends FormComponent
{

    public ?array $data = [];
    public string $title = 'CMS: Blocks de Conteúdo';
    public string $description = 'Inserir um Bloco de Conteúdo';

    protected function getModel(): string
    {
        return CmsBlock::class;
    }

    protected function getTitle(): string
    {
        return 'Bloco de Conteúdo';
    }

    protected function getDescription(): string
    {
        if ($this->isEditing()) {
            return "Atualizar Bloco de Conteúdo: {$this->data['title']}";
        }
        return 'Inserir uma novo Bloco de Conteúdo';
    }

    protected function getSuccessBody(): string
    {
        return 'O Bloco de Conteúdo foi inserido/atualizado com sucesso.';
    }

    protected function getRedirectUrl(): ?string
    {
        return route('wsdadm.cms.blocks');
    }

    /**
     * Salva os registros no banco de dados
     */
    protected function saveData(array $data): ?CmsBlock
    {

        $cmsBlock = CmsBlockRepository::updateOrCreate(
            id: $data['block_id'] ?? null,
            values: $data
        );

        if (!empty($postData['block_id'])) {
            Session::flash('success', 'Bloco Atualizado com sucesso!');

        } else {
            Session::flash('success', 'Bloco criado com sucesso!');
        }

        return $cmsBlock;

    }

    protected function getFormSchema(): array
    {
        return [
            Tabs::make('Tabs')->tabs([

                Tabs\Tab::make('Geral')->schema([

                    Hidden::make('block_id'),

                    TextInput::make('title')
                        ->label('Título do Bloco')
                        ->required(),

                    TextInput::make('identifier')
                        ->label('Identificador do Bloco')
                        ->required(),

                    CodeEditor::make('content')
                        ->label('Conteúdo')
                        ->required(false),

                    Radio::make('is_active')
                        ->label('Ativo')
                        ->boolean()
                        ->required(),


                ])

            ])
        ];
    }

}
