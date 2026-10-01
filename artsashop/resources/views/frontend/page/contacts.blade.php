<x-frontend.app-layout layout="1column">
    <div class="page-title title-buttons">
        <h1>Fale Conosco</h1>
    </div>

    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

    <div class="grid grid-cols-2 gap-2">
        <div class="p-4 fieldset">

            @if(session('success'))
                <div class="mb-6 p-4 rounded bg-green-100 text-green-700 text-sm">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-6 p-4 rounded bg-red-100 text-red-700 text-sm">
                    <ul class="list-disc pl-5 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="{{ route('contacts.sendPost') }}" method="post" autocomplete="off">
                <h2>Gostaríamos de ouvir sua opinião. Envie-nos uma mensagem preenchendo o formulário abaixo
                    e entraremos em contato com você em breve.</h2>
                @csrf

                <div class="py-2">
                    <label class="block text-sm font-medium mb-1 required">
                        <em>*</em> Nome Completo
                    </label>
                    <input type="text"
                           name="contact_name"
                           value="{{ session('success') ? '' : old('contact_name') }}"
                           required
                           class="w-full border border-gray-300 px-2 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blumine-500 focus:border-blumine-500 transition">

                </div>

                {{-- EMAIL --}}
                <div class="py-2">
                    <label class="block text-sm font-medium mb-1 required">
                        <em>*</em> Endereço de E-mail
                    </label>
                    <input type="email"
                           name="email_address"
                           value="{{ session('success') ? '' : old('email_address') }}"
                           required
                           class="w-full border border-gray-300 px-2 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blumine-500 focus:border-blumine-500 transition">
                    <p class="text-xs text-gray-500 mt-1">
                        Nunca compartilharemos seu e-mail com ninguém.
                    </p>
                </div>

                {{-- Telefone --}}
                <div class="py-2">
                    <label class="block text-sm font-medium mb-1 required">
                        <em>*</em> Telefone/WhatsApp
                    </label>
                    <input type="text"
                           name="phone_contacts"
                           value="{{ session('success') ? '' : old('phone_contacts') }}"
                           required
                           class="mask-telefone w-full border border-gray-300 px-2 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blumine-500 focus:border-blumine-500 transition">
                    <p class="text-xs text-gray-500 mt-1">
                        Nunca compartilharemos seu telefone com ninguém.
                    </p>
                </div>

                {{-- Assunto --}}
                <div class="py-2">
                    <label class="block text-sm font-medium mb-1 required">
                        <em>*</em> Assunto
                    </label>
                    <input type="text"
                           name="subject_contacts"
                           value="{{ session('success') ? '' : old('subject_contacts') }}"
                           required
                           class="w-full border border-gray-300 px-2 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blumine-500 focus:border-blumine-500 transition">
                </div>

                {{-- Mensagem --}}
                <div class="mb-6">
                    <label for="message_contacts" class="block text-gray-700 font-medium mb-2 required">
                        <em>*</em> Mensagem
                    </label>
                    <textarea id="message_contacts" name="message_contacts" rows="4" required
                              class="w-full border border-gray-300 px-2 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blumine-500 focus:border-blumine-500 transition">
                        {{ session('success') ? '' : old('message_contacts') }}
                    </textarea>
                </div>

                <div class="mb-4">
                    <div class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.site_key') }}"></div>
                </div>

                <div class="border-t p-6 flex justify-between items-center">
                    <span class="text-sm text-gray-500"> * Campos obrigatórios </span>
                    <button type="submit" class="px-6 py-2 bg-celadon-700 text-white rounded hover:opacity-90 transition">
                        Enviar
                    </button>

                </div>

            </form>

        </div>

        <div class="p-4 form-list">
            <h2>Perguntas Frequentes</h2>
            <div class="">
                @foreach($faqs as $faq)
                    <div class="">
                        <input type="radio" name="faq-accordion"/>
                        <div class="dy-collapse-title font-semibold">{{$faq->sort_order}} – {{$faq->faq_title}}</div>
                        <div class="dy-collapse-content text-sm">
                            <p>{!! $faq->faq_content !!}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

    </div>
</x-frontend.app-layout>
