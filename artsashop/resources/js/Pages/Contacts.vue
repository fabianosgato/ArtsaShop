<script setup>
import {useForm} from '@inertiajs/vue3'
import InputError from "../Utils/InputError.vue";
import ButtonSubmit from "../Components/ButtonSubmit.vue";

const form = useForm({
    contact_name: null,
    email_address: null,
    phone_contacts: null,
    subject_contacts: null,
    message_contacts: null
})

const sendMessage = () => {
    form.post(route('contacts.sendPost'), {
        preserveScroll: true,
        onSuccess: () => {

        },
    });
}

</script>

<template>
    <Head title="Fale Conosco" />
    <div class="page-title title-buttons">
        <h1>Fale Conosco</h1>
    </div>
    <div class="grid grid-cols-2 gap-2">
        <div class="p-4 fieldset">

            <form @submit.prevent="sendMessage">
                <h2>Gostaríamos de ouvir sua opinião. Envie-nos uma mensagem preenchendo o formulário abaixo
                    e entraremos em contato com você em breve.</h2>
                <div class="py-2">
                    <label class="required">
                        <em>*</em> Nome Completo
                        <input id="contact_name"
                               type="text"
                               v-model="form.contact_name"
                               class="w-full"
                               required
                               placeholder="Seu Nome Completo">
                        <InputError :message="form.errors.contact_name"/>
                    </label>
                </div>
                <div class="py-2">
                    <label class="required">
                        <em>*</em> Endereço de E-mail
                        <input id="email_address"
                               type="email"
                               v-model="form.email_address"
                               required
                               class="w-full border border-gray-300 px-2 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blumine-500 focus:border-blumine-500 transition"
                               placeholder="seu@email.com">
                        <small class="required">{{ form.errors.email_address }}</small>
                        <span class="obs">
                            Nunca compartilharemos seu e-mail com ninguém.
                        </span>
                    </label>
                    <div class="py-2">
                        <label class="required">
                            <em>*</em> Telefone/WhatsApp
                            <input id="phone_contacts"
                                   type="text"
                                   v-mask="'phone'"
                                   v-model="form.phone_contacts"
                                   required
                                   class="mask-telefone w-full"
                                   placeholder="(xx) xxxx-xxxx">
                            <small class="required">{{ form.errors.phone_contacts }}</small>
                            <span class="obs">Nunca compartilharemos seu telefone com ninguém.</span>
                        </label>
                    </div>
                    <div class="py-2">
                        <label class="required">
                            <em>*</em> Assunto
                            <input type="text"
                                   id="subject_contacts"
                                   v-model="form.subject_contacts"
                                   required
                                   class="w-full"
                                   placeholder="Informe o Assunto">
                            <small class="required">{{ form.errors.subject_contacts }}</small>
                        </label>
                    </div>
                    <div class="mb-6">
                        <label for="message_contacts" class="required">
                            <em>*</em> Mensagem
                            <textarea id="message_contacts"
                                      v-model="form.message_contacts"
                                      rows="4"
                                      required
                                      placeholder="Digite sua mensagem"
                                      class="w-full"></textarea>
                            <small class="required">{{ form.errors.message_contacts }}</small>
                        </label>
                    </div>
                    <div class="border-t p-6 flex justify-between items-center">
                        <span class="text-sm text-gray-500"> * Campos obrigatórios </span>
                        <ButtonSubmit class="btn btn-large btn-light" :processing="form.processing">
                            Enviar
                        </ButtonSubmit>

                    </div>
                </div>
            </form>

        </div>
    </div>
</template>

<style scoped>

</style>
