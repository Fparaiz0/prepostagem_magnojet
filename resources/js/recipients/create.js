document.addEventListener("DOMContentLoaded", function () {
  const cepInput = document.getElementById("cep");
  const ufInput = document.getElementById("uf");
  const publicPlaceInput = document.getElementById("public_place");
  const neighborhoodInput = document.getElementById("neighborhood");
  const cityInput = document.getElementById("city");
  const complementInput = document.getElementById("complement");
  const cepLoading = document.getElementById("cep-loading");
  const cepError = document.getElementById("cep-error");

  cepInput.addEventListener("input", function (e) {
    let value = e.target.value.replace(/\D/g, "");
    if (value.length > 8) {
      value = value.substring(0, 8);
    }
    e.target.value = value;

    if (value.length === 8) {
      buscarCep(value);
    }
  });

  cepInput.addEventListener("blur", function (e) {
    let value = e.target.value.replace(/\D/g, "");
    if (value.length === 8) {
      buscarCep(value);
    }
  });

  function buscarCep(cep) {
    cepError.classList.add("hidden");
    cepLoading.classList.remove("hidden");

    fetch(`https://viacep.com.br/ws/${cep}/json/`)
      .then((response) => {
        if (!response.ok) {
          throw new Error("Erro na requisição");
        }
        return response.json();
      })
      .then((data) => {
        cepLoading.classList.add("hidden");

        if (data.erro) {
          cepError.classList.remove("hidden");
          cepError.textContent = "CEP não encontrado";
          limparCamposEndereco();
          return;
        }

        ufInput.value = data.uf || "";
        publicPlaceInput.value = data.logradouro || "";
        neighborhoodInput.value = data.bairro || "";
        cityInput.value = data.localidade || "";
        complementInput.value = data.complemento || "";

        document.getElementById("number").focus();
      })
      .catch((error) => {
        cepLoading.classList.add("hidden");
        cepError.classList.remove("hidden");
        cepError.textContent = "Erro ao buscar CEP. Tente novamente.";
        limparCamposEndereco();
        console.error("Erro ao buscar CEP:", error);
      });
  }

  function limparCamposEndereco() {
    ufInput.value = "";
    publicPlaceInput.value = "";
    neighborhoodInput.value = "";
    cityInput.value = "";
    complementInput.value = "";
  }
});
