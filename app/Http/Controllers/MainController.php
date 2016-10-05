<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\support\Facades\DB;
use Carbon\Carbon;


# Models
use App\Location;
use App\Res;
use App\Contractor;
use App\Smr;
use App\Ppo;

class MainController extends Controller
{
    # main request in database
    public function search(Request $request)
    {
        $sql = DB::table('location AS l')
                        ->select('l.location_id', 'l.location_name', 'c.contractor_name', 'c.contractor_id', 'r.pes', 'r.res_name', 'l.report_ppo', 'l.schedule_plan', 'l.trp', 'l.estimate', 'l.kc2',
                    DB::raw("
                        (SELECT COUNT(object_id) FROM object o WHERE o.location_id=l.location_id) 
                        AS plan_fiz18,

                        (SELECT count(ppo_id) FROM ppo where ppo_location_id=l.location_id and ppo_object_id>0) 
                        AS total_found_fiz18,
                        
                        (SELECT count(object_id) FROM object where location_id=l.location_id AND comment !='-') 
                        AS total_not_found,
                        
                        (SELECT count(ppo_id) FROM ppo where ppo_location_id=l.location_id AND ppo_object_id<1) 
                        AS total_ppo_vne18,
                        
                        (SELECT count(ppo_id) FROM ppo hbz where ppo_location_id=l.location_id AND (hbz.ppo_house  IN ('','-',', 0,0','Х/б','0','б/н','уч.0','коттедж','уч.','д.0','д.','Участок 0','к.н.','хоз.бл.','Ю','Уч.б/н','у/о','клуб','магазин','ВЗУ', '0',' д. 0',' д. сад.д.',' д.0',', 0,0',', баня,0',', гараж,0',', дача,0','-','1 коттедж','б','б/н','б/н,0','б\н','бн','будка','бытовка','вагончик','взу','газ','дача,0','ивановское дер. речная ул. б/н,0','коттедж','Магазин','магазин продукты','МКЖД','насос','освещени','парихмах','Почта','сарай','сбербанк','таксофон','телефон','у/о','уо','уч','уч.','уч. при д. 8','уч. при д.14','уч. при д.3','уч. при д.31а','уч. при д.36','уч.0','уч.9/1 при д.9','уч.б/н','уч.при д.11','уч.при д.7','уч.при д.9','фельшер','храм','Церковь','црб') or hbz.ppo_fio IN ('','-','А','абонент',',','-','0','2','? д.18 ','А','А . .','Аа','абонент','Абонент  д.53','Абонет Абонент Абонент','ГАРАЖ','дом','н/д','нет данных','нет счетчика','почта','ТУ'))) 
                        AS total_hbz,

                        (SELECT COUNT(ppo_id) FROM ppo WHERE ppo_location_id=l.location_id AND ppo_customer_type IN ('физ', 'юр', 'тех','мкд')) 
                        AS total_smr,

                        (SELECT COUNT(p.ppo_id) FROM ppo p where ppo_location_id=l.location_id AND p.ppo_customer_type IN ('физ', 'юр', 'тех','мкд') AND ppo_faza=1 ) 
                        AS total_1f,
                        
                        (SELECT COUNT(p.ppo_id) FROM ppo p WHERE ppo_location_id=l.location_id AND p.ppo_customer_type IN ('физ', 'юр', 'тех','мкд') AND ppo_faza=3 ) 
                        AS total_3f,

                        (SELECT COUNT(tp_id) FROM tp WHERE tp_location_id=l.location_id) 
                        AS total_tp"
                    ))
                        ->LeftJoin('res AS r', 'r.res_id', '=', 'l.res_id')
                        ->LeftJoin('contractor AS c', 'c.contractor_id', '=', 'l.location_contractor_id')
                        ->orderBy('r.pes')
                        ->orderBy('r.res_name')
                        ->orderBy('l.location_name');

                $data = [];

                if($request->get('search'))
                {
                    $data = $sql
                        ->where("r.pes", "LIKE", "%{$request->get('search')}%")
                        ->orWhere("r.res_name", "LIKE", "%{$request->get('search')}%")
                        ->orWhere("l.location_name", "LIKE", "%{$request->get('search')}%")
                        ->orWhere("c.contractor_name", "LIKE", "%{$request->get('search')}%")
                        ->get();
                }

                elseif($request->get('column'))
                {
                    $data = $sql
                        ->where("r.pes", "=", $request->get('column'))
                        ->orWhere("r.res_name", "=", $request->get('column'))
                        ->orWhere("l.location_name", "=", $request->get('column'))
                        ->orWhere("c.contractor_name", "=", $request->get('column'))
                        ->get();
                }

                elseif($request->get('smr'))
                {
                    # settings
                    $date_week = []; $date = []; $col = []; $date_smr = []; $i = 0; $s = 0;

                    # array equipment
                    $equipment_type = ['1Ф', '3Ф', '3Б', 'УСПД', 'Акт допуска'];

                    # array date
                    $start = Carbon::now()->subDay(6);
                    for ($i = 0; $i < 7; $i++) {
                        $date_week[] = $start->copy()->toDateString();
                        $start->addDay();

                        # create empty array date_smr
                        $date[$date_week[$i]]['date'] = $date_week[$i];
                        $date[$date_week[$i]]['qty'] = 0;
                        $date[$date_week[$i]]['equipment'] = 0;
                    }

                    $main_table = $sql
                            ->where("c.contractor_name", "=", $request->get('smr'))
                            ->get();

                    $smr_table = DB::table('smr')
                            ->select('*')
                            ->orderBy('smr_published_at', 'ASC')
                            ->get();
                    
                    foreach($main_table as $row):
                        foreach($equipment_type as $eq):
                            $i++;

                            $col[$i]['location_id'] = $row->location_id;
                            $col[$i]['location_name'] = $row->location_name;
                            $col[$i]['contractor_id'] = $row->contractor_id;
                            $col[$i]['contractor_name'] = $row->contractor_name;
                            $col[$i]['pes'] = $row->pes;
                            $col[$i]['res_name'] = $row->res_name;
                            $col[$i]['report_ppo'] = $row->report_ppo;
                            $col[$i]['schedule_plan'] = $row->schedule_plan;
                            $col[$i]['trp'] = $row->trp;
                            $col[$i]['estimate'] = $row->estimate;
                            $col[$i]['kc2'] = $row->kc2;
                            $col[$i]['equipment'] = $eq;

                            if(count($smr_table)) {
                            foreach($date_week as $de):
                                foreach($smr_table as $smr):
                                    $s++;

                                    $d1 = Carbon::parse($smr->smr_published_at)->toDateString();
                                    $d2 = Carbon::parse($de)->toDateString();

                                    if($smr->smr_contractor_id == $row->contractor_id 
                                        && $smr->smr_location_id == $row->location_id
                                        && $d1 == $d2
                                        && $smr->smr_type_equipment == $eq)
                                    {
                                        $date_smr[$d1]['date'] = $d1;
                                        $date_smr[$d1]['qty'] = $smr->smr_quantity;
                                        $date_smr[$d1]['equipment'] = $smr->smr_type_equipment;
                                    }
                                endforeach;
                            endforeach;

                            $col[$i]['date_smr'] = array_filter($date_smr, function($a) use($eq) {
                                return $a['equipment'] == $eq;
                            });
                                $col[$i]['date_smr'] = array_replace($date, $col[$i]['date_smr']);
                            } else {
                                $col[$i]['date_smr'] = $date;
                            }

                        endforeach;
                    endforeach;

                    sort($col);

                    $data = array_merge_recursive([
                        'data' => $col, 
                        'date_week' => $date_week,
                    ]);
                }

                else 
                {
                    $data = $sql->get();
                }

        $status = DB::table('status AS s')
        		  ->select('s.status_id', 's.status_name')
        		  ->get();

        return response($data);
    }

