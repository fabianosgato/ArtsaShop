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

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContactsRequest;
use App\Mail\ContactMail;
use Idea\Framework\Repository\Cms\CmsFaqRepository;
use Idea\Framework\Seo\Contracts\SeoStaticPage;
use Idea\Framework\Seo\Traits\HasSeoResponse;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

class ContactsController extends Controller
{

    use HasSeoResponse;

    public function index()
    {
        // Meta tags da página
        $this->getSeoMetaTags(
            new SeoStaticPage(
                code: 'customer',
                title: 'Fale Conosco'
            )
        );

        return view('frontend.page.contacts', [
            'faqs' => CmsFaqRepository::getData()->orderBy('sort_order')->get()
        ]);
    }

    public function sendPost(ContactsRequest $request)
    {

        // Realiza as validações do cadastro do Cliente
        $validated = $request->validated();

        // Response
        $response = Http::asForm()->post(
            'https://www.google.com/recaptcha/api/siteverify',
            [
                'secret' => config('services.recaptcha.secret_key'),
                'response' => $request->input('g-recaptcha-response'),
                'remoteip' => $request->ip(),
            ]
        );

        $recaptcha = $response->json();

        if (!$recaptcha['success']) {
            return back()
                ->withErrors(['captcha' => 'Falha na verificação do reCAPTCHA.'])
                ->withInput();
        }

        // Envia para o e-mail do site
        Mail::to('fabianogattoti@gmail.com')->send(
            new ContactMail($validated)
        );

        return redirect()
            ->back()
            ->with('success', 'Sua mensagem foi enviada com sucesso. Em breve entraremos em contato.');

    }

}
