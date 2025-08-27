import { Link } from "@inertiajs/react";
import {Plus} from "lucide-react";

export default function AddButton({ className, href }) {
  return (
    // <button
    //   type="button"
    //   onClick={onClick}
    //   className={`flex justify-self-end text-sm gap-2 mb-4 px-4 py-2 font-bold text-white bg-azulIMTA text-black rounded-xl hover:bg-azulIMTAHover hover:text-white transition items-center justify-center ${className}`}
    // >
    //   Agregar nuevo
    //   <Plus />
    // </button>
    
    <Link href={href} className="flex justify-self-end items-center justify-center gap-2 p-3 mb-8 rounded-xl text-sm font-semibold text-white bg-azulIMTA hover:bg-azulIMTAHover hover:text-white transition ${className}" >
      Agregar nuevo
      <Plus/>
    </Link>
  );
}
