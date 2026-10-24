import {useState} from 'react';

export default function HeaderTop() {
    const [open, setOpen] = useState(false);

    return (
        <>
        <div id="top_header">
            <div className="container">
                <div className="md:px-2">
                    <ul className="links topheader-mobile-trigger">
                        <li class="wellcome">Seja Bem-vindo</li>
                        <li><a href="{route('account.login')}">Entre / Registre-se</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="topheader-right">
            <ul class="links">
                <li class="link"><a href="{route('index.home')}">Home</a></li>
                <li class="link"><a href="">Quem Somos</a></li>
                <li class="contact-us-now"><a href="">Fale Conosco</a></li>
            </ul>
        </div>
        </>);
}
