function buscarRemetente() {
    const cnpj = document.getElementById('cnpj_sender').value;
    const nome = document.getElementById('name_sender').value;

    if (!cnpj && !nome) {
        alert('Informe o nome do remetente.');
        return;
    }

    fetch(`/api/remetentes/buscar?cnpj=${cnpj}&nome=${nome}`)
        .then(response => {
            if (!response.ok) throw new Error('Remetente não encontrado');
            return response.json();
        })
        .then(data => {
            document.getElementById('name_sender').value = data.nome;
            document.getElementById('cnpj_sender').value = data.cnpj;
            document.getElementById('cep_sender').value = data.cep;
            document.getElementById('public_place_sender').value = data.logradouro;
            document.getElementById('number_sender').value = data.numero;
            document.getElementById('neighborhood_sender').value = data.bairro;
            document.getElementById('city_sender').value = data.cidade;
            document.getElementById('uf_sender').value = data.uf;
        })
        .catch(error => alert(error.message));
}

function buscarDestinatario() {
    const cnpj = document.getElementById('cnpj_recipient').value;
    const nome = document.getElementById('name_recipient').value;

    if (!cnpj && !nome) {
        alert('Informe o nome do destinatário.');
        return;
    }

    fetch(`/api/destinatarios/buscar?cnpj=${cnpj}&nome=${nome}`)
        .then(response => {
            if (!response.ok) throw new Error('Destinatário não encontrado');
            return response.json();
        })
        .then(data => {
            document.getElementById('name_recipient').value = data.nome;
            document.getElementById('cnpj_recipient').value = data.cnpj;
            document.getElementById('cep_recipient').value = data.cep;
            document.getElementById('public_place_recipient').value = data.logradouro;
            document.getElementById('number_recipient').value = data.numero;
            document.getElementById('neighborhood_recipient').value = data.bairro;
            document.getElementById('city_recipient').value = data.cidade;
            document.getElementById('uf_recipient').value = data.uf;
        })
        .catch(error => alert(error.message));
}

function buscarEmbalagem() {
    const nome = document.getElementById('name').value;

    if (!nome) {
        alert('Informe a embalagem.');
        return;
    }

    fetch(`/api/embalagens/buscar?nome=${nome}`)
        .then(response => {
            if (!response.ok) throw new Error('Embalagem não encontrada');
            return response.json();
        })
        .then(data => {
            document.getElementById('name').value = data.nome;
            document.getElementById('height_informed').value = data.altura;
            document.getElementById('width_informed').value = data.largura;
            document.getElementById('length_informed').value = data.comprimento;
            document.getElementById('diameter_informed').value = data.diametro;
            document.getElementById('weight_informed').value = data.peso;
        })
        .catch(error => alert(error.message));
}
    