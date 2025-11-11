let selectedObjects = [];
let currentReciboId = null;
let allSelected = false;
let selectedPrintFormat = null;

window.openCancelModal = function (id, recipient, objectCode) {
  const form = document.getElementById("cancelForm");
  form.action = window.laravelRoutes.destroyPrepostagem.replace(":id", id);

  document.getElementById("modalRecipient").textContent = recipient;
  document.getElementById("modalObjectCode").textContent = objectCode;

  const modal = document.getElementById("cancelModal");
  const modalContent = document.getElementById("modalContent");

  modal.classList.remove("hidden");
  setTimeout(() => {
    modalContent.classList.remove("scale-95", "opacity-0");
    modalContent.classList.add("scale-100", "opacity-100");
  }, 50);
};

window.closeCancelModal = function () {
  const modal = document.getElementById("cancelModal");
  const modalContent = document.getElementById("modalContent");

  modalContent.classList.remove("scale-100", "opacity-100");
  modalContent.classList.add("scale-95", "opacity-0");

  setTimeout(() => {
    modal.classList.add("hidden");
  }, 200);
};

window.openPrintFormatModal = function () {
  const modal = document.getElementById("printFormatModal");
  const modalContent = document.getElementById("printFormatModalContent");

  selectedPrintFormat = null;
  document.querySelectorAll(".print-format-option").forEach((option) => {
    option.classList.remove("border-blue-500", "bg-blue-50");
    option.classList.add("border-gray-200");
  });

  const confirmBtn = document.getElementById("confirmPrintBtn");
  confirmBtn.classList.add("hidden");
  confirmBtn.textContent = "Imprimir Todas";
  confirmBtn.onclick = confirmPrintAll;

  modal.classList.remove("hidden");
  setTimeout(() => {
    modalContent.classList.remove("scale-95", "opacity-0");
    modalContent.classList.add("scale-100", "opacity-100");
  }, 50);
};

function openPrintFormatModalForSelected() {
  const modal = document.getElementById("printFormatModal");
  const modalContent = document.getElementById("printFormatModalContent");

  selectedPrintFormat = null;
  document.querySelectorAll(".print-format-option").forEach((option) => {
    option.classList.remove("border-blue-500", "bg-blue-50");
    option.classList.add("border-gray-200");
  });

  const confirmBtn = document.getElementById("confirmPrintBtn");
  confirmBtn.classList.add("hidden");
  confirmBtn.textContent = "Imprimir Selecionados";
  confirmBtn.onclick = confirmPrintSelected;

  modal.classList.remove("hidden");
  setTimeout(() => {
    modalContent.classList.remove("scale-95", "opacity-0");
    modalContent.classList.add("scale-100", "opacity-100");
  }, 50);
}

window.closePrintFormatModal = function () {
  const modal = document.getElementById("printFormatModal");
  const modalContent = document.getElementById("printFormatModalContent");

  modalContent.classList.remove("scale-100", "opacity-100");
  modalContent.classList.add("scale-95", "opacity-0");

  setTimeout(() => {
    modal.classList.add("hidden");
  }, 200);
};

window.selectPrintFormat = function (format) {
  selectedPrintFormat = format;

  document.querySelectorAll(".print-format-option").forEach((option) => {
    if (option.getAttribute("data-format") === format) {
      option.classList.add("border-blue-500", "bg-blue-50");
      option.classList.remove("border-gray-200");
    } else {
      option.classList.remove("border-blue-500", "bg-blue-50");
      option.classList.add("border-gray-200");
    }
  });

  document.getElementById("confirmPrintBtn").classList.remove("hidden");
};

window.confirmPrintAll = function () {
  if (!selectedPrintFormat) {
    alert("Por favor, selecione um formato de impressão.");
    return;
  }

  closePrintFormatModal();
  printAllPrepostagens(selectedPrintFormat);
};

function confirmPrintSelected() {
  if (!selectedPrintFormat) {
    alert("Por favor, selecione um formato de impressão.");
    return;
  }

  closePrintFormatModal();

  const objectCodes = selectedObjects.map((obj) => obj.code);

  sendToCorreiosAPI(objectCodes, selectedPrintFormat);
}

function toggleLoadingModal(show) {
  const modal = document.getElementById("loadingModal");
  if (show) {
    modal.classList.remove("hidden");
  } else {
    modal.classList.add("hidden");
  }
}

function showLoadingError(message) {
  const errorElement = document.getElementById("loadingError");
  errorElement.textContent = message;
  errorElement.classList.remove("hidden");

  const spinner = document.querySelector("#loadingModal .animate-spin");
  if (spinner) {
    spinner.classList.remove("animate-spin");
    spinner.innerHTML = `
            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
        `;
  }
}

