<aside class="fixed inset-y-0 left-0 z-40 flex h-screen w-64 shrink-0 flex-col overflow-y-auto bg-wsadmin-950">
    <div class="min-h-full">
        '<div class="h-20">
            <a href="{{ route('wsdadm.dashboard') }}" class="brand-link">
                <img src="{{ asset('images/wsdadm/logo_menu.png') }}" alt="WsdAdm" class="brand-image">
            </a>
            <div class="flex pt-3.5">
                <nav class="flex-1 overflow-y-auto px-3 pb-6">
                    <div class="space-y-6">

                        {{-- Introdução --}}
                        <div>
                            <a href="#introducao"
                               class="group flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-medium
                          text-slate-300 transition-colors
                          hover:bg-white/10 hover:text-white">

                                <svg class="h-5 w-5 shrink-0 text-slate-400 group-hover:text-white"
                                     fill="none"
                                     viewBox="0 0 24 24"
                                     stroke-width="1.8"
                                     stroke="currentColor">
                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          d="M12 6.75v10.5m-3.75-7.5h7.5M6.75 4.5h10.5A2.25 2.25 0 0 1 19.5 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25H6.75A2.25 2.25 0 0 1 4.5 17.25V6.75A2.25 2.25 0 0 1 6.75 4.5Z" />
                                </svg>

                                <span>Introdução</span>
                            </a>
                        </div>


                        {{-- Marketplace --}}
                        <div>
                            <p class="px-3 mb-2 text-[11px] font-semibold uppercase tracking-wider text-slate-500">
                                Marketplace
                            </p>

                            <div class="space-y-1">

                                <a href="#marketplace-clinicas"
                                   class="group flex items-center gap-3 rounded-lg px-3 py-2 text-sm
                              text-slate-300 transition-colors
                              hover:bg-white/10 hover:text-white">

                                    <svg class="h-4 w-4 shrink-0 text-slate-500 group-hover:text-slate-300"
                                         fill="none"
                                         viewBox="0 0 24 24"
                                         stroke-width="1.8"
                                         stroke="currentColor">
                                        <path stroke-linecap="round"
                                              stroke-linejoin="round"
                                              d="M3 21h18M5.25 21V5.25A2.25 2.25 0 0 1 7.5 3h9a2.25 2.25 0 0 1 2.25 2.25V21M9 7.5h6M9 11.25h6M9 15h6" />
                                    </svg>

                                    <span>Clínicas</span>
                                </a>


                                <a href="#marketplace-pedidos"
                                   class="group flex items-center gap-3 rounded-lg px-3 py-2 text-sm
                              text-slate-300 transition-colors
                              hover:bg-white/10 hover:text-white">

                                    <svg class="h-4 w-4 shrink-0 text-slate-500 group-hover:text-slate-300"
                                         fill="none"
                                         viewBox="0 0 24 24"
                                         stroke-width="1.8"
                                         stroke="currentColor">
                                        <path stroke-linecap="round"
                                              stroke-linejoin="round"
                                              d="M6.75 3.75h10.5A2.25 2.25 0 0 1 19.5 6v14.25H4.5V6a2.25 2.25 0 0 1 2.25-2.25ZM8.25 3.75v3h7.5v-3M8.25 11.25h7.5M8.25 15h4.5" />
                                    </svg>

                                    <span>Pedidos</span>
                                </a>


                                <a href="#marketplace-financeiro"
                                   class="group flex items-center gap-3 rounded-lg px-3 py-2 text-sm
                              text-slate-300 transition-colors
                              hover:bg-white/10 hover:text-white">

                                    <svg class="h-4 w-4 shrink-0 text-slate-500 group-hover:text-slate-300"
                                         fill="none"
                                         viewBox="0 0 24 24"
                                         stroke-width="1.8"
                                         stroke="currentColor">
                                        <path stroke-linecap="round"
                                              stroke-linejoin="round"
                                              d="M3.75 18.75h16.5M5.25 16.5V9.75M9.75 16.5v-4.5M14.25 16.5V6.75M18.75 16.5v-9" />
                                    </svg>

                                    <span>Financeiro</span>
                                </a>

                            </div>
                        </div>


                        {{-- Catálogo --}}
                        <div>
                            <p class="px-3 mb-2 text-[11px] font-semibold uppercase tracking-wider text-slate-500">
                                Catálogo
                            </p>

                            <div class="space-y-1">

                                <a href="#catalogo-exames"
                                   class="group flex items-center gap-3 rounded-lg px-3 py-2 text-sm
                              text-slate-300 transition-colors
                              hover:bg-white/10 hover:text-white">

                                    <svg class="h-4 w-4 shrink-0 text-slate-500 group-hover:text-slate-300"
                                         fill="none"
                                         viewBox="0 0 24 24"
                                         stroke-width="1.8"
                                         stroke="currentColor">
                                        <path stroke-linecap="round"
                                              stroke-linejoin="round"
                                              d="m21 7.5-9-4.5-9 4.5m18 0-9 4.5m9-4.5v9l-9 4.5m0-9L3 7.5m9 4.5v9M7.5 5.25l9 4.5" />
                                    </svg>

                                    <span>Exames</span>
                                </a>


                                <a href="#catalogo-categorias"
                                   class="group flex items-center gap-3 rounded-lg px-3 py-2 text-sm
                              text-slate-300 transition-colors
                              hover:bg-white/10 hover:text-white">

                                    <svg class="h-4 w-4 shrink-0 text-slate-500 group-hover:text-slate-300"
                                         fill="none"
                                         viewBox="0 0 24 24"
                                         stroke-width="1.8"
                                         stroke="currentColor">
                                        <path stroke-linecap="round"
                                              stroke-linejoin="round"
                                              d="M3.75 6.75h16.5M3.75 12h16.5M3.75 17.25h16.5" />
                                    </svg>

                                    <span>Categorias</span>
                                </a>

                            </div>
                        </div>


                        {{-- Atributos --}}
                        <div>
                            <p class="px-3 mb-2 text-[11px] font-semibold uppercase tracking-wider text-slate-500">
                                Atributos
                            </p>

                            <a href="#atributos"
                               class="group flex items-center gap-3 rounded-lg px-3 py-2 text-sm
                          text-slate-300 transition-colors
                          hover:bg-white/10 hover:text-white">

                                <svg class="h-4 w-4 shrink-0 text-slate-500 group-hover:text-slate-300"
                                     fill="none"
                                     viewBox="0 0 24 24"
                                     stroke-width="1.8"
                                     stroke="currentColor">
                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          d="M7.5 7.5h.008v.008H7.5V7.5ZM3.75 6A2.25 2.25 0 0 1 6 3.75h4.69a2.25 2.25 0 0 1 1.59.66l7.31 7.31a2.25 2.25 0 0 1 0 3.18l-5.19 5.19a2.25 2.25 0 0 1-3.18 0L3.91 13.78a2.25 2.25 0 0 1-.66-1.59V6Z" />
                                </svg>

                                <span>Grupos de atributos</span>
                            </a>
                        </div>


                        {{-- CMS --}}
                        <div>
                            <p class="px-3 mb-2 text-[11px] font-semibold uppercase tracking-wider text-slate-500">
                                CMS
                            </p>

                            <a href="#cms"
                               class="group flex items-center gap-3 rounded-lg px-3 py-2 text-sm
                          text-slate-300 transition-colors
                          hover:bg-white/10 hover:text-white">

                                <svg class="h-4 w-4 shrink-0 text-slate-500 group-hover:text-slate-300"
                                     fill="none"
                                     viewBox="0 0 24 24"
                                     stroke-width="1.8"
                                     stroke="currentColor">
                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          d="M19.5 14.25v-8.5A2.25 2.25 0 0 0 17.25 3.5h-10.5A2.25 2.25 0 0 0 4.5 5.75v12.5a2.25 2.25 0 0 0 2.25 2.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-2.5M8.25 7.5h7.5M8.25 11.25h7.5M8.25 15h4.5" />
                                </svg>

                                <span>Páginas</span>
                            </a>
                        </div>


                        {{-- Configurações --}}
                        <div>
                            <p class="px-3 mb-2 text-[11px] font-semibold uppercase tracking-wider text-slate-500">
                                Configurações
                            </p>

                            <div class="space-y-1">

                                <a href="#configuracoes-lojas"
                                   class="manual-nav-item">
                                    <span>Lojas</span>
                                </a>

                                <a href="#configuracoes-usuarios"
                                   class="manual-nav-item">
                                    <span>Usuários</span>
                                </a>

                                <a href="#configuracoes-grupos-usuarios"
                                   class="manual-nav-item">
                                    <span>Grupos de usuários</span>
                                </a>

                                <a href="#configuracoes-modulos"
                                   class="manual-nav-item">
                                    <span>Módulos do sistema</span>
                                </a>

                                <a href="#configuracoes-status-produtos"
                                   class="manual-nav-item">
                                    <span>Status de produtos</span>
                                </a>

                                <a href="#configuracoes-seo"
                                   class="manual-nav-item">
                                    <span>SEO MetaTags</span>
                                </a>

                                <a href="#configuracoes-sistema"
                                   class="manual-nav-item">
                                    <span>Configurações do sistema</span>
                                </a>

                            </div>
                        </div>


                        {{-- Fluxo de vendas --}}
                        <div>
                            <p class="px-3 mb-2 text-[11px] font-semibold uppercase tracking-wider text-slate-500">
                                Fluxo de vendas
                            </p>

                            <div class="space-y-1">

                                <a href="#fluxo-vendas-geral" class="manual-nav-item">
                                    <span>Sobre</span>
                                </a>

                                <a href="#fluxo-vendas-principal" class="manual-nav-item">
                                    <span>Fluxo Prinipal</span>
                                </a>

                                <a href="#fluxo-pesquisa" class="manual-nav-item">
                                    <span>Pesquisa de exames</span>
                                </a>

                                <a href="#fluxo-agendamento" class="manual-nav-item">
                                    <span>Agendamento</span>
                                </a>

                                <a href="#fluxo-carrinho" class="manual-nav-item">
                                    <span>Carrinho</span>
                                </a>

                                <a href="#fluxo-checkout" class="manual-nav-item">
                                    <span>Checkout</span>
                                </a>

                                <a href="#fluxo-pagamento" class="manual-nav-item">
                                    <span>Pagamento</span>
                                </a>

                                <a href="#fluxo-aprovacao" class="manual-nav-item">
                                    <span>Aprovação da clínica</span>
                                </a>

                                <a href="#fluxo-cancelamento" class="manual-nav-item">
                                    <span>Cancelamento e reembolso</span>
                                </a>

                            </div>
                        </div>


                        {{-- Regras --}}
                        <div>
                            <p class="px-3 mb-2 text-[11px] font-semibold uppercase tracking-wider text-slate-500">
                                Sistema
                            </p>

                            <a href="#regras-sistema"
                               class="group flex items-center gap-3 rounded-lg px-3 py-2 text-sm
                          text-slate-300 transition-colors
                          hover:bg-white/10 hover:text-white">

                                <svg class="h-4 w-4 shrink-0 text-slate-500 group-hover:text-slate-300"
                                     fill="none"
                                     viewBox="0 0 24 24"
                                     stroke-width="1.8"
                                     stroke="currentColor">
                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          d="M11.25 11.25h1.5v5.25h-1.5v-5.25ZM12 7.5h.008v.008H12V7.5ZM12 21a9 9 0 1 0 0-18 9 9 0 0 0 0 18Z" />
                                </svg>

                                <span>Regras do sistema</span>
                            </a>
                        </div>

                        <div class="mt-4">

                            <p class="px-3 mb-2 text-[11px] font-semibold uppercase tracking-wider text-slate-500">
                                Sistema
                            </p>

                            <a href="#regras-sistema"
                               class="group flex items-center gap-3 rounded-lg px-3 py-2 text-sm
              text-slate-300 transition-colors
              hover:bg-white/10 hover:text-white">

                                <svg class="h-4 w-4 shrink-0 text-slate-500 group-hover:text-slate-300"
                                     fill="none"
                                     viewBox="0 0 24 24"
                                     stroke-width="1.8"
                                     stroke="currentColor">

                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          d="M11.25 11.25h1.5v5.25h-1.5v-5.25ZM12 7.5h.008v.008H12V7.5ZM12 21a9 9 0 1 0 0-18 9 9 0 0 0 0 18Z" />

                                </svg>

                                <span>Regras do sistema</span>

                            </a>


                            <a href="#informacoes-tecnicas"
                               class="group flex items-center gap-3 rounded-lg px-3 py-2 text-sm
              text-slate-300 transition-colors
              hover:bg-white/10 hover:text-white">

                                <svg class="h-4 w-4 shrink-0 text-slate-500 group-hover:text-slate-300"
                                     fill="none"
                                     viewBox="0 0 24 24"
                                     stroke-width="1.8"
                                     stroke="currentColor">

                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          d="M9 3h6m-6 0a2 2 0 0 0-2 2v1h10V5a2 2 0 0 0-2-2m-6 0v18m6-18v18M5 8h14M5 16h14M7 21h10" />

                                </svg>

                                <span>Informações técnicas</span>

                            </a>

                        </div>

                    </div>
                </nav>
            </div>
        </div>
    </div>
</aside>
