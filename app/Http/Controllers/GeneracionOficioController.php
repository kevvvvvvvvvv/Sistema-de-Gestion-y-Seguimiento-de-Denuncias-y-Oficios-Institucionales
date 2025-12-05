<?php

namespace App\Http\Controllers;

use App\Models\Expediente;
use App\Models\Plantilla;
use App\Models\Servidor;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Element\Header;
use PhpOffice\PhpWord\Element\Footer;
use PhpOffice\PhpWord\Shared\Converter;
use PhpOffice\PhpWord\SimpleType\Jc;

class GeneracionOficioController extends Controller
{
    public function verPlantillas() 
    {
        $plantillas  = Plantilla::withTrashed()->get();
        $servidores = Servidor::with(['institucion', 'departamento'])->get();
        $expedientes = Expediente::all();
        return Inertia::render('Modulos/GeneracionOficio/Index', [
            'plantillas' =>  $plantillas,
            'servidores' => $servidores,
            'expedientes' => $expedientes
        ]);
    }

    public function showEditor()
    {
        return Inertia::render('Modulos/GeneracionOficio/Editor');
    }

    public function guardarPlantilla(Request $request){
        $request->validate([
            'titulo' => 'required|string|max:300',
            'contenido' => 'required|string',
        ]);

        Plantilla::create([
            'titulo' => $request->titulo,
            'contenido' => $request->contenido,
        ]);

        return redirect()->route('modulo.oficios.index');
    }

    public function editarPlantilla($id)
    {
        $plantilla = Plantilla::findOrFail($id);
        return Inertia::render('Modulos/GeneracionOficio/EditorActualizar', ['plantilla' => $plantilla]);
    }

    public function actualizarPlantilla(Request $request, $id)
    {
        $request->validate([
            'titulo' => 'required|string|max:300',
            'contenido' => 'required|string',
        ]);

        $plantilla = Plantilla::findOrFail($id);
        $plantilla->update([
            'titulo' => $request->titulo,
            'contenido' => $request->contenido,
        ]);

        return redirect()->route('modulo.oficios.index');
    }

    public function destroy($id)
    {
        Plantilla::findOrFail($id)->delete();
        return redirect()->route('modulo.oficios.index');
    }

    public function restore($id)
    {
        $plantilla = Plantilla::withTrashed()->find($id);
        $plantilla->restore();
        return redirect()->route('modulo.oficios.index');
    }

    public function forceDelete($id)
    {
        $plantilla = Plantilla::withTrashed()->find($id);
        $plantilla->forceDelete();
        return redirect()->route('modulo.oficios.index')
        ->with('success', 'El registro ha sido eliminado permanentemente');
    }

    public function stampHeader(Request $request)
    {
        try {
            $file = $request->file('document');
            $path = $file->getRealPath();

            $phpWord = IOFactory::load($path);
            
            $section = $phpWord->getSection(0); 

            $header = $section->addHeader();
            
            $header->addImage(
            public_path('images/gobierno.png'), 
                [
                    'width'     => Converter::cmToPixel(6), 
                    'height'    => Converter::cmToPixel(1), 
                    'alignment' => Jc::START, 
                ]
            );

            $header->addParagraph(['borderBottomSize' => 6, 'borderBottomColor' => '000000']);

            $header->addTextBreak();

            
            $footer = $section->addFooter();
            $footer->addTextBreak();
            
            $footer->addParagraph(['borderBottomSize' => 6, 'borderBottomColor' => '000000']);

            $footer->addPreserveText(
                'Página {PAGE} de {NUMPAGES}',
                ['size' => 8],
                ['alignment' => Jc::END]
            );
            
            $footer->addText(
                "Sede de la Oficina de Representación en el IMTA: Paseo Cuauhnáhuac No. 8532, Col. Progreso, C.P. 62550 Jiutepec, Morelos. Tel. (777) 3293600 EXT. 311",
                ['size' => 8], 
                ['alignment' => Jc::BOTH]
            );

            $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
            $tempFile = tempnam(sys_get_temp_dir(), 'docx');
            $objWriter->save($tempFile);

            return response()->download($tempFile, 'documento_final.docx')->deleteFileAfterSend(true);

        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ], 500);
        }
    }
}