async function sendToCorreiosAPI(objectCodes, formato = "etiqueta") {
  if (!objectCodes || objectCodes.length === 0) {
    alert("Nenhum código de objeto selecionado para impressão.");
    return;
  }

  toggleLoadingModal(true);

  try {
    const apiUrl = window.laravelRoutes.imprimirSelecionados;

    const requestData = {
      codigosObjeto: objectCodes,
      formato: formato,
    };

    const response = await fetch(apiUrl, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        "X-CSRF-TOKEN": window.csrfToken,
        Accept: "application/json, application/pdf",
      },
      body: JSON.stringify(requestData),
    });

    const contentType = response.headers.get("content-type");

    if (contentType && contentType.includes("application/pdf")) {
      const blob = await response.blob();

      const url = window.URL.createObjectURL(blob);

      window.open(url, "_blank");

      setTimeout(() => window.URL.revokeObjectURL(url), 100);

      selectedObjects = [];
      document.querySelectorAll(".object-checkbox").forEach((checkbox) => {
        checkbox.checked = false;
      });
      document.getElementById("printSelectedBtn").classList.add("hidden");

      toggleLoadingModal(false);
      return;
    }

    const data = await response.json();

    if (!response.ok) {
      if (response.status === 202 && data.idRecibo) {
        currentReciboId = data.idRecibo;
        if (
          confirm(
            "As etiquetas estão sendo processadas. Deseja tentar baixar novamente em alguns segundos?",
          )
        ) {
          setTimeout(tryDownloadPDFAgain, 5000);
        }
      } else {
        throw new Error(
          data.message || data.error || `Erro: ${response.status}`,
        );
      }
      return;
    }

    throw new Error("Resposta inesperada da API");
  } catch (error) {
    console.error("Erro ao enviar para API dos Correios:", error);
    alert("Erro ao processar as etiquetas: " + error.message);
  } finally {
    toggleLoadingModal(false);
  }
}

async function printAllPrepostagens(formato = "etiqueta") {
  toggleLoadingModal(true);

  try {
    const apiUrl = window.laravelRoutes.imprimirTodas;

    const response = await fetch(apiUrl, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        "X-CSRF-TOKEN": window.csrfToken,
        Accept: "application/json, application/pdf",
      },
      body: JSON.stringify({
        formato: formato,
      }),
    });

    const contentType = response.headers.get("content-type");
    if (contentType && contentType.includes("application/pdf")) {
      const blob = await response.blob();

      const url = window.URL.createObjectURL(blob);

      window.open(url, "_blank");

      setTimeout(() => window.URL.revokeObjectURL(url), 100);

      toggleLoadingModal(false);
      return;
    }

    const data = await response.json();

    if (!response.ok) {
      if (response.status === 202 && data.idRecibo) {
        currentReciboId = data.idRecibo;
        if (
          confirm(
            "As etiquetas estão sendo processadas. Deseja tentar baixar novamente em alguns segundos?",
          )
        ) {
          setTimeout(tryDownloadPDFAgain, 5000);
        }
      } else if (response.status === 404) {
        alert(
          data.message || "Nenhuma pré-postagem encontrada para impressão.",
        );
      } else {
        throw new Error(
          data.message || data.error || `Erro: ${response.status}`,
        );
      }
      return;
    }

    throw new Error("Resposta inesperada da API");
  } catch (error) {
    console.error("Erro ao imprimir todas as pré-postagens:", error);
    alert("Erro ao processar as etiquetas: " + error.message);
  } finally {
    toggleLoadingModal(false);
  }
}

async function tryDownloadPDFAgain() {
  if (!currentReciboId) return;

  toggleLoadingModal(true);

  try {
    const response = await fetch(
      "/prepostagens/baixar-pdf/" + currentReciboId,
      {
        method: "GET",
        headers: {
          Accept: "application/pdf",
        },
      },
    );

    const contentType = response.headers.get("content-type");
    if (contentType && contentType.includes("application/pdf")) {
      const blob = await response.blob();
      const url = window.URL.createObjectURL(blob);
      window.open(url, "_blank");
      setTimeout(() => window.URL.revokeObjectURL(url), 100);
      currentReciboId = null;
    } else {
      const data = await response.json();
      if (response.status === 202) {
        alert(
          "PDF ainda está sendo processado. Tente novamente em alguns instantes.",
        );
      } else {
        throw new Error(data.message || "Erro ao baixar PDF");
      }
    }
  } catch (error) {
    console.error("Erro ao tentar baixar PDF:", error);
    alert("Erro: " + error.message);
  } finally {
    toggleLoadingModal(false);
  }
}

function checkInitialSelectionState() {
  const checkboxes = document.querySelectorAll(
    ".object-checkbox:not(:disabled)",
  );
  const anySelected = Array.from(checkboxes).some(
    (checkbox) => checkbox.checked,
  );
  const allChecked = Array.from(checkboxes).every(
    (checkbox) => checkbox.checked,
  );
  const printAllBtn = document.getElementById("printAllBtn");
  const printSelectedBtn = document.getElementById("printSelectedBtn");
  const selectAllBtn = document.getElementById("selectAllBtn");

  if (allChecked && checkboxes.length > 0) {
    allSelected = true;
    if (selectAllBtn) {
      selectAllBtn.innerHTML = `
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    Desmarcar Todas`;
    }
    if (printAllBtn) printAllBtn.classList.add("hidden");
  }

  if (anySelected && !allChecked && printAllBtn) {
    printAllBtn.classList.remove("hidden");
  }

  if (anySelected && printSelectedBtn) {
    printSelectedBtn.classList.remove("hidden");
  }
}

