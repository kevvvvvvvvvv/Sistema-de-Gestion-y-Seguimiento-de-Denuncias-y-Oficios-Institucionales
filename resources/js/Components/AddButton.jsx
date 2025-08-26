import {Plus} from "lucide-react";

export default function AddButton({ className, onClick }) {
  return (
    <button
      type="button"
      onClick={onClick}
      className={`flex justify-self-end text-sm gap-2 mb-4 px-4 py-2 font-bold text-white bg-azulIMTA text-black rounded-xl hover:bg-azulIMTAHover hover:text-white transition items-center justify-center ${className}`}
    >
      Agregar nuevo
      <Plus />
    </button>
  );
}
