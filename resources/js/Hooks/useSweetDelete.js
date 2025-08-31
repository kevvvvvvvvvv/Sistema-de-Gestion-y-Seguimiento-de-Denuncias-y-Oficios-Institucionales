import Swal from "sweetalert2";

export function useSweetDelete() {
  const confirm = async (options, callback) => {
    const result = await Swal.fire({
      title: options.title || "¿Estás seguro?",
      text: options.text || "Esta acción no se puede deshacer.",
      icon: options.icon || "warning",
      iconColor: "#9C8372",
      showCancelButton: true,
      confirmButtonColor: "#9C8372",
      cancelButtonColor: "#D9D9D9",
      confirmButtonText: options.confirmText || "Sí, continuar",
      cancelButtonText: options.cancelText || "Cancelar"
    });

    if (result.isConfirmed) {
      callback();
    }
  };

  return { confirm };
}
