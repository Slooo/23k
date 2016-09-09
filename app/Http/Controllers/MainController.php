<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Location;
use Illuminate\Support\Facades\DB;

class MainController extends Controller
{
    # workflow
    public function workflow(Request $request)
    {
        $input = $request->all();

        $sql = DB::table('location AS l')
                    ->select('l.location_id', 'r.pes', 'r.res_name', 'l.location_name', 'l.report_ppo', 'l.schedule_plan', 'l.trp', 'l.estimate', 'l.kc2', DB::raw("(SELECT COUNT(object_id) FROM object o WHERE o.location_id=l.location_id) AS plan_fiz18, (SELECT COUNT(ppo_id) FROM ppo WHERE ppo_location_id=l.location_id AND ppo_customer_type IN ('физ', 'юр', 'тех','мкд')) AS total_smr,(SELECT COUNT(p.ppo_id) FROM ppo p where p.ppo_customer_type IN ('физ', 'юр', 'тех','мкд') AND ppo_contractor_id=r.res_contractor_id AND p.ppo_res_id=r.res_id AND ppo_faza=1 ) AS total_1f, (SELECT COUNT(p.ppo_id) FROM ppo p WHERE p.ppo_customer_type IN ('физ', 'юр', 'тех','мкд') AND ppo_contractor_id=r.res_contractor_id AND p.ppo_res_id=r.res_id AND ppo_faza=3 ) AS total_3f, (SELECT COUNT(tp_id) FROM tp WHERE tp_location_id=l.location_id) AS total_tp"))
                    ->LeftJoin('res AS r', 'r.res_id', '=', 'l.res_id')
                    ->LeftJoin('contractor AS c', 'c.contractor_id', '=', 'l.contractor_id')
                    ->orderBy('r.pes')
                    ->orderBy('r.res_name')
                    ->orderBy('l.location_id');

        if($request->get('search'))
        {
        	$location = $sql
        				->where("r.pes", "LIKE", "%{$request->get('search')}%")
        				->orWhere("r.res_name", "LIKE", "%{$request->get('search')}%")
        				->orWhere("l.location_name", "LIKE", "%{$request->get('search')}%")
        				->paginate(10);
        } else {
        	$location = $sql
        				->paginate(10);
        }

        $status = DB::table('status AS s')
        		  ->select('s.status_id', 's.status_name')
        		  ->get();

        $location['status'] = $status;
        return response($location);
    }

    # workflow update status
    public function update(Request $request, $id)
    {
		$location = Location::find($id);
		$location->update([$request->type => $request->$id]);
        return response(['status' => 'success']);
    }

}