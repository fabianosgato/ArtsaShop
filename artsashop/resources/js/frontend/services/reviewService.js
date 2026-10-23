const url = 'http://artsashop.localhost/'

async function authorize() {

    let resultApi = await fetch(url + 'api/auth/login', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json', // OBRIGATÓRIO para o Laravel ler o body
            'Accept': 'application/json'        // Diz ao Laravel para responder em JSON
        },
        body: JSON.stringify({
            "device_name": "application/react"
        })
    });

    // Se o Laravel rejeitar (ex: erro 422 de validação)
    if (!resultApi.ok) {
        try {
            let errorData = await resultApi.json();
            console.log("Erro detalhado da API:", errorData);

            // Se houver erros de validação do Laravel, mostra o primeiro deles
            if (errorData.errors) {
                let primeiroErro = Object.values(errorData.errors)[0][0];
                throw new Error(`Erro de Validação: ${primeiroErro}`);
            }

            throw new Error(errorData.message || 'Falha na autenticação');
        } catch (e) {
            // Se o erro acima for o nosso "Erro de Validação", repassa ele
            if (e.message.includes('Erro de Validação')) throw e;
            throw new Error(`Falha na autenticação. Status HTTP: ${resultApi.status}`);
        }
    }

    // Se chegou aqui, o status é 200 (Sucesso)
    let data = await resultApi.json();

    // O Laravel por padrão no Sanctum/Passport retorna o token direto ou em data.token
    return data.token || (data.data && data.data.token);

}


async function retrieveData(uri) {
    let token = await authorize();

    if (token) {

        let resp = await fetch(url+uri, {
            headers: {
                'Accept': 'application/json',
                'Authorization': 'Bearer ' + token
            }
        });

        // Retorna o json para quem chamou esta função
        return await resp.json();

    }

    // Caso não tenha token, você pode retornar null ou lançar um erro
    return null;
}

async function getReviews() {
    try {
        // Como retrieveData é async, usamos o 'await' aqui também!
        return await retrieveData(
            'api/v1/reviews?entity=product&entityIdValue=14182&perPage=1'
        )

        // Agora você pode usar a variável 'dadosDasReviews' livremente no seu código
    } catch (erro) {
        console.error("Ocorreu um erro no fluxo:", erro);
    }
}

