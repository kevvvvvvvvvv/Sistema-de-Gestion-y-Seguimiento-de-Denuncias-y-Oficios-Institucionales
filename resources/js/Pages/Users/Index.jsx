import AddButton from '@/Components/AddButton';
import MainLayout from '@/Layouts/MainLayout';
import { Head, Link } from '@inertiajs/react';
import {Trash2} from 'lucide-react';
import {SquarePen} from 'lucide-react';
import { useSweetDelete } from '@/Hooks/useSweetDelete';
import { router } from '@inertiajs/react';

const {confirm} = useSweetDelete();

export default function Index({ users, auth }) {
  return(
    <>
      <MainLayout auth={auth} topHeader="Consulta de usuarios" insideHeader={""}>
        <Head title="Usuarios" />
        <AddButton href={route('users.create')} />
        <div className="grid grid-cols-3 gap-4 mt-6">
          {users.map(user => (
            <div key={user.idUsuario} className="bg-blancoIMTA text-center justify-center-safe py-4 rounded-lg">
              <h2 className="font-bold">{user.nombre} {user.apPaterno} {user.apMaterno}</h2>
              <h3 className="text-sm text-cafeIMTA">{user.email}</h3>
              <div className="grid grid-cols-4 mt-4 mx-4 gap-4">
                <button 
                onClick={() => 
                  confirm(
                    { title: "¿Eliminar usuario?", text: "No podrás recuperarlo"},
                    () => router.delete(route("users.destroy", user.idUsuario))
                  )
                }
                className="bg-cafeIMTA col-span-1 col-start-2 flex justify-center items-center py-3 rounded-lg hover:bg-cafeIMTA/80 transition">
                  <Trash2 color="#F9F7F5" className="w-5 h-5" />
                </button>
                <button 
                onClick={() => 
                  router.get(route("users.edit", user.idUsuario))
                }
                className="bg-cafeIMTA flex justify-center items-center py-3 rounded-lg hover:bg-cafeIMTA/80 transition">
                  <SquarePen color="#F9F7F5" className="w-5 h-5" />
                </button>
              </div>
            </div>
          ))}
        </div>
      </MainLayout>
    </>
  )
}
