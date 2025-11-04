document.addEventListener("DOMContentLoaded", function () {
  let selectedId = null;
  const modal = document.getElementById("invoiceModal");
  const modalContent = document.getElementById("modalContent");
  const input = document.getElementById("invoiceInput");

  function openModal() {
    modal.classList.remove("hidden");
    modal.classList.add("flex");
    setTimeout(() => {
      modalContent.classList.remove("scale-95", "opacity-0");
      modalContent.classList.add("scale-100", "opacity-100");
    }, 50);
    input.focus();
  }

  function closeModal() {
    modalContent.classList.remove("scale-100", "opacity-100");
    modalContent.classList.add("scale-95", "opacity-0");
    setTimeout(() => {
      modal.classList.add("hidden");
      modal.classList.remove("flex");
    }, 300);
  }

  document.querySelectorAll(".track-code").forEach(function (el) {
    el.addEventListener("click", function () {
      const id = el.getAttribute("data-id");

      if (el.classList.contains("text-blue-800")) {
        selectedId = id;
        input.value = "";
        openModal();
      } else {
        if (confirm("Tem certeza que deseja remover a NF desta etiqueta?")) {
          toggleInvoice(id, null, el);
        }
      }
    });
  });

  document
    .getElementById("cancelInvoice")
    .addEventListener("click", closeModal);

  document.getElementById("saveInvoice").addEventListener("click", function () {
    const invoice = input.value.trim();
    if (!invoice) {
      alert("Digite a nota fiscal.");
      return;
    }

    const el = document.querySelector(`.track-code[data-id='${selectedId}']`);
    toggleInvoice(selectedId, invoice, el);
    closeModal();
  });

  document.addEventListener("keydown", function (e) {
    if (e.key === "Escape") {
      closeModal();
    }
  });

  function toggleInvoice(id, invoice, el) {
    fetch(`/range/${id}/toggle-invoice`, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        "X-CSRF-TOKEN": document
          .querySelector('meta[name="csrf-token"]')
          .getAttribute("content"),
      },
      body: JSON.stringify({
        invoice: invoice,
      }),
    })
      .then((res) => res.json())
      .then((response) => {
        if (response.success) {
          if (response.data.selected === 1) {
            el.classList.remove(
              "text-blue-800",
              "bg-blue-50",
              "border-blue-200",
              "hover:bg-blue-100",
              "hover:border-blue-300",
            );
            el.classList.add(
              "text-red-800",
              "bg-red-50",
              "border-red-200",
              "hover:bg-red-100",
              "hover:border-red-300",
            );

            if (invoice) {
              el.innerHTML = `
                                        <div class="text-center font-semibold tracking-wide">${response.data.object_code}</div>
                                        <div class="text-xs text-gray-600 mt-2 p-1 bg-white rounded border text-center">NF: ${invoice}</div>
                                        <div class="absolute bottom-1 right-1"><div class="w-2 h-2 bg-red-500 rounded-full"></div></div>
                                    `;
            }
          } else {
            el.classList.remove(
              "text-red-800",
              "bg-red-50",
              "border-red-200",
              "hover:bg-red-100",
              "hover:border-red-300",
            );
            el.classList.add(
              "text-blue-800",
              "bg-blue-50",
              "border-blue-200",
              "hover:bg-blue-100",
              "hover:border-blue-300",
            );

            el.innerHTML = `
                                    <div class="text-center font-semibold tracking-wide">${response.data.object_code}</div>
                                    <div class="text-xs text-gray-400 mt-2 text-center">Disponível</div>
                                    <div class="absolute bottom-1 right-1"><div class="w-2 h-2 bg-green-500 rounded-full"></div></div>
                                `;
          }
        } else {
          alert(response.message || "Erro ao atualizar.");
        }
      })
      .catch(() => alert("Erro de comunicação com o servidor."));
  }
});
