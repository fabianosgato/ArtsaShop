<?php
/**
 * Fabiano Gato
 *
 * NOTICE OF LICENSE
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 *
 * É concedida permissão, gratuitamente, a qualquer pessoa que obtenha uma cópia
 * deste software e arquivos de documentação associados
 *
 *****************************************************
 *
 * @copyright    Copyright (c) Fabiano Gato
 * @author       Fabiano Gato <fabianogattoti@gmail.com>
 *
 */

namespace Modules\System\Livewire\Grids;

use App\Models\User;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Notifications\Notification;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Idea\Framework\Admin\Grids\Grid;
use Idea\Framework\Repository\System\SysUserRepository;


final class SysUserGrid extends Grid
{

    public string $heading = 'Usuários do sistema';
    public string $primaryKey = 'sys_users.user_id';
    public string $sortDirection = 'desc';

    public function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->query(SysUserRepository::getData())
            ->heading($this->heading)
            ->columns([
                TextColumn::make('name')
                    ->label("Nome do usuario")
                    ->toggleable()
                    ->searchable(['sys_users.name']),

                TextColumn::make('group_name')
                    ->label("Grupo")
                    ->toggleable()
                    ->searchable(['sys_group.group_name']),

                TextColumn::make('email')
                    ->label("Email do usuario")
                    ->toggleable()
                    ->searchable(['sys_users.email']),

                TextColumn::make('status')
                    ->label("Ativo")
                    ->toggleable()
                    ->verticallyAlignCenter()
                    ->alignCenter()
                    ->searchable(['sys_users.status'])
                    ->color(fn(string $state): string => match ($state) {
                        '1' => 'success',
                        '0' => 'warning',
                    })
                    ->formatStateUsing(function ($state) {
                        return ($state == 1 ? 'Habilitado' : 'Desabilitado');
                    })
                    ->extraHeaderAttributes([
                        'class' => 'w-8'
                    ]),

            ])
            ->recordActions([

                ActionGroup::make([

                    Action::make('edit')
                        ->label('Editar')
                        ->url(fn(User $record): string => route('wsdadm.sysusers.edit', [
                            'id' => $record->user_id
                        ])),

                    DeleteAction::make()
                        ->label('Excluir')
                        ->icon(null)
                        ->modalHeading("Excluir Usuário")
                        ->modalDescription("Deseja Excluir esse Usuário?")
                        ->successNotification(
                            Notification::make()
                                ->success()
                                ->title('Usuário Excluído')
                                ->body('O Usuário foi excluido com sucesso'),
                        )

                ])
            ])
            ->paginationPageOptions(
                options: $this->paginationPageOptions
            )
            ->striped()
            ->recordUrl(null)
            ->defaultSort(
                column: $this->primaryKey,
                direction: $this->sortDirection
            )
            ->persistFiltersInSession();

    }


}
