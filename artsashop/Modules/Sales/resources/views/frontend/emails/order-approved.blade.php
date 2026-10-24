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
                            <p>Obrigado por comprar na {{ config('app.name') }}.</p>
                        </td>
                    </tr>

                    {{-- GREETING --}}
                    <tr>
                        <td>
                            <h2 style="font-size:22px;">Seu Pedido foi Aprovado com Sucesso!!!</h2>
                        </td>
                    </tr>

                    {{-- ORDER INFO --}}
                    <tr>
                        <td>
                            <h2>
                                Pedido #{{ $orderData['incrementCode'] }}
                                <small>
                                    (realizado em {{ \Carbon\Carbon::parse($orderData['createdAt'])->format('d/m/Y H:i') }})
                                </small>
                            </h2>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <table width="100%">
                                <tr>
                                    <th align="left" width="50%" bgcolor="#EAEAEA">Endereço de Cobrança</th>
                                    <th align="left" width="50%" bgcolor="#EAEAEA">Pagamento</th>
                                </tr>
                                <tr>
                                    <td style="border:1px solid #EAEAEA;">
                                        {{ $orderData['billing']['street'] }}, {{ $orderData['billing']['number'] }}<br>
                                        {{ $orderData['billing']['neighborhood'] }}<br>
                                        {{ $orderData['billing']['city'] }} - {{ $orderData['billing']['region'] }}<br>
                                        CEP: {{ $orderData['billing']['postcode'] }}
                                    </td>

                                    <td style="border:1px solid #EAEAEA;">
                                        Método: {{ $orderData['payments']['description'] }}<br>
                                        Valor: R$ {{ number_format($orderData['payments']['amount'], 2, ',', '.') }}
                                    </td>
                                </tr>
                            </table>

                            <table width="100%">
                                <tr>
                                    <th align="left" width="50%" bgcolor="#EAEAEA">Endereço de Entrega</th>
                                </tr>
                                <tr>
                                    <td style="border:1px solid #EAEAEA;">
                                        {{ $orderData['shipping']['street'] }}, {{ $orderData['shipping']['number'] }}<br>
                                        {{ $orderData['shipping']['neighborhood'] }}<br>
                                        {{ $orderData['shipping']['city'] }} - {{ $orderData['shipping']['region'] }}<br>
                                        CEP: {{ $orderData['shipping']['postcode'] }}
                                    </td>
                                </tr>
                            </table>

                            <br>

                            {{-- ITEMS --}}
                            <table width="100%" cellpadding="5" cellspacing="0" border="1" style="border-collapse:collapse;">
                                <thead>
                                <tr>
                                    <th align="left">Produto</th>
                                    <th>Qtd</th>
                                    <th>Preço</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($orderData['itens'] as $item)
                                    <tr>
                                        <td>{{ $item['productName'] }}</td>
                                        <td align="center">{{ $item['qtyOrdered'] }}</td>
                                        <td align="right">
                                            R$ {{ number_format($item['salesPrice'], 2, ',', '.') }}
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

                            <br>

                            {{-- totais --}}
                            <table width="100%" cellpadding="5" cellspacing="0" border="1" style="border-collapse:collapse;">
                                <tbody>
                                <tr>
                                    <td style="text-align: right">Subtotal : R$ {{ number_format($orderData['totals']['subtotal'], 2, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <td style="text-align: right">Desconto: R$ {{ number_format($orderData['totals']['discount_total'], 2, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <td style="text-align: right">Frete: R$ {{ number_format($orderData['totals']['shipping_total'], 2, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <td style="text-align: right; font-size: 22px; color: #1e7ec8">Total do Pedido: R$ {{ number_format($orderData['totals']['grand_total'], 2, ',', '.') }}</td>
                                </tr>
                                </tbody>
                            </table>

                        </td>
                    </tr>

                    {{-- FOOTER --}}
                    <tr>
                        <td bgcolor="#EAEAEA" align="center">
                            <p>Obrigado pela sua compra,<br><strong>{{ $store['store_name'] }}</strong></p>
                            <p>Caso esteja com alguma dúvida, fale com nosso atendimento pelo WhatsApp</p><br/>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</div>
</body>
