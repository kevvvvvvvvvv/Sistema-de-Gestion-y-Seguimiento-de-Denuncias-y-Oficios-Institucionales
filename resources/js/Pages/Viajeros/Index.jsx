import AddButton from '@/Components/AddButton';
import MainLayout from '@/Layouts/MainLayout';
import { Head } from '@inertiajs/react';
import { router } from '@inertiajs/react';
import { useEffect } from 'react';
import { useSweetDelete } from '@/Hooks/useSweetDelete';
import Swal from 'sweetalert2';


import DataTable from 'datatables.net-react';
import DT from 'datatables.net-dt'; 
import 'datatables.net-dt/css/dataTables.dataTables.css';

import Buttons from 'datatables.net-buttons-dt'; 
import 'datatables.net-buttons/js/buttons.html5.mjs';
import 'datatables.net-buttons-dt/css/buttons.dataTables.css';

import JSZip from 'jszip';
window.JSZip = JSZip;

DataTable.use(DT);
DataTable.use(Buttons);

const { confirm } = useSweetDelete();

export default function Index({ viajeros, auth }) {

  // Definir estructura de columnas
  const columns = [
    { title: "ID", data: "folio"},
    { title: "Número de Oficio", data: "numOficio" },
    { title: "Fecha de Creación", data: "oficio.fechaCreacion" },
    { title: "Fecha de Llegada", data: "oficio.fechaLlegada" },
    { title: "Asunto", data: "asunto" },
    { title: "Instrucción", data: "instruccion" },
    { title: "Resultado", data: "resultado" },
    { title: "Fecha de Entrega", data: "fechaEntrega" },
    { title: "Destino final", data: "usuario.nombre" },
    {
      title: "Operaciones",
      orderable: false,
      render: (data, type, row) => `
      <div class="flex gap-2 justify-center items-center">
        
        <button class="edit-btn" data-id="${row.folio}">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" 
            fill="none" stroke="currentColor" stroke-width="2" 
            stroke-linecap="round" stroke-linejoin="round">
            <path d="M12 20h9"></path>
            <path d="M16.5 3.5a2.121 2.121 0 1 1 3 3L7 19l-4 1 1-4 12.5-12.5z"></path>
          </svg>
        </button>
    
        <button class="delete-btn" data-id="${row.folio}">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" 
            fill="none" stroke="red" stroke-width="2" 
            stroke-linecap="round" stroke-linejoin="round">
            <polyline points="3 6 5 6 21 6"></polyline>
            <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"></path>
            <path d="M10 11v6"></path>
            <path d="M14 11v6"></path>
          </svg>
        </button>
    
        <div class="relative inline-block text-left group">
          
          <button class="p-1 rounded-full hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="currentColor">
              <path d="M10 6a2 2 0 1 1 0-4 2 2 0 0 1 0 4zm0 6a2 2 0 1 1 0-4 2 2 0 0 1 0 4zm0 6a2 2 0 1 1 0-4 2 2 0 0 1 0 4z" />
            </svg>
          </button>

          <div class="absolute right-0 z-10 w-48 mt-2 origin-top-right bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none hidden group-hover:block group-focus-within:block"
               role="menu" aria-orientation="vertical" tabindex="-1">
            <div class="py-1" role="none">
              
              ${row.url ? `
                <a href="${row.url}" target="_blank" 
                   class="text-gray-700 block px-4 py-2 text-sm hover:bg-gray-100" 
                   role="menuitem" tabindex="-1">
                  Visualizar
                </a>
              ` : ''}
              
              <button 
                 class="pdf-btn text-gray-700 block w-full text-left px-4 py-2 text-sm hover:bg-gray-100" 
                 role="menuitem" tabindex="-1" data-id="${row.folio}">
                Descargar PDF
              </button>

            </div>
          </div>
        </div>
        </div>
    `
    }
  ];

  useEffect(() => {
    const handleClick = (e) => {
      const editBtn = e.target.closest(".edit-btn");
      const deleteBtn = e.target.closest(".delete-btn");
      const pdfBtn = e.target.closest(".pdf-btn"); 
      if (editBtn) {
        const id = editBtn.dataset.id;
        router.visit(route("viajeros.edit", id));
      }

      if (deleteBtn) {
        const id = deleteBtn.dataset.id;
        confirm(
          {
            title: "¿Eliminar viajero?",
            text: "No podrás deshacer esta acción",
            confirmText: "Sí, eliminar",
          },
          () => {
            router.delete(route("viajeros.destroy", id), {
              onSuccess: () => {
                router.reload({ only: ["viajeros"] });
                Swal.fire({
                  toast: true,             
                  position: 'top-end',     
                  icon: 'success',         
                  title: 'Eliminación realizada correctamente',
                  showConfirmButton: false, 
                  timer: 4000,             
                  timerProgressBar: true,  
              });
              },
            });
          }
        );
      }

      if (pdfBtn) {
        const id = pdfBtn.dataset.id;

        window.open(route("viajeros.pdf", id), "_blank");
      }
    };

    document.addEventListener("click", handleClick);
    return () => document.removeEventListener("click", handleClick);
  }, []);

  return (
    <MainLayout auth={auth} topHeader="Consulta de Viajeros" insideHeader="" backURL={route('viajeros.dashboard')}>
      <Head title="Viajeros" />
      {auth.permissions.includes("crear viajeros") && (
      <AddButton href={route('viajeros.create')} />
      )}

      <DataTable 
        data={viajeros}
        className="display"
        options={{
          scrollX: true, 
          dom: '<"dt-toolbar flex justify-between items-center mb-4"fB>rt<"dt-footer flex justify-between items-center mt-4 text-xs"lip>', 
          buttons: [
            {
              extend: 'excelHtml5',
              text: 'Exportar a Excel',
              titleAttr: 'Excel',
              className: 'bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded-lg shadow !important'
            }
          ],
          language: {
            search: "Buscar:",
            lengthMenu: "Mostrar _MENU_ registros por página",
            info: "Mostrando _START_ a _END_ de _TOTAL_ registros",
            infoEmpty: "No hay registros disponibles",
            infoFiltered: "(filtrado de _MAX_ registros en total)",
            zeroRecords: "No se encontraron resultados",
          },
          columns
        }}
      >
        <thead>
          <tr>
            <th>ID</th>
            <th>Número de Oficio</th>
            <th>Fecha de Creación</th>
            <th>Fecha de Llegada</th>
            <th>Asunto</th>
            <th>Instrucción</th>
            <th>Resultado</th>
            <th>Fecha de Entrega</th>
            <th>Usuario</th>
            <th>Operaciones</th>
          </tr>
        </thead>
      </DataTable>
    </MainLayout>
  );
}
