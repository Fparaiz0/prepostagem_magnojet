// Função para abrir o modal (remove "hidden" e adiciona classe fade-in)
function abrirModal() {
  const modal = document.getElementById("modalSelecionarDestinatario");
  modal.classList.remove("hidden");
  modal.classList.add("opacity-100");
}

// Função para fechar o modal (adiciona "hidden" e remove fade-in)
function fecharModal() {
  const modal = document.getElementById("modalSelecionarDestinatario");
  modal.classList.add("hidden");
  modal.classList.remove("opacity-100");
}

// Configura o botão fechar do modal
document
  .getElementById("fecharModalBtn")
  .addEventListener("click", fecharModal);

function buscarRemetente() {
  const cnpj = document.getElementById("cnpj_sender").value;
  const nome = document.getElementById("name_sender").value;

  if (!cnpj && !nome) {
    alert("Informe o nome do remetente.");
    return;
  }

  fetch(`/api/remetentes/buscar?cnpj=${cnpj}&nome=${nome}`)
    .then((response) => {
      if (!response.ok) throw new Error("Remetente não encontrado");
      return response.json();
    })
    .then((data) => {
      document.getElementById("name_sender").value = data.nome;
      document.getElementById("cnpj_sender").value = data.cnpj;
      document.getElementById("cep_sender").value = data.cep;
      document.getElementById("public_place_sender").value = data.logradouro;
      document.getElementById("number_sender").value = data.numero;
      document.getElementById("neighborhood_sender").value = data.bairro;
      document.getElementById("city_sender").value = data.cidade;
      document.getElementById("uf_sender").value = data.uf;
    })
    .catch((error) => alert(error.message));
}

function buscarDestinatario() {
  const cnpj = document.getElementById("cnpj_recipient").value;
  const nome = document.getElementById("name_recipient").value;

  if (!cnpj && !nome) {
    alert("Informe o nome ou CNPJ do destinatário.");
    return;
  }

  fetch(`/api/destinatarios/buscar?cnpj=${cnpj}&nome=${nome}`)
    .then((response) => {
      if (!response.ok) throw new Error("Destinatário não encontrado");
      return response.json();
    })
    .then((data) => {
      if (Array.isArray(data)) {
        mostrarListaDestinatarios(data);
      } else {
        preencherCamposDestinatario(data);
      }
    })
    .catch((error) => alert(error.message));
}

function preencherCamposDestinatario(data) {
  document.getElementById("name_recipient").value = data.name;
  document.getElementById("cnpj_recipient").value = data.cnpj;
  document.getElementById("cep_recipient").value = data.cep;
  document.getElementById("public_place_recipient").value = data.public_place;
  document.getElementById("number_recipient").value = data.number;
  document.getElementById("complement_recipient").value = data.complement;
  document.getElementById("neighborhood_recipient").value = data.neighborhood;
  document.getElementById("city_recipient").value = data.city;
  document.getElementById("uf_recipient").value = data.uf;
  fecharModal();
}

function mostrarListaDestinatarios(lista) {
  const container = document.getElementById("listaDestinatarios");
  container.innerHTML = "";

  lista.forEach((destinatario) => {
    const btn = document.createElement("button");
    btn.type = "button";
    btn.className = `
            w-full text-left p-4 mb-2 border rounded-lg shadow-sm
            hover:bg-gray-100 focus:outline-none cursor-pointer focus:ring-2 focus:ring-blue-500
            transition duration-150
        `;
    btn.innerHTML = `
            <p class="font-semibold text-gray-800">${destinatario.name}</p>
            <p class="text-sm text-gray-600">${destinatario.public_place}</p>
            <p class="text-sm text-gray-600">${destinatario.city}/${destinatario.uf}</p>
        `;
    btn.onclick = () => preencherCamposDestinatario(destinatario);
    container.appendChild(btn);
  });

  abrirModal();
}

function buscarEmbalagem() {
  const nome = document.getElementById("name").value;

  if (!nome) {
    alert("Informe a embalagem.");
    return;
  }

  fetch(`/api/embalagens/buscar?nome=${nome}`)
    .then((response) => {
      if (!response.ok) throw new Error("Embalagem não encontrada");
      return response.json();
    })
    .then((data) => {
      document.getElementById("name").value = data.nome;
      document.getElementById("height_informed").value = data.altura;
      document.getElementById("width_informed").value = data.largura;
      document.getElementById("length_informed").value = data.comprimento;
      document.getElementById("diameter_informed").value = data.diametro;
      document.getElementById("weight_informed").value = data.peso;
    })
    .catch((error) => alert(error.message));
}
