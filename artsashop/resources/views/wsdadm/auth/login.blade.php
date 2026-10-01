<x-guest-layout>
    <div class="flex flex-col items-center justify-center">
        <div class="w-full max-w-xl p-6 space-y-8 sm:p-8 bg-white rounded-lg shadow dark:bg-gray-800">
            <form method="POST" class="mt-8 space-y-6" action="{{ route('wsdadmin.login') }}">
                @csrf
                <div>
                    <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">E-mail</label>
                    <input type="email" name="email" id="email"
                           class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                           placeholder="name@company.com" required>
                </div>
                <div>
                    <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Senha</label>
                    <input type="password" name="password" id="password"
                           placeholder="••••••••"
                           class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                           required>
                </div>
                <div class="flex items-start">
                    <div class="flex items-center h-5">
                        <input id="remember_me" aria-describedby="remember" name="remember" type="checkbox"
                               class="border-gray-300 rounded "
                               checked>
                    </div>
                    <div class="ml-3 text-sm">
                        <label for="remember" class="font-medium text-gray-900 dark:text-white">Permanecer Logado</label>
                    </div>
                    <a href="{{ route('password.request') }}" class="ml-auto text-sm text-primary-700 hover:underline dark:text-primary-500">Esqueceu sua senha?</a>
                </div>
                <button type="submit" class="w-full btn btn-sm btn-primary">
                    Entrar
                </button>

            </form>
        </div>
    </div>
</x-guest-layout>