    public function main()
    {
        $data['location']   = Location::groupBy('location_name')->select('location_name')->get();
        $data['pes']        = Res::groupBy('pes')->select('pes')->get();
        $data['res_name']   = Res::groupBy('res_name')->select('res_name')->get();
        $data['contractor'] = Contractor::groupBy('contractor_name')->select('contractor_name')->get();
        return response($data);
    }

    # workflow update status
    public function update(Request $request, $id)
    {
		$location = Location::find($id);
		$location->update([$request->type => $request->$id]);
        return response(['status' => 'success']);
    }

    # insert smr
    public function create_smr(Request $request)
    {
        $smr = Smr::create($request->all());
        if($smr)
        {
            return response(['status' => 'success']);
        } else {
            return response(['status' => 'error']);
        }
    }

    public function ppo()
    {
        $sql = DB::table('ppo AS p')
            ->select(DB::raw("

                    (SELECT tp_id FROM tp WHERE tp_location_id = p.ppo_location_id AND tp_num = ppo_tp) 
                    AS tp_id,

                    (SELECT count(ppo_id) FROM ppo pposmr WHERE pposmr.ppo_location_id = p.ppo_location_id AND pposmr.ppo_tp = p.ppo_tp AND ppo_customer_type in ('физ', 'юр', 'тех','мкд')) 
                    AS total_smr, 

                    (SELECT count(ppo_id) FROM ppo pposmr WHERE pposmr.ppo_location_id = p.ppo_location_id AND pposmr.ppo_tp = p.ppo_tp AND ppo_customer_type ='мкд') 
                    AS mkd,

                    (SELECT count(ppo_id) FROM ppo pposmr WHERE pposmr.ppo_location_id = p.ppo_location_id AND pposmr.ppo_tp = p.ppo_tp AND ppo_faza = 1 AND ppo_customer_type in ('физ', 'юр', 'тех','мкд')) 
                    AS total_1f, 

                    (SELECT count(ppo_id) FROM ppo pposmr WHERE pposmr.ppo_location_id = p.ppo_location_id AND pposmr.ppo_tp = p.ppo_tp AND ppo_faza = 3 AND ppo_customer_type in ('физ', 'юр', 'тех','мкд')) 
                    AS total_3f, 

                    (SELECT count(ppo_id) FROM ppo pposmr WHERE pposmr.ppo_location_id = p.ppo_location_id AND pposmr.ppo_tp = p.ppo_tp AND ppo_in_type = 'н' AND ppo_customer_type in ('физ', 'юр', 'тех','мкд')) 
                    AS total_nv,

                    (SELECT count(ppo_id) FROM ppo ppoi WHERE ppoi.ppo_location_id = p.ppo_location_id AND ppoi.ppo_tp = p.ppo_tp AND ppoi.ppo_highway_type = 'и') 
                    AS i, 

                    (SELECT count(ppoh.ppo_id) FROM ppo ppoh WHERE ppoh.ppo_location_id = p.ppo_location_id AND ppoh.ppo_tp = p.ppo_tp AND (ppoh.ppo_house 
                        IN ('','-',', 0,0','Х/б','0','б/н','уч.0','коттедж','уч.','д.0','д.','Участок 0','к.н.','хоз.бл.','Ю','Уч.б/н','у/о','клуб','магазин','ВЗУ', '0',' д. 0',' д. сад.д.',' д.0',', 0,0',', баня,0',', гараж,0',', дача,0','-','1 коттедж','б','б/н','б/н,0','б\н','бн','будка','бытовка','вагончик','взу','газ','дача,0','ивановское дер. речная ул. б/н,0','коттедж','Магазин','магазин продукты','МКЖД','насос','освещени','парихмах','Почта','сарай','сбербанк','таксофон','телефон','у/о','уо','уч','уч.','уч. при д. 8','уч. при д.14','уч. при д.3','уч. при д.31а','уч. при д.36','уч.0','уч.9/1 при д.9','уч.б/н','уч.при д.11','уч.при д.7','уч.при д.9','фельшер','храм','Церковь','црб') OR ppoh.ppo_fio 
                        IN ('','-','А','абонент',',','-','0','2','? д.18 ','А','А . .','Аа','абонент','Абонент  д.53','Абонет Абонент Абонент','ГАРАЖ','дом','н/д','нет данных','нет счетчика','почта','ТУ'))) 
                    AS hbz_ppo, 

                    (SELECT count(ppo_id) FROM ppo ppon WHERE ppon.ppo_location_id = p.ppo_location_id AND ppon.ppo_tp = p.ppo_tp AND ppon.ppo_highway_type = 'н') 
                    AS n"))
                
                #->LeftJoin('tp AS t', 't.tp_id', '=', 'p.ppo_tp')
                #->LeftJoin('res AS r', 'r.res_id', '=', 'p.ppo_res_id')
                #->LeftJoin('location AS l', 'l.location_id', '=', 'p.ppo_location_id')
                #->LeftJoin('contractor AS c', 'c.contractor_id', '=', 'p.ppo_contractor_id')
                ->get();

        dd($sql);
    }

    public function smr()
    {
        $start = Carbon::now();
        $start->subDay(6);

        for ($i = 0; $i < 7; $i++) {
           $dates[] = $start->copy();
           $start->addDay();
        }

        $sql = DB::table('location AS l')
                ->select('l.location_id', 'c.contractor_name', 'r.pes', 'r.res_name', 'l.location_name',
                DB::raw("
                    (SELECT count(ppo_id) FROM ppo WHERE ppo_customer_type IN ('физ', 'юр', 'тех','мкд') AND ppo_faza = 1 AND ppo_location_id = ppo.ppo_location_id) 
                    AS 1f,

                    (SELECT count(ppo_id) FROM ppo WHERE ppo_customer_type IN ('физ', 'юр', 'тех','мкд') AND ppo_faza = 3 AND ppo_location_id = ppo.ppo_location_id)
                    AS 3f,

                    (SELECT count(tp_id) FROM tp WHERE tp_location_id = location_id)
                    AS 3b_uspd
                    "))

                ->LeftJoin('res AS r', 'r.res_id', '=', 'l.res_id')
                ->LeftJoin('contractor AS c', 'contractor_id', '=', 'l.location_contractor_id')
                ->orderBy('r.pes')
                ->orderBy('c.contractor_name')
                ->orderBy('l.location_name')
                ->get();
                dd($sql);
        return response(['data' => $sql]);
    }

    public function smr2()
    {
    }
}