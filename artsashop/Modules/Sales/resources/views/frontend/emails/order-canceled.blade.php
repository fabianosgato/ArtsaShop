<body style="background:#ffffff; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px; margin:0; padding:0;">
<div style="background:#ffffff; margin:0; padding:0;">
    <table width="100%">
        <tr>
            <td align="center" style="padding:20px 0;">
                <table bgcolor="#FFFFFF" cellpadding="10" width="650" style="border:1px solid #E0E0E0;">

                    {{-- HEADER --}}
                    <tr>
                        <td>
                            <a href="{{ config('app.url') }}">
                                <img src="{{ asset('images/frontend/logo.png') }}" alt="{{ $store['store_name'] }}" />
                            </a>
                        </td>
                    </tr>

                    {{-- GREETING --}}
                    <tr>
                        <td>
                            <h1 style="font-size:22px;">Olá, {{ $orderData['customer']['customerName'] }}</h1>
                            <p>Ops! Não conseguimos processar seu pedido.</p>
                            <br/>
                            <hr>
                            <br/>
                            <h2>Isso pode acontecer por diversas razões — mas não se preocupe, estamos aqui para ajudar!</h2>
                            <p>Fale com nosso atendimento pelo WhatsApp</p><br/>
                        </td>
                    </tr>

                    {{-- FOOTER --}}
                    <tr>
                        <td bgcolor="#EAEAEA" align="center">
                            Obrigado,<br><strong>{{ $store['store_name'] }}</strong>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</div>
</body>
