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

namespace Modules\System\Livewire\Form;

use App\Models\SysConfigDatum;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Idea\Framework\Repository\System\SysConfigRespository;
use Idea\Framework\View\Wsdadm\Components\FormComponent;
use Illuminate\Support\Facades\Cache;

class SysConfigForm extends FormComponent
{

    public ?array $data = [];

    public function mount(array $data = [], array $params = []): void
    {

        foreach ($data as $key => $value) {
            $this->data[$key] = $value;
        }

        $this->params = $params;

        $this->initializeForm();

    }

    protected function getModel(): string
    {
        return SysConfigDatum::class;
    }

    protected function getTitle(): string
    {
        return 'Configurações do sistema';
    }

    protected function getDescription(): string
    {
        return 'Configurações gerais do Sistema';
    }

    protected function getSuccessTitle(): string
    {
        return "Configurações Salvas com Sucesso";
    }

    protected function getSuccessBody(): string
    {
        return 'As configurações foram salvas e carregadas com sucesso';
    }

    protected function getRedirectUrl(): ?string
    {
        return route('wsdadm.sysconfig');
    }

    protected function hasSaveAndContinue(): bool
    {
        return false;
    }

    protected function getFormSchema(): array
    {
        return [

            Tabs::make('Tabs')->tabs([

                // Configuração geral do sistema
                Tab::make('Geral')->schema([

                    Fieldset::make('Configurações da Loja')->schema([

                        TextInput::make('general/store_information/name')
                            ->label('Nome da loja')
                            ->required()
                            ->helperText(''),

                        TextInput::make('general/store_information/whatsapp')
                            ->label('WhatsApp da loja')
                            ->required()
                            ->helperText('Se estiver presente, isso será incluído em todos os e-mails transacionais.'),

                        TextInput::make('general/store_information/phone')
                            ->label('Telefone de Contato')
                            ->required()
                            ->helperText('Se estiver presente, isso será incluído em todos os e-mails transacionais.'),

                        TextInput::make('general/store_information/address')
                            ->label('Endereço de Contato')
                            ->required()
                            ->helperText('Se estiver presente, isso será incluído em todos os e-mails transacionais.'),

                    ]),

                    Fieldset::make('Opções de Localidade')->schema([

                        TextInput::make('general/locale/timezone')
                            ->label('Fuso horário')
                            ->required(),

                        TextInput::make('general/locale/code')
                            ->label('Localidade')
                            ->required(),

                    ]),


                ]),

                Tab::make('Endereços de e-mail')->schema([

                    Fieldset::make('Envio')->schema([
                        TextInput::make('trans_email/ident_send/name')
                            ->label('Nome do Remetente'),
                        TextInput::make('trans_email/ident_send/email')
                            ->label('E-mail do Remetente'),
                    ]),

                    Fieldset::make('Contato Geral')->schema([
                        TextInput::make('trans_email/ident_general/name')
                            ->label('Nome do Remetente'),
                        TextInput::make('trans_email/ident_general/email')
                            ->label('E-mail do Remetente'),
                    ]),

                    Fieldset::make('Vendas')->schema([
                        TextInput::make('trans_email/ident_sales/name')
                            ->label('Nome do Remetente'),
                        TextInput::make('trans_email/ident_sales/email')
                            ->label('E-mail do Remetente'),
                    ]),

                    Fieldset::make('Suporte')->schema([
                        TextInput::make('trans_email/ident_support/name')
                            ->label('Nome do Remetente'),
                        TextInput::make('trans_email/ident_support/email')
                            ->label('E-mail do Remetente'),
                    ]),

                ]),

                Tab::make('Catálogo')->schema([

                    Fieldset::make('Opções de Busca')->schema([

                        TextInput::make('catalog/search/min_query_length')
                            ->label('Tamanho Minimo')
                            ->helperText('Tamanho Mínimo de caracteres para busca'),

                        TextInput::make('catalog/search/max_query_length')
                            ->label('Tamanho máximo')
                            ->helperText('Tamanho máximo de caracteres para busca'),

                        TextInput::make('catalog/search/max_query_words')
                            ->label('Contagem máxima de palavras na busca')
                            ->helperText('Tamanho máximo de palavras para busca'),

                        Radio::make('catalog/search/show_autocomplete_results')
                            ->label('Mostrar resultados rápidos')
                            ->helperText('Exibe resultados ao digitar na busca')
                            ->boolean()
                            ->options([
                                true => 'Habilitado',
                                false => 'Desabilitado'
                            ]),

                        Radio::make('catalog/config/generate_sku')
                            ->label('Gerar SKU automaticamente')
                            ->helperText('Gerar SKUs automaticamente')
                            ->options([
                                true => 'Habilitado',
                                false => 'Desabilitado'
                            ])

                    ]),

                ]),

//                Tab::make('Repasse')->schema([
//
//                    Fieldset::make('Configurações gerais do Repasse')->schema([
//
//
//                    ])
//
//                ]),

                Tab::make('Pagamentos')->schema([

                    Fieldset::make('Pagar-me')->schema([

                        Radio::make('payments/pagarme/active')
                            ->label('Habilitado')
                            ->helperText('Módulo de Pagamento do Pagar-me Habilitado')
                            ->boolean()
                            ->options([
                                true => 'Habilitado',
                                false => 'Desabilitado'
                            ]),

                        Select::make('payments/pagarme/environment')
                            ->label('Ambiente')
                            ->helperText('Para desenvolvimento escolha SANDBOX')
                            ->options([
                                'SANDBOX' => 'SandBox - Ambiente de teste/homologação',
                                'PRODUCTION' => 'Produção'
                            ]),

                        TextInput::make('payments/pagarme/base_url')
                            ->label('URL do Pagar-me')
                            ->helperText('URL da API do Pagar-me, tanto para produção quanto para homologação'),

                        TextInput::make('payments/pagarme/sandbox_account_id')
                            ->label('ID da conta de teste/homologação')
                            ->helperText('ID da conta do Pagar-me para o ambiente de teste/homologação'),

                        TextInput::make('payments/pagarme/sandbox_public_key')
                            ->label('PublicKey do Ambiente de teste/homologação')
                            ->helperText('Chave Pública do Pagar-me para o ambiente de teste/homologação'),

                        TextInput::make('payments/pagarme/sandbox_secret_key')
                            ->label('SecretKey do Ambiente teste/homologação')
                            ->helperText('Chave Privada do Pagar-me para o ambiente de teste/homologação'),

                        TextInput::make('payments/pagarme/production_account_id')
                            ->label('ID da conta de Produção')
                            ->helperText('ID da conta do Pagar-me para o ambiente de Produção'),

                        TextInput::make('payments/pagarme/production_public_key')
                            ->label('PublicKey do Ambiente de Produção')
                            ->helperText('Chave Pública do Pagar-me o ambiente de produção'),

                        TextInput::make('payments/pagarme/production_secret_key')
                            ->label('SecretKey do Ambiente de Produção')
                            ->helperText('Chave Privada do Pagar-me para o ambiente de produção'),

                    ])->columns(1),

                    Fieldset::make('Ipag')->schema([

                        Radio::make('payments/ipag/active')
                            ->label('Habilitado')
                            ->helperText('Módulo de Pagamento do Ipag Habilitado')
                            ->boolean()
                            ->options([
                                true => 'Habilitado',
                                false => 'Desabilitado'
                            ]),

                        Select::make('payments/ipag/environment')
                            ->label('Ambiente')
                            ->helperText('Para desenvolvimento escolha SANDBOX')
                            ->options([
                                'SANDBOX' => 'SandBox - Ambiente de teste/homologação',
                                'PRODUCTION' => 'Produção'
                            ]),

                        TextInput::make('payments/ipag/sandbox_base_url')
                            ->label('URL do Ambiente SANDBOX')
                            ->helperText('URL do ambiente de teste/homologação do Ipag'),

                        TextInput::make('payments/ipag/production_base_url')
                            ->label('URL do Ambiente SANDBOX')
                            ->helperText('URL de produção do Ipag'),

                        TextInput::make('payments/ipag/ipag_merchantid')
                            ->label('MerchantId do Ipag')
                            ->helperText('Código do cliente no IPag'),

                        TextInput::make('payments/ipag/sandbox_ipag_id')
                            ->label('SandBox ID do Ipag')
                            ->helperText('ID do ambiente teste/homologação no IPag'),

                        TextInput::make('payments/ipag/sandbox_ipag_key')
                            ->label('Chave SandBox do Ipag')
                            ->helperText('Chave do ambiente de teste/homologação no IPag'),

                        TextInput::make('payments/ipag/production_ipag_id')
                            ->label('SandBox ID do Ipag')
                            ->helperText('ID do ambiente de produção no IPag'),

                        TextInput::make('payments/ipag/production_ipag_key')
                            ->label('Chave SandBox do Ipag')
                            ->helperText('Chave do ambiente de Produção no IPag'),

                    ])->columns(1),

                ])

            ])

        ];
    }

    /**
     * Salva os dados da configuração do sistema
     * @param array $data
     * @return \App\Models\SysConfigDatum
     */
    protected function saveData(array $data): SysConfigDatum
    {

        // Salva os dados da configuração
        foreach ($data as $path => $value) {

            $sysConfig = SysConfigRespository::getData()->updateOrCreate(
                attributes: [
                    'path' => $path
                ],
                values: [
                    'value' => $value
                ]
            );

        }

        // Limpa o cache da configuração do sistema
        Cache::forget('idea.sysconfig');

        return $sysConfig;

    }

}
