<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DataTables;
use App\Models\SkillNotFound;
use App\Models\Skill;
use App\Models\ScrapedJobsCategory;
use App\Models\TechSkill;
use App\Models\DeveloperSkill;
use DB;

class DeveloperSkillController extends Controller
{
    public function index(Request $request) {
        if ($request->ajax()) {
            $data = DeveloperSkill::select( DB::raw('count(developer_id) as total_count'),DB::raw('MIN(id) as id'), 'skill_name')->where("category_id", 12)->groupBy("skill_name");
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btn = '';
                        $btn = '<button class="edit btn btn-primary btn-sm edit-the-skill mr-2"><i class="fa fas fa-edit"></i></button>';
                        $btn .= " <a href='javascript:void(0)'  class='edit btn btn-primary btn-sm mr-2 deleteSkill' data-id='".$row->id."'><i class='fa fas fa-trash'></i></a>";
                       
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        $skills = Skill::select(DB::raw("MIN(id) as id"), "display_name")->groupBy('display_name')->orderBy("display_name", "asc")->get();
        $categories = ScrapedJobsCategory::select("id", "name")->get();
        return view('admin.developer-skill.index', compact('skills', 'categories'));
    }
    public function move(Request $request) {
        $request->validate([
            'selected_skill' => 'required',
            'skill' => 'required',
        ]);
        foreach(explode(",", $request->selected_skill) as $skillId) {
            if($skillId != '') {
                $developerMissingSkill = DeveloperSkill::where("id", $skillId)->first();
                if($request->skill != "AddNewSkill") {
                    $skill = Skill::where("id", $request->skill)->first();
                    $skill = Skill::create([
                        "name" => $developerMissingSkill->skill_name,
                        "display_name" => $skill->display_name,
                        "category_id" => $skill->category_id,
                        "icon" => $skill->icon,
                    ]);
                } else {
                    $skill = Skill::create([
                        "name" => $developerMissingSkill->skill_name,
                        "display_name" => $request->new_skill,
                        "category_id" => $request->category,
                        "icon" => $request->new_skill_icon
                    ]);
                }
               
                $skillNotFound = SkillNotFound::where("name", $developerMissingSkill->skill_name)->first();
                $techskills = TechSkill::select("id","category_id","skill_name","job_id")->whereIn("job_id", explode(";", $skillNotFound->job_id))->where("skill_name", $skillNotFound->name)->get();
                foreach ($techskills as &$techskill) {
                    $techskill->category_id = $skill->category_id;
                    $techskill->skill_name = $skill->display_name;
                    $techskill->save();
                }
                $skillNotFound->delete();

                $developerskills = DeveloperSkill::select("id","category_id","skill_name")->where("skill_name", $developerMissingSkill->skill_name)->get();
                foreach ($developerskills as &$developerskill) {
                    $developerskill->category_id = $skill->category_id;
                    $developerskill->skill_name = $skill->display_name;
                    $developerskill->save();
                }
                
            }
        }


    }
    public function delete(DeveloperSkill $developerSkill) {
        DeveloperSkill::where("skill_name", $developerSkill->skill_name)->delete();
        return response()->json(['message' => 'Developer skill deleted successfully']);
    }

}
