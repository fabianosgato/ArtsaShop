<div class="footer-static-container">
    <div class="container mx-auto px-4">
        <div class="footer-static">
            {{-- Futuro carrossel de marcas --}}
        </div>
    </div>
</div>

{{-- Footer Principal --}}

<div class="ma-footer-container bg-gray-100">
    <div class="container mx-auto px-4">
        <div class="footer py-12">

            <div class="grid grid-cols-1 md:grid-cols-12 gap-10">

                {{-- Sobre --}}
                <div class="md:col-span-6">
                    <div class="footer-title mb-4">
                        <h5 class="text-lg font-semibold">Sobre o ArtsaShop</h5>
                    </div>

                    <div class="content-block-footer space-y-4 text-sm text-gray-700">

                        <p>
                            O ArtsaShop é uma plataforma de e-commerce desenvolvida com foco em desempenho, segurança e uma experiência de compra intuitiva.
                            O projeto reúne recursos para gerenciamento de produtos, clientes, pedidos, pagamentos e conteúdo, utilizando uma arquitetura modular preparada
                            para crescimento e evolução contínua.
                        </p>

                        <div class="social-icons follow-icons flex gap-4 text-xl">

                            {{-- Facebook --}}
                            <a href="https://www.facebook.com/"
                               target="_blank"
                               rel="noopener nofollow"
                               class="hover:text-blue-600 transition">
                                <svg viewBox="0 0 24 24" class="w-10 h-10 fill-current">
                                    <path d="M22 12a10 10 0 1 0-11.63 9.87v-6.99H7.9V12h2.47V9.8c0-2.43 1.45-3.77 3.67-3.77 1.06 0 2.17.19 2.17.19v2.38h-1.22c-1.2 0-1.58.75-1.58 1.52V12h2.69l-.43 2.88h-2.26v6.99A10 10 0 0 0 22 12z"/>
                                </svg>
                            </a>

                            {{-- Instagram --}}
                            <a href="https://www.instagram.com/"
                               target="_blank"
                               rel="noopener nofollow"
                               class="hover:text-pink-600 transition">
                                <svg viewBox="0 0 24 24" class="w-10 h-10 fill-current">
                                    <path d="M7 2C4.2 2 2 4.2 2 7v10c0 2.8 2.2 5 5 5h10c2.8 0 5-2.2 5-5V7c0-2.8-2.2-5-5-5H7zm5 5a5 5 0 1 1 0 10 5 5 0 0 1 0-10zm6.5-.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z"/>
                                </svg>
                            </a>

                            {{-- YouTube --}}
                            <a href="https://www.youtube.com/"
                               target="_blank"
                               rel="noopener nofollow"
                               class="hover:text-red-600 transition">
                                <svg viewBox="0 0 24 24" class="w-10 h-10 fill-current">
                                    <path d="M23.5 6.2s-.2-1.7-.9-2.4c-.9-.9-1.9-.9-2.4-1C16.8 2.5 12 2.5 12 2.5h0s-4.8 0-8.2.3c-.5.1-1.5.1-2.4 1-.7.7-.9 2.4-.9 2.4S0 8.1 0 10v2c0 1.9.5 3.8.5 3.8s.2 1.7.9 2.4c.9.9 2.1.9 2.7 1 2 .2 8 .3 8 .3s4.8 0 8.2-.3c.5-.1 1.5-.1 2.4-1 .7-.7.9-2.4.9-2.4s.5-1.9.5-3.8v-2c0-1.9-.5-3.8-.5-3.8zM9.5 14.5v-5l5 2.5-5 2.5z"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Informações --}}
                <div class="md:col-span-3">
                    <div class="footer-title mb-4">
                        <h5 class="text-lg font-semibold">Informações</h5>
                    </div>

                    <div class="content-block-footer">
                        <ul class="space-y-2 text-sm">
                            <li><a href="{{ url('quem-somos') }}" class="hover:text-blue-600 transition">Quem Somos</a></li>
                            <li><a href="{{ url('politica-de-entrega') }}" class="hover:text-blue-600 transition">Política de Entrega</a></li>
                            <li><a href="{{ url('politica-de-trocas-e-devolucoes') }}" class="hover:text-blue-600 transition">Política de Devoluções</a></li>
                            <li><a href="{{ url('politica-de-privacidade') }}" class="hover:text-blue-600 transition">Política de Privacidade</a></li>
                        </ul>
                    </div>
                </div>

                {{-- Minha Conta --}}
                <div class="md:col-span-3">
                    <div class="footer-title mb-4">
                        <h5 class="text-lg font-semibold">Minha Conta</h5>
                    </div>

                    <div class="content-block-footer">
                        <ul class="space-y-2 text-sm">
                            <li><a href="{{ route('account.index') }}" class="hover:text-blue-600 transition">Painel</a></li>
                            <li><a href="{{ route('account.orders') }}" class="hover:text-blue-600 transition">Pedidos</a></li>
                            <li><a href="{{ route('account.edit') }}" class="hover:text-blue-600 transition">Detalhes da conta</a></li>
                            <li><a href="{{ route('checkout.cart') }}" class="hover:text-blue-600 transition">Carrinho</a></li>
                        </ul>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>
