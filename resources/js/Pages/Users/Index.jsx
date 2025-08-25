import InnerBackground from "@/Components/Layout/InnerBackground";
import Sidebar from "@/Components/Layout/SideBar";
import Top from "@/Components/Layout/Top";
import { Head } from '@inertiajs/react';
import {Trash2} from 'lucide-react';
import {SquarePen} from 'lucide-react';

export default function Index({ users }) {
  return(
    
    <div className="flex">
      <Head title="Usuarios" />

      <Sidebar />
      
      <div className="flex-1">
        <Top>Consultar usuarios</Top>
        <InnerBackground>
          <div className="grid grid-cols-3 gap-4">
            {users.map(user => (
              <div key={user.idUsuario} className="bg-blancoIMTA text-center justify-center-safe py-4 rounded-lg">
                <h2 className="font-bold">{user.nombre} {user.apPaterno} {user.apMaterno}</h2>
                <h3 className="text-sm text-cafeIMTA">{user.email}</h3>
                <div className="grid grid-cols-4 mt-4 mx-4 gap-4">
                  <button className="bg-cafeIMTA col-span-1 col-start-2 flex justify-center items-center py-3 rounded-lg hover:bg-cafeIMTA/80 transition">
                    <Trash2 color="#F9F7F5" className="w-5 h-5" />
                  </button>
                  <button className="bg-cafeIMTA flex justify-center items-center py-3 rounded-lg hover:bg-cafeIMTA/80 transition">
                    <SquarePen color="#F9F7F5" className="w-5 h-5" />
                  </button>
                </div>
              </div>
            ))}
          </div>
        </InnerBackground>
      </div>
    </div>
  )
}
