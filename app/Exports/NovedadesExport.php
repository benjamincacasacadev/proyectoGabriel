<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
//Para personalizar los estilos en la exportación
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\Exportable;

class NovedadesExport implements FromView, WithEvents
{
    use Exportable;
    public $novedades;

    //Para obtener parámetros desde el controlador, desde el cual es instanciado el Export
    public function parametros($novedades){
        $this->novedades = $novedades;
        return $this;
    }

    public function view(): View{
        //Se pasa los parámetros a la vista que dibuja la estructura de la tabla
        $novedades = $this->novedades;
        return view('novedades.excel', compact('novedades'));
    }

    //Para dar formato y estilos a las celdas
    public function registerEvents(): array{
        return [
            AfterSheet::class => function (AfterSheet $event) {
                //#################################################################################################
                //###### IMPORTAR MACROS PERSONALIZADAS PARA APLICAR ESTILOS, BORDES, CENTREADOS, COLOR, ETC ######
                //####################### (TAMBIÉN INCLUYE LOS COLORES POR DEFECTO A USAR) ########################
                include("ExcelMacrosExport.php");

                //########################## CÁLCULO DE FILAS Y COLUMNAS DE INICIO Y FIN ##########################

                $primeraColumna = 'A';
                $primeraFila = 1;
                $primeraFilaTabla = 3;
                $primeraFilaDatos = 4;

                $ultimaColumna = $event->sheet->getHighestColumn();
                $ultimaFilaDatos = $event->sheet->getHighestRow();

                $inicioRango = $primeraColumna . $primeraFila;
                $finRango = $ultimaColumna . $ultimaFilaDatos;
                $rangoDatos = $primeraColumna . $primeraFilaDatos . ':' . $finRango;

                //############################## PERSONALIZAR CELDAS ###############################
                //==========> BORDES
                $event->sheet->estiloBordesDelgadoInterno($primeraColumna . $primeraFilaTabla . ':' . $finRango, $colorBordeDelagado);
                $event->sheet->estiloBordeGruesoExterno($inicioRango . ':' . $finRango, $colorBordeGrueso);

                //############################# PERSONALIZAR COLUMNAS ##############################
                //==========> ESTABLECER ANCHO DE LAS COLUMNAS
                $event->sheet->estiloAnchoColumna('A', 8); // Cod
                $event->sheet->estiloAnchoColumna('B', 10); // SOLO Fecha
                $event->sheet->estiloAnchoColumna('C', 10); // Hora
                $event->sheet->estiloAnchoColumna('D', 10); // Dia
                $event->sheet->estiloAnchoColumna('E', 15); // Operador
                $event->sheet->estiloAnchoColumna('F', 20); // Ambito
                $event->sheet->estiloAnchoColumna('G', 20); // Evento
                $event->sheet->estiloAnchoColumna('H', 15); // Cuenta/Matricula
                $event->sheet->estiloAnchoColumna('I', 15); // Regional
                $event->sheet->estiloAnchoColumna('J', 17); // Departamento
                $event->sheet->estiloAnchoColumna('K', 20); // Paf (Nom cuenta o vehiculo)
                $event->sheet->estiloAnchoColumna('L', 30); // Acciones (Comentarios)
                $event->sheet->estiloAnchoColumna('M', 15); // Reportado
                $event->sheet->estiloAnchoColumna('N', 15); // Estado

                //==========> AJUSTE DEL CONTENIDO AL ANCHO DE LA CELDA (WRAP TEXT)
                $columnasPorAjustar = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N'];
                foreach ($columnasPorAjustar as $columna) {
                    $event->sheet->estiloAjustarTexto($columna . $primeraFilaTabla . ':' . $columna . $ultimaFilaDatos);
                }

                //==========> FILA CABECERA DE TÍTULOS DE LA TABLA
                $numFila = $primeraFilaTabla;
                $fila = $primeraColumna . $numFila . ':' . $ultimaColumna . $numFila;
                //Centrar
                $event->sheet->estiloCentrar($fila);
                $event->sheet->estiloCentrarVerticalmente($fila);
                //Estilos
                $event->sheet->estiloNegrita($fila);
                //Color
                $event->sheet->estiloLetraColor($fila, $colorLetraTablaCabecera);
                $event->sheet->estiloRellenarColor($fila, $fondoTablaCabecera);

                //==========> FILAS y COLUMNAS DEL CUERPO DE LA TABLA
                //Centrar
                $columnasCentradas = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'M', 'N'];
                foreach ($columnasCentradas as $columna) {
                    $event->sheet->estiloCentrar($columna . $primeraFilaDatos . ':' . $columna . $ultimaFilaDatos);
                }
                //Centrar Verticalmente
                $event->sheet->estiloCentrarVerticalmente($rangoDatos);
                //Justificar texto
                $columnasAJustificar = ['L'];
                foreach ($columnasAJustificar as $columna) {
                    $event->sheet->estiloJustificarIzquierda($columna . $primeraFilaDatos . ':' . $columna . $ultimaFilaDatos);
                }

                //Tamaño letra
                $event->sheet->estiloLetraCalibriTam($rangoDatos, 10);
                //Color a rayas
                for ($i = $primeraFilaDatos; $i <= $ultimaFilaDatos; $i++) {
                    $fila = $primeraColumna . $i . ':' . $ultimaColumna . $i;
                    $color = ($i % 2 == 0) ?  $fondoCuerpoClaro : $fondoCuerpoOscuro;
                    $event->sheet->estiloRellenarColor($fila, $color);
                }

                ##AHORA CABECERA
                //################################### CABECERA #####################################
                //==========> FILA: NOMBRE DE LA EMPRESA Y LOGO
                $numFila = $primeraFila;
                //ULTIMA COLUMNA SE ACTUALIZA DESPUES DE OCULTAR TODAS LAS COLUMNAS NECESARIAS
                $ultimaColumna = $event->sheet->getHighestDataColumn();
                $fila = $primeraColumna . $numFila . ':' . $ultimaColumna . $numFila;
                $event->sheet->mergeCells($fila);
                //Altura
                $event->sheet->estiloAlturaFila(1, 20);
                //Estilos
                $event->sheet->estiloNegrita($fila);
                $event->sheet->estiloJustificarDerecha($fila);
                //Color
                $event->sheet->estiloLetraColor($fila, $colorLetraNombreEmpresa);
                $event->sheet->estiloRellenarColor($fila, $colorFondoNombreEmpresa);
                $numFila = $primeraFila + 1;

                //############################## PERSONALIZAR CELDAS ###############################
                $inicioRango = $primeraColumna . $primeraFila;
                $finRango = $ultimaColumna . $ultimaFilaDatos;
                $rangoDatos = $primeraColumna . $primeraFilaDatos . ':' . $finRango;
                //==========> BORDES
                $event->sheet->estiloBordesDelgadoInterno($primeraColumna . $primeraFilaTabla . ':' . $finRango, $colorBordeDelagado);
                $event->sheet->estiloBordeGruesoExterno($inicioRango . ':' . $finRango, $colorBordeGrueso);

                //ULTIMA COLUMNA SE ACTUALIZA DESPUES DE OCULTAR TODAS LAS COLUMNAS NECESARIAS
                $ultimaColumna = $event->sheet->getHighestDataColumn();
                $fila = $primeraColumna . $numFila . ':' . $ultimaColumna . $numFila;
                $event->sheet->mergeCells($fila);
                //Altura
                $event->sheet->estiloAlturaFila($numFila, 40);
                //Centrar
                $event->sheet->estiloCentrar($fila);
                $event->sheet->estiloCentrarVerticalmente($fila);
                //Estilos
                $event->sheet->estiloNegrita($fila);
                //$event->sheet->estiloSubrallado($fila);
                //Tamaño letra
                $event->sheet->estiloLetraCalibriTam($fila, 28);
                //Color
                $event->sheet->estiloLetraColor($fila, $colorLetraTitulo);
                $event->sheet->estiloRellenarColorGradiente($fila, $colorFondoTituloArriba, $colorFondoTituloAbajo);
            }
        ];
    }
}
