import { Link } from "@inertiajs/react";
import {Plus} from "lucide-react";

export default function AddButton({ className, href }) {
  return (
    <Link href={href} 
    className="flex justify-self-end items-center justify-center gap-2 p-3 mb-8 
    rounded-xl text-sm font-semibold 
    text-white bg-azulIMTA hover:bg-azulIMTAHover
    hover:text-white transition 
    hover:-translate-y-1 hover:scale-110 cursor-pointer
    ${className}" >
      Agregar nuevo
      <Plus/>
    </Link>
  );
}
