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

use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Actions;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Model;
use Livewire\Component;

abstract class FormComponent extends Component implements HasForms, HasActions
{

    use InteractsWithForms;
    use InteractsWithActions;

    public ?array $data = [];
    public array $params = [];

    abstract protected function saveData(array $data): ?Model;

    abstract protected function getFormSchema(): array;

    abstract protected function getModel(): string;

    public function mount(array $data = [], array $params = []): void
    {
        $this->data = $data;
        $this->params = $params;

        $this->initializeForm();
    }

    protected function initializeForm(): void
    {
        $this->form->fill($this->data);
    }

    protected function getTitle(): string
    {
        return '';
    }

    protected function getDescription(): string
    {
        return '';
    }

    protected function getPrimaryKeyName(): string
    {
        return app($this->getModel())->getKeyName();
    }

    protected function isEditing(): bool
    {
        return filled(
            data_get(
                $this->data,
                $this->getPrimaryKeyName()
            )
        );
    }

    protected function hasTopActions(): bool
    {
        return true;
    }

    protected function hasBottomActions(): bool
    {
        return true;
    }

    protected function getStatePath(): string
    {
        return 'data';
    }

    /**
     * Metodo que cria as Actions para os formulários
     * @return array
     */
    protected function getFormActions(): array
    {
        $actions = [

            Action::make('save')
                ->label('Salvar')
                ->action('save')
                ->color('primary'),

        ];

        if ($this->hasSaveAndContinue()) {
            $actions[] = Action::make('saveAndContinue')
                ->label('Salvar e continuar editando')
                ->color('primary')
                ->action('saveAndContinue')
                ->keyBindings(['mod+s']);

        }

        return $actions;

    }

    public function form(Schema $schema): Schema
    {

        $components = [];

        if ($this->hasTopActions()) {
            $components[] = Actions::make($this->getFormActions());
        }

        $components = array_merge(
            $components,
            $this->getFormSchema()
        );

        if ($this->hasBottomActions()) {
            $components[] = Actions::make($this->getFormActions())
                ->alignEnd();
        }

        return $schema
            ->components($components)
            ->statePath($this->getStatePath());
    }

    protected function syncForm(Model $model): void
    {
        $this->data = array_merge(
            $this->data,
            $model->toArray()
        );

        $this->form->fill($this->data);
    }

    public function save()
    {
        if (!$this->persist()) {
            return;
        }

        if ($url = $this->getRedirectUrl()) {
            return redirect($url);
        }
    }

    public function saveAndContinue(): void
    {
        $this->persist();
    }

    protected function persist(): bool
    {

        $model = $this->saveData(
            $this->form->getState()
        );

        if (!$model) {

            Notification::make()
                ->danger()
                ->title($this->getErrorTitle())
                ->body($this->getErrorBody())
                ->send();

            return false;

        } else {

            // Atualiza o form com os dados cadastrados
            $this->syncForm(
                model: $model
            );

            Notification::make()
                ->success()
                ->title($this->getSuccessTitle())
                ->body($this->getSuccessBody())
                ->send();


        }

        return true;

    }

    protected function getSuccessTitle(): string
    {
        return 'Registro salvo com sucesso.';
    }

    protected function getSuccessBody(): string
    {
        return '';
    }

    protected function getErrorTitle(): string
    {
        return 'Erro ao salvar.';
    }

    protected function getErrorBody(): string
    {
        return '';
    }

    protected function getRedirectUrl(): ?string
    {
        return null;
    }

    protected function hasSaveAndContinue(): bool
    {
        return true;
    }

    public function render(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        return view('wsdadm.partials.forms.fields');
    }

}
