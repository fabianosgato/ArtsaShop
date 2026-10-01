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

use App\Models\CmsFaq;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Tabs;
use Idea\Framework\Repository\Cms\CmsFaqRepository;
use Idea\Framework\View\Wsdadm\Components\FormComponent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class FaqForm extends FormComponent
{

    protected function getModel(): string
    {
        return CmsFaq::class;
    }

    protected function getTitle(): string
    {
        return 'Faq - Pergunta e resposta';
    }

    protected function getDescription(): string
    {
        if ($this->isEditing()) {
            return "Atualizar Faq: {$this->data['faq_title']}";
        }
        return 'Inserir uma nova Faq';
    }

    protected function getSuccessBody(): string
    {
        return 'A Faq foi inserida/atualizada com sucesso.';
    }

    protected function getRedirectUrl(): ?string
    {
        return route('wsdadm.cms.faq');
    }

    protected function getFormSchema(): array
    {
        return [
            Tabs::make('Tabs')->tabs([

                Tabs\Tab::make('Geral')->schema([

                    Hidden::make('faq_id'),

                    TextInput::make('faq_title')
                        ->label('Título do Bloco')
                        ->required(),

                    RichEditor::make('faq_content')
                        ->label('Conteúdo')
                        ->required(false),

                ])

            ])
        ];
    }

    protected function saveData(array $data): ?Model
    {

        $cmsFaq = CmsFaqRepository::updateOrCreate(
            id: $data['faq_id'] ?? null,
            values: [
                'faq_title' => $data['faq_title'],
                'faq_content' => $data['faq_content'],
            ]
        );

        if (!empty($data['faq_id'])) {
            $message = "FAQ atualizada com sucesso!";
        } else {
            $message = "FAQ criada com sucesso";
        }

        // Mensagem de sucesso ao salvar os dados
        Session::flash('success', $message);

        return $cmsFaq;

    }

}
