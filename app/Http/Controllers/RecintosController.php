<?php

namespace App\Http\Controllers;

use App\Distritos;
use App\Municipios;
use App\People;
use App\Recintos;
use Fredpeal\BakaHttp\Traits\CrudTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpWord\Settings;
use PhpOffice\PhpWord\TemplateProcessor;

class RecintosController extends Controller
{
    //
    use CrudTrait;

    public function __construct()
    {
        $this->model = new Recintos;
    }

    public function report($id)
    {
        Settings::setPdfRendererPath('/vendor/dompdf/dompdf');
        Settings::setPdfRendererName('DOMPDF');
        $recinto = $this->model::find($id);
        $template = Storage::disk('local')->path('reportes/recintos.docx');
        $templateProcessor = new TemplateProcessor($template);
        $templateProcessor->setValue('NombreRecinto', $recinto->name);
        $templateProcessor->setValue('CantidadDeColegios', $recinto->number_colegios);
        $templateProcessor->setValue('DireccionRecinto', $recinto->address);
        $templateProcessor->setValue('NombreMunicipio', $recinto->municipios->name);
        $templateProcessor->setValue('Distrito', $recinto->distritos ? $recinto->distritos->name : '');
        $coordinadores = [
            [
                'NombreCordinador' => $recinto->coordinadores ? $recinto->coordinadores->name : '',
                'RolCordinador' => 'Coordinador',
            ],
            [
                'NombreCordinador' => $recinto->coordinadores_ejecutivos ? $recinto->coordinadores_ejecutivos->name : '',
                'RolCordinador' => 'Coordinador Ejecutivo',
            ],
            [
                'NombreCordinador' => $recinto->coordinadores_electorales ? $recinto->coordinadores_electorales->name : '',
                'RolCordinador' => 'Coordinador Electoral',
            ],
            [
                'NombreCordinador' => $recinto->coordinadores_seguridad ? $recinto->coordinadores_seguridad->name : '',
                'RolCordinador' => 'Coordinador de Seguridad',
            ],
            [
                'NombreCordinador' => $recinto->coordinadores_finanzas ? $recinto->coordinadores_finanzas->name : '',
                'RolCordinador' => 'Coordinador de Finanzas',
            ],
            [
                'NombreCordinador' => $recinto->activistas ? $recinto->activistas->name : '',
                'RolCordinador' => 'Sub-cordinador',
            ],
            [
                'NombreCordinador' => $recinto->activistas1 ? $recinto->activistas1->name : '',
                'RolCordinador' => 'Sub-cordinador 1',
            ],
            [
                'NombreCordinador' => $recinto->activistas2 ? $recinto->activistas2->name : '',
                'RolCordinador' => 'Sub-cordinador 2',
            ],
            [
                'NombreCordinador' => $recinto->activistas2 ? $recinto->activistas2->name : '',
                'RolCordinador' => 'Sub-cordinador 2',
            ],
            [
                'NombreCordinador' => $recinto->activistas3 ? $recinto->activistas3->name : '',
                'RolCordinador' => 'Sub-cordinador 3',
            ],
            [
                'NombreCordinador' => $recinto->activistas4 ? $recinto->activistas4->name : '',
                'RolCordinador' => 'Sub-cordinador 4',
            ],
            [
                'NombreCordinador' => $recinto->activistas5 ? $recinto->activistas5->name : '',
                'RolCordinador' => 'Sub-cordinador 5',
            ],
        ];

        $electores = [];
        $people = People::where('recintos_id', $id)
            ->orderBy('colegios_electorales_id')
            ->get();
        $templateProcessor->setValue('numeroElectoresRecinto', $people->count());
        foreach ($people as $model) {
            $electores[] = [
                'NombreElector' => $model->first_name . ' ' . $model->last_name,
                'cedulaElector' => $model->card_id,
                'celularElector' => $model->celphone,
                'ColegioElectoralElector' => $model->colegios_electorales ? $model->colegios_electorales->name : '',
                'comiteBaseElector' => $model->comites_bases ? $model->comites_bases->name : '',
            ];
        }
        $templateProcessor->cloneRowAndSetValues('NombreCordinador', $coordinadores);
        if ($electores) {
            $templateProcessor->cloneRowAndSetValues('NombreElector', $electores);
        }

        $fileName = uniqid();
        $templateProcessor->saveAs("/app/storage/app/reportes/{$fileName}.docx");
        return response()->download("/app/storage/app/reportes/{$fileName}.docx", "{$recinto->name}.docx");
    }

    /**
     * getByDistritos
     *
     * @param  Request $request
     * @param  mixed $name
     * @return void
     */
    public function getByDistritos(Request $request, $name)
    {
        $distritos = Distritos::where('name', 'like', "%{$name}%")->select('id')->get();
        $distritos = $distritos->toArray();

        $distritosId = array_map(function ($distrito) {
            return $distrito['id'];;
        }, $distritos);

        $request = $request->toArray();
        $condition = [
            'condition' => 'whereIn',
            'field' => 'distritos_id',
            'value' => implode(',', $distritosId),
        ];
        $request['q'][] = json_encode($condition);
        $data = $this->search($request);
        return response()->json($data);
    }

    /**
     * getByMunicipios
     *
     * @param  Request $request
     * @param  mixed $name
     * @return void
     */
    public function getByMunicipios(Request $request, $name)
    {
        $municipios = Municipios::where('name', 'like', "%{$name}%")->select('id')->get();
        $municipios = $municipios->toArray();

        $municipiosId = array_map(function ($municipio) {
            return $municipio['id'];;
        }, $municipios);

        $request = $request->toArray();
        $condition = [
            'condition' => 'whereIn',
            'field' => 'municipios_id',
            'value' => implode(',', $municipiosId),
        ];
        $request['q'][] = json_encode($condition);
        $data = $this->search($request);
        return response()->json($data);
    }

