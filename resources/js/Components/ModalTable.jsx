export default function ModalTable({ open, onClose, data }) {
    if (!open || !data) return null;

    return (
        <div className="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50">
            <div className="bg-white p-9 rounded shadow-lg w-auto">
                <h2 className="text-xl font-bold mb-4">Detalles del expediente</h2>
                <p><strong>Número de expediente:</strong> {data.numero}</p>
                <p><strong>Nombre completo del servidor:</strong> {data.nombreCompleto}</p>
                <p><strong>Institución del servidor:</strong> {data.nomInstitucion}</p>
                <p><strong>Departamento del servidor:</strong> {data.departamento}</p>
                <p><strong>Oficio de requerimiento:</strong> {data.ofRequerimiento}</p>
                <p><strong>Fecha del oficio de requerimiento:</strong> {data.fechaRequerimiento}</p>
                <p><strong>Oficio de respuesta:</strong> {data.ofRespuesta}</p>
                <p><strong>Fecha del oficio de respuesta:</strong> {data.fechaRespuesta}</p>
                <p><strong>Fecha de recepción del oficio de respuesta:</strong> {data.fechaRecepcion}</p>
                
                <button 
                    onClick={onClose} 
                    className="mt-4 px-4 py-2 bg-azulIMTA text-white rounded"
                >
                    Cerrar
                </button>
            </div>
        </div>
    );
}
