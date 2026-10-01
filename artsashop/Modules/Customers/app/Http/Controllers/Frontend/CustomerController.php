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
namespace Modules\Customers\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Mail\ForgotPasswordMail;
use Carbon\Carbon;
use Idea\Framework\Repository\Customer\CustomerAddressRepository;
use Idea\Framework\Repository\Customer\CustomerEntityRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Modules\Customers\Http\Requests\EditCustomerAddressRequest;
use Modules\Customers\Http\Requests\EditCustomerRequest;
use Modules\Customers\Http\Requests\ForgotPasswordRequest;
use Modules\Customers\Http\Requests\LoginCustomerRequest;
use Modules\Customers\Http\Requests\RegisterCustomerRequest;
use Modules\Customers\Http\Requests\ResetPasswordRequest;
use Modules\Customers\Services\CheckoutCustomerService;
use Modules\Customers\Services\CustomerAuthService;

class CustomerController extends Controller
{

    public function __construct(
        protected CustomerAuthService     $authService,
        protected CheckoutCustomerService $checkoutCustomerService,
    )
    {
    }

    /**
     * Cria o cliente no banco de dados
     */
    public function createpost(RegisterCustomerRequest $request)
    {

        // Realiza as validações do cadastro do Cliente
        $validated = $request->validated();

        if ($validated) {

            // Registra o cliente e realiza o login
            $this->authService->registerAndLogin($validated);

            // Redireciona o cliente para a página do painel
            return redirect()->intended(route('account.index'));

        }

    }

    /**
     * Valida se o cliente existe pelo e-mail
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkEmail(Request $request): \Illuminate\Http\JsonResponse
    {

        // Valida o e-mail do cliente
        $request->validate([
            'email' => ['required', 'email']
        ]);

        $customer = CustomerEntityRepository::getData()
            ->where('customer_email', $request->email)
            ->first();

        return response()->json([
            'exists' => (bool)$customer
        ]);
    }

    /**
     * Action que realiza o POST para completar o cadastro do cliente
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function completeProfilePost(Request $request)
    {

        // Valida se o usuario preecheu corretamente o campo de CPF/CNPJ
        $request->validate([
            'vat_number' => 'required|cpf_ou_cnpj'
        ]);

        // Retorna os dados do usuario da sessão
        $customer = Auth::guard('customer')->user();

        // Atualiza o campo de CPF/CNPJ
        CustomerEntityRepository::getData()
            ->find($customer->customer_id)
            ->update([
                'vat_number' => $request->vat_number
            ]);

        // Redireciona para a pagina que o cliente estava
        return redirect()->intended(route('account.index'));

    }

    /**
     * Metodo que atualiza as informações do cliente
     * @param \Modules\Customers\Http\Requests\EditCustomerRequest $request
     * @return \Illuminate\Http\RedirectResponse|void
     */
    public function editPost(EditCustomerRequest $request)
    {

        // Valida se o cliente esta realmente autenticado
        if (Auth::guard('customer')->check()) {

            // Dados do Cliente
            $customer = Auth::guard('customer')->user();

            // Realiza as validações do cadastro do Cliente
            $validated = $request->validated();

            if ($validated) {

                if ($request->boolean('change_password')) {
                    $request->validate([
                        'password' => ['required', 'confirmed', 'min:6'],
                    ]);

                    $customer->password = bcrypt($request->password);
                }

                CustomerEntityRepository::getData()->find($customer->customer_id)
                    ->update($request->all());


                return redirect()->route('account.edit')
                    ->with('success', 'Seus dados foram atualizados com sucesso');

            }

        }

        // Redireciona para a página de login
        return redirect()->route('account.login')->withErrors([
            'Você precisa estar logado'
        ]);

    }

