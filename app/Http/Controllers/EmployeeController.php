<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Position;
use \Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // public function index()
    // {
    //     $pageTitle = 'Employee List';

    //     // RAW SQL QUERY
    //     $employees = DB::select('
    //         select *, employees.id as employee_id, positions.name as position_name
    //         from employees
    //         left join positions on employees.position_id = positions.id
    //     ');

    //      //QUERY BUILDER
    //      $employees = DB::table('employees')
    //      ->select('*', 'employees.id as employee_id', 'positions.name as position_name')
    //      ->leftJoin("positions", "employees.position_id", '=', 'positions.id')
    //      ->get();

    //     return view('employee.index', [
    //         'pageTitle' => $pageTitle,
    //         'employees' => $employees
    //     ]);
    // }

    public function index()
    {
        $pageTitle = 'Employee List';

        // ELOQUENT
        $employees = Employee::all();

        return view('employee.index', [
            'pageTitle' => $pageTitle,
            'employees' => $employees
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    // public function create()
    // {
    //     $pageTitle = 'Create Employee';
    //     // RAW SQL Query
    //     $positions = DB::select('select * from positions');

    //     // QUERY BUILDER
    //     $positions = DB::table('positions')->get();

    //     return view('employee.create', compact('pageTitle', 'positions'));
    // }

    public function create()
    {
        $pageTitle = 'Create Employee';

        // ELOQUENT
        $positions = Position::all();

        return view('employee.create', compact('pageTitle', 'positions'));
    }


    /**
     * Store a newly created resource in storage.
     */
    // public function store(Request $request)
    // {
    //     $messages = [
    //         'required' => ':Attribute harus diisi.',
    //         'email' => 'Isi :attribute dengan format yang benar',
    //         'numeric' => 'Isi :attribute dengan angka'
    //     ];

    //     $validator = Validator::make($request->all(), [
    //         'firstName' => 'required',
    //         'lastName' => 'required',
    //         'email' => 'required|email',
    //         'age' => 'required|numeric',
    //     ], $messages);

    //     if ($validator->fails()) {
    //         return redirect()->back()->withErrors($validator)->withInput();
    //     }

    //     // INSERT QUERY
    //     DB::table('employees')->insert([
    //         'firstname' => $request->firstName,
    //         'lastname' => $request->lastName,
    //         'email' => $request->email,
    //         'age' => $request->age,
    //         'position_id' => $request->position,
    //     ]);

    //     return redirect()->route('employees.index');
    // }

    public function store(Request $request)
    {
        $messages = [
            'required' => ':Attribute harus diisi.',
            'email' => 'Isi :attribute dengan format yang benar',
            'numeric' => 'Isi :attribute dengan angka'
        ];

        $validator = Validator::make($request->all(), [
            'firstName' => 'required',
            'lastName' => 'required',
            'email' => 'required|email',
            'age' => 'required|numeric',
        ], $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // ELOQUENT
        $employee = New Employee;
        $employee->firstname = $request->firstName;
        $employee->lastname = $request->lastName;
        $employee->email = $request->email;
        $employee->age = $request->age;
        $employee->position_id = $request->position;
        $employee->save();

        return redirect()->route('employees.index');
    }

    /**
     * Display the specified resource.
     */
    // public function show(string $id)
    // {
    //     $pageTitle = 'Employee Detail';

    //     // RAW SQL QUERY
    //     $employee = collect(DB::select('
    //         select *, employees.id as employee_id, positions.name as position_name
    //         from employees
    //         left join positions on employees.position_id = positions.id
    //         where employees.id = ?', [$id]))->first();

    //     //QUERY BUILDER

    //     $employee = DB::table('employees')
    //             ->select('*', 'employees.id as employees_id', 'positions.name as position_name')
    //             ->leftJoin("positions", "employees.position_id", '=', 'positions.id')
    //             ->where('employees.id', '=', $id)
    //             ->first();

    //     return view('employee.show', compact('pageTitle', 'employee'));
    // }

    public function show(string $id)
    {
        $pageTitle = 'Employee Detail';

        // ELOQUENT
        $employee = Employee::find($id);

        return view('employee.show', compact('pageTitle', 'employee'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    // public function edit(string $id)
    // {
    //     // RAW SQL Query
    //     $pageTitle = 'Employee Edit';
    //     $employee = DB::table('employees')
    //                 ->select('*', 'employees.id as employee_id', 'positions.name as position_name')
    //                 ->leftJoin('positions', 'employees.position_id', '=', 'positions.id')
    //                 ->where('employees.id', '=', $id)
    //                 ->first();
    //     $positions = DB::table('positions')
    //                 ->select('*')
    //                 ->get();
    //     return view('employee.edit', compact('pageTitle', 'employee', 'positions'));
    // }

    public function edit(string $id)
    {
        $pageTitle = 'Edit Employee';

        // ELOQUENT
        $positions = Position::all();
        $employee = Employee::find($id);

        return view('employee.edit', compact('pageTitle', 'positions', 'employee'));
    }

    /**
     * Update the specified resource in storage.
     */
    // public function update(Request $request, string $id)
    // {
    //     // Raw SQL Query
    //     DB::table('employees')
    //     ->where('id', $id)
    //     ->update([
    //         'firstname' => $request->input('firstName'),
    //         'lastname' => $request->input('lastName'),
    //         'email' => $request->input('email'),
    //         'age' => $request->input('age'),
    //         'position_id' => $request->input('position')
    //     ]);
    //     return redirect()->route('employees.index');

    //     return view('employee.index', compact('pageTitle', 'employee'));
    // }

    public function update(Request $request, string $id)
    {
        $messages = [
            'required' => ':Attribute harus diisi.',
            'email' => 'Isi :attribute dengan format yang benar',
            'numeric' => 'Isi :attribute dengan angka'
        ];

        $validator = Validator::make($request->all(), [
            'firstName' => 'required',
            'lastName' => 'required',
            'email' => 'required|email',
            'age' => 'required|numeric',
        ], $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // ELOQUENT
        $employee = Employee::find($id);
        $employee->firstname = $request->firstName;
        $employee->lastname = $request->lastName;
        $employee->email = $request->email;
        $employee->age = $request->age;
        $employee->position_id = $request->position;
        $employee->save();

        return redirect()->route('employees.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    // public function destroy(string $id)
    // {
    //     // QUERY BUILDER
    //     DB::table('employees')
    //         ->where('id', $id)
    //         ->delete();

    //     return redirect()->route('employees.index');
    // }

    public function destroy(string $id)
    {
        // ELOQUENT
        Employee::find($id)->delete();

        return redirect()->route('employees.index');
    }
}