document.addEventListener("DOMContentLoaded", function () {
  const checkboxes = document.querySelectorAll(".object-checkbox");
  const printSelectedBtn = document.getElementById("printSelectedBtn");
  const printAllBtn = document.getElementById("printAllBtn");
  const selectAllBtn = document.getElementById("selectAllBtn");

  const apiToken = "{{ $apiToken }}";

  if (!apiToken) {
    console.warn(
      "Token de API não encontrado. Os botões de impressão não estarão disponíveis.",
    );
    if (printSelectedBtn) printSelectedBtn.style.display = "none";
    if (printAllBtn) printAllBtn.style.display = "none";
    if (selectAllBtn) selectAllBtn.style.display = "none";
    return;
  }

  checkboxes.forEach((checkbox) => {
    checkbox.addEventListener("change", function () {
      const objectCode = this.getAttribute("data-object-code");
      const recipient = this.getAttribute("data-recipient");

      if (this.checked) {
        selectedObjects.push({
          code: objectCode,
          recipient: recipient,
        });
      } else {
        selectedObjects = selectedObjects.filter(
          (obj) => obj.code !== objectCode,
        );
        allSelected = false;
        if (selectAllBtn) {
          selectAllBtn.innerHTML = `
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                            Selecionar Todas`;
        }
      }

      if (selectedObjects.length > 0) {
        printSelectedBtn.classList.remove("hidden");
        printSelectedBtn.innerHTML = `
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m4 4h6a2 2 0 002-2v-4a2 2 0 00-2-2h-6a2 2 0 00-2 2v4a2 2 0 002 2z" />
        </svg>
        Imprimir Selecionados (${selectedObjects.length})
    `;

        if (printAllBtn) printAllBtn.classList.add("hidden");
      } else {
        printSelectedBtn.classList.add("hidden");
        if (printAllBtn) printAllBtn.classList.remove("hidden");
      }

      const allCheckboxes = document.querySelectorAll(
        ".object-checkbox:not(:disabled)",
      );
      const allChecked = Array.from(allCheckboxes).every(
        (checkbox) => checkbox.checked,
      );

      if (allChecked && allCheckboxes.length > 0) {
        allSelected = true;
        if (selectAllBtn) {
          selectAllBtn.innerHTML = `
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Desmarcar Todas`;
        }
        if (printAllBtn) printAllBtn.classList.add("hidden");
      }
    });
  });

  if (selectAllBtn) {
    selectAllBtn.addEventListener("click", function () {
      const checkboxes = document.querySelectorAll(
        ".object-checkbox:not(:disabled)",
      );

      allSelected = !allSelected;

      selectedObjects = [];

      checkboxes.forEach((checkbox) => {
        checkbox.checked = allSelected;

        if (allSelected) {
          selectedObjects.push({
            code: checkbox.getAttribute("data-object-code"),
            recipient: checkbox.getAttribute("data-recipient"),
          });
        }
      });

      selectAllBtn.innerHTML = allSelected
        ? `<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
         </svg>
         Desmarcar Todas`
        : `<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
         </svg>
         Selecionar Todas`;

      if (allSelected) {
        if (printAllBtn) printAllBtn.classList.add("hidden");
        if (printSelectedBtn) {
          printSelectedBtn.classList.remove("hidden");
          printSelectedBtn.innerHTML = `
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m4 4h6a2 2 0 002-2v-4a2 2 0 00-2-2h-6a2 2 0 00-2 2v4a2 2 0 002 2z" />
                </svg>
                Imprimir Selecionados (${selectedObjects.length})
            `;
        }
      } else {
        if (printAllBtn) printAllBtn.classList.remove("hidden");
        if (printSelectedBtn) printSelectedBtn.classList.add("hidden");
      }
    });
  }

  if (printSelectedBtn) {
    printSelectedBtn.addEventListener("click", function () {
      if (!apiToken) {
        alert(
          "Token de autenticação não configurado. Entre em contato com o administrador.",
        );
        return;
      }

      if (selectedObjects.length === 0) {
        alert("Nenhuma pré-postagem selecionada para impressão.");
        return;
      }

      openPrintFormatModalForSelected();
    });
  }

  if (printAllBtn) {
    printAllBtn.addEventListener("click", function () {
      if (!apiToken) {
        alert(
          "Token de autenticação não configurado. Entre em contato com o administrador.",
        );
        return;
      }

      openPrintFormatModal();
    });
  }

  checkInitialSelectionState();
});
