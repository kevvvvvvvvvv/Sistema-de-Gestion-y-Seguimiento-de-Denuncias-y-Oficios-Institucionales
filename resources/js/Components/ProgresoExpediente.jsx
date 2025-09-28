import React from "react";

const pasos = [
    "Inicio",
    "En espera del oficio de respuesta",
    "En Proceso",
    "Finalizado",
];

function getPasoIndex(estado) {
    switch (estado) {
        case "Inicio": return 0;
        case "En espera del oficio de respuesta": return 1;
        case "En Proceso": return 2;
        case "Finalizado": return 3;
        default: return 0;
    }
}

export default function ProgresoExpediente({ estado }) {
    const estadoIndex = getPasoIndex(estado);

    return (
        <div className="flex items-center w-full mt-6">
            {pasos.map((paso, index) => {
                const activo = index <= estadoIndex;
                return (
                    <div key={index} className="flex-1 flex items-center">
                        {/* Punto */}
                        <div className="flex flex-col items-center justify-start">
                            <div
                                className={`w-8 h-8 flex items-center justify-center rounded-full border-2 z-10
                                ${activo ? "bg-azulIMTA text-white border-azulIMTA" : "bg-gray-200 border-gray-400"}
                                `}
                            >
                                {index + 1}
                            </div>
                            <div className="text-xs mt-2 text-center w-24">{paso}</div>
                        </div>

                        {/* Línea (a la derecha, excepto el último) */}
                        {index < pasos.length - 1 && (
                            <div
                                className={`flex-1 h-1 ml-2 mr-2 ${
                                index < estadoIndex ? "bg-blue-600" : "bg-gray-300"
                                }`}
                            ></div>
                        )}
                    </div>
                );
            })}
        </div>
    );
}

