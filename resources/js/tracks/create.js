function updatePreview(value) {
  const previewSection = document.getElementById("previewSection");
  const previewAmount = document.getElementById("previewAmount");
  const submitButton = document.getElementById("submitButton");

  if (value && value >= 500) {
    previewAmount.textContent = parseInt(value).toLocaleString("pt-BR");
    previewSection.classList.remove("hidden");
    submitButton.disabled = false;
  } else {
    previewSection.classList.add("hidden");
    submitButton.disabled = true;
  }
}

document.addEventListener("DOMContentLoaded", function () {
  const amountInput = document.getElementById("amount");
  if (amountInput.value) {
    updatePreview(amountInput.value);
  }
});