    /**
     * Salva as informações de endereço do cliente
     * @param \Modules\Customers\Http\Requests\EditCustomerAddressRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addressEditPost(EditCustomerAddressRequest $request)
    {

        // Valida se o cliente esta realmente autenticado
        if (Auth::guard('customer')->check()) {

            $customer = Auth::guard('customer')->user();

            // Realiza as validações do cadastro do Cliente
            $request->validated();

            // Retorna os atributos a serem enviados para atualizar o endereço
            $attributes = $request->all();

            // Se o endereço for padrao de cobrança, desativa os outros para cobrança
            if (isset($attributes['is_default_billing'])) {
                CustomerAddressRepository::disableAllBillingShipping($customer->customer_id);
            }

            // Se o endereço for padrao de entrega, desativa os outros para entrega
            if (isset($attributes['is_default_shipping'])) {
                CustomerAddressRepository::disableAllBillingShipping($customer->customer_id, 'shipping');
            }

            // Atualiza os dados do cliente
            CustomerAddressRepository::updateAddress($attributes);

            // Redireciona para a página de login
            return redirect()->route('account.addressedit', ['id' => $attributes['address_id']])
                ->with('success', 'Endereço atualizado com sucesso!');

        }

        // Redireciona para a página de login
        return redirect()->route('account.login')->withErrors([
            'Você precisa estar logado'
        ]);

    }

    /**
     * Salva as informações de endereço do cliente
     * @param \Modules\Customers\Http\Requests\EditCustomerAddressRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addressCreatePost(EditCustomerAddressRequest $request): \Illuminate\Http\RedirectResponse
    {

        // Valida se o cliente esta realmente autenticado
        if (Auth::guard('customer')->check()) {

            // Retorna os dados do cliente
            $customer = Auth::guard('customer')->user();

            // Realiza as validações do cadastro do Cliente
            $request->validated();

            // Retorna os atributos a serem enviados para atualizar o endereço
            $attributes = $request->all();

            // Se o endereço for padrao de cobrança, desativa os outros para cobrança
            if (isset($attributes['is_default_billing'])) {
                CustomerAddressRepository::disableAllBillingShipping($customer->customer_id);
                $types[] = 'billing';
            } else {
                $attributes['is_default_billing'] = 0;
            }

            // Se o endereço for padrao de entrega, desativa os outros para entrega
            if (isset($attributes['is_default_shipping'])) {
                CustomerAddressRepository::disableAllBillingShipping($customer->customer_id, 'shipping');
                $types[] = 'shipping';
            } else {
                $attributes['is_default_shipping'] = 0;
            }

            // Define o tipo de endereço sempre como billing
            $attributes['address_type'] = 'billing';

            CustomerAddressRepository::createAddress(
                customerId: $customer->customer_id,
                customerName: $customer->customer_name,
                attributes: $attributes
            );

            // Redireciona para a página de endereços
            return redirect()->route('account.address')
                ->with('success', 'Endereços criados com sucesso!');

        }

        // Redireciona para a página de login
        return redirect()->route('account.login')->withErrors([
            'Você precisa estar logado'
        ]);

    }

    /**
     * Realiza o login do cliente
     */
    public function loginPost(LoginCustomerRequest $request)
    {

        // Retorna os dados validados
        $credentials = $request->validated();

        if (!$this->authService->login(
            email: $credentials['customer_email'],
            password: $credentials['password']
        )) {
            return back()
                ->withErrors([
                    'customer_email' => 'E-mail ou senha inválidos.',
                ])
                ->withInput($request->only('customer_email'));
        }

        // ESSENCIAL
        $request->session()->regenerate();

        // Redireciona para a pagina dependendo da onde ele esteja
        return redirect()->intended(route('account.index'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function forgotpasswordPost(ForgotPasswordRequest $request)
    {

        // Retorna os dados validados
        $validated = $request->validated();

        $customer = CustomerEntityRepository::getData()
            ->where(
                column: 'customer_email',
                operator: '=',
                value: $validated['email_address']
            )
            ->first();

        if (!$customer)
            return back()
                ->withErrors(['Este e-mail não existe em nossa base de dados'])
                ->withInput();

        // Cria o Token para o reenvio de senha
        $token = Password::broker('customers')->createToken($customer);

        // Cria o LINK para ser enviado para o cliente por e-mail
        $link = route('account.resetPassword', [
            'token' => $token
        ]);

        // Envia para o e-mail do site
        Mail::to($customer->customer_email)->send(
            new ForgotPasswordMail(
                data: $customer,
                link: $link
            )
        );

        return redirect()
            ->back()
            ->with('success', 'Foi enviado para você um e-mail para poder alterar sua senha.');

    }

    public function resetPasswordPost(ResetPasswordRequest $request)
    {

        // Retorna os dados validados
        $validated = $request->validated();

        $isValidToken = $this->validateResetToken(
            $request->get('token')
        );

        if (!$isValidToken) {
            return back()->withErrors(['Token inválido ou expirado']);
        }

        $customer = CustomerEntityRepository::getData()
            ->where(
            column: 'customer_email',
            operator: '=',
            value: $isValidToken->email
        )->first();

        // Salva a senha do cliente
        $customer->customer_passwd = bcrypt($validated['password']);
        $customer->save();

        // Remove da tabela o email do cliente
        DB::table('sys_password_reset_tokens')
            ->where('email', '=', $isValidToken->email)
            ->delete();

        return redirect()
            ->route('account.login')
            ->with('success', 'Senha alterada com sucesso.');


    }

    /**
     * Action de logout do cliente
     */
    public function logout(): \Illuminate\Http\RedirectResponse
    {
        Auth::guard('customer')->logout();
        session()->invalidate();
        session()->regenerateToken();
        return redirect()->route('index.home');
    }

    private function validateResetToken(string $token)
    {
        $records = DB::table('sys_password_reset_tokens')->get();

        foreach ($records as $record) {

            if (Hash::check($token, $record->token)) {

                $created = Carbon::parse($record->created_at);

                if ($created->addMinutes(60)->isPast()) {
                    return null;
                }

                return $record;
            }
        }

        return null;
    }

}
