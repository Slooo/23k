<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

# Models
use App\Location;
use App\Res;
use App\Contractor;

class MainController extends Controller
{
    # workflow
    public function workflow_search(Request $request)
    {
        $sql = DB::table('location AS l')
                    ->select('l.location_id', 'c.contractor_name', 'r.pes', 'r.res_name', 'l.location_name', 'l.report_ppo', 'l.schedule_plan', 'l.trp', 'l.estimate', 'l.kc2', DB::raw("(SELECT COUNT(object_id) FROM object o WHERE o.location_id=l.location_id) AS plan_fiz18,

                        (select count(ppo_id) from ppo where ppo_location_id=l.location_id and ppo_object_id>0) as total_found_fiz18,
                        (select count(object_id) from object where location_id=l.location_id AND comment !='-') as total_not_found,
                        (select count(ppo_id) from ppo where ppo_location_id=l.location_id AND ppo_object_id<1) as total_ppo_vne18,
                        ( select count(ppo_id) from ppo hbz where ppo_location_id=l.location_id AND (hbz.ppo_house  IN ('','-',', 0,0','Х/б','0','б/н','уч.0','коттедж','уч.','д.0','д.','Участок 0','к.н.','хоз.бл.','Ю','Уч.б/н','у/о','клуб','магазин','ВЗУ', '0',' д. 0',' д. сад.д.',' д.0',', 0,0',', баня,0',', гараж,0',', дача,0','-','1 коттедж','б','б/н','б/н,0','б\н','бн','будка','бытовка','вагончик','взу','газ','дача,0','ивановское дер. речная ул. б/н,0','коттедж','Магазин','магазин продукты','МКЖД','насос','освещени','парихмах','Почта','сарай','сбербанк','таксофон','телефон','у/о','уо','уч','уч.','уч. при д. 8','уч. при д.14','уч. при д.3','уч. при д.31а','уч. при д.36','уч.0','уч.9/1 при д.9','уч.б/н','уч.при д.11','уч.при д.7','уч.при д.9','фельшер','храм','Церковь','црб') or hbz.ppo_fio IN ('','-','А','абонент',',','-','0','2','? д.18 ','А','А . .','Аа','абонент','Абонент  д.53','Абонет Абонент Абонент','ГАРАЖ','дом','н/д','нет данных','нет счетчика','почта','ТУ')  )) as total_hbz,
                        (SELECT COUNT(ppo_id) FROM ppo WHERE ppo_location_id=l.location_id AND ppo_customer_type IN ('физ', 'юр', 'тех','мкд')) AS total_smr,
                        (SELECT COUNT(p.ppo_id) FROM ppo p where ppo_location_id=l.location_id AND p.ppo_customer_type IN ('физ', 'юр', 'тех','мкд') AND ppo_faza=1 ) AS total_1f,
                        (SELECT COUNT(p.ppo_id) FROM ppo p WHERE ppo_location_id=l.location_id AND p.ppo_customer_type IN ('физ', 'юр', 'тех','мкд')  AND ppo_faza=3 ) AS total_3f,
                        (SELECT COUNT(tp_id) FROM tp WHERE tp_location_id=l.location_id) AS total_tp"))
                    ->LeftJoin('res AS r', 'r.res_id', '=', 'l.res_id')
                    ->LeftJoin('contractor AS c', 'c.contractor_id', '=', 'l.location_contractor_id')
                    ->orderBy('r.pes')
                    ->orderBy('r.res_name')
                    ->orderBy('l.location_name');

        if($request->get('search'))
        {
        	$location = $sql
        				->where("r.pes", "LIKE", "%{$request->get('search')}%")
        				->orWhere("r.res_name", "LIKE", "%{$request->get('search')}%")
        				->orWhere("l.location_name", "LIKE", "%{$request->get('search')}%")
                        ->orWhere("c.contractor_name", "LIKE", "%{$request->get('search')}%")
                        ->get();
        				#->paginate(70);
        }

        elseif($request->get('column'))
        {
            $location = $sql
                        ->where("r.pes", "=", $request->get('column'))
                        ->orWhere("r.res_name", "=", $request->get('column'))
                        ->orWhere("l.location_name", "=", $request->get('column'))
                        ->orWhere("c.contractor_name", "=", $request->get('column'))
                        ->get();
                        #->paginate(70);
        } else {
        	$location = $sql->get();
        				#->paginate(70);
        }

        $status = DB::table('status AS s')
        		  ->select('s.status_id', 's.status_name')
        		  ->get();

        return response(['data' => $location, 'status' => $status]);
    }

    public function workflow()
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

}