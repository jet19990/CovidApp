<?php

namespace App\Http\Controllers;

use App\Vaccination;
use Auth;
use DB;
use App\User;
use App\Threshold;
use Illuminate\Http\Request;
use App\Http\Resources\VolunteersCollection;

class VaccinationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $volunteers = User::all();
        return VolunteersCollection::collection($volunteers);
    }

    public function allVaccines(){


        $positiveCases = Vaccination::where('test', true)->get()->count();
        $threshhold = Threshold::first()->threshhold;

         if($positiveCases < $threshhold){
             return response()->json([
                "error_message" => "Phase 3 Trial in progress, please wait."
             ]);
         }

        $vaccineA = Vaccination::where('vaccine','A')->get()->count();
        $vaccineB =  Vaccination::where('vaccine', 'B')->get()->count();

        $positiveA = Vaccination::where([['vaccine','A'],['test', true]])->get()->count();
        $positiveB = Vaccination::where([['vaccine','B'],['test', true]])->get()->count();

        $efficacy = 0;

        if($positiveB != 0){
            $efficacy = ($positiveB - $positiveA) / $positiveB ;
        }
       
        return response()->json([
              [
                "name" => "SLCV2020",
                "type" => "vaccine",
                "vaccineGroup" => "A",
                "efficacy_rate" => $efficacy,
                "result" => [
                "volunteer" => $vaccineA,
                "confirm_positive" => $positiveA
                ]
                ],

                [
                    "name" => "Unknown",
                    "type" => "placebo",
                    "vaccineGroup" => "B",
                    "result" => [
                    "volunteer" => $vaccineB,
                    "confirm_positive" => $positiveB
                    ]
                ]

           ]);
    }


    public function search(Request $request){
        $this->validate($request, [
            'dose' => 'required|in:0.5,1',
            'group' => 'required|in:A,B'
        ]);

        $positiveCases = Vaccination::where('test', true)->get()->count();
        $threshhold = Threshold::first()->threshhold;

         if($positiveCases < $threshhold){
             return response()->json([
                "error_message" => "Phase 3 Trial in progress, please wait."
             ]);
         }


        $vaccine = $request->query('group');
        $dose = $request->query('dose');

        $searchResult = Vaccination::where([['vaccine', $vaccine],['dose',$dose]])->get()->count();
       
        $searchAPositive = Vaccination::where([['vaccine', 'A'],['dose',$dose],['test', true]])->get()->count();
        $searchBPositive = Vaccination::where([['vaccine', 'B'],['dose',$dose],['test', true]])->get()->count();
        
        // Calculate eficacy_rate
        $searchPositive = 0;
        if($vaccine == 'A'){
            $searchPositive = $searchAPositive;
            $efficacy_rate = ($searchBPositive - $searchAPositive) / $searchBPositive;
        }else{
            $searchPositive = $searchBPositive;

            $efficacy_rate = ($searchAPositive - $searchBPositive)/$searchAPositive;
        }




        return response()->json([
            "name"=> $vaccine == 'A' ? "SLCV2020" : 'Unknown',
            "type"=> $vaccine == 'A' ?"vaccine" : 'placebo',
            "vaccineGroup"=> $vaccine,
            "dose"=> $dose,
            "efficacy_rate"=> $efficacy_rate,
            "result"=>[
            "volunteer"=>$searchResult,
            "confirm_positive"=> $searchPositive
            ]
        ]);
    }


    public function checkUserVaccine(){
        $userId = auth('api')->user()->id;
        $userVaccine = Vaccination::where('uid', $userId)->first();
        if($userVaccine){
            return response()->json([
                'status' => true,
                'testedPositive' => $userVaccine->test,
                'message' => 'User has posted vaccine'
            ]);
        }

        return response()->json([
            'status' => false,
            'testedPositive' => false,
            'message' => 'User has not posted vaccine'
        ]);
    }

    // These are vaccines taken

    public function vaccinesTaken() {
        $vaccinations = DB::table('vaccinations')
        ->select('vaccine', DB::raw('count(*) as total'))
        ->groupBy('vaccine')->get();

        return $vaccinations;

    }

    public function vaccinesDoseTaken() {
        $vaccinations = DB::table('vaccinations')
        ->select('vaccine', 'dose', DB::raw('count(*) as total'))
        ->groupBy('vaccinations.vaccine', 'vaccinations.dose')->get();

        return $vaccinations;

    }


    public function reportPositive(Request $request){
        $userId = auth('api')->user()->id;
        $vaccination = Vaccination::where('uid', $userId)->first();

        $vaccination->test = true;

        if($vaccination->save()){
            return response()->json([
                'status' => true,
                'message' => 'Report was submitted successfully'
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'Oops, please try again later'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //validation

        $this->validate($request, [
            'dose' => 'required',
            'vaccine' => 'required | string'
        ]);

        try {
            $vaccination = new Vaccination;

            $vaccination->dose = $request->dose;
            $vaccination->vaccine = $request->vaccine;
            $vaccination->uid = Auth::user()->id;
            if($vaccination->save()){
                return response()->json([
                    'status' => true,
                    'message' => 'vaccination was submitted successfully !!!'
                ]);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'An error occurred please ty again later.'
            ]);
        }
    }


    public function reportedResults () {
        $resultsClassifications = $users = DB::table('vaccinations')
                ->join('users', 'vaccinations.uid', '=', 'users.id')
                ->select('vaccinations.*', 'users.gender')
                ->select('test','gender', DB::raw('count(*) as total'))
                ->groupBy('test','gender')
                ->get();
        
        return $resultsClassifications;

    }

    public function positiveCasesPerDosage(){
        $positiveCases = DB::table('vaccinations')
        ->where('test', true)
        ->select('vaccine', 'dose', DB::raw('count(*) as total'))
        ->groupBy('vaccine', 'dose')
        ->get();

        return $positiveCases;
    }


    public function agePositiveCases(){
        $ranges = [
            '18-24' => 25,
            '25-30' => 31,
            '31-35' => 36,
            '36-40' => 41,
            '41-45' => 46,
            '46-50' => 51,
            '51-55' => 56,
            '56-60' => 61,
            '61-65' => 66,
            '66-70' => 71,
            '71+' => 100
        ];

        
        $output = Vaccination::where('test', true)
            ->get()
            ->map(function ($test) use ($ranges) {
                $age = User::find($test->uid)->age;
                foreach($ranges as $key => $breakpoint)
                {
                    if ($breakpoint >= $age)
                    {
                        $test->range = $key;
                        break;
                    }
                }
        
                return $test;
            })
            ->mapToGroups(function ($test, $key) {
                return [$test->range => $test];
            })
            ->map(function ($group) {
                return count($group);
            })
            ->sortKeys();

        return $output;
    }

    
    public function dashboardReport()
    {
        // Total volunteers

        $volunteers = User::all()->count();

        // Total positive cases

        $positiveCases = Vaccination::where('test', true)->get()->count();

         // Total negative cases

        $negativeCases = $volunteers - $positiveCases;

         // percentage positive

         $percentagePositive = ($positiveCases / $volunteers) * 100;


         return response()->json([
             'volunteers' => $volunteers,
             'positive_cases' => $positiveCases,
             'negative_cases' => $negativeCases,
             'percentage_positive' => $percentagePositive
         ]);


    }


}