    /**
     * search function
     *
     * @param  mixed $request
     * @return
     */
    public function search(array $request)
    {
        $model = $this->model::query();

        #Pagination Vars

        $perPage = key_exists('perPage', $request) ? $request['perPage'] : 5;
        $page = key_exists('page', $request) ? $request['page'] : 1;
        $offset = $page == 1 ? 0 : intval($perPage) * intval($page - 1);
        if (key_exists('q', $request)) {
            foreach ($request['q'] as $key) {
                $q = json_decode($key, true);
                $this->model = $this->conditions($model, $q);
            }
        }
        $totalResult = $this->model->count();
        $lastPage = ceil($totalResult / intval($perPage));

        $data = $this->model->orderBy('id', 'desc')
            ->offset($offset)
            ->limit($perPage)
            ->get();

        $dataResponse = [];

        foreach ($data as $model) {
            $dataResponse[] = [
                'id' => $model->id,
                'municipios_id' => $model->municipios_id,
                'distritos_id' => $model->distritos_id,
                'name' => $model->name,
                'address' => $model->address,
                'coordinadores_id' => $model->coordinadores_id,
                'coordinadores_ejecutivos_id' => $model->coordinadores_ejecutivos_id,
                'coordinadores_electorales_id' => $model->coordinadores_electorales_id,
                'coordinadores_seguridad_id' => $model->coordinadores_seguridad_id,
                'coordinadores_finanzas_id' => $model->coordinadores_finanzas_id,
                'activistas_id' => $model->activistas_id,
                'activistas1_id' => $model->activistas1_id,
                'activistas2_id' => $model->activistas2_id,
                'activistas3_id' => $model->activistas3_id,
                'activistas4_id' => $model->activistas4_id,
                'activistas5_id' => $model->activistas5_id,
                'number_colegios' => $model->number_colegios,
                'coordinadores' => $model->coordinadores ? [
                    'id' => $model->coordinadores->id,
                    'first_name' => $model->coordinadores->first_name,
                    'last_name' => $model->coordinadores->last_name,
                    'name' => $model->coordinadores->name,
                ] : false,
                'distritos' => $model->distritos ? [
                    'id' => $model->distritos->id,
                    'name' => $model->distritos->name,
                ] : false,
                'coordinadores_ejecutivos' => $model->coordinadores_ejecutivos ? [
                    'id' => $model->coordinadores_ejecutivos->id,
                    'first_name' => $model->coordinadores_ejecutivos->first_name,
                    'last_name' => $model->coordinadores_ejecutivos->last_name,
                    'name' => $model->coordinadores_ejecutivos->name,
                ] : false,
                'coordinadores_electorales' => $model->coordinadores_electorales ? [
                    'id' => $model->coordinadores_electorales->id,
                    'first_name' => $model->coordinadores_electorales->first_name,
                    'last_name' => $model->coordinadores_electorales->last_name,
                    'name' => $model->coordinadores_electorales->name,
                ] : false,
                'coordinadores_seguridad' => $model->coordinadores_seguridad ? [
                    'id' => $model->coordinadores_seguridad->id,
                    'first_name' => $model->coordinadores_seguridad->first_name,
                    'last_name' => $model->coordinadores_seguridad->last_name,
                    'name' => $model->coordinadores_seguridad->name,
                ] : false,
                'coordinadores_finanzas' => $model->coordinadores_finanzas ? [
                    'id' => $model->coordinadores_finanzas->id,
                    'first_name' => $model->coordinadores_finanzas->first_name,
                    'last_name' => $model->coordinadores_finanzas->last_name,
                    'name' => $model->coordinadores_finanzas->name,
                ] : false,
                'activistas' => $model->activistas ? [
                    'id' => $model->activistas->id,
                    'first_name' => $model->activistas->first_name,
                    'last_name' => $model->activistas->last_name,
                    'name' => $model->activistas->name,
                ] : false,
                'activistas1' => $model->activistas1 ? [
                    'id' => $model->activistas1->id,
                    'first_name' => $model->activistas1->first_name,
                    'last_name' => $model->activistas1->last_name,
                    'name' => $model->activistas1->name,
                ] : false,
                'activistas2' => $model->activistas2 ? [
                    'id' => $model->activistas2->id,
                    'first_name' => $model->activistas2->first_name,
                    'last_name' => $model->activistas2->last_name,
                    'name' => $model->activistas2->name,
                ] : false,
                'activistas3' => $model->activistas3 ? [
                    'id' => $model->activistas3->id,
                    'first_name' => $model->activistas3->first_name,
                    'last_name' => $model->activistas3->last_name,
                    'name' => $model->activistas3->name,
                ] : false,
                'activistas4' => $model->activistas4 ? [
                    'id' => $model->activistas4->id,
                    'first_name' => $model->activistas4->first_name,
                    'last_name' => $model->activistas4->last_name,
                    'name' => $model->activistas4->name,
                ] : false,
                'activistas5' => $model->activistas5 ? [
                    'id' => $model->activistas5->id,
                    'first_name' => $model->activistas5->first_name,
                    'last_name' => $model->activistas5->last_name,
                    'name' => $model->activistas5->name,
                ] : false,
                'municipios' => $model->municipios ? [
                    'id' => $model->municipios->id,
                    'name' => $model->municipios->name,
                ] : false,
            ];
        }

        /**
         * paginate data
         */
        $data = collect($dataResponse);
        $result = [
            'total' => $totalResult,
            'last_page' => $lastPage,
            'current_page' => $page,
            'data' => $data,
        ];
        return $result;
    }
}
