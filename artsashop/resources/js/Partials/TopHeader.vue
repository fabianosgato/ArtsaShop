<script setup>
import {ref} from 'vue';
import {usePage} from "@inertiajs/vue3";

const open = ref(false);
const page = usePage();
const appUrl = page.props.appUrl
</script>

<template>
    <div id="top_header">
        <div class="container">
            <div class="md:px-2">

                <div class="topheader-left">
                    <button
                        class="account-top-menu"
                        type="button"
                        @click="open = !open"
                        :aria-expanded="open"
                        aria-label="Abrir menu da conta"
                    >
                        Minha conta
                    </button>

                    <ul
                        class="links topheader-mobile-trigger"
                        :class="{ 'is-open': open }"
                    >
                        <li class="wellcome">
                            Seja Bem-vindo
                        </li>

                        <li>
                            <a class="link" :href="route('account.login')">
                                Entre / Registre-se
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="topheader-right">
                    <ul class="links">
                        <li class="link"><a :href="route('index.home')">Home</a></li>
                        <li class="link"><a :href="appUrl + 'quem-somos'">Quem Somos</a></li>
                        <li class="contact-us-now"><a :href="appUrl + 'fale-conosco'">Fale Conosco</a></li>
                    </ul>
                </div>

            </div>
        </div>
    </div>
</template>
